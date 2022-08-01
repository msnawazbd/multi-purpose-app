<?php

namespace App\Http\Livewire\Admin\Messages;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\ContactMessage;

class ListContactMessages extends AdminComponent
{
    public $full_name, $email, $mobile, $subject, $message, $status, $created_at, $updated_at;

    public $faq;
    public $faqId;
    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['searchKeywords' => ['except' => '']];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSearchKeywords()
    {
        $this->resetPage();
    }

    public function show($faqId)
    {
        try {
            $faq = ContactMessage::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                ])
                ->where('id', $faqId)
                ->first();

            $this->title = $faq->title;
            $this->status = $faq->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED';
            $this->description = $faq->description;
            $this->created_at = $faq->created_at ? $faq->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $faq->updated_at ? $faq->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $faq->createdBy->name;
            $this->updated_by = $faq->updatedBy ? $faq->updatedBy->name : 'N/A';

            $this->dispatchBrowserEvent('show-view-modal');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            return redirect()->route('admin.tasks');
        }
    }

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function changeStatus($faqId)
    {
        try {
            $faq = ContactMessage::query()->findOrFail($faqId);
            $faq->status = $faq->status == 1 ? 0 : 1;
            $faq->save();
            $this->dispatchBrowserEvent('success', ['message' => 'FAQ status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($faqId)
    {
        $this->faqId = $faqId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = ContactMessage::query()->findOrFail($this->faqId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'FAQ deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $contact_messages = ContactMessage::query()
            ->where(function ($query) {
                $query->where('full_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('email', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('mobile', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('subject', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('message', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['*'])
            ->paginate(5);

        return view('livewire.admin.messages.list-contact-messages', [
            'contact_messages' => $contact_messages
        ]);
    }
}

<?php

namespace App\Http\Livewire\Admin\Messages;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\ContactMessage;

class ListContactMessages extends AdminComponent
{
    public $full_name, $email, $mobile, $subject, $contact_message, $status, $created_at, $updated_at;

    public $messageId;
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

    public function show($contactMessageId)
    {
        try {
            $contact_message = ContactMessage::query()
                ->where('id', $contactMessageId)
                ->first();

            $this->full_name = $contact_message->full_name;
            $this->email = $contact_message->email;
            $this->mobile = $contact_message->mobile;
            $this->subject = $contact_message->subject;
            $this->contact_message = $contact_message->message;
            $this->status = $contact_message->status == 1 ? 'ANSWERED' : 'PENDING';
            $this->created_at = $contact_message->created_at ? $contact_message->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $contact_message->updated_at ? $contact_message->updated_at->toFormattedDate() : 'N/A';

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
            $this->dispatchBrowserEvent('success', ['message' => 'Message status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($messageId)
    {
        $this->messageId = $messageId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = ContactMessage::query()->findOrFail($this->messageId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Message deleted successfully.']);
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

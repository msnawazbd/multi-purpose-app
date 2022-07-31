<?php

namespace App\Http\Livewire\Admin\Faqs;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Faq;
use Illuminate\Support\Facades\Validator;

class ListFaqs extends AdminComponent
{
    public $title, $status, $description, $created_at, $updated_at, $created_by, $updated_by;

    public $state = [];
    public $faq;
    public $faqId;
    public $showEditModal = false;
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

    public function create()
    {
        $this->reset();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function store()
    {
        Validator::make($this->state, [
            'title' => 'required|string|max:250|min:4',
            'status' => 'required|numeric',
            'description' => 'required|string',
        ])->validate();

        try {
            Faq::query()
                ->create([
                    'title' => $this->state['title'],
                    'status' => $this->state['status'],
                    'description' => $this->state['description'],
                    'created_by' => auth()->user()->id
                ]);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'FAQ created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(Faq $faq)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->faq = $faq;
        $this->state = $faq->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'title' => 'required|string|max:250|min:4',
            'status' => 'required|numeric',
            'description' => 'required|string',
        ])->validate();

        $validateData['updated_by'] = auth()->user()->id;

        try {
            $this->faq->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'FAQ updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($faqId)
    {
        try {
            $faq = Faq::query()
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
            $faq = Faq::query()->findOrFail($faqId);
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
            $data = Faq::query()->findOrFail($this->faqId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'FAQ deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $faqs = Faq::query()
            ->with([
                'createdBy:id,name'
            ])
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('description', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['id', 'title', 'status', 'created_at', 'created_by'])
            ->paginate(5);

        return view('livewire.admin.faqs.list-faqs', [
            'faqs' => $faqs
        ]);
    }
}

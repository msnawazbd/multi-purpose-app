<?php

namespace App\Http\Livewire\Admin\Blog\Categories;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ListBlogCategories extends AdminComponent
{
    public $name, $status, $created_at, $updated_at, $created_by, $updated_by;

    public $state = [];
    public $category;
    public $categoryId;
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
        $validateData = Validator::make($this->state, [
            'name' => 'required|string|max:100|min:4',
            'status' => 'required|numeric',
        ])->validate();

        $validateData['created_by'] = Auth::user()->id;

        try {
            BlogCategory::query()
                ->create($validateData);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Blog category created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(BlogCategory $category)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->category = $category;
        $this->state = $category->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'name' => 'required|string|max:100|min:4',
            'status' => 'required|numeric',
        ])->validate();

        $validateData['updated_by'] = auth()->user()->id;

        try {
            $this->category->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Blog category updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($categoryId)
    {
        try {
            $category = BlogCategory::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                ])
                ->where('id', $categoryId)
                ->first();

            $this->name = $category->name;
            $this->status = $category->status;
            $this->created_at = $category->created_at ? $category->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $category->updated_at ? $category->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $category->createdBy->name;
            $this->updated_by = $category->updatedBy ? $category->updatedBy->name : 'N/A';

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

    public function changeStatus($categoryId)
    {
        try {
            $category = BlogCategory::query()->findOrFail($categoryId);
            $category->status = $category->status == 1 ? 0 : 1;
            $category->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Blog category status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = BlogCategory::query()->findOrFail($this->categoryId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Blog category deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $categories = BlogCategory::query()
            ->with([
                'createdBy:id,name'
            ])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('status', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['id', 'name', 'status', 'created_at', 'created_by'])
            ->paginate(5);

        return view('livewire.admin.blog.categories.list-blog-categories', [
            'categories' => $categories
        ]);
    }
}

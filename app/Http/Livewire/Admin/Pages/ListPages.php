<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class ListPages extends AdminComponent
{
    public $page_name, $page_title, $page_slug, $page_details, $meta_title, $meta_keywords, $meta_description, $status, $created_at, $updated_at, $created_by, $updated_by;

    public $pageId;
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

    public function show($pageId)
    {
        try {
            $page = Page::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                ])
                ->where('id', $pageId)
                ->first();

            $this->page_name = $page->page_name;
            $this->page_title = $page->page_title;
            $this->page_slug = $page->page_slug;
            $this->page_details = $page->page_details;
            $this->meta_title = $page->meta_title;
            $this->meta_keywords = $page->meta_keywords;
            $this->meta_description = $page->meta_description;
            $this->status = $page->status;
            $this->created_at = $page->created_at ? $page->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $page->updated_at ? $page->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $page->createdBy->name;
            $this->updated_by = $page->updatedBy ? $page->updatedBy->name : 'N/A';

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

    public function changeStatus($pageId)
    {
        try {
            $page = Page::query()->findOrFail($pageId);
            $page->status = $page->status == 1 ? 0 : 1;
            $page->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Page status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($pageId)
    {
        $this->pageId = $pageId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Page::query()->findOrFail($this->pageId);
            Storage::disk('blog_featured_image')->delete($data->featured_image);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Page deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $pages = Page::query()
            ->with([
                'createdBy:id,name'
            ])
            ->where(function ($query) {
                $query->where('page_title', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('page_details', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('page_name', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['id', 'page_name', 'page_title', 'status', 'created_at', 'created_by'])
            ->paginate(5);

        return view('livewire.admin.pages.list-pages', [
            'pages' => $pages
        ]);
    }

}

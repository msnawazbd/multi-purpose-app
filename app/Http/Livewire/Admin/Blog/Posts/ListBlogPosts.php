<?php

namespace App\Http\Livewire\Admin\Blog\Posts;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Storage;

class ListBlogPosts extends AdminComponent
{
    public $post_category, $post_title, $post_slug, $post_details, $featured_image_url, $view_count, $meta_title, $meta_keywords, $meta_description, $status, $created_at, $updated_at, $created_by, $updated_by;

    public $postId;
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

    public function show($postId)
    {
        try {
            $post = BlogPost::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                    'blogCategory:id,name',
                ])
                ->where('id', $postId)
                ->first();

            $this->post_category = $post->blogCategory->name;
            $this->post_title = $post->post_title;
            $this->post_slug = $post->post_slug;
            $this->post_details = $post->post_details;
            $this->featured_image_url = $post->featured_image_url;
            $this->view_count = $post->view_count;
            $this->meta_title = $post->meta_title;
            $this->meta_keywords = $post->meta_keywords;
            $this->meta_description = $post->meta_description;
            $this->status = $post->status;
            $this->created_at = $post->created_at ? $post->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $post->updated_at ? $post->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $post->createdBy->name;
            $this->updated_by = $post->updatedBy ? $post->updatedBy->name : 'N/A';

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

    public function changeStatus($postId)
    {
        try {
            $post = BlogPost::query()->findOrFail($postId);
            $post->status = $post->status == 1 ? 0 : 1;
            $post->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Post status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($postId)
    {
        $this->postId = $postId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = BlogPost::query()->findOrFail($this->postId);
            Storage::disk('blog_featured_image')->delete($data->featured_image);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Post deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $posts = BlogPost::query()
            ->join('blog_categories', function ($join) {
                $join->on('blog_posts.blog_category_id', '=', 'blog_categories.id');
            })
            ->with([
                'createdBy:id,name',
                'blogCategory:id,name',
            ])
            ->where(function ($query) {
                $query->where('blog_posts.post_title', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('blog_posts.post_details', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('blog_categories.name', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['blog_posts.id', 'blog_posts.blog_category_id', 'blog_posts.post_title', 'blog_posts.featured_image', 'blog_posts.status', 'blog_posts.created_at', 'blog_posts.created_by'])
            ->paginate(5);

        return view('livewire.admin.blog.posts.list-blog-posts', [
            'posts' => $posts
        ]);
    }

}

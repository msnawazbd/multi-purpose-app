<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BlogPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image && Storage::disk('blog_featured_image')->exists($this->featured_image)) {
            return Storage::disk('blog_featured_image')->url($this->featured_image);
        }

        return 'https://ui-avatars.com/api/?name=' . $this->post_title;
    }
}

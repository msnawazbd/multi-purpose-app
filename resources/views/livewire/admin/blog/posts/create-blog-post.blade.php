<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Posts</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blog.posts') }}">Blog</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blog.posts') }}">Posts</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-12 -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('admin.blog.posts') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-list"></i>
                                    &nbsp; Manage Posts
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form wire:submit.prevent="create" autocomplete="off">
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="post_title">Post Title <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="state.post_title"
                                                   class="form-control @error('post_title') is-invalid @enderror"
                                                   id="post_title">
                                            @error('post_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="blog_category_id">Post Category <span class="text-danger">*</span></label>
                                            <select class="form-control @error('blog_category_id') is-invalid @enderror"
                                                    wire:model.defer="state.blog_category_id" id="blog_category_id">
                                                <option value="">Select One</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('blog_category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select id="status" wire:model.defer="state.status"
                                                    class="form-control @error('status') is-invalid @enderror">
                                                <option value="" selected>Select one</option>
                                                <option value="1">Published</option>
                                                <option value="0">Unpublished</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div wire:ignore class="form-group">
                                            <label for="details">Post Details <span class="text-danger">*</span></label>
                                            <textarea id="details" data-details="@this"
                                                      class="form-control @error('details') is-invalid @enderror"></textarea>
                                            @error('details')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title </label>
                                            <input type="text" wire:model.defer="state.meta_title"
                                                   class="form-control @error('meta_title') is-invalid @enderror"
                                                   id="meta_title">
                                            @error('meta_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" wire:model.defer="state.meta_keywords"
                                                   class="form-control @error('meta_keywords') is-invalid @enderror"
                                                   id="meta_keywords">
                                            @error('meta_keywords')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea wire:model.defer="state.meta_description"
                                                      class="form-control @error('meta_description') is-invalid @enderror"
                                                      id="meta_description" rows="5"></textarea>
                                            @error('meta_description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="customFile">Profile Photo</label>
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <div x-data="{ isUploading : false, progress: 5 }"
                                                         x-on:livewire-upload-start="isUploading = true"
                                                         x-on:livewire-upload-finish="isUploading = false; progress = 5"
                                                         x-on:livewire-upload-error="isUploading = false"
                                                         x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                        <input wire:model="featured_image" type="file" class="custom-file-input"
                                                               id="customFile">
                                                        <div x-show.transition="isUploading"
                                                             class="progress progress-sm mt-2 rounded">
                                                            <div class="progress-bar bg-primary progress-bar-striped"
                                                                 role="progressbar"
                                                                 aria-valuenow="40" aria-valuemin="0"
                                                                 aria-valuemax="100"
                                                                 x-bind:style="`width: ${progress}%`">
                                                                <span class="sr-only">40% Complete (success)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="custom-file-label" for="customFile">
                                                        @if($featured_image)
                                                            {{ $featured_image->getClientOriginalName() }}
                                                        @else
                                                            Choose file
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                            @if($featured_image)
                                                <img src="{{ $featured_image->temporaryUrl() }}" class="img d-block mt-2 w-100"
                                                     alt="">
                                            @else
                                                <img src="{{ $state['featured_image_url'] ?? '' }}"
                                                     class="img d-block mt-2 w-100" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <x-inputs.button id="create-appointment" class="text-white">Create Post</x-inputs.button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@push('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 150px;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#details'));
        $('form').submit(function () {
            @this.
            set('state.post_details', $('#details').val());
        })
    </script>
@endpush


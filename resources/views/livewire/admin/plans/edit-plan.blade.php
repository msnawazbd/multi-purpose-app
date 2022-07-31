<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Plans</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.plans') }}">Plans</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                                <a href="{{ route('admin.plans') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-list"></i>
                                    &nbsp; Manage Plan
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form wire:submit.prevent="update" autocomplete="off">
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="title">Plan Title <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="state.title"
                                                   class="form-control @error('title') is-invalid @enderror"
                                                   id="title">
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="original_price">Original Price <span class="text-danger">*</span></label>
                                            <input type="number" step="any" wire:model.defer="state.original_price"
                                                   class="form-control @error('original_price') is-invalid @enderror"
                                                   id="original_price">
                                            @error('original_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="discounted_price">Discounted Price <span class="text-danger">*</span></label>
                                            <input type="number" step="any" wire:model.defer="state.discounted_price"
                                                   class="form-control @error('discounted_price') is-invalid @enderror"
                                                   id="discounted_price">
                                            @error('discounted_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="validity">Validity <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.defer="state.validity"
                                                   class="form-control @error('validity') is-invalid @enderror"
                                                   id="validity" value="null">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('validity')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="listings">Listings <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.defer="state.listings"
                                                   class="form-control @error('listings') is-invalid @enderror" id="listings">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('listings')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="categories">Categories <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.defer="state.categories"
                                                   class="form-control @error('categories') is-invalid @enderror"
                                                   id="categories">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('categories')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="photos">Photos</label>
                                            <input type="number" wire:model.defer="state.photos"
                                                   class="form-control @error('photos') is-invalid @enderror" id="photos">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('photos')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="videos">Videos <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.defer="state.videos"
                                                   class="form-control @error('videos') is-invalid @enderror" id="videos">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('videos')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tags">Tags <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.defer="state.tags"
                                                   class="form-control @error('tags') is-invalid @enderror"
                                                   id="tags">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('tags')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="amenities">Amenities <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.defer="state.amenities"
                                                   class="form-control @error('amenities') is-invalid @enderror"
                                                   id="amenities">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('amenities')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="products">Products</label>
                                            <input type="number" wire:model.defer="state.products"
                                                   class="form-control @error('products') is-invalid @enderror"
                                                   id="products">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('products')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="services">Services <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.defer="state.services"
                                                   class="form-control @error('services') is-invalid @enderror"
                                                   id="services">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('services')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="articles">Articles <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.defer="state.articles"
                                                   class="form-control @error('articles') is-invalid @enderror"
                                                   id="articles">
                                            <small class="form-text text-muted">Set limit ( -1 ) for infinity.</small>
                                            @error('articles')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group clearfix">
                                            <label for="featured_listings">Featured Listings <span class="text-danger">*</span></label>
                                            <div class="form-control @error('featured_listings') is-invalid @enderror">
                                                <div class="icheck-primary d-inline mr-3">
                                                    <input type="radio" wire:model.defer="state.featured_listings" id="featured_listings_1" name="featured_listings" value="1">
                                                    <label for="featured_listings_1">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" wire:model.defer="state.featured_listings" id="featured_listings_2" name="featured_listings" value="0">
                                                    <label for="featured_listings_2">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                            @error('featured_listings')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group clearfix">
                                            <label for="contact_form">Contact Form <span class="text-danger">*</span></label>
                                            <div class="form-control @error('contact_form') is-invalid @enderror">
                                                <div class="icheck-primary d-inline mr-3">
                                                    <input type="radio" wire:model.defer="state.contact_form" id="contact_form_1" name="contact_form" value="1">
                                                    <label for="contact_form_1">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" wire:model.defer="state.contact_form" id="contact_form_2" name="contact_form" value="0">
                                                    <label for="contact_form_2">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                            @error('contact_form')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group clearfix">
                                            <label for="social_items">Social Items<span class="text-danger">*</span></label>
                                            <div class="form-control @error('social_items') is-invalid @enderror">
                                                <div class="icheck-primary d-inline mr-3">
                                                    <input type="radio" wire:model.defer="state.social_items" id="social_items_1" name="social_items" value="1">
                                                    <label for="social_items_1">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" wire:model.defer="state.social_items" id="social_items_2" name="social_items" value="0">
                                                    <label for="social_items_2">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                            @error('social_items')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <x-inputs.button id="create-plan" class="text-white">Update Plan</x-inputs.button>
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
@endpush

@push('js')
@endpush

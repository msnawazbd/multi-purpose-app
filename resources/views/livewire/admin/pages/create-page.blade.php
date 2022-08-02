<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pages') }}">Pages</a></li>
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
                                <a href="{{ route('admin.pages') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-list"></i>
                                    &nbsp; Manage Pages
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form wire:submit.prevent="create" autocomplete="off">
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="page_name">Page Name <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="state.page_name"
                                                   class="form-control @error('page_name') is-invalid @enderror"
                                                   id="page_name">
                                            @error('page_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="page_title">Page Title <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="state.page_title"
                                                   class="form-control @error('page_title') is-invalid @enderror"
                                                   id="page_title">
                                            @error('page_title')
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
                                            <label for="details">Page Details <span class="text-danger">*</span></label>
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
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <x-inputs.button id="create-appointment" class="text-white">Create Page</x-inputs.button>
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
            set('state.page_details', $('#details').val());
        })
    </script>
@endpush


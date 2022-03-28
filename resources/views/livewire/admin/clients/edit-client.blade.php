<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Clients</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.clients') }}">Clients</a></li>
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
                                <a href="{{ route('admin.clients') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-list"></i>
                                    &nbsp; Manage Client
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form wire:submit.prevent="update" autocomplete="off">
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="first_name">First Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="first_name"
                                                   class="form-control @error('first_name') is-invalid @enderror"
                                                   id="first_name">
                                            @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="last_name"
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   id="last_name">
                                            @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="mobile"
                                                   class="form-control @error('mobile') is-invalid @enderror"
                                                   id="mobile">
                                            @error('mobile')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="alternate_no">Alternate No.</label>
                                            <input type="text" wire:model.defer="alternate_no"
                                                   class="form-control @error('alternate_no') is-invalid @enderror"
                                                   id="alternate_no" value="null">
                                            @error('alternate_no')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group clearfix">
                                            <label for="gender">Gender <span class="text-danger">*</span></label>
                                            <div class="form-control @error('gender') is-invalid @enderror">
                                                <div class="icheck-primary d-inline mr-3">
                                                    <input type="radio" wire:model.defer="gender" id="radioPrimary1" name="gender" value="male" checked>
                                                    <label for="radioPrimary1">
                                                        Male
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" wire:model.defer="gender" id="radioPrimary2" name="gender" value="female">
                                                    <label for="radioPrimary2">
                                                        Female
                                                    </label>
                                                </div>
                                            </div>
                                            @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Email ID</label>
                                            <input type="text" wire:model.defer="email"
                                                   class="form-control @error('email') is-invalid @enderror" id="email">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="address"
                                                   class="form-control @error('address') is-invalid @enderror"
                                                   id="address">
                                            @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="country_id">Country <span class="text-danger">*</span></label>
                                            <select class="form-control @error('country_id') is-invalid @enderror"
                                                    wire:model.defer="country_id" id="country_id">
                                                <option value="">Select One</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" wire:model.defer="state"
                                                   class="form-control @error('state') is-invalid @enderror" id="state">
                                            @error('state')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="city">City <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="city"
                                                   class="form-control @error('city') is-invalid @enderror" id="city">
                                            @error('city')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="zip_code">Zip Code</label>
                                            <input type="text" wire:model.defer="zip_code"
                                                   class="form-control @error('zip_code') is-invalid @enderror"
                                                   id="zip_code">
                                            @error('zip_code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="reference_name">Reference Name</label>
                                            <input type="text" wire:model.defer="reference_name"
                                                   class="form-control @error('reference_name') is-invalid @enderror"
                                                   id="reference_name">
                                            @error('reference_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="reference_mobile">Reference Mobile</label>
                                            <input type="text" wire:model.defer="reference_mobile"
                                                   class="form-control @error('reference_mobile') is-invalid @enderror"
                                                   id="reference_mobile">
                                            @error('reference_mobile')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select id="status" wire:model.defer="status"
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
                                    <div class="col-md-12">
                                        <div wire:ignore class="form-group">
                                            <label for="details">Details</label>
                                            <textarea id="details" data-details="@this" wire:model.defer="details"
                                                      class="form-control @error('details') is-invalid @enderror">{!! $details !!}</textarea>
                                            @error('details')
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
                                <x-inputs.button id="create-client" class="text-white">Update Client</x-inputs.button>
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
            min-height: 120px;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#details'));
        $('form').submit(function () {
            @this.
            set('details', $('#details').val());
        })
    </script>
@endpush


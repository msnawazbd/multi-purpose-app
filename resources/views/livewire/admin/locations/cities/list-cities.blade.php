<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cities</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Locations</a></li>
                        <li class="breadcrumb-item active">Cities</li>
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
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-sm" wire:click="create"><i
                                        class="fas fa-plus"></i>
                                    &nbsp; Add New City
                                </button>
                                <x-search-input wire:model="searchKeywords"/>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>
                                        City Name
                                        <span wire:click="sortBy('cities.city_name')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'cities.city_name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'cities.city_name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>
                                        State Name
                                        <span wire:click="sortBy('states.state_name')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'states.state_name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'states.state_name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>
                                        Country Name
                                        <span wire:click="sortBy('countries.country_name')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'countries.country_name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'countries.country_name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>
                                        City Abbreviation
                                        <span wire:click="sortBy('cities.city_abbreviation')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'cities.city_abbreviation' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'cities.city_abbreviation' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>Created At</th>
                                    <th>
                                        Status
                                        <span wire:click="sortBy('cities.status')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'cities.status' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'cities.status' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($cities as $key => $v_city)
                                    <tr>
                                        <td class="align-middle">{{ $cities->firstItem() + $key }}</td>
                                        <td class="align-middle">
                                            <img src="{{ $v_city->featured_image_url }}" class="img img-circle mr-1" width="30" height="30" alt="{{ $v_city->city_name }}">
                                            {{ $v_city->city_name }}
                                        </td>
                                        <td class="align-middle">{{ $v_city->state->state_name }}</td>
                                        <td class="align-middle">{{ $v_city->state->country->country_name }}</td>
                                        <td class="align-middle">{{ $v_city->city_abbreviation }}</td>
                                        <td class="align-middle">
                                            {{ $v_city->created_at ? $v_city->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-{{ $v_city->status == 1 ? 'success' : 'warning' }}">
                                                {{ $v_city->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED' }}
                                            </span>
                                        </td>
                                        <td class="text-right align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-default">Options</button>
                                                <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu" style="">
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="changeStatus({{ $v_city->id }})">
                                                        <i class="fas fa-{{ $v_city->status == 1 ? 'arrow-down' : 'arrow-up' }} mr-2"></i>
                                                        {{ $v_city->status == 1 ? 'Unpublished' : 'Published' }}
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item" wire:click.prevent="show({{ $v_city->id }})">
                                                        <i class="fas fa-eye mr-2"></i> View
                                                    </button>
                                                    <button class="dropdown-item" wire:click.prevent="edit({{ $v_city }})">
                                                        <i class="fas fa-edit mr-2"></i> Edit
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="destroy({{ $v_city->id }})"><i
                                                            class="fas fa-trash mr-2"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            No result found !
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            {{ $cities->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- City Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                            <span>Edit City</span>
                        @else
                            <span>Add City</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'update' : 'store' }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="city_name">City Name <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.defer="state.city_name"
                                           class="form-control @error('city_name') is-invalid @enderror" id="city_name"
                                           placeholder="City name">
                                    @error('city_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="country_id">Country <span class="text-danger">*</span></label>
                                    <select wire:model="countryId"
                                            class="form-control @error('country_id') is-invalid @enderror" id="country_id">
                                        <option value="">Select One</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="state_id">State <span class="text-danger">*</span></label>
                                    <select wire:model.defer="state.state_id"
                                            class="form-control @error('state_id') is-invalid @enderror" id="state_id">
                                        <option value="">Select One</option>
                                        @foreach($states as $v_state)
                                            <option value="{{ $v_state->id }}">{{ $v_state->state_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="city_abbreviation">City Abbreviation <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.defer="state.city_abbreviation"
                                           class="form-control @error('city_abbreviation') is-invalid @enderror" id="city_abbreviation"
                                           placeholder="Enter abbreviation">
                                    @error('city_abbreviation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="latitude">Latitude </label>
                                    <input type="text" wire:model.defer="state.latitude"
                                           class="form-control @error('latitude') is-invalid @enderror" id="latitude"
                                           placeholder="Enter latitude">
                                    @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude </label>
                                    <input type="text" wire:model.defer="state.longitude"
                                           class="form-control @error('longitude') is-invalid @enderror" id="longitude"
                                           placeholder="Enter longitude">
                                    @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select wire:model.defer="state.status"
                                            class="form-control @error('status') is-invalid @enderror" id="status">
                                        <option value="">Select One</option>
                                        <option value="1">PUBLISHED</option>
                                        <option value="0">UNPUBLISHED</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="customFile">Photo</label>
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <div x-data="{ isUploading : false, progress: 5 }"
                                                 x-on:livewire-upload-start="isUploading = true"
                                                 x-on:livewire-upload-finish="isUploading = false; progress = 5"
                                                 x-on:livewire-upload-error="isUploading = false"
                                                 x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                <input wire:model="photo" type="file" class="custom-file-input" id="customFile">
                                                <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                                                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                                                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                         x-bind:style="`width: ${progress}%`">
                                                        <span class="sr-only">40% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="custom-file-label" for="customFile">
                                                @if($photo)
                                                    {{ $photo->getClientOriginalName() }}
                                                @else
                                                    Choose file
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @if($photo)
                                        <img src="{{ $photo->temporaryUrl() }}" class="img d-block mt-2 w-100" alt="">
                                    @else
                                        <img src="{{ $state['featured_image_url'] ?? '' }}" class="img d-block mt-2 w-100" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            @if($showEditModal)
                                <span> Update</span>
                            @else
                                <span> Save</span>
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        City Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-primary">City Name</td>
                            <td>{{ $city_name }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <img src="{{ $featured_image }}" class="img img-rounded" alt="{{ $city_name }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d57498.037605857266!2d89.22702590816918!3d25.749834262238313!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e32de6fca6019b%3A0x9fa496e687f818c8!2sRangpur!5e0!3m2!1sen!2sbd!4v1659613488249!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-primary">State Name</td>
                            <td>{{ $state_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Country Name</td>
                            <td>{{ $country_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">City Abbreviation</td>
                            <td>{{ $city_abbreviation }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">City Slug</td>
                            <td>{{ $city_slug }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Latitude</td>
                            <td>{{ $latitude }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Longitude</td>
                            <td>{{ $longitude }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Status</td>
                            <td>{{ $status}}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Created By</td>
                            <td>{{ $created_by }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Created At</td>
                            <td>{{ $created_at }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Updated By</td>
                            <td>{{ $updated_by }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Updated At</td>
                            <td>{{ $updated_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- confirmation-alert components -->
    <x-confirmation-alert/>

</div>

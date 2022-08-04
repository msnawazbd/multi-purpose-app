<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">States</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Locations</a></li>
                        <li class="breadcrumb-item active">States</li>
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
                                    &nbsp; Add New State
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
                                        State Abbreviation
                                        <span wire:click="sortBy('states.state_abbreviation')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'states.state_abbreviation' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'states.state_abbreviation' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>Created At</th>
                                    <th>
                                        Status
                                        <span wire:click="sortBy('states.status')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'states.status' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'states.status' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($states as $key => $state)
                                    <tr>
                                        <td class="align-middle">{{ $states->firstItem() + $key }}</td>
                                        <td class="align-middle">{{ $state->state_name }} ({{ $state->cities->count() }})</td>
                                        <td class="align-middle">{{ $state->country->country_name }}</td>
                                        <td class="align-middle">{{ $state->state_abbreviation }}</td>
                                        <td class="align-middle">
                                            {{ $state->created_at ? $state->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-{{ $state->status == 1 ? 'success' : 'warning' }}">
                                                {{ $state->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED' }}
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
                                                            wire:click.prevent="changeStatus({{ $state->id }})">
                                                        <i class="fas fa-{{ $state->status == 1 ? 'arrow-down' : 'arrow-up' }} mr-2"></i>
                                                        {{ $state->status == 1 ? 'Unpublished' : 'Published' }}
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item" wire:click.prevent="show({{ $state->id }})">
                                                        <i class="fas fa-eye mr-2"></i> View
                                                    </button>
                                                    <button class="dropdown-item" wire:click.prevent="edit({{ $state }})">
                                                        <i class="fas fa-edit mr-2"></i> Edit
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="destroy({{ $state->id }})"><i
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
                            {{ $states->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- State Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                            <span>Edit State</span>
                        @else
                            <span>Add State</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'update' : 'store' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="state_name">State Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model.defer="f_state.state_name"
                                   class="form-control @error('state_name') is-invalid @enderror" id="state_name"
                                   placeholder="Full state name">
                            @error('state_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="country_id">Country <span class="text-danger">*</span></label>
                            <select wire:model.defer="f_state.country_id"
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
                            <label for="state_abbreviation">State Abbreviation <span class="text-danger">*</span></label>
                            <input type="text" wire:model.defer="f_state.state_abbreviation"
                                   class="form-control @error('state_abbreviation') is-invalid @enderror" id="state_abbreviation"
                                   placeholder="Enter abbreviation">
                            @error('state_abbreviation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select wire:model.defer="f_state.status"
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
                        State Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-primary">State Name</td>
                            <td>{{ $state_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Country Name</td>
                            <td>{{ $country_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">State Abbreviation</td>
                            <td>{{ $state_abbreviation }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">State Slug</td>
                            <td>{{ $state_slug }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">States</td>
                            <td>
                                @foreach($city_list as $city)
                                    <span class="badge badge-info">{{ $city->city_name }}</span>
                                @endforeach
                            </td>
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

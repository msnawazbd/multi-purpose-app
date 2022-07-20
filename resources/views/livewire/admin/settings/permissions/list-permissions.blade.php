<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Permissions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item active">Permissions</li>
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
                                    &nbsp; Add New Permission
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
                                        Name
                                        <span wire:click="sortBy('name')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>
                                        Guard Name
                                        <span wire:click="sortBy('guard_name')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'guard_name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'guard_name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>Roles</th>
                                    <th>Created At</th>
                                    <th>
                                        Status
                                        <span wire:click="sortBy('status')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'status' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'status' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($permissions as $key => $v_permission)
                                    <tr>
                                        <td class="align-middle">{{ $permissions->firstItem() + $key }}</td>
                                        <td class="align-middle">{{ $v_permission->name }}</td>
                                        <td class="align-middle">{{ $v_permission->guard_name }}</td>
                                        <td class="align-middle">
                                            @foreach($v_permission->roles as $role)
                                                <a style="cursor: pointer;"
                                                   wire:click.prevent="revokeRole({{ $v_permission }}, '{{ $role->name }}')">
                                                    <span class="badge badge-info text-uppercase">
                                                {{ $role->name }}
                                                    <i class="fas fa-times pl-1 ml-1 text-dark border-left"></i>
                                                </span>
                                                </a>
                                            @endforeach
                                        </td>
                                        <td class="align-middle">
                                            {{ $v_permission->created_at ? $v_permission->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-{{ $v_permission->status == 1 ? 'success' : 'warning' }}">
                                                {{ $v_permission->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED' }}
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
                                                <div class="dropdown-menu" permission="menu" style="">
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="changeStatus({{ $v_permission->id }})">
                                                        <i class="fas fa-{{ $v_permission->status == 1 ? 'arrow-down' : 'arrow-up' }} mr-2"></i>
                                                        {{ $v_permission->status == 1 ? 'Unpublished' : 'Published' }}
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="show({{ $v_permission->id }})">
                                                        <i class="fas fa-eye mr-2"></i> View
                                                    </button>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="edit({{ $v_permission }})">
                                                        <i class="fas fa-edit mr-2"></i> Edit
                                                    </button>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="giveRole({{ $v_permission }})">
                                                        <i class="fas fa-unlock mr-2"></i> Assign Roles
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="destroy({{ $v_permission->id }})"><i
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
                            {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Permission Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                            <span>Edit Permission</span>
                        @else
                            <span>Add Permission</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'update' : 'store' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model.defer="state.name"
                                   class="form-control @error('name') is-invalid @enderror" id="name"
                                   placeholder="Full name">
                            @error('name')
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
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea wire:model.defer="state.description"
                                      class="form-control @error('description') is-invalid @enderror" id="description"
                                      placeholder="Enter description"></textarea>
                            @error('nodescriptionte')
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
                        Permission Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-primary table-subject">Name</td>
                            <td>{{ $name }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Rate</td>
                            <td>{{ $guard_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Status</td>
                            <td>{{ $status}}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Created At</td>
                            <td>{{ $created_at }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Created By</td>
                            <td>{{ $created_by }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Updated At</td>
                            <td>{{ $updated_at }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Updated By</td>
                            <td>{{ $updated_by }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Description</td>
                            <td>{!! $description !!}</td>
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

    @if($permission)
        <!-- Permission Modal -->
        <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
             wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="text-capitalize">Give Role To {{ $permission->name }}</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form autocomplete="off" wire:submit.prevent="assignRole">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Roles <span class="text-danger">*</span></label>
                                <select wire:model.defer="role_state.name"
                                        class="form-control @error('name') is-invalid @enderror" id="name">
                                    <option value="">Select One</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="pb-2 mb-2">
                                @foreach($permission->roles as $role)
                                    <a style="cursor: pointer"
                                       wire:click.prevent="revokeRole({{ $permission }}, '{{ $role->name }}')">
                                        <span class="badge badge-info text-uppercase">{{ $role->name }}<i class="fas fa-times pl-1 ml-1 text-dark border-left"></i></span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                    class="fas fa-times"></i> Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                <span> Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- confirmation-alert components -->
    <x-confirmation-alert/>

</div>

@push('js')
    <script>
        window.addEventListener('show-role-modal', event => {
            $('#roleModal').modal('show');
        })
    </script>
@endpush

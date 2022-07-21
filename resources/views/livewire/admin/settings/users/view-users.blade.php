<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                                    &nbsp; Add New User
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
                                        Email
                                        <span wire:click="sortBy('email')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'email' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'email' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>Mobile</th>
                                    <th>Registered At</th>
                                    <th>Role</th>
                                    <th>Permission</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($users as $key => $v_user)
                                    <tr>
                                        <td class="align-middle">{{ $users->firstItem() + $key }}</td>
                                        <td class="align-middle">
                                            <img src="{{ $v_user->avatar_url  }}" class="img img-circle mr-1"
                                                 width="30" alt="{{ $v_user->name }}">
                                            {{ $v_user->name }}
                                        </td>
                                        <td class="align-middle">{{ $v_user->email }}</td>
                                        <td class="align-middle">{{ $v_user->mobile }}</td>
                                        <td class="align-middle">
                                            <!-- for php 8 -->
                                            {{--{{ $v_user->created_at?->toFormattedDate() ?? 'N/A' }}--}}
                                            {{ $v_user->created_at ? $v_user->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td class="align-middle">
                                            @foreach($v_user->roles as $role)
                                                <a style="cursor: pointer;"
                                                   wire:click.prevent="revokeRole({{ $v_user }}, '{{ $role->name }}')">
                                                    <span class="badge badge-info text-uppercase">
                                                {{ $role->name }}
                                                    <i class="fas fa-times pl-1 ml-1 text-dark border-left"></i>
                                                </span>
                                                </a>
                                            @endforeach
                                        </td>
                                        <td class="align-middle">
                                            @foreach($v_user->permissions as $permission)
                                                <a style="cursor: pointer;"
                                                   wire:click.prevent="revokePermission({{ $v_user }}, '{{ $permission->name }}')">
                                                    <span class="badge badge-info text-uppercase">
                                                {{ $permission->name }}
                                                    <i class="fas fa-times pl-1 ml-1 text-dark border-left"></i>
                                                </span>
                                                </a>
                                            @endforeach
                                        </td>
                                        <td class="text-right align-middle">
                                            <button type="button" wire:click.prevent="edit({{ $v_user }})"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                            <button type="button" wire:click.prevent="giveRole({{ $v_user }})"
                                                    class="btn btn-info btn-sm"><i class="fas fa-unlock"></i> Roles
                                            </button>
                                            <button type="button" wire:click.prevent="givePermission({{ $v_user }})"
                                                    class="btn btn-info btn-sm"><i class="fas fa-unlock"></i>
                                                Permissions
                                            </button>
                                            <button type="button" wire:click.prevent="destroy({{ $v_user->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- User Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                            <span>Edit User</span>
                        @else
                            <span>Add User</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'update' : 'store' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Full Name</label>
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
                            <label for="email">Email address</label>
                            <input type="email" wire:model.defer="state.email"
                                   class="form-control @error('email') is-invalid @enderror" id="email"
                                   placeholder="Enter email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" wire:model.defer="state.mobile"
                                   class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                                   placeholder="Enter mobile">
                            @error('mobile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" wire:model.defer="state.password"
                                   class="form-control @error('password') is-invalid @enderror" id="password"
                                   autocomplete="on"
                                   placeholder="Password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Confirm Password</label>
                            <input type="password" wire:model.defer="state.password_confirmation" class="form-control"
                                   autocomplete="on"
                                   id="passwordConfirmation" placeholder="Confirm Password">
                        </div>
                        <div class="form-group">
                            <label for="customFile">Profile Photo</label>
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
                                <img src="{{ $state['avatar_url'] ?? '' }}" class="img d-block mt-2 w-100" alt="">
                            @endif
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

    @if($user)
        <!-- Permission Modal -->
        <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
             wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="text-capitalize">Give Role To {{ $user->name }}</span>
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
                                @foreach($user->roles as $role)
                                    <a style="cursor: pointer"
                                       wire:click.prevent="revokeRole({{ $user }}, '{{ $role->name }}')">
                                        <span class="badge badge-info text-uppercase">{{ $role->name }}<i
                                                class="fas fa-times pl-1 ml-1 text-dark border-left"></i></span>
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

        <!-- Permission Modal -->
        <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
             wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="text-capitalize">Give Permission To {{ $user->name }}</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form autocomplete="off" wire:submit.prevent="assignPermission">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Permissions <span class="text-danger">*</span></label>
                                <select wire:model.defer="permission_state.name"
                                        class="form-control @error('name') is-invalid @enderror" id="name">
                                    <option value="">Select One</option>
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="pb-2 mb-2">
                                @foreach($user->permissions as $permission)
                                    <a style="cursor: pointer"
                                       wire:click.prevent="revokePermission({{ $user }}, '{{ $permission->name }}')">
                                        <span class="badge badge-info text-uppercase">{{ $permission->name }}<i
                                                class="fas fa-times pl-1 ml-1 text-dark border-left"></i></span>
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

        window.addEventListener('show-permission-modal', event => {
            $('#permissionModal').modal('show');
        })
    </script>
@endpush

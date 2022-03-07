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
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->toFormattedDate() }}</td>
                                        <td>{{ $user->updated_at->toFormattedDate() }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" wire:click.prevent="edit({{ $user }})"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                            <button type="button" wire:click.prevent="destroy({{ $user->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
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
</div>

<!-- User Modal -->
<div class="modal fade" id="myForm" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
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
                        <label for="password">Password</label>
                        <input type="password" wire:model.defer="state.password"
                               class="form-control @error('password') is-invalid @enderror" id="password"
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
                               id="passwordConfirmation" placeholder="Confirm Password">
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
    <!-- confirmation-alert components -->
    <x-confirmation-alert/>
</div>

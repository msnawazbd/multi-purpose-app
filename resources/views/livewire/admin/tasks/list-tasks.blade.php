<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tasks</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tasks</li>
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
                                <a href="{{ route('admin.clients.create') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-plus"></i>
                                    &nbsp; Add New Task
                                </a>
                                <x-search-input wire:model="searchKeywords"/>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Task Name</th>
                                    <th>Start Date</th>
                                    <th>Deadline</th>
                                    <th>Members</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($tasks as $key => $task)
                                    <tr>
                                        <td>{{ $tasks->firstItem() + $key }}</td>
                                        <td>{{ $task->subject }}</td>
                                        <td>{{ $task->start_date->toFormattedDate() }}</td>
                                        <td>{{ $task->deadline->toFormattedDate() }}</td>
                                        <td>
                                            @foreach($task->usersInfo as $index => $user)
                                                <img src="{{ $user->avatar_url }}" class="img-circle mr-1" width="32"
                                                     alt="{{ $user->name }}" title="{{ $user->name }}">
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $task->status_badge }}">
                                                {{ $task->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $task->priority_badge }}">
                                                {{ $task->priority }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm">Options</button>
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu" style="">
                                                    <button class="dropdown-item" wire:click.prevent="show({{ $task->id }})"><i class="fas fa-eye mr-2"></i> View</button>
                                                    <a class="dropdown-item" href="{{ route('admin.clients.edit', $task->id) }}"><i class="fas fa-edit mr-2"></i> Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item" wire:click.prevent="destroy({{ $task->id }})"><i class="fas fa-trash mr-2"></i> Delete</button>
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
                            {{ $tasks->links() }}
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

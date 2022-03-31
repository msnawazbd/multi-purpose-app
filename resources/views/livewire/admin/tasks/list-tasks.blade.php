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
                                <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-plus"></i>
                                    &nbsp; Add New Task
                                </a>
                                <x-search-input wire:model="searchKeywords"/>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                        <div class="form-row align-items-center mb-3">
                                            <div class="col-auto">
                                                <label for="priority">Priority</label>
                                                <select class="form-control"wire:model="searchPriority" id="priority">
                                                    <option value="" selected>Select one</option>
                                                    <option value="LOW">LOW</option>
                                                    <option value="MEDIUM">MEDIUM</option>
                                                    <option value="HIGH">HIGH</option>
                                                    <option value="URGENT">URGENT</option>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <label for="status">Status</label>
                                                <select class="form-control"wire:model="searchStatus" id="status">
                                                    <option value="" selected>Select one</option>
                                                    <option value="NOT STARTED">NOT STARTED</option>
                                                    <option value="IN PROGRESS">IN PROGRESS</option>
                                                    <option value="COMPLETED">COMPLETED</option>
                                                    <option value="DEFERRED">DEFERRED</option>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <label for="status">Start Date</label>
                                                <x-datepicker wire:model="searchStartDate" id="start_date"
                                                               :error="'start_date'" :placeholder="'Select Date'"/>
                                            </div>
                                            <div class="col-auto">
                                                <label for="deadline">Deadline</label>
                                                <x-datepicker wire:model="searchDeadline" id="deadline"
                                                               :error="'deadline'" :placeholder="'Select Date'"/>
                                            </div>
                                            <div class="col-auto">
                                                <label for="submit-search">&nbsp;</label>
                                                <button type="button" wire:click="resetFilter" class="form-control btn btn-primary" id="submit-search"><i
                                                        class="fa fa-sync mr-1"></i> Reset Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Task Name</th>
                                            <th>Start Date</th>
                                            <th>Deadline</th>
                                            <th>Members</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody wire:loading.class="text-muted">
                                        @forelse($tasks as $key => $task)
                                            <tr>
                                                <td>{{ $tasks->firstItem() + $key }}</td>
                                                <td>{{ $task->subject }}</td>
                                                <td>{{ $task->start_date }}</td>
                                                <td>{{ $task->deadline }}</td>
                                                <td>
                                                    @foreach($task->users as $index => $user)
                                                        <img src="{{ $user->avatar_url }}" class="img-circle mr-1" width="32"
                                                             alt="{{ $user->name }}" title="{{ $user->name }}">
                                                    @endforeach
                                                </td>
                                                <td>
                                            <span class="badge badge-{{ $task->priority_badge }}">
                                                {{ $task->priority }}
                                            </span>
                                                </td>
                                                <td>
                                            <span class="badge badge-{{ $task->status_badge }}">
                                                {{ $task->status }}
                                            </span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm">Options</button>
                                                        <button type="button"
                                                                class="btn btn-default btn-sm dropdown-toggle dropdown-icon"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu" style="">
                                                            <button class="dropdown-item"
                                                                    wire:click.prevent="show({{ $task->id }})"><i
                                                                    class="fas fa-eye mr-2"></i> View
                                                            </button>
                                                            <a class="dropdown-item"
                                                               href="{{ route('admin.tasks.edit', $task) }}"><i
                                                                    class="fas fa-edit mr-2"></i> Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <button class="dropdown-item"
                                                                    wire:click.prevent="destroy({{ $task->id }})"><i
                                                                    class="fas fa-trash mr-2"></i> Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">
                                                    No result found !
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

    <!-- My Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        Task Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-primary table-subject">Subject</td>
                            <td>{{ $subject }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Start Date</td>
                            <td>{{ $start_date }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Deadline</td>
                            <td>{{ $deadline }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Members</td>
                            <td>
                                @foreach($members as $index => $user)
                                    <img src="{{ $user->avatar_url }}" class="img-circle mr-1" width="32"
                                         alt="{{ $user->name }}" title="{{ $user->name }}">
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-primary">Priority</td>
                            <td>{{ $priority }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Status</td>
                            <td>{{ $status }}</td>
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

    <!-- confirmation-alert components -->
    <x-confirmation-alert/>
</div>

@push('styles')
    <style>
        .table-subject {
            width: 150px
        }
    </style>

    <!-- Bootstrap DateTime Picker -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <style>
        .ck-editor__editable_inline {
            min-height: 150px;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript" src="https://unpkg.com/moment"></script>
    <!-- Bootstrap DateTime Picker -->
    <script type="text/javascript" src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@endpush

<div>
    <x-loading-indicator/>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Appointments</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-12 -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.appointments.create') }}"><i
                                            class="fas fa-plus"></i>
                                        &nbsp; Add Appointment
                                    </a>
                                    @if($selectedRows)
                                        <div class="btn-group ml-2">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <a wire:click.prevent="deleteSelectedRows" class="dropdown-item"
                                                   href="#">Delete Selected</a>
                                                <a wire:click.prevent="markAllAsScheduled" class="dropdown-item"
                                                   href="#">Mark as Scheduled</a>
                                                <a wire:click.prevent="markAllAsClosed" class="dropdown-item"
                                                   href="#">Mark
                                                    as Closed</a>
                                                <a wire:click.prevent="export" class="dropdown-item"
                                                   href="#">Export</a>
                                            </div>
                                        </div>
                                        <span
                                            class="ml-2">Selected {{ count($selectedRows) }} {{ Str::plural('appointment', count($selectedRows)) }}</span>
                                    @endif
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button wire:click="filterByStatus" type="button"
                                            class="btn {{ is_null($status) ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">All</span>
                                        <span class="badge badge-pill badge-info">{{ $appointmentsCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus('scheduled')" type="button"
                                            class="btn {{ ($status === 'scheduled') ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">Scheduled</span>
                                        <span class="badge badge-pill badge-primary">{{ $scheduledAppointmentsCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus('closed')" type="button"
                                            class="btn {{ ($status === 'closed') ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">Closed</span>
                                        <span class="badge badge-pill badge-success">{{ $closedAppointmentsCount }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <div class="icheck-primary d-inline ml-2">
                                            <input wire:model="selectPageRows" type="checkbox" value="" name="todo2"
                                                   id="todoCheck2" checked="">
                                            <label for="todoCheck2"></label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Color</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:sortable="updateAppointmentOrder">
                                @foreach($appointments as $key => $appointment)
                                    <tr wire:sortable.item="{{ $appointment->id }}" wire:key="appointment-{{ $appointment->id }}">
                                        <td class="align-middle" wire:sortable.handle style="width: 10px; cursor: move"><i class="fa fa-arrows-alt text-muted"></i></td>
                                        <td class="align-middle">
                                            <div class="icheck-primary d-inline ml-2">
                                                <input wire:model="selectedRows" type="checkbox"
                                                       value="{{ $appointment->id }}" name="todo2"
                                                       id="{{ $appointment->id }}">
                                                <label for="{{ $appointment->id }}"></label>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ $appointments->firstItem() + $key }}</td>
                                        <td class="align-middle">{{ $appointment->client->full_name }}</td>
                                        <td class="align-middle">{{ $appointment->date }}</td>
                                        <td class="align-middle">{{ $appointment->time }}</td>
                                        <td class="align-middle">
                                            <span class="px-2" style="background-color: {{ $appointment->color }}"></span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-{{ $appointment->status_badge }}">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-default">Options</button>
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button class="dropdown-item" wire:click.prevent="changeStatus({{ $appointment->id }})"><i class="fas fa-eye{{ $appointment->status == 'CLOSED' ? '-slash' : '' }} mr-2"></i> View</button>
                                                    <a class="dropdown-item" href="{{ route('admin.appointments.edit', $appointment) }}"><i class="fas fa-edit mr-2"></i> Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item" wire:click.prevent="destroy({{ $appointment->id }})"><i class="fas fa-trash mr-2"></i> Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            {{ $appointments->links() }}
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

<!-- confirmation-alert components -->
<x-confirmation-alert/>

@push('styles')
    <style>
        .draggable-mirror {
            background-color: #ffffff;
            width: 100%;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@push('after-livewire-scripts')
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
@endpush

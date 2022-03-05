<div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Appointments</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Appointments</li>
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
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <a href="#" class="btn btn-primary btn-sm"><i
                                                class="fas fa-plus"></i>
                                            &nbsp; Add Appointment
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        {{--<button wire:click="filter_by_status" type="button"
                                                class="btn {{ is_null($status) ? 'btn-secondary' : 'btn-default' }}">
                                            <span class="mr-1">All</span>
                                            <span class="badge badge-pill badge-info">{{ $total_appointment }}</span>
                                        </button>

                                        <button wire:click="filter_by_status('scheduled')" type="button"
                                                class="btn {{ ($status === 'scheduled') ? 'btn-secondary' : 'btn-default' }}">
                                            <span class="mr-1">Scheduled</span>
                                            <span class="badge badge-pill badge-primary">{{ $scheduled_appointment }}</span>
                                        </button>

                                        <button wire:click="filter_by_status('closed')" type="button"
                                                class="btn {{ ($status === 'closed') ? 'btn-secondary' : 'btn-default' }}">
                                            <span class="mr-1">Closed</span>
                                            <span class="badge badge-pill badge-success">{{ $closed_appointment }}</span>
                                        </button>--}}
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
                                        <th>ID</th>
                                        <th>Client Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($appointments as $key => $appointment)
                                        <tr wire:sortable.item="{{ $appointment->id }}"
                                            wire:key="appointment-{{ $appointment->id }}">
                                            <td wire:sortable.handle style="width: 10px; cursor: move"><i
                                                    class="fa fa-arrows-alt text-muted"></i></td>
                                            <td>
                                                <div class="icheck-primary d-inline ml-2">
                                                    <input wire:model="selected_rows" type="checkbox"
                                                           value="{{ $appointment->id }}" name="todo2"
                                                           id="{{ $appointment->id }}">
                                                    <label for="{{ $appointment->id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $appointments->firstItem() + $key }}</td>
                                            <td>{{ $appointment->clientInfo->name }}</td>
                                            <td>{{ $appointment->date }}</td>
                                            <td>{{ $appointment->time }}</td>
                                            <td>
                                            <span
                                                class="badge badge-{{ $appointment->status_badge }}">{{ $appointment->status }}</span>
                                            </td>
                                            <td class="text-right">
                                                <button wire:click="changeStatus({{ $appointment->id }})" type="button"
                                                        class="btn btn-{{ $appointment->status_badge }} btn-sm"><i
                                                        class="fas fa-eye{{ $appointment->status == 'CLOSED' ? '-slash' : '' }}"></i>
                                                </button>
                                                <a href="#"
                                                   class="btn btn-info btn-sm"><i
                                                        class="fas fa-edit"></i></a>
                                                <button type="button"
                                                        wire:click.prevent="destroy({{ $appointment->id }})"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{--@dump($selected_rows)--}}
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
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
    <!-- /. confirmation-alert components -->
</div>

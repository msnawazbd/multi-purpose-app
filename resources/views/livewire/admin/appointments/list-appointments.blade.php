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
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.appointments.create') }}"><i class="fas fa-plus"></i>
                                    &nbsp; Add Appointment
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @foreach($appointments as $key => $appointment)
                                    <tr>
                                        <td>{{ $appointments->firstItem() + $key }}</td>
                                        <td>{{ $appointment->clientInfo->name }}</td>
                                        <td>{{ $appointment->date->toFormattedDate() }}</td>
                                        <td>{{ $appointment->time->toFormattedTime() }}</td>
                                        <td>
                                            <span class="badge badge-{{ $appointment->status_badge }}">{{ $appointment->status }}</span>
                                        </td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                                            <button type="button" wire:click.prevent="edit({{ $appointment }})" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                            <button type="button" wire:click.prevent="destroy({{ $appointment->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
    <!-- confirmation-alert components -->
    <x-confirmation-alert/>
</div>

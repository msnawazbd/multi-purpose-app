<div>
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.appointments') }}">Appointments</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                            <div class="card-tools">
                                <a href="{{ route('admin.appointments') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-list"></i>
                                    &nbsp; Manage Appointment
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form wire:submit.prevent="create" autocomplete="off">
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_id">Client:</label>
                                            <select class="form-control @error('client_id') is-invalid @enderror"
                                                    wire:model.defer="state.client_id" id="client_id">
                                                <option value="">Select One</option>
                                                @foreach($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('client_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Team Members</label>
                                            <div
                                                class="@error('members') is-invalid border border-danger rounded custom-error @enderror">
                                                <x-inputs.select2 wire:model="state.members" id="members"
                                                                  placeholder="Select Members">
                                                    <option>One</option>
                                                    <option>Alaska</option>
                                                    <option>California</option>
                                                    <option>Delaware</option>
                                                    <option>Tennessee</option>
                                                    <option>Texas</option>
                                                    <option>Washington</option>
                                                </x-inputs.select2>
                                            </div>
                                            @error('members')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Color Picker -->
                                        <div class="form-group">
                                            <label>Color picker with addon:</label>
                                            <div class="input-group" id="colorPicker">
                                                <input type="text" name="color" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appointmentTime">Appointment Time</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                </div>
                                                <x-timepicker wire:model.defer="state.time" id="appointment_time"
                                                              :error="'time'"/>
                                                @error('time')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appointmentDate">Appointment Date</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-calendar"></i></span>
                                                </div>
                                                <x-datepicker wire:model.defer="state.date" id="appointment_date"
                                                              :error="'date'"/>
                                                @error('date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select id="status" wire:model.defer="state.status"
                                                    class="form-control @error('status') is-invalid @enderror">
                                                <option value="" selected>Select one</option>
                                                <option value="SCHEDULED">Scheduled</option>
                                                <option value="CLOSED">Closed</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div wire:ignore class="form-group">
                                            <label for="note">Note:</label>
                                            <textarea id="note" data-note="@this" wire:model.defer="state.note"
                                                      class="form-control @error('note') is-invalid @enderror"></textarea>
                                            @error('note')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <x-inputs.button id="create-appointment" class="text-white">Create appointment</x-inputs.button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@include('livewire/admin/appointments/appointment-css')
@include('livewire/admin/appointments/appointment-js')

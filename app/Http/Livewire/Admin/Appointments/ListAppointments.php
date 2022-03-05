<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;

class ListAppointments extends AdminComponent
{
    public $status = null;

    public function render()
    {
        $appointments = Appointment::with([
            'clientInfo'
        ])
            ->when($this->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->paginate(5);
        return view('livewire.admin.appointments.list-appointments', [
            'appointments' => $appointments,
        ]);
    }
}

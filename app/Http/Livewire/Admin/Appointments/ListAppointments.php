<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Appointment;
use Livewire\Component;

class ListAppointments extends Component
{
    public $appointmentId;

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function destroy($appointmentId)
    {
        $this->appointmentId = $appointmentId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        $data = Appointment::query()->findOrFail($this->appointmentId);
        $data->delete();

        $this->dispatchBrowserEvent('deleted', ['message' => 'Appointment deleted successfully.']);
    }
    public function render()
    {
        $appointments = Appointment::query()
            ->with(['clientInfo'])
            ->latest()
            ->paginate(5);
        return view('livewire.admin.appointments.list-appointments', [
            'appointments' => $appointments
        ]);
    }
}

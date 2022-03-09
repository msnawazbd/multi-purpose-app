<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Exports\AppointmentsExport;
use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;

class ListAppointments extends AdminComponent
{
    public $appointmentId;
    public $status = null;
    public $selectedRows = [];
    public $selectPageRows = false;

    protected $queryString = ['status'];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->appointments->pluck('id')->map(function ($id) {
                return (string)$id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function deleteSelectedRows()
    {
        Appointment::query()->whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('deleted', ['message' => 'All selected appointment got deleted.']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsScheduled()
    {
        Appointment::query()->whereIn('id', $this->selectedRows)->update(['status' => 'SCHEDULED']);

        $this->dispatchBrowserEvent('updated', ['message' => 'Appointments marked as scheduled']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsClosed()
    {
        Appointment::query()->whereIn('id', $this->selectedRows)->update(['status' => 'CLOSED']);

        $this->dispatchBrowserEvent('updated', ['message' => 'Appointments marked as closed']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function export()
    {
        return (new AppointmentsExport($this->selectedRows))->download('appointments.xlsx');
    }

    public function updateAppointmentOrder($items)
    {
        foreach ($items as $key => $item) {
            Appointment::query()->find($item['value'])->update(['order_position' => $item['order']]);
        }

        $this->dispatchBrowserEvent('updated', ['message' => 'Appointments marked as closed']);
    }

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

    public function filterByStatus($status = null)
    {
        $this->resetPage();
        $this->status = $status;
    }

    public function changeStatus($appointment_id)
    {
        $appointment = Appointment::query()->findOrFail($appointment_id);
        $appointment->status = $appointment->status == 'SCHEDULED' ? 'CLOSED' : 'SCHEDULED';
        $appointment->save();
        $this->dispatchBrowserEvent('updated', ['message' => 'Appointments status changed.']);
    }

    public function getAppointmentsProperty()
    {
        return Appointment::query()
            ->with([
                'clientInfo'
            ])
            ->when($this->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('order_position', 'asc')
            ->paginate(5);
    }

    public function render()
    {
        $appointmentsCount = Appointment::query()->count();
        $scheduledAppointmentsCount = Appointment::query()->where('status', 'scheduled')->count();
        $closedAppointmentsCount = Appointment::query()->where('status', 'closed')->count();

        return view('livewire.admin.appointments.list-appointments', [
            'appointments' => $this->appointments,
            'appointmentsCount' => $appointmentsCount,
            'scheduledAppointmentsCount' => $scheduledAppointmentsCount,
            'closedAppointmentsCount' => $closedAppointmentsCount,
            ]
        );
    }
}

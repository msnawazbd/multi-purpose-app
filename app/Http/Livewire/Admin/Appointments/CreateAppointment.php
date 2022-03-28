<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateAppointment extends Component
{
    public $state = [];

    public function create()
    {
        Validator::make($this->state, [
            'client_id' => 'required|numeric',
            'members' => 'required',
            'color' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required',
            'note' => 'required|string',
        ], [
            'client_id.required' => 'The client field is required.'
        ])
            ->validate();

        /*$this->state['status'] = 'CLOSED';
       Appointment::create($this->state);*/

        try {
            Appointment::query()->create([
                'client_id' => $this->state['client_id'],
                'date' => $this->state['date'],
                'time' => $this->state['time'],
                'note' => $this->state['note'],
                'status' => $this->state['status'],
                'members' => $this->state['members'],
                'color' => $this->state['color'],
            ]);

            $this->dispatchBrowserEvent('success', ['message' => 'Appointment created successfully.']);
            return redirect()->route('admin.appointments');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $clients = Client::query()->orderBy('first_name')->get();
        return view('livewire.admin.appointments.create-appointment', [
            'clients' => $clients
        ]);
    }
}

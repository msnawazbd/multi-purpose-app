<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateTask extends Component
{
    public $state = [];

    public function create()
    {
        $validateData = Validator::make($this->state, [
            'subject' => 'required|string|min:3|max:255',
            'start_date' => 'required|date',
            'deadline' => 'required|date',
            'priority' => 'required|string',
            'status' => 'required|string',
            'members' => 'required',
            'description' => 'nullable|string'
        ])->validate();

        $validateData['created_by'] = auth()->user()->id;

        try {
            Task::query()
                ->create([
                    'subject' => $this->state['subject'],
                    'start_date' => $this->state['start_date'],
                    'deadline' => $this->state['deadline'],
                    'priority' => $this->state['priority'],
                    'status' => $this->state['status'],
                    'description' => $this->state['description'],
                    'created_by' => auth()->user()->id
                ]);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Task created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $users = User::query()
            ->whereIn('role', ['admin'])
            ->orderBy('name')
            ->get(['id', 'name', 'mobile']);
        return view('livewire.admin.tasks.create-task', [
            'users' => $users
        ]);
    }
}

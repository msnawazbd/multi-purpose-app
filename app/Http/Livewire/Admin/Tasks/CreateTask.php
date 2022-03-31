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
        Validator::make($this->state, [
            'subject' => 'required|string|min:3|max:255',
            'start_date' => 'required|date',
            'deadline' => 'required|date',
            'priority' => 'required|string',
            'status' => 'required|string',
            'members' => 'required',
            'description' => 'nullable|string'
        ])->validate();

        try {
            $task = Task::query()
                ->create([
                    'subject' => $this->state['subject'],
                    'start_date' => $this->state['start_date'],
                    'deadline' => $this->state['deadline'],
                    'priority' => $this->state['priority'],
                    'status' => $this->state['status'],
                    'description' => $this->state['description'],
                    'created_by' => auth()->user()->id
                ]);

            if (!empty($this->state['members'])) {
                $task->users()->attach($this->state['members']);
            }

            $this->dispatchBrowserEvent('task-success', ['message' => 'Task created successfully!']);
            return redirect()->route('admin.tasks');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $users = User::query()
            //->whereIn('role', ['admin'])
            ->orderBy('name')
            ->get(['id', 'name', 'mobile']);
        return view('livewire.admin.tasks.create-task', [
            'users' => $users
        ]);
    }
}

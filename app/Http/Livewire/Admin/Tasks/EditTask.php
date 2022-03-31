<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditTask extends Component
{
    public $state = [];
    public $task;

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->state = Task::query()
            ->with([
                'users'
            ])
            ->where('id', $task->id)
            ->first()
            ->toArray();

        $this->state['members'] = collect($this->state['users'])->pluck('id');
    }

    public function update()
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
            $this->task->update([
                'subject' => $this->state['subject'],
                'start_date' => $this->state['start_date'],
                'deadline' => $this->state['deadline'],
                'priority' => $this->state['priority'],
                'status' => $this->state['status'],
                'description' => $this->state['description'],
                'updated_by' => auth()->user()->id
            ]);

            if (!empty($this->state['members'])) {
                $this->task->users()->sync($this->state['members']);
            } else {
                $this->task->users()->sync(array());
            }
            $this->dispatchBrowserEvent('success', ['message' => 'Task updated successfully.']);
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
            //->whereIn('role', ['admin'])
            ->orderBy('name')
            ->get(['id', 'name', 'mobile']);
        return view('livewire.admin.tasks.edit-task', [
            'users' => $users
        ]);
    }
}

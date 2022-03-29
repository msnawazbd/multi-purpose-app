<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class EditTask extends Component
{
    public $state = [];

    public $task;

    public function mount(Task $task)
    {
        dd($task);
        $this->state = $task->toArray();
        $this->task = $task;
    }

    public function render()
    {
        $users = User::query()
            ->whereIn('role', ['admin'])
            ->orderBy('name')
            ->get(['id', 'name', 'mobile']);
        return view('livewire.admin.tasks.edit-task', [
            'users' => $users
        ]);
    }
}

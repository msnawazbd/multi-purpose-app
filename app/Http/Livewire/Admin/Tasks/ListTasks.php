<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Task;

class ListTasks extends AdminComponent
{
    public function render()
    {
        $tasks = Task::query()
            ->with([
                'usersInfo'
            ])
            ->orderBy('created_at')
            ->paginate(10);
        return view('livewire.admin.tasks.list-tasks', [
            'tasks' => $tasks
        ]);
    }
}

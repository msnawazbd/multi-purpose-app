<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class EditTask extends Component
{
    public $subject, $start_date, $deadline, $priority, $status, $members = [], $description;

    public $taskId;

    public function mount($id)
    {
        $this->taskId = $id;

        $task = Task::query()
            ->with([
                'usersInfo:id'
            ])
            ->where('id', $id)
            ->first();

        //dd($task);

        $this->subject = $task->subject;
        $this->start_date = $task->start_date;
        $this->deadline = $task->deadline->toFormattedDate();
        $this->priority = $task->priority;
        $this->status = $task->status;
        $this->description = $task->description;
        $this->members = [1];
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

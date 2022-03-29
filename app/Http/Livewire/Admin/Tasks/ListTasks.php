<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Task;

class ListTasks extends AdminComponent
{
    public $subject, $start_date, $deadline, $priority, $status, $description, $members = [], $created_at, $updated_at, $created_by, $updated_by;
    public $searchKeywords = null;
    public $taskId;

    protected $queryString = ['searchKeywords' => ['except' => '']];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function show($id)
    {
        try {
            $task = Task::query()
                ->with([
                    'usersInfo'
                ])
                ->where('id', $id)
                ->first();

            $this->subject = $task->subject;
            $this->start_date = $task->start_date->toFormattedDate();
            $this->deadline = $task->deadline->toFormattedDate();
            $this->priority = $task->priority;
            $this->members = $task->usersInfo;
            $this->status = $task->status;
            $this->description = $task->description;
            $this->created_at = $task->created_at ? $task->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $task->updated_at ? $task->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $task->createdByInfo->name;
            $this->updated_by = $task->updatedByInfo ? $task->updatedByInfo->name : 'N/A';

            $this->dispatchBrowserEvent('show-modal');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            return redirect()->route('admin.tasks');
        }
    }

    public function destroy($taskId)
    {
        $this->taskId = $taskId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Task::query()->findOrFail($this->taskId);
            $data->delete();
            $this->dispatchBrowserEvent('success', ['message' => 'Task deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
        }
    }

    public function render()
    {
        $tasks = Task::query()
            ->with([
                'usersInfo'
            ])
            ->where(function ($query) {
                $query->where('subject', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('description', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.admin.tasks.list-tasks', [
            'tasks' => $tasks
        ]);
    }
}

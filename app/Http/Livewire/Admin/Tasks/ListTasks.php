<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Task;
use Carbon\Carbon;

class ListTasks extends AdminComponent
{
    public $subject, $start_date, $deadline, $priority, $status, $description, $members = [], $created_at, $updated_at, $created_by, $updated_by;
    public $searchKeywords = null;
    public $searchPriority = null;
    public $searchStatus = null;
    public $searchStartDate = null;
    public $searchDeadline = null;
    public $taskId;

    protected $queryString = [
        'searchKeywords' => ['except' => ''],
        'searchPriority' => ['except' => ''],
        'searchStatus' => ['except' => ''],
        'searchStartDate' => ['except' => ''],
        'searchDeadline' => ['except' => '']
    ];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function resetFilter()
    {
        $this->searchKeywords = null;
        $this->searchPriority = null;
        $this->searchStatus = null;
        $this->searchStartDate = null;
        $this->searchDeadline = null;
    }

    public function updatedSearchKeywords()
    {
        $this->resetPage();
    }

    public function updatedSearchPriority()
    {
        $this->resetPage();
    }

    public function updatedSearchStatus()
    {
        $this->resetPage();
    }

    public function updatedSearchStartDate()
    {
        $this->resetPage();
    }

    public function updatedSearchDeadline()
    {
        $this->resetPage();
    }

    public function show($id)
    {
        try {
            $task = Task::query()
                ->with([
                    'users'
                ])
                ->where('id', $id)
                ->first();

            $this->subject = $task->subject;
            $this->start_date = $task->start_date;
            $this->deadline = $task->deadline;
            $this->priority = $task->priority;
            $this->members = $task->users;
            $this->status = $task->status;
            $this->description = $task->description;
            $this->created_at = $task->created_at ? $task->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $task->updated_at ? $task->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $task->createdBy->name;
            $this->updated_by = $task->updatedBy ? $task->updatedBy->name : 'N/A';

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
        $query = Task::query()
            ->with([
                'users'
            ])
            ->where(function ($query) {
                $query->where('subject', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('description', 'like', '%' . $this->searchKeywords . '%');
            });

        if ($this->searchPriority) {
            $query->where('priority', $this->searchPriority);
        }
        if ($this->searchStatus) {
            $query->where('status', $this->searchStatus);
        }
        if ($this->searchStartDate) {
            $query->where('start_date', Carbon::parse($this->searchStartDate)->toDateString());
        }
        if ($this->searchDeadline) {
            $query->where('deadline', Carbon::parse($this->searchDeadline)->toDateString());
        }

        $query->orderBy('created_at', 'desc');
        $tasks = $query->paginate(5);
        return view('livewire.admin.tasks.list-tasks', [
            'tasks' => $tasks
        ]);
    }
}

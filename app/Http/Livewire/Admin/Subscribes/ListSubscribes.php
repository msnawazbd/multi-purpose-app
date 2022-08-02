<?php

namespace App\Http\Livewire\Admin\Subscribes;

use App\Exports\SubscribesExport;
use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Auth;

class ListSubscribes extends AdminComponent
{
    public $subscribeId;
    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['searchKeywords' => ['except' => '']];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSearchKeywords()
    {
        $this->resetPage();
    }

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function changeStatus($subscribeId)
    {
        try {
            $subscribe = Subscribe::query()->findOrFail($subscribeId);
            $subscribe->status = $subscribe->status == 1 ? 0 : 1;
            $subscribe->updated_by = Auth::user()->id;
            $subscribe->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Subscribe status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function export()
    {
        return (new SubscribesExport([1]))->download('appointments.xlsx');
    }

    public function destroy($subscribeId)
    {
        $this->subscribeId = $subscribeId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Subscribe::query()->findOrFail($this->subscribeId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Subscribe deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $subscribes = Subscribe::query()
            ->with([
                'updatedBy:id,name'
            ])
            ->where(function ($query) {
                $query->where('email', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['id', 'email', 'status', 'created_at', 'updated_by', 'updated_at'])
            ->paginate(5);

        return view('livewire.admin.subscribes.list-subscribes', [
            'subscribes' => $subscribes
        ]);
    }
}

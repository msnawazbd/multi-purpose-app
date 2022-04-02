<?php

namespace App\Http\Livewire\Admin\Services;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;

class ListServices extends AdminComponent
{
    public $name, $amount, $status, $description, $created_at, $updated_at, $created_by, $updated_by;

    public $state = [];
    public $service;
    public $serviceId;
    public $showEditModal = false;
    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $photo;

    protected $queryString = ['searchKeywords' => ['except' => '']];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSearchKeywords()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function store()
    {
        Validator::make($this->state, [
            'name' => 'required|string|max:100|min:4',
            'amount' => 'required|numeric',
            'status' => 'required|numeric',
            'description' => 'nullable|string',
        ])->validate();

        try {
            Service::query()
                ->create([
                    'name' => $this->state['name'],
                    'amount' => $this->state['amount'],
                    'status' => $this->state['status'],
                    'description' => $this->state['description'],
                    'created_by' => auth()->user()->id
                ]);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Service created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(Service $service)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->service = $service;
        $this->state = $service->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'name' => 'required|string|max:100|min:4',
            'amount' => 'required|numeric',
            'status' => 'required|numeric',
            'description' => 'nullable|string',
        ])->validate();

        $validateData['updated_by'] = auth()->user()->id;

        try {
            $this->service->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Service updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($serviceId)
    {
        try {
            $service = Service::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                ])
                ->where('id', $serviceId)
                ->first();

            $this->name = $service->name;
            $this->amount = $service->amount;
            $this->status = $service->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED';
            $this->description = $service->description;
            $this->created_at = $service->created_at ? $service->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $service->updated_at ? $service->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $service->createdBy->name;
            $this->updated_by = $service->updatedBy ? $service->updatedBy->name : 'N/A';

            $this->dispatchBrowserEvent('show-view-modal');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            return redirect()->route('admin.tasks');
        }
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

    public function changeStatus($serviceId)
    {
        try {
            $service = Service::query()->findOrFail($serviceId);
            $service->status = $service->status == 1 ? 0 : 1;
            $service->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Service status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($serviceId)
    {
        $this->serviceId = $serviceId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Service::query()->findOrFail($this->serviceId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Service deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $services = Service::query()
            ->with([
                'createdBy'
            ])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('amount', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('description', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['id', 'name', 'amount', 'status', 'created_at'])
            ->paginate(5);

        return view('livewire.admin.services.list-services', [
            'services' => $services
        ]);
    }
}

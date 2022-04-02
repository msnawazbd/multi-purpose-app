<?php
namespace App\Http\Livewire\Admin\Settings\Taxes;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Tax;
use Illuminate\Support\Facades\Validator;

class ListTaxes extends AdminComponent
{
    public $name, $rate, $status, $description, $created_at, $updated_at, $created_by, $updated_by;

    public $state = [];
    public $tax;
    public $taxId;
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
            'rate' => 'required|numeric',
            'status' => 'required|numeric',
            'description' => 'nullable|string',
        ])->validate();

        try {
            Tax::query()
                ->create([
                    'name' => $this->state['name'],
                    'rate' => $this->state['rate'],
                    'status' => $this->state['status'],
                    'description' => $this->state['description'],
                    'created_by' => auth()->user()->id
                ]);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Tax created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(Tax $tax)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->tax = $tax;
        $this->state = $tax->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'name' => 'required|string|max:100|min:4',
            'rate' => 'required|numeric',
            'status' => 'required|numeric',
            'description' => 'nullable|string',
        ])->validate();

        $validateData['updated_by'] = auth()->user()->id;

        try {
            $this->tax->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Tax updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show(Tax $tax)
    {
        try {
            $tax = Tax::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                ])
                ->where('id', $tax->id)
                ->first();

            $this->name = $tax->name;
            $this->rate = $tax->rate;
            $this->status = $tax->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED';
            $this->description = $tax->description;
            $this->created_at = $tax->created_at ? $tax->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $tax->updated_at ? $tax->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $tax->createdBy->name;
            $this->updated_by = $tax->updatedBy ? $tax->updatedBy->name : 'N/A';

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

    public function changeStatus($taxId)
    {
        try {
            $tax = Tax::query()->findOrFail($taxId);
            $tax->status = $tax->status == 1 ? 0: 1;
            $tax->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Tax status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($taxId)
    {
        $this->taxId = $taxId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Tax::query()->findOrFail($this->taxId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Tax deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $taxes = Tax::query()
            ->with([
                'createdBy'
            ])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('rate', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('description', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(5);

        return view('livewire.admin.settings.taxes.list-taxes', [
            'taxes' => $taxes
        ]);
    }
}

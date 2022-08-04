<?php

namespace App\Http\Livewire\Admin\Locations\States;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ListStates extends AdminComponent
{
    public $state_name, $country_name, $state_abbreviation, $city_list = [], $status, $state_slug, $created_at, $updated_at, $created_by, $updated_by;

    public $f_state = [];
    public $state;
    public $stateId;
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
        $validateData = Validator::make($this->f_state, [
            'state_name' => 'required|string|max:80',
            'country_id' => 'required|numeric',
            'state_abbreviation' => 'required|string|max:80',
            'status' => 'required|numeric',
        ], [
            'country_id.required' => 'The country name field is required.',
        ])->validate();

        $validateData['state_slug'] = toFormattedSlug($this->f_state['state_name']);
        $validateData['created_by'] = Auth::user()->id;

        try {
            State::query()->create($validateData);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'State created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(State $state)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->state = $state;
        $this->f_state = $state->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->f_state, [
            'state_name' => 'required|string|max:80',
            'country_id' => 'required|numeric',
            'state_abbreviation' => 'required|string|max:80',
            'status' => 'required|numeric',
        ], [
            'country_id.required' => 'The country name field is required.',
        ])->validate();

        $validateData['state_slug'] = toFormattedSlug($this->f_state['state_slug']);
        $validateData['updated_by'] = Auth::user()->id;

        try {
            $this->state->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'State updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($stateId)
    {
        try {
            $state = State::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                    'country:id,country_name',
                    'cities:id,state_id,city_name',
                ])
                ->where('id', $stateId)
                ->first();

            $this->state_name = $state->state_name;
            $this->country_name = $state->country->country_name;
            $this->city_list = $state->cities;
            $this->state_abbreviation = $state->state_abbreviation;
            $this->status = $state->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED';
            $this->state_slug = $state->state_slug;
            $this->created_at = $state->created_at ? $state->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $state->updated_at ? $state->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $state->createdBy->name;
            $this->updated_by = $state->updatedBy ? $state->updatedBy->name : 'N/A';

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

    public function changeStatus($stateId)
    {
        try {
            $state = State::query()->findOrFail($stateId);
            $state->status = $state->status == 1 ? 0 : 1;
            $state->save();
            $this->dispatchBrowserEvent('success', ['message' => 'State status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($stateId)
    {
        $this->stateId = $stateId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = State::query()->findOrFail($this->stateId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'State deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $states = State::query()
            ->join('countries', function ($join) {
                $join->on('states.country_id', '=', 'countries.id');
            })
            ->with([
                'createdBy:id,name',
                'updatedBy:id,name',
                'country:id,country_name',
                'cities:id,state_id,city_name',
            ])
            ->where(function ($query) {
                $query->where('states.state_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('states.state_abbreviation', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('countries.country_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('countries.country_abbreviation', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['states.id', 'states.country_id', 'states.state_name', 'states.state_abbreviation', 'states.status', 'states.created_at'])
            ->paginate(5);

        $countries = Country::query()->orderBy('country_name')->get(['id', 'country_name']);

        return view('livewire.admin.locations.states.list-states', [
            'states' => $states,
            'countries' => $countries,
        ]);
    }
}

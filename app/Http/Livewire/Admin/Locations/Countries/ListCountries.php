<?php

namespace App\Http\Livewire\Admin\Locations\Countries;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class ListCountries extends AdminComponent
{
    public $country_name, $country_abbreviation, $status, $state_list = [], $country_slug, $created_at, $updated_at;

    public $state = [];
    public $country;
    public $countryId;
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
        $validateData = Validator::make($this->state, [
            'country_name' => 'required|string|max:80',
            'country_abbreviation' => 'required|string|max:80',
            'status' => 'required|numeric',
        ])->validate();

        $validateData['country_slug'] = toFormattedSlug($this->state['country_name']);

        try {
            Country::query()->create($validateData);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Country created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(Country $country)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->country = $country;
        $this->state = $country->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'country_name' => 'required|string|max:80',
            'country_abbreviation' => 'required|string|max:80',
            'status' => 'required|numeric',
        ])->validate();

        $validateData['country_slug'] = toFormattedSlug($this->state['country_slug']);

        try {
            $this->country->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Country updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($countryId)
    {
        try {
            $country = Country::query()
                ->with([
                    'states:id,country_id,state_name'
                ])
                ->where('id', $countryId)
                ->first();

            $this->country_name = $country->country_name;
            $this->state_list = $country->states;
            $this->country_abbreviation = $country->country_abbreviation;
            $this->status = $country->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED';
            $this->country_slug = $country->country_slug;
            $this->created_at = $country->created_at ? $country->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $country->updated_at ? $country->updated_at->toFormattedDate() : 'N/A';

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

    public function changeStatus($countryId)
    {
        try {
            $country = Country::query()->findOrFail($countryId);
            $country->status = $country->status == 1 ? 0 : 1;
            $country->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Country status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($countryId)
    {
        $this->countryId = $countryId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Country::query()->findOrFail($this->countryId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Country deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $countries = Country::query()
            ->with([
                'states:id,country_id,state_name'
            ])
            ->where(function ($query) {
                $query->where('country_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('country_abbreviation', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['id', 'country_name', 'country_abbreviation', 'status', 'created_at'])
            ->paginate(5);

        return view('livewire.admin.locations.countries.list-countries', [
            'countries' => $countries
        ]);
    }
}

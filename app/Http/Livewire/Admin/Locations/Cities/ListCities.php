<?php

namespace App\Http\Livewire\Admin\Locations\Cities;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

class ListCities extends AdminComponent
{
    use WithFileUploads;

    public $city_name, $state_name, $country_name, $city_abbreviation, $featured_image, $latitude, $longitude, $status, $city_slug, $created_at, $updated_at, $created_by, $updated_by;

    public $state = [
        'state_id' => ''
    ];
    public $city;
    public $cityId;
    public $showEditModal = false;
    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $states = [];
    public $countryId;
    public $photo;

    protected $queryString = ['searchKeywords' => ['except' => '']];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSearchKeywords()
    {
        $this->resetPage();
    }

    public function updatedCountryId()
    {
        $this->states = State::query()
            ->where('country_id', $this->countryId)
            ->get(['id', 'state_name']);
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
            'city_name' => 'required|string|max:80',
            'state_id' => 'required|numeric',
            'city_abbreviation' => 'required|string|max:80',
            'latitude' => 'nullable|string|max:80',
            'longitude' => 'nullable|string|max:80',
            'status' => 'required|numeric',
        ], [
            'state_id.required' => 'The country name field is required.',
        ])->validate();

        $validateData['city_slug'] = toFormattedSlug($this->state['city_name']);
        $validateData['created_by'] = Auth::user()->id;

        if ($this->photo) {
            $validateData['featured_image'] = $this->photo->store('/', 'city_featured_images');
        } else {
            $validateData['featured_image'] = '';
        }

        try {
            City::query()->create($validateData);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'City created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(City $city)
    {
        //dd($city->toArray());
        $this->reset();
        $this->showEditModal = true;
        $this->city = $city;
        $this->countryId = $city->state->country_id;
        $this->updatedCountryId();
        $this->state = $city->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'city_name' => 'required|string|max:80',
            'state_id' => 'required|numeric',
            'city_abbreviation' => 'required|string|max:80',
            'latitude' => 'nullable|string|max:80',
            'longitude' => 'nullable|string|max:80',
            'status' => 'required|numeric',
        ], [
            'state_id.required' => 'The country name field is required.',
        ])->validate();

        $validateData['city_slug'] = toFormattedSlug($this->state['city_slug']);
        $validateData['updated_by'] = Auth::user()->id;

        if ($this->photo) {
            Storage::disk('city_featured_images')->delete($this->city->featured_image);
            $validateData['featured_image'] = $this->photo->store('/', 'city_featured_images');
        } else {
            $validateData['featured_image'] = '';
        }

        try {
            $this->city->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'City updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($cityId)
    {
        try {
            $city = City::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                    'state:id,state_name,country_id',
                    'state.country:id,country_name',
                ])
                ->where('id', $cityId)
                ->first();

            $this->city_name = $city->city_name;
            $this->state_name = $city->state->state_name;
            $this->country_name = $city->state->country->country_name;
            $this->city_abbreviation = $city->city_abbreviation;
            $this->status = $city->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED';
            $this->latitude = $city->latitude;
            $this->longitude = $city->longitude;
            $this->city_slug = $city->city_slug;
            $this->featured_image = $city->featured_image_url;
            $this->created_at = $city->created_at ? $city->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $city->updated_at ? $city->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $city->createdBy->name;
            $this->updated_by = $city->updatedBy ? $city->updatedBy->name : 'N/A';

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

    public function changeStatus($cityId)
    {
        try {
            $city = City::query()->findOrFail($cityId);
            $city->status = $city->status == 1 ? 0 : 1;
            $city->save();
            $this->dispatchBrowserEvent('success', ['message' => 'City status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($cityId)
    {
        $this->cityId = $cityId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = City::query()->findOrFail($this->cityId);
            Storage::disk('city_featured_images')->delete($data->featured_image);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'City deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $cities = City::query()
            ->join('states', function ($join) {
                $join->on('cities.state_id', '=', 'states.id');
            })
            ->join('countries', function ($join) {
                $join->on('states.country_id', '=', 'countries.id');
            })
            ->with([
                'createdBy:id,name',
                'updatedBy:id,name',
                'state:id,state_name,country_id',
                'state.country:id,country_name',
            ])
            ->where(function ($query) {
                $query->where('cities.city_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('cities.city_abbreviation', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('states.state_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('states.state_abbreviation', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('countries.country_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('countries.country_abbreviation', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            //->select(['cities.id', 'cities.state_id', 'cities.city_name', 'cities.city_abbreviation', 'cities.status', 'cities.created_at', 'cities.featured_image'])
            ->select(['cities.*'])
            ->paginate(5);

        $countries = Country::query()->orderBy('country_name')->get(['id', 'country_name']);

        return view('livewire.admin.locations.cities.list-cities', [
            'cities' => $cities,
            'countries' => $countries
        ]);
    }
}

<?php

namespace App\Http\Livewire\Admin\Clients;

use App\Models\Client;
use App\Models\Country;
use App\Models\User;
use Livewire\Component;

class CreateClient extends Component
{
    public $first_name, $last_name, $mobile, $alternate_no, $gender, $email, $address, $country_id, $city, $state, $zip_code, $reference_name, $reference_mobile, $status, $details;

    public function resetFields()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->mobile = '';
        $this->alternate_no = '';
        $this->gender = '';
        $this->address = '';
        $this->country_id = '';
        $this->city = '';
        $this->state = '';
        $this->zip_code = '';
        $this->reference_name = '';
        $this->reference_mobile = '';
        $this->details = '';
        $this->status = '';
    }

    public function create()
    {
        $this->validate([
            'first_name' => 'required|string|max:50|min:3',
            'last_name' => 'required|string|max:50|min:3',
            'mobile' => 'required|numeric|unique:users,mobile',
            'alternate_no' => 'nullable|numeric',
            'gender' => 'required|string|max:6',
            'email' => 'nullable|email|max:100|unique:users,email',
            'address' => 'required|string|max:255|min:3',
            'country_id' => 'required|numeric',
            'city' => 'required|string|max:50|min:3',
            'state' => 'nullable|string|max:50|min:3',
            'zip_code' => 'nullable|string|max:20|min:3',
            'reference_name' => 'nullable|string|max:50|min:3',
            'reference_mobile' => 'nullable|numeric',
            'status' => 'required|numeric',
            'details' => 'nullable|string',
        ], [
            'country_id.required' => 'The country field is required.'
        ]);

        try {
            $user = User::query()->create([
                'name' => $this->first_name . ' ' . $this->last_name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'alternate_no' => $this->alternate_no,
                'gender' => $this->gender,
                'address' => $this->address,
                'country_id' => $this->country_id,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zip_code,
                'password' => bcrypt('password'),
                'role' => 'client',
                'created_by' => auth()->user()->id,
            ]);

            if ($user->id) {
                Client::query()->create([
                    'user_id' => $user->id,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'reference_name' => $this->reference_name,
                    'reference_mobile' => $this->reference_mobile,
                    'details' => $this->details,
                    'status' => $this->status,
                    'created_by' => auth()->user()->id,
                ]);

                $this->dispatchBrowserEvent('success', ['message' => 'Client added successfully.']);
                $this->resetFields();
            } else {
                $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            $this->resetFields();
        }
    }

    public function render()
    {
        $countries = Country::query()
            ->orderBy('name')
            ->get();
        return view('livewire.admin.clients.create-client', [
            'countries' => $countries
        ]);
    }
}

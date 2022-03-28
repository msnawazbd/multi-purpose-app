<?php

namespace App\Http\Livewire\Admin\Clients;

use App\Models\Country;
use App\Models\User;
use Livewire\Component;

class EditClient extends Component
{
    public $first_name, $last_name, $mobile, $alternate_no, $gender, $email, $address, $country_id, $city, $state, $zip_code, $reference_name, $reference_mobile, $status, $details;
    public $userId;
    public $user;

    public function mount($id)
    {
        $this->userId = $id;

        try {
            $user = User::query()
                ->with([
                    'clientInfo'
                ])
                ->where('id', $id)
                ->where('role', 'client')
                ->first();

            $this->user = $user;

            $this->first_name = $user->clientInfo->first_name;
            $this->last_name = $user->clientInfo->last_name;
            $this->email = $user->email;
            $this->mobile = $user->mobile;
            $this->alternate_no = $user->alternate_no;
            $this->gender = $user->gender;
            $this->address = $user->address;
            $this->country_id = $user->country_id;
            $this->city = $user->city;
            $this->state = $user->state;
            $this->zip_code = $user->zip_code;
            $this->reference_name = $user->clientInfo->reference_name;
            $this->reference_mobile = $user->clientInfo->reference_mobile;
            $this->details = $user->clientInfo->details;
            $this->status = $user->clientInfo->status;
        } catch (\Exception $e) {
            return redirect()->route('admin.clients');
        }
    }

    public function update()
    {
        $this->validate([
            'first_name' => 'required|string|max:50|min:3',
            'last_name' => 'required|string|max:50|min:3',
            'mobile' => 'required|numeric|unique:users,mobile,' . $this->userId,
            'alternate_no' => 'nullable|numeric',
            'gender' => 'required|string|max:6',
            'email' => 'nullable|email|max:100|unique:users,email,' . $this->userId,
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
            $this->user->update([
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
                'updated_by' => auth()->user()->id,
            ]);

            $this->user->clientInfo->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'reference_name' => $this->reference_name,
                'reference_mobile' => $this->reference_mobile,
                'details' => $this->details,
                'status' => $this->status,
                'updated_by' => auth()->user()->id,
            ]);

            $this->dispatchBrowserEvent('success', ['message' => 'Client updated successfully.']);
            return redirect()->route('admin.clients');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            return redirect()->route('admin.clients');
        }
    }

    public function render()
    {
        $countries = Country::query()
            ->orderBy('name')
            ->get();
        return view('livewire.admin.clients.edit-client', [
            'countries' => $countries
        ]);
    }
}

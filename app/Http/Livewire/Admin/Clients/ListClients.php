<?php

namespace App\Http\Livewire\Admin\Clients;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Client;
use App\Models\User;

class ListClients extends AdminComponent
{
    public $name, $mobile, $alternate_no, $gender, $email, $address, $country, $city, $state, $zip_code, $avatar_url, $reference_name, $reference_mobile, $status, $details, $created_at, $updated_at, $created_by, $updated_by;

    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $userId;

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

    public function show($id)
    {
        try {
            $user = User::query()
                ->with([
                    'clientInfo',
                    'countryInfo:id,name',
                    'createdByInfo:id,name',
                    'updatedByInfo:id,name'
                ])
                ->where('id', $id)
                ->where('role', 'client')
                ->first();

            $this->name = $user->name;
            $this->email = $user->email;
            $this->mobile = $user->mobile;
            $this->alternate_no = $user->alternate_no;
            $this->gender = ucfirst($user->gender);
            $this->address = $user->address;
            $this->country = $user->countryInfo->name;
            $this->city = $user->city;
            $this->state = $user->state;
            $this->zip_code = $user->zip_code;
            $this->avatar_url = $user->avatar_url;
            $this->reference_name = $user->clientInfo->reference_name;
            $this->reference_mobile = $user->clientInfo->reference_mobile;
            $this->details = $user->clientInfo->details;
            $this->created_at = $user->created_at ? $user->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $user->updated_at ? $user->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $user->createdByInfo ? $user->createdByInfo->name : 'N/A';
            $this->updated_by = $user->updatedByInfo ? $user->updatedByInfo->name : 'N/A';
            $this->status = $user->clientInfo->status == 1 ? 'Published' : 'Unpublished';

            $this->dispatchBrowserEvent('show-modal');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            return redirect()->route('admin.clients');
        }
    }

    public function destroy($userId)
    {
        $this->userId = $userId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = User::query()->findOrFail($this->userId);
            $data->delete();
            $this->dispatchBrowserEvent('success', ['message' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
        }
    }

    public function render()
    {
        $users = User::query()
            ->with([
                'clientInfo'
            ])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('mobile', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('email', 'like', '%' . $this->searchKeywords . '%');
            })
            ->where('role', 'client')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(10);
        return view('livewire.admin.clients.list-clients', [
            'users' => $users
        ]);
    }
}

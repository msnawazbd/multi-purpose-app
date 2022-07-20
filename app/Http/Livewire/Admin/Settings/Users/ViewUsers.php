<?php

namespace App\Http\Livewire\Admin\Settings\Users;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ViewUsers extends AdminComponent
{
    use WithFileUploads;

    public $state = [];
    public $role_state = [];
    public $permission_state = [];
    public $user;
    public $roles = [];
    public $permissions = [];
    public $userId;
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|string|unique:users',
            'password' => 'required|confirmed',
        ])->validate();

        /*$validateData['password'] = bcrypt($validateData['password']);
        $user = User::create($validateData);*/

        if ($this->photo) {
            $validateData['avatar'] = $this->photo->store('/', 'avatars');
        } else {
            $validateData['avatar'] = '';
        }

        try {
            User::query()
                ->create([
                    'name' => $this->state['name'],
                    'email' => $this->state['email'],
                    'mobile' => $this->state['mobile'],
                    'password' => bcrypt($this->state['password']),
                    'avatar' => $validateData['avatar']
                ]);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'User created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(User $user)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->user = $user;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'mobile' => 'required|string|unique:users,mobile,' . $this->user->id,
            'password' => 'sometimes|confirmed',
        ])->validate();

        if (!empty($this->state['password'])) {
            $validateData['password'] = bcrypt($this->state['password']);
        }

        if ($this->photo) {
            Storage::disk('avatars')->delete($this->user->avatar);
            $validateData['avatar'] = $this->photo->store('/', 'avatars');
        } else {
            $validateData['avatar'] = '';
        }

        try {
            $this->user->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'User updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function giveRole(User $user)
    {
        $this->user = $user;
        $this->roles = Role::all();
        $this->dispatchBrowserEvent('show-role-modal');
    }

    public function assignRole()
    {
        Validator::make($this->role_state, [
            'name' => 'required|string',
        ], [
            'name.required' => 'The role name field is required.',
        ])->validate();

        if ($this->user->hasRole($this->role_state['name'])) {
            $this->dispatchBrowserEvent('warning', ['message' => 'Role already assigned!']);
        } else {
            $this->user->assignRole($this->role_state['name']);
            $this->role_state['name'] = '';
            $this->dispatchBrowserEvent('success', ['message' => 'Role assign successfully!']);
        }
    }

    public function revokeRole(User $user, $role_name)
    {
        if ($user->hasRole($role_name)) {
            $user->removeRole($role_name);
            $this->dispatchBrowserEvent('success', ['message' => 'Role revoke successfully!']);
        } else {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
        }
    }

    public function givePermission(User $user)
    {
        $this->user = $user;
        $this->permissions = Permission::all();
        $this->dispatchBrowserEvent('show-permission-modal');
    }

    public function assignPermission()
    {
        Validator::make($this->permission_state, [
            'name' => 'required|string',
        ], [
            'name.required' => 'The permission name field is required.',
        ])->validate();

        if ($this->user->hasPermissionTo($this->permission_state['name'])) {
            $this->dispatchBrowserEvent('warning', ['message' => 'Permission already assigned!']);
        } else {
            $this->user->givePermissionTo($this->permission_state['name']);
            $this->permission_state['name'] = '';
            $this->dispatchBrowserEvent('success', ['message' => 'Permission assign successfully!']);
        }
    }

    public function revokePermission(User $user, $permission_name)
    {
        if ($user->hasPermissionTo($permission_name)) {
            $user->revokePermissionTo($permission_name);
            $this->dispatchBrowserEvent('success', ['message' => 'Permission revoke successfully!']);
        } else {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
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
            $this->dispatchBrowserEvent('deleted', ['message' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $users = User::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('email', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('mobile', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(5);

        return view('livewire.admin.settings.users.view-users', [
            'users' => $users
        ]);
    }
}

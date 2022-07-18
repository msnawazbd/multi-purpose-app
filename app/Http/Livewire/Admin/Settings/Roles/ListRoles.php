<?php

namespace App\Http\Livewire\Admin\Settings\Roles;

use App\Http\Livewire\Admin\AdminComponent;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ListRoles extends AdminComponent
{
    public $name, $guard_name, $status, $description, $created_at, $updated_at, $created_by, $updated_by;

    public $state = [];
    public $permission;
    public $role;
    public $roleId;
    public $showEditModal = false;
    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $permissions = [];

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
            'status' => 'required|numeric',
            'description' => 'nullable|string',
        ])->validate();

        Role::query()
            ->create([
                'name' => $this->state['name'],
                'status' => $this->state['status'],
                'description' => $this->state['description'],
                'created_by' => auth()->user()->id
            ]);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Role created successfully!']);
        return redirect()->back();

        try {
            Role::query()
                ->create([
                    'name' => $this->state['name'],
                    'status' => $this->state['status'],
                    'description' => $this->state['description'],
                    'created_by' => auth()->user()->id
                ]);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Role created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(Role $role)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->role = $role;
        $this->state = $role->toArray();
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'name' => 'required|string|max:100|min:4',
            'status' => 'required|numeric',
            'description' => 'nullable|string',
        ])->validate();

        $validateData['updated_by'] = auth()->user()->id;

        try {
            $this->role->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Role updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($roleId)
    {
        try {
            $role = Role::query()
                ->leftJoin('users as a', function ($join) {
                    $join->on('roles.created_by', 'a.id');
                })
                ->leftJoin('users as b', function ($join) {
                    $join->on('roles.updated_by', 'b.id');
                })
                ->where('roles.id', $roleId)
                ->first(['roles.*', 'a.name as created_by', 'b.name as updated_by']);

            $this->name = $role->name;
            $this->guard_name = $role->guard_name;
            $this->status = $role->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED';
            $this->description = $role->description;
            $this->created_at = $role->created_at ? $role->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $role->updated_at ? $role->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $role->created_by;
            $this->updated_by = $role->updated_by ? $role->updated_by : 'N/A';

            $this->dispatchBrowserEvent('show-view-modal');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            return redirect()->route('admin.tasks');
        }
    }

    public function givePermission(Role $role)
    {
        $this->role = $role;
        $this->permissions = Permission::all();
        $this->dispatchBrowserEvent('show-permission-modal');
    }

    public function assignPermission()
    {
        if ($this->role->hasPermissionTo($this->permission)) {
            $this->dispatchBrowserEvent('warning', ['message' => 'Permission already assigned!']);
        } else {
            $this->role->givePermissionTo($this->permission);
            $this->dispatchBrowserEvent('success', ['message' => 'Permission assign successfully!']);
        }
    }

    public function revokePermission(Role $role, $permission_name)
    {
        $role->revokePermissionTo($permission_name);
        $this->dispatchBrowserEvent('success', ['message' => 'Permission revoke successfully!']);

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

    public function changeStatus($roleId)
    {
        try {
            $role = Role::query()->findOrFail($roleId);
            $role->status = $role->status == 1 ? 0 : 1;
            $role->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Role status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($roleId)
    {
        $this->roleId = $roleId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Role::query()->findOrFail($this->roleId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Role deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $roles = Role::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('guard_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('description', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['id', 'name', 'guard_name', 'status', 'created_at'])
            ->paginate(5);

        return view('livewire.admin.settings.roles.list-roles', [
            'roles' => $roles
        ]);
    }
}

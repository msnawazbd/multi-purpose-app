<?php

namespace App\Http\Livewire\Admin\Settings\Permissions;

use App\Http\Livewire\Admin\AdminComponent;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ListPermissions extends AdminComponent
{
    public $name, $guard_name, $status, $description, $created_at, $updated_at, $created_by, $updated_by;

    public $state = [];
    public $role_state = [];
    public $permission;
    public $permissionId;
    public $showEditModal = false;
    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $roles = [];

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

        try {
            Permission::query()
                ->create([
                    'name' => $this->state['name'],
                    'status' => $this->state['status'],
                    'description' => $this->state['description'],
                    'created_by' => auth()->user()->id
                ]);

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Permission created successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function edit(Permission $permission)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->permission = $permission;
        $this->state = $permission->toArray();
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
            $this->permission->update($validateData);
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Permission updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($permissionId)
    {
        try {
            $permission = Permission::query()
                ->leftJoin('users as a', function ($join) {
                    $join->on('permissions.created_by', 'a.id');
                })
                ->leftJoin('users as b', function ($join) {
                    $join->on('permissions.updated_by', 'b.id');
                })
                ->where('permissions.id', $permissionId)
                ->first(['permissions.*', 'a.name as created_by', 'b.name as updated_by']);

            $this->name = $permission->name;
            $this->guard_name = $permission->guard_name;
            $this->status = $permission->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED';
            $this->description = $permission->description;
            $this->created_at = $permission->created_at ? $permission->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $permission->updated_at ? $permission->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $permission->created_by;
            $this->updated_by = $permission->updated_by ? $permission->updated_by : 'N/A';

            $this->dispatchBrowserEvent('show-view-modal');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            return redirect()->route('admin.tasks');
        }
    }

    public function giveRole(Permission $permission)
    {
        $this->permission = $permission;
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

        if ($this->permission->hasRole($this->role_state['name'])) {
            $this->dispatchBrowserEvent('warning', ['message' => 'Role already assigned!']);
        } else {
            $this->permission->assignRole($this->role_state['name']);
            $this->role_state['name'] = '';
            $this->dispatchBrowserEvent('success', ['message' => 'Role assign successfully!']);
        }
    }

    public function revokeRole(Permission $permission, $role_name)
    {
        if ($permission->hasRole($role_name)) {
            $permission->removeRole($role_name);
            $this->dispatchBrowserEvent('success', ['message' => 'Role revoke successfully!']);
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

    public function changeStatus($permissionId)
    {
        try {
            $permission = Permission::query()->findOrFail($permissionId);
            $permission->status = $permission->status == 1 ? 0 : 1;
            $permission->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Permission status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($permissionId)
    {
        $this->permissionId = $permissionId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Permission::query()->findOrFail($this->permissionId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Permission deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $permissions = Permission::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('guard_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('description', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['id', 'name', 'guard_name', 'status', 'created_at'])
            ->paginate(5);

        return view('livewire.admin.settings.permissions.list-permissions', [
            'permissions' => $permissions
        ]);
    }
}

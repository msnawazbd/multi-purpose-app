<?php

namespace App\Http\Livewire\Admin\Users;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

class ListUsers extends AdminComponent
{
    use WithFileUploads;

    public $state = [];
    public $user;
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

    public function changeRole(User $user, $role)
    {
        Validator::make(['role' => $role], [
            // 'role' => 'required|in:admin,user'
            'role' => [
                'required',
                Rule::in(User::ROLE_ADMIN, User::ROLE_USER)
            ]
        ])->validate();

        try {
            $user->update(['role' => $role]);
            $this->dispatchBrowserEvent('success', ['message' => "User role change to {$role} successfully!"]);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
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

        return view('livewire.admin.users.list-users', [
            'users' => $users
        ]);
    }
}

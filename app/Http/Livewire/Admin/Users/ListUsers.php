<?php

namespace App\Http\Livewire\Admin\Users;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ListUsers extends AdminComponent
{
    public $state = [];
    public $user;
    public $userId;
    public $showEditModal = false;
    public $searchKeywords = null;

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function create()
    {
        $this->showEditModal = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $validateData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ])->validate();

        /*$validateData['password'] = bcrypt($validateData['password']);
        $user = User::create($validateData);*/

        $user = User::query()
            ->create([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'password' => bcrypt($this->state['password']),
            ]);

        $this->dispatchBrowserEvent('hide-form', ['message' => 'User created successfully!']);

        return redirect()->back();
    }

    public function edit(User $user)
    {
        $this->showEditModal = true;
        $this->user = $user;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|confirmed',
        ])->validate();

        if (!empty($this->state['password'])) {
            $validateData['password'] = bcrypt($this->state['password']);
        }

        $this->user->update($validateData);

        $this->dispatchBrowserEvent('hide-form', ['message' => 'User updated successfully!']);

        return redirect()->back();
    }

    public function destroy($userId)
    {
        $this->userId = $userId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        $data = User::query()->findOrFail($this->userId);
        $data->delete();

        $this->dispatchBrowserEvent('deleted', ['message' => 'User deleted successfully.']);
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->searchKeywords . '%')
            ->orWhere('email', 'like', '%' . $this->searchKeywords . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.admin.users.list-users', [
            'users' => $users
        ]);
    }
}

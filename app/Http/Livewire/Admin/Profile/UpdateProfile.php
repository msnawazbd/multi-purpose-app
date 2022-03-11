<?php

namespace App\Http\Livewire\Admin\Profile;

use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $image;
    public $state = [];

    public function mount()
    {
        $this->state = auth()->user()->only(['name', 'email']);
    }

    public function updateProfile(UpdateUserProfileInformation $updater)
    {
        $updater->update(auth()->user(), [
            'name' => $this->state['name'],
            'email' => $this->state['email']
        ]);

        $this->emit('nameChanged', auth()->user()->name);

        $this->dispatchBrowserEvent('updated', ['message' => 'Profile update successfully.']);
    }

    public function changePassword(UpdatesUserPasswords $updater)
    {
        /*$updater->update(auth()->user(), [
            'current_password' => $this->state['current_password'] ?? '',
            'password' => $this->state['password'] ?? '',
            'password_confirmation' => $this->state['password_confirmation'] ?? '',
        ]);*/

        $updater->update(
            auth()->user(),
            $attributes = Arr::only($this->state, ['current_password', 'password', 'password_confirmation'])
        );

        // collect($attributes)->map(fn ($value, $key) => $this->state[$key] = '');

        collect($attributes)->map(function ($value, $key) {
            $this->state[$key] = '';
        });

        $this->dispatchBrowserEvent('updated', ['message' => 'Password changed successfully.']);
    }

    public function updatedImage()
    {
        $path = $this->image->store('/', 'avatars');

        if (auth()->user()->avatar) {
            Storage::disk('avatars')->delete(auth()->user()->avatar);
        }
        auth()->user()->update(['avatar' => $path]);

        $this->dispatchBrowserEvent('updated', ['message' => 'Profile change successfully!']);
    }

    public function render()
    {
        return view('livewire.admin.profile.update-profile');
    }
}

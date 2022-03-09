<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UpdateSetting extends Component
{
    public $state = [];

    public function mount()
    {
        $setting = Setting::query()->first();

        if ($setting) {
            $this->state = $setting->toArray();
        }
    }

    public function updateSetting()
    {
        $setting = Setting::query()->first();
        if ($setting) {
            $setting->update($this->state);
        } else {
            Setting::query()->create($this->state);
        }

        Cache::forget('setting');

        $this->dispatchBrowserEvent('updated', ['message' => 'Setting update successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.settings.update-setting');
    }
}

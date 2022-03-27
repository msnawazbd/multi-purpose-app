<?php

namespace App\Http\Livewire\Admin\Clients;

use App\Models\Country;
use Livewire\Component;

class CreateClient extends Component
{
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

<?php

namespace App\Http\Livewire\Web\Contact;

use Livewire\Component;

class ContactUs extends Component
{
    public function render()
    {
        return view('livewire.web.contact.contact-us')->layout('layouts.web-app');
    }
}

<?php

namespace App\Http\Livewire\Admin\Plans;

use App\Models\Directory\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditPlan extends Component
{
    public $state = [];

    public $plan;

    public function mount(Plan $plan)
    {
        $this->state = $plan->toArray();
        $this->plan = $plan;
    }

    public function update()
    {
        $validateData = Validator::make($this->state, [
            'title' => 'required|string|max:50',
            'original_price' => 'required|numeric',
            'discounted_price' => 'required|numeric',
            'validity' => 'required|numeric',
            'listings' => 'required|numeric',
            'categories' => 'required|numeric',
            'photos' => 'required|numeric',
            'videos' => 'required|numeric',
            'tags' => 'required|numeric',
            'amenities' => 'required|numeric',
            'products' => 'required|numeric',
            'services' => 'required|numeric',
            'articles' => 'required|numeric',
            'featured_listings' => 'required|numeric',
            'contact_form' => 'required|numeric',
            'social_items' => 'required|numeric',
            'status' => 'required|numeric',
        ])->validate();

        $validateData['updated_by'] = Auth::user()->id;

        try {
            $this->plan->update($validateData);
            $this->dispatchBrowserEvent('success', ['message' => 'Plan updated successfully.']);
            return redirect()->route('admin.plans');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.admin.plans.edit-plan');
    }
}

<?php

namespace App\Http\Livewire\Admin\Plans;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Directory\Plan;

class ListPlans extends AdminComponent
{
    public $searchKeywords = null;
    public $planId;

    protected $queryString = ['searchKeywords' => ['except' => '']];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSearchKeywords()
    {
        $this->resetPage();
    }

    public function changeStatus($planId)
    {
        try {
            $plan = Plan::query()->findOrFail($planId);
            $plan->status = $plan->status == 1 ? 0 : 1;
            $plan->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Plan status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function destroy($planId)
    {
        $this->planId = $planId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Plan::query()->findOrFail($this->planId);
            $data->delete();
            $this->dispatchBrowserEvent('success', ['message' => 'Plan deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
        }
    }

    public function render()
    {
        $plans = Plan::query()
            ->with([
                'createdBy:id,name'
            ])
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('discounted_price', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('validity', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy('discounted_price')
            ->get();
        return view('livewire.admin.plans.list-plans', [
            'plans' => $plans
        ]);
    }
}

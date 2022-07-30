<?php

namespace App\Http\Livewire\Admin\Prices;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Directory\Price;

class ListPrices extends AdminComponent
{
    public $searchKeywords = null;
    public $priceId;

    protected $queryString = ['searchKeywords' => ['except' => '']];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSearchKeywords()
    {
        $this->resetPage();
    }

    public function destroy($priceId)
    {
        $this->priceId = $priceId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Price::query()->findOrFail($this->priceId);
            $data->delete();
            $this->dispatchBrowserEvent('success', ['message' => 'Pricing deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
        }
    }

    public function render()
    {
        $prices = Price::query()
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
        return view('livewire.admin.prices.list-prices', [
            'prices' => $prices
        ]);
    }
}

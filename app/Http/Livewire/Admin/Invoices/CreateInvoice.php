<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class CreateInvoice extends Component
{
    public $items = [
        [
            'service_id' => '',
            'description' => '',
            'qty' => 1,
            'rate' => 0,
            'amount' => 0
        ]
    ];

    public function addItem()
    {
        $item = array(
            'service_id' => '',
            'description' => '',
            'qty' => 1,
            'rate' => 0,
            'amount' => 0
        );

        $this->items[] = $item;
    }

    public function removeItem($key)
    {
        unset($this->items[$key]);
        $this->items = array_values($this->items);
    }

    public function create()
    {
        dd($this->items);
    }

    public function render()
    {
        $invoice = Invoice::query()
            ->with([
                'client',
                'invoiceDetails',
                'invoiceDetails.service',
                'tax'
            ])
            ->where('id', 1)
            ->first();

        return view('livewire.admin.invoices.create-invoice', [
            'invoice' => $invoice
        ]);
    }
}

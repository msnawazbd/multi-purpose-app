<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class ViewInvoice extends Component
{
    public $invoice;

    public function mount($id)
    {
        $invoice = Invoice::query()
            ->with([
                'client',
                'invoiceDetails',
                'invoiceDetails.service',
                'tax'
            ])
            ->where('id', $id)
            ->first();

        if ($invoice) {
            $this->invoice = $invoice;
        } else {
            return redirect()->route('admin.income.invoices');
        }
    }

    public function render()
    {
        return view('livewire.admin.invoices.view-invoice', [
            'invoices' => $this->invoice
        ]);
    }
}

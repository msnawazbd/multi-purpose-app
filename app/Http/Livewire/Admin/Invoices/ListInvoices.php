<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class ListInvoices extends Component
{
    public function render()
    {
        $invoices = Invoice::query()
            ->with([
                'client'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.admin.invoices.list-invoices', [
            'invoices' => $invoices
        ]);
    }
}

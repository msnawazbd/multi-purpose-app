<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class ListInvoices extends Component
{
    public $status = null;

    public function render()
    {
        $invoicesCount = Invoice::query()->count();
        $paidInvoicesCount = Invoice::query()->where('status', 1)->count();
        $partialPaidInvoicesCount = Invoice::query()->where('status', 2)->count();
        $dueInvoicesCount = Invoice::query()->where('status', 3)->count();

        $invoices = Invoice::query()
            ->with([
                'client'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.admin.invoices.list-invoices', [
            'invoicesCount' => $invoicesCount,
            'paidInvoicesCount' => $paidInvoicesCount,
            'partialPaidInvoicesCount' => $partialPaidInvoicesCount,
            'dueInvoicesCount' => $dueInvoicesCount,
            'invoices' => $invoices,
        ]);
    }
}

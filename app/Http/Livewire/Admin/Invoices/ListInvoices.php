<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Invoice;

class ListInvoices extends AdminComponent
{
    public $status = null;
    public $searchKeywords = null;

    protected $queryString = [
        'status',
        'searchKeywords' => ['except' => '']
    ];

    public function filterByStatus($status = null)
    {
        $this->resetPage();
        $this->status = $status;
    }

    public function getInvoicesProperty()
    {
        return Invoice::query()
            ->with([
                'client'
            ])
            ->when($this->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->where(function ($query) {
                $query->where('invoice_no', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('description', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function render()
    {
        $invoicesCount = Invoice::query()->count();
        $paidInvoicesCount = Invoice::query()->where('status', 1)->count();
        $partialPaidInvoicesCount = Invoice::query()->where('status', 2)->count();
        $dueInvoicesCount = Invoice::query()->where('status', 3)->count();

        return view('livewire.admin.invoices.list-invoices', [
            'invoicesCount' => $invoicesCount,
            'paidInvoicesCount' => $paidInvoicesCount,
            'partialPaidInvoicesCount' => $partialPaidInvoicesCount,
            'dueInvoicesCount' => $dueInvoicesCount,
            'invoices' => $this->invoices,
        ]);
    }
}

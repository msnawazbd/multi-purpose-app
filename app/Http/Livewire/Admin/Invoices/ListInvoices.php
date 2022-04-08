<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Invoice;

class ListInvoices extends AdminComponent
{
    public $invoiceId;
    public $status = null;
    public $searchKeywords = null;

    protected $queryString = [
        'status',
        'searchKeywords' => ['except' => '']
    ];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function filterByStatus($status = null)
    {
        $this->resetPage();
        $this->status = $status;
    }

    public function destroy($invoiceId)
    {
        $this->invoiceId = $invoiceId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Invoice::query()->findOrFail($this->invoiceId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Invoice deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
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

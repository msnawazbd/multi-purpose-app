<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use App\Models\Invoice;

class ListInvoices extends AdminComponent
{
    public $state = [];
    public $invoiceId;
    public $status = null;
    public $searchKeywords = null;
    public $paymentList = [];

    protected $queryString = [
        'status',
        'searchKeywords' => ['except' => '']
    ];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function paymentReceive($id)
    {
        $this->reset();
        $this->invoiceId = $id;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function paymentStore()
    {
        Validator::make($this->state, [
            'amount' => 'required|numeric',
            'receiving_date' => 'required|date',
            'reference_number' => 'required|string',
            'payment_method' => 'required|numeric',
            'note' => 'required|string',
        ])->validate();

        try {
            Payment::query()
                ->create([
                    'invoice_id' => $this->invoiceId,
                    'amount' => $this->state['amount'],
                    'receiving_date' => $this->state['receiving_date'],
                    'reference_number' => $this->state['reference_number'],
                    'payment_method' => $this->state['payment_method'],
                    'note' => $this->state['note'],
                    'created_by' => auth()->user()->id
                ]);

            $invoice = Invoice::query()->where('id', $this->invoiceId)->first();
            $invoice->paid += $this->state['amount'];
            $invoice->due -= $this->state['amount'];
            if ($invoice->due <= 0) {
                $invoice->status = 1;
            } else {
                $invoice->status = 2;
            }
            $invoice->update();

            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Payment received successfully!']);
            return redirect()->route('admin.income.invoices');
        } catch (\Exception $e) {
            dd($e);
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function paymentHistory($id)
    {
        $this->paymentList = Payment::query()
            ->with([
                'invoice'
            ])
            ->where('invoice_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();

        $this->dispatchBrowserEvent('show-view-modal');
    }

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

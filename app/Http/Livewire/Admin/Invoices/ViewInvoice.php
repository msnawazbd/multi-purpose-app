<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ViewInvoice extends Component
{
    public $state = [];
    public $invoice;
    public $invoiceId;
    public $paymentList = [];

    public function mount($id)
    {
        $this->invoiceId = $id;
    }

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
            return redirect()->route('admin.income.invoices.view', $this->invoiceId);
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

    public function render()
    {
        $invoice = Invoice::query()
            ->with([
                'client',
                'invoiceDetails',
                'invoiceDetails.service',
                'tax'
            ])
            ->where('id', $this->invoiceId)
            ->first();

        if ($invoice) {
            $this->invoice = $invoice;
        } else {
            return redirect()->route('admin.income.invoices');
        }

        return view('livewire.admin.invoices.view-invoice', [
            'invoices' => $this->invoice
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function print($id)
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

        return view('admin.invoices.print-invoice', [
            'invoice' => $invoice
        ]);
    }

    public function pdf($id)
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
        $pdf = PDF::loadView('admin.invoices.pdf-invoice', compact('invoice'));
        $file_name = $invoice->invoice_no . '.pdf';
        return $pdf->download($file_name);
    }
}

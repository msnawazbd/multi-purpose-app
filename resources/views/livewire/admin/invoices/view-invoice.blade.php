<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Invoices</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.income.invoices') }}">Invoices</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="invoice p-3 mb-3">

                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> {{ setting('site_name') }}
                                    <small class="float-right">Date: {{ now()->toFormattedDate() }}</small>
                                </h4>
                            </div>

                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>{{ setting('site_name') }}</strong><br>
                                    {{ setting('address') }}, {{ setting('state') }}<br>
                                    {{ setting('city') }}, {{ setting('zip_code') }}, {{ setting('country') }}<br>
                                    Phone: {{ setting('site_phone') }}<br>
                                    Email: {{ setting('site_email') }}
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{ $invoice->client->user->name }}</strong><br>
                                    {{ $invoice->client->user->address }}, {{ $invoice->client->user->state }}<br>
                                    {{ $invoice->client->user->city }}, {{ $invoice->client->user->zip_code }}, {{ ucwords($invoice->client->user->country->name) }}<br>
                                    Phone: {{ $invoice->client->user->mobile }}<br>
                                    Email: {{ $invoice->client->user->email }}
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>Invoice No #{{ $invoice->invoice_no }}</b><br>
                                <br>
                                <b>Invoice Date:</b> {{ $invoice->invoice_date->toFormattedDate() }}<br>
                                <b>Invoice Due Date:</b> {{ $invoice->invoice_due_date->toFormattedDate() }}<br>
                                <b>Invoice Due:</b> {{ toFormattedNumber($invoice->due, 2) }}<br>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right">Rate</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice->invoiceDetails as $key => $details)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $details->service->name }}</td>
                                        <td class="text-right">{{ $details->quantity }}</td>
                                        <td class="text-right">{{ $details->amount }}</td>
                                        <td class="text-right">{{ $details->amount * $details->quantity }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-8">
                                <p class="lead">Note:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">{{ $invoice->description }}</p>
                            </div>

                            <div class="col-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody><tr>
                                            <th class="text-left" style="width:50%">Subtotal:</th>
                                            <td class="text-right">{{ toFormattedNumber($invoice->sub_total, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Tax ({{ $invoice->tax ? $invoice->tax->rate : 0 }}%):</th>
                                            <td class="text-right">{{ toFormattedNumber($invoice->tax_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Total:</th>
                                            <td class="text-right">{{ toFormattedNumber($invoice->total, 2) }}</td>
                                        </tr>
                                        @if($invoice->discount_amount)
                                        <tr>
                                            <th class="text-left">Discount:</th>
                                            <td class="text-right">{{ toFormattedNumber($invoice->discount_amount, 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th class="text-left">Net Total:</th>
                                            <td class="text-right">{{ toFormattedNumber($invoice->net_total, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Paid Amount:</th>
                                            <td class="text-right">{{ toFormattedNumber($invoice->paid, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Due Amount:</th>
                                            <td class="text-right">{{ toFormattedNumber($invoice->due, 2) }}</td>
                                        </tr>
                                        </tbody></table>
                                </div>
                            </div>

                        </div>


                        <div class="row no-print">
                            <div class="col-12">
                                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                    Payment
                                </button>
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

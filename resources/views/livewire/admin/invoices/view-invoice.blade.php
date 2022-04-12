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
                                    {{ $invoice->client->user->city }}, {{ $invoice->client->user->zip_code }}
                                    , {{ ucwords($invoice->client->user->country->name) }}<br>
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
                                <p class="text-muted well well-sm shadow-none"
                                   style="margin-top: 10px;">{{ $invoice->description }}</p>
                            </div>

                            <div class="col-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="text-left" style="width:50%">Subtotal:</th>
                                            <td class="text-right">{{ toFormattedNumber($invoice->sub_total, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Tax ({{ $invoice->tax ? $invoice->tax->rate : 0 }}
                                                %):
                                            </th>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>


                        <div class="row no-print">
                            <div class="col-12">
                                <div class="btn-group">
                                    <a href="{{ route('admin.income.invoices') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                    <a href="{{ route('admin.income.invoices.print', $invoice->id) }}" target="_blank"
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                    @if($invoice->due > 0)
                                        <button type="button" wire:click="paymentReceive({{ $invoice->id }})"
                                                class="btn btn-outline-primary ">
                                            <i class="fas fa-dollar-sign"></i> Payment Receive
                                        </button>
                                    @endif
                                    <button type="button" wire:click="paymentHistory({{ $invoice->id }})"
                                            class="btn btn-outline-primary ">
                                        <i class="fas fa-history"></i> Payment History
                                    </button>
                                    <a href="{{ route('admin.income.invoices.pdf', $invoice->id) }}"
                                       class="btn btn-outline-primary ">
                                        <i class="fas fa-file"></i> Generate PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Receive</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form autocomplete="off" wire:submit.prevent="paymentStore">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount">Amount <span class="text-danger">*</span></label>
                            <input type="number" wire:model.defer="state.amount"
                                   class="form-control @error('amount') is-invalid @enderror" id="amount"
                                   placeholder="">
                            @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="receiving_date">Receiving Date<span
                                    class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-calendar"></i></span>
                                </div>
                                <x-datepicker wire:model.defer="state.receiving_date" id="receiving_date"
                                              :error="'receiving_date'" :placeholder="''"/>
                                @error('receiving_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                            <select wire:model.defer="state.payment_method"
                                    class="form-control @error('payment_method') is-invalid @enderror"
                                    id="payment_method">
                                <option value="">Select One</option>
                                <option value="1">CASH</option>
                                <option value="2">BANK</option>
                            </select>
                            @error('payment_method')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="reference_number">Reference Number <span class="text-danger">*</span></label>
                            <input type="text" wire:model.defer="state.reference_number"
                                   class="form-control @error('reference_number') is-invalid @enderror"
                                   id="reference_number"
                                   placeholder="">
                            @error('reference_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="note">Note<span
                                    class="text-danger">*</span></label>
                            <textarea wire:model.defer="state.note"
                                      class="form-control @error('note') is-invalid @enderror" id="note"
                                      placeholder=""></textarea>
                            @error('nonotete')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-dollar-sign"></i>
                            <span> Add Payment</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        Payment History
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>#</th>
                            <th>Invoice No</th>
                            <th>Amount</th>
                            <th>Receiving Date</th>
                            <th>Payment Date</th>
                            <th>Reference Number</th>
                        </tr>
                        @forelse($paymentList as $index => $payment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $payment['invoice']['invoice_no'] }}</td>
                                <td>{{ $payment['amount'] }}</td>
                                <td>{{ $payment['receiving_date'] }}</td>
                                <td>{{ $payment['created_at'] }}</td>
                                <td>{{ $payment['reference_number'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
    <!-- Bootstrap DateTime Picker -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush

@push('js')
    <script type="text/javascript" src="https://unpkg.com/moment"></script>
    <!-- Bootstrap DateTime Picker -->
    <script type="text/javascript"
            src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@endpush

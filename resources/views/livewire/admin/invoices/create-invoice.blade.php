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

                        <div class="row invoice-info mb-2">
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
                                Billed To
                                <div class="form-group">
                                    <select id="status" wire:model.defer="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                        <option value="" selected>Select one</option>
                                        <option value="1">Published</option>
                                        <option value="0">Unpublished</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
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
                                <p><b>Invoice Date:</b></p>
                                <div class="input-group mb-2">
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
                                <p><b>Invoice Due Date:</b></p>
                                <div class="input-group">
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

                        </div>


                        <div class="row">
                            <div class="col-12 table-responsive">
                                <form wire:submit.prevent="create" autocomplete="off">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service</th>
                                        <th class="text-right">Description</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right">Rate</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <select id="service-id-{{ $key }}" wire:model.defer="items.{{ $key }}.service_id" wire:change.prevent="selectService({{ $key }})"
                                                        class="form-control">
                                                    <option value="" selected>Select one</option>
                                                    @foreach($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="text-right">
                                                <input type="text" wire:model.defer="items.{{ $key }}.description"
                                                       class="form-control"
                                                       id="description-{{ $key }}">
                                            </td>
                                            <td class="text-right">
                                                <input type="text" wire:model.defer="items.{{ $key }}.qty"
                                                       class="form-control"
                                                       id="qty-{{ $key + 1 }}">
                                            </td>
                                            <td class="text-right">
                                                <input type="text" wire:model.defer="items.{{ $key }}.rate"
                                                       class="form-control"
                                                       id="rate-{{ $key }}">
                                            </td>
                                            <td class="text-right">
                                                <input type="text" value="{{ $items[$key]['qty'] * $items[$key]['rate'] }}"
                                                       class="form-control"
                                                       id="amount-{{ $key }}" disabled>
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-danger btn-sm" wire:click.prevent="removeItem({{ $key }})"><span class="fa fa-trash"></span></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <button class="btn btn-primary btn-sm" wire:click.prevent="addItem"><span class="fa fa-plus"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <button class="btn btn-primary btn-sm"><span class="fa fa-save"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                </form>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-8">
                                <p class="lead">Note:</p>
                                <div wire:ignore class="form-group">
                                    <textarea id="details" data-details="@this" wire:model.defer="details"
                                              class="form-control @error('details') is-invalid @enderror"
                                              rows="6"></textarea>
                                    @error('details')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
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
                                            <th class="text-left">
                                                <select id="status" wire:model.defer="status"
                                                        class="form-control @error('status') is-invalid @enderror">
                                                    <option value="" selected>Select one</option>
                                                    <option value="1">Published</option>
                                                    <option value="0">Unpublished</option>
                                                </select>
                                                @error('status')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
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

                    </div>

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

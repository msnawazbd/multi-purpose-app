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
                        <li class="breadcrumb-item active">Invoices</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-12 -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.income.invoices.create') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-plus"></i>
                                    &nbsp; Add New Invoice
                                </a>

                                <div class="btn-group btn-group-sm">
                                    <button wire:click="filterByStatus" type="button"
                                            class="btn {{ is_null($status) ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">All</span>
                                        <span class="badge badge-pill badge-info">{{ $invoicesCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus(1)" type="button"
                                            class="btn {{ ($status === 1) ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">Paid</span>
                                        <span class="badge badge-pill badge-success">{{ $paidInvoicesCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus(2)" type="button"
                                            class="btn {{ ($status === 2) ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">Partial Paid</span>
                                        <span
                                            class="badge badge-pill badge-primary">{{ $partialPaidInvoicesCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus(3)" type="button"
                                            class="btn {{ ($status === 3) ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">Due</span>
                                        <span class="badge badge-pill badge-warning">{{ $dueInvoicesCount }}</span>
                                    </button>
                                </div>

                                <x-search-input wire:model="searchKeywords"/>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Invoice No.</th>
                                    <th>Client Name</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Created at</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($invoices as $key => $invoice)
                                    <tr>
                                        <td class="align-middle">{{ $invoices->firstItem() + $key }}</td>
                                        <td class="align-middle">{{ $invoice->invoice_no }}</td>
                                        <td class="align-middle">{{ $invoice->client->user->name }}</td>
                                        <td class="align-middle">{{ $invoice->total }}</td>
                                        <td class="align-middle">{{ $invoice->paid }}</td>
                                        <td class="align-middle">{{ $invoice->due }}</td>
                                        <td class="align-middle">
                                            {{ $invoice->created_at ? $invoice->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-{{ $invoice->status_badge }}">
                                                {{ $invoice->status_name }}
                                            </span>
                                        </td>
                                        <td class="text-right align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-default">Options</button>
                                                <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu" style="">
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.income.invoices.view', $invoice->id) }}"><i
                                                            class="fas fa-eye mr-2"></i> View</a>
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.income.invoices.edit', $invoice) }}"><i
                                                            class="fas fa-edit mr-2"></i> Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.income.invoices.print', $invoice->id) }}"
                                                       target="_blank"><i class="fas fa-print mr-2"></i> Print</a>
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.income.invoices.pdf', $invoice->id) }}"><i
                                                            class="fas fa-file-pdf mr-2"></i> PDF</a>
                                                    <div class="dropdown-divider"></div>
                                                    @if($invoice->due > 0)
                                                    <button class="dropdown-item"
                                                            wire:click="paymentReceive({{ $invoice->id }})"><i
                                                            class="fas fa-dollar-sign mr-2"></i> Payment Receive
                                                    </button>
                                                    @endif
                                                    <button class="dropdown-item"
                                                            wire:click="paymentHistory({{ $invoice->id }})"><i
                                                            class="fas fa-history mr-2"></i> Payment History
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="destroy({{ $invoice->id }})"><i
                                                            class="fas fa-trash mr-2"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            No result found !
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

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

    <!-- confirmation-alert components -->
    <x-confirmation-alert/>

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

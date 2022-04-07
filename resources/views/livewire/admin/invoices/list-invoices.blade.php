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
                                <a href="{{ route('admin.clients.create') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-plus"></i>
                                    &nbsp; Add New Invoice
                                </a>

                                <div class="btn-group">
                                    <button wire:click="filterByStatus" type="button"
                                            class="btn {{ is_null($status) ? 'btn-secondary' : 'btn-default' }} btn-sm">
                                        <span class="mr-1">All</span>
                                        <span class="badge badge-pill badge-info">{{ $invoicesCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus('scheduled')" type="button"
                                            class="btn {{ ($status === 'scheduled') ? 'btn-secondary' : 'btn-default' }} btn-sm">
                                        <span class="mr-1">Paid</span>
                                        <span class="badge badge-pill badge-success">{{ $paidInvoicesCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus('closed')" type="button"
                                            class="btn {{ ($status === 'closed') ? 'btn-secondary' : 'btn-default' }} btn-sm">
                                        <span class="mr-1">Partial Paid</span>
                                        <span class="badge badge-pill badge-primary">{{ $partialPaidInvoicesCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus('closed')" type="button"
                                            class="btn {{ ($status === 'closed') ? 'btn-secondary' : 'btn-default' }} btn-sm">
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
                                        <td>{{ $invoices->firstItem() + $key }}</td>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ $invoice->client->user->name }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>{{ $invoice->paid }}</td>
                                        <td>{{ $invoice->due }}</td>
                                        <td>
                                            {{ $invoice->created_at ? $invoice->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $invoice->status_badge }}">
                                                {{ $invoice->status_name }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm">Options</button>
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu" style="">
                                                    <a class="dropdown-item" href="{{ route('admin.income.invoices.view', $invoice->id) }}"><i class="fas fa-eye mr-2"></i> View</a>
                                                    <a class="dropdown-item" href="{{ route('admin.clients.edit', $invoice->id) }}"><i class="fas fa-edit mr-2"></i> Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item" wire:click.prevent="destroy({{ $invoice->id }})"><i class="fas fa-trash mr-2"></i> Delete</button>
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

    <!-- confirmation-alert components -->
    <x-confirmation-alert/>

</div>

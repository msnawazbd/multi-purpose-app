<div>
    <x-loading-indicator/>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Messages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Messages</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-12 -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if($selectedRows)
                                        <div class="btn-group ml-2">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <a wire:click.prevent="deleteSelectedRows" class="dropdown-item"
                                                   href="#">Delete Selected</a>
                                                <a wire:click.prevent="markAllAsPending" class="dropdown-item"
                                                   href="#">Mark as Pending</a>
                                                <a wire:click.prevent="markAllAsConfirmed" class="dropdown-item"
                                                   href="#">Mark
                                                    as Confirmed</a>
                                                <a wire:click.prevent="export" class="dropdown-item"
                                                   href="#">Export</a>
                                            </div>
                                        </div>
                                        <span
                                            class="ml-2">Selected {{ count($selectedRows) }} {{ Str::plural('message', count($selectedRows)) }}</span>
                                    @endif
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button wire:click="filterByStatus" type="button"
                                            class="btn {{ is_null($status) ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">All</span>
                                        <span class="badge badge-pill badge-info">{{ $messagesCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus('pending')" type="button"
                                            class="btn {{ ($status === 'pending') ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">Pending</span>
                                        <span class="badge badge-pill badge-warning">{{ $pendingMessagesCount }}</span>
                                    </button>

                                    <button wire:click="filterByStatus('confirmed')" type="button"
                                            class="btn {{ ($status === 'confirmed') ? 'btn-secondary' : 'btn-default' }}">
                                        <span class="mr-1">Confirmed</span>
                                        <span class="badge badge-pill badge-success">{{ $confirmedMessagesCount }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="icheck-primary d-inline ml-2">
                                            <input wire:model="selectPageRows" type="checkbox" value="" name="todo2"
                                                   id="todoCheck2" checked="">
                                            <label for="todoCheck2"></label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Transaction</th>
                                    <th>Receiver</th>
                                    <th>Sender</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:sortable="updateMessageOrder">
                                @foreach($messages as $key => $message)
                                    <tr wire:sortable.item="{{ $message->id }}" wire:key="message-{{ $message->id }}">
                                        <td class="align-middle">
                                            <div class="icheck-primary d-inline ml-2">
                                                <input wire:model="selectedRows" type="checkbox"
                                                       value="{{ $message->id }}" name="todo2"
                                                       id="{{ $message->id }}">
                                                <label for="{{ $message->id }}"></label>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ $messages->firstItem() + $key }}</td>
                                        <td class="align-middle">
                                            <img src="{{ asset('backend/img/' . $message->title_image) }}" class="img img-rounded mr-1" width="30" alt="{{ $message->android_title }}">
                                        </td>
                                        <td class="align-middle">{{ $message->transaction_id }}</td>
                                        <td class="align-middle">{{ $message->msg_from }}</td>
                                        <td class="align-middle">
                                            @php
                                                    $data = preg_split("/[\s:]+/", $message->android_text);
                                                    //echo '<pre>';
                                                    //echo print_r($data);
                                                    echo $data[7];
                                            @endphp
                                        </td>
                                        <td class="align-middle">
                                            {{ $data[5] }}
                                        </td>
                                        <td class="align-middle">{{ $message->created_at->toFormattedDate() }}</td>
                                        <td class="align-middle">{{ $message->created_at->toFormattedTime() }}</td>
                                        <td class="align-middle">
                                            <span class="badge badge-{{ $message->status_badge }}">
                                                {{ $message->status }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-default">Options</button>
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button class="dropdown-item" wire:click.prevent="changeStatus({{ $message->id }})"><i class="fas fa-eye{{ $message->status == 'CONFIRMED' ? '-slash' : '' }} mr-2"></i> View</button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item" wire:click.prevent="destroy({{ $message->id }})"><i class="fas fa-trash mr-2"></i> Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            {{ $messages->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<!-- confirmation-alert components -->
<x-confirmation-alert/>

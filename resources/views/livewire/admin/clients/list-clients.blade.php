<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Clients</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Clients</li>
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
                                <button class="btn btn-primary btn-sm" wire:click="create"><i
                                        class="fas fa-plus"></i>
                                    &nbsp; Add New Client
                                </button>
                                <x-search-input wire:model="searchKeywords"/>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>
                                        Client Name
                                        <span wire:click="sortBy('name')" class="float-right text-sm" style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>
                                        Email
                                        <span wire:click="sortBy('email')" class="float-right text-sm" style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'email' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'email' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>Mobile</th>
                                    <th>
                                        Registered At
                                        <span wire:click="sortBy('created_at')" class="float-right text-sm" style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'created_at' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'created_at' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($clients as $key => $client)
                                    <tr>
                                        <td>{{ $clients->firstItem() + $key }}</td>
                                        <td>
                                            {{ $client->full_name }}
                                        </td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->mobile }}</td>
                                        <td>
                                            {{ $client->created_at ? $client->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" wire:click.prevent="edit({{ $client }})"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                            <button type="button" wire:click.prevent="destroy({{ $client->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
                            {{ $clients->links() }}
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

<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Testimonials</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Testimonials</li>
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
                            <div class="d-flex justify-content-end">
                                <x-search-input wire:model="searchKeywords"/>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Testimonial By</th>
                                    <th>
                                        Message
                                        <span wire:click="sortBy('message')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'message' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'message' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>Created At</th>
                                    <th>
                                        Status
                                        <span wire:click="sortBy('status')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'status' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'status' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($testimonials as $key => $testimonial)
                                    <tr>
                                        <td class="align-middle">{{ $testimonials->firstItem() + $key }}</td>
                                        <td class="align-middle">
                                            <img src="{{ $testimonial->createdBy->avatar_url  }}"
                                                 class="img img-circle mr-1"
                                                 width="30" alt="{{ $testimonial->createdBy->name }}">
                                            {{ $testimonial->createdBy->name }}
                                        </td>
                                        <td class="align-middle">
                                            {{ \Str::words($testimonial->message, 10, '...') }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $testimonial->created_at ? $testimonial->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td class="align-middle">
                                            <span
                                                class="badge badge-{{ $testimonial->status == 1 ? 'success' : 'warning' }}">
                                                {{ $testimonial->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED' }}
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
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="changeStatus({{ $testimonial->id }})">
                                                        <i class="fas fa-{{ $testimonial->status == 1 ? 'arrow-down' : 'arrow-up' }} mr-2"></i>
                                                        {{ $testimonial->status == 1 ? 'Unpublished' : 'Published' }}
                                                    </button>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="show({{ $testimonial->id }})">
                                                        <i class="fas fa-eye mr-2"></i> View
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="destroy({{ $testimonial->id }})"><i
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
                            {{ $testimonials->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="cu-form-label" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-primary" width="15%">Message</td>
                            <td>{{ $message }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Status</td>
                            <td>
                                <span class="badge badge-{{ $status == 1 ? 'success' : 'warning' }}">
                                    {{ $status == 1 ? 'PUBLISHED' : 'UNPUBLISHED' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-primary">Created At</td>
                            <td>{{ $created_at }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Created By</td>
                            <td>{{ $created_by }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Updated At</td>
                            <td>{{ $updated_at }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary">Updated By</td>
                            <td>{{ $updated_by }}</td>
                        </tr>
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

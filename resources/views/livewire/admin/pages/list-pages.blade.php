<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Pages</li>
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
                                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-plus"></i>
                                    &nbsp; Add New Page
                                </a>
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
                                        Page Name
                                        <span wire:click="sortBy('page_name')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'page_name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'page_name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>
                                        Page Title
                                        <span wire:click="sortBy('page_title')" class="float-right text-sm"
                                              style="cursor: pointer;">
                                            <i class="fa fa-arrow-up {{ $sortColumnName === 'page_title' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i class="fa fa-arrow-down {{ $sortColumnName === 'page_title' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th>Created By</th>
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
                                @forelse($pages as $key => $page)
                                    <tr>
                                        <td class="align-middle">{{ $pages->firstItem() + $key }}</td>
                                        <td class="align-middle">{{ $page->page_name }}</td>
                                        <td class="align-middle">{{ $page->page_title }}</td>
                                        <td class="align-middle">{{ $page->createdBy->name }}</td>
                                        <td class="align-middle">
                                            {{ $page->created_at ? $page->created_at->toFormattedDate() : 'N/A' }}
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-{{ $page->status == 1 ? 'success' : 'warning' }}">
                                                {{ $page->status == 1 ? 'PUBLISHED' : 'UNPUBLISHED' }}
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
                                                            wire:click.prevent="changeStatus({{ $page->id }})">
                                                        <i class="fas fa-{{ $page->status == 1 ? 'arrow-down' : 'arrow-up' }} mr-2"></i>
                                                        {{ $page->status == 1 ? 'Unpublished' : 'Published' }}
                                                    </button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="show({{ $page->id }})">
                                                        <i class="fas fa-eye mr-2"></i> View
                                                    </button>
                                                    <a href="{{ route('admin.pages.edit', $page) }}" class="dropdown-item">
                                                        <i class="fas fa-edit mr-2"></i> Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item"
                                                            wire:click.prevent="destroy({{ $page->id }})"><i
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
                            {{ $pages->links() }}
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
                        {{ $page_name }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-primary table-subject">Page Title</td>
                            <td>{{ $page_title }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary table-subject">Page Slug</td>
                            <td>{{ $page_slug }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary table-subject">Page Details</td>
                            <td>{!! $page_details !!}</td>
                        </tr>
                        <tr>
                            <td class="text-primary table-subject">Meta Title</td>
                            <td>{{ $meta_title }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary table-subject">Meta Keywords</td>
                            <td>{{ $meta_keywords }}</td>
                        </tr>
                        <tr>
                            <td class="text-primary table-subject">Meta Description</td>
                            <td>{{ $meta_description }}</td>
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

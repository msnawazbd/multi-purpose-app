<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active"> Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form wire:submit.prevent="updateSetting">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="site_name">Site Name</label>
                                    <input type="text" wire:model.defer="state.site_name" class="form-control"
                                           id="site_name" placeholder="Enter site name">
                                </div>

                                <div class="form-group">
                                    <label for="site_email">Site Email</label>
                                    <input type="email" wire:model.defer="state.site_email" class="form-control"
                                           id="site_email" placeholder="Enter site email">
                                </div>

                                <div class="form-group">
                                    <label for="site_title">Site Title</label>
                                    <input type="text" wire:model.defer="state.site_title" class="form-control"
                                           id="site_title" placeholder="Enter site title">
                                </div>

                                <div class="form-group">
                                    <label for="footer_text">Footer Text</label>
                                    <input type="text" wire:model.defer="state.footer_text" class="form-control"
                                           id="footer_text" placeholder="Enter site footer">
                                </div>

                                {{--<div class="form-check">
                                    <input type="checkbox" wire:model.defer="state.sidebar_collapse"
                                           class="form-check-input" id="sidebar_collapse">
                                    <label class="form-check-label" for="sidebar_collapse">Sidebar Collapse</label>
                                </div>--}}

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" wire:model.defer="state.sidebar_collapse" class="custom-control-input" id="sidebarCollapse">
                                        <label class="custom-control-label" for="sidebarCollapse">Sidebar Collapse</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <x-inputs.button id="update-profile" class="text-white">Save Change</x-inputs.button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>

@push('js')
    <script>
        $('#sidebarCollapse').on('change', function () {
            $('body').toggleClass('sidebar-collapse')
        });
    </script>
@endpush

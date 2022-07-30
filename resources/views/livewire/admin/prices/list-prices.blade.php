<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pricing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Pricing</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus"></i>
                            &nbsp; Add New Pricing
                        </a>
                        <x-search-input wire:model="searchKeywords"/>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @foreach($prices as $price)
                            <div class="col-md-4">
                                <div class="card card-widget widget-user-2">
                                    <div class="widget-user-header bg-warning">
                                        <h3 class="widget-user-username">{{ $price->title }}</h3>
                                        <!-- price to value -->
                                        <h5 class="widget-user-desc"><i
                                                class="fas fa-dollar-sign"></i> {{ $price->original_price }}</h5>
                                        <h5 class="widget-user-desc"><i
                                                class="fas fa-dollar-sign"></i> {{ $price->discounted_price }}
                                            / {{ $price->validity }} Days</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Listing <span
                                                        class="float-right badge bg-primary">{{ $price->listings }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Categories <span
                                                        class="float-right badge bg-primary">{{ $price->categories }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Photos <span
                                                        class="float-right badge bg-primary">{{ $price->photos }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Videos <span
                                                        class="float-right badge bg-primary">{{ $price->videos }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Tags <span
                                                        class="float-right badge bg-primary">{{ $price->tags }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Amenities <span
                                                        class="float-right badge bg-primary">{{ $price->amenities }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Products <span
                                                        class="float-right badge bg-primary">{{ $price->products }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Services <span
                                                        class="float-right badge bg-primary">{{ $price->services }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Articles <span
                                                        class="float-right badge bg-primary">{{ $price->articles }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Featured Listings <span
                                                        class="float-right badge bg-{{ $price->featured_listings == 0 ? 'warning' : 'success' }}"><i
                                                            class="fas {{ $price->featured_listings == 0 ? 'fa-times' : 'fa-check' }}"></i></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Contact Form <span
                                                        class="float-right badge bg-{{ $price->contact_form == 0 ? 'warning' : 'success' }}"><i
                                                            class="fas {{ $price->contact_form == 0 ? 'fa-times' : 'fa-check' }}"></i></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Social Items <span
                                                        class="float-right badge bg-{{ $price->social_items == 0 ? 'warning' : 'success' }}"><i
                                                            class="fas {{ $price->social_items == 0 ? 'fa-times' : 'fa-check' }}"></i></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Status <span
                                                        class="float-right badge bg-{{ $price->status == 0 ? 'warning' : 'success' }}"><i
                                                            class="fas {{ $price->status == 0 ? 'fa-times' : 'fa-check' }}"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer">
                                        <div class="btn-group btn-group-sm btn-block" role="group"
                                             aria-label="Basic example">
                                            <button type="button" class="btn btn-outline-info">Edit</button>
                                            <button type="button" class="btn btn-outline-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-end"></div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- confirmation-alert components -->
    <x-confirmation-alert/>

</div>
@push('styles')
    <style>
        .widget-user-username, .widget-user-desc {
            margin-left: 0px !important;
        }
    </style>
@endpush

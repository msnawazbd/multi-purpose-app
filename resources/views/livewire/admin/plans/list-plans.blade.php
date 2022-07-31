<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Plans</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Plans</li>
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
                        <a href="{{ route('admin.plans.create') }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus"></i>
                            &nbsp; Add New Plan
                        </a>
                        <x-search-input wire:model="searchKeywords"/>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @foreach($plans as $plan)
                            <div class="col-md-4">
                                <div class="card card-widget widget-user-2">
                                    <div class="widget-user-header bg-light text-center">
                                        <h3 class="widget-user-username text-success">{{ $plan->title }}</h3>
                                        <!-- plan to value -->
                                        <h5 class="widget-user-desc text-muted">
                                            <small><i class="fas fa-dollar-sign"></i></small> <del>{{ toFormattedNumber($plan->original_price, 2) }}</del></h5>
                                        <h5 class="widget-user-desc  text-muted">
                                            <small><i class="fas fa-dollar-sign"></i></small> <span class="text-warning">{{ toFormattedNumber($plan->discounted_price, 2) }}</span>
                                            / <span class="text-warning">{!! checkInfinity($plan->validity) !!}</span> Days</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                   <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Listing <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->listings) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Categories <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->categories) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Photos <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->photos) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Videos <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->videos) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Tags <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->tags) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Amenities <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->amenities) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Products <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->products) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Services <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->services) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Articles <span class="float-right text-secondary font-weight-bold">{!! checkInfinity($plan->articles) !!}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Featured Listings <span class="float-right text-secondary font-weight-bold">
                                                        <i class="fas {{ $plan->featured_listings == 0 ? 'fa-times-circle text-danger' : 'fa-check-circle text-success' }}"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Contact Form <span class="float-right text-secondary font-weight-bold">
                                                        <i class="fas {{ $plan->contact_form == 0 ? 'fa-times-circle text-danger' : 'fa-check-circle text-success' }}"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Social Items <span class="float-right text-secondary font-weight-bold">
                                                        <i class="fas {{ $plan->social_items == 0 ? 'fa-times-circle text-danger' : 'fa-check-circle text-success' }}"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-double-right pr-2 text-secondary"></i> Status <span class="float-right text-secondary font-weight-bold">
                                                        <i class="fas {{ $plan->status == 0 ? 'fa-times-circle text-danger' : 'fa-check-circle text-success' }}"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer text-right">
                                        <div class="btn-group btn-group-sm" role="group"
                                             aria-label="Basic example">
                                            <button type="button" class="btn btn-outline-info" wire:click.prevent="changeStatus({{ $plan->id }})"><i class="fas {{ $plan->status == 0 ? 'fa-times text-danger' : 'fa-check text-success' }}s"></i></button>
                                            <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-outline-info"><i class="fas fa-edit text-primary"></i></a>
                                            <button type="button" class="btn btn-outline-info" wire:click.prevent="destroy({{ $plan->id }})"><i class="fas fa-trash text-danger"></i></button>
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

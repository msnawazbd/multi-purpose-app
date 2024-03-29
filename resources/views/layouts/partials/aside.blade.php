<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ setting('site_name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()['avatar_url'] ?? '' }}" id="profileSideImage" class="img-circle elevation-2"
                     alt="{{ auth()->user()->name }}">
            </div>
            <div class="info">
                <a href="#" class="d-block" x-ref="username">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{--<div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>--}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.clients') }}" class="nav-link {{ request()->is('admin/clients', 'admin/clients/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Clients
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tasks') }}" class="nav-link {{ request()->is('admin/tasks', 'admin/tasks/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Tasks
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.appointments') }}" class="nav-link {{ request()->is('admin/appointments', 'admin/appointments/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                            Appointments
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/income', 'admin/income/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/income', 'admin/income/*') ? 'active' : '' }}">
                        <i class="nav-icon 	fas fa-dollar-sign"></i>
                        <p>
                            Income
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.income.services') }}" class="nav-link {{ request()->is('admin/income/services', 'admin/income/services') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Services</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.income.invoices') }}" class="nav-link {{ request()->is('admin/income/invoices', 'admin/income/invoices/*') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Invoices</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.plans') }}" class="nav-link {{ request()->is('admin/plans', 'admin/plans/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Plans
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/blog', 'admin/blog/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/blog', 'admin/blog/*') ? 'active' : '' }}">
                        <i class="nav-icon 	fas fa-blog"></i>
                        <p>
                            Blog
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.blog.categories') }}" class="nav-link {{ request()->is('admin/blog/categories', 'admin/blog/categories') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.blog.posts') }}" class="nav-link {{ request()->is('admin/blog/posts', 'admin/blog/posts/*') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Blog Posts</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->is('admin/settings', 'admin/settings/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/settings', 'admin/settings/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.roles') }}" class="nav-link {{ request()->is('admin/settings/roles', 'admin/settings/roles') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.permissions') }}" class="nav-link {{ request()->is('admin/settings/permissions', 'admin/settings/permissions') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.users') }}" class="nav-link {{ request()->is('admin/settings/users', 'admin/settings/users') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.taxes') }}" class="nav-link {{ request()->is('admin/settings/taxes', 'admin/settings/taxes') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Taxes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.taxes') }}" class="nav-link {{ request()->is('admin/settings/taxes', 'admin/settings/taxes') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Languages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.taxes') }}" class="nav-link {{ request()->is('admin/settings/taxes', 'admin/settings/taxes') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Appearances</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.generals') }}" class="nav-link {{ request()->is('admin/settings/generals', 'admin/settings/generals') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Generals</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->is('admin/locations', 'admin/locations/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/locations', 'admin/locations/*') ? 'active' : '' }}">
                        <i class="nav-icon 	fas fa-map-marker-alt"></i>
                        <p>
                            Locations
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.locations.countries') }}" class="nav-link {{ request()->is('admin/locations/countries', 'admin/locations/countries') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Countries</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.locations.states') }}" class="nav-link {{ request()->is('admin/locations/states', 'admin/locations/states') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>States</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.locations.cities') }}" class="nav-link {{ request()->is('admin/locations/cities', 'admin/locations/cities') ? 'active' : '' }}">
                                <i class="fas fa-arrow-right nav-icon"></i>
                                <p>Cities</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.contact-messages') }}" class="nav-link {{ request()->is('admin/contact-messages', 'admin/contact-messages/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Messages
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages') }}" class="nav-link {{ request()->is('admin/pages', 'admin/pages/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sticky-note"></i>
                        <p>
                            Pages
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.subscribes') }}" class="nav-link {{ request()->is('admin/subscribes', 'admin/subscribes/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            Subscribes
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.testimonials') }}" class="nav-link {{ request()->is('admin/testimonials', 'admin/testimonials/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comment-dots"></i>
                        <p>
                            Testimonials
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.faqs') }}" class="nav-link {{ request()->is('admin/faqs', 'admin/faqs/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question"></i>
                        <p>
                            FAQs
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

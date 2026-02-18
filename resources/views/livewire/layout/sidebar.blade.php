<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('images/logo/favicon.png') }}"Logo" class="brand-image">
        <span class="brand-text font-weight-light">Summit Chemical</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{ route('dashboard') }}" class="d-block">{{ Auth::user()->name }}
                    {{ Auth::user()->last_name }}</a>

                @isset(auth()->user()->department->name)
                    <div class="d-block text-light">
                        {{ auth()->user()->department->name }}
                    </div>
                @endisset
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- User Menu -->
                <li class="nav-item {{ request()->is('user*', 'department*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user*', 'department*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <p>
                            User
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <!-- User Profile -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.profile') }}"
                                class="nav-link {{ request()->is('user/profile') ? 'active' : '' }}">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>Profile</p>
                            </a>
                            <a href="{{ route('user.list') }}"
                                class="nav-link {{ request()->is('user/list') ? 'active' : '' }}">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>User Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Department Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('department.list') }}"
                                class="nav-link {{ request()->is('department*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- CRM Menu -->
                <li
                    class="nav-item {{ request()->is('crms*', 'customers*', 'products*', 'applications*', 'customer-types*', 'customer-groups*', 'sales-stages*', 'probabilities*', 'volume-units*', 'events*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('crms*', 'customers*', 'products*', 'applications*', 'customer-types*', 'customer-groups*', 'sales-stages*', 'probabilities*', 'volume-units*', 'events*') ? 'active' : '' }}">
                        {{-- <i class="fab fa-wordpress-simple nav-icon"></i> --}}
                        <i class="fas fa-bars nav-icon"></i>
                        <p>
                            CRM Application
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <!-- CRM Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('crm.list') }}"
                                class="nav-link {{ request()->is('crms/lists', 'crms/create', 'crms/update*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                {{-- <i class="far fa-circle nav-icon"></i> --}}
                                <p>CRM Lists</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('crm.list.delete') }}"
                                class="nav-link {{ request()->is('crms/lists/delete') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                {{-- <i class="far fa-circle nav-icon"></i> --}}
                                <p>CRM Delete Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Customer Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('customer.list') }}"
                                class="nav-link {{ request()->is('customers*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Customer Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Event Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('event.list') }}"
                                class="nav-link {{ request()->is('events*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Event Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Customer Type Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('customer-type.list') }}"
                                class="nav-link {{ request()->is('customer-types*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Customer Type Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Customer Group Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('customer-group.list') }}"
                                class="nav-link {{ request()->is('customer-groups*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Customer Group Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Product Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('product.list') }}"
                                class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Product Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Application Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('application.list') }}"
                                class="nav-link {{ request()->is('applications*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Application Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Probability Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('probability.list') }}"
                                class="nav-link {{ request()->is('probabilities*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Probability Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Volume Unit Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('volume-unit.list') }}"
                                class="nav-link {{ request()->is('volume-units*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Volume Unit Lists</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Sales Stage Lists -->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sales-stage.list') }}"
                                class="nav-link {{ request()->is('sales-stages*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Sales Stage Lists</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('images/logo/favicon.png') }}" Logo" class="brand-image">
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
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item {{ request()->is('user*', 'department*', 'role*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user*', 'department*', 'role*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <p>
                            User
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <!-- User Profile -->
                        <li class="nav-item">
                            <a href="{{ route('user.profile') }}"
                                class="nav-link {{ request()->is('users/profile') ? 'active' : '' }}">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                        <!-- Role Lists -->
                        @if (auth()->user()->can('role.view'))
                        <li class="nav-item">
                            <a href="{{ route('role.list') }}"
                                class="nav-link {{ request()->is('role*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Role Lists</p>
                            </a>
                        </li>
                        @endif

                        <!-- User Lists -->
                        @if (auth()->user()->can('user.view'))
                        <li class="nav-item">
                            <a href="{{ route('user.list') }}"
                                class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>User Lists</p>
                            </a>
                        </li>
                        @endcan

                        <!-- Department Lists -->
                        @if (auth()->user()->can('department.view'))
                        <li class="nav-item">
                            <a href="{{ route('department.list') }}"
                                class="nav-link {{ request()->is('departments') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Department Lists</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>

                @if (auth()->user()->can('crm.view') || auth()->user()->can('crmDelete.view'))
                <li class="nav-item {{ request()->is('crms*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('crms*') ? 'active' : '' }}">
                        <i class="fas fa-bars nav-icon"></i>
                        <p>
                            CRM Application
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <!-- CRM Lists -->
                        @if (auth()->user()->can('crm.view'))
                        <li class="nav-item">
                            <a href="{{ route('crm.list') }}"
                                class="nav-link {{ request()->is('crms', 'crms/create', 'crms/update*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>CRM Lists</p>
                            </a>
                        </li>
                        @endif

                        <!-- CRM Delete Lists -->
                        @if (auth()->user()->can('crmDelete.view'))
                        <li class="nav-item">
                            <a href="{{ route('crm.list.delete') }}"
                                class="nav-link {{ request()->is('crms/delete') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>CRM Delete Lists</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if (auth()->user()->can('customer.view') ||
                auth()->user()->can('customerType.view') ||
                auth()->user()->can('customerGroup.view') ||
                auth()->user()->can('event.view'))
                <li
                    class="nav-item {{ request()->is('customers*', 'customer-types*', 'customer-groups*', 'events*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('customers*', 'customer-types*', 'customer-groups*', 'events*') ? 'active' : '' }}">
                        <i class="fas fa-bars nav-icon"></i>
                        <p>
                            Customer Masters
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <!-- Customer Lists -->
                        @if (auth()->user()->can('customer.view'))
                        <li class="nav-item">
                            <a href="{{ route('customer.list') }}"
                                class="nav-link {{ request()->is('customers*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Customer Lists</p>
                            </a>
                        </li>
                        @endif

                        <!-- Customer Type Lists -->
                        @if (auth()->user()->can('customerType.view'))
                        <li class="nav-item">
                            <a href="{{ route('customer-type.list') }}"
                                class="nav-link {{ request()->is('customer-types*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Customer Type Lists</p>
                            </a>
                        </li>
                        @endcan

                        <!-- Customer Group Lists -->
                        @if (auth()->user()->can('customerGroup.view'))
                        <li class="nav-item">
                            <a href="{{ route('customer-group.list') }}"
                                class="nav-link {{ request()->is('customer-groups*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Customer Group Lists</p>
                            </a>
                        </li>
                        @endcan

                        <!-- Event Lists -->
                        @if (auth()->user()->can('event.view'))
                        <li class="nav-item">
                            <a href="{{ route('event.list') }}"
                                class="nav-link {{ request()->is('events*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Event Lists</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endif

                @if (auth()->user()->can('product.view') ||
                auth()->user()->can('application.view') ||
                auth()->user()->can('salesStage.view') ||
                auth()->user()->can('probability.view') ||
                auth()->user()->can('volumeUnit.view') ||
                auth()->user()->can('event.view'))
                <li
                    class="nav-item {{ request()->is('products*', 'applications*', 'sales-stages*', 'probabilities*', 'volume-units*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('products*', 'applications*', 'sales-stages*', 'probabilities*', 'volume-units*') ? 'active' : '' }}">
                        <i class="fas fa-bars nav-icon"></i>
                        <p>
                            Data Masters
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <!-- Product Lists -->
                        @if (auth()->user()->can('product.view'))
                        <li class="nav-item">
                            <a href="{{ route('product.list') }}"
                                class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Product Lists</p>
                            </a>
                        </li>
                        @endif

                        <!-- Application Lists -->
                        @if (auth()->user()->can('application.view'))
                        <li class="nav-item">
                            <a href="{{ route('application.list') }}"
                                class="nav-link {{ request()->is('applications*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Application Lists</p>
                            </a>
                        </li>
                        @endif

                        <!-- Probability Lists -->
                        @if (auth()->user()->can('probability.view'))
                        <li class="nav-item">
                            <a href="{{ route('probability.list') }}"
                                class="nav-link {{ request()->is('probabilities*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Probability Lists</p>
                            </a>
                        </li>
                        @endif

                        <!-- Volume Unit Lists -->
                        @if (auth()->user()->can('volumeUnit.view'))
                        <li class="nav-item">
                            <a href="{{ route('volume-unit.list') }}"
                                class="nav-link {{ request()->is('volume-units*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Volume Unit Lists</p>
                            </a>
                        </li>
                        @endif

                        <!-- Sales Stage Lists -->
                        @if (auth()->user()->can('salesStage.view'))
                        <li class="nav-item">
                            <a href="{{ route('sales-stage.list') }}"
                                class="nav-link {{ request()->is('sales-stages*') ? 'active' : '' }}">
                                <i class="fas fa-chevron-circle-down nav-icon"></i>
                                <p>Sales Stage Lists</p>
                            </a>
                        </li>

                        @endif

                    </ul>

                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
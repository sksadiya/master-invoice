<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('root') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('root') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/uploads/'.$settings['app-fevicon']) }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/uploads/'.$settings['app-logo']) }}" alt="" width="200px"  height="36">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>



    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('root') }}" >
                        <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('clients') }}" >
                        <i class="ri-folder-user-line"></i> <span>Clients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('serviceCategories') }}" >
                        <i class="ri-folder-user-line"></i> <span>Service Categories</span>
                    </a>
                </li>
                @can('View Departments')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('departments') }}" >
                        <i class="ri-file-user-line"></i> <span>Departments</span>
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('employees') }}" >
                        <i class="ri-file-user-line"></i> <span>Employees</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('invoices') }}" >
                    <i class="ri-file-list-3-line"></i> <span>Invoices</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('payments') }}" >
                    <i class="ri-currency-line"></i> <span>Payments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('categories') }}" >
                    <i class="ri-apps-2-line"></i> <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('taxes') }}" >
                    <i class="ri-money-dollar-circle-line"></i> <span>Taxes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('products') }}" >
                    <i class="ri-product-hunt-line"></i> <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('expenseCategories') }}" >
                    <i class="ri-product-hunt-line"></i> <span>Expense Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('expenses') }}" >
                    <i class="ri-product-hunt-line"></i> <span>Expenses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('app-settings') }}" >
                    <i class="ri-settings-2-line"></i> <span>Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('roles') }}" >
                    <i class="ri-settings-2-line"></i> <span>Roles & Permissions</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
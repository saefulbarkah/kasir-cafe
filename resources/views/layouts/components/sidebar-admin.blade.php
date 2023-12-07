<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="javscript:void(0)">Kasir Cafe</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="javscript:void(0)">CF</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="@if (Request::is('admin/dashboard')) active @endif"><a class="nav-link"
                    href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span></a></li>
            {{-- <li class="@if (Request::is('admin/manage/user*')) active @endif"><a class="nav-link"
                    href="{{ route('admin.manage.user') }}"><i class="fas fa-users"></i>
                    <span>Data pengguna</span></a>
            </li> --}}
            <li
                class="nav-item dropdown {{ request()->is('admin/manager*') || request()->is('admin/kasir*') ? 'active' : '' }}">
                <a href=" #" class="nav-link has-dropdown"><i class="fas fa-list"></i>
                    <span>Data pengguna</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.manager') }}">Manager</a></li>
                    <li><a class="nav-link" href="{{ route('admin.kasir') }}">Kasir</a></li>
                </ul>
            </li>
            <li class="{{ request()->is('admin/aktifitas*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.aktifitas') }}"><i class="fas fa-tasks"></i>
                    <span>Log aktifitas</span>
                </a>
            </li>
        </ul>
    </aside>
</div>

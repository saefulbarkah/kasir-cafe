<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="javscript:void(0)">Kasir Cafe</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="javscript:void(0)">KR</a>
        </div>
        <ul class="sidebar-menu">
            <li class=" menu-header">Menu</li>
            <li class="{{ request()->is('manager/dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('manager/menu*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.menu') }}"><i class="fas fa-hamburger"></i>
                    <span>Daftar menu</span>
                </a>
            </li>
            <li class="{{ request()->is('manager/laporan-pendapatan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.laporan.pendapatan') }}"><i
                        class="fas fa-bank"></i>
                    <span>Laporan Pendapatan</span>
                </a>
            </li>
            <li class="{{ request()->is('manager/riwayat-transaksi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.riwayat.transaksi') }}"><i
                        class="fas fa-history"></i>
                    <span>Riwayat transaksi</span>
                </a>
            </li>
            <li class="{{ request()->is('manager/aktifitas*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.aktifitas') }}"><i class="fas fa-tasks"></i>
                    <span>Log aktifitas</span>
                </a>
            </li>

            {{-- <li
                class="nav-item dropdown {{ (request()->is('admin/manager*') || request()->is('admin/kasir*') ) ? 'active' : '' }}">
                <a href=" #" class="nav-link has-dropdown"><i class="fas fa-list"></i>
                    <span>Data pengguna</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.manager') }}">Manager</a></li>
                    <li><a class="nav-link" href="{{ route('admin.kasir') }}">Kasir</a></li>
                </ul>
            </li> --}}
        </ul>
    </aside>
</div>

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
            {{-- <li class="{{ request()->is('kasir/dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kasir.dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li> --}}
            <li class="{{ request()->is('kasir/pesanan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kasir.pesanan') }}"><i class="fas fa-hamburger"></i>
                    <span>Pesanan</span>
                </a>
            </li>
            <li class="{{ request()->is('kasir/riwayat-transaksi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kasir.riwayat.transaksi') }}"><i class="fas fa-history"></i>
                    <span>Riwayat transaksi</span>
                </a>
            </li>
        </ul>
    </aside>
</div>

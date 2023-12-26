<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">SiKecilSehat</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">Sks</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fas fa-columns"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">List Data</li>
            <li class="dropdown {{ Request::is('dashboard/datasets*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-bar"></i>
                    <span>Dataset</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('dashboard/datasets/create') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.datasets.create') }}">Tambah Dataset</a></li>
                    <li class="{{ Request::is('dashboard/datasets') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.datasets.index') }}">Dataset</a></li>
                </ul>
            </li>
            <li class="dropdown {{ Request::is('dashboard/dataujis*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-line"></i>
                    <span>Data Uji</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('dashboard/dataujis/create') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.dataujis.create') }}">Tambah Data Uji</a></li>
                    <li class="{{ Request::is('dashboard/dataujis') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.dataujis.index') }}">Data Uji</a></li>
                </ul>
            </li>
            <li class="menu-header">Akses</li>
            <li class="dropdown">
                <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>
        </ul>
    </aside>
</div>

<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        {{-- <a href="{{ route('home') }}" class="logo logo-dark">
            <span class="logo-sm">
                Sistem Informasi...
            </span>
            <span class="logo-lg">
                Sistem Informasi...
            </span>
        </a>

        <a href="{{ route('home') }}" class="logo logo-light">
            <span class="logo-sm">
                Sistem Informasi...
            </span>
            <span class="logo-lg">
                Sistem Informasi...
            </span>
        </a> --}}
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Master Data</li>

                <li class="{{set_active('home')}}">
                    <a href="{{ route('home') }}">
                       <span class="badge rounded-pill bg-primary float-end"></span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{set_active('pegawai.*')}}">
                    <a href="{{ route('pegawai.index') }}">
                       <span
                            class="badge rounded-pill bg-primary float-end"></span>
                        <span>Data Pegawai</span>
                    </a>
                </li>

                <li class="{{set_active('akun.*')}}">
                    <a href="{{ route('akun.index') }}">
                       <span
                            class="badge rounded-pill bg-primary float-end"></span>
                        <span>Data Akun</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route('home') }}">
                        <span
                            class="badge rounded-pill bg-primary float-end"></span>
                        <span>Data User</span>
                    </a>
                </li> --}}

                <li class="menu-title">Transaksi</li>

                <li class="{{set_active('gaji.index')}}">
                    <a href="{{ route('gaji.index') }}" class="waves-effect">
                        <span>Penggajian</span>
                    </a>
                </li>

                <li class="{{set_active('absen.index')}}">
                    <a href="{{ route('absen.index') }}" class="waves-effect">
                        <span>Rekap Absensi</span>
                    </a>
                </li>

                <li class="{{set_active('jurnal.index')}}">
                    <a href="{{ route('jurnal.index') }}" class="waves-effect">
                        <span>Jurnal</span>
                    </a>
                </li>

                <li class="menu-title">Laporan</li>

                <li class="{{set_active('absen.report-list')}}">
                    <a href="{{ route('absen.report-list') }}" class="waves-effect">
                        <span>Laporan Absensi</span>
                    </a>
                </li>

                <li class="{{set_active('gaji.report-list')}}">
                    <a href="{{ route('gaji.report-list') }}" class="waves-effect">
                        <span>Laporan Gaji</span>
                    </a>
                </li>

                <li class="{{set_active('jurnal.report-list')}}">
                    <a href="{{ route('jurnal.report-list') }}" class="waves-effect">
                        <span>Laporan Jurnal</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>

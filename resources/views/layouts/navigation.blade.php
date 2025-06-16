<nav class="navbar navbar-expand-lg johor-header shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="https://images.seeklogo.com/logo-png/30/1/kerajaan-negeri-johor-logo-png_seeklogo-306450.png"
                alt="Jata Johor" class="johor-logo">
            <div>
                <span class="d-block fw-bold">SISTEM PENTADBIRAN</span>
                <small class="d-block text-muted">JOHOR DARUL TA'ZIM</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (auth()->user()->type == 1)
                    <li class="nav-item">
                        <a class="nav-link nav-link-johor {{ request()->routeIs('dashboard.umum') ? 'active' : '' }}"
                            href="{{ route('dashboard.umum') }}">UTAMA</a>
                    </li>
                @endif
                @if (auth()->user()->type == 2)
                    <li class="nav-item">
                        <a class="nav-link nav-link-johor {{ request()->routeIs('dashboard.sekretariat') ? 'active' : '' }}"
                            href="{{ route('dashboard.sekretariat') }}">UTAMA</a>
                    </li>
                @endif
                @if (auth()->user()->type == 3)
                    <li class="nav-item">
                        <a class="nav-link nav-link-johor {{ request()->routeIs('dashboard.adminjabatan') ? 'active' : '' }}"
                            href="{{ route('dashboard.adminjabatan') }}">UTAMA</a>
                    </li>
                @endif
                @if (auth()->user()->type == 4)
                    <li class="nav-item">
                        <a class="nav-link nav-link-johor {{ request()->routeIs('dashboard.superadmin') ? 'active' : '' }}"
                            href="{{ route('dashboard.superadmin') }}">UTAMA</a>
                    </li>
                @endif
                @if (in_array(auth()->user()->type, [2, 3, 4]))
                    <li class="nav-item">
                        <a class="nav-link nav-link-johor {{ request()->routeIs('pengguna', 'pengguna.create', 'pengguna.edit') ? 'active' : '' }}"
                            href="{{ route('pengguna') }}">
                            PENGGUNA
                        </a>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-johor dropdown-toggle {{ request()->routeIs('permohonan.*', 'pengurusan.*') ? 'active' : '' }}"
                        href="#" id="permohonanDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        PERMOHONAN
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="permohonanDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('permohonan.index', 'permohonan.edit', 'permohonan.tambah') ? 'active' : '' }}"
                                href="{{ route('permohonan.index') }}">PERMOHONAN</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('permohonan.senarai') ? 'active' : '' }}"
                                href="{{ route('permohonan.senarai') }}">SENARAI</a>
                        </li>
                        @if (in_array(auth()->user()->type, [2, 3, 4]))
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('pengurusan.index') ? 'active' : '' }}"
                                    href="{{ route('pengurusan.index') }}">PENGURUSAN</a>
                            </li>
                        @endif
                    </ul>
                </li>
                @if (in_array(auth()->user()->type, [2, 3, 4]))
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-johor dropdown-toggle {{ request()->routeIs('mesyuarat.*') ? 'active' : '' }}"
                            href="#" id="mesyuaratDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            MESYUARAT
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="mesyuaratDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('mesyuarat.index') ? 'active' : '' }}"
                                    href="{{ route('mesyuarat.index') }}">MESYUARAT</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>

        <div class="dropdown">
            <button class="btn btn-johor dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">PROFIL</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">LOG
                            KELUAR</a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
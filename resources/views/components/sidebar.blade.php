<div class="sidebar-wrapper" id="sidebarWrapper">
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <img src="{{ asset('assets/logo laskar cilik.png') }}" alt="Logo Laskar Cilik">
            <div class="brand-text">
                <h2>Laskar Cilik</h2>
            </div>
        </div>

        <nav>
            <p class="nav-label">Menu Utama</p>
            <ul class="sidebar-menu">
                @if(auth()->user()->hak_akses === 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="icon"><i class="fa-solid fa-chart-pie"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.siswa.index') }}" class="{{ Request::routeIs('admin.siswa.*') ? 'active' : '' }}">
                            <span class="icon"><i class="fa-solid fa-graduation-cap"></i></span>
                            <span>Data Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.guru.index') }}" class="{{ Request::routeIs('admin.guru.*') ? 'active' : '' }}">
                            <span class="icon"><i class="fa-solid fa-chalkboard-user"></i></span>
                            <span>Akun Guru</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('guru.dashboard') }}"
                           class="{{ Request::routeIs('guru.dashboard') ? 'active' : '' }}">
                            <span class="icon"><i class="fa-solid fa-chart-pie"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guru.siswa.index') }}"
                           class="{{ Request::routeIs('guru.siswa.*') ? 'active' : '' }}">
                            <span class="icon"><i class="fa-solid fa-graduation-cap"></i></span>
                            <span>Daftar Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guru.catatan.index') }}"
                           class="{{ Request::routeIs('guru.catatan.*') ? 'active' : '' }}">
                            <span class="icon"><i class="fa-solid fa-clipboard-list"></i></span>
                            <span>Catatan Siswa</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <div class="nav-footer-text">
            <p class="copyright">Laskar Cilik {{ ucfirst($role) }}<br>© 2025 All Rights Reserved</p>
            <p class="made-by">Made with ❤️ by Lantas</p>
        </div>

    </aside>
</div>
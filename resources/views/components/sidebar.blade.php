<div class="sidebar-wrapper">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Laskar<br />Cilik</h2>
        </div>
        
        <nav>
            <ul class="sidebar-menu">
                @if(auth()->user()->hak_akses === 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="icon">📊</span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.siswa.index') }}" class="{{ Request::routeIs('admin.siswa.*') ? 'active' : '' }}">
                            <span class="icon">👨‍🎓</span>
                            <span>Data Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.guru.index') }}" class="{{ Request::routeIs('admin.guru.*') ? 'active' : '' }}">
                            <span class="icon">👨‍🏫</span>
                            <span>Akun Guru</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('guru.dashboard') }}" class="{{ Request::routeIs('guru.*') ? 'active' : '' }}">
                            <span class="icon">📊</span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guru.siswa.index') }}" class="{{ Request::routeIs('guru.siswa.*') ? 'active' : '' }}">
                            <span class="icon">👨‍🎓</span>
                            <span>Daftar Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guru.catatan.index') }}" class="{{ Request::routeIs('guru.catatan.*') ? 'active' : '' }}">
                            <span class="icon">📋</span>
                            <span>Catatan Siswa</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <div class="nav-footer-text">
            <p class="copyright">
                Laskar Cilik {{ ucfirst($role) }} Dashboard<br>© 2025 All Rights Reserved
            </p>
            <p class="made-by">Made with ❤️ by Lantas</p>
        </div>

        <button class="sidebar-close-btn" id="sidebarCloseBtn">&lt;</button>
    </aside>

    <button class="sidebar-tab" id="sidebarTab">
        <span class="icon">☰</span>
        <span>MENU</span>
    </button>
</div>

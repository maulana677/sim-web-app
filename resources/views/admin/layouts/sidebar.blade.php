<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="">
            <a href="#" data-toggle="" class="nav-link nav-link-lg nav-link-user">
                @if (auth()->check())
                    <img alt="image" src="{{ Storage::url(auth()->user()->avatar) }}" class="rounded-circle mr-1"
                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
                @else
                    <div class="d-sm-none d-lg-inline-block">Hi, Guest</div>
                @endif
            </a>

        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">SIMS Web App</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SIMS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ setSidebarActive(['admin.produk.*']) }}">
                <a class="nav-link" href="{{ route('admin.produk.index') }}"><i class="fas fa-address-card"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li class="{{ setSidebarActive(['profile.*']) }}">
                <a class="nav-link" href="{{ route('profile.edit') }}"><i class="fas fa-user"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li>
                <a class="nav-link text-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>
</div>

<nav id="adminNav" class="header-nav">
    <a href="{{ route('admin.overview') }}" class="{{ request()->routeIs('admin.overview') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        Overview
    </a>
    <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        Pesanan
    </a>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        Produk
    </a>
    <a href="{{ route('admin.notifications') }}" class="{{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
        Notifikasi
    </a>
</nav>

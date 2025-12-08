<nav id="headerNav" style="display:flex;align-items:center;gap:8px;">
    <a href="{{ route('admin.dashboard') }}" 
       class="nav-link {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.overview') ? 'active' : '' }}"
       style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
        <i class="fas fa-tachometer-alt" style="font-size:16px;color:#10b981;"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('admin.orders') }}" 
       class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"
       style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
        <i class="fas fa-shopping-cart" style="font-size:16px;color:#10b981;"></i>
        <span>Pesanan</span>
    </a>
    <a href="{{ route('admin.products.index') }}" 
       class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
       style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
        <i class="fas fa-box" style="font-size:16px;color:#10b981;"></i>
        <span>Produk</span>
    </a>
</nav>



<header style="background:linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);padding:15px 24px;box-shadow:0 4px 20px rgba(0,0,0,0.08);position:sticky;top:0;z-index:120;border-bottom:3px solid #10b981;">
    <div style="max-width:1400px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:20px;">
        <!-- Logo Section -->
        <div style="display:flex;align-items:center;gap:15px;">
            <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:15px;text-decoration:none;color:inherit;transition:all 0.3s ease;" class="logo-link">
                <div style="width:50px;height:50px;border-radius:12px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(16,185,129,0.3);">
                    <i class="fas fa-leaf" style="color:white;font-size:24px;"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:#065f46;font-size:17px;letter-spacing:0.3px;">Pupuk & Bibit Subsidi</div>
                    <div style="font-size:12px;color:#059669;font-weight:500;">Sistem Informasi Pemerintah</div>
                </div>
            </a>
        </div>

        <!-- Navigation Section -->
        <nav style="display:flex;align-items:center;gap:8px;">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-link" style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-home" style="font-size:16px;color:#10b981;"></i>
                    <span>Beranda</span>
                </a>
            @else
                <a href="{{ route('home') }}" class="nav-link" style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-home" style="font-size:16px;color:#10b981;"></i>
                    <span>Beranda</span>
                </a>
            @endauth
            
            <a href="{{ route('pupuk.bibit') }}" class="nav-link" style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <i class="fas fa-leaf" style="font-size:16px;color:#10b981;"></i>
                <span>Pupuk & Bibit</span>
            </a>
            
            @auth
                <a href="{{ route('profil.user') }}" class="nav-link" style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-user-circle" style="font-size:16px;color:#10b981;"></i>
                    <span>Profil</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-link" style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-sign-in-alt" style="font-size:16px;color:#10b981;"></i>
                    <span>Masuk</span>
                </a>
            @endauth
            
            <a href="{{ route('kontak') }}" class="nav-link" style="text-decoration:none;padding:10px 16px;border-radius:10px;color:#374151;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <i class="fas fa-envelope" style="font-size:16px;color:#10b981;"></i>
                <span>Kontak</span>
            </a>
            
            @auth
                <a href="{{ route('notifikasi') }}" title="Notifikasi" class="nav-link nav-notification" style="text-decoration:none;padding:10px 12px;border-radius:10px;display:inline-flex;align-items:center;color:#374151;transition:all 0.3s ease;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);position:relative;">
                    <i class="fas fa-bell" style="font-size:18px;color:#10b981;"></i>
                    <span class="notification-badge" style="position:absolute;top:5px;right:5px;width:8px;height:8px;background:#ef4444;border-radius:50%;border:2px solid white;"></span>
                </a>
            @endauth
        </nav>
    </div>
</header>

<style>
    .logo-link:hover {
        transform: translateY(-2px);
    }

    .nav-link {
        position: relative;
        overflow: hidden;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: linear-gradient(135deg, #10b981, #059669);
        transition: width 0.3s ease;
    }

    .nav-link:hover::before {
        width: 100%;
    }

    .nav-link:hover {
        background: linear-gradient(135deg, #dcfce7, #d1fae5) !important;
        color: #065f46 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16,185,129,0.2) !important;
    }

    .nav-link:hover i {
        transform: scale(1.2);
        color: #059669 !important;
    }

    .nav-link i {
        transition: all 0.3s ease;
    }

    .nav-notification:hover .notification-badge {
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    
    /* Responsive */
    @media (max-width:1024px) {
        header > div { 
            flex-direction: column; 
            align-items: flex-start; 
            gap: 15px; 
        }
        nav { 
            width: 100%; 
            display: flex;
            flex-wrap: wrap; 
            gap: 8px; 
        }
        .nav-link { 
            font-size: 13px !important;
            padding: 8px 12px !important; 
        }
    }
    
    @media (max-width:768px) {
        header {
            padding: 12px 15px !important;
        }
        nav {
            justify-content: flex-start;
        }
        .nav-link span {
            display: none;
        }
        .nav-link {
            padding: 10px !important;
        }
    }
</style>

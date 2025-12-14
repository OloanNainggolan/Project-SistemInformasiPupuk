<header style="background:linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);padding:15px 24px;box-shadow:0 4px 20px rgba(0,0,0,0.08);position:sticky;top:0;z-index:120;border-bottom:3px solid #10b981;">
    <div style="max-width:1400px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:20px;">
        <!-- Logo Section -->
        <div style="display:flex;align-items:center;gap:15px;">
            <a href="<?php echo e(route('home')); ?>" style="display:flex;align-items:center;gap:15px;text-decoration:none;color:inherit;transition:all 0.3s ease;" class="logo-link">
                <div style="width:50px;height:50px;border-radius:12px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(16,185,129,0.3);">
                    <i class="fas fa-seedling" style="color:white;font-size:24px;"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:#065f46;font-size:17px;letter-spacing:0.3px;">Pupuk & Bibit Subsidi</div>
                    <div style="font-size:12px;color:#059669;font-weight:500;">Sistem Informasi Pemerintah</div>
                </div>
            </a>
        </div>
        
        <!-- Navigation for guest users -->
        <nav style="display:flex;align-items:center;gap:8px;">
            <a href="<?php echo e(route('login')); ?>" class="nav-link" style="text-decoration:none;padding:10px 20px;border-radius:10px;color:white;font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 15px rgba(16,185,129,0.3);">
                <i class="fas fa-sign-in-alt" style="font-size:16px;"></i>
                <span>Masuk</span>
            </a>
        </nav>
    </div>
</header>

<style>
    .logo-link:hover {
        transform: translateY(-2px);
    }

    .nav-link:hover {
        background: linear-gradient(135deg, #004d00, #047857) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16,185,129,0.4) !important;
    }

    .nav-link:hover i {
        transform: scale(1.2);
    }

    .nav-link i {
        transition: all 0.3s ease;
    }
    
    /* Responsive */
    @media (max-width:768px) {
        header {
            padding: 12px 15px !important;
        }
        header > div {
            flex-direction: column;
            gap: 15px;
        }
        nav {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<?php /**PATH C:\laragon\www\ppw\resources\views/partials/header-home.blade.php ENDPATH**/ ?>
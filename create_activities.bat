php artisan tinker << 'EOF'
App\Models\AdminActivity::create(['action' => 'update_product', 'description' => 'Mengubah detail produk Pupuk Organik', 'module' => 'products', 'related_id' => 1, 'status' => 'success', 'ip_address' => '127.0.0.1', 'user_agent' => 'Test']);
App\Models\AdminActivity::create(['action' => 'update_order_status', 'description' => 'Mengubah status pesanan dari Processing ke Ready', 'module' => 'orders', 'related_id' => 123, 'status' => 'success', 'ip_address' => '127.0.0.1', 'user_agent' => 'Test']);
App\Models\AdminActivity::create(['action' => 'login', 'description' => 'Percobaan login gagal', 'module' => 'auth', 'status' => 'failed', 'ip_address' => '127.0.0.1', 'user_agent' => 'Test']);
App\Models\AdminActivity::create(['action' => 'update_profile', 'description' => 'Admin mengubah profil', 'module' => 'profile', 'status' => 'success', 'ip_address' => '127.0.0.1', 'user_agent' => 'Test']);
App\Models\AdminActivity::create(['action' => 'logout', 'description' => 'Admin logout dari sistem', 'module' => 'auth', 'status' => 'success', 'ip_address' => '127.0.0.1', 'user_agent' => 'Test']);
echo "All test activities created!";
EOF

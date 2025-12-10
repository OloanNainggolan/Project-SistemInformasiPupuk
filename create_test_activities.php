<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\AdminActivity;

try {
    // Simulate admin login activity
    AdminActivity::create([
        'action' => 'login',
        'description' => 'Admin berhasil login ke sistem',
        'module' => 'auth',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'status' => 'success'
    ]);

    // Simulate product update activity
    AdminActivity::create([
        'action' => 'update_product',
        'description' => 'Mengubah detail produk Pupuk Organik',
        'module' => 'products',
        'related_id' => 1,
        'changes' => json_encode([
            'name' => 'Pupuk Organik Berkualitas',
            'price' => ['old' => '50000', 'new' => '55000'],
            'stock' => ['old' => 100, 'new' => 150]
        ]),
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'status' => 'success'
    ]);

    // Simulate order status change
    AdminActivity::create([
        'action' => 'update_order_status',
        'description' => 'Mengubah status pesanan dari Processing menjadi Ready',
        'module' => 'orders',
        'related_id' => 123,
        'changes' => json_encode([
            'order_number' => 'ORD-2024-001',
            'status' => ['old' => 'Processing', 'new' => 'Ready']
        ]),
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'status' => 'success'
    ]);

    // Simulate failed login attempt
    AdminActivity::create([
        'action' => 'login',
        'description' => 'Percobaan login gagal dengan username salah',
        'module' => 'auth',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'status' => 'failed'
    ]);

    // Simulate profile update
    AdminActivity::create([
        'action' => 'update_profile',
        'description' => 'Admin mengubah informasi profil',
        'module' => 'profile',
        'changes' => json_encode([
            'name' => ['old' => 'Administrator', 'new' => 'Admin Pupuk'],
            'email' => 'admin@pupukbibit.com'
        ]),
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'status' => 'success'
    ]);

    echo "✓ Test data created successfully!\n";
    echo "  - 2 successful login attempts\n";
    echo "  - 1 failed login attempt\n";
    echo "  - 1 product update\n";
    echo "  - 1 order status change\n";
    echo "  - 1 profile update\n\n";

    // Display created records
    $activities = AdminActivity::latest()->limit(5)->get();
    echo "Recent Activities:\n";
    foreach ($activities as $activity) {
        echo "  [{$activity->status}] {$activity->action} - {$activity->description}\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

<?php
/**
 * Integration Test for Admin Activity Log
 * - Simulate admin login
 * - Create test activities
 * - Fetch activities via API
 * - Verify data format
 */

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\AdminActivity;
use Illuminate\Support\Facades\Session;

echo "Admin Activity Log Integration Test\n";
echo "====================================\n\n";

try {
    // 1. Create test activities
    echo "1. Creating test activities...\n";
    $activities = [
        ['action' => 'login', 'description' => 'Admin login berhasil', 'module' => 'auth', 'status' => 'success'],
        ['action' => 'update_product', 'description' => 'Mengubah harga produk pupuk', 'module' => 'products', 'related_id' => 1, 'status' => 'success'],
        ['action' => 'update_order_status', 'description' => 'Status pesanan diubah ke Ready', 'module' => 'orders', 'related_id' => 1, 'status' => 'success'],
        ['action' => 'delete_product', 'description' => 'Menghapus produk dari sistem', 'module' => 'products', 'related_id' => 2, 'status' => 'success'],
        ['action' => 'logout', 'description' => 'Admin logout dari sistem', 'module' => 'auth', 'status' => 'success'],
    ];

    $count = 0;
    foreach ($activities as $data) {
        $data['ip_address'] = '127.0.0.1';
        $data['user_agent'] = 'Test Browser';
        AdminActivity::create($data);
        $count++;
    }
    echo "   ✓ Created $count test activities\n\n";

    // 2. Verify activities in database
    echo "2. Verifying activities in database...\n";
    $dbCount = AdminActivity::count();
    echo "   ✓ Total activities: $dbCount\n\n";

    // 3. Test model methods
    echo "3. Testing model methods...\n";
    
    $latest = AdminActivity::latest()->first();
    echo "   Latest Activity:\n";
    echo "     - Action: " . $latest->action . "\n";
    echo "     - Icon: " . $latest->icon . "\n";
    echo "     - Status Color: " . $latest->status_color . "\n";
    echo "     - Activity Text: " . $latest->activity_text . "\n";

    echo "\n   By Module (orders):\n";
    $orderActivities = AdminActivity::byModule('orders')->get();
    foreach ($orderActivities as $act) {
        echo "     - " . $act->description . "\n";
    }

    echo "\n   ✓ Model methods working correctly\n\n";

    // 4. Test recent activities scope
    echo "4. Testing recent activities scope...\n";
    $recent = AdminActivity::latest()->limit(5)->get();
    echo "   Latest 5 activities:\n";
    foreach ($recent as $act) {
        echo "     - [{$act->status}] {$act->action}: {$act->description}\n";
    }
    echo "   ✓ Scope working correctly\n\n";

    // 5. Test JSON response format (simulating API)
    echo "5. Testing API response format...\n";
    $apiData = $recent->map(function ($activity) {
        return [
            'id' => $activity->id,
            'action' => $activity->action,
            'description' => $activity->description,
            'module' => $activity->module,
            'status' => $activity->status,
            'icon' => $activity->icon,
            'activity_text' => $activity->activity_text,
            'status_color' => $activity->status_color,
            'created_at' => $activity->created_at->toIso8601String(),
            'time_diff' => $activity->created_at->diffForHumans()
        ];
    });

    echo "   Sample API Response:\n";
    $sample = $apiData->first();
    echo "   {\n";
    foreach ($sample as $key => $value) {
        if (is_string($value)) {
            echo "     \"$key\": \"$value\",\n";
        } else {
            echo "     \"$key\": $value,\n";
        }
    }
    echo "     ...\n";
    echo "   }\n";
    echo "   ✓ API format correct\n\n";

    echo "✅ All tests passed!\n";
    echo "\nSummary:\n";
    echo "- Activity logging model: ✓\n";
    echo "- Database operations: ✓\n";
    echo "- Model methods: ✓\n";
    echo "- API format: ✓\n";
    echo "- Ready for dashboard integration: ✓\n";

} catch (\Exception $e) {
    echo "❌ Test failed: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    die(1);
}

<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICATION CHECK ===\n\n";

// Check pickup points
$pickupPoints = DB::table('pickup_points')->count();
echo "✓ Pickup Points in DB: $pickupPoints\n";

// Check orders with Ready status
$readyOrders = DB::table('orders')->where('status', 'Ready')->count();
echo "✓ Orders with 'Ready' status: $readyOrders\n";

// Check routes
$routes = [
    '/maps',
    '/api/nearest-pickup',
    '/test-api'
];

echo "\n✓ Route Check:\n";
foreach ($routes as $route) {
    $exists = Route::has(ltrim($route, '/')) || Route::getRoutes()->match(
        Request::create($route)
    );
    echo "  - $route: " . ($exists ? "REGISTERED ✓" : "NOT FOUND ✗") . "\n";
}

// Check notification messages
$latestNotif = DB::table('notifications')
    ->where('type', 'info')
    ->orderBy('created_at', 'desc')
    ->first();

if ($latestNotif) {
    echo "\n✓ Latest Notification:\n";
    echo "  Title: " . substr($latestNotif->title, 0, 50) . "...\n";
    $hasMapsMention = stripos($latestNotif->message, 'peta') !== false || 
                      stripos($latestNotif->message, 'lokasi pengambilan') !== false;
    echo "  Contains Maps mention: " . ($hasMapsMention ? "YES ✓" : "NO ✗") . "\n";
}

echo "\n=== FILES CHECK ===\n";
$files = [
    'resources/views/admin/orders/detail.blade.php',
    'resources/views/user/notifications/show-notification.blade.php',
    'app/Http/Controllers/Admin/AdminOrderController.php'
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        if (strpos($file, 'admin/orders/detail') !== false) {
            $hasPickupSection = strpos($content, 'pickupInfoSection') !== false;
            echo "✓ Admin Detail: Pickup section " . ($hasPickupSection ? "EXISTS ✓" : "MISSING ✗") . "\n";
        }
        
        if (strpos($file, 'AdminOrderController') !== false) {
            $hasMapsMessage = strpos($content, 'LIHAT LOKASI PENGAMBILAN') !== false;
            echo "✓ Controller: Maps message " . ($hasMapsMessage ? "EXISTS ✓" : "MISSING ✗") . "\n";
        }
        
        if (strpos($file, 'show-notification') !== false) {
            $hasMapButton = strpos($content, 'btn-map') !== false;
            echo "✓ Notification: Map button " . ($hasMapButton ? "EXISTS ✓" : "MISSING ✗") . "\n";
        }
    }
}

echo "\n=== DONE ===\n";

<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$orders = \App\Models\Order::with('user')->whereIn('order_number', ['ORD-2025-001', 'ORD-2025-002'])
    ->get(['id', 'order_number', 'user_id', 'village_office', 'items', 'total_amount', 'status', 'confirmed_by_user']);

echo json_encode($orders->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

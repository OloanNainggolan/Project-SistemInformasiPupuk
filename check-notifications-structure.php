<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Struktur Tabel Notifications ===\n\n";
$columns = DB::select('DESCRIBE notifications');
foreach($columns as $col) {
    echo $col->Field . ' (' . $col->Type . ')' . PHP_EOL;
}

echo "\n=== Sample Notification ===\n";
$notif = DB::table('notifications')
    ->orderBy('created_at', 'desc')
    ->first();

if ($notif) {
    print_r($notif);
}

echo "\n=== Notifikasi dengan Order Number ===\n";
$notifsWithOrder = DB::table('notifications')
    ->where('message', 'LIKE', '%ORD-%')
    ->orderBy('created_at', 'desc')
    ->limit(3)
    ->get(['id', 'title', 'related_id', 'related_type', 'created_at']);

foreach ($notifsWithOrder as $n) {
    echo "ID: {$n->id} | Title: {$n->title} | Related: {$n->related_type}#{$n->related_id}\n";
}

<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CEK SEMUA NOTIFIKASI ===\n\n";

$total = DB::table('notifications')->count();
echo "Total notifications: $total\n\n";

if ($total > 0) {
    echo "Sample 5 notifikasi terbaru:\n";
    $notifs = DB::table('notifications')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    foreach ($notifs as $n) {
        echo "━━━━━━━━━━━━━━━━━━━\n";
        echo "ID: {$n->id}\n";
        echo "User: {$n->user_id}\n";
        echo "Title: {$n->title}\n";
        echo "Type: {$n->type}\n";
        echo "Related: {$n->related_type} #{$$n->related_id}\n";
        echo "Message Preview: " . substr($n->message, 0, 100) . "...\n";
        echo "Created: {$n->created_at}\n\n";
    }
}

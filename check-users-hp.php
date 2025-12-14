<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "Users dengan Nomor HP:\n";
echo "========================\n\n";

$users = User::whereNotNull('no_telp')
    ->where('no_telp', '!=', '')
    ->get(['id', 'username', 'nama_lengkap', 'email', 'no_telp']);

if ($users->isEmpty()) {
    echo "❌ Tidak ada user dengan nomor HP!\n\n";
    echo "Silakan tambah nomor HP ke user:\n";
    echo "UPDATE users SET no_telp='6281234567890' WHERE id=1;\n";
} else {
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Username: {$user->username}\n";
        echo "Nama: {$user->nama_lengkap}\n";
        echo "Email: {$user->email}\n";
        echo "HP: {$user->no_telp}\n";
        echo "------------------------\n";
    }
    echo "\nTotal: " . $users->count() . " user\n";
}

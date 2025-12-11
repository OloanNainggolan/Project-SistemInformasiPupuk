<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== TEST LOGIN INTERAKTIF ===\n\n";

// Tampilkan semua user yang terdaftar
echo "DAFTAR USER YANG TERDAFTAR:\n";
echo str_repeat("=", 80) . "\n";
$users = User::all(['id', 'name', 'email', 'username', 'created_at']);
foreach ($users as $u) {
    echo "ID: {$u->id}\n";
    echo "  Nama: {$u->name}\n";
    echo "  Email: {$u->email}\n";
    echo "  Username: {$u->username}\n";
    echo "  Terdaftar: {$u->created_at}\n";
    echo str_repeat("-", 80) . "\n";
}

echo "\n";
echo "Masukkan EMAIL yang Anda gunakan untuk login: ";
$email = trim(fgets(STDIN));

echo "Masukkan PASSWORD yang Anda gunakan untuk login: ";
$password = trim(fgets(STDIN));

echo "\n" . str_repeat("=", 80) . "\n";
echo "TESTING LOGIN...\n";
echo str_repeat("=", 80) . "\n\n";

// Cari user berdasarkan email
$user = User::where('email', $email)->first();

if (!$user) {
    echo "❌ GAGAL: Email '{$email}' TIDAK DITEMUKAN di database!\n\n";
    echo "Kemungkinan:\n";
    echo "1. Email salah ketik\n";
    echo "2. Belum pernah registrasi dengan email ini\n";
    echo "3. Salah mengingat email yang digunakan\n\n";
    
    echo "Email yang tersedia:\n";
    foreach ($users as $u) {
        echo "  - {$u->email}\n";
    }
    exit;
}

echo "✓ Email ditemukan!\n";
echo "  User: {$user->name}\n";
echo "  Email: {$user->email}\n\n";

// Test password
echo "Testing password...\n";
if (Hash::check($password, $user->password)) {
    echo "✅✅✅ PASSWORD BENAR! ✅✅✅\n\n";
    echo "Login SEHARUSNYA BERHASIL dengan:\n";
    echo "  Email: {$email}\n";
    echo "  Password: {$password}\n\n";
    
    echo "Jika masih tidak bisa login di browser:\n";
    echo "1. Clear browser cache dan cookies\n";
    echo "2. Tutup semua tab browser\n";
    echo "3. Buka browser baru (atau incognito mode)\n";
    echo "4. Coba login lagi\n\n";
    
    echo "Jika tetap gagal, kemungkinan masalah di:\n";
    echo "- JavaScript error di halaman login\n";
    echo "- CSRF token issue\n";
    echo "- Session driver issue\n";
} else {
    echo "❌❌❌ PASSWORD SALAH! ❌❌❌\n\n";
    echo "Password '{$password}' TIDAK COCOK dengan password di database!\n\n";
    
    echo "SARAN:\n";
    echo "1. Coba ingat-ingat password yang Anda gunakan saat registrasi\n";
    echo "2. Password bersifat case-sensitive (huruf besar/kecil berbeda)\n";
    echo "3. Pastikan tidak ada spasi di awal/akhir password\n\n";
    
    // Test dengan variasi password
    echo "Mencoba variasi password...\n";
    $variations = [
        strtolower($password),
        strtoupper($password),
        ucfirst($password),
        trim($password),
        $password . '123',
        '123' . $password,
    ];
    
    $found = false;
    foreach ($variations as $var) {
        if (Hash::check($var, $user->password)) {
            echo "✓ DITEMUKAN! Password yang benar: '{$var}'\n";
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        echo "\n❌ Tidak ada variasi yang cocok.\n\n";
        echo "SOLUSI:\n";
        echo "1. Gunakan akun demo yang sudah saya buat:\n";
        echo "   Email: demo@test.com\n";
        echo "   Password: 123456\n\n";
        echo "2. Atau reset password dengan perintah:\n";
        echo "   php reset_password.php\n";
    }
}

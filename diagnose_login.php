<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== DIAGNOSIS: LOGIN ISSUE AFTER LOGOUT ===\n\n";

// Pilih user untuk test
$testUser = User::find(4); // User test@gmail.com

if (!$testUser) {
    echo "User not found!\n";
    exit;
}

echo "Testing with User:\n";
echo "ID: {$testUser->id}\n";
echo "Email: {$testUser->email}\n";
echo "Name: {$testUser->name}\n";
echo "Username: {$testUser->username}\n\n";

// Kemungkinan masalah:
echo "POSSIBLE ISSUES:\n";
echo str_repeat("-", 60) . "\n";

// 1. Check password hash
echo "\n1. PASSWORD VERIFICATION:\n";
echo "   Password hash in DB: " . substr($testUser->password, 0, 60) . "...\n";

// Test berbagai password yang mungkin
$possiblePasswords = ['test', 'Test', 'TEST', '123', 'test123', 'password'];
$foundPassword = false;

foreach ($possiblePasswords as $pwd) {
    if (Hash::check($pwd, $testUser->password)) {
        echo "   ✓ FOUND! Correct password is: '{$pwd}'\n";
        $foundPassword = true;
        break;
    }
}

if (!$foundPassword) {
    echo "   ✗ None of the common passwords match\n";
    echo "   → You need to remember the exact password used during registration\n";
}

// 2. Check user status
echo "\n2. USER ACCOUNT STATUS:\n";
echo "   Account created: {$testUser->created_at}\n";
echo "   Account updated: {$testUser->updated_at}\n";
echo "   Email verified: " . ($testUser->email_verified_at ? "Yes" : "No") . "\n";

// 3. Check session configuration
echo "\n3. SESSION CONFIGURATION:\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Lifetime: " . config('session.lifetime') . " minutes\n";
echo "   Encrypt: " . (config('session.encrypt') ? 'Yes' : 'No') . "\n";

// 4. Check active sessions
$activeSessions = DB::table('sessions')->count();
echo "\n4. ACTIVE SESSIONS: {$activeSessions}\n";

// 5. Simulate Auth::attempt
echo "\n5. SIMULATING Auth::attempt():\n";
if ($foundPassword) {
    $credentials = [
        'email' => $testUser->email,
        'password' => $pwd // dari loop di atas
    ];
    
    echo "   Credentials: email={$credentials['email']}, password={$pwd}\n";
    echo "   Hash check: " . (Hash::check($pwd, $testUser->password) ? "PASS" : "FAIL") . "\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "\nCONCLUSION:\n";
if (!$foundPassword) {
    echo "❌ Cannot login because password doesn't match.\n";
    echo "\nSOLUTION:\n";
    echo "1. Try to remember the exact password used during registration\n";
    echo "2. OR use 'Forgot Password' feature (if available)\n";
    echo "3. OR manually reset password in database\n";
} else {
    echo "✓ Login should work with email: {$testUser->email} and password: {$pwd}\n";
    echo "\nIf you still can't login after logout, the issue might be:\n";
    echo "- Browser cache (try clearing cookies)\n";
    echo "- Session not being properly destroyed\n";
    echo "- CSRF token mismatch\n";
}

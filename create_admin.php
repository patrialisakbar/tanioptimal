<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$request = \Illuminate\Http\Request::capture();
$kernel->handle($request);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Cek apakah sudah ada
$existing = User::where('email', 'admin@tanioptimal.com')->first();
if ($existing) {
    echo "❌ Akun sudah ada!\n";
    echo "Email: " . $existing->email . "\n";
    exit;
}

$admin = User::create([
    'name' => 'Admin TaniOptimal',
    'email' => 'admin@tanioptimal.com',
    'password' => Hash::make('admin123'),
    'role' => 'admin'
]);

echo "✅ Akun Admin Berhasil Dibuat!\n";
echo "====================================\n";
echo "Email: " . $admin->email . "\n";
echo "Password: admin123\n";
echo "====================================\n";
echo "Login di: http://localhost:8000/login\n";
?>

<?php
require_once 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Hapus semua user lama
User::query()->delete();

// Buat user admin baru
$admin = User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'role' => 'admin',
]);

echo "✅ Admin user berhasil dibuat!\n";
echo "Email: admin@example.com\n";
echo "Password: password123\n";

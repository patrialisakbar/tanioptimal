# 🔐 Admin & User Authentication Setup

## Akun yang telah dibuat:

### 1️⃣ Admin Account (Bisa Login ke Filament)
```
Email: admin@tanioptimal.com
Password: admin12345
Role: admin
Akses: ✅ Filament Admin Panel
```

### 2️⃣ Regular User Account (TIDAK Bisa Login ke Filament)
```
Email: user@tanioptimal.com
Password: user12345
Role: user
Akses: ❌ Filament Admin Panel (ditolak & logout otomatis)
```

## 🛡️ Keamanan Filament

### Middleware Protection
- File: `app/Http/Middleware/FilamentAdminMiddleware.php`
- Register di: `bootstrap/app.php`

### Gate Authorization
- File: `app/Providers/AppServiceProvider.php`
- Gate: `viewFilament` - hanya user dengan role 'admin' yang bisa akses

### Behavior
1. User dengan role `user` mencoba login ke Filament
2. Middleware akan check role
3. Jika bukan admin → **logout otomatis** dan redirect ke dashboard
4. Menampilkan error: "Anda tidak memiliki akses ke admin panel"

## 🔄 Cara Menggunakan

### Jalankan Seeder:
```bash
php artisan migrate:fresh --seed
```

### Login Admin:
1. Buka: `http://localhost:8000/admin`
2. Email: `admin@tanioptimal.com`
3. Password: `admin12345`
4. ✅ Login berhasil

### Coba Login User ke Admin (akan ditolak):
1. Buka: `http://localhost:8000/admin`
2. Email: `user@tanioptimal.com`
3. Password: `user12345`
4. ❌ Akan logout otomatis & redirect

## 📂 File yang Dimodifikasi

1. ✅ `app/Http/Middleware/FilamentAdminMiddleware.php` (BARU)
2. ✅ `bootstrap/app.php` (Register middleware)
3. ✅ `database/seeders/AdminSeeder.php` (Update credentials)
4. ✅ `app/Providers/AppServiceProvider.php` (Gate sudah ada)

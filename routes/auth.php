<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Auth routes dengan middleware web
Route::middleware('web')->group(function () {
    // GET Register Form
    Route::get('register', function () {
        return view('auth.register');
    })->name('register');

    // POST Register Store
    Route::post('register', function () {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        return redirect('/login')->with('status', 'Registrasi berhasil! Silakan login.');
    })->name('register.store');

    // GET Login Form - Redirect ke Filament
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    // POST Login Store
    Route::post('login', function () {
        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, request('remember'))) {
            request()->session()->regenerate();
            
            $user = Auth::user();
            // Redirect ke admin jika role admin, ke dashboard jika user biasa
            if ($user->role === 'admin') {
                return redirect('/admin');
            }
            
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    })->name('login.store');

    // POST Logout
    Route::post('logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout')->middleware('auth');
});

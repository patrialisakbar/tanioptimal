<?php

namespace App\Filament\Pages\Auth;

use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Http\Responses\Auth\LoginResponse as FilamentLoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        // Authenticate user
        if (!auth()->attempt(['email' => $data['email'], 'password' => $data['password']], $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        // Check if user is admin
        $user = auth()->user();
        if ($user->role !== 'admin') {
            auth()->logout();
            throw ValidationException::withMessages([
                'data.email' => 'Hanya admin yang dapat mengakses admin panel.',
            ])->errorBag('login');
        }

        return app(FilamentLoginResponse::class);
    }
}

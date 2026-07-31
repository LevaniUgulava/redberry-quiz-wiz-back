<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class AuthService
{
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;

    }

    public function login(array $data, bool $remember): User
    {
        if (! Auth::validate($data)) {
            throw new \Exception('AUTH_FAILED');
        }

        $user = User::where('email', $data['email'])->first();

        if (! $user->hasVerifiedEmail()) {
            throw new \Exception('EMAIL_NOT_VERIFIED');
        }

        Auth::login($user, $remember);

        return $user;
    }

    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}

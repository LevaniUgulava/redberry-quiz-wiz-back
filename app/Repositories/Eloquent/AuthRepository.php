<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Override;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    #[Override]
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;

    }

    #[Override]
    public function login(array $data, bool $remember): User
    {
        if (Auth::attempt($data, $remember)) {

            return Auth::user();
        }
        throw new Exception('AUTH_FAILED');
    }

    public function updateAvatar(User $user, UploadedFile $file): User
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $file->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return $user;
    }
}

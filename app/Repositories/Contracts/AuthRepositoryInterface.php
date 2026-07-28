<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Http\UploadedFile;
interface AuthRepositoryInterface
{
    public function register(array $data): User;

    public function login(array $data, bool $remember): User;
    public function updateAvatar(User $user, UploadedFile $file): User;
}

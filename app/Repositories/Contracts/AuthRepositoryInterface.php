<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function register(array $data): User;

    public function login(array $data, bool $remember): User;
}

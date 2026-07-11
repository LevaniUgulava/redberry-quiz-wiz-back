<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authRepository->register($request->validated());
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'NOTCREATED',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'SUCCESS',
        ], 201);
    }

    public function Login(LoginRequest $request): JsonResponse
    {

        try {
            $user = $this->authRepository->login(
                $request->only(['email', 'password']),
                $request->boolean('checkbox'));
            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'NOTFOUND',
                ]);
            }
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'SUCCESS',
                'user' => $user,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'INVALID_CREDENTIALS',
                'error' => $e->getMessage(),
            ], 401);
        }

    }
}

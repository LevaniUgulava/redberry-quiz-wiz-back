<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use App\Services\EmailVerificationService;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'NOTCREATED',
            ], 500);
        }
        event(new Registered($user));

        return response()->json([
            'success' => true,
            'message' => 'SUCCESS',
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {

        try {
            $user = $this->authService->login(
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

    public function verify(string $id, string $hash, EmailVerificationService $service): JsonResponse
    {
        return $service->verify($id, $hash);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request);

        return response()->json([
            'success' => true,
            'message' => 'LOGOUT',
        ]);
    }
}

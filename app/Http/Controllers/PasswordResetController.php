<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordReset\ForgetPasswordRequest;
use App\Http\Requests\PasswordReset\ResetPasswordRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;

class PasswordResetController extends Controller
{
    public function __construct(protected PasswordResetService $passwordService) {}

    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        return $this->passwordService->sendNotification($request->email);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->passwordService->resetPassword($request);

    }
}

<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class EmailVerificationService
{
    public function verify(string $id, string $hash): JsonResponse
    {
        $user = User::findOrFail($id);

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return response()->json(['message' => 'INVALID_LINK']);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'ALREADY_VERIFIED']);
        }

        $user->markEmailAsVerified();

        return response()->json(['message' => 'SUCCESS']);
    }
}

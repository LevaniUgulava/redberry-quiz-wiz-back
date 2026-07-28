<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateAvatarRequest;
use App\Services\UserProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(protected UserProfileService $userProfileService) {}

    public function updateAvatar(UpdateAvatarRequest $request): JsonResponse
    {
        $user = $this->userProfileService->updateAvatar(
            Auth::user(),
            $request->file('avatar')
        );

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
}

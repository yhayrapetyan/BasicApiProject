<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class EmailVerificationController extends Controller
{
    public function sendVerificationLink(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['status' => false, 'message' => 'user is already verified'], 400);
        }

        $request->user()->sendEmailVerificationNotification();
        return response()->json(['status' => true, 'message' => 'notification is sent'], 200);
    }

    public function verifyEmail(Request $request)
    {
        $user = User::query()->find($request->id);

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'user is not found',
            ]);
        }

        $user->update(['email_verified_at' => now()]);

        return response()->json([
            'status' => true,
            'message' => 'user has verified successfully',
        ]);
    }
}

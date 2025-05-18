<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->to(env('FRONTEND_URL') . '/verify-email?verified=0');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->to(env('FRONTEND_URL') . '/verify-email?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->to(env('FRONTEND_URL') . '/verify-email?verified=1');
    }
}

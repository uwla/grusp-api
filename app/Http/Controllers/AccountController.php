<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\User;
use App\Rules\PasswordRule;
use App\Rules\USPEmailRule;
// use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AccountController extends Controller
{
    /**
     * Get the profile of the authenticated user
     */
    public function getProfile(Request $request)
    {
        $user = $request->user();
        if ($user->hasAdministrationRole())
            $user->roles = $user->getRoleNames();
        return $user;
    }

    /**
     * Update the profile of the authenticated user
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $attr = $request->validate([
            'name' => 'required|string|min:2|max:50',
            'email' => ['required', 'email', new USPEmailRule()],
            'password' => ['nullable', 'string', 'confirmed', new PasswordRule()],
            'password_current' => ['required', 'current_password'],
        ]);

        // set password to the current, if new one not available
        $attr['password'] ??= $attr['password_current'];

        $user->update($attr);
        return $user;
    }

    /**
     * Get the grupos owned by the user making the request
     */
    public function grupos(Request $request)
    {
        $user = $request->user();
        $grupos = $user->getModels(Grupo::class);
        return Grupo::withExtraData($grupos);
    }

    /**
     * Verify the user's email.
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return response(['status' => 'verified'], 200);
    }

    /**
     * Send an email with a link to reset the user's password.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $credentials = ['email' => $request->email];
        $status = Password::broker()->sendResetLink($credentials);

        if ($status == Password::RESET_LINK_SENT)
            return response(['success' => 'true'], 200);

        return response([
            'errors' => [
                'email' => 'Unable to send reset password link'
            ]
        ], 400);
    }

    /**
     *  Reset the user's password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $attributes = $request->only([
            'email', 'password', 'password_confirmation', 'token'
        ]);

        $updateUserPasswordCallback = function (User $user, string $password) {
            $user->update(['password' => $password]);
            // event(new PasswordReset($user));
        };

        $status = Password::reset($attributes, $updateUserPasswordCallback);

        if ($status == Password::PASSWORD_RESET)
            return response('', 204);

        return response(['message' => 'Unable to reset password'], 400);
    }
}

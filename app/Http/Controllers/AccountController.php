<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Rules\PasswordRule;
use App\Rules\USPEmailRule;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Get the profile of the authenticated user
     */
    public function getProfile(Request $request)
    {
        return $request->user();
    }

    /**
     * Update the profile of the authenticated user
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $attr = $request->validate([
            'name'             => 'required|string|min:2|max:50',
            'email'            => ['required', 'email', new USPEmailRule()],
            'password'         => ['nullable', 'string', 'confirmed', new PasswordRule()],
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
}

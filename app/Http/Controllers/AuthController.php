<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\PasswordRule;
use App\Rules\USPEmailRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// basic auth controller
class AuthController extends Controller
{
    /**
     * Register new user
     */
    public function register(Request $request)
    {
        $request->validate($this->rules());
        return User::create($request->validated());
    }

    /**
     * Login the user by issuing a new token
     */
    public function login(Request $request)
    {
        $request->validate($this->rules());

        $user = User::where('email', $request->email)->firstOrFail();

        if (! Hash::check($request->password, $user->password))
        {
            return response('Login invalid', 503);
        }

        $token_name = Str::random(8);
        return $user->createToken($token_name)->plainTextToken;
    }

    /**
     * Logout the user by revoking the current access token
     */
    public function logout(Request $request)
    {
        // delete current token
        $request->user()->currentAccessToken()->delete();

        // return response
        return new Response(status: 204);
    }

    /**
     * Get the validation rules for registering/logging in
     * This is just basic rules. Surely it will be improved later on.
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', new USPEmailRule()],
            'password' => ['required', 'string', new PasswordRule()],
        ];
    }
}

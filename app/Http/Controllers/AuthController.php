<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\PasswordRule;
use App\Rules\USPEmailRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken as Token;
use Illuminate\Auth\Events\Registered;

// basic auth controller
class AuthController extends Controller
{
    /**
     * Register new user
     */
    public function register(Request $request)
    {
        // get the regular rules
        $rules = $this->rules();

        // add more rules
        $rules['name'] = 'required|string|min:2|max:80';
        $rules['password'][] = 'confirmed';

        // validate request
        $attr = $request->validate($rules);

        // create user using the validated attributes
        $user = User::create($attr);

        // add the default user role
        $user->addRole('user');

        // send email verification
        $user->sendEmailVerificationNotification();

        // return user
        return $user;
    }

    /**
     * Login the user by issuing a new token
     *
     * @return mixed
     */
    public function login(Request $request)
    {
        $request->validate($this->rules());

        $user = User::where('email', $request->email)->first();

        if ($user == null) {
            $errorMessage =  'Usuário com este email não encontrado.';
            $response = [
                'errors' => [ 'email' => [$errorMessage] ],
                'message' => $errorMessage
            ];
            return response($response, 404);
        }

        if (! Hash::check($request->password, $user->password))
        {
            $errorMessage =  'Senha incorreta.';
            $response = [
                'errors' => [ 'password' => [$errorMessage] ],
                'message' => $errorMessage
            ];
            return response($response, 403);
        }

        $token_name = Str::random(8);
        $token = $user->createToken($token_name)->plainTextToken;
        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    /**
     * Login an administrator user
     */
    public function loginAdmin(Request $request)
    {
        $response = $this->login($request);
        if (!is_array($response))
            return $response;

        $user = $response['user'];

        // if user has admin roles, return the user along with its roles
        if ($user->hasAdministrationRole())
        {
            $user->roles = $user->getRoleNames();
            return $response;
        }

        // else...
        // first, delete the token
        $tokenPlain = $response['token'];
        $token = $user->tokens()->where('id', $tokenPlain)->first();
        Token::where('id', $token->id)->delete();

        // then, return the error
        $errorMessage =  'Este usuário não tem privilégios administrativos.';
        $response = [
            'errors' => [ 'email' => [$errorMessage] ],
            'message' => $errorMessage
        ];
        return response($response, 403);
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
            // 'email' => ['required', 'email', new USPEmailRule()],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', new PasswordRule()],
        ];
    }
}

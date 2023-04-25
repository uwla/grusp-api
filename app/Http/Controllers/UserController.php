<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\PasswordRule;
use App\Rules\USPEmailRule;

class UserController extends Controller
{
    use CrudController;

    public function model()
    {
        return User::class;
    }

    public function rules()
    {
        return [
            'name'     => 'required|string|max:50',
            'email'    => ['required', 'email', new USPEmailRule()],
            'password' => ['required', 'string', new PasswordRule()]
        ];
    }
}

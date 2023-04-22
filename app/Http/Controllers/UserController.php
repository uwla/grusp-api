<?php

namespace App\Http\Controllers;

use App\Models\User;

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
            'email'    => 'required|email',
            'password' => 'required|string|min:10|max:100',
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Rules\PasswordRule;
use App\Rules\USPEmailRule;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Get a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $users = User::withRoleNames($users);
        return $users;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->roles = $user->getRoleNames();
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = $this->rules();
        $rules['password'] = 'required|string|min:10|max:50';
        $attr = $request->validate($rules);
        $model = User::create($attr);
        $model->addRoles($request->roles);
        $model->roles = $request->roles;
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $attr = $request->validate($this->rules());
        $user->update($attr);
        $user->setRoles($request->roles);
        $user->roles = $request->roles;
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $request = request();
        $request->validate(['password' => 'required|current_password']);
        $user->delAllPermissions();
        $user->delAllRoles();
        $user->delete();
        return $user;
    }

    /**
     * Get the validation rules.
     */
    public function rules()
    {
        $roles = Role::where('name', 'not like', "%App%Models%User%")->pluck('name');
        $in = Rule::in($roles);
        return [
            'name'     => 'required|string|min:2|max:50',
            'email'    => ['required', 'email', new USPEmailRule()],
            'password' => ['nullable', 'string', new PasswordRule()],
            'roles'    => 'required|array|min:1',
            'roles.*'  => ['string', $in]
        ];
    }
}

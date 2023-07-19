<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Role::withPermissionNames(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attr = $request->validate($this->rules());
        $role = Role::create($attr);
        $role->addPermissions($request->permissions);
        $role->permissions = $request->permissions;
        return $role;
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->permissions = $role->getPermissionNames();
        return $role;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $attr = $request->validate($this->rules());
        $role->update($attr);
        $role->setPermissions($request->permissions);
        $role->permissions = $request->permissions;
        return $role;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $request = request();
        $request->validate(['password' => 'required|current_password']);
        $role->delAllPermissions();
        $role->delete();
        return $role;
    }

    /**
     * Get the validation rules
     */
    public function rules()
    {
        $permissions = Permission::where('model_id', null)->pluck('name');
        $rule = Rule::in($permissions);

        return [
            'name' => 'required|string|max:25',
            'description' => 'nullable|string|max:250',
            'permissions' => 'array|required|min:1',
            'permissions.*' => ['string', $rule]
        ];
    }
}

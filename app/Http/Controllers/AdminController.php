<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminController extends Controller
{
    // Display all roles and permissions
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.index', compact('roles', 'permissions'));
    }


    public function createUserForm()
    {
        $roles = Role::all();
        return view('admin.create-user', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        // Assign the selected role to the user
        $user->assignRole($request->input('role'));
        return redirect()->route('admin.index')->with('success', 'User created and role assigned successfully!');
    }

    public function showUsers()
    {
        $users = User::all();
        return view('user.list', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    // Create a new role
    public function createRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);
    
        // Create the new role
        $role = Role::create([
            'name' => $request->input('role_name')
        ]);
    
        // Convert the permission IDs to their corresponding permission models
        $permissions = Permission::whereIn('id', $request->input('permissions'))->get();
        // Assign selected permissions to the role
        $role->syncPermissions($permissions);
        return redirect()->route('admin.createRoleForm')->with('success', 'Role created successfully with selected permissions!');
    }


    public function editRolePermissions($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all(); // Get all permissions
        return view('admin.edit-role-permissions', compact('role', 'permissions'));
    }

    public function updateRolePermissions(Request $request, $roleId)
    {
        // Find the role by its ID
        $role = Role::findOrFail($roleId);
        // Validate the request
        $request->validate([
            'permissions' => 'required|array', // Ensure permissions are selected
        ]);
        // Retrieve the permission models based on selected permission IDs
        $permissions = Permission::whereIn('id', $request->input('permissions'))->get();
        // Sync the permissions to the role (syncing models)
        $role->syncPermissions($permissions);
        return redirect()->route('admin.index')->with('success', 'Permissions updated successfully!');
    }



    // Assign permissions to a role
    public function assignPermissions(Request $request, $roleId)
    {
        // Validate the request to ensure permissions is an array
        $request->validate([
            'permissions' => 'array', // Ensure it's an array
        ]);
    
        // Find the role
        $role = Role::findOrFail($roleId);
    
        // Convert permission IDs to names
        $permissions = Permission::whereIn('id', $request->input('permissions', []))->pluck('name');
    
        // Sync the permissions to the role
        $role->syncPermissions($permissions);
        return redirect()->route('admin.index')->with('success', 'Permissions assigned successfully!');
    }



}

<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Permission;


use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function list()
    {
        $data['getRecord'] = Role::getRecord();
        return view('role.list',$data);
    }

    public function add()
    {
        return view('role.add');
    }

    public function insert(Request $rerquet)
    {
        $save = new Role;
        $save->name = $rerquet->name;
        $save->save();
        return redirect('/role')->with('success', "Role Created Successfuly");
    }

    public function edit($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return redirect()->route('roles.edit')->with('error', 'Role not found');
        }
        return view('role.edit', compact('role'));
    }


    public function update(Request $rerquet, $id)
    {   $rerquet->validate([
        'name' => 'required|string|max:255',
    ]);
        $role = Role::find($id);
        $role->name = $rerquet->name;
        $role->save();
        return redirect('/role')->with('success', 'Updated Successfull');

    }
    
}

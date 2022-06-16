<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::whereNotIn('name', ['admin'])->get();

        return response()->json([
            'status' => true,
            'roles' => $roles
        ]);
    }

    public function store(Request $request) { 
        $roles = Role::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Role created',
            'roles' => $roles
        ], 200);
    }

    public function update(Role $role, Request $request) {
        $role->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'roles udpated',
            'roles' => $role
        ], 200);
    }

    public function destroy(Role $role) {
        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'roles deleted',
            'roles' => $role
        ], 200);
    }

//     public function assignPermission(Request $request, Role $role) {
//         $role->permission()->sync($request->permission);

//         return response()->json([
//             'status' => true,
//             'message' => 'assing ready',
//             'role' => $role
//         ]);
//     }
}

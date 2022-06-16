<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index() {
        $permissions = Permission::all();

        return response()->json([
            'status' => true,
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request) {
        $permissions = Permission::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Permission Created',
            'permissions' => $permissions
        ], 200);
    }

    public function update(Request $request, Permission $permission) {

        $permission->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Pemission updated',
            'permission' => $permission
        ], 200);
    }

    public function destroy(Permission $permission) {

        $permission->delete();

        return response()->json([
            'status' => true,
            'message' => 'Permission Deleted',
            'permissions' -> $permission
        ], 200);
    }
}

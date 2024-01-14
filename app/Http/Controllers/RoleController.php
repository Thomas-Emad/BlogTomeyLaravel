<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

  function __construct()
  {
    $this->middleware(['permission:rolesPermissions']);
  }

  public function index(Request $request)
  {
    $roles = Role::orderBy('id', 'ASC')->get();
    return view('pages.admin.roles', compact('roles'));
  }
  public function roleInfo($roleID)
  {
    $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
      ->where("role_has_permissions.role_id", $roleID)
      ->pluck('id', 'name');
    return json_decode($rolePermissions);
  }
  public function create()
  {
    $permission = Permission::get();
    return view('pages.admin.roles.create', compact('permission'));
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|unique:roles,name',
      'permission' => 'required',
    ]);

    $role = Role::create(['name' => $request->input('name')]);
    $role->syncPermissions($request->input('permission'));

    return redirect()->route('roles.index')
      ->with('success', __("messages.roles.create"));
  }

  public function show($id)
  {
    $role = Role::find($id);
    $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
      ->where("role_has_permissions.role_id", $id)
      ->get();

    return view('roles.show', compact('role', 'rolePermissions'));
  }

  public function edit($id)
  {
    $role = Role::find($id);
    $permission = Permission::get();
    $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
      ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
      ->all();

    return view('pages.admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required',
      'permission' => 'required',
    ]);

    $role = Role::find($id);
    $role->name = $request->input('name');
    $role->save();

    $role->syncPermissions($request->input('permission'));

    return redirect()->route('roles.index')
      ->with('success', __("messages.roles.update"));
  }

  public function destroy(Request $request)
  {
    $id = $request->input("id");
    DB::table("roles")->where('id', $id)->delete();
    return redirect()->route('roles.index')
      ->with('success', __("messages.roles.delete"));
  }
}

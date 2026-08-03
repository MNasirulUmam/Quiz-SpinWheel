<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $pages = 'user';
        $roles = Role::with('permissions')->get();
        $auth  = Auth::user();
        return view('settings.roles.index', compact(
        'pages',
        'roles',
        'auth'
    ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = 'user';
        $auth  = Auth::user();
        $permissions = Permission::orderBy('name')->get();

        $groups = [];
        foreach ($permissions as $permission) {
            $parts = explode('-', $permission->name);
            $module = $parts[0];
            $action = $parts[1] ?? 'other';
            $groups[$module][$action] = $permission;
        }

        return view('settings.roles.create', compact('pages', 'groups', 'auth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('settings.roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
            $pages = 'user';
            $auth = Auth::user();
            $role = Role::findOrFail($id);
            $permissions = Permission::orderBy('name')->get();
            $rolePermissions = $role->permissions
                ->pluck('name')
                ->toArray();

            $groups = [];
            foreach ($permissions as $permission) {

                $parts = explode('-', $permission->name);

                $module = $parts[0];

                $action = $parts[1];

                $groups[$module][$action] = $permission;
            }

            return view(
                'settings.roles.edit',
                compact(
                    'pages',
                    'auth',
                    'role',
                    'groups',
                    'rolePermissions'
                )
            );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}

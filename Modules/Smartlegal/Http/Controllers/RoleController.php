<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\Menu;
use Modules\Smartlegal\Entities\Permission;
use Modules\Smartlegal\Entities\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $roles = Role::with('permission')->with('menu')
            ->orderBy('intMenuID')
            ->get();
        
            $transform = $roles->map(function ($row) {
                return [
                    'role_id' => $row->intRoleID,
                    'role_name' => $row->txtRoleName,
                    'menu_id' => $row->intMenuID,
                    'created_at' => $row->dtmCreatedAt,
                    'permission_name' => $row->permission->txtPermissionName,
                    'menu_name' => $row->menu->txtMenuTitle,
                    'desc' => $row->txtDesc
                ];
            });

            return DataTables::of($transform)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<button onclick="edit('.$row["role_id"].')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button>';
                })
                ->editColumn('created_at', function($row){
                    return date('Y-m-d H:i', strtotime($row['created_at']));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.role', [
                'menus' => Menu::get(['intMenuID', 'txtMenuTitle']),
                'permissions' => Permission::get(['intPermissionID', 'txtPermissionName'])
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('smartlegal::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Role::rules(), [], Role::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = Role::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Role created successfully'
            ], 200);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('smartlegal::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $role = Role::where('intRoleID', $id)->first();
        if ($role) {
            return response()->json([
                'status' => 'success',
                'data' => $role
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Not Found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Role::rules(), [], Role::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $role = Role::where('intRoleID', $id)->update($request->only(['intMenuID', 'intPermissionID', 'txtDesc']));
            if ($role) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Role updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role failed to update'
                ], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $role = Role::where('intRoleID', $id)->delete();
        if ($role) {
            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Role failed to delete'
            ], 400);
        }
    }
}

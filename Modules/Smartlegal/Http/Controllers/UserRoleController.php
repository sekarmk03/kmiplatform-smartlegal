<?php

namespace Modules\Smartlegal\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\Role;
use Modules\Smartlegal\Entities\UserRole;
use Yajra\DataTables\DataTables;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $roles = DB::table('kmi_smartlegal_2023.muserroles AS ur')
            ->leftJoin('db_standardization.musers AS u', 'u.id', '=', 'ur.intUserID')
            ->leftJoin('db_standardization.mdepartments AS d', 'd.intDepartment_ID', '=', 'u.intDepartment_ID')
            ->leftJoin('kmi_smartlegal_2023.mroles AS r', 'r.intRoleID', '=', 'ur.intRoleID')
            ->select([
                'ur.intUserRoleID', 'ur.intUserID', 'ur.intRoleID', 'ur.txtCreatedBy', 'ur.dtmCreatedAt',
                'u.txtName', 'u.txtInitial',
                'd.txtDepartmentName',
                'r.txtRoleName', 'r.txtDesc'
            ])
            ->get();
        
            $transform = $roles->map(function ($row) {
                return [
                    'userrole_id' => $row->intUserRoleID,
                    'created_at' => $row->dtmCreatedAt,
                    'name' => $row->txtName,
                    'initial' => $row->txtInitial,
                    'department' => $row->txtDepartmentName,
                    'role_name' => $row->txtRoleName,
                    'role_desc' => $row->txtDesc,
                    'created_by' => $row->txtCreatedBy,
                ];
            });

            return DataTables::of($transform)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<div class="btn-group"><button onclick="edit('. $row["userrole_id"] .')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button> <button onclick="destroy('. $row["userrole_id"] .')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fas fa-trash"></i></button></div>';
                })
                ->editColumn('created_at', function($row){
                    return date('Y-m-d H:i', strtotime($row['created_at']));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.userrole', [
                'users' => User::get(['id AS intUserID', 'txtName', 'txtInitial']),
                'roles' => Role::get(['intRoleID', 'txtRoleName'])
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
        $input = $request->only(['intUserID', 'intRoleID']);
        $validator = Validator::make($input, UserRole::rules(), [], UserRole::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $input['txtCreatedBy'] = Auth::user()->txtInitial;
            $create = UserRole::create($input);
            return response()->json([
                'status' => 'success',
                'message' => 'Access assigned successfully'
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
        $userrole = UserRole::where('intUserRoleID', $id)->first();
        if ($userrole) {
            return response()->json([
                'status' => 'success',
                'data' => $userrole
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
        $validator = Validator::make($request->all(), UserRole::rules(), [], UserRole::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $userrole = UserRole::where('intUserRoleID', $id)->update($request->only(['intUserID', 'intRoleID']));
            if ($userrole) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Access updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Access failed to update'
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
        $userrole = UserRole::where('intUserRoleID', $id)->delete();
        if ($userrole) {
            return response()->json([
                'status' => 'success',
                'message' => 'Access deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Access failed to delete'
            ], 400);
        }
    }
}

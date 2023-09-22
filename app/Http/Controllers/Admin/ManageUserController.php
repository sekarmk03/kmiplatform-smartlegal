<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\DepartmentModel as Department;
use App\Models\LevelModel as Level;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use App\Helpers\LevelAccess as LevelHelper;
use App\Models\CGModel;

class ManageUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $user = User::join('mlevels', 'mlevels.intLevel_ID','=', 'musers.intLevel_ID')
                ->join('mdepartments', 'mdepartments.intDepartment_ID', '=', 'musers.intDepartment_ID')
                ->get(['musers.*', 'mdepartments.txtDepartmentName', 'mlevels.txtLevelName']);
            return DataTables::of($user)
                ->addColumn('action', function($row){
                    return LevelHelper::btnUsersAction($row->id);
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $departments = Department::all();
            $levels = Level::all();
            return view('pages.admin.manage-user', [
                'levels' => $levels,
                'departments' => $departments,
                'cgs' => CGModel::all()
            ]);
        }
    }
    public function store(Request $request)
    {
        $input = $request->only([
            'txtName', 'txtUsername', 'txtNik', 
            'intLevel_ID', 'intDepartment_ID', 'txtInitial', 
            'txtEmail', 'txtPhoto'
        ]);
        $input['txtPassword'] = Hash::make($request->txtPassword);
        $validator = Validator::make($input, User::rules(), [], User::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            if ($request->hasFile('txtPhoto')) {
                $imageName = time().'.'.$request->txtPhoto->extension();
                $request->txtPhoto->move(public_path('img/user/'), $imageName);
                $input['txtPhoto'] = $imageName;
            }
            $create = User::create($input);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Created Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User Created Failed'
                ], 500);
            }
        }
    }
    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'status' => 'error',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not Found !'
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $input = $request->only([
            'txtName', 'txtUsername', 'txtNik', 
            'intLevel_ID', 'intDepartment_ID', 'txtInitial', 
            'txtEmail', 'txtPhoto'
        ]);
        $user = User::find($id);
        if ($user) {
            $validator = Validator::make($input, User::rules($id), [], User::attributes());
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'fields' => $validator->errors()
                ], 400);
            } else {
                if ($request->hasFile('txtPhoto')) {
                    if ($user->txtPhoto != 'default.png') {
                        $destroy = public_path('/img/user/'. $user->txtPhoto);
                        unlink($destroy);
                    }
                    $imageName = time().'.'.$request->txtPhoto->extension();
                    $request->txtPhoto->move(public_path('img/user/'), $imageName);
                    $input['txtPhoto'] = $imageName;
                }
                $update = $user->update($input);
                if ($update) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'User Updated Successfully'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User Updated Failed'
                    ], 500);
                }
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not Found !'
            ], 404);
        }
    }
    public function putChangePassword(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $validator = Validator::make($request->all(), ['txtPassword' => 'required'], [], ['txtPassword' => 'Password']);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'fields' => $validator->errors()
                ], 400);
            } else {
                $user->update([
                    'txtPassword' => Hash::make($request->txtPassword)
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Password Reset Successfully'
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not Found !'
            ], 404);
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            if ($user->txtPhoto != 'default.png') {
                $destroy = public_path('/img/user/'. $user->txtPhoto);
                unlink($destroy);
            }
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not Found !'
            ], 404);
        }
    }
}

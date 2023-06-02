<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Helpers\LevelAccess as LevelHelp;
use App\Models\DepartmentModel as Department;
use App\Models\SubdepartmentModel as Subdepartment;

class ManageSubdepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $datas = Subdepartment::join('mdepartments AS mdept', 'mdept.intDepartment_ID', '=', 'msubdepartments.intDepartment_ID')
                ->get(['msubdepartments.*', 'mdept.txtDepartmentName']);
            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return LevelHelp::btnAction($row->intSubdepartment_ID);
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('pages.admin.manage-subdepartments', [
                'departments' => Department::get(['intDepartment_ID', 'txtDepartmentName'])
            ]);
        }
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Subdepartment::rules(), [], Subdepartment::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = Subdepartment::create($input);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Subdepartment Created Successfully !'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Internal server Error !'
                ], 500);
            }
        }
    }
    public function edit($id)
    {
        $data = Subdepartment::find($id);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Exist !'
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $input = $request->only(['intDepartment_ID', 'txtSubdepartmentName', 'txtCreatedBy', 'txtUpdatedBy']);
        $validator = Validator::make($input, Subdepartment::rules(), [], Subdepartment::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $data = Subdepartment::find($id);
            if ($data) {
                $data->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Sub Department updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not Exist !'
                ], 404);
            }
        }
    }
    public function destroy($id)
    {
        $data = Subdepartment::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Sub Department deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Exist !'
            ], 404);
        }
    }
}

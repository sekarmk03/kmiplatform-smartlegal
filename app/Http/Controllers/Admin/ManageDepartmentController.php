<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Models\DepartmentModel as Department;
use App\Helpers\LevelAccess as LevelHelp;
use VisitLog;
use App\Models\Notification;

class ManageDepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $departments = Department::all();
            return DataTables::of($departments)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return LevelHelp::btnAction($row->intDepartment_ID);
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            VisitLog::save();
            return view('pages.admin.manage-departments');
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Department::rules(), [], Department::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = Department::create($request->all());
            Notification::create([
                'txtnotification' => 'Department ditambah!'
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Department created Successfully'
            ], 200);
        }
    }
    public function edit($id)
    {
        $department = Department::where('intDepartment_ID', $id)->first();
        if ($department) {
            return response()->json([
                'status' => 'success',
                'department' => $department
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Department not Found'
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Department::rules(), [], Department::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $level = Department::where('intDepartment_ID', $id)->update($request->only(['txtDepartmentName', 'txtInitial']));
            if ($level) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Department Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Department updated Failed'
                ], 500);
            }
        }
    }
    public function destroy($id)
    {
        $department = Department::where('intDepartment_ID', $id)->delete();
        if ($department) {
            Notification::create([
                'txtnotification' => 'Department ditambah!'
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Department deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Department deleted Failed'
            ], 400);
        }
    }
    
    public function listUsers(){
        return response()->json([
            'status' => 'success',
            'data' => Department::departmentModule() 
        ], 200);
    }
}

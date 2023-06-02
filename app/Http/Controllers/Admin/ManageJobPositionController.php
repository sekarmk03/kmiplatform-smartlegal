<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Helpers\LevelAccess as LevelHelp;
use App\Models\JobPositionModel as JobPosition;
use App\Models\DepartmentModel as Department;

class ManageJobPositionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $datas = JobPosition::join('mdepartments AS mdept', 'mdept.intDepartment_ID', '=', 'mjabatans.intDepartment_ID')
                ->get(['mjabatans.*', 'mdept.txtDepartmentName']);
            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return LevelHelp::btnAction($row->intJabatan_ID);
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('pages.admin.manage-jobpositions', [
                'departments' => Department::get(['intDepartment_ID', 'txtDepartmentName'])
            ]);
        }
    }
    public function store(Request $request)
    {
        $input = $request->only(['intDepartment_ID', 'txtNamaJabatan', 'txtCreatedBy', 'txtUpdatedBy']);
        $validator = Validator::make($input, JobPosition::rules(), [], JobPosition::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = JobPosition::create($input);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Job Position inserted Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Internal server error !'
                ], 500);
            }
        }
    }
    public function edit($id)
    {
        $data = JobPosition::find($id);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Found !'
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $input = $request->only(['intDepartment_ID', 'txtNamaJabatan', 'txtCreatedBy', 'txtUpdatedBy']);
        $validator = Validator::make($input, JobPosition::rules(), [], JobPosition::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $jobposition = JobPosition::find($id);
            if ($jobposition) {
                $jobposition->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Job Position updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not Found !'
                ], 404);
            }
        }
    }
    public function destroy($id)
    {
        $data = JobPosition::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Job Position deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Found !'
            ], 404);
        }
    }
}

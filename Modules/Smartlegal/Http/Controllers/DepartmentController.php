<?php

namespace Modules\Smartlegal\Http\Controllers;

use App\Models\DepartmentModel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $issuers = DB::table('db_standardization.mdepartments')->get();

            return DataTables::of($issuers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<button onclick="edit('.$row->intDepartment_ID.')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.department');
        }
    }

    public function getAllDepartments() {
        $data = DepartmentModel::all();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
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
        //
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
        $department = DepartmentModel::where('intDepartment_ID', $id)->first();
        if ($department) {
            return response()->json([
                'status' => 'success',
                'data' => $department
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
        $validator = Validator::make($request->all(), DepartmentModel::rules(), [], DepartmentModel::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $department = DepartmentModel::where('intDepartment_ID', $id)->update($request->only(['txtDepartmentName', 'txtInitial']));
            if ($department) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Department updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Department failed to update'
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
        //
    }
}

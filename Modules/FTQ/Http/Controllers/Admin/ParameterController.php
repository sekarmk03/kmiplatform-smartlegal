<?php

namespace Modules\FTQ\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

//Model
use Modules\FTQ\Entities\Parameter;
use Modules\FTQ\Entities\TrParameter;
//Package
use Yajra\DataTables\DataTables;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = Parameter::orderBy('intParameter_ID', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_edit = '<button onclick="edit('.$row->intParameter_ID.')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></button>';
                    $btn_delete = '<button class="btn btn-sm btn-danger" onclick="destroy('.$row->intParameter_ID.')"><i class="fa-solid fa-trash"></i></button>';
                    return '<div class="btn-group">'.$btn_edit.' '.$btn_delete.'</div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->editColumn('txtInputType', function($row){
                    return strtoupper($row->txtInputType);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('ftq::pages.admin.parameter');
        }        
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ftq::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $input = $request->only([
            'txtParameter', 'txtStandar', 'txtInputType', 'intMin', 'intMax',
            'txtCreatedBy', 'txtUpdatedBy'
        ]);
        $validator = Validator::make($input, Parameter::rules(), [], Parameter::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $create = Parameter::create($input);
            if ($create) {
                if ($input['txtInputType'] == 'select') {
                    $result = [];
                    foreach ($request->intCustomParameter_ID as $key => $val) {
                        $result[] = [
                            'intParameter_ID' => $create->intParameter_ID,
                            'intCustomParameter_ID' => $val
                        ];
                    }
                    TrParameter::insert($result);
                }
                return response()->json([
                    'status' => 'message',
                    'message' => 'Parameter created successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'internal server error'
                ], 500);
            }
        }        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ftq::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = Parameter::with('tr_parameter')->find($id);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data parameter not exist'
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
        $input = $request->only([
            'txtParameter', 'txtStandar', 'txtInputType', 'intMin', 'intMax',
            'txtCreatedBy', 'txtUpdatedBy'
        ]);
        $validator = Validator::make($input, Parameter::rules(), [], Parameter::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $data = Parameter::find($id);
            if ($data) {
                $update = $data->update($input);
                if ($update) {
                    if ($input['txtInputType'] == 'select') {
                        $result = [];
                        foreach ($request->intCustomParameter_ID as $key => $val) {
                            $result[] = [
                                'intParameter_ID' => $id,
                                'intCustomParameter_ID' => $val
                            ];
                        }
                        TrParameter::insert($result);
                    }
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data Parameter deleted successfully'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Internal server error'
                    ], 500);
                }                                
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data parameter not exist'
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        $data = Parameter::find($id);
        if ($data) {
            $data->update(['txtDeletedBy' => $request->txtDeletedBy]);
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data Parameter deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data parameter not exist'
            ], 404);
        }
    }
}

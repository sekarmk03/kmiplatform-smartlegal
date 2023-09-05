<?php

namespace Modules\FTQ\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

//Model
use Modules\FTQ\Entities\CustomParameter;

//Package
use Yajra\DataTables\DataTables;

class CustomParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = CustomParameter::orderBy('intCustomParameter_ID', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_edit = '<button onclick="edit('.$row->intCustomParameter_ID.')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></button>';
                    $btn_delete = '<button class="btn btn-sm btn-danger" onclick="destroy('.$row->intCustomParameter_ID.')"><i class="fa-solid fa-trash"></i></button>';
                    return '<div class="btn-group">'.$btn_edit.' '.$btn_delete.'</div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('ftq::pages.admin.custom-parameter');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list()
    {
        $data = CustomParameter::all();
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Custom Parameter not Exist'
            ], 404);
        }     
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $input = $request->only(['txtCustomValue', 'txtCreatedBy', 'txtUpdatedBy']);
        $validator = Validator::make($input, CustomParameter::rules(), [], CustomParameter::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $create = CustomParameter::create($input);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Custom Parameter Created Successfully'
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
        $data = CustomParameter::find($id);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Custom Parameter not Exist'
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
        $input = $request->only(['txtCustomValue', 'txtUpdatedBy']);
        $validator = Validator::make($input, CustomParameter::rules(), [], CustomParameter::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $data = CustomParameter::find($id);
            if ($data) {
                $data->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Custom Parameter updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data Custom Parameter not Exist'
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
        $data = CustomParameter::find($id);
        if ($data) {
            $data->update(['txtDeletedBy' => $request->txtDeletedBy]);
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Custom Parameter deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Custom Parameter not Exist'
            ], 404);
        }        
    }
}

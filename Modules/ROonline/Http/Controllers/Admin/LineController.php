<?php

namespace Modules\ROonline\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\ROonline\Entities\Line;
use Yajra\DataTables\DataTables;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = Line::All();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_edit = '<button onclick="edit('.$row->intLine_ID.')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></button>';
                    $btn_delete = '<button class="btn btn-sm btn-danger" onclick="destroy('.$row->intLine_ID.')"><i class="fa-solid fa-trash"></i></button>';
                    return '<div class="btn-group">'.$btn_edit.' '.$btn_delete.'</div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('roonline::pages.admin.line');
        }        
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('roonline::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $input = $request->only(['txtLineProcessName', 'txtCreatedBy', 'txtUpdatedBy']);
        $validator = Validator::make($input, Line::rules(), [], Line::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = Line::create($input);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Line created Successfully'
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
        return view('roonline::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = Line::find($id);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
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
        $input = $request->only(['txtLineProcessName', 'txtUpdatedBy']);
        $validator = Validator::make($input, Line::rules(), [], Line::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $data = Line::find($id);
            if ($data) {
                $update = $data->update($input);
                if ($update) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Line updated Successfully'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'internal server error'
                    ], 500);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not found'
                ], 404);
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
        $data = Line::find($id);
        if ($data) {
            $data->update([
                'txtDeletedBy' => Auth::user()->txtName
            ]);
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Line deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        } 
    }
}

<?php

namespace Modules\ROIS\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Modules\ROIS\Entities\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = Menu::orderBy('intMenu_ID', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_edit = '<button onclick="edit('.$row->intMenu_ID.')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></button>';
                    $btn_delete = '<button class="btn btn-sm btn-danger" onclick="destroy('.$row->intMenu_ID.')"><i class="fa-solid fa-trash"></i></button>';
                    return '<div class="btn-group">'.$btn_edit.' '.$btn_delete.'</div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('roonline::pages.admin.menu');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list()
    {
        $data = Menu::all();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $input = $request->only(['txtMenuTitle', 'txtMenuIcon', 'txtMenuUrl', 'txtMenuRoute', 'intQueue']);
        $validator = Validator::make($input, Menu::rules(), [], Menu::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $create = Menu::create($input);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Menu created Successfully'
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
        return view('rois::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = Menu::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $input = $request->only(['txtMenuTitle', 'txtMenuIcon', 'txtMenuUrl', 'txtMenuRoute', 'intQueue']);
        $validator = Validator::make($input, Menu::rules($id), [], Menu::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $data = Menu::find($id);
            if ($data) {
                $data->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Menu updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data Menu not exist'
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
        $data = Menu::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menu deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Menu not exist'
            ], 404);
        }
    }
}

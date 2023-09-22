<?php

namespace Modules\FTQ\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Modules\FTQ\Entities\Level;
use Modules\FTQ\Entities\LevelMenu;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = Level::orderBy('intLevel_ID', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_edit = '<button onclick="edit('.$row->intLevel_ID.')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></button>';
                    $btn_delete = '<button class="btn btn-sm btn-danger" onclick="destroy('.$row->intLevel_ID.')"><i class="fa-solid fa-trash"></i></button>';
                    return '<div class="btn-group">'.$btn_edit.' '.$btn_delete.'</div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('ftq::pages.admin.level');
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
        $input = $request->only(['txtLevelName']);
        $validator = Validator::make($input, Level::rules(), [], Level::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 401);
        } else {
            $create = Level::create($input);
            if ($create) {
                $result = [];
                foreach ($request->intMenu_ID as $key => $item) {
                    $result[] = [
                        'intLevel_ID' => $create->intLevel_ID,
                        'intMenu_ID' => $item
                    ];
                }
                LevelMenu::insert($result);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Level created Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Internal Server Error'
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
        $data = Level::find($id);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Level not Exist!'
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
        $input = $request->only(['txtLevelName']);
        $validator = Validator::make($input, Level::rules(), [], Level::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 401);
        } else {
            $data = Level::find($id);
            if ($data) {
                $data->update($input);
                LevelMenu::where('intLevel_ID', $id)->delete();
                $result = [];
                foreach ($request->intMenu_ID as $key => $item) {
                    $result[] = [
                        'intLevel_ID' => $id,
                        'intMenu_ID' => $item
                    ];
                }
                LevelMenu::insert($result);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Level updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data Level not Exist!'
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
        $data = Level::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Level deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Level not Exist!'
            ], 404);
        }
    }
}

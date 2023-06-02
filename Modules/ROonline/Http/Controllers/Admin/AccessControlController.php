<?php

namespace Modules\ROonline\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;
use Modules\ROonline\Entities\MLevel as level;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccessControlController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $rules = [
        'txtLevelName' => 'required',
        'user_id' => 'required'
    ];
    protected $attributes = [
        'txtLevelName' => 'Level Name',
        'user_id' => 'Users Select'
    ];
    private function _listLevels(){
        return level::orderBy('intLevel_ID', 'DESC')->get();
    }
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = $this->_listLevels();
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
            $users = User::all();
            return view('roonline::pages.admin.access-control', [
                'users' => $users
            ]);
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
        //
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
        $data = level::find($id);
        $list = [];
        $user_id = DB::connection('roonline')->table('truser_level')
            ->where('intLevel_ID', $id)
            ->get('user_id');
        foreach ($user_id as $key => $val) {
            array_push($list, $val->user_id);
        }
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'list' => $list
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Found!'
            ], 404);
        }        
    }
    
    public function getUser($id){
        $list = [];
        $user_id = DB::connection('roonline')->table('truser_level')
            ->where('intLevel_ID', '<>', $id)
            ->get('user_id');
        foreach ($user_id as $key => $val) {
            array_push($list, $val->user_id);
        }
        $data = User::whereNotIn('id', $list)->get(['id', 'txtName']);
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'list' => $list
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
        $input = $request->only(['txtLevelName', 'user_id']);
        $validator = Validator::make($input, $this->rules, [], $this->attributes);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' =>  $validator->errors()
            ], 400);
        } else {
            $level = Level::find($id);
            if ($level) {
                $users = $request->user_id;
                $result = [];
                foreach ($users as $key => $val) {
                    $result[] = [
                        'intLevel_ID' => $id,
                        'user_id' => $val
                    ];
                }            
                DB::connection('roonline')
                    ->table('truser_level')
                    ->where('intLevel_ID', $id)
                    ->delete();
                DB::connection('roonline')
                    ->table('truser_level')
                    ->insert($result);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Access has been updated !'
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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

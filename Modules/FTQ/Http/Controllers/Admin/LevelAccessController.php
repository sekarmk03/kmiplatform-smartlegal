<?php

namespace Modules\FTQ\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Modules\FTQ\Entities\Level;
use Modules\FTQ\Entities\LevelAccess;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LevelAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $rules = [
        'user_id' => 'required'
    ];
    protected $attributes = [
        'user_id' => 'ID User'
    ];
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = Level::orderBy('intLevel_ID', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_edit = '<button onclick="edit('.$row->intLevel_ID.')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></button>';
                    return '<div class="btn-group">'.$btn_edit.'</div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('ftq::pages.admin.level-access');
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
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = Level::with('access')->find($id);
        $list = [];
        $user_id = DB::connection('ftq')->table('truser_level')
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
                'message' => 'Data Access not Found !'
            ], 404);
        }
    }
    public function getUser($id){
        $list = [];
        $user_id = DB::connection('ftq')->table('truser_level')
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ftq::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $input = $request->only(['user_id']);
        $validator = Validator::make($input, $this->rules, [], $this->attributes);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 401);
        } else {
            $result = [];
            foreach ($request->user_id as $key => $val) {
                $result[] = [
                    'intLevel_ID' => $id,
                    'user_id' => $val
                ];
            }
            LevelAccess::insert($result);
            return response()->json([
                'status' => 'success',
                'message' => 'Access Level has been updated !'
            ], 200);
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

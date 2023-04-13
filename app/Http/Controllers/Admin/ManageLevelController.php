<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LevelModel as Level;
use Yajra\DataTables\DataTables;
use App\Helpers\LevelAccess as LevelHelp;
use Illuminate\Support\Facades\Auth;
use App\Models\SubmenuModel as Submenu;
use App\Models\LevelAccessModel as LevelAccess;

class ManageLevelController extends Controller
{
    public function getIndex(Request $request)
    {
        if ($request->wantsJson()) {
            $levels = Level::all();
            return DataTables::of($levels)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return LevelHelp::btnLevelAction($row->intLevel_ID);
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('pages.admin.manage-levels');
        }
    }
    public function postLevel(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Level::rules(), [], Level::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $input['txtCreatedBy'] = Auth::user()->txtName;
            $create = Level::create($input);
            return response()->json([
                'status' => 'success',
                'message' => 'Level created Successfully'
            ], 200);
        }
    }
    public function editLevel($id)
    {
        $level = Level::find($id);
        if ($level) {
            return response()->json([
                'status' => 'success',
                'level' => $level
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Level not Found'
            ], 400);
        }
    }
    public function getAccess($id)
    {
        $access = Submenu::with('routes')
            ->with('access', function ($query) use ($id) {
                $query->where('intLevel_ID', $id);
            })
            ->get();
        if ($access){
            return response()->json([
                'status' => 'success',
                'level' => $access
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Level not Found'
            ], 400);
        }
    }
    public function updateLevel(Request $request, $id)
    {
        $input = $request->only(['txtLevelName']);
        $validator = Validator::make($input, Level::rules(), [], Level::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $level = Level::find($id);
            if ($level) {
                $input['txtUpdatedBy'] = Auth::user()->txtName;
                $level->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Level Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Level updated Failed'
                ], 500);
            }
        }
    }
    public function changeAccess($id, Request $request)
    {
        $level = Level::find($id);
        if ($level) {
            $route = $request->route_id;
            $submenu = $request->submenu_id;
            $result = [];
            foreach ($route as $i => $val) {
                $result[] = [
                    'intLevel_ID' => $id,
                    'intSubmenu_ID' => $submenu[$i],
                    'intRoute_ID' => $route[$i],
                    'intAccessible' => $request->intAccess[$i],
                ];
            }
            LevelAccess::where('intLevel_ID', $id)->delete();
            LevelAccess::insert($result);
            return response()->json([
                'status' => 'success',
                'message' => 'Level Access changed Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Level created Failed'
            ], 404);
        }
    }
    public function destroyLevel($id)
    {
        $level = Level::find($id);
        if ($level) {
            $level->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Level deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Level created Failed'
            ], 404);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuModel as Menu;
use App\Models\SubmenuModel as Submenu;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Helpers\LevelAccess as LevelHelp;

class ManageSubmenuController extends Controller
{
    public function getIndex(Request $request)
    {
        if ($request->wantsJson()) {
            $menus = Submenu::join('mmenus', 'mmenus.intMenu_ID','=', 'msubmenus.intMenu_ID')
                ->get(['msubmenus.*', 'mmenus.txtMenuTitle']);
            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return LevelHelp::btnAction($row->intSubmenu_ID);
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $menus = Menu::all();
            return view('pages.admin.manage-submenu', [
                'menus' => $menus
            ]);
        }
    }
    public function postSubmenu(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Submenu::rules(), [], Submenu::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $input['txtCreatedBy'] = Auth::user()->txtName;
            $create = Submenu::create($input);
            $routes = [];
            $routetitle = $request->txtRouteTitle;
            foreach ($routetitle as $key => $val) {
                $routes[] = [
                    'intSubmenu_ID' => $create->intSubmenu_ID,
                    'txtRouteTitle' => $routetitle[$key],
                    'txtRouteName' => $request->RouteName[$key]
                ];
            }
            DB::table('trroutes')->insert($routes);
            return response()->json([
                'status' => 'success',
                'message' => 'Submenu created Successfully'
            ], 200);
        }
    }
    public function editSubmenu($id)
    {
        $submenu = Submenu::with('routes')->find($id);
        if ($submenu) {
            return response()->json([
                'status' => 'success',
                'submenu' => $submenu,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'submenu not Found'
            ], 404);
        }
    }
    public function updateSubmenu(Request $request, $id)
    {
        $input = $request->only([
            'intMenu_ID', 'txtSubmenuTitle', 'txtSubmenuIcon', 'txtUrl', 'txtRouteName'
        ]);
        $validator = Validator::make($input, Submenu::rules(), [], Submenu::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $submenu = Submenu::find($id);
            if ($submenu) {
                $input['txtUpdatedBy'] = Auth::user()->txtName;
                $submenu->update($input);
                $routetitle = $request->txtRouteTitle;
                foreach ($routetitle as $key => $val) {
                    if (isset($request->routeId[$key])) {
                        DB::table('trroutes')->where('intRoute_ID', $request->routeId[$key])->update([
                            'txtRouteTitle' => $routetitle[$key],
                            'txtRouteName' => $request->RouteName[$key]
                        ]);
                    } else {
                        DB::table('trroutes')->insert([
                            'intSubmenu_ID' => $id,
                            'txtRouteTitle' => $routetitle[$key],
                            'txtRouteName' => $request->RouteName[$key]
                        ]);
                    }
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Submenu Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Submenu updated Failed'
                ], 500);
            }
        }
    }
    public function destroySubmenu($id)
    {
        $submenu = Submenu::find($id);
        if ($submenu) {
            $submenu->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Submenu deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Submenu created Failed'
            ], 400);
        }
    }
}

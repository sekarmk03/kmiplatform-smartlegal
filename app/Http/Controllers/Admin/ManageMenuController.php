<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MenuModel as Menu;
use Yajra\DataTables\DataTables;
use App\Helpers\LevelAccess as LevelHelp;
use Illuminate\Support\Facades\Auth;

class ManageMenuController extends Controller
{
    public function getIndex(Request $request)
    {
        if ($request->wantsJson()) {
            $menus = Menu::all();
            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return LevelHelp::btnAction($row->intMenu_ID);
                })
                ->editColumn('txtMenuIcon', function($row){
                    return '<i class="'.$row->txtMenuIcon.'"></i>';
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('pages.admin.manage-menu');
        }
    }
    public function postMenu(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Menu::rules(), [], Menu::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $input['txtCreatedBy'] = Auth::user()->txtName;
            $create = Menu::create($input);
            return response()->json([
                'status' => 'success',
                'message' => 'Menu created Successfully'
            ], 200);
        }
    }
    public function editMenu($id)
    {
        $menu = Menu::where('intMenu_ID', $id)->first();
        if ($menu) {
            return response()->json([
                'status' => 'success',
                'menu' => $menu
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not Found'
            ], 404);
        }
    }
    public function updateMenu(Request $request, $id)
    {
        $input = $request->only([
            'txtMenuTitle', 'txtMenuIcon'
        ]);
        $validator = Validator::make($input, Menu::rules(), [], Menu::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $level = Menu::find($id);
            $input['txtUpdatedBy'] = Auth::user()->txtName;
            if ($level) {
                $level->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Menu Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu updated Failed'
                ], 500);
            }
        }
    }
    public function destroyMenu($id)
    {
        $menu = Menu::where('intMenu_ID', $id)->delete();
        if ($menu) {
            return response()->json([
                'status' => 'success',
                'message' => 'Menu deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not Found'
            ], 404);
        }
    }
}

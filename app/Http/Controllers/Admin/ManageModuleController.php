<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ModuleModel as Module;
use Yajra\DataTables\DataTables;
use App\Helpers\LevelAccess as LevelHelp;
use Illuminate\Support\Facades\Artisan;
use File;

class ManageModuleController extends Controller
{
    public function getIndex(Request $request)
    {
        if ($request->wantsJson()) {
            if (Auth::user()->intLevel_ID == 1) {
                $modules = $this->_adminList();
            } else {
                $modules = $this->_championModule();
            }
            return DataTables::of($modules)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    if ($row->intStatus == 1) {
                        $status = '<span class="badge bg-success">Enabled</span>';
                    } else {
                        $status = '<span class="badge bg-danger">Disabled</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    return LevelHelp::btnAction($row->intModule_ID);
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        } else {
            return view('pages.admin.manage-modules');
        }
    }

    public function storeModule(Request $request)
    {
        $input = $request->only(['txtModuleName']);
        $validator = Validator::make($input, Module::rules(), [], Module::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            if (empty($request->intStatus)) {
                $input['intStatus'] = 0;
            }
            $input['txtModuleName'] = htmlspecialchars($request->txtModuleName);
            $input['user_id'] = Auth::user()->id;
            $input['txtCreatedBy'] = Auth::user()->txtName;
            $module = Module::create($input);
            if ($module) {
                Artisan::call('module:make '.htmlspecialchars($request->txtModuleName));
                if (empty($request->intStatus)) {
                    Artisan::call('module:disable '.htmlspecialchars($request->txtModuleName));
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Module created Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Internal Server Error'
                ], 500);
            }
        }
    }

    public function editModule($id)
    {
        $module = Module::find($id);
        if ($module) {
            return response()->json([
                'status' => 'success',
                'module' => $module
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Module not found'
            ], 404);
        }
    }
    public function updateModule($id, Request $request)
    {
        $input = $request->only(['txtModuleName']);
        $validator = Validator::make($input, Module::rules(), [], Module::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $module = Module::find($id);
            if ($module) {
                if (empty($request->intStatus)) {
                    $input['intStatus'] = 0;
                    Artisan::call('module:disable '.$module->txtModuleName);
                } else {
                    $input['intStatus'] = 1;
                    Artisan::call('module:enable '.$module->txtModuleName);
                }
                $input['user_id'] = Auth::user()->id;
                $input['txtUpdatedBy'] = Auth::user()->txtName;
                $module->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Module updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Module not found'
                ], 404);
            }
        }
    }

    public function destroyModule($id)
    {
        $module = Module::find($id);
        if ($module) {
            //Windows
            File::deleteDirectory(base_path('Modules/'.$module->txtModuleName));
            Artisan::call('cache:clear');
            $module->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Module deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Module not found'
            ], 404);
        }
    }

    private function _adminList()
    {
        return Module::orderBy('intModule_ID', 'DESC')->get();
    }
    private function _championModule(){
        return Module::join('musers', 'musers.id', '=', 'mmodules.user_id')
            ->where('musers.intDepartment_ID', Auth::user()->intDepartment_ID)
            ->get();
    }
}

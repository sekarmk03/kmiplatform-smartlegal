<?php

namespace Modules\ROIS\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Modules\ROIS\Entities\DeviceModel as Device;
use Modules\ROIS\Entities\LocaterModel as Locater;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private function _listDevices(){
        return Device::orderBy('intROModule_ID', 'DESC')->get();
    }
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $devices = $this->_listDevices();
            return DataTables::of($devices)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_edit = '<button onclick="edit('.$row->intROModule_ID.')" class="btn btn-sm btn-success" onclick="view('.$row->intROModule_ID.')"><i class="fa-solid fa-pen-to-square"></i></button>';
                    $btn_delete = '<button class="btn btn-sm btn-danger" onclick="destroy('.$row->intROModule_ID.')"><i class="fa-solid fa-trash"></i></button>';
                    return $btn_edit.' '.$btn_delete;
                })
                ->editColumn('dtmInserted', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmInserted));
                })
                ->addColumn('status', function($row){
                    if ($row->bitActive) {
                        $status = '<span class="badge bg-success">Active</span>';
                    } else {
                        $status = '<span class="badge bg-danger">Non-active</span>';
                    }
                    return $status;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        } else {
            $locater = Locater::all();
            return view('roonline::pages.admin.devices', [
                'locaters' => $locater
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('rois::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $input = $request->only(['txtModuleName', 'intLocater_ID', 'txtInsertedBy', 'txtUpdatedBy']);
        $validator = Validator::make($input, Device::rules(), [], Device::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            if ($request->has('activate')) {
                $input['bitActive'] = 1;
            } else {
                $input['bitActive'] = 0;
            }
            $create = Device::create($input);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Device inserted successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Internal server error'
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
        $device = Device::find($id);
        if ($device) {
            return response()->json([
                'status' => 'success',
                'device' => $device
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
        $input = $request->only(['txtModuleName', 'intLocater_ID', 'txtUpdatedBy']);
        $validator = Validator::make($input, Device::rules(), [], Device::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $device = Device::find($id);
            if ($device) {
                if ($request->has('activate')) {
                    $input['bitActive'] = 1;
                } else {
                    $input['bitActive'] = 0;
                }
                $device->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Device updated successfully'
                ], 200);
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
        $device = Device::find($id);
        if ($device) {
            $device->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Device deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }
    }
}

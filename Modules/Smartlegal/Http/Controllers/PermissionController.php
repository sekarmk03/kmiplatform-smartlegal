<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $permissions = Permission::all();

            return DataTables::of($permissions)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<button onclick="edit('.$row->intPermissionID.')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('smartlegal::create');
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
        return view('smartlegal::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $permission = Permission::where('intPermissionID', $id)->first();
        if ($permission) {
            return response()->json([
                'status' => 'success',
                'data' => $permission
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Not Found'
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
        $validator = Validator::make($request->all(), Permission::rules(), [], Permission::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $permission = Permission::where('intPermissionID', $id)->update($request->only(['txtPermissionName', 'txtDesc']));
            if ($permission) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Permission updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission failed to update'
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

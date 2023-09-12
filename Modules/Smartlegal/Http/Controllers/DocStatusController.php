<?php

namespace Modules\Smartlegal\Http\Controllers;

use App\Models\Notification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\DocStatus;
use Yajra\DataTables\DataTables;

class DocStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $status = DocStatus::all();

            return DataTables::of($status)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<div class="btn-group"><button onclick="edit('.$row->intDocStatusID.')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button> <button onclick="destroy('.$row->intDocStatusID.')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fas fa-trash"></i></button></div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.docstatus');
        }
    }

    public function getAllStatuses() {
        $data = DocStatus::all();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
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
        $validator = Validator::make($request->all(), DocStatus::rules(), [], DocStatus::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = DocStatus::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Document Status created successfully'
            ], 200);
        }
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
        $status = DocStatus::where('intDocStatusID', $id)->first();
        if ($status) {
            return response()->json([
                'status' => 'success',
                'data' => $status
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
        $validator = Validator::make($request->all(), DocStatus::rules(), [], DocStatus::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $status = DocStatus::where('intDocStatusID', $id)->update($request->only(['txtStatusName', 'txtDesc']));
            if ($status) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Document Status updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Document Status failed to update'
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
        $status = DocStatus::where('intDocStatusID', $id)->delete();
        if ($status) {
            return response()->json([
                'status' => 'success',
                'message' => 'Document Status deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Document Status failed to delete'
            ], 400);
        }
    }
}

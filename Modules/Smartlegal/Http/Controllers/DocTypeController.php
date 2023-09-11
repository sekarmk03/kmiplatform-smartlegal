<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\DocType;
use Yajra\DataTables\DataTables;

class DocTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $types = DocType::all();

            return DataTables::of($types)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<div class="btn-group"><button onclick="edit('.$row->intDocTypeID.')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button> <button onclick="destroy('.$row->intDocTypeID.')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fas fa-trash"></i></button></div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.doctype');
        }
    }

    public function getAllTypes() {
        $data = DocType::all();
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
        $validator = Validator::make($request->all(), DocType::rules(), [], DocType::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = DocType::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Document Type created successfully'
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
        $type = DocType::where('intDocTypeID', $id)->first();
        if ($type) {
            return response()->json([
                'status' => 'success',
                'data' => $type
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
        $validator = Validator::make($request->all(), DocType::rules(), [], DocType::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $type = DocType::where('intDocTypeID', $id)->update($request->only(['txtTypeName', 'txtDesc']));
            if ($type) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Document Type updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Document Type failed to update'
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
        $type = DocType::where('intDocTypeID', $id)->delete();
        if ($type) {
            return response()->json([
                'status' => 'success',
                'message' => 'Document Type deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Document Type failed to delete'
            ], 400);
        }
    }
}

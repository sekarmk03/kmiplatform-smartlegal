<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\DocVariant;
use Yajra\DataTables\DataTables;

class DocVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $variants = DocVariant::all();

            return DataTables::of($variants)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<div class="btn-group"><button onclick="edit('.$row->intDocVariantID.')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button> <button onclick="destroy('.$row->intDocVariantID.')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fas fa-trash"></i></button></div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.docvariant');
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
        $validator = Validator::make($request->all(), DocVariant::rules(), [], DocVariant::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = DocVariant::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Document Variant created successfully'
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
        $variant = DocVariant::where('intDocVariantID', $id)->first();
        if ($variant) {
            return response()->json([
                'status' => 'success',
                'data' => $variant
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
        $validator = Validator::make($request->all(), DocVariant::rules(), [], DocVariant::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $variant = DocVariant::where('intDocVariantID', $id)->update($request->only(['txtVariantName', 'txtDesc']));
            if ($variant) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Document Variant updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Document Variant failed to update'
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
        $variant = DocVariant::where('intDocVariantID', $id)->delete();
        if ($variant) {
            return response()->json([
                'status' => 'success',
                'message' => 'Document Variant deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Document Variant failed to delete'
            ], 400);
        }
    }
}

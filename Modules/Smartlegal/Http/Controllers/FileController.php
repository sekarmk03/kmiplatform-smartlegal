<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Smartlegal\Entities\File;
use Yajra\DataTables\DataTables;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $files = File::all();

            return DataTables::of($files)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<div class="btn-group"><button onclick="preview('.$row->intFileID.')" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview"><i class="fas fa-eye"></i></button> <button onclick="download('.$row->intFileID.')" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="fas fa-download"></i></button> <button onclick="edit('.$row->intFileID.')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button> <button onclick="destroy('.$row->intFileID.')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fas fa-trash"></i></button></div>';
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.file');
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
        $input = [
            'txtFilename' => '',
            'txtPath' => ''
        ];
        if ($request->hasFile('txtFile')) {
            $file = $request->file('txtFile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('upload/documents', $fileName);
            $input['txtFilename'] = $fileName;
            $input['txtPath'] = '/upload/documents/' . $fileName;
        }
        $create = File::create($input);
        if ($create) {
            return response()->json([
                'status' => 'success',
                'message' => 'File Created Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'File Created Failed'
            ], 500);
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
        $file = File::where('intFileID', $id)->first();
        if ($file) {
            return response()->json([
                'status' => 'success',
                'data' => $file
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
        $oldFile = File::find($id);
        $input = [
            'txtFilename' => '',
            'txtPath' => ''
        ];
        if ($request->hasFile('txtFile')) {
            if($oldFile->txtFilename != 'default.pdf') {
                $destroy = public_path($oldFile->txtPath);
                unlink($destroy);
            }
            $file = $request->file('txtFile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('upload/documents', $fileName);
            $input['txtFilename'] = $fileName;
            $input['txtPath'] = '/upload/documents/' . $fileName;
        }
        $file = File::where('intFileID', $id)->update($input);
        if ($file) {
            return response()->json([
                'status' => 'success',
                'message' => 'File Updated Successfully',
                'data' => $file, $input
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'File Updated Failed'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $file = File::find($id);
        if ($file) {
            if($file->txtFilename != 'default.pdf') {
                $destroy = public_path($file->txtPath);
                unlink($destroy);
            }
            $delete = $file->delete();
            if ($delete) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'File deleted successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File failed to delete'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found!'
            ], 404);
        }
    }

    /**
     * Show the form for showing document preview the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function preview($id)
    {
        $file = File::where('intFileID', $id)->first();
        if ($file) {
            return response()->json([
                'status' => 'success',
                'data' => $file
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Not Found'
            ], 404);
        }
    }

    public function download($id) {
        $file = File::where('intFileID', $id)->first();
    
        if (!$file) {
            return abort(404, 'File not found');
        }

        $filePath = public_path($file->txtPath);

        if (file_exists($filePath)) {
            $extension = pathinfo($file->txtFilename, PATHINFO_EXTENSION);

            $mimeTypes = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
            ];

            $defaultMimeType = 'application/octet-stream';

            $mime_type = $mimeTypes[$extension] ?? $defaultMimeType;

            return response()->download($filePath, $file->txtFilename, [
                'Content-Type' => $mime_type,
            ]);
        }

        return abort(404, 'File not found');
    }
}

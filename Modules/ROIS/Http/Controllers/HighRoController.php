<?php

namespace Modules\ROIS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;
use Modules\ROIS\Entities\Reason;
use Modules\ROIS\Entities\LogHistoryModel as LogHistory;

class HighRoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = LogHistory::select(['muser.txtName', 'mreasonro.intReasonRO_ID', 'mreasonro.txtReason', 'mreasonro.txtCreatedBy', 'log_history.*'])
                ->leftJoin('mreasonro', 'log_history.intLog_History_ID', '=', 'mreasonro.intLog_History_ID')
                ->leftJoin('db_standardization.musers AS muser', 'muser.id', '=', 'mreasonro.txtCreatedBy')
                ->when(($request->txtLineProcessName != 'noFilter'), function($query) use ($request){
                    $query->where('txtLineProcessName', $request->txtLineProcessName);
                })
                ->whereBetween('log_history.floatValues', [2.00, 5.00])
                ->orderBy('log_history.TimeStamp', 'DESC')
                ->get();
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn_view = '<button class="btn btn-sm btn-info" onclick="view('.$row->intLog_History_ID.')"><i class="fa-solid fa-eye"></i></button>';
                    return $btn_view;
                })
                ->editColumn('TimeStamp', function($row){
                    return date('Y-m-d H:i', strtotime($row->TimeStamp));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $lines = [
                'Filling Sachet A1', 'Filling Sachet A2',
                'Filling Sachet E1', 'Filling Sachet E2',
                'Filling Sachet J1', 'Filling Sachet J2'
            ];
            return view('rois::pages.above-std',[
                'lines' => $lines
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
        $input = $request->only(['intLog_History_ID', 'txtReason']);
        $create = Reason::create($input);
        if ($create) {
            return response()->json([
                'status' => 'success',
                'message' => 'Reason successfully Inserted'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Reason failed Inserted'
            ], 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = LogHistory::with('reasonRo')->find($id)->makeHidden(['reason_ro', 'intROModule_ID']);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('rois::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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

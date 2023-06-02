<?php

namespace Modules\ROonline\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ROonline\Entities\Reason;
use Modules\ROonline\Entities\LogHistoryModel as LogHistory;
use Yajra\DataTables\DataTables;

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
                ->where('log_history.floatValues', '>', 2)
                ->orderBy('log_history.intLog_History_ID','DESC');
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn_view = '<button class="btn btn-sm btn-info" onclick="view('.$row->intReasonRO_ID.')"><i class="fa-solid fa-eye"></i></button>';
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
            return view('roonline::pages.above-std',[
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
        return view('roonline::create');
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
        $data = Reason::select('lh.floatValues AS RO', 'lh.txtStatus', 'lh.txtLineProcessName', 'lh.txtBatchOrder AS OKP', 'lh.txtProductName', 'lh.txtProductionCode', 'lh.dtmExpireDate', 'muser.txtName AS CreatedBy', 'mreasonro.txtReason AS Remark')
            ->join('log_history AS lh', 'lh.intLog_History_ID', '=', 'mreasonro.intLog_History_ID')
            ->join('db_standardization.musers AS muser', 'muser.id', '=', 'mreasonro.txtCreatedBy')
            ->find($id);
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
        return view('roonline::edit');
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

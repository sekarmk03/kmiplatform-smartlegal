<?php

namespace Modules\ROonline\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ROonline\Entities\LogHistoryModel as LogHistory;
use Yajra\DataTables\DataTables;
use App\Models\User;

class LogHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $logs = LogHistory::where([
                    ['txtLineProcessName', '<>','undefined'],
                    ['txtBatchOrder', '<>','undefined'],
                    ['txtProductName', '<>','undefined'],
                    ['txtProductionCode', '<>','undefined'],
                    ['txtStatus', '<>','undefined'],
                ])->latest()
                ->select('*')
                ->when(($request->txtLineProcessName != 'noFilter'), function($query) use ($request){
                    $query->where('txtLineProcessName', $request->txtLineProcessName);
                })
                ->when(($request->txtStatus != 'noFilter'), function($query) use ($request){
                    $query->where('txtStatus', $request->txtStatus);
                });
            return DataTables::of($logs)
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
            var_dump(User::online()->get());
        }
    }
    public function getDetail($id)
    {
        $log = LogHistory::find($id)->makeHidden(['intLog_History_ID', 'intROModule_ID']);
        if ($log) {
            return response()->json([
                'status' => 'success',
                'data' => $log
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Found !'
            ], 404);
        }
    }
}

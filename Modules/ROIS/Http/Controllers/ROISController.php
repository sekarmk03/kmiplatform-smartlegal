<?php

namespace Modules\ROIS\Http\Controllers;

use App\Exports\RhTempHistoryExport;
use App\Exports\RoHistoryExport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Sarfraznawaz2005\VisitLog\Facades\VisitLog;
use Excel;
use Modules\ROIS\Entities\LogHistoryModel as LogHistory;
use Modules\ROIS\Entities\LogRHTemp;
use Modules\ROIS\Entities\Area;
use Modules\ROIS\Entities\Reason;

class ROISController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private function group_by($key, $data) {
        $result = array();
    
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
    
        return $result;
    }
    public function index()
    {
        VisitLog::save();
        $lines = [
            'Filling Sachet A1', 'Filling Sachet A2',
            'Filling Sachet E1', 'Filling Sachet E2',
            'Filling Sachet J1', 'Filling Sachet J2'
        ];
        $data = LogHistory::selectRaw("txtLineProcessName, LEFT(`txtLineProcessName`, CHAR_LENGTH(`txtLineProcessName`) - 1) AS LineProcess")
            ->where('txtLineProcessName','<>','undefined')
            ->where('floatValues', '<', 5)
            ->orderBy('txtLineProcessName', 'ASC')
            ->groupBy('txtLineProcessName')
            ->get(['txtLineProcessName', 'LineProcess'])->toArray();
        return view('rois::pages.dashboard',[
            'lines' => $this->group_by('LineProcess', $data),
            'list_line' => $lines,
            'areas' => Area::all()
        ]);
    }

    public function getROWidget()
    {
        $subQuery = LogHistory::selectRaw("MAX(intLog_History_ID) AS intLog_History_ID")
            ->groupBy('txtLineProcessName')
            ->get();
        $datas = LogHistory::selectRaw('intLog_History_ID, txtLineProcessName, txtBatchOrder, txtProductName, txtProductionCode, DATE_FORMAT(dtmExpireDate, "%d-%b-%Y") as dtmExpireDate, txtStatus, floatValues, TimeStamp')
            ->where('txtLineProcessName', '<>', 'undefined')
            ->whereIn('intLog_History_ID', $subQuery)
            ->where('txtStatus', 'Measuring')
            ->where('floatValues', '<', 5)
            ->orderBy('txtLineProcessName', 'ASC')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $datas
        ], 200);
    }

    public function RoisChart(Request $request){
        if ($request->start == '' || empty($request->start)) {
            $from = LogHistory::selectRaw("DATE_SUB(`TimeStamp`, INTERVAL 1 HOUR) AS `from`")
                ->orderBy('intLog_History_ID', 'DESC')
                ->take(1)
                ->first()->from;
        } else {
            $from = date('Y-m-d H:i:s', strtotime($request->start));
        }                
        if ($request->end == '' || empty($request->end)) {
            $to = date('Y-m-d H:i:s');
        } else {
            $to = date('Y-m-d H:i:s', strtotime($request->end));
        }                
        $categories = LogHistory::selectRaw("DISTINCT REPLACE(LEFT(txtLineProcessName, CHAR_LENGTH(txtLineProcessName) - 1), ' ', '') AS line, `TimeStamp` AS xAxis")
            ->whereBetween('TimeStamp', [$from, $to])
            ->where('txtLineProcessName', '<>', 'undefined')
            ->where('txtStatus', 'Measuring')
            ->where('floatValues', '<', 5)
            ->orderBy('intLog_History_ID', 'ASC')
            ->get()->toArray();
        $data = LogHistory::selectRaw("intLog_History_ID, REPLACE(txtLineProcessName,' ','') AS txtLineProcessName,
        floatValues as yAxis, `TimeStamp` as xAxis")
            ->whereBetween('TimeStamp', [$from, $to])
            ->where('txtLineProcessName', '<>', 'undefined')
            ->where('txtStatus', 'Measuring')
            ->where('floatValues', '<', 5)
            ->orderBy('intLog_History_ID', 'ASC')
            ->get()->toArray();
        return response()->json([
            'status' => 'success',
            'data' => $this->group_by('txtLineProcessName', $data),
            'categories' => $this->group_by('line', $categories)
        ], 200);
    }

    public function ROChart(Request $request){
        if ($request->start != '') {
            $from = date('Y-m-d H:i:s', strtotime($request->start));
        } else {
            $from = LogHistory::selectRaw("DATE_SUB(`TimeStamp`, INTERVAL 1 HOUR) AS `from`")
                ->orderBy('intLog_History_ID', 'DESC')
                ->take(1)
                ->first()->from;
        }
        if ($request->end != '') {
            $to = date('Y-m-d H:i:s', strtotime($request->end));
        } else {
            $to = date('Y-m-d H:i:s');
        }
        $datas = LogHistory::selectRaw("intLog_History_ID, `TimeStamp` AS xAxis, floatValues, txtLineProcessName, txtBatchOrder, txtProductionCode")
            ->whereBetween('TimeStamp', [$from, $to])
            ->where('txtLineProcessName', '<>', 'undefined')
            ->where('txtStatus', 'Measuring')
            ->where('floatValues', '<', 5)
            ->orderBy('txtLineProcessName', 'ASC')
            ->orderBy('TimeStamp', 'ASC')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $datas
        ], 200);
    }

    public function getMaxAvg()
    {
        $datas = LogHistory::selectRaw("intLog_History_ID, txtBatchOrder, txtLineProcessName, 
            CAST(MIN(floatValues) AS DECIMAL(10, 2)) AS minimum, 
            CAST(MAX(floatValues) AS DECIMAL(10, 2)) AS maximum, 
            CAST(AVG(floatValues) AS DECIMAL(10, 2)) AS average,
            floatValues")
            ->where('txtLineProcessName', '<>', 'undefined')
            ->where('txtBatchOrder', '<>', 'undefined')
            ->where('txtStatus', 'Measuring')
            ->where('floatValues', '<', 5)
            ->groupBy("txtBatchOrder", "txtLineProcessName")
            ->orderBy("intLog_History_ID", "DESC")
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $datas
        ], 200);
    }
    public function storeReason(Request $request)
    {
        $input = $request->only(['txtLineProcessName', 'floatValues', 'TimeStamp', 'txtReason']);
        $validator = Validator::make($input, Reason::rules(), [], Reason::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $create = Reason::create([
                'intLog_History_ID' => $request->intLog_History_ID,
                'txtReason' => $input['txtReason'],
                'txtCreatedBy' => Auth::user()->id
            ]);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Reason inserted Successfully'
                ], 200);
            } else {
                return response()->json([
                'status' => 'error',
                'message' => 'internal server error'
            ], 500);
            }            
        }        
    }
    public function getReasonRO(Request $request)
    {
        $id_log = LogHistory::where(['TimeStamp' => $request->waktu, 
        'txtLineProcessName' => $request->line])->first()->intLog_History_ID;
        $data = LogHistory::with('reasonRo')->find($id_log);
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
    public function getRHTemp()
    {
        $subQuery = LogRHTemp::selectRaw("MAX(intLog_RhandTemp_ID) AS intLog_RhandTemp_ID")
            ->groupBy('txtLineProcessName', 'intArea_ID')
            ->get();
        $data = LogRHTemp::whereIn('intLog_RhandTemp_ID', $subQuery)->get();
        return response()->json([
            'status' => 'success', 
            'data' => $data
        ], 200);
    }
    public function getExportHistory(Request $request) 
    {
        return Excel::download(new RoHistoryExport($request->start, $request->end, $request->txtLineProcess), 'loghistories | RO Online.xlsx');
    }
    public function getExportRhTemp(Request $request) 
    {
        return Excel::download(new RhTempHistoryExport($request->start, $request->end, $request->intArea_ID), 'RH Temp Histories_RO Online.xlsx');
    }
}

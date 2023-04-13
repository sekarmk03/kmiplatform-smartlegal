<?php

namespace Modules\ROonline\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ROonline\Entities\LogHistoryModel as LogHistory;

class ROonlineController extends Controller
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
        $data = LogHistory::selectRaw("txtLineProcessName, LEFT(`txtLineProcessName`, CHAR_LENGTH(`txtLineProcessName`) - 1) AS LineProcess")
            ->where('txtLineProcessName','<>','undefined')
            ->orderBy('txtLineProcessName', 'ASC')
            ->groupBy('txtLineProcessName')
            ->get(['txtLineProcessName', 'LineProcess'])->toArray();
        return view('roonline::pages.dashboard',[
            'lines' => $this->group_by('LineProcess', $data)
        ]);
    }

    public function getROWidget()
    {
        $subQuery = LogHistory::selectRaw("MAX(intLog_History_ID) AS intLog_History_ID")
            ->groupBy('txtLineProcessName')
            ->get();
        $datas = LogHistory::where('txtLineProcessName', '<>', 'undefined')
            ->whereIn('intLog_History_ID', $subQuery)
            ->where('txtStatus', 'Measuring')
            ->orderBy('txtLineProcessName', 'ASC')
            ->get(['intLog_History_ID', 'txtLineProcessName', 'txtBatchOrder', 'txtProductName', 'txtProductionCode', 'dtmExpireDate',
            'txtStatus', 'floatValues', 'TimeStamp']);
        return response()->json([
            'status' => 'success',
            'data' => $datas
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
            $to = LogHistory::orderBy('intLog_History_ID', 'DESC')->first(['TimeStamp'])->TimeStamp;
        }
        $datas = LogHistory::selectRaw("`TimeStamp` AS xAxis, floatValues, txtLineProcessName, txtBatchOrder, txtProductionCode")
            ->whereBetween('TimeStamp', [$from, $to])
            ->where('txtLineProcessName', '<>', 'undefined')
            ->where('txtStatus', 'Measuring')
            ->orderBy('txtLineProcessName', 'ASC')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $datas
        ], 200);
    }

    public function getMaxAvg()
    {
        $datas = LogHistory::selectRaw("intLog_History_ID, txtBatchOrder, txtLineProcessName, 
            CAST(MAX(floatValues) AS DECIMAL(10, 2)) AS maximum, 
            CAST(AVG(floatValues) AS DECIMAL(10, 2)) AS average,
            floatValues")
            ->where('txtLineProcessName', '<>', 'undefined')
            ->where('txtBatchOrder', '<>', 'undefined')
            ->where('txtStatus', 'Measuring')
            ->groupBy("txtBatchOrder", "txtLineProcessName")
            ->orderBy("intLog_History_ID", "DESC")
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $datas
        ], 200);
    }
}

<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Smartlegal\Helpers\CurrencyFormatter;
use Yajra\DataTables\DataTables;

class LibraryMandatoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data = DB::table('kmi_smartlegal_2023.mdocuments AS d')
        ->leftJoin('kmi_smartlegal_2023.mdocumentstatuses AS ds', 'd.intRequestStatus', '=', 'ds.intDocStatusID')
        ->leftJoin('kmi_smartlegal_2023.mmandatories AS m', 'd.intDocID', '=', 'm.intDocID')
        ->select([
            DB::raw("SUBSTRING(`d.txtDocNumber`, 1, 11) AS DocNumberGroup"),
            'd.intDocID', 'd.txtRequestNumber', 'd.txtDocNumber', 'd.txtDocName',
            'ds.txtStatusName as txtDocStatus',
            'm.intRenewalCost', 'm.dtmCreatedAt', 'm.dtmPublishDate', 'm.dtmExpireDate',
        ])
        ->orderBy('d.txtDocNumber', 'desc')
        // ->groupBy('DocNumberGroup')
        ->get();

        return $data;
        // if ($request->wantsJson()) {
    
        //     $transformedData = $data->map(function ($row) {
        //         $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost);
        //         return [
        //             'doc_id' => $row->intDocID,
        //             'request_number' => $row->txtRequestNumber,
        //             'status' => $row->txtDocStatus,
        //             'doc_number' => $row->txtDocNumber,
        //             'doc_name' => $row->txtDocName,
        //             'publish_date' => $row->dtmPublishDate,
        //             'exp_date' => $row->dtmExpireDate ?: '-',
        //             'renewal_cost' => $renewalCost,
        //         ];
        //     });

        //     return DataTables::of($transformedData)
        //         ->addIndexColumn()
        //         ->addColumn('action', function($row) {
        //             return '<div class="btn-group"><button onclick="update('.$row["doc_id"].')" class="btn btn-sm btn-green" data-bs-toggle="tooltip" data-bs-placement="top" title="Update">Update</button> <button onclick="terminate('.$row["doc_id"].')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Terminate">Terminate</button></div>';
        //         })
        //         ->editColumn('created_at', function($row) {
        //             return date('Y-m-d H:i', strtotime($row["created_at"]));
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // } else {
        //     return view('smartlegal::pages.request.mandatory.index');
        // }
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
        return view('smartlegal::edit');
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

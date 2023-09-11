<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Smartlegal\Entities\Document;
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
        
        
        // return $data;
        if ($request->wantsJson()) {
            $data = Document::select(
                'mdocuments.intDocID', 
                'mdocuments.txtRequestNumber', 
                DB::raw('substring(mdocuments.txtDocNumber, 1, 11) as txtDocNumber'), 
                'mdocuments.txtDocName', 
                'mdocumentstatuses.txtStatusName', 
                'mmandatories.dtmPublishDate', 
                'mmandatories.dtmExpireDate',
                'mmandatories.intRenewalCost'
            )
            ->join('mdocumentstatuses', 'mdocuments.intRequestStatus', '=', 'mdocumentstatuses.intDocStatusID')
            ->join('mmandatories', 'mmandatories.intDocID', '=', 'mdocuments.intDocID')
            ->whereIn('mdocuments.intDocID', function($query) {
                $query->select(DB::raw('MAX(intDocID)'))
                    ->from('mdocuments')
                    ->groupBy(DB::raw('substring(txtDocNumber, 1, 11)'));
            })
            ->get();
    
            $transformedData = $data->map(function ($row) {
                $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost);
                return [
                    'doc_id' => $row->intDocID,
                    'request_number' => $row->txtRequestNumber,
                    'status' => $row->txtStatusName,
                    'doc_number' => $row->txtDocNumber,
                    'doc_name' => $row->txtDocName,
                    'publish_date' => $row->dtmPublishDate,
                    'exp_date' => $row->dtmExpireDate ?: '-',
                    'renewal_cost' => $renewalCost,
                ];
            });

            return DataTables::of($transformedData)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<button onclick="show('.$row["doc_id"].')" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"><i class="fas fa-location-arrow"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.library.mandatory.index');
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

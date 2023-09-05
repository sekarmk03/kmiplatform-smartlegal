<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Smartlegal\Helpers\CurrencyFormatter;
use Yajra\DataTables\DataTables;

class RequestMandatoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = DB::table('kmi_smartlegal_2023.mdocuments AS d')
            ->leftJoin('kmi_smartlegal_2023.mmandatories AS m', 'd.intDocID', '=', 'm.intDocID')
            ->leftJoin('kmi_smartlegal_2023.mdocumenttypes AS t', 'm.intTypeID', '=', 't.intDocTypeID')
            ->leftJoin('db_standardization.musers AS u2', 'u2.id', '=', 'm.intPICUserID')
            ->leftJoin('db_standardization.mdepartments AS e', 'e.intDepartment_ID', '=', 'm.intPICDeptID')
            ->leftJoin('kmi_smartlegal_2023.mdocumentvariants AS v', 'v.intDocVariantID', '=', 'm.intVariantID')
            ->leftJoin('db_standardization.mdepartments AS e2', 'e2.intDepartment_ID', '=', 'm.intCostCenterID')
            ->select([
                'd.intDocID', 'd.txtRequestNumber', 'd.txtDocNumber', 'd.txtDocName',
                'm.intRenewalCost', 'm.dtmCreatedAt',
                't.txtTypeName',
                'u2.txtName AS txtPICName', 'u2.txtInitial AS txtPICInitial',
                'e.txtDepartmentName', 'e.txtInitial AS txtPICDeptInitial',
                'v.txtVariantName',
                'e2.txtDepartmentName AS txtCostCenterName', 'e2.txtInitial AS txtCostCenterInitial'
            ])
            ->get();
    
            $transformedData = $data->map(function ($row) {
                $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost);
                return [
                    'doc_id' => $row->intDocID,
                    'request_number' => $row->txtRequestNumber,
                    'doc_number' => $row->txtDocNumber,
                    'type' => $row->txtTypeName,
                    'variant' => $row->txtVariantName,
                    'doc_name' => $row->txtDocName,
                    'renewal_cost' => $renewalCost,
                    'cost_center' => $row->txtCostCenterInitial,
                    'pic' => $row->txtPICDeptInitial . ' - ' . $row->txtPICName,
                    'created_at' => $row->dtmCreatedAt
                ];
            });

            return DataTables::of($transformedData)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<div class="btn-group"><button onclick="update('.$row["doc_id"].')" class="btn btn-sm btn-green" data-bs-toggle="tooltip" data-bs-placement="top" title="Update">Update</button> <button onclick="terminate('.$row["doc_id"].')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Terminate">Terminate</button></div>';
                })
                ->editColumn('created_at', function($row) {
                    return date('Y-m-d H:i', strtotime($row["created_at"]));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.request.mandatory.index');
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

<?php

namespace Modules\Smartlegal\Http\Controllers;

use App\Models\DepartmentModel;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\DocType;
use Modules\Smartlegal\Entities\DocVariant;
use Modules\Smartlegal\Entities\Issuer;
use Modules\Smartlegal\Helpers\CurrencyFormatter;
use Modules\Smartlegal\Helpers\PeriodFormatter;
use Yajra\DataTables\DataTables;

class DocMandatoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = DB::table('kmi_smartlegal_2023.mdocuments AS d')
            ->leftJoin('db_standardization.musers AS u', 'u.id', '=', 'd.intRequestedBy')
            ->leftJoin('kmi_smartlegal_2023.mdocumentstatuses AS ds', 'd.intRequestStatus', '=', 'ds.intDocStatusID')
            ->leftJoin('kmi_smartlegal_2023.mmandatories AS m', 'd.intDocID', '=', 'm.intDocID')
            ->leftJoin('kmi_smartlegal_2023.mdocumenttypes AS t', 'm.intTypeID', '=', 't.intDocTypeID')
            ->leftJoin('db_standardization.musers AS u2', 'u2.id', '=', 'm.intPICUserID')
            ->leftJoin('db_standardization.mdepartments AS e', 'e.intDepartment_ID', '=', 'm.intPICDeptID')
            ->leftJoin('kmi_smartlegal_2023.mdocumentvariants AS v', 'v.intDocVariantID', '=', 'm.intVariantID')
            ->leftJoin('kmi_smartlegal_2023.missuers AS i', 'i.intIssuerID', 'm.intIssuerID')
            ->leftJoin('kmi_smartlegal_2023.mfiles AS f', 'f.intFileID', 'm.intFileID')
            ->leftJoin('db_standardization.mdepartments AS e2', 'e2.intDepartment_ID', '=', 'm.intCostCenterID')
            ->select([
                'd.intDocID', 'd.txtRequestNumber', 'd.txtDocNumber', 'd.txtDocName',
                'ds.txtStatusName as txtDocStatus',
                'm.intExpirationPeriod', 'm.dtmPublishDate', 'm.dtmExpireDate', 'm.intReminderPeriod', 'm.txtLocationFilling', 'm.intRenewalCost', 'm.txtNote', 'm.txtTerminationNote', 'm.intDeleted', 'm.dtmCreatedAt',
                'u.txtName AS txtReqByName', 'u.txtInitial AS txtReqByInitial',
                't.txtTypeName',
                'u2.txtName AS txtPICName', 'u2.txtInitial AS txtPICInitial',
                'e.txtDepartmentName', 'e.txtInitial AS txtPICDeptInitial',
                'v.txtVariantName',
                'i.txtIssuerName', 'i.txtCode',
                'f.intFileID', 'f.txtFilename', 'f.txtPath',
                'e2.txtDepartmentName AS txtCostCenterName', 'e2.txtInitial AS txtCostCenterInitial'
            ])
            ->get();
    
            $transformedData = $data->map(function ($row) {
                if ($row->dtmExpireDate) {
                    $period = PeriodFormatter::date($row->dtmPublishDate, $row->dtmExpireDate, 'day');
                } else {
                    $period = '-';
                }

                $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost);
    
                return [
                    'doc_id' => $row->intDocID,
                    'file_id' => $row->intFileID,
                    'created_at' => $row->dtmCreatedAt,
                    'requested_by' => $row->txtReqByName,
                    'request_number' => $row->txtRequestNumber,
                    'doc_number' => $row->txtDocNumber,
                    'doc_name' => $row->txtDocName,
                    'status' => $row->txtDocStatus,
                    'type' => $row->txtTypeName,
                    'pic' => $row->txtPICDeptInitial . ' - ' . $row->txtPICName,
                    'variant' => $row->txtVariantName,
                    'exp_period' => $period ?: '-',
                    'publish_date' => $row->dtmPublishDate,
                    'exp_date' => $row->dtmExpireDate ?: '-',
                    'issuer' => $row->txtIssuerName,
                    'rem_period' => $row->intReminderPeriod ?: '-',
                    'location' => $row->txtLocationFilling,
                    'renewal_cost' => $renewalCost,
                    'cost_center' => $row->txtCostCenterInitial,
                    'note' => $row->txtNote ?: '-',
                    'termination_note' => $row->txtTerminationNote ?: '-'
                ];
            });

            return DataTables::of($transformedData)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<div class="btn-group"><button onclick="preview('.$row["file_id"].')" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview"><i class="fas fa-eye"></i></button> <button onclick="edit('.$row["doc_id"].')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-pencil"></i></button> <button onclick="destroy('.$row["doc_id"].')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fas fa-trash"></i></button></div>';
                })
                ->editColumn('created_at', function($row) {
                    return date('Y-m-d H:i', strtotime($row["created_at"]));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.master.docmandatory', [
                'variants' => DocVariant::get(['intDocVariantID', 'txtVariantName']),
                'issuers' => Issuer::get(['intIssuerID', 'txtIssuerName'])
            ]);
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
        $inputFile = [];
        $inputDocument = [];
        $inputMandatory = [];
        $inputPICReminder = [];

        
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

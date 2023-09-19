<?php

namespace Modules\Smartlegal\Http\Controllers;

use App\Models\DepartmentModel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Smartlegal\Entities\DocApproval;
use Modules\Smartlegal\Entities\Document;
use Modules\Smartlegal\Entities\DocVariant;
use Modules\Smartlegal\Entities\File;
use Modules\Smartlegal\Entities\Mandatory;
use Modules\Smartlegal\Entities\PICReminder;
use Modules\Smartlegal\Helpers\CurrencyFormatter;
use Modules\Smartlegal\Helpers\NumberIDGenerator;
use Modules\Smartlegal\Helpers\PeriodFormatter;
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
            ->orderBy('intDocID', 'DESC')
            ->get();
    
            $transformedData = $data->map(function ($row) {
                $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost, 'Rp');
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
            return view('smartlegal::pages.request.mandatory.index', [
                'variants' => DocVariant::get(['intDocVariantID', 'txtVariantName'])
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
        $inputLog = [];

        if ($request->hasFile('txtFile')) {
            $file = $request->file('txtFile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('upload/documents', $fileName);
            $inputFile['txtFilename'] = $fileName;
            $inputFile['txtPath'] = '/upload/documents/' . $fileName;
        }

        $department = DepartmentModel::where('intDepartment_ID', $request['intPICDeptID'])->first();
        $inputDocument['txtRequestNumber'] = NumberIDGenerator::generateRequestNumber($request['intTypeID'], $department->txtInitial);
        $inputDocument['txtDocNumber'] = NumberIDGenerator::generateDocumentNumber('PM', $request['intTypeID'], $department->txtInitial, null);
        $inputDocument['txtDocName'] = $request['txtDocName'];
        $inputDocument['intRequestedBy'] = Auth::user()->id;
        $inputDocument['intRequestStatus'] = 1;

        $inputMandatory['intTypeID'] = $request['intTypeID'];
        $inputMandatory['intPICDeptID'] = $request['intPICDeptID'];
        $inputMandatory['intPICUserID'] = $request['intPICUserID'];
        $inputMandatory['intVariantID'] = $request['intVariantID'];
        $inputMandatory['dtmPublishDate'] = $request['dtmPublishDate'];
        $inputMandatory['dtmExpireDate'] = $request['intVariantID'] == 1 ? null : ($request['dtmExpireDate'] ?: null);
        $inputMandatory['intExpirationPeriod'] = $request['intVariantID'] == 1 ? null : ($inputMandatory['dtmExpireDate'] ? PeriodFormatter::dayCounter($inputMandatory['dtmPublishDate'], $inputMandatory['dtmExpireDate']) : null);
        $inputMandatory['intIssuerID'] = $request['intIssuerID'];
        $inputMandatory['intReminderPeriod'] = $request['intVariantID'] == 1 ? null : ($request['intReminderPeriod'] ? PeriodFormatter::countInputToDay($request['intReminderPeriod'], $request['remPeriodUnit']) : null);
        $inputMandatory['txtLocationFilling'] = $request['txtLocationFilling'];
        $inputMandatory['intRenewalCost'] = $request['intVariantID'] == 1 ? 0 : ($request['intRenewalCost'] ?: 0);
        $inputMandatory['intCostCenterID'] = $request['intCostCenterID'];
        $inputMandatory['txtNote'] = $request['txtNote'];
        $inputMandatory['intCreatedBy'] = Auth::user()->id;

        $inputLog['intState'] = 1;
        $inputLog['intUserID'] = Auth::user()->id;
        $inputLog['txtNote'] = $request['txtNote'];
        $inputLog['txtLeadTime'] = null;
        
        try {
            DB::beginTransaction();
            $createFile = File::create($inputFile);
            $createDocument = Document::create($inputDocument);
            $inputMandatory['intFileID'] = $createFile->intFileID;
            $inputMandatory['intDocID'] = $createDocument->intDocID;
            $createMandatory = Mandatory::create($inputMandatory);
            $inputLog['intDocID'] = $createDocument->intDocID;
            
            if ($request['intVariantID'] == 2) {
                foreach ($request['picReminders'] as $pr) {
                    $inputPICReminder['intUserID'] = $pr;
                    $inputPICReminder['intMandatoryID'] = $createMandatory->intMandatoryID;
                    $createPICReminder = PICReminder::create($inputPICReminder);
                }
            }

            $createLog = DocApproval::create($inputLog);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Request Created Successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
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

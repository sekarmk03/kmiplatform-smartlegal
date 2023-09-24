<?php

namespace Modules\Smartlegal\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\DocApproval;
use Modules\Smartlegal\Entities\Document;
use Modules\Smartlegal\Entities\DocVariant;
use Modules\Smartlegal\Entities\File;
use Modules\Smartlegal\Entities\Mandatory;
use Modules\Smartlegal\Entities\PICReminder;
use Modules\Smartlegal\Helpers\CurrencyFormatter;
use Modules\Smartlegal\Helpers\LeadTimeCalculator;
use Modules\Smartlegal\Helpers\PeriodFormatter;
use Yajra\DataTables\DataTables;

class MyTaskMandatoryController extends Controller
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
                'm.intRenewalCost', 'm.dtmCreatedAt',
                'u2.txtName AS txtPICName', 'u2.txtInitial AS txtPICInitial',
                'e.txtDepartmentName', 'e.txtInitial AS txtPICDeptInitial',
                'v.txtVariantName',
                'f.intFileID', 'f.txtFilename', 'f.txtPath',
                'e2.txtDepartmentName AS txtCostCenterName', 'e2.txtInitial AS txtCostCenterInitial'
            ])
            ->where('d.intRequestStatus', 1)
            ->orWhere('d.intRequestStatus', 2)
            ->get();
    
            $transformedData = $data->map(function ($row) {
                $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost, 'Rp');
                return [
                    'doc_id' => $row->intDocID,
                    'request_number' => $row->txtRequestNumber,
                    'doc_number' => $row->txtDocNumber,
                    'variant' => $row->txtVariantName,
                    'doc_name' => $row->txtDocName,
                    'renewal_cost' => $renewalCost,
                    'pic' => $row->txtPICDeptInitial . ' - ' . $row->txtPICName,
                    'status' => $row->txtDocStatus,
                    'created_at' => $row->dtmCreatedAt,
                    'file_id' => $row->intFileID,
                    'file_path' => $row->txtPath,
                    'file_name' => $row->txtFilename
                ];
            });

            return DataTables::of($transformedData)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<div class="btn-group"><button onclick="preview('.$row["file_id"].')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Open"><i class="fas fa-eye"></i></button> <button onclick="show('.$row["doc_id"].')" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"><i class="fas fa-link"></i></button></div>';
                })
                ->editColumn('created_at', function($row) {
                    return date('Y-m-d H:i', strtotime($row["created_at"]));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('smartlegal::pages.mytask.mandatory.index', [
                'active_task' => Document::where('intRequestStatus', 1)->count(),
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
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id, Request $request)
    {
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
            'd.intDocID', 'd.txtRequestNumber', 'd.txtDocNumber', 'd.txtDocName', 'd.dtmCreatedAt', 'd.dtmUpdatedAt',
            'ds.txtStatusName as txtDocStatus',
            'm.intExpirationPeriod', 'm.dtmPublishDate', 'm.dtmExpireDate', 'm.intReminderPeriod', 'm.txtLocationFilling', 'm.intRenewalCost', 'm.txtNote', 'm.txtTerminationNote',
            'u.txtName AS txtReqByName', 'u.txtInitial AS txtReqByInitial',
            't.txtTypeName',
            'u2.txtName AS txtPICName', 'u2.txtInitial AS txtPICInitial',
            'e.txtDepartmentName', 'e.txtInitial AS txtPICDeptInitial',
            'v.txtVariantName',
            'i.txtIssuerName', 'i.txtCode',
            'f.intFileID', 'f.txtFilename', 'f.txtPath',
            'e2.txtDepartmentName AS txtCostCenterName', 'e2.txtInitial AS txtCostCenterInitial'
        ])
        ->where('d.intDocID', $id)
        ->first();

        if ($data->dtmExpireDate) {
            $period = PeriodFormatter::date($data->dtmPublishDate, $data->dtmExpireDate, 'day');
        } else {
            $period = '-';
        }

        if ($data->intReminderPeriod) {
            $remPeriod = PeriodFormatter::convertDaysToReadable($data->intReminderPeriod);
        } else {
            $remPeriod = '-';
        }

        $renewalCost = CurrencyFormatter::formatIDR($data->intRenewalCost, 'Rp');

        $mandatory = [
            'doc_id' => $data->intDocID,
            'created_at' => $data->dtmCreatedAt,
            'updated_at' => $data->dtmUpdatedAt,
            'requested_by' => $data->txtReqByName,
            'request_number' => $data->txtRequestNumber,
            'doc_number' => $data->txtDocNumber,
            'doc_name' => $data->txtDocName,
            'status' => $data->txtDocStatus,
            'type' => $data->txtTypeName,
            'pic' => $data->txtPICDeptInitial . ' - ' . $data->txtPICName,
            'variant' => $data->txtVariantName,
            'exp_period' => $period ?: '-',
            'publish_date' => $data->dtmPublishDate,
            'exp_date' => $data->dtmExpireDate ?: '-',
            'issuer' => $data->txtIssuerName,
            'rem_period' => $remPeriod,
            'location' => $data->txtLocationFilling,
            'renewal_cost' => $renewalCost,
            'cost_center' => $data->txtCostCenterInitial,
            'note' => $data->txtNote ?: '-',
            'termination_note' => $data->txtTerminationNote ?: '-',
            'file_id' => $data->intFileID,
            'file_path' => $data->txtPath,
            'file_name' => $data->txtFilename
        ];

        $pdfPath = public_path($mandatory['file_path']);
    
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        if ($request->wantsPdf) {
            $headers['Content-Disposition'] = 'inline';
            return response()->file($pdfPath, $headers);
        }

        return view('smartlegal::pages.mytask.mandatory.detail', [
            'mandatory' => $mandatory,
            'variants' => DocVariant::get(['intDocVariantID', 'txtVariantName'])
        ]);
    }

    public function showPDF() {
        $pdfPath = public_path('upload/document/your-pdf-file.pdf');

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline',  // This ensures the PDF is displayed
        ];

        return response()->file($pdfPath, $headers);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = DB::table('kmi_smartlegal_2023.mdocuments AS d')
        ->leftJoin('db_standardization.musers AS u', 'u.id', '=', 'd.intRequestedBy')
        ->leftJoin('kmi_smartlegal_2023.mmandatories AS m', 'd.intDocID', '=', 'm.intDocID')
        ->leftJoin('kmi_smartlegal_2023.mfiles AS f', 'f.intFileID', 'm.intFileID')
        ->select([
            'd.intDocID', 'd.txtRequestNumber', 'd.txtDocNumber', 'd.txtDocName',
            'm.intMandatoryID', 'm.intTypeID', 'm.intPICDeptID', 'm.intPICUserID', 'm.intVariantID', 'm.dtmPublishDate', 'm.dtmExpireDate', 'm.intIssuerID', 'm.intReminderPeriod', 'm.txtLocationFilling', 'm.intRenewalCost', 'm.txtNote', 'm.intCostCenterID',
            'f.intFileID', 'f.txtPath', 'f.txtFilename',
        ])
        ->where('d.intDocID', $id)
        ->first();
    
        $picData = DB::table('kmi_smartlegal_2023.mpicreminders AS p')
        ->leftJoin('db_standardization.musers AS u', 'p.intUserID', '=', 'u.id')
        ->where('p.intMandatoryID', '=', $data->intMandatoryID)
        ->get();
        
        $data->picReminders = [];
        foreach ($picData as $pic) {
            array_push($data->picReminders, $pic->id);
        }

        $remData = PeriodFormatter::countDayToUnit($data->intReminderPeriod);
        $data->intReminderPeriod = $remData['number'];
        $data->remPeriodUnit = $remData['unit'];

        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Not Found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // get old data
        $document = Document::where('intDocID', $id)->first();
        $mandatory = Mandatory::where('intDocID', $id)->first();
        $file = File::where('intFileID', $mandatory->intFileID)->first();
        $picReminders = PICReminder::where('intMandatoryID', $mandatory->intMandatoryID)->get();
        $prevLog = DocApproval::where('intDocID', $id)->orderBy('intApprovalID', 'DESC')->first();
        if (!$prevLog) $prevLog = $document;

        // construct request
        $inputFile = [];
        $inputDocument = [];
        $inputMandatory = [];
        $inputPICReminder = [];
        $inputLog = [];

        if ($request->hasFile('txtFile')) {
            if($file->txtFilename != 'default.pdf') {
                $destroy = public_path($file->txtPath);
                if (file_exists($destroy)) unlink($destroy);
            }
            $reqFile = $request->file('txtFile');
            $fileName = time() . '_' . $reqFile->getClientOriginalName();
            $reqFile->move('upload/documents', $fileName);
            $inputFile['txtFilename'] = $fileName;
            $inputFile['txtPath'] = '/upload/documents/' . $fileName;
        }

        $inputDocument['txtRequestNumber'] = $request['txtRequestNumber'] ?: $document->txtRequestNumber;
        $inputDocument['txtDocNumber'] = $request['txtDocNumber'] ?: $document->txtDocNumber;
        $inputDocument['txtDocName'] = $request['txtDocName'] ?: $document->txtDocName;
        $inputDocument['intRequestedBy'] = $document->intRequestedBy;
        $inputDocument['intRequestStatus'] = 2; // Revise

        $inputMandatory['intTypeID'] = $request['intTypeID'] ?: $mandatory->intTypeID;
        $inputMandatory['intPICDeptID'] = $request['intPICDeptID'] ?: $mandatory->intPICDeptID;
        $inputMandatory['intPICUserID'] = $request['intPICUserID'] ?: $mandatory->intPICUserID;
        $inputMandatory['intVariantID'] = $request['intVariantID'] ?: $mandatory->intVariantID;
        $inputMandatory['dtmPublishDate'] = $request['dtmPublishDate'] ?: $mandatory->dtmPublishDate;
        $inputMandatory['dtmExpireDate'] = $request['intVariantID'] == 1 ? null : ($request['dtmExpireDate'] ?: $mandatory->dtmExpireDate);
        $inputMandatory['intExpirationPeriod'] = $request['intVariantID'] == 1 ? null : ($inputMandatory['dtmExpireDate'] ? PeriodFormatter::dayCounter($inputMandatory['dtmPublishDate'], $inputMandatory['dtmExpireDate']) : $mandatory->intExpirationPeriod);
        $inputMandatory['intIssuerID'] = $request['intIssuerID'];
        $inputMandatory['intReminderPeriod'] = $request['intVariantID'] == 1 ? null : ($request['intReminderPeriod'] ? PeriodFormatter::countInputToDay($request['intReminderPeriod'], $request['remPeriodUnit']) : $mandatory->intReminderPeriod);
        $inputMandatory['txtLocationFilling'] = $request['txtLocationFilling'];
        $inputMandatory['intRenewalCost'] = $request['intVariantID'] == 1 ? 0 : ($request['intRenewalCost'] ?: $mandatory->intRenewalCost);
        $inputMandatory['intCostCenterID'] = $request['intCostCenterID'];
        $inputMandatory['txtNote'] = $request['txtNote'];
        $inputMandatory['txtTerminationNote'] = null;
        $inputMandatory['intCreatedBy'] = $mandatory->intCreatedBy;
        $inputMandatory['intFileID'] = $mandatory->intFileID;
        $inputMandatory['intDocID'] = $document->intDocID;

        $inputLog['intState'] = 2; // Revised
        $inputLog['intUserID'] = Auth::user()->id;
        $inputLog['txtNote'] = $request['txtNote'];
        $inputLog['intDocID'] = $document->intDocID;
        $prevTime = $prevLog->dtmCreatedAt->format('Y-m-d H:i:s');
        $now = new DateTime();
        $now = $now->format('Y-m-d H:i:s');
        $inputLog['txtLeadTime'] = PeriodFormatter::date($prevTime, $now, 'min');
        
        try {
            DB::beginTransaction();
            if ($request->hasFile('txtFile')) $file->update($inputFile);
            $document->update($inputDocument);
            $mandatory->update($inputMandatory);
            
            if ($request['intVariantID'] == 2) {
                if (count($picReminders) > 0) {
                    foreach ($picReminders as $pic) {
                        $pic->delete();
                    }
                }
                if (count($request['picReminders']) > 0) {
                    foreach ($request['picReminders'] as $pr) {
                        $inputPICReminder['intUserID'] = $pr;
                        $inputPICReminder['intMandatoryID'] = $mandatory->intMandatoryID;
                        $createPICReminder = PICReminder::create($inputPICReminder);
                    }
                }
            }

            $createLog = DocApproval::create($inputLog);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Document Updated Successfully'
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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function approve(Request $request, $id)
    {
        $prevLog = DocApproval::where('intDocID', $id)->orderBy('intApprovalID', 'DESC')->first();
        $document = Document::where('intDocID', $id)->first();
        if (!$prevLog) $prevLog = $document;

        $input = $request->only(['txtNote']);
        $input['intDocID'] = $id;
        $input['intUserID'] = Auth::user()->id;
        $input['intState'] = $request['noteType'];

        $prevTime = $prevLog->dtmCreatedAt->format('Y-m-d H:i:s');
        $now = new DateTime();
        $now = $now->format('Y-m-d H:i:s');
        $input['txtLeadTime'] = PeriodFormatter::date($prevTime, $now, 'min');

        try {
            DB::beginTransaction();
            $document->update(['intRequestStatus' => $request['noteType']]);
            $log = DocApproval::create($input);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Document updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}

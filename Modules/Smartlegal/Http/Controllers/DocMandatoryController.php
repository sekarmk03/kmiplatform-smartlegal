<?php

namespace Modules\Smartlegal\Http\Controllers;

use App\Models\DepartmentModel;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Smartlegal\Entities\DocApproval;
use Modules\Smartlegal\Entities\DocType;
use Modules\Smartlegal\Entities\Document;
use Modules\Smartlegal\Entities\DocVariant;
use Modules\Smartlegal\Entities\File;
use Modules\Smartlegal\Entities\Issuer;
use Modules\Smartlegal\Entities\Mandatory;
use Modules\Smartlegal\Entities\PICReminder;
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
                'm.intMandatoryID', 'm.intExpirationPeriod', 'm.dtmPublishDate', 'm.dtmExpireDate', 'm.intReminderPeriod', 'm.txtLocationFilling', 'm.intRenewalCost', 'm.txtNote', 'm.txtTerminationNote', 'm.dtmCreatedAt',
                'u.txtName AS txtReqByName', 'u.txtInitial AS txtReqByInitial',
                't.txtTypeName',
                'u2.txtName AS txtPICName', 'u2.txtInitial AS txtPICInitial',
                'e.txtDepartmentName', 'e.txtInitial AS txtPICDeptInitial',
                'v.txtVariantName',
                'i.txtIssuerName', 'i.txtCode',
                'f.intFileID', 'f.txtFilename', 'f.txtPath',
                'e2.txtDepartmentName AS txtCostCenterName', 'e2.txtInitial AS txtCostCenterInitial'
            ])
            ->orderBy('d.intDocID', 'DESC')
            ->get();
    
            $transformedData = $data->map(function ($row) {
                $picData = DB::table('kmi_smartlegal_2023.mpicreminders AS p')
                ->leftJoin('db_standardization.musers AS u', 'p.intUserID', '=', 'u.id')
                ->select('u.txtInitial')
                ->where('p.intMandatoryID', '=', $row->intMandatoryID)
                ->get();

                $picReminder = [];
                foreach ($picData as $pic) {
                    array_push($picReminder, $pic->txtInitial);
                }

                if ($row->dtmExpireDate) {
                    $period = PeriodFormatter::date($row->dtmPublishDate, $row->dtmExpireDate, 'day');
                } else {
                    $period = '-';
                }

                if ($row->intReminderPeriod) {
                    $remPeriod = PeriodFormatter::convertDaysToReadable($row->intReminderPeriod);
                } else {
                    $remPeriod = '-';
                }

                $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost, 'Rp');
    
                return [
                    'doc_id' => $row->intDocID,
                    'file_id' => $row->intFileID,
                    'created_at' => $row->dtmCreatedAt,
                    'requested_by' => $row->txtReqByInitial,
                    'request_number' => $row->txtRequestNumber,
                    'doc_number' => $row->txtDocNumber,
                    'doc_name' => $row->txtDocName,
                    'status' => $row->txtDocStatus,
                    'type' => $row->txtTypeName,
                    'pic' => $row->txtPICDeptInitial . ' - ' . $row->txtPICInitial,
                    'variant' => $row->txtVariantName,
                    'exp_period' => $period ?: '-',
                    'publish_date' => $row->dtmPublishDate,
                    'exp_date' => $row->dtmExpireDate ?: '-',
                    'issuer' => $row->txtIssuerName,
                    'rem_period' => $remPeriod,
                    'pic_reminder' => count($picReminder) > 0 ? implode(", ", $picReminder) : '-',
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

        $inputDocument['txtRequestNumber'] = $request['txtRequestNumber'];
        $inputDocument['txtDocNumber'] = $request['txtDocNumber'];
        $inputDocument['txtDocName'] = $request['txtDocName'];
        $inputDocument['intRequestedBy'] = Auth::user()->id;
        $inputDocument['intRequestStatus'] = $request['intRequestStatus'] ?: 1;

        $inputMandatory['intTypeID'] = $request['intTypeID'];
        $inputMandatory['intPICDeptID'] = $request['intPICDeptID'];
        $inputMandatory['intPICUserID'] = $request['intPICUserID'];
        $inputMandatory['intVariantID'] = $request['intVariantID'];
        $inputMandatory['dtmPublishDate'] = $request['dtmPublishDate'];
        $inputMandatory['dtmExpireDate'] = $request['dtmExpireDate'] ?: null;
        $inputMandatory['intExpirationPeriod'] = $inputMandatory['dtmExpireDate'] ? PeriodFormatter::dayCounter($inputMandatory['dtmPublishDate'], $inputMandatory['dtmExpireDate']) : null;
        $inputMandatory['intIssuerID'] = $request['intIssuerID'];
        $inputMandatory['intReminderPeriod'] = $request['intReminderPeriod'] ? PeriodFormatter::countInputToDay($request['intReminderPeriod'], $request['remPeriodUnit']) : null;
        $inputMandatory['txtLocationFilling'] = $request['txtLocationFilling'];
        $inputMandatory['intRenewalCost'] = $request['intRenewalCost'] ?: 0;
        $inputMandatory['intCostCenterID'] = $request['intCostCenterID'];
        $inputMandatory['txtNote'] = $request['txtNote'];
        $inputMandatory['txtTerminationNote'] = $request['txtTerminationNote'];
        $inputMandatory['intCreatedBy'] = Auth::user()->id;

        $inputLog['intState'] = $request['intDocStatusID'];
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
                'message' => 'Document Created Successfully'
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
        $data = DB::table('kmi_smartlegal_2023.mdocuments AS d')
        ->leftJoin('db_standardization.musers AS u', 'u.id', '=', 'd.intRequestedBy')
        ->leftJoin('kmi_smartlegal_2023.mmandatories AS m', 'd.intDocID', '=', 'm.intDocID')
        ->leftJoin('kmi_smartlegal_2023.mfiles AS f', 'f.intFileID', 'm.intFileID')
        ->select([
            'd.intDocID', 'd.txtRequestNumber', 'd.txtDocNumber', 'd.txtDocName', 'd.intRequestStatus AS intStatusID',
            'm.intMandatoryID', 'm.intTypeID', 'm.intPICDeptID', 'm.intPICUserID', 'm.intVariantID', 'm.dtmPublishDate', 'm.dtmExpireDate', 'm.intIssuerID', 'm.intReminderPeriod', 'm.txtLocationFilling', 'm.intRenewalCost', 'm.txtNote', 'm.txtTerminationNote', 'm.intCostCenterID',
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

        $inputDocument['txtRequestNumber'] = $request['txtRequestNumber'];
        $inputDocument['txtDocNumber'] = $request['txtDocNumber'];
        $inputDocument['txtDocName'] = $request['txtDocName'];
        $inputDocument['intRequestedBy'] = Auth::user()->id;
        $inputDocument['intRequestStatus'] = $request['intRequestStatus'];

        $inputMandatory['intTypeID'] = $request['intTypeID'];
        $inputMandatory['intPICDeptID'] = $request['intPICDeptID'];
        $inputMandatory['intPICUserID'] = $request['intPICUserID'];
        $inputMandatory['intVariantID'] = $request['intVariantID'];
        $inputMandatory['dtmPublishDate'] = $request['dtmPublishDate'];
        $inputMandatory['dtmExpireDate'] = $request['dtmExpireDate'] ?: null;
        $inputMandatory['intExpirationPeriod'] = $inputMandatory['dtmExpireDate'] ? PeriodFormatter::dayCounter($inputMandatory['dtmPublishDate'], $inputMandatory['dtmExpireDate']) : null;
        $inputMandatory['intIssuerID'] = $request['intIssuerID'];
        $inputMandatory['intReminderPeriod'] = $request['intReminderPeriod'] ? PeriodFormatter::countInputToDay($request['intReminderPeriod'], $request['remPeriodUnit']) : null;
        $inputMandatory['txtLocationFilling'] = $request['txtLocationFilling'];
        $inputMandatory['intRenewalCost'] = $request['intRenewalCost'] ?: 0;
        $inputMandatory['intCostCenterID'] = $request['intCostCenterID'];
        $inputMandatory['txtNote'] = $request['txtNote'];
        $inputMandatory['txtTerminationNote'] = $request['txtTerminationNote'];
        $inputMandatory['intCreatedBy'] = Auth::user()->id;
        $inputMandatory['intFileID'] = $mandatory->intFileID;
        $inputMandatory['intDocID'] = $document->intDocID;

        $inputLog['intState'] = $request['intDocStatusID'];
        $inputLog['intUserID'] = Auth::user()->id;
        $inputLog['txtNote'] = $request['txtNote'];
        $inputLog['txtLeadTime'] = null;
        $inputLog['intDocID'] = $document->intDocID;
        
        try {
            DB::beginTransaction();
            $file->update($inputFile);
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
        $document = Document::where('intDocID', $id)->first();
        $mandatory = Mandatory::where('intDocID', $id)->first();
        $file = File::where('intFileID', $mandatory->intFileID)->first();
        $picReminders = PICReminder::where('intMandatoryID', $mandatory->intMandatoryID)->get();
        $logs = DocApproval::where('intDocID', $id)->get();
        try {
            DB::beginTransaction();
            if ($file) {
                if($file->txtFilename != 'default.pdf') {
                    $destroy = public_path($file->txtPath);
                    if (file_exists($destroy)) unlink($destroy);
                }
            }
            foreach ($logs as $log) {
                $log->delete();
            }
            foreach ($picReminders as $pic) {
                $pic->delete();
            }
            $mandatory->delete();
            $file->delete();
            $document->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Document Deleted Successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

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
use Modules\Smartlegal\Entities\Issuer;
use Modules\Smartlegal\Entities\Mandatory;
use Modules\Smartlegal\Entities\PICReminder;
use Modules\Smartlegal\Helpers\CurrencyFormatter;
use Modules\Smartlegal\Helpers\NumberIDGenerator;
use Modules\Smartlegal\Helpers\PeriodFormatter;
use Modules\Smartlegal\Helpers\TextFormatter;
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
            ->leftJoin('kmi_smartlegal_2023.mdocumentstatuses AS s', 'd.intRequestStatus', '=', 's.intDocStatusID')
            ->select([
                'd.intDocID', 'd.txtRequestNumber', 'd.txtDocNumber', 'd.txtDocName', 'd.intRequestStatus',
                'm.intRenewalCost', 'm.dtmCreatedAt',
                't.txtTypeName',
                'u2.txtName AS txtPICName', 'u2.txtInitial AS txtPICInitial',
                'e.txtDepartmentName', 'e.txtInitial AS txtPICDeptInitial',
                'v.txtVariantName',
                's.txtStatusName'
            ])
            ->orderBy('intDocID', 'DESC')
            ->get();
    
            $transformedData = $data->map(function ($row) {
                $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost, 'Rp');
                return [
                    'doc_id' => $row->intDocID,
                    'request_number' => $row->txtRequestNumber,
                    'status' => $row->intRequestStatus,
                    'doc_number' => $row->txtDocNumber,
                    'type' => $row->txtTypeName,
                    'variant' => $row->txtVariantName,
                    'doc_name' => $row->txtDocName,
                    'status' => $row->txtStatusName,
                    'pic' => $row->txtPICDeptInitial . ' - ' . $row->txtPICName,
                    'created_at' => $row->dtmCreatedAt
                ];
            });

            return DataTables::of($transformedData)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $actionBtn = '<div class="btn-group"><button onclick="update('.$row["doc_id"].')" class="btn btn-sm btn-green" data-bs-toggle="tooltip" data-bs-placement="top" title="Update">Update</button>';
                    if ($row['status'] == 7) {
                        $actionBtn .= '<button class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Terminated"disabled>Terminated</button></div>';
                    } else {
                        $actionBtn .= '<button onclick="terminate('.$row["doc_id"].')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Terminate">Terminate</button></div>';
                    }
                    return $actionBtn;
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
        $inputIssuer = [];

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
        $inputMandatory['intReminderPeriod'] = $request['intVariantID'] == 1 ? null : ($request['intReminderPeriod'] ? PeriodFormatter::countInputToDay($request['intReminderPeriod'], $request['remPeriodUnit']) : null);
        $inputMandatory['txtLocationFilling'] = $request['txtLocationFilling'];
        $inputMandatory['intRenewalCost'] = $request['intVariantID'] == 1 ? 0 : ($request['intRenewalCost'] ?: 0);
        $inputMandatory['intCostCenterID'] = $request['intCostCenterID'];
        $inputMandatory['txtNote'] = $request['txtNote'] ?: '';
        $inputMandatory['intCreatedBy'] = Auth::user()->id;

        $inputLog['intState'] = 1;
        $inputLog['intUserID'] = Auth::user()->id;
        $inputLog['txtNote'] = $request['txtNote'];
        $inputLog['txtLeadTime'] = null;
        
        try {
            DB::beginTransaction();

            $createFile = File::create($inputFile);

            $createDocument = Document::create($inputDocument);

            if ($request['intIssuerID'] == 0) {
                $inputIssuer['txtIssuerName'] = $request['txtOtherIssuer'];
                $inputIssuer['txtCode'] = TextFormatter::getInitials($request['txtOtherIssuer']);
                $createIssuer = Issuer::create($inputIssuer);
                $inputMandatory['intIssuerID'] = $createIssuer->intIssuerID;
            } else {
                $inputMandatory['intIssuerID'] = $request['intIssuerID'];
            }

            $inputMandatory['intFileID'] = $createFile->intFileID;
            $inputMandatory['intDocID'] = $createDocument->intDocID;
            $createMandatory = Mandatory::create($inputMandatory);

            $inputLog['intDocID'] = $createDocument->intDocID;
            
            if ($request['intVariantID'] == 2) {
                if (count($request['picReminders']) > 0) {
                    foreach ($request['picReminders'] as $pr) {
                        $inputPICReminder['intUserID'] = $pr;
                        $inputPICReminder['intMandatoryID'] = $createMandatory->intMandatoryID;
                        $createPICReminder = PICReminder::create($inputPICReminder);
                    }
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
        $data = DB::table('kmi_smartlegal_2023.mdocuments AS d')
        ->leftJoin('db_standardization.musers AS u', 'u.id', '=', 'd.intRequestedBy')
        ->leftJoin('kmi_smartlegal_2023.mmandatories AS m', 'd.intDocID', '=', 'm.intDocID')
        ->leftJoin('kmi_smartlegal_2023.mfiles AS f', 'f.intFileID', 'm.intFileID')
        ->select([
            'd.intDocID', 'd.txtDocName',
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

        // construct request
        $inputFile = [];
        $inputDocument = [];
        $inputMandatory = [];
        $inputPICReminder = [];
        $inputLog = [];
        $inputIssuer = [];

        if ($request->hasFile('txtFile')) {
            $reqFile = $request->file('txtFile');
            $fileName = time() . '_' . $reqFile->getClientOriginalName();
            $reqFile->move('upload/documents', $fileName);
            $inputFile['txtFilename'] = $fileName;
            $inputFile['txtPath'] = '/upload/documents/' . $fileName;
        } else {
            $inputFile['txtFilename'] = $file->txtFilename;
            $inputFile['txtPath'] = $file->txtPath;
        }

        $department = DepartmentModel::where('intDepartment_ID', ($request['intPICDeptID'] ?: $mandatory->intPICDeptID))->first();
        $inputDocument['txtRequestNumber'] = NumberIDGenerator::generateRequestNumber(($request['intTypeID'] ?: $mandatory->intTypeID), $department->txtInitial);
        $inputDocument['txtDocNumber'] = NumberIDGenerator::generateDocumentNumber('PM', ($request['intTypeID'] ?: $mandatory->intTypeID), $department->txtInitial, $id);
        $inputDocument['txtDocName'] = $request['txtDocName'] ?: $document->txtDocName;
        $inputDocument['intRequestedBy'] = Auth::user()->id;
        $inputDocument['intRequestStatus'] = 1; // New Request

        $inputMandatory['intTypeID'] = $request['intTypeID'] ?: $mandatory->intTypeID;
        $inputMandatory['intPICDeptID'] = $request['intPICDeptID'] ?: $mandatory->intPICDeptID;
        $inputMandatory['intPICUserID'] = $request['intPICUserID'] ?: $mandatory->intPICUserID;
        $inputMandatory['intVariantID'] = $request['intVariantID'] ?: $mandatory->intVariantID;
        $inputMandatory['dtmPublishDate'] = $request['dtmPublishDate'] ?: $mandatory->dtmPublishDate;
        $inputMandatory['dtmExpireDate'] = $request['intVariantID'] == 1 ? null : ($request['dtmExpireDate'] ?: $mandatory->dtmExpireDate);
        $inputMandatory['intExpirationPeriod'] = $request['intVariantID'] == 1 ? null : ($inputMandatory['dtmExpireDate'] ? PeriodFormatter::dayCounter($inputMandatory['dtmPublishDate'], $inputMandatory['dtmExpireDate']) : $mandatory->intExpirationPeriod);
        $inputMandatory['intReminderPeriod'] = $request['intVariantID'] == 1 ? null : ($request['intReminderPeriod'] ? PeriodFormatter::countInputToDay($request['intReminderPeriod'], $request['remPeriodUnit']) : $mandatory->intReminderPeriod);
        $inputMandatory['txtLocationFilling'] = $request['txtLocationFilling'];
        $inputMandatory['intRenewalCost'] = $request['intVariantID'] == 1 ? 0 : ($request['intRenewalCost'] ?: $mandatory->intRenewalCost);
        $inputMandatory['intCostCenterID'] = $request['intCostCenterID'];
        $inputMandatory['txtNote'] = $request['txtNote'] ?: '';
        $inputMandatory['txtTerminationNote'] = null;
        $inputMandatory['intCreatedBy'] = Auth::user()->id;

        $inputLog['intState'] = 1; // New Request
        $inputLog['intUserID'] = Auth::user()->id;
        $inputLog['txtNote'] = $request['txtNote'];
        $inputLog['txtLeadTime'] = null;
        
        try {
            DB::beginTransaction();
            
            if ($request->hasFile('txtFile')) {
                $createFile = File::create($inputFile);
                $inputMandatory['intFileID'] = $createFile->intFileID;
            } else {
                $inputMandatory['intFileID'] = $file->intFileID;
            }

            $createDocument = Document::create($inputDocument);

            if ($request['intIssuerID'] == 0) {
                $inputIssuer['txtIssuerName'] = $request['txtOtherIssuer'];
                $inputIssuer['txtCode'] = TextFormatter::getInitials($request['txtOtherIssuer']);
                $createIssuer = Issuer::create($inputIssuer);
                $inputMandatory['intIssuerID'] = $createIssuer->intIssuerID;
            } else {
                $inputMandatory['intIssuerID'] = $request['intIssuerID'] ?: $mandatory->intIssuerID;
            }

            $inputMandatory['intDocID'] = $createDocument->intDocID;
            $inputLog['intDocID'] = $createDocument->intDocID;
            $createMandatory = Mandatory::create($inputMandatory);
            
            if ($request['intVariantID'] == 2) {
                if (count($request['picReminders']) > 0) {
                    foreach ($request['picReminders'] as $pr) {
                        $inputPICReminder['intUserID'] = $pr;
                        $inputPICReminder['intMandatoryID'] = $createMandatory->intMandatoryID;
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

    public function terminate(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $document = Document::where('intDocID', $id)->update(['intRequestStatus' => 7]);

            $mandatory = Mandatory::where('intDocID', $id)->update(['txtTerminationNote' => $request['txtTerminationNote']]);

            $inputLog['intDocID'] = $id;
            $inputLog['intState'] = 7;
            $inputLog['intUserID'] = Auth::user()->id;
            $inputLog['txtNote'] = $request['txtTerminationNote'];
            $inputLog['txtLeadTime'] = null;

            $createLog = DocApproval::create($inputLog);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Document Terminated Successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'request' => $request['txtTerminationNote']
            ], 500);
        }
    }
}

<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Smartlegal\Entities\Document;
use Modules\Smartlegal\Entities\PICReminder;
use Modules\Smartlegal\Helpers\CurrencyFormatter;
use Modules\Smartlegal\Helpers\PeriodFormatter;
use Yajra\DataTables\DataTables;

class LibraryMandatoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
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
            ->whereIn('mdocuments.intRequestStatus', [3, 5, 6, 7])
            ->get();
    
            $transformedData = $data->map(function ($row) {
                $renewalCost = CurrencyFormatter::formatIDR($row->intRenewalCost, 'Rp');
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
    public function show(Request $request, $id)
    {
        if ($request->wantsJson()) {
            $document = Document::select(DB::raw('substring(txtDocNumber, 1, 11) as docNumber'))
            ->where('intDocID', $id)->first();
            $versions = DB::table('kmi_smartlegal_2023.mdocuments as d')
            ->leftJoin('kmi_smartlegal_2023.mmandatories as m', 'd.intDocID', '=', 'm.intDocID')
            ->leftJoin('kmi_smartlegal_2023.missuers as i', 'm.intIssuerID', '=', 'i.intIssuerID')
            ->leftJoin('kmi_smartlegal_2023.mfiles as f', 'm.intFileID', '=', 'f.intFileID')
            ->select([
                'd.intDocID', 'd.txtDocNumber', 'd.txtDocName', 'd.dtmUpdatedAt',
                'm.intMandatoryID',
                'i.intIssuerID', 'i.txtIssuerName', 'i.txtCode',
                'f.intFileID', 'f.txtFilename', 'f.txtPath'
            ])
            ->where('d.txtDocNumber', 'like', $document->docNumber . '%')
            ->get();

            $transformedData = $versions->map(function ($row) {
                return [
                    'doc_id' => $row->intDocID,
                    'doc_number' => $row->txtDocNumber,
                    'date' => $row->dtmUpdatedAt,
                    'doc_name' => $row->txtDocName,
                    'mandatory_id' => $row->intMandatoryID,
                    'issuer_id' => $row->intIssuerID,
                    'issuer_name' => $row->txtIssuerName,
                    'issuer_code' => $row->txtCode,
                    'file_id' => $row->intFileID,
                    'file_name' => $row->txtFilename,
                    'file_path' => $row->txtPath
                ];
            });

            return DataTables::of($transformedData)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<div class="btn-group"><button onclick="preview('.$row["file_id"].')" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview File"><i class="fas fa-eye"></i></button> <button onclick="download('.$row["file_id"].')" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Download File"><i class="fas fa-download"></i></button></div>';
                })
                ->addColumn('attachment', function($row) {
                    return '<div class="btn-group"><button onclick="attachments('.$row["doc_id"].')" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview File"><i class="fas fa-file"></i></button> <button onclick="upload('.$row["doc_id"].')" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Download File"><i class="fas fa-upload"></i></button></div>';
                })
                ->rawColumns(['action', 'attachment'])
                ->make(true);
        } else {
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
                'm.intMandatoryID', 'm.intExpirationPeriod', 'm.dtmPublishDate', 'm.dtmExpireDate', 'm.intReminderPeriod', 'm.txtLocationFilling', 'm.intRenewalCost', 'm.txtNote', 'm.txtTerminationNote', 'm.intDeleted',
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

            $picData = DB::table('kmi_smartlegal_2023.mpicreminders AS p')
            ->leftJoin('db_standardization.musers AS u', 'p.intUserID', '=', 'u.id')
            ->select('u.txtInitial')
            ->where('p.intMandatoryID', '=', $data->intMandatoryID)
            ->get();

            $picReminder = [];
            foreach ($picData as $pic) {
                array_push($picReminder, $pic->txtInitial);
            }
    
            if ($data->dtmExpireDate) {
                $period = PeriodFormatter::readablePeriod($data->dtmPublishDate, $data->dtmExpireDate);
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
                'date' => $data->dtmPublishDate . ($data->dtmExpireDate ? ' s.d. ' . $data->dtmExpireDate : ''),
                'issuer' => $data->txtIssuerName . ' (' . $data->txtCode . ')',
                'rem_period' => $remPeriod,
                'location' => $data->txtLocationFilling,
                'renewal_cost' => $renewalCost,
                'cost_center' => $data->txtCostCenterInitial,
                'note' => $data->txtNote ?: '-',
                'termination_note' => $data->txtTerminationNote ?: '-',
                'file_id' => $data->intFileID,
                'file_path' => $data->txtPath,
                'file_name' => $data->txtFilename,
                'pic_reminder' => count($picReminder) > 0 ? implode(", ", $picReminder) : '-'
            ];
    
            return view('smartlegal::pages.library.mandatory.detail', [
                'mandatory' => $mandatory,
            ]);
        }
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

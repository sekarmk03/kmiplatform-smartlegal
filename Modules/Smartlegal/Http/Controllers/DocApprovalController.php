<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Smartlegal\Entities\DocApproval;
use Yajra\DataTables\DataTables;

class DocApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('smartlegal::index');
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

    /**
     * Get approval list by document
     * @param int $id
     * @return Renderable
     */
    public function getLogByDocument(Request $request, $id)
    {
        if ($request->wantsJson()) {
            $approvals = DB::table('kmi_smartlegal_2023.trdocumentapprovals AS da')
            ->leftJoin('db_standardization.musers AS u', 'u.id', '=', 'da.intUserID')
            ->leftJoin('kmi_smartlegal_2023.mdocumentstatuses AS s', 's.intDocStatusID', '=', 'da.intState')
            ->select([
                'da.intApprovalID', 'da.txtNote', 'da.txtLeadTime', 'da.dtmCreatedAt', 'da.dtmUpdatedAt',
                'u.txtName', 'u.txtInitial',
                's.txtStatusName'
            ])
            ->where('da.intDocID', $id)
            ->get();
        
            $transform = $approvals->map(function ($row) {
                return [
                    'approval_id' => $row->intApprovalID,
                    'date' => $row->dtmCreatedAt,
                    'name' => $row->txtName . ' (' . $row->txtInitial . ')',
                    'status' => $row->txtStatusName,
                    'lead_time' => $row->txtLeadTime,
                    'note' => $row->txtNote,
                ];
            });

            return DataTables::of($transform)
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Not Found'
            ], 404);
        }
    }
}

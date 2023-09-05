<?php

namespace Modules\FTQ\Http\Controllers;

use App\Models\User;
use App\Notifications\PublishForm;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\FTQ\Entities\LevelAccess;
use Modules\FTQ\Entities\MfatblendVerification as Mfatblend;
use Modules\FTQ\Entities\TrfatblendVerification as TrFatblend;
use Yajra\DataTables\DataTables;

class FatBlendVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $leader;
    public function __construct(){
        $this->leader = LevelAccess::where('intLevel_ID', 4)->get(['user_id'])->toArray();
    }
    private function _isMessageSuccess($param){
        switch ($param) {
            case 'draft':
                return 'Verifikasi Fat Blend berhasil disimpan sebagai Draft';
                break;
            
            default:
                return 'Verifikasi Fat Blend berhasil dipublish';
                break;
        }
    }
    private function _isChecked($param) {
        return empty($param)?0:1;
    }
    function _isAnalyst() {
        $data = Mfatblend::join('db_standardization.musers AS user', 'user.id', '=', 'mfatblend_verification.txtCreatedBy')
            ->get(['mfatblend_verification.*', 'user.txtName']);
        return $data;
    }
    function _isLeader(){
        $data = Mfatblend::join('db_standardization.musers AS user', 'user.id', '=', 'mfatblend_verification.txtCreatedBy')
            ->where('intIsDraft', 0)
            ->get(['mfatblend_verification.*', 'user.txtName']);
        return $data;
    }
    public function index(Request $request)
    {
        $role = LevelAccess::where('user_id', Auth::user()->id)->first();
        if ($request->wantsJson()) {
            switch ($role->intLevel_ID) {
                case 4:
                    $data = $this->_isLeader();
                    break;
                
                default:
                    $data = $this->_isAnalyst();
                    break;
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) use ($role) {
                    if ($row->intIsDraft == 1) {
                        $btn_edit = '<button onclick="edit('.$row->intVerification_ID.')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></button> <button onclick="destroy('.$row->intVerification_ID.')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
                    } else {
                        if ($role->intLevel_ID == 4) {
                            $btn_edit = '<button onclick="edit('.$row->intVerification_ID.')" class="btn btn-sm btn-info"><i class="fa-solid fa-eye"></i></button>';
                        } else {
                            $btn_edit = '<span class="badge bg-secondary">Not Available</span>';                        
                        }
                    }
                    return $btn_edit;
                })
                ->editColumn('dtmCreatedAt', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreatedAt));
                })
                ->addColumn('status', function($row){
                    if ($row->intIsDraft == 1) {
                        $status = '<span class="badge bg-secondary">Draft</span>';
                    } else {
                        $status = '<span class="badge bg-success">Published</span>';
                    }
                    return $status;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        } else {   
            $qa_emp = User::where('intDepartment_ID', 8)->get(['txtName']);     
            return view('ftq::pages.verifikasi.fat-blend', [
                'qa_emp' => $qa_emp,
                'role' => $role
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ftq::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $result = [];
        foreach ($request->shift as $key => $val) {
            $result[] = [
                'shift' => $request->shift[$key],
                'processmix' => $request->processmix[$key],
                'pic' => $request->pic[$key],
            ];
        }
        $create = Mfatblend::create([
            'txtOkp' => $request->txtOkp,
            'txtOkpType' => $request->txtOkpType,
            'txtProduct' => $request->txtProduct,
            'txtTotal' => $request->txtTotal,
            'tmPlannedStart' => $request->tmPlannedStart,
            'txtMoveOrder' => $request->txtMoveOrder,
            'intFormulaVersion' => $request->intFormula,
            'intIsDraft' => $request->intIsDraft,
            'txtPic' => json_encode($result),
            'txtCreatedBy' => $request->txtCreatedBy,
            'txtUpdatedBy' => $request->txtUpdatedBy
        ]);
        $trfatblend = [];
        foreach ($request->txtIngredient as $key => $item) {
            $trfatblend[] = [
                'intVerification_ID' => $create->intVerification_ID,
                'txtIngredient' => $request->txtIngredient[$key],
                'txtDescription' => $request->txtDescription[$key],
                'intQty' => $request->intQty[$key],
                'txtTotalQty' => $request->txtTotalQty[$key],
                'txtUom' => $request->txtUom[$key],
                'intIsCheck' => $request->intIsCheck[$key]
            ];
        }
        TrFatblend::insert($trfatblend);
        if ($create) {
            if ($request->intIsDraft == 0) {
                Notification::send(User::whereIn('id', $this->leader)->get(), new PublishForm('Verifikasi Fat Blend', Auth::user()->txtName));
            }
            return response()->json([
                'status' => 'success',
                'message' => $this->_isMessageSuccess($request->intIsDraft == 1?'draft':'publish'),
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Verifikasi Fat Blend gagal disimpan'
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
        return view('ftq::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = Mfatblend::with('trfatblend')->find($id);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Verifikasi tidak ditemukan'
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
        $fatblend = Mfatblend::find($id);
        $fatblend->update([
            'intIsDraft' => $request->intIsDraft
        ]);
        TrFatblend::where('intVerification_ID', $id)->delete();
        $trfatblend = [];
        foreach ($request->txtIngredient as $key => $item) {
            $trfatblend[] = [
                'intVerification_ID' => $id,
                'txtIngredient' => $request->txtIngredient[$key],
                'txtDescription' => $request->txtDescription[$key],
                'intQty' => $request->intQty[$key],
                'txtTotalQty' => $request->txtTotalQty[$key],
                'txtUom' => $request->txtUom[$key],
                'intIsCheck' => $request->intIsCheck[$key]
            ];
        }
        $insert = TrFatblend::insert($trfatblend);
        if ($insert) {
            if ($request->intIsDraft == 0) {
                Notification::send(User::whereIn('id', $this->leader)->get(), new PublishForm('Verifikasi Fat Blend', Auth::user()->txtName));
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Draft Verifikasi berhasil diubah',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Verifikasi Fat Blend gagal disimpan'
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
        $data = Mfatblend::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Draft Verifikasi berhasil dihapus'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Draft Verifikasi gagal dihapus'
            ], 500);
        }
    }
}

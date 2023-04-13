<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\AccountModel as Account;
use App\Helpers\LevelAccess as LevelHelp;

class ManageDBAccountController extends Controller
{
    public function getIndex(Request $request)
    {
        if ($request->wantsJson()) {
            if (Auth::user()->intLevel_ID == 1) {
                $accounts = $this->_adminList();
            } else {
                $accounts = $this->_userList();
            }
            return DataTables::of($accounts)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return LevelHelp::btnDatabaseAction($row->intAccount_ID);
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('pages.admin.manage-dbaccount');
        }
    }
    public function storeAccount(Request $request)
    {
        $input = $request->only(['txtUsername', 'txtPassword']);
        $validator = Validator::make($input, Account::rules(), [], Account::attributes());
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $input['user_id'] = Auth::user()->id;
            $input['txtCreatedBy'] = Auth::user()->txtName;
            $account = Account::create($input);
            if ($account) {
                DB::statement("CREATE USER '".$request->txtUsername."'@'localhost' IDENTIFIED BY '".$request->txtPassword."'");
                DB::statement("GRANT SELECT ON db_standardization.musers TO '$account->txtUsername'@'localhost'");
                return response()->json([
                    'status' => 'success',
                    'message' => 'DB Account Created Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Internal Server Error'
                ], 500);
            }
        }
    }

    public function editAccount($id)
    {
        $account = Account::find($id);
        if ($account) {
            return response()->json([
                'status' => 'success',
                'account' => $account
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Exist'
            ], 404);
        }
    }
    public function updateAccount($id, Request $request)
    {
        $account = Account::find($id);
        if ($account) {
            $input = $request->only(['txtUsername', 'txtPassword']);
            $validator = Validator::make($input, Account::rules(), [], Account::attributes());
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 400);
            } else {
                $input['user_id'] = Auth::user()->id;
                $input['txtUpdatedBy'] = Auth::user()->txtName;
                $update = $account->update($input);
                if ($update) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'DB Account Created Successfully'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Internal Server Error'
                    ], 500);
                }
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Exist'
            ], 404);
        }
    }
    public function destroyAccount($id)
    {
        $account = Account::find($id);
        if ($account) {
            DB::statement("DROP USER '$account->txtUsername'@'localhost';");
            $account->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'DB Account deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not Exist'
            ], 404);
        }
    }

    private function _adminList(){
        return Account::orderBy('intAccount_ID', 'DESC')->get();
    }
    private function _userList(){
        return Account::where('user_id', Auth::user()->id)->get();
    }
}

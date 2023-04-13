<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\DatabaseModel as Database;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ManageDatabasesController extends Controller
{
    private function _listTable($id){
        return Database::where('intAccount_ID', $id)->orderBy('intDatabase_ID', 'DESC')->get();
    }
    public function getIndex($id, Request $request)
    {
        if ($request->wantsJson()) {
            $databases = $this->_listTable($id);
            return DataTables::of($databases)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_delete = '<button class="btn btn-sm btn-danger" onclick="destroy('.$row->intDatabase_ID.')"><i class="fa-solid fa-trash"></i></button>';
                    return $btn_delete;
                })
                ->editColumn('dtmCreated', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmCreated));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('pages.admin.manage-databases');
        }
    }
    public function storeDatabase(Request $request)
    {
        $input = $request->only(['intAccount_ID', 'txtDatabaseName', 'txtCreatedBy', 'txtUpdatedBy']);
        $validator = Validator::make($input, Database::rules(), [], Database::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $create = Database::create($input);
            if ($create) {
                $account = AccountModel::find($create->intAccount_ID);
                DB::statement("CREATE DATABASE $create->txtDatabaseName;");
                DB::statement("GRANT ALL PRIVILEGES ON $create->txtDatabaseName.* TO '$account->txtUsername'@'localhost'");
                return response()->json([
                    'status' => 'success',
                    'message' => 'Database Created Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Internal server error'
                ], 500);
            }
        }
    }
    public function destroyDatabase($id)
    {
        $db = Database::find($id);
        if ($db) {
            $db->delete();
            DB::statement("DROP DATABASE $db->txtDatabaseName");
            return response()->json([
                'status' => 'success',
                'message' => 'Database deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }
    }
}

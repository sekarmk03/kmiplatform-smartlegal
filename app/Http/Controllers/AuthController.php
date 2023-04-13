<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ModuleModel as Modules;

class AuthController extends BaseController
{
    protected $rules = [
        'userCredentials' => 'required',
        'txtPassword' => 'required'
    ];
    protected $attributes = [
        'userCredentials' => 'NIK or Username',
        'txtPassword' => 'Password'
    ];
    public function getIndex()
    {
        $qa = Modules::whereHas('user', function($query){
            $query->where('intDepartment_ID', 8);
        })->get();
        // echo "<pre>",var_dump($qa),"</pre>"; die();
        return view('pages.auth', [
            'qas' => $qa
        ]);
    }
    public function postAuth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txtUserCredential' => 'required',
            'txtPassword' => 'required'
        ], [], [
            'txtUserCredential' => 'Username or NIK',
            'txtPassword' => 'Password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $user = User::where('txtUsername', $request->only('txtUserCredential'))
                ->orWhere('txtNik', $request->only('txtUserCredential'))->first(['txtUsername', 'txtNik', 'intActive', 'id']);
            if ($user) {
                if ($user->intActive == 0) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Akun ini belum diaktivasi. Silahkan hubungi pengelola aplikasi ini!'
                    ], 403);
                } else {
                    $remember = false;
                    if ($request->has('remember')) {
                        $remember = true;
                    }
                    if(Auth::attempt(['txtUsername' => $user->txtUsername, 'password' => $request->txtPassword], $remember)){
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Login Successfully. Wait for Redirected !'
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Password you provided is incorrect !'
                        ], 401);
                    }
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username or NIK doesnt exist in our record !'
                ], 404);
            }
        }
    }

    //Logout Function
    public function getLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();    
        $request->session()->regenerateToken();
        return redirect(route('auth.index'));
    }
}

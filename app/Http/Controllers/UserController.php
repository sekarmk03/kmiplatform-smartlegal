<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $rules = [
        'txtOldPassword' => 'required',
        'txtNewPassword' => 'required|same:txtConfirmPassword|max:128',
        'txtConfirmPassword' => 'required|max:128',
    ];
    protected $attributes = [
        'txtOldPassword' => 'Current Password',
        'txtNewPassword' => 'New Password',
        'txtConfirmPassword' => 'Confirm Password',
    ];
    public function getProfile()
    {
        $user = User::join('mjabatans', 'mjabatans.intJabatan_ID', '=', 'musers.intJabatan_ID')
            ->join('mdepartments', 'mdepartments.intDepartment_ID', '=', 'musers.intDepartment_ID')
            ->join('msubdepartments', 'msubdepartments.intSubdepartment_ID', '=', 'musers.intSubdepartment_ID')
            ->join('mcgs', 'mcgs.intCg_ID', '=', 'musers.intCg_ID')
            ->where('id', Auth::user()->id)
            ->first(['musers.*', 'mjabatans.txtNamaJabatan', 'mdepartments.txtDepartmentName',
                'msubdepartments.txtSubdepartmentName', 'mcgs.txtCgName' 
            ]);
        return view('pages.profile', [
            'user' => $user
        ]);
    }
    public function putPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, [], $this->attributes);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 400);
        } else {
            $data = User::find($id);
            if ($data) {
                if (Hash::check($request->txtOldPassword, $data->txtPassword)) {
                    $update = $data->update([
                        'txtPassword' => Hash::make($request->txtNewPassword)
                    ]);
                    if ($update) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Password changed successfully'
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'internal server error'
                        ], 500);
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Wrong current Password'
                    ], 403);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not found'
                ], 404);
            }
        }
    }
    public function putPhotoProfile(Request $request, $id)
    {
        $data = User::find($id);
        if ($request->hasFile('txtPhoto')) {
            if ($data->txtPhoto != 'default.png') {
                $path = public_path('/img/user/'. $data->txtPhoto);
                unlink($path);
            }
            $filename = time().Auth::user()->id.'.'.$request->txtPhoto->extension();
            $request->txtPhoto->move(public_path('img/user/'), $filename);
            $data->update([
                'txtPhoto' => $filename
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Photo Profile changed successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Select Photo to change Photo Profile'
            ], 400);
        }
    }
}

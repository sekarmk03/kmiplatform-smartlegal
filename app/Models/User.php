<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'musers';
    protected $fillable = [
        'txtName', 'txtNik', 'txtUsername', 'txtEmail', 'intDepartment_ID', 'txtInitial',
        'txtPassword', 'txtPhoto', 'intLevel_ID', 'txtCreatedBy', 'txtUpdatedBy'
    ];
    public function getAuthPassword()
    {
        return $this->txtPassword;
    }

    public static function rules($id = false)
    {
        if ($id) {
            return [
                'txtName' => 'required|max:128',
                'txtUsername' => 'required|unique:musers,txtUsername,'.$id,
                'txtEmail' => 'required|email|unique:musers,txtEmail,'.$id,
                'txtNik' => 'required|unique:musers,txtNik,'.$id,
                'txtInitial' => 'required|max:4|unique:musers,txtInitial,'.$id,
                'intLevel_ID' => 'required',
                'intDepartment_ID' => 'required',
                'txtPhoto' => 'image|mimes:jpg,png,jpeg'
            ];
        } else {
            return [
                'txtName' => 'required|max:128',
                'txtUsername' => 'required|unique:musers,txtUsername',
                'txtEmail' => 'required|email|unique:musers,txtEmail',
                'txtInitial' => 'required|max:4|unique:musers,txtInitial',
                'txtNik' => 'required|unique:musers,txtNik',
                'txtPassword' => 'required',
                'intLevel_ID' => 'required',
                'intDepartment_ID' => 'required',
                'txtPhoto' => 'image|mimes:jpg,png,jpeg'
            ];
        }
    }
    public static function attributes()
    {
        return [
            'txtName' => 'Name',
            'txtUsername' => 'Username',
            'txtEmail' => 'Email',
            'txtNik' => 'NIK',
            'txtInitial' => 'Initial',
            'txtPassword' => 'Password',
            'intLevel_ID' => 'Level',
            'intDepartment_ID' => 'Department'
        ];
    }
}

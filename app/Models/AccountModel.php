<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'maccounts';
    protected $primaryKey = 'intAccount_ID';
    protected $fillable = [
        'user_id', 'txtUsername', 'txtPassword', 'txtCreatedBy', 'txtUpdatedBy'
    ];

    public static function rules(){
        return [
            'txtUsername' => 'required|max:64',
            'txtPassword' => 'required|max:64'
        ];
    }
    public static function attributes(){
        return [
            'txtUsername' => 'Username',
            'txtPassword' => 'Password'
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPositionModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'mjabatans';
    protected $primaryKey = 'intJabatan_ID';
    protected $fillable = [
        'intDepartment_ID', 'txtNamaJabatan', 'txtCreatedBy', 'txtUpdatedBy'
    ];

    public static function rules(){
        return [
            'intDepartment_ID' => 'required',
            'txtNamaJabatan' => 'required'
        ];
    }
    public static function attributes(){
        return [
            'intDepartment_ID' => 'Department',
            'txtNamaJabatan' => 'Job Position Name'
        ];
    }
}

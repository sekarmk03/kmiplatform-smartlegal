<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubdepartmentModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'msubdepartments';
    protected $primaryKey = 'intSubdepartment_ID';
    protected $fillable = [
        'intDepartment_ID', 'txtSubdepartmentName'
    ];

    public static function rules(){
        return [
            'intDepartment_ID' => 'required',
            'txtSubdepartmentName' => 'required'
        ];
    }
    public static function attributes(){
        return [
            'intDepartment_ID' => 'Department',
            'txtSubdepartmentName' => 'Subdepartment Name'
        ];
    }
}

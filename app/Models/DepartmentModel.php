<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'mdepartments';
    protected $primaryKey = 'intDepartment_ID';
    protected $fillable = [
        'txtDepartmentName', 
        'txtInitial', 
        'txtCreatedBy', 
        'txtUpdatedBy'
    ];

    public static function rules()
    {
        return [
            'txtDepartmentName' => 'required|max:64',
            'txtInitial' => 'required|max:4'
        ];
    }

    public static function attributes(){
        return [
            'txtDepartmentName' => 'Department Name',
            'txtInitial' => 'Department Initial'
        ];
    }
}

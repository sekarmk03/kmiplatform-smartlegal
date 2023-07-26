<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function users(): HasMany 
    {
        return $this->hasMany(User::class, 'intDepartment_ID');
    }

    public static function departmentModule(){
        $data = DepartmentModel::with(['users' => function ($query){
            $query->select('id', 'txtName', 'intDepartment_ID');
        }, 'users.modules' => function($query){
            $query->select('intModule_ID', 'user_id', 'txtModuleName');
        }])->get();
        $result = [];
        foreach ($data as $val) {
            $modules = [];
            foreach ($val->users as $idx => $value) {
                foreach ($value->modules as $module) {
                    $modules[] = [
                        'module' => $module->txtModuleName
                    ];
                }
            }
            $result[] = [
                'id' => $val->intDepartment_ID,
                'department' => $val->txtInitial,
                'modules' => $modules
            ];
        }
        return $result;
    }

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

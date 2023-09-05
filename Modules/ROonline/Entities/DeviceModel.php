<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceModel extends Model
{
    use HasFactory;
    CONST CREATED_AT = 'dtmInserted';
    CONST UPDATED_AT = 'dtmUpdated';
    protected $connection = 'roonline';
    protected $table = 'mst_romodule';
    protected $primaryKey = 'intROModule_ID';

    protected $fillable = [
        'txtModuleName', 'intLocater_ID', 'bitActive', 'txtInsertedBy', 'txtUpdatedBy'
    ];
    
    public static function rules(){
        return [
            'txtModuleName' => 'required',
            'intLocater_ID' => 'required',
        ];
    }
    public static function attributes(){
        return [
            'txtModuleName' => 'Module Name',
            'intLocater_ID' => 'Locater',
        ];
    }
}

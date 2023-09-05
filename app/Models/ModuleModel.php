<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';

    protected $table = 'mmodules';
    protected $primaryKey = 'intModule_ID';
    protected $fillable = ['user_id', 'txtModuleName', 'intStatus', 'txtCreatedBy', 'txtUpdatedBy'];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public static function rules(){
        return [
            'txtModuleName' => 'required|max:64'
        ];
    }

    public static function attributes()
    {
        return [
            'txtModuleName' => 'Module Name'
        ];
    }
}

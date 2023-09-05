<?php

namespace Modules\FTQ\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomParameter extends Model
{
    use SoftDeletes;
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    const DELETED_AT = 'dtmDeletedAt';
    protected $connection = 'ftq';
    protected $table = 'mcustom_parameter';
    protected $primaryKey = 'intCustomParameter_ID';

    protected $fillable = ['txtCustomValue', 'txtCreatedBy', 'txtUpdatedBy', 'txtDeletedBy'];

    public static function rules(){
        return [
            'txtCustomValue' => 'required|max:64'
        ];
    }
    public static function attributes(){
        return [
            'txtCustomValue' => 'Custom Value'
        ];
    }
}

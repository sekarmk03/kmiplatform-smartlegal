<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reason extends Model
{
    use HasFactory;
    protected $connection = 'rois';
    protected $table = 'mreasonro';
    protected $primaryKey = 'intReasonRO_ID';
    CONST CREATED_AT = 'dtmCreatedAt';
    CONST UPDATED_AT = 'dtmUpdatedAt';

    protected $fillable = ['intLog_History_ID', 'txtReason', 'txtCreatedBy'];
    public static function rules()
    {
        return [
            'txtReason' => 'required|max:256',
        ];
    }
    public static function attributes()
    {
        return [
            'intLog_History_ID' => 'Log History',
            'txtReason' => 'Reason',
        ];
    }
}

<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Line extends Model
{
    use HasFactory;
    protected $connection = 'rois';
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    const DELETED_AT = 'dtmDeletedAt';
    protected $table = 'mline';
    protected $primaryKey = 'intLine_ID';
    protected $dates = ['dtmDeletedAt'];

    protected $fillable = ['txtLineProcessName','txtCreatedBy', 'txtUpdatedBy', 'txtDeletedBy'];
    
    public static function rules(){
        return [
            'txtLineProcessName' => 'required|max:64'
        ];
    }
    public static function attributes(){
        return [
            'txtLineProcessName' => 'Line Process'
        ];
    }
}

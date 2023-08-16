<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrUser extends Model
{
    use HasFactory;
    protected $connection = 'rois';
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $table = 'truser_level';

    protected $fillable = ['intLevel_ID', 'user_id'];
    
    public static function rules(){
        return [
            'intLevel_ID' => 'required',
            'user_id' => 'required'
        ];
    }
    public static function attributes(){
        return [
            'intLevel_ID' => 'Level',
            'user_id' => 'User'
        ];
    }
}

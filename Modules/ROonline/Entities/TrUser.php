<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;

class TrUser extends Model
{
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $connection = 'roonline';
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

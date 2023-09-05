<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'mlevels';
    protected $primaryKey = 'intLevel_ID';
    protected $fillable = [
        'txtLevelName',
        'txtCreatedBy',
        'txtUpdatedBy',
    ];

    public static function rules(){
        return [
            'txtLevelName' => 'required'
        ];
    }

    public static function attributes(){
        return [
            'txtLevelName' => 'Level Name'
        ];
    }
}

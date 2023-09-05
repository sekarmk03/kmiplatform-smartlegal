<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shetabit\Visitor\Traits\Visitable;

class Area extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'roonline';
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    const DELETED_AT = 'dtmDeletedAt';
    protected $table = 'marea';
    protected $primaryKey = 'intArea_ID';
    protected $dates = ['dtmDeletedAt'];

    protected $fillable = [
        'txtAreaName', 'txtCreatedBy', 'txtUpdatedBy', 'txtDeletedBy'
    ];

    public static function rules()
    {
        return [
            'txtAreaName' => 'required|max:64'
        ];
    }
    public static function attributes(){
        return [
            'txtAreaName' => 'Area Name'
        ];
    }
}

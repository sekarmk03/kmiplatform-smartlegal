<?php

namespace Modules\FTQ\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use SoftDeletes;
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    const DELETED_AT = 'dtmDeletedAt';
    protected $connection = 'ftq';
    protected $table = 'mparameter';
    protected $primaryKey = 'intParameter_ID';

    protected $fillable = [
        'txtParameter', 'txtStandar', 'txtInputType', 'intMin', 'intMax',
        'txtCreatedBy', 'txtUpdatedBy', 'txtDeletedBy'
    ];

    public function tr_parameter()
    {
        return $this->hasMany('Modules\FTQ\Entities\TrParameter', 'intParameter_ID');
    }

    public static function rules(){
        return [
            'txtParameter' => 'required|max:64',
            'txtStandar' => 'required|max:32',
            'txtInputType' => 'required|max:16',
            'intMin' => 'nullable',
            'intMax' => 'nullable',
        ];
    }
    public static function attributes(){
        return [
            'txtParameter' => 'Parameter Name',
            'txtStandar' => 'Standar Parameter',
            'txtInputType' => 'Input Type',
            'intMin' => 'Min',
            'intMax' => 'Max',
        ];
    }
}

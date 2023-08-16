<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mlevel extends Model
{
    use HasFactory;
    protected $connection = 'rois';
    CONST CREATED_AT = 'dtmCreatedAt';
    CONST UPDATED_AT = 'dtmUpdatedAt';
    protected $table = 'mlevels';
    protected $primaryKey = 'intLevel_ID';

    protected $fillable = [
        'intLevel_ID', 'txtLevelName'
    ];
}

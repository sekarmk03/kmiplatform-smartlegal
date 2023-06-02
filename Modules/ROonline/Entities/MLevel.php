<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MLevel extends Model
{
    use HasFactory;
    CONST CREATED_AT = 'dtmCreatedAt';
    CONST UPDATED_AT = 'dtmUpdatedAt';
    protected $connection = 'roonline';
    protected $table = 'mlevels';
    protected $primaryKey = 'intLevel_ID';

    protected $fillable = [
        'intLevel_ID', 'txtLevelName'
    ];
}

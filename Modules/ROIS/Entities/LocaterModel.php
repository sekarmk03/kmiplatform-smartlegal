<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocaterModel extends Model
{
    use HasFactory;
    protected $connection = 'rois';
    CONST CREATED_AT = 'dtmInserted';
    CONST UPDATED_AT = 'dtmUpdated';
    protected $table = 'mst_locater';
    protected $primaryKey = 'intLocater_ID';

    protected $fillable = ['txtLocaterName', 'bitActive', 'txtInsertedBy', 'txtUpdatedBy'];
}

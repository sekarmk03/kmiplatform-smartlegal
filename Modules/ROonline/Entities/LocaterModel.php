<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocaterModel extends Model
{
    use HasFactory;
    CONST CREATED_AT = 'dtmInserted';
    CONST UPDATED_AT = 'dtmUpdated';
    protected $connection = 'roonline';
    protected $table = 'mst_locater';
    protected $primaryKey = 'intLocater_ID';

    protected $fillable = ['txtLocaterName', 'bitActive', 'txtInsertedBy', 'txtUpdatedBy'];
    
    protected static function newFactory()
    {
        return \Modules\ROonline\Database\factories\LocaterModelFactory::new();
    }
}

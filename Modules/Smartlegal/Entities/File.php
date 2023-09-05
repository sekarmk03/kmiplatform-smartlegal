<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mfiles';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intFileID';
    protected $fillable = ['txtFilename', 'txtPath'];
    
    public function mandatories() {
        return $this->hasOne(Mandatory::class, 'intFileID', 'intFileID');
    }
}

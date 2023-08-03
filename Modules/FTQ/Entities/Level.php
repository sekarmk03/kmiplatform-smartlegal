<?php

namespace Modules\FTQ\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FTQ\Entities\LevelAccess;

class Level extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $connection = 'ftq';
    protected $table = 'mlevels';
    protected $primaryKey = 'intLevel_ID';

    protected $fillable = ['txtLevelName'];
    
    public static function rules(){
        return [
            'txtLevelName' => 'required|max:32'
        ];
    }

    public static function attributes(){
        return [
            'txtLevelName' => 'Level Name'
        ];
    }

    public function access()
    {
        return $this->hasMany(LevelAccess::class, 'intLevel_ID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LevelAccessModel extends Model
{
    use HasFactory;

    protected $table = 'trlevel_access';
    // protected $primaryKey = 'intLevelAccess_ID';
    protected $fillable = [
        'intLevel_ID', 'intSubmenu_ID', 'intRoute_ID', 'intAccessible'
    ];
}

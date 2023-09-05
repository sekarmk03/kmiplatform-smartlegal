<?php

namespace Modules\FTQ\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MfatblendVerification extends Model
{
    use HasFactory;
    protected $connection = 'ftq';
    public $timestamps = false;
    protected $primaryKey = 'intVerification_ID';
    protected $table = 'mfatblend_verification';

    protected $fillable = ['txtOkp', 'txtOkpType', 'txtProduct', 'txtTotal', 'tmPlannedStart', 
        'txtMoveOrder', 'intFormulaVersion', 'intIsDraft', 'txtApproveLeader', 'dtmApproval',
        'txtPic', 'txtCreatedBy', 'txtUpdatedBy'];
    
    public function trfatblend(): HasMany{
        return $this->hasMany(TrfatblendVerification::class, 'intVerification_ID');
    }
}

<?php

namespace Modules\FTQ\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrfatblendVerification extends Model
{
    use HasFactory;
    protected $connection = 'ftq';
    public $timestamps = false;
    protected $table = 'trfatblend_verification';

    protected $fillable = ['intVerification_ID', 'txtIngredient', 'txtDescription', 
        'intQty', 'txtTotalQty', 'txtUom', 'intIsCheck'];    
}

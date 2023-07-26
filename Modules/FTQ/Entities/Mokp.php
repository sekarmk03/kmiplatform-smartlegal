<?php

namespace Modules\FTQ\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mokp extends Model
{
    use HasFactory;
    protected $connection = 'ftq';
    protected $table = 'mokp_api';

    protected $fillable = [];        
}

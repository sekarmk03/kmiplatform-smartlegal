<?php

namespace Modules\FTQ\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrParameter extends Model
{
    use HasFactory;
    protected $connection = 'ftq';
    protected $table = 'tr_parameter';

    protected $fillable = ['intParameter_ID', 'intCustomParameter_ID'];
}

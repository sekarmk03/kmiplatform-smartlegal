<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogRHTemp extends Model
{
    use HasFactory;
    protected $connection = 'roonline';
    protected $table = 'log_rhandtemp';

    protected $fillable = ['txtLineProcessName', 'intArea_ID', 'intModule_ID', 'floatTemp', 'floatRH'];
}

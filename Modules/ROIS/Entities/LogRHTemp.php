<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogRHTemp extends Model
{
    use HasFactory;
    protected $connection = 'rois';
    protected $table = 'log_rhandtemp';

    protected $fillable = ['txtLineProcessName', 'intArea_ID', 'intModule_ID', 'floatTemp', 'floatRH'];
}

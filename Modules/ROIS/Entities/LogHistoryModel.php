<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogHistoryModel extends Model
{
    use HasFactory;
    protected $connection = 'rois';
    CONST CREATED_AT = 'TimeStamp';
    protected $table = 'log_history';
    protected $primaryKey = 'intLog_History_ID';

    protected $fillable = [];
}

<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogHistoryModel extends Model
{
    use HasFactory;
    CONST CREATED_AT = 'TimeStamp';
    protected $connection = 'roonline';
    protected $table = 'log_history';
    protected $primaryKey = 'intLog_History_ID';

    protected $fillable = [];
}

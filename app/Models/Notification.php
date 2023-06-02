<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    CONST CREATED_AT = 'dtmCreatedAt';
    CONST UPDATED_AT = 'dtmUpdatedAt';
    protected $table = 'mnotifications';
    protected $primaryKey = 'intNotification_ID';
    protected $fillable = ['txtnotification'];
}

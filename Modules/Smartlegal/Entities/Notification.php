<?php

namespace Modules\Smartlegal\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mnotifications';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intNotificationID';
    protected $fillable = ['intUserID', 'txtType', 'txtSubject', 'txtContent', 'txtLinkedData', 'dtmReadAt'];
    
    public function user() {
        return $this->belongsTo(User::class, 'intUserID', 'id');
    }
}

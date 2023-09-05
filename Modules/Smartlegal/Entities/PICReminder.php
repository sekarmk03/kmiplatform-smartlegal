<?php

namespace Modules\Smartlegal\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PICReminder extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mpicreminders';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intPICReminderID';
    protected $fillable = ['intUserID', 'intMandatoryID'];

    public static function rules() {
        return [
            'intUserID' => 'required|numeric',
            'intMandatoryID' => 'required|numeric'
        ];
    }

    public static function attributes() {
        return [
            'intUserID' => 'User',
            'intMandatoryID' => 'Mandatory'
        ];
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'intUserID', 'id');
    }

    public function mandatory() {
        return $this->belongsTo(Mandatory::class, 'intMandatoryID', 'intMandatoryID');
    }
}

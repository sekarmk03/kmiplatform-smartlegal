<?php

namespace Modules\Smartlegal\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocApproval extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'trdocumentapprovals';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intApprovalID';
    protected $fillable = ['intDocID', 'intState', 'intUserID', 'txtNote', 'txtLeadTime'];

    public static function rules()
    {
        return [
            'txtNote' => 'nullable|max:1000'
        ];
    }

    public static function attributes(){
        return [
            'txtNote' => 'Approval Note'
        ];
    }
    
    public function document() {
        return $this->belongsTo(Document::class, 'intDocID', 'intDocID');
    }

    public function approver() {
        return $this->belongsTo(User::class, 'intUserID', 'id');
    }
}

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
    protected $fillable = ['intDocID', 'intUserID', 'txtNotes', 'intLeadTime'];
    
    public function document() {
        return $this->belongsTo(Document::class, 'intDocID', 'intDocID');
    }

    public function approver() {
        return $this->belongsTo(User::class, 'intUserID', 'id');
    }
}

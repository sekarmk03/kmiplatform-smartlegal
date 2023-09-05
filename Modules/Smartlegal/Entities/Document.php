<?php

namespace Modules\Smartlegal\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mdocuments';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intDocID';
    protected $fillable = ['txtRequestNumber', 'txtDocNumber', 'txtDocName', 'intRequestedBy', 'intRequestStatus'];
    
    public static function rules()
    {
        return [
            'txtRequestNumber' => 'required|max:50|unique:mdocuments,txtRequestNumber',
            'txtDocNumber' => 'required|max:50|unique:mdocuments,txtDocNumber',
            'txtDocName' => 'required|max:100'
        ];
    }

    public static function attributes(){
        return [
            'txtRequestNumber' => 'Request Number',
            'txtDocNumber' => 'Document Number',
            'txtDocName' => 'Document Name'
        ];
    }

    public function mandatory() {
        return $this->hasOne(Mandatory::class, 'intDocID', 'intDocID');
    }

    public function status() {
        return $this->belongsTo(DocStatus::class, 'intRequestStatus', 'intDocStatus');
    }

    public function requestedby() {
        return $this->belongsTo(User::class, 'intRequestedBy', 'id');
    }

    public function approvals() {
        return $this->hasMany(DocApproval::class, 'intDocID', 'intDocID');
    }
}

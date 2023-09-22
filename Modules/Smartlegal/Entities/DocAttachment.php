<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocAttachment extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mattachments';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intAttachmentID';
    protected $fillable = ['intDocID', 'intFileID', 'intCreatedBy'];

    public static function rules() {
        return [
            'intDocID' => 'required|numeric',
            'intFileID' => 'required|numeric',
            'intCreatedBy' => 'required|numeric'
        ];
    }

    public static function attributes() {
        return [
            'intDocID' => 'Document ID',
            'intFileID' => 'File ID',
            'intCreatedBy' => 'Created By'
        ];
    }

    public function document() {
        return $this->belongsTo(Document::class, 'intDocID', 'intDocID');
    }

    public function file() {
        return $this->belongsTo(File::class, 'intFileID', 'intFileID');
    }

    public function user() {
        return $this->belongsTo(User::class, 'intCreatedBy', 'id');
    }
}

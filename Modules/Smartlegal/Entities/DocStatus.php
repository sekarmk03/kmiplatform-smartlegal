<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocStatus extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mdocumentstatuses';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intDocStatusID';
    protected $fillable = ['txtStatusName', 'txtDesc'];

    public function documents() {
        return $this->hasMany(Document::class, 'intRequestStatus', 'intDocStatusID');
    }

    public static function rules()
    {
        return [
            'txtStatusName' => 'required|max:100',
            'txtDesc' => 'nullable|max:1000'
        ];
    }

    public static function attributes(){
        return [
            'txtStatusName' => 'Status Name',
            'txtDesc' => 'Description'
        ];
    }
}

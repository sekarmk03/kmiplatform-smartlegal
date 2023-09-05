<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocType extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mdocumenttypes';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intDocTypeID';
    protected $fillable = ['txtTypeName', 'txtDesc'];
    
    public function mandatories() {
        return $this->hasMany(Mandatory::class, 'intTypeID', 'intDocTypeID');
    }

    public static function rules()
    {
        return [
            'txtTypeName' => 'required|max:100',
            'txtDesc' => 'nullable|max:1000'
        ];
    }

    public static function attributes(){
        return [
            'txtTypeName' => 'Status Name',
            'txtDesc' => 'Description'
        ];
    }
}

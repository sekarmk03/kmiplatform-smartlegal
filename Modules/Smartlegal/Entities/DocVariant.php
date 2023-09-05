<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocVariant extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mdocumentvariants';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intDocVariantID';
    protected $fillable = ['txtVariantName', 'txtDesc'];

    public function mandatories() {
        return $this->hasMany(Mandatory::class, 'intVariantID', 'intDocVariantID');
    }

    public static function rules()
    {
        return [
            'txtVariantName' => 'required|max:100',
            'txtDesc' => 'nullable|max:1000'
        ];
    }

    public static function attributes(){
        return [
            'txtVariantName' => 'Variant Name',
            'txtDesc' => 'Description'
        ];
    }
}

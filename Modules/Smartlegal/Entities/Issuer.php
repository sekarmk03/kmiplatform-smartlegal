<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Issuer extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'missuers';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intIssuerID';
    protected $fillable = ['txtIssuerName', 'txtCode', 'txtDesc'];
    
    public function mandatories() {
        return $this->hasMany(Mandatory::class, 'intIssuerID', 'intIssuerID');
    }

    public static function rules()
    {
        return [
            'txtIssuerName' => 'required|max:100',
            'txtCode' => 'nullable|max:20',
            'txtDesc' => 'nullable|max:1000'
        ];
    }

    public static function attributes(){
        return [
            'txtIssuerName' => 'Issuer Name',
            'txtCode' => 'Issuer Code',
            'txtDesc' => 'Description'
        ];
    }
}

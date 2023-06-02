<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CGModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'mcgs';
    protected $primaryKey = 'intCg_ID';
    protected $fillable = [
        'txtCgName'
    ];
    public static function rules(){
        return [
            'txtCgName' => 'required'
        ];
    }
    public static function attributes(){
        return [
            'txtCgName' => 'CG Name'
        ];
    }
}

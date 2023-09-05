<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'roonline';
    protected $table = 'trprocess';
    protected $primaryKey = 'intProcess_ID';

    protected $fillable = [
        'txtLineProcessName', 'txtBatchOrder', 'txtProductName',
        'txtProductionCode', 'dtmExpireDate', 'txtOptFilling', 'txtOptQA'
    ];

    public static function rules(){
        return [
            'txtLineProcessName' => 'required',
            'txtBatchOrder' => 'required',
            'txtProductName' => 'required',
        ];
    }
}

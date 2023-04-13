<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatabaseModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'mdatabases';
    protected $primaryKey = 'intDatabase_ID';
    protected $fillable = [
        'intAccount_ID', 'txtDatabaseName', 'txtCreatedBy', 'txtUpdatedBy'
    ];

    public static function rules()
    {
        return [
            'txtDatabaseName' => 'required|max:64'
        ];
    }
    public static function attributes()
    {
        return [
            'txtDatabaseName' => 'Database Name'
        ];
    }
}

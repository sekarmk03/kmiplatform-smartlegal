<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mpermissions';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intPermissionID';
    protected $fillable = ['txtPermissionName', 'txtDesc'];
    
    public function roles() {
        return $this->hasMany(Role::class, 'intPermissionID', 'intPermissionID');
    }

    public static function rules()
    {
        return [
            'txtPermissionName' => 'required|max:100',
            'txtDesc' => 'nullable|max:1000'
        ];
    }

    public static function attributes(){
        return [
            'txtPermissionName' => 'Permission Name',
            'txtDesc' => 'Description'
        ];
    }
}

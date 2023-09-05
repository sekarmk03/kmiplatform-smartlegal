<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mroles';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intRoleID';
    protected $fillable = ['intMenuID', 'intPermissionID', 'txtRoleName', 'txtDesc'];

    public function menu() {
        return $this->belongsTo(Menu::class, 'intMenuID', 'intMenuID');
    }

    public function permission() {
        return $this->belongsTo(Permission::class, 'intPermissionID', 'intPermissionID');
    }

    public function users() {
        return $this->hasMany(UserRole::class, 'intRoleID', 'intRoleID');
    }

    public static function rules() {
        return [
            'txtRoleName' => 'required|max:50',
            'intMenuID' => 'required',
            'intPermissionID' => 'required',
            'txtDesc' => 'nullable|max:1000'
        ];
    }

    public static function attributes() {
        return [
            'txtRoleName' => 'Role Name',
            'intMenuID' => 'Menu',
            'intPermissionID' => 'Permission',
            'txtDesc' => 'Description'
        ];
    }
}

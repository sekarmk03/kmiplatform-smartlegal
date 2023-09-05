<?php

namespace Modules\Smartlegal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mmenus';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intMenuID';
    protected $fillable = ['intParentID', 'txtMenuTitle', 'txtMenuIcon', 'txtUrl', 'txtRouteName', 'intType', 'intOrder', 'txtDescription'];
    
    public function child() {
        return $this->hasMany(Menu::class, 'intParentID', 'intMenuID');
    }

    public function parent() {
        return $this->belongsTo(Menu::class, 'intParentID', 'intMenuID');
    }

    public function roles() {
        return $this->hasMany(Role::class, 'intMenuID', 'intMenuID');
    }
}

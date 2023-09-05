<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmenuModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'msubmenus';
    protected $primaryKey = 'intSubmenu_ID';
    protected $fillable = [
        'intMenu_ID',
        'txtSubmenuTitle',
        'txtUrl',
        'txtRouteName',
        'txtSubmenuIcon',
        'txtCreatedBy',
        'txtUpdatedBy'
    ];

    public function menu()
    {
        return $this->belongsTo('App\Models\MenuModel', 'intMenu_ID');
    }
    public function routes()
    {
        return $this->hasMany('App\Models\RouteModel', 'intSubmenu_ID');
    }
    public function access()
    {
        return $this->hasMany('App\Models\LevelAccessModel', 'intSubmenu_ID');
    }

    public static function rules()
    {
        return [
            'intMenu_ID' => 'required',
            'txtSubmenuTitle' => 'required|max:64',
            'txtUrl' => 'required|max:64',
            'txtRouteName' => 'required|max:64',
            'txtSubmenuIcon' => 'required|max:64'
        ];
    }

    public static function attributes()
    {
        return [
            'txtSubmenuTitle' => 'Sub Menu Title',
            'intMenu_ID' => 'ID Menu',
            'txtUrl' => 'URL',
            'txtRouteName' => 'Route Name',
            'txtSubmenuIcon' => 'Icon'
        ];
    }
}

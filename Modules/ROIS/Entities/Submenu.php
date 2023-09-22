<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submenu extends Model
{
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $connection = 'rois';
    protected $table = 'msubmenu';
    protected $primaryKey = 'intSubmenu_ID';

    protected $fillable = ['intMenu_ID', 'txtSubmenuTitle', 'txtSubmenuIcon', 'txtSubmenuUrl', 'txtSubmenuRoute'];

    public static function rules(){
        return [
            'intMenu_ID' => 'required',
            'txtSubmenuTitle' => 'required|max:64',
            'txtSubmenuIcon' => 'required|max:64',
            'txtSubmenuUrl' => 'required|max:64',
            'txtSubmenuRoute' => 'required|max:64'
        ];
    }

    public static function attributes(){
        return [
            'intMenu_ID' => 'Menu',
            'txtSubmenuTitle' => 'Submenu Title',
            'txtSubmenuIcon' => 'Submenu Icon',
            'txtSubmenuUrl' => 'Submenu URL',
            'txtSubmenuRoute' => 'Submenu Route'
        ];
    }
}

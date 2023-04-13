<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'mmenus';
    protected $primaryKey = 'intMenu_ID';
    protected $fillable = [
        'txtMenuTitle',
        'txtMenuIcon',
        'txtCreatedBy',
        'txtUpdatedBy'
    ];

    public function submenu()
    {
        return $this->hasMany('App\Models\SubmenuModel', 'intMenu_ID');
    }

    public static function rules(){
        return [
            'txtMenuTitle' => 'required|max:64',
            'txtMenuIcon' => 'required|max:64'
        ];
    }

    public static function attributes()
    {
        return [
            'txtMenuTitle' => 'Menu Title',
            'txtMenuIcon' => 'Menu Icon'
        ];
    }
}

<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $connection = 'rois';
    protected $table = 'mmenu';
    protected $primaryKey = 'intMenu_ID';

    protected $fillable = ['txtMenuTitle', 'txtMenuIcon', 'txtMenuRoute', 'txtMenuUrl', 'intQueue'];
    
    public function submenu()
    {
        return $this->hasMany('Modules\ROIS\Entities\Submenu', 'intMenu_ID');
    }

    public static function rules($id = false){
        $connection = 'rois';
        if ($id) {
            return [
                'txtMenuTitle' => 'required|max:64',
                'txtMenuIcon' => 'required|max:64',
                'txtMenuRoute' => 'nullable|max:64',
                'txtMenuUrl' => 'nullable|max:64',
                'intQueue' => "required|numeric|unique:{$connection}.mmenu,intQueue,".$id.',intMenu_ID'
            ];
        } else {
            return [
                'txtMenuTitle' => 'required|max:64',
                'txtMenuIcon' => 'required|max:64',
                'txtMenuRoute' => 'nullable|max:64',
                'txtMenuUrl' => 'nullable|max:64',
                'intQueue' => "required|numeric|unique:{$connection}.mmenu,intQueue"
            ];
        }
    }

    public static function attributes(){
        return [
            'txtMenuTitle' => 'Menu Title',
            'txtMenuIcon' => 'Menu Icon',
            'txtMenuRoute' => 'Route',
            'txtMenuUrl' => 'URL Menu',
            'intQueue' => 'Queue'
        ];
    }
}

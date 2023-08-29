<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModuleModel as Modules;

class DashboardNavigationController extends Controller
{
    public function getIndex()
    {
        $qa = Modules::whereHas('user', function($query){
            $query->where('intDepartment_ID', 8);
        })->get();
        return view('pages.dashboard-navigation', [
            'qas' => $qa
        ]);
    }

    public function getModules($id_dept)
    {
        # code...
    }
}

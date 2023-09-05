<?php

namespace Modules\Smartlegal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Smartlegal\Entities\Menu;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        
        // return $transform;
        if ($request->wantsJson()) {
            $menus = Menu::with('parent')
            ->orderBy('intParentID')
            ->get();
        
            $transform = $menus->map(function ($row) {
                return [
                    'menu_id' => $row->intMenuID,
                    'created_at' => $row->dtmCreatedAt,
                    'parent_title' => $row->intParentID ? $row->parent->txtMenuTitle : 'N/A',
                    'menu_title' => $row->txtMenuTitle,
                    'icon' => $row->txtIcon,
                    'url' => $row->txtUrl,
                    'route' => $row->txtRouteName,
                    'type' => $row->intType,
                    'order' => $row->intOrder,
                    'desc' => $row->txtDesc
                ];
            });

            return DataTables::of($transform)
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return date('Y-m-d H:i', strtotime($row['created_at']));
                })
                ->make(true);
        } else {
            return view('smartlegal::pages.master.menu');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('smartlegal::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('smartlegal::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('smartlegal::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

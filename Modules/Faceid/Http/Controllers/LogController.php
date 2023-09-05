<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Faceid\Entities\Log;
use Modules\Faceid\Entities\Setting;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function index()
    {
        $setting = Setting::find(1);

        return view('faceid::pages.logs.index', compact('setting'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            if ($request->from || $request->to) {
                $to = Carbon::parse($request->to)->addDay(1)->format('Y-m-d');

                $data = DB::table('standardization.musers as users')->join('faceid.logs as log', 'log.user_id', '=', 'users.id')->whereBetween('waktu', [$request->from, $to]);
            } else {
                $data = DB::table('standardization.musers as users')->join('faceid.logs as log', 'log.user_id', '=', 'users.id');
            }

            return DataTables::query($data)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $actionBtn = '<a href="#modal-dialog" id="' . $row->id . '" class="btn btn-sm btn-success btn-edit" data-route="' . route('faceid.karyawan.update', $row->id) . '" data-bs-toggle="modal">Edit</a> <button type="button" data-route="' . route('faceid.karyawan.destroy', $row->id) . '" class="delete btn btn-danger btn-delete btn-sm">Delete</button>';

                    return $actionBtn;
                })
                ->editColumn('txtName', function ($row) {
                    return '<span class="text-dark">' . $row->txtName . '</span>';
                })
                ->editColumn('beard', function ($row) {
                    if ($row->beard == 1) {
                        $beard = 'Yes';
                    } else {
                        $beard = 'No';
                    }

                    if ($row->beard == 1) {
                        return '<span class="badge bg-success">' . $beard . '</span>';
                    } else {
                        return '<span class="badge bg-danger">' . $beard . '</span>';
                    }
                })
                ->editColumn('moustache', function ($row) {

                    if ($row->moustache == 1) {
                        $moustache = 'Yes';
                    } else {
                        $moustache = 'No';
                    }

                    if ($row->moustache == 1) {
                        return '<span class="badge bg-success">' . $moustache . '</span>';
                    } else {
                        return '<span class="badge bg-danger">' . $moustache . '</span>';
                    }
                })
                ->editColumn('suhu', function ($row) {
                    $setting = Setting::find(1);
                    if ($row->suhu > $setting->limit) {
                        return '<span class="badge bg-danger">' . $row->suhu . '</span>';
                    } else {
                        return '<span class="badge bg-success">' . $row->suhu . '</span>';
                    }
                })
                ->editColumn('foto', function ($row) {
                    return '<a href="#modal-dialog" id="" class="btn-action" data-route="' . route('faceid.logs.show', $row->id) . '" data-bs-toggle="modal">
                    <div class="menu-profile-image">
                        <img src="' . asset('/storage/' . $row->foto) . '" alt="User Photo" width="50">
                    </div>
                </a>';
                })
                ->editColumn('dtmCreated', function ($row) {
                    return '<span class="text-dark">' . Carbon::parse($row->waktu)->format('d/m/Y H:i:s') . '</span>';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == "Healthy") {
                        $status = '<span class="badge bg-success">' . $row->status . '</span>';
                    } else {
                        $status = '<span class="badge bg-danger">' . $row->status . '</span>';
                    }

                    return $status;
                })
                ->rawColumns(['action', 'foto', 'txtName', 'beard', 'moustache', 'suhu', 'dtmCreated', 'status'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $log = Log::find($id);

        return response()->json([
            'log' => $log,
            'image' => asset('/storage/' . $log->foto)
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $setting = Setting::find(1);

            $setting->update([
                'limit' => $request->limit
            ]);

            DB::commit();

            return back()->with('success', "Limit successfully updated");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}

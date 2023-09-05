<?php

namespace Modules\Faceid\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Faceid\Entities\Device;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    public function index()
    {

        return view('faceid::pages.device.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Device::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="#modal-dialog" id="' . $row->id . '" class="btn btn-sm btn-success btn-edit" data-route="' . route('faceid.device.update', $row->id) . '" data-bs-toggle="modal">Edit</a> <button type="button" data-route="' . route('faceid.device.destroy', $row->id) . '" class="delete btn btn-danger btn-delete btn-sm">Delete</button>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'iddev' => 'required|numeric',
            'nama_device' => 'required|string',
            'ipaddress' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $device = Device::create([
                'iddev' => $request->iddev,
                'nama_device' => $request->nama_device,
                'ipaddress' => $request->ipaddress,
            ]);

            DB::commit();

            return back()->with('success', "Device berhasil diupload");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        $device = Device::find($id);

        return response()->json([
            'device' => $device
        ]);
    }

    public function update(Request $request, Device $device)
    {
        $request->validate([
            'iddev' => 'required|numeric',
            'nama_device' => 'required|string',
            'ipaddress' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $device->update([
                'iddev' => $request->iddev,
                'nama_device' => $request->nama_device,
                'ipaddress' => $request->ipaddress,
            ]);

            DB::commit();

            return back()->with('success', "Device berhasil diupdate");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Device $device)
    {
        try {
            DB::beginTransaction();

            $device->delete();

            DB::commit();

            return back()->with('success', "Device berhasil dihapus");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}

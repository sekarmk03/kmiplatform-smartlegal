<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\Faceid\Entities\Device;
use Modules\Faceid\Entities\FotoKaryawan;
use Yajra\DataTables\Facades\DataTables;

class FotoKaryawanController extends Controller
{
    public function index()
    {
        $fotoId = DB::connection('faceid')->table('foto_karyawans')->pluck('user_id');

        $karyawan = DB::connection('mysql')->table('musers')->whereNotIn('id', $fotoId)->get();
        $devices = Device::get();

        return view('faceid::pages.karyawan.index', compact('karyawan', 'devices'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('standardization.musers as users')->join('faceid.foto_karyawans as foto', 'foto.user_id', '=', 'users.id')->get(['txtName', 'created_at', 'foto', 'foto.id', 'is_export', 'is_edit']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('checkbox', function ($row) {
                    $checkbox = '';
                    if ($row->is_export == 0) {
                        $checkbox .= '<input type="checkbox" name="" id="' . $row->id . '" class="check-karyawan">';
                    }
                    return $checkbox;
                })
                ->editColumn('action', function ($row) {
                    $actionBtn = '<div class="btn-group my-n1">
                        <button type="button" disabled class="btn btn-secondary btn-sm">Action</button>
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                        <a href="' . route('faceid.karyawan.edit', $row->id) . '" class="dropdown-item ">Edit</a>
                        <a data-route="' . route('faceid.karyawan.destroy', $row->id) . '" class="dropdown-item btn-delete">Delete</a>';
                    if ($row->is_edit == 1) {
                        $actionBtn .= '<a href="' . route('faceid.karyawan.updatePerson', $row->id) . '"  class="dropdown-item btn-update">Update To Device</a> ';
                    }
                    if ($row->is_export == 1) {
                        $actionBtn .= '<a href="' . route('faceid.karyawan.deletePerson', $row->id) . '"  class="dropdown-item btn-del">Delete From Device</a> ';
                    }

                    $actionBtn .= '</div>
                    </div>';
                    return $actionBtn;
                })
                ->editColumn('foto', function ($row) {
                    return '<div class="menu-profile-image">
                    <img src="' . asset('/storage/' . $row->foto) . '" alt="User Photo" width="50">
                </div>';
                })
                ->editColumn('dtmCreated', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
                })
                ->rawColumns(['action', 'foto', 'checkbox'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('faceid::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan' => 'required|numeric',
            'foto' => 'required|mimes:jpg,jpeg,png'
        ]);

        try {
            DB::beginTransaction();

            $karyawan = DB::connection('mysql')->table('musers')->find($request->karyawan);

            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('users', $karyawan->txtNik . '.' . $foto->extension());

            $karyawan = FotoKaryawan::create([
                'user_id' => $request->karyawan,
                'foto' => $fotoUrl,
                'employe_id' => 23 . rand(100, 999)
            ]);

            DB::commit();

            return back()->with('success', "Foto karyawan berhasil diupload");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        $karyawan = FotoKaryawan::find($id);

        return response()->json([
            'karyawan' => $karyawan
        ]);
    }

    public function edit($id)
    {
        $fotoKaryawan = FotoKaryawan::find($id);

        return view('faceid::pages.karyawan.form', compact('fotoKaryawan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|mimes:jpg,jpeg,png'
        ]);

        try {
            DB::beginTransaction();

            $fotoKaryawan = FotoKaryawan::find($id);
            $karyawan = DB::connection('mysql')->table('musers')->find($fotoKaryawan->user_id);

            Storage::delete($fotoKaryawan->foto);
            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('users', $karyawan->txtNik . '.' . $foto->extension());

            $fotoKaryawan->update([
                'foto' => $fotoUrl,
                'is_edit' => 1
            ]);

            DB::commit();

            return redirect()->route('faceid.karyawan.index')->with('success', "Foto karyawan berhasil diupdate");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $fotoKaryawan = FotoKaryawan::find($id);

            Storage::delete($fotoKaryawan->foto);

            $fotoKaryawan->delete();

            DB::commit();

            return back()->with('success', "Foto karyawan berhasil dihapus");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function addPersons(Request $request)
    {
        $device = Device::find($request->device);
        $deviceTarget = $device->iddev;
        $ipDevice = $device->ipaddress;

        $personInfo = [];

        $karyawan = FotoKaryawan::whereIn('id', $request->idkary)->get();

        $newArray = [
            "operator" => "AddPersons",
            "DeviceID" => $deviceTarget,
            "Total" => count($karyawan),
        ];

        foreach ($karyawan as $i => $person) {
            $member = DB::connection('mysql')->table('musers')->find($person->user_id);

            $gambar = file_get_contents(storage_path('/app/public/' . $person->foto));
            $gambar_format = base64_encode($gambar);
            $id = $person->employe_id;

            $personInfo = [
                "Name" => $member->txtName,
                "CustomizeID" => intval($id),
                "PersonUUID" => $id,
                "picinfo" => $gambar_format
            ];
            $newArray["Personinfo_$i"] = $personInfo;
        }

        // Encode newArray to json format
        $json = json_encode($newArray, JSON_UNESCAPED_SLASHES);

        $headers = array(
            "Authorization: Basic " . base64_encode("admin:admin"),
            'Content-Type: application/x-www-form-urlencoded'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ipDevice . '/action/AddPersons');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if ($result['code'] == 200) {
            foreach ($karyawan as $p) {
                $p->update(['is_export' => 1, 'is_edit' => 0]);
            }

            return back()->with('success', "Foto karyawan berhasil diexport");
        } else {
            return back()->with('error', $result);
        }
    }

    public function updatePerson(Request $request, $id)
    {
        if (!$request->device) {
            return back()->with('error', "Select Device");
        }

        $device = Device::find($request->device);
        $deviceTarget = $device->iddev;
        $ipDevice = $device->ipaddress;

        $karyawan = FotoKaryawan::find($id);
        $member = DB::connection('mysql')->table('musers')->find($karyawan->user_id);

        $gambar = file_get_contents(storage_path('/app/public/' . $karyawan->foto));
        $gambar_format = base64_encode($gambar);

        $data = array(
            "operator" => "EditPerson",
            "info" => array(
                "DeviceID" => $deviceTarget,
                "IdType" => 0,
                "CustomizeID" => $karyawan->employe_id,
                "PersonUUID" => $karyawan->employe_id,
            ),
            "picinfo" => $gambar_format
        );

        // Encode newArray to json format
        $json = json_encode($data, JSON_UNESCAPED_SLASHES);

        $headers = array(
            "Authorization: Basic " . base64_encode("admin:admin"),
            'Content-Type: application/x-www-form-urlencoded'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ipDevice . '/action/EditPerson');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if ($result['code'] == 200) {
            $karyawan->update(['is_export' => 1, 'is_edit' => 0]);

            return back()->with('success', "Foto karyawan berhasil diupdate");
        } else {
            return back()->with('error', $result);
        }
    }

    public function deletePerson(Request $request, $id)
    {
        if (!$request->device) {
            return back()->with('error', "Select Device");
        }

        $device = Device::find($request->device);
        $deviceTarget = $device->iddev;
        $ipDevice = $device->ipaddress;

        $karyawan = FotoKaryawan::find($id);
        $member = DB::connection('mysql')->table('musers')->find($karyawan->user_id);

        $gambar = file_get_contents(storage_path('/app/public/' . $karyawan->foto));
        $gambar_format = base64_encode($gambar);

        $data = array(
            "operator" => "DeletePerson",
            "info" => array(
                "DeviceID" => $deviceTarget,
                "IdType" => 0,
                "CustomizeID" => $karyawan->employe_id,
                "PersonUUID" => $karyawan->employe_id,
            ),
        );

        // Encode newArray to json format
        $json = json_encode($data, JSON_UNESCAPED_SLASHES);

        $headers = array(
            "Authorization: Basic " . base64_encode("admin:admin"),
            'Content-Type: application/x-www-form-urlencoded'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ipDevice . '/action/DeletePerson');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if ($result['code'] == 200) {
            $karyawan->update(['is_export' => 0, 'is_edit' => 0]);


            return back()->with('success', "Foto karyawan berhasil diupdate");
        } else {
            return back()->with('error', $result);
        }
    }
}

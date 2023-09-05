<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Faceid\Entities\Device;
use Modules\Faceid\Entities\FotoKaryawan;
use Modules\Faceid\Entities\Log;
use Modules\Faceid\Entities\Setting;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $now = Carbon::now('Asia/Jakarta')->format('YmdHis');

            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('logs', $now . '-' . rand(1000, 9999) . '.' . $foto->extension());

            $device = Device::where('iddev', $request->id_device)->first();

            $user = FotoKaryawan::where('employe_id', $request->employeeid)->first();

            $setting = Setting::find(1);

            if ($request->beard == 1 && $request->moustache == 1 && $request->suhu > $setting) {
                $status = "Healthy";
            } else {
                $status = "Not Healthy";
            }

            Log::create([
                'user_id' => $user->user_id,
                'device_id' => $device->id,
                'moustache' => $request->moustache,
                'beard' => $request->beard,
                'suhu' => $request->suhu,
                'waktu' => $request->waktu,
                'foto' => $fotoUrl,
                'status' => $status
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "Log berhasil disimpan"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}

<?php

namespace Modules\FTQ\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\FTQ\Entities\Mokp;

class FTQController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ftq::index');
    }

    // function getOkp(Request $request){
    //     if ($request->okp) {
    //         $response = Http::withBasicAuth('admin', 'admin')->get(
    //             'http://kmisvrlar.kalbemorinaga.local:84/api/okpformula',
    //             [
    //                 'nookp' => $request->okp,
    //                 'decode_content' => false,
    //                 'headers' => [
    //                     'Content-Type' => 'application/json',
    //                 ],
    //             ]
    //         );
    //         $result = json_decode($response->getBody()->getContents(), true);
    //         $datas = collect($result['data'])->all();
    //     } else {
    //         $response = Http::withBasicAuth('admin', 'admin')->get(
    //             'http://kmisvrlar.kalbemorinaga.local:84/api/okpformula',
    //             [
    //                 'decode_content' => false,
    //                 'headers' => [
    //                     'Content-Type' => 'application/json',
    //                 ],
    //             ]
    //         );
    //         $result = json_decode($response->getBody()->getContents(), true);
    //         $datas = collect($result['data'])->groupBy('nookp');
    //     }
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $datas
    //     ], 200);
    // }

    public function getOkp(Request $request){
        if ($request->okp) {
            $data = Mokp::where('txtOkp', $request->okp)->get();
        } else {
            $data = Mokp::all(['txtOkp']);
        }
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function getOracle(){
        $data = DB::connection('oracle')->table("XXKMIDQM.KMI_DQM_SPECPARAMTRS_V")->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ftq::create');
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
        return view('ftq::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ftq::edit');
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

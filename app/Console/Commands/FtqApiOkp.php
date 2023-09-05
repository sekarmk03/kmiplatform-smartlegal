<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FtqApiOkp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Ftq:okp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize OKP from API Oracle to Mysql';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mokp_api = DB::connection('ftq')->table('mokp_api');
        $response = Http::withBasicAuth('admin', 'admin')->get(
            'http://kmisvrlar.kalbemorinaga.local:84/api/okpformula',
            [
                'decode_content' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
        $result = json_decode($response->getBody()->getContents(), true);
        $datas = collect($result['data'])->all();
        $mokp_api->truncate();
        foreach ($datas as $key => $val) {
            $mokp_api->insert([
                    'txtOkp' => $val['nookp'],
                    'txtOkpType' => $val['typeokp'],
                    'txtProduct' => $val['product'],
                    'txtTotal' => $val['total'],
                    'tmPlannedStart' => $val['plannedstart'],
                    'txtMoveOrder' => $val['moveorder'],
                    'intFormulaVersion' => $val['formulaversion'],
                    'txtIngredient' => $val['ingredients'],
                    'txtDescription' => $val['descriptions'],
                    'txtCategory' => $val['category'],
                    'intQty' => $val['qty'],
                    'txtUom' => $val['uom']
                ]);
        }
    }
}

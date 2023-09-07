<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class SynchronizeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:synchron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Synchronizer to KMI Option Apps';

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
        $response = Http::withBasicAuth('admin', 'admin')->get(
            'http://kmisvrlar.kalbemorinaga.local:84/api/listkaryawan',
            [
                'decode_content' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
        $result = json_decode($response->getBody()->getContents(), true);
        $datas = collect($result['data'])->all();
        foreach ($datas as $key => $val) {
            if (empty(User::where('txtNik', $val['nik'])->first()) && $val['nik'] != '4dm1n') {
                User::create([
                    'intLevel_ID' => 3,
                    'intDepartment_ID' => $val['relationships']['departemen']['intiddepartemen'],
                    'intSubdepartment_ID' => $val['relationships']['subdepartemen']['intidsubdepartemen'],
                    'intCg_ID' => $val['relationships']['cg']['intidcg'],
                    'intJabatan_ID' => $val['relationships']['jabatan']['intidjabatan'],
                    'txtName' => $val['nama'],
                    'txtNik' => $val['nik'],
                    'txtUsername' => $val['username'],
                    'txtInitial' => $val['inisial'],
                    'txtEmail' => $val['email'],
                    'txtExt' => $val['ext'],
                    'txtPassword' => Hash::make('kalbemorinaga'),
                    'intActive' => 1,
                    'txtCreatedBy' => 'SYNCRONIZER',
                    'txtUpdatedBy' => 'SYNCRONIZER',
                ]);
                printf($val['nik'].":".$val['nama']." - ".$val['relationships']['departemen']['namadepartemen']."\n");
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

class MqttListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listener for MQTT Purpose';

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
        $clientId = 'ClientId_'.substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
        $clean_session = true;
        $connectionSettings = (new ConnectionSettings)
            ->setUsername(null)
            ->setPassword(null);

        $mqtt = new MqttClient('10.175.13.146', 1883, $clientId);
        $mqtt->connect($connectionSettings, $clean_session);
        printf("Client $clientId connected To 10.175.13.146\n");

        $mqtt->subscribe('ro/a2/status', function ($topic, $message) {
            printf("$message\n");
        }, 0);
        $mqtt->subscribe('ro/d1', function ($topic, $message) {
            printf("$message\n");
        }, 0);
        $mqtt->loop(true);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ConnpassApiService;

class ConnpassApiBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:connpass';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'コンパスAPIの情報取得のバッチ処理';

    protected $connpass_api_service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConnpassApiService $connpass_api_service)
    {
        parent::__construct();
        $this->connpass_api_service = $connpass_api_service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->connpass_api_service->getPopularEventData();
        $this->connpass_api_service->getPhpEventData();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ConnpassApiService;

class AlertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:alertcommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '人気急上昇イベントの表示のためのConnpassAPIからの情報取得のバッチ処理';

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
      $this->connpass_api_service->getAlertData();
    }
}

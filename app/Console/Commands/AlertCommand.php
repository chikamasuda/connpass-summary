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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      ConnpassApiService::updateAlertData();
    }
}

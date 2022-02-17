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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ConnpassApiService::updatePopularEventData();
        ConnpassApiService::updatePhpEventData();
    }
}

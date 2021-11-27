<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiService;

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
    protected $description = 'コンパスAPIのアラート表示バッチ処理';

    protected $apiService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $this->apiService->AlertBatch();
      $this->apiService->alertSecondBatch();
    }
}

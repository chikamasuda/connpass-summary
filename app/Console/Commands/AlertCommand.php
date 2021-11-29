<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ApiController;

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

    protected $apiController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ApiController $apiController)
    {
        parent::__construct();
        $this->apiController = $apiController;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $this->apiController->alertBatch();
      $this->apiController->alertSecondBatch();
    }
}

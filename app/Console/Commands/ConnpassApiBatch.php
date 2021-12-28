<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ConnpassApiController;

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
    protected $description = 'コンパスAPIのバッチ処理';

    protected $ConnpassApiController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConnpassApiController $ConnpassApiController)
    {
        parent::__construct();
        $this->ConnpassApiController = $ConnpassApiController;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->ConnpassApiController->popularEventBatch();
        $this->ConnpassApiController->popularEventBatchSecond();
        $this->ConnpassApiController->phpEventBatch();
    }
}

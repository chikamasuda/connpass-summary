<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ConnpassApiController;

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
      $this->ConnpassApiController->alertBatch();
    }
}

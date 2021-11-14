<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ApiRepository;

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

    protected $api_repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ApiRepository $api_repository)
    {
        parent::__construct();
        $this->api_repository = $api_repository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->api_repository->popularEventBatch();

        $this->api_repository->phpEventBatch();
    }
}

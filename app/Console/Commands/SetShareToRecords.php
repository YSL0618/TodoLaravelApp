<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use App\Repositories\Task\TaskRepositoryInterface;
class SetShareToRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:set-share';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '値がnullのTask::shareにユニークキーをセットします';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskRepositoryInterface $task_repository)
    {
        $this->task_repository = $task_repository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        echo "shareの値を追加したレコードの数：".$this->task_repository->setTaskShare()."\n";
    }
}

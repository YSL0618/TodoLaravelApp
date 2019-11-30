<?php

namespace App\Repositories\Task;
use App\Folder;

use App\Task;

class TaskRepository implements TaskRepositoryInterface
{
    protected $task;

    /**
    * @param object $task
    */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * 名前で1レコードを取得
     *
     * @var $task
     * @return object
     */
    public function getRecordByShare($share)
    {
        return Task::where('share', $share)->first();
    }

    public function createTaskShare($task)
    {
        $prefix = (string)rand(1000,9999).(string)$task->id;
        
        $share = uniqid($prefix);
        $task->share = $share;
        $task->save();
        return;
    }
}
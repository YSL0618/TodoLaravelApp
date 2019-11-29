<?php

namespace App\Repositories\Task;

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
    public function getRecordByShare($task)
    {
        return $this->task->where('id', '=', $task->share)->first();
    }
}
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

    public function isRecordByShare($share)
    {
        $result = Task::where('share', $share)->count() > 0 ? true : false;
        return $result;
    }

    public function createTaskShare($task)
    {
        $prefix = (string)rand(1000,9999).(string)$task->id;
        
        $share = uniqid($prefix);
        $task->share = $share;
        $task->save();
        return $this->isRecordByShare($share);
    }

    public function setTaskShare()
    {   
        $tasks =Task::get();
        $countUpdatedTasks = 0;
        foreach ($tasks as $task){
            if (is_null($task->share)){
                if ($this->createTaskShare($task)) $countUpdatedTasks ++;
            }
        }
        return $countUpdatedTasks;
    }

}
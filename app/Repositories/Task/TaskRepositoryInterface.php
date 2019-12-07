<?php

namespace App\Repositories\Task;
use App\Task;
use App\Folder;

use App\Http\Requests\CreateTask;
interface TaskRepositoryInterface
{
    /**
     * @var string $task
     * @return object
     */
    public function getRecordByShare($share);
    public function generateShareKey(Task $task);
    public function isRecordByShare($share);
    public function createNewTask(Folder $folder,CreateTask $request);
    public function setTaskShare();
}
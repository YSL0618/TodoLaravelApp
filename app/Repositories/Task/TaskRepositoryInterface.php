<?php

namespace App\Repositories\Task;

interface TaskRepositoryInterface
{
    /*
     *
     * @var string $task
     * @return object
     */
    public function getRecordByID($task);
}
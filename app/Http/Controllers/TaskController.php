<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Task\TaskRepositoryInterface;

class TaskController extends Controller
{

    public function __construct(TaskRepositoryInterface $task_repository)
    {
        $this->task_repository = $task_repository;
    }

    public function block(Folder $folder)
    {
        if (Auth::user()->id !== $folder->user_id) {
            abort(403);
        }
        $folders = Auth::user()->folders()->get();

        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function index(Folder $folder)
    {
        if (Auth::user()->id !== $folder->user_id) {
            abort(403);
        }
        $folders = Auth::user()->folders()->get();

        $tasks = $folder->tasks()->get();
        foreach ($tasks as $task){
            if (is_null($task->share)){
                $this->task_repository->createTaskShare($task);
            }
        }
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }


    public function create(Folder $folder, CreateTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    
    public function showEditForm(Folder $folder, Task $task)
    {
        $this->verifyFolderAndTask($folder , $task);
        return view('tasks/edit', [
            'task' => $task,
        ]);
    }


    public function showTaskShare($share)
    {
        
        if (!$this->task_repository->isRecordByShare($share)){
            abort(404);
        }
        $task = $this->task_repository->getRecordByShare($share);
        return view('tasks/show_share', [
            'task' => $task,
        ]);
    }


    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->verifyFolderAndTask($folder , $task);
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
    private function verifyFolderAndTask(Folder $folder, Task $task)
    {
        if($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}
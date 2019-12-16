<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Task;
use App\Folder;
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
        $new_id = $this->task_repository->createNewTask( $folder, $request );

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ])->with('flash_message', '新規タスクID: '.$new_id.'の作成が完了しました');
    }

    
    public function showEditForm(Folder $folder, Task $task)
    {
        $this->verifyFolderAndTask($folder , $task);
        $image = $this->task_repository->showS3URL( $task );
        return view('tasks/edit', [
            'task' => $task,
            'image' => $image,
        ]);
    }


    public function showTaskShare($share)
    {
        
        if (!$this->task_repository->isRecordByShare($share)){
            abort(404);
        }
        $image = $this->task_repository->showS3URL( $task );
        $task = $this->task_repository->getRecordByShare($share);
        return view('tasks/show_share', [
            'task' => $task,
            'image' => $image,
        ]);
    }

    public function showTaskInfo(Folder $folder, Task $task)
    {
        if(!Auth::check())return redirect()->route('tasks.show_share', [
            'share' => $task->share,
        ]);
        $image = $this->task_repository->showS3URL( $task );
        $this->verifyFolderAndTask($folder , $task);
        return view('tasks/show_share', [
            'task' => $task,
            'folder' => $folder,
            'image' => $image ,
        ]);
    }

    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->verifyFolderAndTask($folder , $task);
        $this->task_repository->editTask($folder,$task, $request);

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
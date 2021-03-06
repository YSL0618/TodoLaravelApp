<?php

namespace App\Repositories\Task;
use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use Exception;



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

    public function generateShareKey($task)
    {
        $prefix = (string)rand(1000,9999).(string)$task->id;
        return uniqid($prefix);
    }

    public function setTaskShare()
    {   
        $tasks =Task::get();
        $count_updated_tasks = 0;
        $count_all_tasks = 0;
        $ids_list = "";
        $shares_list = "" ;
        foreach ($tasks as $task){
            $count_all_tasks++;
            if (is_null($task->share)){
                $ids_list .= ",{$task -> id}";
                $shares_list .= ", '{$this->generateShareKey($task)}'" ;
                $count_updated_tasks ++;
            }
        }
        if ($count_updated_tasks > 0){
            echo "全{$count_all_tasks}件のうち{ $count_updated_tasks}件に対して、以下のクエリを実行しました。\n";
            $ids_list_without_the_first_comma = substr($ids_list, 1);
            $query = "UPDATE `tasks` SET share = ELT(FIELD(id {$ids_list}){$shares_list}) WHERE id IN ({$ids_list_without_the_first_comma});";
            echo $query."\n";
            $cli = DB::statement($query);
            var_dump($cli);
        } else {
            echo "全{$count_all_tasks}件中、shareの内容を追加したレコードはありませんでした。\n";
        }

        return $count_updated_tasks;

    }
    public function createNewTask(Folder $folder, CreateTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->share = $this->generateShareKey($task);
        $task->detail = $request->detail;
        $requested_file = $request->file('file');
        if ($requested_file){
            $task->image_url = Storage::disk('s3')->url($this->uploadImage($task,$requested_file));
        }
        $folder->tasks()->save($task);
        return $task->id;
}

    public function editTask(Folder $folder, Task $task, EditTask $request)
    {
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->detail = $request->detail;
        $requested_file = $request->file('file');
        if ($requested_file){
            $this->deleteImage($task,$request);
            $task->image_url = Storage::disk('s3')->url($this->uploadImage($task,$requested_file));
        }
        $task->save();
        return $task->id;
}

    public function uploadImage(Task $task,$requested_file) 
    {   
        if ($requested_file){
            $extentions_list = [ "jpg","jpeg","gif","png" ];
            if(in_array($requested_file->extension(),$extentions_list)){
                $image_url = (string)$task->id.'.'.$requested_file->extension();
            } else {
                throw new Exception('.jpg .png .gifの画像のみアップロード可能です　アップロードファイルの拡張子: '.$requested_file->extension());
            }
            $path = Storage::disk('s3')->put($image_url, $requested_file);
            if (empty($path)) {
                throw new Exception('ファイルのアップロードに失敗しました');
            }
        }
        return $path;
    }
    

    
    public function deleteImage(Task $task, EditTask $request)
    {
        $result = true ;
        if ($request->has('file') && Storage::disk('s3')->exists($task->image_url)) {
            $image_file = preg_replace ('/([^/]+?)?$/','{1}',$task->image_url);
            $result = Storage::disk('s3')->delete($image_file);
            if ($result) {
                throw new Exception('ファイルの削除に失敗しました');
            }
        }
        return $result;
    }
}
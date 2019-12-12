@extends('layout')

@section('styles')
  @include('share.flatpickr.styles')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">タスクの情報</div>
          <div class="panel-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
              <div class="form-group">
                <label for="title">タイトル</label>
                <p>{{  $task->title }}</p>
              </div>
              <div class="form-group">
                <label for="status">状態</label>
                <p>
                {{ $task->status_label }}</p>
              </div>
              <div class="form-group">
                <label for="due_date">期限</label>
                <p>
                {{ $task->formatted_due_date  }}</p>
              </div>
              <div class="form-group">
                <label for="due_date">画像</label>
                <p>
                <!-- ここに添付画像を配置 --></p>
              </div>
              <!-- 情報シェアボタンを配置 -->
              
              <div class="form-group">
                <label for="share_url"">URL</label>
                <input type="text" class="form-control" name="share_url" id="share_url"
                      value="{{request()->fullUrl()}}" />
              </div>
                <div class="row">
                  <div class="col-xs-8 text-left">
                  <a href="http://twitter.com/share?text=タスク「{{$task->title}}」の期限は{{ $task->formatted_due_date  }}まで！&url={{request()->fullUrl()}}" rel="nofollow" class="btn btn-twitter btn-sm"><i class="fab fa-twitter"></i> Twitter</a>
                  <a href="http://www.facebook.com/share.php?u={{request()->fullUrl()}}" class="btn btn-facebook btn-sm"><i class="fab fa-facebook"></i> Facebook</a>
                  </div>
                  <div class="col-xs-4 text-right">
                  @if(Auth::check())
                  <a href="{{ route('tasks.edit', ['id' => $task->folder_id, 'task_id' => $task->id]) }}" class="btn btn-primary btn-sm ">編集</a>
                  @endif
                  <a href="#"  onclick="javascript:window.history.back(-1);return false;" class="btn btn-primary btn-sm ">戻る</a>
                  </div>
                </div>
              </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @include('share.flatpickr.scripts')
@endsection
                  <div id="fb-root"></div>
                  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v5.0"></script>
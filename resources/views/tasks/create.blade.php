@extends('layout')

@section('styles')
  @include('share.flatpickr.styles')
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">タスクを追加する</div>
          <div class="panel-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="{{ route('tasks.create', ['id' => $folder_id]) }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" />
              </div>
              <div class="form-group">
                <label for="due_date">期限</label>
                <input type="text" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') }}" />
              </div>
              <div class="form-group">
                <label for="title">詳細</label>
                <input type="text" class="form-control" name="detail" id="detail" value="{{ old('detail') }}" />
              </div>
              <div class="form-group">
                <label for="file">添付画像</label>
                <input type="file" name="file"/>
                @if ( $task->image_exists )
                  <img border="0" src="{{Storage::disk('s3')->url((string)$task->id.".jpg")}}" alt="現在の画像">
                @else
                  画像なし
                @endif
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">送信</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
  @include('share.flatpickr.scripts')
@endsection
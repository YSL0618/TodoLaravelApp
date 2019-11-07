@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="column col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">プロフィール</div>

          <table class="table">
          <tbody>
            <tr>
              <td>
                名前
              </td>
              <td>
                {{ $name }}
              </td>
            </tr>

            <tr>
              <td>
                メール
              </td>
              <td>
                {{ $email }}
              </td>
            </tr>
          </tbody>
          </table>
          <div class="panel-body">
            <div class="text-right">
            <a href="{{ route('users.edit')}}" class="btn btn-default btn-block">
            名前を変更する
            </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
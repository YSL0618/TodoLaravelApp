@extends('layout')

@section('content')
  <div class="container text-center">
    <div class="row">
      <div class="column col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">プロフィール</div>
          <table class="table">
            <tbody>
              <tr>
                <td class="col-xs-4">
                  名前
                </td>
                <td class="col-xs-8">
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
          <div class="panel-footer">
            <a href="{{ route('users.edit') }}" class="btn btn-default">
            名前を変更する
            </a>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
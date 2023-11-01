@extends('adminlte::page')

@section('title', 'アカウント一覧')

@section('content_header')
    <h1>アカウント一覧</h1>
@stop

@section('content')

<!-- 検索フォームエリア -->
<form method="GET" action="{{ url('users') }}" class="mt-3">
    <input type="search" placeholder="社員番号/氏名" class="sesrch-input input-size"  name="search" value="{{request('search')}}">
    <button type="submit" class="btn btn-secondary mb-2 btn-sm search-btn">検索</button> 
        <!--検索クリアボタン -->
    <a href="{{ url('users') }}" class="btn btn-secondary mb-2 btn-sm search-clear-btn ">検索クリア</a>
</form>

<!-- フラッシュメッセージ -->
@if (session('flash_message'))
    <div class="alert alert-secondary alert-dismissible fade show mt-3 alert-size" role="alert" >
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {!! session('flash_message') !!}
    </div>
@endif

    
<!-- ユーザー一覧表示エリア -->
<div class="card-body table-responsive p-0 mt-3 user-index-form" >
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>行No,</th>
                    <th>スタッフNo,</th>
                    <th>氏名</th>
                    <th>メールアドレス</th>
                    <th>アカウント権限</th>
                    <th>　　　</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user) <!-- $indexを使用して行番号を生成 -->
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td> <!-- 行番号を表示 -->
                        <td>{{ $user->staff_number }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $roles[$user->role] }}</td>
                        <td class="align-middle"><a href="/users/edit/{{ $user->id }}" class="btn btn-secondary btn-sm mx-1 edit-btn">編集</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
    <!-- ページネーション -->
        <div class="pagination justify-content-center">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>

                          
@stop

@section('css')
    <!-- style -->
    @include('layouts.styles')
@stop

@section('js')
<script>
$(function(){
    $('div.alert').fadeIn('slow', function() {
        $(this).delay(10000).fadeOut('slow');
    });
});
</script>

@stop

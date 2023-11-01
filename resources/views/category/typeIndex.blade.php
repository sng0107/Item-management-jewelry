@extends('adminlte::page')

@section('title', '【カテゴリー】アイテム一覧')

@section('content_header')
    <h1>【カテゴリー】アイテム一覧</h1>
@stop

@section('content')

<div class="new-content-cards">
    <!-- アイテム登録画面への遷移ボタン -->
    <div class="text-right new-add-btn">
        <a href="{{ url('categories/type/add') }}" class="btn btn-secondary mb-2 btn-sm back-btn ">【NEW】アイテム登録</a>
    </div>
</div>
<!-- 検索フォームエリア -->
<form method="GET" action="{{ url('categories/type') }}" class="mt-3">
    @csrf
    <input type="search" placeholder="アイテムコード/アイテム名" class="sesrch-input input-size"  name="search" value="{{request('search')}}">
    <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn">検索</button> 
        <!--検索クリアボタン -->
        <a href="{{ url('categories/type') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn">検索クリア</a>
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
    
<!-- 一覧表示エリア -->
<div class="card-body table-responsive mt-3 type-index-form" >
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>行No,</th>
                <th>コード</th>
                <th>アイテム名</th>
                <th>　　　</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type) 
                <tr>
                    <!-- 行番号を表示 -->
                    <td>{{ ($types->currentPage() - 1) * $types->perPage() + $loop->iteration }}</td> 
                    <td>{{ $type->type_code }}</td>
                    <td>{{ $type->type_name }}</td>
                    <!-- 編集ボタンエリア -->
                    <td class="align-middle"><a href="/categories/type/edit/{{ $type->id }}" class="btn btn-secondary btn-sm mx-1 edit-btn">編集</a></td>
            @endforeach
        </tbody>
    </table>
</div>

<!-- ページネーション -->
    <div class="pagination justify-content-center mt-3">
        {{ $types->links('pagination::bootstrap-4') }}
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

@extends('adminlte::page')

@section('title', '【カテゴリー】アトリエ一覧')

@section('content_header')
    <h1>【カテゴリー】仕入先一覧</h1>
@stop

@section('content')

<div class="new-content-cards">
    <!-- 仕入先登録画面への遷移ボタン -->
    <div class="text-right new-add-btn">
        <a href="{{ url('categories/supplier/add') }}" class="btn btn-secondary mb-2 btn-sm back-btn ">【NEW】仕入先登録</a>
    </div>
</div>    
<!-- 検索フォームエリア -->
<form method="GET" action="{{ url('categories/supplier') }}" class="mt-3">
    @csrf
    <input type="search" placeholder="仕入先コード/仕入先名" class="sesrch-input input-size"  name="search" value="{{request('search')}}">
    <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn">検索</button> 
        <!--検索クリアボタン -->
        <a href="{{ url('categories/supplier') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn">検索クリア</a>
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
<div class="card-body table-responsive supplier-index-form mt-3" style="width:80%;">
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>行No,</th>
                <th>コード</th>
                <th>仕入先名</th>
                <th>　　　</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <!-- 行番号を表示 -->
                    <td>{{ ($suppliers->currentPage() - 1) * $suppliers->perPage() + $loop->iteration }}</td> 
                    <td>{{ $supplier->supplier_code }}</td>
                    <td>{{ $supplier->supplier_name }}</td>
                    
                    <!-- 編集ボタンエリア -->
                    <td class="align-middle"><a href="/categories/supplier/edit/{{ $supplier->id }}" class="btn btn-secondary btn-sm mx-1 edit-btn">編集</a></td>
            @endforeach
        </tbody>
    </table>
</div>

<!-- ページネーション -->
    <div class="pagination justify-content-center mt-3">
        {{ $suppliers->links('pagination::bootstrap-4') }}
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

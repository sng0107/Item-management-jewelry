@extends('adminlte::page')

@section('title', '販売登録')

@section('content_header')
    <h1>販売登録</h1>
@stop

@section('content')
<div class="content-body sales-item-search" >
    <!-- 検索フォームエリア -->
    <form method="GET" action="{{ url('sales/add') }}" class="mt-3">
        @csrf
        <input type="search" placeholder="商品コード/商品名" class="sesrch-input input-size"   name="search" value="{{request('search')}}">
        <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn">検索</button> 
            <!--検索クリアボタン -->
            <a href="{{ url('sales/search') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn">検索クリア</a>
    </form>
</div>  

@stop

@section('css')
    <!-- style -->
    @include('layouts.styles')
@stop

@section('js')
@stop

@extends('adminlte::page')

@section('title', '販売ランキング')

@section('content_header')
    <h1>販売ランキング</h1>
@stop

@section('content')
<div class="new-content-cards me-1">
    <!-- 販売履歴画面への遷移ボタン -->
    <div class="text-right new-add-btn">
    <a href="{{url()->previous()}}" class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
    </div>
</div> 

<!-- 検索フォームエリア -->
<div class="content-body" >
    <form method="GET" action="{{ url('sales/rank') }}" class="mt-3">
        @csrf
        <input type="search" placeholder="商品コード/商品名" class="sesrch-input input-size"  name="search" value="{{request('search')}}">
        <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn">検索</button> 
            <!--検索クリアボタン -->
            <a href="{{ url('sales/rank') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn">検索クリア</a>
    </form>
</div>  
 

<!-- 品番数表示エリア -->
<div class="itemCount">
    <p>ランキングの品番数は全部で{{$itemCount}}品番です</p>
</div>

<!-- フラッシュメッセージ -->
@if (session('flash_message'))
    <div class="alert alert-secondary  alert-dismissible fade show mt-3 alert-size" role="alert" >
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {!! session('flash_message') !!}
    </div>
@endif

    <!-- 商品一覧表示エリア -->
    <div class="card-body table-responsive p-0 mt-3" style="width:100%;" >
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th class="index-title ">順位<br>　</th>
                    <th>商品コード<br>　</th>
                    <th>商品名<br>　</th>
                    <th>販売単価<br>(税込)</th>
                    <th>販売数<br>　</th>
                    <th>在庫数<br>　</th>
                </tr>
            </thead>
    
            <tbody>
                @foreach ($totalSales as $key => $sale) 
                    <tr>
                        <!-- 順位を表示 -->
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $sale->item->item_code }}</td>
                        <td>{{ $sale->item->item_name }}</td>
                        <td class="">{{ number_format($sale->item->retail_price) }}</td>
                        <td class="">{{ number_format($sale->total_sales) }}</td>
                        <td>{{ $sale->item->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
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

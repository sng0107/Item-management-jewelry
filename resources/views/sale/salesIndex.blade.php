@extends('adminlte::page')

@section('title', '販売履歴')

@section('content_header')
    <h1>販売履歴</h1>
@stop

@section('content')
<div class="new-content-cards">
    <div class="new-content-card me-1">
        <!-- 販売登録画面への遷移ボタン -->
        <div class="text-right new-add-btn">
            <a href="{{ url('sales/search') }}" class="btn btn-secondary btn-sm">【NEW】販売登録</a>
        </div>
    </div>   
    <div class="new-content-card ma-1">
    <!-- 販売登録画面への遷移ボタン -->
        <div class="text-right new-add-btn">
        <a href="{{ url('sales/rank') }}" class="btn btn-secondary btn-sm">ランキング</a>
        </div>
    </div>
</div>

<!-- 検索フォームエリア -->
<div class="content-body" >
    <form method="GET" action="{{ url('sales') }}" class="mt-3">
        @csrf
        <input type="search" placeholder="商品コード/商品名/販売日/お客様名" class="sesrch-input input-size"  name="search" value="{{request('search')}}">
        <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn">検索</button> 
            <!--検索クリアボタン -->
            <a href="{{ url('sales') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn">検索クリア</a>
    </form>

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
                    <th class="index-title ">行No,<br>　</th>
                    <th hidden>販売No,<br>　</th>
                    <th hidden>登録処理日<br>　</th>
                    <th>販売日<br>　</th>
                    <th>商品コード<br>　</th>
                    <th>商品名<br>　</th>
                    <th>販売単価<br>(税込)</th>
                    <th>販売数<br>　</th>
                    <th>お客様名<br>　</th>
                    <th hidden>備考<br>　</th>
                    <th>　　　</th>
                    <th>　　　</th>

                </tr>
            </thead>
    
            <tbody>
                @foreach ($sales as  $sale) 
                    <tr>
                        <!-- 行番号を表示 -->
                        <td>{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}</td> 
                        <td hidden>{{ $sale->created_at ->format('Y-m-d') }}</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>{{ $sale->item->item_code }}</td>
                        <td>{{ $sale->item->item_name }}</td>
                        <td class="">{{ number_format($sale->sale_price) }}</td>
                        <td class="">{{ number_format($sale->sale_quantity) }}</td>
                        <td>{{ $sale->customer }}</td>
                        <td hidden class="text-truncate" style="max-width:6.5rem;">{!! nl2br(e($sale->comment)) !!}</td>
                        <!-- コスト詳細表示ボタン -->
                        <td class="align-middle"><a href="/sales/detail/{{ $sale->id }}" class="btn btn-secondary btn-sm edit-btn">詳細</a></td>
                        <!-- 編集ボタン -->
                        <td class="align-middle"><a href="/sales/edit/{{ $sale->id }}" class="btn btn-secondary btn-sm edit-btn">編集</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- ページネーション -->
    <div class="pagination justify-content-center mt-3 pagination-sm">
        {{ $sales->links('pagination::bootstrap-4') }}
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

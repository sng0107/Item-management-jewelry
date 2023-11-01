@extends('adminlte::page')

@section('title', 'コスト一覧')

@section('content_header')
    <h1>コスト一覧</h1>
@stop

@section('content')

<!-- 検索フォームエリア -->
<form method="GET" action="{{ url('costs') }}" class="mt-3">
@csrf
    <input type="search" placeholder="商品コード/商品名" class="sesrch-input input-size"  name="search" value="{{request('search')}}">
    <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn ">検索</button> 

    <!--検索クリアボタン -->
    <a href="{{ url('costs') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn me-5 ">検索クリア</a>

    <!--原価率が高い順に並び変えるボタン -->
    <a href="{{ url('costs/ratedesc') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn ms-1 ">原価率<br>(高い順)</a>
    <a href="{{ url('costs') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn ms-1 ">原価率<br>(クリア)</a>

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
<div class="card-body table-responsive mt-3" >
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>行No,<br>　</th>
                <th>商品コード<br>　</th>
                <th>商品名<br>　</th>
                <th>地金<br>　</th>
                <th>チェーン<br>　</th>
                <th>パーツ<br>　</th>
                <th>石材<br>　</th>
                <th>加工<br>　</th>
                <th>その他<br>　</th>
                <th>【合計】<br>　</th>
                <th>【原価率】<br>　(%)</th>
                <th>仕入先<br>　</th>
                <th>　　　</th>
                <th>　　　</th>
                <th>　　　</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($costs as  $cost) 
                <tr>
                    <td>{{ ($costs->currentPage() - 1) * $costs->perPage() + $loop->iteration }}</td> <!-- 行番号を表示 -->
                    <td>{{ $cost->item->item_code  }}</td>
                    <td>{{ $cost->item->item_name }}</td>
                    <td >{{ number_format($cost->metal_cost) }}</td>
                    <td >{{ number_format($cost->chain_cost) }}</td>
                    <td >{{ number_format($cost->parts_cost) }}</td>
                    <td >{{ number_format($cost->stone_cost) }}</td>
                    <td >{{ number_format($cost->processing_cost) }}</td>
                    <td >{{ number_format($cost->other_cost) }}</td>
                    <td >{{ number_format($cost->total_cost) }}</td>
                    <td >{{ $cost->cost_rate }}</td> 
                    <td >{{ $cost->item->supplier->supplier_name }}</td>
                    
                    
                    <!-- 詳細ボタン -->
                    <td class="align-middle "><a href="/costs/detail/{{ $cost->id }}" class="btn btn-secondary btn-sm me-1 detail-btn">詳細</a></td>
                    <!-- 編集ボタン -->
                    <td class="align-middle"><a href="/costs/edit/{{ $cost->id }}" class="btn btn-secondary btn-sm edit-btn">編集</a></td>
                    <!-- 商品詳細へのリンクボタン -->
                    <td class="align-middle "><a href="/items/detail/{{ $cost->id }}" class="btn btn-success btn-sm me-1 detail-btn">商品</a></td>

            @endforeach
        </tbody>
    </table>
</div>

<!-- ページネーション -->
    <div class="pagination justify-content-center mt-3 pagination-sm" >
        {{ $costs->links('pagination::bootstrap-4') }}
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

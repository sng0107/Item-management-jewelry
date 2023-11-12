@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
<div class="new-content-cards">
    <!-- 商品登録画面への遷移ボタン -->
    @can('管理者')
        <div class="text-right new-add-btn">
            <a href="{{ url('items/add') }}" class="btn btn-secondary btn-sm">【NEW】商品登録</a>
        </div>
    @endcan
    
</div>
<div class="content-body" >
    <!-- 検索フォームエリア -->
    <form method="GET" action="{{ url('items') }}" class="mt-3">
        @csrf
        <input type="search" placeholder="商品コード/商品名" class="sesrch-input input-size"   name="search" value="{{request('search')}}">
        <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn">検索</button> 
            <!--検索クリアボタン -->
            <a href="{{ url('items') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn">検索クリア</a>
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
        
    <!-- 商品一覧表示エリア -->
    <div class="card-body table-responsive p-0 mt-3" style="width:100%;" >
        <table class="table table-hover text-nowrap ">
            <thead>
                <tr >
                    <th class="index-title ">行No,<br>　</th>
                    <th>商品コード<br>　</th>
                    <th>商品名<br>　</th>
                    <th>商品画像<br>　</th>
                    <th >アイテム<br>　</th>
                    <th>販売単価<br>(税込)</th>
                    <th>在庫数<br>　</th>
                    <th>素材<br>　</th>
                    <th>仕様<br>　</th>
                    <th hidden>販売期間<br>　</th>
                    <th>　　　</th>
                    <th>　　　</th>
                    <th>　　　</th>
                </tr>
            </thead>
            <tbody  >
                @foreach ($items as  $item) 
                    <tr >
                        <!-- 行番号を表示 -->
                        <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td> 
                        <td>{{ $item->item_code }}</td>
                        <td class="text-truncate" style="max-width:8rem;">{{ $item->item_name }}</td>
                        <!-- 画像表示エリア -->
                        <td>
                        @if ($item->img)
                            <div class="aspect-ratio-block">
                                <img src="data:image/*;base64,{{ $item->img }}" alt="{{ $item->item_name }}" class="img-thumbnail " style="width:3rem; height:3rem;">
                            </div>                        
                            @else
                            画像なし
                        @endif
                        </td>
                        <!-- アイテム名をコードから名前に変換して表示 -->
                        <td >
                            @if ( $item->type_id)
                                    {{ $item->type->type_name }}
                                @endif
                        </td>
                        <td class="index-price">{{ number_format($item->retail_price) }}</td>
                        <td class="index-price">{{ number_format($item->stock) }}</td>
                        <td class="text-truncate" style="max-width:5rem;">{{ $item->material }}</td>
                        <td class="text-truncate" style="max-width:6rem;">{!! nl2br(e($item->spec)) !!}</td>
                        <td hidden>{{ $item->sales_period }}</td>
                        <!-- 詳細ボタン -->
                        <td class="align-middle"><a href="/items/detail/{{ $item->id }}" class="btn btn-secondary btn-sm  detail-btn">詳細</a></td>
                        @can('管理者')
                        <!-- 編集ボタン -->
                        <td class="align-middle"><a href="/items/edit/{{ $item->id }}" class="btn btn-secondary btn-sm edit-btn">編集</a></td>
                        <!-- コスト詳細表示ボタン -->
                        <td class="align-middle"><a href="/costs/detail/{{ $item->cost->id }}" class="btn btn-success btn-sm edit-btn">コスト</a></td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- ページネーション -->
    <div class="pagination justify-content-center mt-3 pagination-sm">
        {{ $items->links('pagination::bootstrap-4') }}
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

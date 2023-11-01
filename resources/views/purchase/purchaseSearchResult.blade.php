@extends('adminlte::page')

@section('title', '仕入登録')

@section('content_header')
    <h1>仕入登録</h1>
@stop

@section('content')

<div class="content-body sales-item-search" >
    <!-- 検索フォームエリア -->
    <form method="GET" action="{{ url('purchases/add') }}" class="mt-3">
        @csrf
        <input type="search" placeholder="商品コード or 商品名を入力" class="sesrch-input input-size" name="search" value="{{request('search')}}">
        <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn">検索</button> 
            <!--検索クリアボタン -->
            <a href="{{ url('purchases/search') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn">検索クリア</a>
    </form>
</div>  

<!-- 検索結果表示エリア -->
<div class="card-body table-responsive p-0 mt-3 sales-item-search"  >
    @if(isset($items))
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th class="index-title ">行No,<br>　</th>
                    <th>商品コード<br>　</th>
                    <th>商品名<br>　</th>
                    <th>商品画像<br>　</th>
                    <th >アイテム<br>　</th>
                    <th>販売単価<br>(税込)</th>
                    <th>在庫数<br>　</th>
                    <th>　　　</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as  $item) 
                    <tr>
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
                            @if ( $item->type_id )
                                {{ $item->type->type_name }}
                            @endif
                        </td>
                        <td class="sales-result-price">{{ number_format($item->retail_price) }}</td>
                        <td class="sales-result-price">{{ number_format($item->stock) }}</td>

                        <!-- 販売登録画面への遷移ボタン -->
                        <td class="align-middle"><a href="/purchases/count/{{ $item->id }}" class="btn btn-secondary btn-sm me-1 detail-btn">仕入登録</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    <!-- ページネーション -->
    <div class="pagination justify-content-center mt-3 pagination-sm">
        {{ $items->links('pagination::bootstrap-4') }}
    </div>
    @else
        <p class="search-result">検索結果がありません。</p>
    @endif
 </div>
   

@stop

@section('css')
    <!-- style -->
    @include('layouts.styles')
@stop

@section('js')
@stop

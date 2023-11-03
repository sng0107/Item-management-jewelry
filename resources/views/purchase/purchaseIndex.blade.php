@extends('adminlte::page')

@section('title', '仕入履歴')

@section('content_header')
    <h1>仕入履歴</h1>
@stop
@section('content')
<div class="new-content-cards">
    <!-- 仕入登録画面への遷移ボタン -->
    <div class="text-right new-add-btn">
        <a href="{{ url('purchases/search') }}" class="btn btn-secondary btn-sm">【NEW】仕入登録</a>
    </div>
</div>
<!-- 検索フォームエリア -->
<div class="content-body" >
    <form method="GET" action="{{ url('purchases') }}" class="mt-3">
        @csrf
        <input type="search" placeholder="商品コード/商品名/納品書日付" class="sesrch-input input-size"  name="search" value="{{request('search')}}">
        <button type="submit" class="btn btn-secondary btn-sm mb-2 search-btn">検索</button> 
            <!--検索クリアボタン -->
            <a href="{{ url('purchases') }}" class="btn btn-secondary btn-sm mb-2 search-clear-btn">検索クリア</a>
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
                    <th hidden>仕入No,<br>　</th>
                    <th>更新日<br>　</th>
                    <th>納品書日付<br>　</th>
                    <th>商品コード<br>　</th>
                    <th>商品名<br>　</th>
                    <th>仕入単価<br>(税込)</th>
                    <th>仕入数<br>　</th>
                    <th>仕入先<br>　</th>
                    <th hidden>備考<br>　</th>
                    <th>　　　</th>
                    <th>　　　</th>

                </tr>
            </thead>
    
            <tbody>
                @foreach ($purchases as  $purchase) 
                    <tr>
                        <!-- 行番号を表示 -->
                        <td>{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td> 
                        <td hidden>{{ $purchase->id }}</td>
                        <td>{{ $purchase->updated_at->format('Y-m-d') }}</td>
                        <td>{{ $purchase->purchase_date }}</td>
                        <td>{{ $purchase->item->item_code }}</td>
                        <td>{{ $purchase->item->item_name }}</td>
                        <td class="">{{ number_format($purchase->purchase_price) }}</td>
                        <td class="">{{ number_format($purchase->purchase_quantity) }}</td>
                        <!-- 仕入先名をコードから名前に変換して表示 -->
                        <td >
                            @if ( $purchase->item->supplier_id )
                                {{ $purchase->item->supplier->supplier_name }}
                            @endif
                        </td>
                        <td hidden class="text-truncate" style="max-width:6.5rem;">{!! nl2br(e($purchase->comment)) !!}</td>
                        <!-- コスト詳細表示ボタン -->
                        <td class="align-middle"><a href="/purchases/detail/{{ $purchase->id }}" class="btn btn-secondary btn-sm edit-btn">詳細</a></td>
                        <!-- 編集ボタン -->
                        <td class="align-middle"><a href="/purchases/edit/{{ $purchase->id }}" class="btn btn-secondary btn-sm edit-btn">編集</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- ページネーション -->
    <div class="pagination justify-content-center mt-3 pagination-sm">
        {{ $purchases->links('pagination::bootstrap-4') }}
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

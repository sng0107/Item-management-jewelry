@extends('adminlte::page')

@section('title', '仕入実績詳細')

@section('content_header')
    <h1>仕入実績詳細</h1>
@stop

@section('content')

<!-- 検索に戻るボタン -->
<div class="text-right">
    <a href="{{url()->previous()}}" class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- 詳細表示エリア -->
<div class="card card-primary type-add-form">
    @csrf
    <div class="card-body" >
        <div class="purchase-cards">
            <div class="purchase-card me-1">
                <div class="form-group" >
                    <label for="purchase_date" class="mb-0">納品書日付</label>
                    <input readonly type="text" class="form-control input-size" id="purchase_date" name="purchase_date"  value="{{ $purchase->purchase_date }}">
                </div>
            </div>                    
            <div class="purchase-card ms-1">
                <div class="form-group" >
                    <label for="updated_at" class="mb-0">更新日</label>
                    <input readonly type="text" class="form-control input-size" id="updated_at" name="updated_at"  value="{{ $purchase->updated_at->format('Y-m-d') }}">
                </div>
            </div>            
        </div>
            <div class="form-group" >
                <label for="purchase_id" class="mb-0 ">仕入No,</label>
                <input readonly type="text" class="form-control input-size" id="purchase_id" name="purchase_id" value="{{ $purchase->id }}">
            </div>  

            <div class="form-group" >
                <label for="item_code" class="mb-0 ">商品コード</label>
                <input readonly type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ $purchase->item->item_code }}">
            </div>  

            <div class="form-group" >
                <label for="item_name" class="mb-0 ">商品名</label>
                <input readonly type="text" class="form-control input-size " id="item_name" name="item_name" value="{{ $purchase->item->item_name }}">
            </div>

            <div class="form-group" >
                <label for="purchase_price" class="mb-0">仕入単価</label>
                <input readonly type="text" class="form-control input-size" id="purchase_price" name="purchase_price" value="{{ number_format($purchase->purchase_price) }}">
            </div>

            <div class="form-group" >
                <label for="purchase_quantity" class="mb-0">仕入数</label>
                <input readonly type="text" class="form-control input-size" id="purchase_quantity" name="purchase_quantity"  value="{{ $purchase->purchase_quantity }}">
            </div>

            <div class="form-group" >
                <label for="supplier" class="mb-0">仕入先</label>
                    @if ($purchase->item->supplier_id)
                        <input readonly type="text" class="form-control input-size" id="type" name="supplier" value="{{ $purchase->item->supplier->supplier_name }}">
                    @endif
            </div>
                    
            <div class="form-group">
                <label for="comment" class="mb-0">備考</label>
                <textarea rows="3" readonly style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ $purchase->comment }}</textarea>
            </div>
    </div>
    <div class="card-footer ">
        <!-- 複製ボタン -->
        <form method="GET" action="/purchases/clone/{{$purchase->id}}" >
            @csrf
            <button type="submit" class="btn btn-warning ms-3 btn-sm delete-btn" >複製</button>
        </form>
    </div>
</div>

@stop

@section('css')
    <!-- style -->
    @include('layouts.styles')
@stop

@section('js')
@stop

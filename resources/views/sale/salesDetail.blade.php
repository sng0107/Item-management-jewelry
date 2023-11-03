@extends('adminlte::page')

@section('title', '販売実績詳細')

@section('content_header')
    <h1>販売実績詳細</h1>
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
        <div class="sales-cards">
            <div class="sales-card me-1">
                <div class="form-group" >
                    <label for="sale_date" class="mb-0">販売日</label>
                    <input readonly type="text" class="form-control input-size" id="sale_date" name="sale_date"  value="{{ $sale->sale_date }}">
                </div>
            </div>    
            <div class="sales-card ms-1">
                <div class="form-group" >
                    <label for="updated_at" class="mb-0">更新日</label>
                    <input readonly type="text" class="form-control input-size" id="update_at" name="updated_at"  value="{{ $sale->updated_at -> format('Y-m-d')}}">
                </div>
            </div>            
        </div>

        <div class="form-group" >
            <label for="sale_id" class="mb-0 ">販売No,</label>
            <input readonly type="text" class="form-control input-size" id="sale_id" name="sale_id" value="{{ $sale->id }}">
        </div>  

        <div class="form-group" >
            <label for="item_code" class="mb-0 ">商品コード</label>
            <input readonly type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ $sale->item->item_code }}">
        </div>  

        <div class="form-group" >
            <label for="item_name" class="mb-0 ">商品名</label>
            <input readonly type="text" class="form-control input-size " id="item_name" name="item_name" value="{{ $sale->item->item_name }}">
        </div>

        <div class="form-group" >
            <label for="sale_price" class="mb-0">販売単価</label>
            <input readonly type="text" class="form-control input-size" id="sale_price" name="sale_price" value="{{ number_format($sale->sale_price) }}">
        </div>


        <div class="form-group" >
            <label for="sale_quantity" class="mb-0">販売数</label>
            <input readonly type="text" class="form-control input-size" id="sale_quantity" name="sale_quantity"  value="{{ $sale->sale_quantity }}">
        </div>

        <div class="form-group" >
            <label for="customer" class="mb-0">お客様名</label>
            <input readonly type="text" class="form-control input-size" id="customer" name="customer"  value="{{ $sale->customer }}">
        </div>
                
        <div class="form-group">
            <label for="comment" class="mb-0">備考</label>
            <textarea readonly rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ $sale->comment }}</textarea>
        </div>
    </div>
    
    <div class="card-footer ">
        <!-- 複製ボタン -->
        <form method="GET" action="/sales/clone/{{$sale->id}}" >
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

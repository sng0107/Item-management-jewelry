@extends('adminlte::page')

@section('title', '販売編集')

@section('content_header')
    <h1>販売実績編集</h1>
@stop

@section('content')

<!-- 検索に戻るボタン -->
<div class="text-right">
    <a href="{{url()->previous()}}" class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- 入力フォームエリア -->
<div class="card card-primary type-add-form">
    <form method="POST" action="/sales/edit/{{$sale->id}}" >
        @csrf
        <div class="card-body" >
            <div class="sales-cards mb-0">
                <div class="sales-card me-1">
                    <div class="form-group" >
                        <label for="sale_date" class="mb-0">販売日</label>
                            <input type="date" class="form-control input-size" id="sale_date" name="sale_date"  value="{{ $sale->sale_date }}">
                                @error('sale_date')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>    
                <div class="sales-card ms-1">
                    <div class="form-group" >
                        <label for="updated_at" class="mb-0">更新日<span class="text-primary">　※自動更新</span></label>
                            <input readonly type="text" class="form-control input-size" id="update_at" name="updated_at"  value="{{ $sale->updated_at -> format('Y-m-d')}}">
                    </div>
                </div>            
            </div>
            <div class="form-group" >
                <label for="sale_id" class="mb-0 ">販売No,</label>
                    <input readonly type="text" class="form-control input-size" id="sale_id" name="sale_id" value="{{ $sale->id }}">
                        @error('item_code')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>  
            <div class="form-group" >
                <label for="item_code" class="mb-0 ">商品コード</label>
                    <input readonly type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ $sale->item->item_code }}">
                        @error('item_code')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>  
            <div class="form-group" >
                <label for="item_name" class="mb-0 ">商品名</label>
                <input readonly type="text" class="form-control input-size " id="item_name" name="item_name" value="{{ $sale->item->item_name }}">
                @error('item_name')
                    <div class="text-danger error-font-size">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group" >
                <label for="sale_price" class="mb-0">販売単価<span class="text-primary">　※実際の販売単価を入力してください。</span></label>
                    <input type="text" class="form-control input-size" id="sale_price" name="sale_price" value="{{ $sale->sale_price }}">
                        @error('sale_price')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>
            <div class="form-group" >
                <label for="sale_quantity" class="mb-0">販売数</label>
                    <input type="text" class="form-control input-size" id="sale_quantity" name="sale_quantity"  value="{{ $sale->sale_quantity }}">
                        @error('sale_quantity')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>
            <div class="form-group" >
                <label for="customer" class="mb-0">お客様名</label>
                    <input type="text" class="form-control input-size" id="customer" name="customer"  value="{{ $sale->customer }}">
                        @error('customer')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>
            <div class="form-group">
                <label for="comment" class="mb-0">備考</label>
                    <textarea rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ $sale->comment }}</textarea>
                        @error('comment')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>
        </div>
        <div class="card-footer ">
            <!-- 更新ボタン -->
            <button  type="submit" class="btn btn-secondary mr-2 btn-sm update-btn" >更新</button>                    
    </form>
            <!-- 削除ボタン -->
            <form method="POST" action="/sales/delete/{{$sale->id}}" onSubmit="return submitCheck()">
                @csrf
                <button type="submit" class="btn btn-danger ml-2 btn-sm delete-btn" >削除</button>
            </form>
        </div>    
</div>
@stop

@section('css')
    <!-- style -->
    @include('layouts.styles')
@stop

@section('js')
<script>
    // 削除ボタンが押下されたら確認メッセージを表示
    function submitCheck(){
        if(!window.confirm('削除ボタンが押されました。本当に削除しますか？')) {
            return false;
        }
    }
</script> 
@stop

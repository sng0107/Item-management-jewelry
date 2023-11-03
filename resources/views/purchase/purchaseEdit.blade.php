@extends('adminlte::page')

@section('title', '仕入編集')

@section('content_header')
    <h1>仕入編集</h1>
@stop

@section('content')

<!-- 検索に戻るボタン -->
<div class="text-right">
    <a href="{{url()->previous()}}" class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- 編集フォームエリア -->
<div class="card card-primary type-add-form">
    <form method="POST" action="/purchases/edit/{{$purchase->id}}" >
        @csrf
        <div class="card-body" >
            <div class="sales-cards">
                <div class="sales-card me-1">
                    <div class="form-group" >
                        <label for="purchase_date" class="mb-0">納品書日付</label>
                        <input type="date" class="form-control input-size" id="purchase_date" name="purchase_date"  value="{{ $purchase->purchase_date }}">
                        @error('purchase_date')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>    
                <div class="sales-card ms-1">
                    <div class="form-group" >
                        <label for="created_at" class="mb-0">更新日<span class="text-primary">　※自動更新</span></label>
                        <input readonly type="text" class="form-control input-size" id="created_at" name="created_at"  value="{{ $purchase->created_at->format('Y-m-d') }}">
                        @error('created_at')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>           
            </div>

            <div class="form-group" >
                <label for="purchase_id" class="mb-0 ">仕入No,</label>
                <input readonly type="text" class="form-control input-size" id="purchase_id" name="purchase_id" value="{{ $purchase->id }}">
                @error('item_code')
                    <div class="text-danger error-font-size">{{ $message }}</div>
                @enderror
            </div>  

            <div class="form-group" >
                <label for="item_code" class="mb-0 ">商品コード</label>
                <input readonly type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ $purchase->item->item_code }}">
                @error('item_code')
                    <div class="text-danger error-font-size">{{ $message }}</div>
                @enderror
            </div>  

            <div class="form-group" >
                <label for="item_name" class="mb-0 ">商品名</label>
                <input readonly type="text" class="form-control input-size " id="item_name" name="item_name" value="{{ $purchase->item->item_name }}">
                @error('item_name')
                    <div class="text-danger error-font-size">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" >
                <label for="purchase_price" class="mb-0">仕入単価<span class="text-primary">　※実際の仕入単価を入力してください。</span></label>
                <input type="text" class="form-control input-size" id="purchase_price" name="purchase_price" value="{{ $purchase->purchase_price }}">
                @error('purchase_price')
                    <div class="text-danger error-font-size">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" >
                <label for="purchase_quantity" class="mb-0">仕入数</label>
                <input type="text" class="form-control input-size" id="purchase_quantity" name="purchase_quantity"  value="{{ $purchase->purchase_quantity }}">
                @error('purchase_quantity')
                <div class="text-danger error-font-size">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" >
                <label for="supplier_id" class="mb-0">仕入先</label>
                @if ($purchase->item->supplier_id)
                        <input readonly type="text" class="form-control input-size" id="type" name="supplier_id" value="{{ $purchase->item->supplier->supplier_name }}">
                    @endif
                @error('supplier_id')
                <div class="text-danger error-font-size">{{ $message }}</div>
                @enderror
            </div>
                    
            <div class="form-group">
                <label for="comment" class="mb-0">備考</label>
                <textarea rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ $purchase->comment }}</textarea>
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
            <form method="POST" action="/purchases/delete/{{$purchase->id}}" onSubmit="return submitCheck()">
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

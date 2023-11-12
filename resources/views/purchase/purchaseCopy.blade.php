@extends('adminlte::page')

@section('title', '仕入複製登録')

@section('content_header')
    <h1>仕入複製登録</h1>
@stop

@section('content')

<!-- 検索に戻るボタン -->
<div class="text-right">
    <a href="{{url('/purchases/search')}}" class="btn btn-secondary mb-2 btn-sm back-btn ">検索に戻る</a>
</div>

<!-- 入力フォームエリア -->
<div class="card card-primary type-add-form">
    <form method="POST" >
        @csrf
        <div class="card-body" >
            <div class="purchase-cards">
                <div class="purchase-card me-1">
                    <div class="form-group" >
                        <label for="purchase_date" class="mb-0">納品書日付<span class="text-danger">　(必須)</span></label>
                            <input type="date" class="form-control input-size" id="purchase_date" name="purchase_date"  value="{{ old('purchase_date',$purchase->purchase_date) }}">
                                @error('purchase_date')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>
                <div class="purchase-card ms-1">
                    <div class="form-group" >
                        <label for="updated_at" class="mb-0">更新日<span class="text-primary">　※自動更新</span></label>
                            <input readonly type="text" class="form-control input-size" id="updated_at" name="updated_at"  value="{{ old('updated_at',$purchase->updated_at) }}">
                                @error('updated_at')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>       
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
                        <input type="text" class="form-control input-size" id="purchase_price" name="purchase_price" value="{{ old('purchase_price',$purchase->purchase_price )}}">
                            @error('purchase_price')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                            @enderror
                </div>
                <div class="form-group" >
                    <label for="stock" class="mb-0">仕入前の在庫数</label>
                        <input readonly type="text" class="form-control input-size" id="stock" name="stock"  value="{{ $purchase->item->stock }}">
                </div>
                <div class="form-group" >
                    <label for="purchase_quantity" class="mb-0">仕入数<span class="text-danger">　(必須)</span></label>
                        <input type="text" class="form-control input-size" id="purchase_quantity" name="purchase_quantity"  value="{{ old('purchase_quantity',$purchase->purchase_quantity) }}">
                            @error('purchase_quantity')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                            @enderror
                </div>
                <!-- 仕入先名の編集エリア -->
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
                        <textarea rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ old('comment',$purchase->comment) }}</textarea>
                            @error('comment')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                            @enderror
                </div>
        </div>
                <!-- 登録ボタン -->
                <div class="card-footer mt-3">
                    <button type="submit" class="btn btn-secondary ml-2 btn-sm add-btn" >登録</button>
                </div>
    </form>
</div>

@stop

@section('css')
    <!-- style -->
    @include('layouts.styles')
@stop

@section('js')
@stop

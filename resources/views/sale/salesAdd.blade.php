@extends('adminlte::page')

@section('title', '販売登録')

@section('content_header')
    <h1>販売登録</h1>
@stop

@section('content')

<!-- 検索に戻るボタン -->
<div class="text-right">
    <a href="{{url('/sales/search')}}" class="btn btn-secondary mb-2 btn-sm back-btn ">検索に戻る</a>
</div>

<!-- 入力フォームエリア -->
<div class="card card-primary type-add-form">
    <form method="POST" >
        @csrf
            <div class="card-body" >
                <div class="sales-cards">
                    <div class="sales-card  me-1">
                        <div class="form-group" >
                            <label for="sale_date" class="mb-0">販売日( 例 2023/01/01 )<span class="text-danger">　(必須)</span></label>
                            <input type="text" class="form-control input-size" id="sale_date" name="sale_date"  value="{{ old('sale_date') }}">
                            @error('sale_date')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>    
                    <div class="sales-card ms-1">
                        <div class="form-group" >
                            <label for="updated_at" class="mb-0 ">更新日<span class="text-primary">　※自動更新</span></label>
                            <input readonly type="text" class="form-control input-size" id="updated_at" name="updated_at"  value="{{ old('updated_at') }}">
                            @error('updated_at')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>                
                </div>

                <div class="form-group" >
                    <label for="item_code" class="mb-0 ">商品コード</label>
                    <input readonly type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ $item->item_code }}">
                    @error('item_code')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
                </div>  

                <div class="form-group" >
                    <label for="item_name" class="mb-0 ">商品名</label>
                    <input readonly type="text" class="form-control input-size " id="item_name" name="item_name" value="{{ $item->item_name }}">
                    @error('item_name')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" >
                    <label for="sale_price" class="mb-0">販売単価<span class="text-primary">　※実際の販売単価を入力してください。</span></label>
                    <input type="text" class="form-control input-size" id="sale_price" name="sale_price" value="{{ $item->retail_price }}">
                    @error('sale_price')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" >
                    <label for="stock" class="mb-0">販売前の在庫数</label>
                    <input readonly type="text" class="form-control input-size" id="stock" name="stock"  value="{{ $item->stock }}">
                </div>

                <div class="form-group" >
                    <label for="sale_quantity" class="mb-0">販売数<span class="text-danger">　(必須)</span></label>
                    <input type="text" class="form-control input-size" id="sale_quantity" name="sale_quantity"  value="{{ old('sale_quantity') }}">
                    @error('sale_quantity')
                    <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" >
                    <label for="customer" class="mb-0">お客様名</label>
                    <input type="text" class="form-control input-size" id="customer" name="customer"  value="{{ old('customer') }}">
                    @error('customer')
                    <div class="text-danger error-font-size" >{{ $message }}</div>
                    @enderror
                </div>
                     
                <div class="form-group">
                    <label for="comment" class="mb-0">備考</label>
                    <textarea rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ old('comment') }}</textarea>
                    @error('comment')
                    <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
                </div>
        </div>
                <!-- 登録ボタン -->
                <div class="card-footer mt-1">
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

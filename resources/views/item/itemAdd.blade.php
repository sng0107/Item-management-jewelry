@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')

<!-- 一覧に戻るボタン -->
<div class="text-right" >
    <a href="{{url('items')}}" class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- 入力フォームエリア -->
<div class="card card-primary mb-2" >
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body" >
            <div class="content-cards">
                <div class="content-card" >
                    <div class="item_title_cards">
                        <div class="form-group" >
                            <label for="item_code" class="mb-0">商品コード<span class="text-danger">　(必須)</span></label>
                                <input type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ old('item_code') }}">
                                    @error('item_code')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                    @enderror
                        </div>
                        <div class="form-group" >
                            <label for="item_name" class="mb-0">商品名<span class="text-danger">　(必須)</span></label>
                                <input type="text" class="form-control input-size" id="item_name" name="item_name" value="{{ old('item_name') }}">
                                    @error('item_name')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                    @enderror
                        </div>
                    </div>
                    <!--  アイテムのセレクトボックス -->
                    <div class="form-group">
                        <label for="item_type" class="form-label">アイテム<span class="text-danger">　(必須)</span></label>
                            <select class="form-control input-size" id="item_type" name="item_type" >
                                <option > 選択してください </option>
                                    @foreach ($types as $type)
                                        <option value="{{$type->id }}">{{ $type->type_name }}</option>
                                    @endforeach
                            </select>
                                @error('type')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                    <div class="form-group">
                        <label for="retail_price" class="mb-0">販売単価(税込)<span class="text-danger">　(必須)</span></label>
                            <input type="text" class="form-control input-size" id="retail_price" name="retail_price" value="{{ old('retail_price','0') }}">
                                @error('retail_price')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                    <div class="form-group" hidden>
                        <label for="stock" class="mb-0">在庫数<span class="text-primary">　※仕入処理後に反映されます。</span></label>
                            <input readonly type="text" class="form-control input-size" id="stock" name="stock" value="{{ old('stock','0') }}">
                                @error('stock')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                    <div class="form-group" >
                        <label for="material" class="mb-0">素材<span class="text-danger">　(必須)</span></label>
                            <input type="text" class="form-control input-size text-wrap" id="material" name="material" value="{{ old('material') }}">
                                @error('material')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>    
                <!-- 画像エリア -->
                <div class="content-card ml-2">
                    <div class="form-group" >
                        <label for="img" class="mb-0">商品画像(50KB以内 jpg,jpeg,png,gifのみ)</label>
                            <input type="file" class="form-control input-size" id="img" name="img" value="{{ old('img') }}">
                                @error('img')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>    
            </div>
            <div class="content-cards">
                <div class="content-card me-1">
                    <div class="form-group" >
                        <label for="spec" class="mb-0">仕様<span class="text-danger">　(必須)</span></label>
                            <textarea rows="3" style="resize:none" id="spec" type="text" name="spec" class="form-control input-size text-wrap">{{ old('spec') }}</textarea>
                                @error('spec')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>                   
                <div class="content-card ms-1">
                    <div class="form-group">
                        <label for="comment" class="mb-0">備考</label>
                            <textarea rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ old('comment') }}</textarea>
                                @error('comment')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>            
            </div>
            <div class="content-cards">
                <div class="content-card me-1">
                    <div class="form-group">
                        <label for="sales_period" class="mb-0">販売期間( 例 2022/01/01-2023/09/09 )<span class="text-danger">　(必須)</span></label>
                            <input type="text" class="form-control input-size" id="sales_period" name="sales_period" value="{{ old('sales_period') }}">
                                @error('sales_period')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>    
                <div class="content-card ms-1">
                    <!--  仕入先種別のセレクトボックス -->
                    <div class="form-group" >
                        <label for="supplier" class="mb-0">仕入先<span class="text-danger">　(必須)</span></label>
                            <select class="form-control input-size" id="supplier" name="supplier" >
                                <option > 選択してください </option>
                                @foreach ($suppliers as $supplier)
                                                    <option value="{{$supplier->id }}">{{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                                @error('supplier')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>    
            </div>                
        </div>
</div>
            <!-- 登録ボタン -->
            <div class="card-footer mt=0">
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

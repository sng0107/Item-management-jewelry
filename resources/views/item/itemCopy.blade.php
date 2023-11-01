@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品複製</h1>
@stop

@section('content')

<!-- 一覧に戻るボタン -->
<div class="text-right">
        <a href="{{url('items')}}" class="btn btn-primary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- 編集フォームエリア -->
<div class="card card-primary">
    <form method="POST" action="/items/clone/{{$item->id}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="content-cards">
                <div class="content-card me-1" >
                            <div class="form-group">
                            <label for="item_code" class="mb-0">商品コード<span class="text-danger">　(必須)</span></label>
                                <input type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ old('item_code', $item->item_code) }}">
                                @error('item_code')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                            <label for="item_name" class="mb-0">商品名<span class="text-danger">　(必須)</span></label>
                                <input type="text" class="form-control input-size" id="item_name" name="item_name" value="{{ old('item_name', $item->item_name) }}">
                                @error('item_name')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                            </div>
                   <!-- アイテム名の編集エリア -->
                    <div class="form-group">
                    <label for="type_id" class="form-label">アイテム<span class="text-danger">　(必須)</span></label>
                        <select class="form-control input-size" name="type_id" id="type_id">
                            @foreach ($types as $type)     
                                @if ($item->type_id == $type->type_id)
                                    <option value="{{ $item->type_id }}" selected>{{ $item->type->type_name }}</option>
                                @else
                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('type_id')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                    <label for="retail_price" class="mb-0">販売単価(税込)<span class="text-danger">　(必須)</span></label>
                        <input type="text" class="form-control input-size " id="retail_price" name="retail_price" value="{{ old('retail_price', $item->retail_price) }}">
                        @error('retail_price')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                    <label for="stock" class="mb-0">在庫数<span class="text-primary">　※仕入処理後に反映されます。</span></label>
                        <input readonly type="text" class="form-control input-size" id="stock" name="stock" value="{{ 0 }}">
                        @error('stock')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                    <label for="material" class="mb-0">素材<span class="text-danger">　(必須)</span></label>
                        <input type="text" class="form-control input-size" id="material" name="material" class="text-wrap" value="{{ old('material', $item->material) }}">
                        @error('material')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>   

                <!-- 画像エリア -->
                <div class="content-card ms-1">
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
                    <div class="form-group">
                    <label for="spec" class="mb-0">仕様<span class="text-danger">　(必須)</span></label>
                        <textarea rows="3" style="resize:none" id="spec" type="text" name="spec" class="form-control input-size text-wrap">{{ old('spec', $item->spec) }}</textarea>
                        @error('spec')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div> 
                <div class="content-card ms-1">
                    <div class="form-group">
                    <label for="comment" class="mb-0">備考</label>
                        <textarea rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ old('comment', $item->comment) }}</textarea>
                        @error('comment')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="content-cards">
                <div class="content-card me-1">
                    <div class="form-group">
                    <label for="sales_period" class="mb-0">販売期間( 例 2022/01/01-2023/09/09)<span class="text-danger">　(必須)</span></label>
                        <input type="text" class="form-control input-size" id="sales_period" name="sales_period" value="{{ old('sales_period', $item->sales_period) }}">
                        @error('sales_period')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>    
                <div class="content-card ms-1">
                    <!-- 仕入先名の編集エリア -->
                    <div class="form-group" >
                    <label for="supplier_id" class="mb-0">仕入先<span class="text-danger">　(必須)</span></label>
                        <select class="form-control input-size" name="supplier_id" id="supplier_id">
                            @foreach ($suppliers as $supplier)     
                                @if ($item->supplier_id == $supplier->id)
                                    <option value="{{ $item->supplier_id }}" selected>{{ $item->supplier->supplier_name }}</option>
                                @else
                                    <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('supplier')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>            
            </div>

        </div>


        <div class="card-footer ">
            <!-- 更新ボタン -->
            <button  type="submit" class="btn btn-primary me-2 btn-sm update-btn" >登録</button>                    
        
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

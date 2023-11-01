@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
@stop

@section('content')

<!-- 一覧に戻るボタン -->
<div class="text-right">
        <a href="{{url('items')}}" class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- フラッシュメッセージ -->
@if (session('flash_message'))
    <div class="alert alert-primary alert-dismissible fade show mt-3 alert-size" role="alert" >
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {!! session('flash_message') !!}
    </div>
@endif

<!-- 編集フォームエリア -->
<div class="card card-primary">
    <form method="POST" action="/items/edit/{{$item->id}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="content-cards">
                <div class="content-card" >
                            <div class="form-group">
                                <label for="item_code" class="mb-0">商品コード</label>
                                <input  type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ old('item_code', $item->item_code) }}">
                                @error('item_code')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="item_name" class="mb-0">商品名</label>
                                <input type="text" class="form-control input-size" id="item_name" name="item_name" value="{{ old('item_name', $item->item_name) }}">
                                @error('item_name')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                            </div>
                   <!-- アイテム名の編集エリア -->
                    <div class="form-group">
                        <label for="type_id" class="mb-0">アイテム</label>
                        <select class="form-control input-size" name="type_id" id="type_id">
                            @foreach ($types as $type) 
                                @if ($item->type_id == $type->id)
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
                        <label for="retail_price" class="mb-0">販売単価(税込)</label>
                        <input type="text" class="form-control input-size " id="retail_price" name="retail_price" value="{{ old('retail_price', $item->retail_price) }}">
                        @error('retail_price')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock" class="mb-0">在庫数</label>
                        <input readonly type="text" class="form-control input-size" id="stock" name="stock" value="{{ old('stock', $item->stock) }}">
                        @error('stock')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="material" class="mb-0">素材</label>
                        <input type="text" class="form-control input-size" id="material" name="material" class="text-wrap" value="{{ old('material', $item->material) }}">
                        @error('material')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>   
                <div class="content-card ml-3">
                    <div class="form-group">
                        <label for="img" class="mb-0">商品画像(50KB以内 jpg,jpeg,png,gifのみ)</label>
                        <input type="file" class="form-control input-size" id="img" name="img" value="{{ old('img', $item->img) }}">
                        <p for="img" class="form-label text-danger">*画像を変更しない場合は選択不要です</p>
                        @error('img')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div> 

                    <!-- 変更前の画像レビュー -->
                    <div class="form-group " >
                        <div><p for="img" class="mb-0">↓ 変更前の画像です</p></div>
                        <td>
                        @if ($item->img)
                        <div>
                            <img src="data:image/*;base64,{{ $item->img }}" alt="{{ $item->item_name }}" class="img-thumbnail" style="width:10rem; ">
                        </div>                                
                        @else
                            画像なし
                        @endif
                    </div>
                </div>
            </div>
        
            <div class="content-cards">
                <div class="content-card me-1">
                    <div class="form-group">
                        <label for="spec" class="mb-0">仕様</label>
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
                        <label for="sales_period" class="mb-0">販売期間( 例 2022/01/01-2023/09/09 )</label>
                        <input type="text" class="form-control input-size" id="sales_period" name="sales_period" value="{{ old('sales_period', $item->sales_period) }}">
                        @error('sales_period')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>    
                <div class="content-card ms-1">
                    <!-- 仕入先名の編集エリア -->
                    <div class="form-group" >
                        <label for="supplier_id" class="mb-0">仕入先</label>
                        <select class="form-control input-size" name="supplier_id" id="supplier_id">
                            @foreach ($suppliers as $supplier)     
                                @if ($supplier->supplier_code == $item->supplier)
                                    <option value="{{ $supplier->supplier_code }}" selected>{{ $supplier->supplier_name }}</option>
                                @else
                                    <option value="{{ $supplier->supplier_code }}">{{ $supplier->supplier_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('supplier_id')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
                    </div>
                </div>            
            </div>

        </div>


        <div class="card-footer ">
            <!-- 更新ボタン -->
            <button  type="submit" class="btn btn-secondary me-2 btn-sm update-btn" >更新</button>                    
        
    </form>
            <!-- 削除ボタン -->
            <form method="POST" action="/items/delete/{{$item->id}}" onSubmit="return submitCheck()">
                @csrf
                <button type="submit" class="btn btn-danger ms-2 btn-sm delete-btn" >削除</button>
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
        if(!window.confirm('本当に削除しますか？')) {
            return false;
        }
    }

    // コストが削除されたときに出るフラッシュメッセージ
    $(function(){
        $('div.alert').fadeIn('slow', function() {
            $(this).delay(10000).fadeOut('slow');
        });
    });
</script>

@stop

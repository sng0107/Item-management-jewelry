@extends('adminlte::page')

@section('title', '商品詳細')

@section('content_header')
    <h1>商品詳細</h1>
@stop

@section('content')
<!-- 一覧画面の元居たページに戻るボタン -->
<div class="text-right">
    <a href="{{url()->previous()}}"  class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>
<!-- 詳細表示エリア -->
    <div class="card card-primary">
            <div class="card-body">
                <div class="content-cards">
                    <div class="content-card me-1">
                        <div class="form-group">
                            <label for="item_code" class="mb-0">商品コード</label>
                                <input readonly type="text" class="form-control input-size input-size" id="item_code" name="item_code" value="{{ $item->item_code }}">
                        </div>   
                        <div class="form-group">
                            <label for="item_name" class="mb-0">商品名</label>
                                <input readonly type="text" class="form-control input-size" id="item_name" name="item_name" value="{{ $item->item_name }}">
                        </div>
                        <!-- アイテム名をコードからに変換して表示 -->              
                        <div class="form-group">
                            <label for="type" class="mb-0">アイテム</label>
                                @if ($item->type_id)
                                    <input readonly type="text" class="form-control input-size" id="type" name="type" value="{{ $item->type->type_name }}">
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="retail_price" class="mb-0">販売単価(税込)</label>
                                <input readonly  type="text" class="form-control input-size" id="retail_price" name="retail_price" value="{{ number_format($item->retail_price) }}">
                        </div>
                       <div class="form-group">
                            <label for="stock" class="mb-0">在庫数</label>
                                <input readonly  type="text" class="form-control input-size" id="stock" name="stock" value="{{ number_format($item->stock) }}">
                        </div>
                        <div class="form-group">
                            <label for="material" class="mb-0">素材</label>
                                <input readonly  type="text" class="form-control input-size" id="material" name="material" value="{{ $item->material }}">
                        </div>
                    </div>
                        <!-- 画像エリア -->
                        <div class="content-card ms-1" >
                            <div class="form-group " >
                                <div><label for="img" class="mb-0">商品画像</label></div>
                                <td>
                                @if ($item->img)
                                <div>
                                    <img src="data:image/*;base64,{{ $item->img }}" alt="{{ $item->name }}" id="img" name="img" class="img-thumbnail" style="width:15rem; ">
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
                                    <textarea readonly  rows="3" style="resize:none"  type="text" id="spec" name="spec" class="form-control input-size">{{$item->spec}}</textarea>
                            </div>
                        </div>                           
                        <div class="content-card ms-1">
                            <div class="form-group">
                                <label for="comment" class="mb-0">備考</label>
                                    <textarea readonly rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size">{{$item->comment}}</textarea>
                            </div>
                        </div>                   
                    </div>

                    <div class="content-cards">
                        <div class="content-card me-1">
                            <div class="form-group">
                                <label for="sales_period" class="mb-0 ">発売時期</label>
                                    <input readonly  type="text" class="form-control input-size" id="sales_period" name="sales_period" value="{{ $item->sales_period }}">
                            </div>
                        </div>                       
                        <div class="content-card ms-1">
                            @can('管理者')
                                <!-- 仕入先をコードから名前に変換して表示 -->              
                                <div class="form-group">
                                    <label for="supplier" class="mb-0">仕入先</label>
                                        @if ($item->supplier_id)
                                            <input readonly  type="text" class="form-control input-size" id="supplier" name="supplier" value="{{ $item->supplier->supplier_name }}">
                                        @endif
                                </div>
                        </div>                    
                    </div>                        
            </div>
            <div class="card-footer ">
                <!-- 複製ボタン -->
                <form method="GET" action="/items/clone/{{$item->id}}" >
                    @csrf
                    <button type="submit" class="btn btn-warning ms-3 btn-sm delete-btn" >複製</button>
                </form>
            </div>
            @endcan
    </div>
@stop

@section('css')
    <!-- style -->
    @include('layouts.styles')
@stop

@section('js')
@stop

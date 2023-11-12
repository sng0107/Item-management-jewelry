@extends('adminlte::page')

@section('title', '仕入単価詳細')

@section('content_header')
    <h1>コスト詳細</h1>
@stop

@section('content')
    
<!-- 一覧画面の元居たページに戻るボタン -->
<div class="text-right">
    <a href="{{url()->previous()}}" class="btn btn-secondary mb-2 btn-sm back-btn ">一覧に戻る</a>
</div>

<!--　詳細表示エリア  -->
<div class="card card-primary">
    <form method="">
        <div class="card-body" >
            <div class="content-cards mb-3">
                <div class="content-card me-1" >
                    <div class="form-group"  >
                        <label for="item_code" class="mb-0 ">商品コード</label>
                            <input readonly type="text" class="form-control input-size " id="item_code" name="item_code" value="{{ $cost->item->item_code }}">
                    </div>  
                </div>    
                <div class="content-card ms-1 me-1">
                    <div class="form-group" >
                        <label for="item_name" class="mb-0 ">商品名</label>
                            <input readonly type="text" class="form-control input-size " id="item_name" name="item_name" value="{{ $cost->item->item_name }}">
                    </div>
                </div>
                <div class="content-card ms-1">
                    <div class="form-group" >
                    <label for="supplier_id" class="mb-0 ">仕入先</label>
                        <input readonly type="text" class="form-control input-size " id="supplier_id" name="supplier_id" value="{{ $cost->item->supplier->supplier_name }}">
                    </div>
                </div>
            </div>

            <!--コスト詳細エリア  -->
            <p class="text-primary">---  全て税込価格です。 ---</p>
            <label>仕入単価の内訳</label>
            <div class="cost-content-cards">
                <div class="cost-content-card me-1">
                    <div class="form-group" >
                        <label for="metal_cost" class="mb-0">(地金代)</label>
                            <input type="text" class="form-control input-size" id="metal_cost" name="metal_cost" value="{{ number_format($cost->metal_cost) }}">
                    </div>
                </div>
                <div class="cost-content-card ms-1 me-1">
                    <div class="form-group" >
                        <label for="chain_cost" class="mb-0">(チェーン代)</label>
                            <input type="text" class="form-control input-size" id="chain_cost" name="chain_cost" value="{{ number_format($cost->chain_cost) }}">
                    </div>
                </div>
                <div class="cost-content-card ms-1 me-1">
                    <div class="form-group" >
                        <label for="parts_cost" class="mb-0">(パーツ代)</label>
                            <input type="text" class="form-control input-size" id="parts_cost" name="parts_cost" value="{{ number_format($cost->parts_cost) }}">
                    </div>
                </div>
                <div class="cost-content-card ms-1 me-1">
                    <div class="form-group" >
                        <label for="stone_cost" class="mb-0">(石材代)</label>
                            <input type="text" class="form-control input-size" id="stone_cost" name="stone_cost" value="{{ number_format($cost->stone_cost) }}">
                    </div>
                </div>
                <div class="cost-content-card ms-1 me-1">
                    <div class="form-group" >
                        <label for="processing_cost" class="mb-0">(加工代)</label>
                            <input type="text" class="form-control input-size" id="processing_cost" name="processing_cost" value="{{number_format($cost->processing_cost) }}">
                    </div>
                </div>
                <div class="cost-content-card ms-1">
                    <div class="form-group" >
                        <label for="other_cost" class="mb-0">(その他)</label>
                            <input type="text" class="form-control input-size" id="other_cost" name="other_cost" value="{{ number_format($cost->other_cost) }}">
                    </div>
                </div>
            </div>
            <div class="totalcost-content-cards">
                <div class="totalcost-content-card me-1">
                    <div class="form-group" >
                        <label for="total_cost" class="mb-0">コスト合計</label>
                            <input type="text" class="form-control input-size" id="total_cost" name="total_cost" value="{{ number_format($cost->total_cost) }}">
                    </div>
                </div>
                <div class="totalcost-content-card ms-1 me-1">
                    <div class="form-group" >
                        <label for="retail_price" class="mb-0">販売単価</label>
                            <input readonly type="text" class="form-control input-size" id="retail_price" name="retail_price" value="{{ number_format($cost->retail_price) }}">
                    </div>
                </div>
                <div class="totalcost-content-card ms-1">
                    <div class="form-group" >
                        <label for="cost_rate" class="mb-0">原価率(%)</label>
                            <input type="text" class="form-control input-size" id="cost_rate" name="cost_rate" value="{{ number_format($cost->cost_rate) }}">
                    </div>
                </div>
</div>            <div class="form-group">
                    <label for="comment" class="mt-3">備考</label>
                        <textarea rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{  $cost->comment }}</textarea>
                </div>
                <div class="cost-date-cards mt-3">
                    <div class="cost-date-card me-1">
                        <div class="form-group" >
                            <label for="created_at" class="mb-0">登録日時</label>
                                <input type="text" class="form-control input-size" id="created_at" name="created_at" value="{{ $cost->created_at ->format('Y-m-d　H:d') }}">
                        </div>
                    </div>
                    <div class="cost-date-card ms-1">
                        <div class="form-group" >
                            <label for="updated_at" class="mb-0">更新日時</label>
                                <input type="text" class="form-control input-size" id="updated_at" name="updated_at" value="{{ $cost->updated_at ->format('Y-m-d　H:d') }}">
                        </div>
                    </div>   
                    <div class="cost-date-card ms-1">
                        <div class="form-group" >
                            <label for="user_id" class="mb-0">最終更新 担当者</label>
                                <input type="text" class="form-control input-size" id="user_id" name="user_id"  value="{{ $cost->user->name }}">
                        </div>
                    </div> 
                </div>
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

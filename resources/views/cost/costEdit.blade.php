@extends('adminlte::page')

@section('title', 'コスト編集')

@section('content_header')
    <h1>コスト編集</h1>
@stop

@section('content')
<!-- 一覧画面の元居たページに戻るボタン -->
<div class="text-right">
    <a href="{{url()->previous()}}" class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

  <!--　編集フォームエリア  -->
<div class="card card-primary">
    <form method="POST"  action="{{ route('costs.costUpdate', ['id' => $cost->id]) }}">
        @csrf
        <div class="card-body" >
            <div class="content-cards">
                <div class="content-card me-1">
                    <div class="form-group" >
                        <label for="item_code" class="mb-0 ">商品コード</label>
                            <input readonly type="text" class="form-control input-size" id="item_code" name="item_code" value="{{ $cost->item->item_code }}">
                                @error('item_code')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
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
                        <label for="supplier" class="mb-0 ">仕入先</label>
                            <input readonly type="text" class="form-control input-size " id="supplier" name="supplier" value="{{ $cost->item->supplier->supplier_name }}">
                    </div>
                </div>
            </div>

            <!--コスト入力エリア  -->
            <p class="text-primary mt-3">---  全て税込価格で入力してください。 ---</p>
                <label >仕入単価の内訳</label>
                <div class="cost-content-cards">
                    <div class="cost-content-card me-1">
                        <div class="form-group" >
                            <label for="metal_cost" class="mb-0">(地金代)</label>
                                <input type="text" class="form-control input-size" id="metal_cost" name="metal_cost" oninput="makeTotalCost()" value="{{ old('metal_cost',$cost->metal_cost) }}">
                                    @error('metal_cost')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                    @enderror
                        </div>
                    </div> 
                    <div class="cost-content-card ms-1 me-1">    
                        <div class="form-group" >
                            <label for="chain_cost" class="mb-0">(チェーン代)</label>
                                <input type="text" class="form-control input-size" id="chain_cost" name="chain_cost" oninput="makeTotalCost()" value="{{ old('chain_cost',$cost->chain_cost) }}">
                                    @error('chain_cost')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="cost-content-card ms-1 me-1">  
                        <div class="form-group" >
                            <label for="parts_cost" class="mb-0">(パーツ代)</label>
                                <input type="text" class="form-control input-size" id="parts_cost" name="parts_cost" oninput="makeTotalCost()" value="{{ old('parts_cost',$cost->parts_cost) }}">
                                    @error('parts_cost')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="cost-content-card ms-1 me-1">  
                        <div class="form-group" >
                            <label for="stone_cost" class="mb-0">(石材代)</label>
                                <input type="text" class="form-control input-size" id="stone_cost" name="stone_cost" oninput="makeTotalCost()" value="{{ old('stone_cost',$cost->stone_cost) }}">
                                    @error('stone_cost')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="cost-content-card ms-1 me-1">  
                        <div class="form-group" >
                            <label for="processing_cost" class="mb-0">(加工代)</label>
                                <input type="text" class="form-control input-size" id="processing_cost" name="processing_cost"oninput="makeTotalCost()"  value="{{ old('processing_cost',$cost->processing_cost) }}">
                                    @error('processing_cost')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="cost-content-card ms-1"> 
                        <div class="form-group" >
                            <label for="other_cost" class="mb-0">(その他)</label>
                                <input type="text" class="form-control input-size" id="other_cost" name="other_cost" oninput="makeTotalCost()" value="{{ old('other_cost',$cost->other_cost) }}">
                                    @error('other_cost')
                                    <div class="text-danger error-font-size">{{ $message }}</div>
                                    @enderror
                        </div>
                    </div>
                </div>

            <div class="totalcost-content-cards">
                <!-- 仕入単価合計の自動計算結果を表示 -->
                <div class="totalcost-content-card me-1">
                    <div class="form-group" >
                        <label for="total_cost" class="mb-0">コスト合計<span class="text-primary">　※自動計算です。</span></label>
                            <input type="text" class="form-control input-size" id="total_cost" name="total_cost" value="{{ old('total_cost',$cost->total_cost) }}">
                                @error('total_cost')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>
                <div class="totalcost-content-card ms-1 me-1 ">
                    <div class="form-group" >
                        <label for="retail_price" class="mb-0">販売単価</label>
                            <input readonly type="text" class="form-control input-size" id="retail_price" name="retail_price" value="{{ $cost->item->retail_price }}">
                    </div>
                </div>

                <!-- 原価率の自動計算結果を表示 -->
                <div class="totalcost-content-card ms-1">
                    <div class="form-group" >
                        <label for="cost_rate" class="mb-0">原価率 (%)<span class="text-primary">　※自動計算です。</span></label>
                            <input type="text" class="form-control input-size" id="cost_rate" name="cost_rate" value="{{ old('cost_rate',$cost->cost_rate) }}">
                                @error('retail_price')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                </div>            
</div>

            <div class="form-group">
                <label for="comment" class="mt-3">備考</label>
                    <textarea rows="3" style="resize:none" id="comment" type="text" name="comment" class="form-control input-size text-wrap">{{ old('comment', $cost->comment) }}</textarea>
                        @error('comment')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>
        </div>
        <!-- 登録ボタン -->
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary ml-2 btn-sm update-btn" >更新</button>
    </form>
        <!-- 削除ボタン -->
            <form action="/costs/delete/{{$cost->id}}" method="POST" onSubmit="return submitCheck()">
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
 //仕入単価合計と原価率の計算を自動で行う処理
    function makeTotalCost() {
        const metalCost = parseFloat(document.getElementById('metal_cost').value); //parseFloatは文字列を数値に変換
        const chainCost = parseFloat(document.getElementById('chain_cost').value);
        const partsCost = parseFloat(document.getElementById('parts_cost').value);
        const stoneCost = parseFloat(document.getElementById('stone_cost').value);
        const processingCost = parseFloat(document.getElementById('processing_cost').value);
        const otherCost = parseFloat(document.getElementById('other_cost').value);
        const totalCost = parseFloat(document.getElementById('total_cost').value); 
        const retailPrice = parseFloat(document.getElementById('retail_price').value);

        if (metalCost || chainCost || partsCost || stoneCost || processingCost || otherCost) {
            const totalCost = (metalCost + chainCost + partsCost + stoneCost + processingCost + otherCost);
            document.getElementById('total_cost').value = totalCost;
            const costRate = ((totalCost / retailPrice)*100);
            document.getElementById('cost_rate').value = costRate;

        } else {
            document.getElementById('total_cost').value = 'エラーが発生しています。入力を確認してください。';
        }
    }
</script>

<script>
    //削除ボタンが押下されたら確認メッセージを表示
    function submitCheck(){
        if(!window.confirm('本当に削除しますか？')) {
            return false;
        }
    }
</script>
@stop

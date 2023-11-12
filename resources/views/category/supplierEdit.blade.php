@extends('adminlte::page')

@section('title', '【カテゴリー】仕入先編集')

@section('content_header')
    <h1>【カテゴリー】仕入先編集</h1>
@stop

@section('content')
<!-- 一覧に戻るボタン -->
<div class="text-right">
    <a href="{{url('categories/supplier')}}"class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- 編集フォームエリア -->
<div class="card card-primary supplier-edit-form">
    <form method="POST" action="/categories/supplier/edit/{{$supplier->id}}" >
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="supplier_code" class="mb-0">仕入先コード</label>
                    <input readonly type="text" class="form-control input-size" id="supplier_code" name="supplier_code" value="{{ $supplier->supplier_code }}">
                        @error('supplier_code')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>
            <div class="form-group">
                <label for="supplier_name" class="mb-0">仕入先名(20文字以内)</label>
                    <input type="text" class="form-control input-size" id="supplier_name" name="supplier_name" value="{{  $supplier->supplier_name }}">
                        @error('supplier_name')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                        @enderror
            </div>
        </div>

        <div class="card-footer">
            <!-- 更新ボタン -->
            <button  type="submit" class="btn btn-secondary mr-2 btn-sm update-btn" >更新</button>  
    </form>      
            <!-- 削除ボタン -->
            <form  method="POST" action="/categories/supplier/delete/{{$supplier->id}}" onSubmit="return submitCheck()">
                @csrf
                <button type="submit" class="btn btn-danger ml-2 btn-sm delete-btn ">削除</button>
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
</script>   
@stop

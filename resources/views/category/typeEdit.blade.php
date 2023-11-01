@extends('adminlte::page')

@section('title', '【カテゴリー】アイテム編集')

@section('content_header')
    <h1>【カテゴリー】アイテム編集</h1>
@stop

@section('content')
<!-- 一覧に戻るボタン -->
<div class="text-right">
    <a href="{{url('categories/type')}}"class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- 編集フォーム -->
<div class="card card-primary type-edit-form">
    <form method="POST" action="/categories/type/edit/{{$type->id}}" >
        <div class="card-body">
            @csrf
            <div class="form-group">
            <label for="type_code" class="mb-0">アイテムコード</label>
                <input readonly type="text" class="form-control" id="type_code" name="type_code" value="{{ $type->type_code }}">
                    @error('type_code')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
            </div>

            <div class="form-group">
            <label for="type_name" class="mb-0">アイテム名(20文字以内)</span></label>
                <input type="text" class="form-control" id="type_name" name="type_name" value="{{  $type->type_name }}">
                    @error('type_name')
                            <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
            </div>
            
            <div class="card-footer">
                <!-- 更新ボタン -->
                <button  type="submit" class="btn btn-secondary mr-2 btn-sm update-btn ">更新</button>  
    </form>      

                <!-- 削除ボタン -->
                <form  method="POST" action="/categories/type/delete/{{$type->id}}" onSubmit="return submitCheck()">
                    @csrf
                    <button type="submit" class="btn btn-danger ml-2 btn-sm delete-btn" >削除</button>
                </form>
            </div> 
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

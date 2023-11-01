@extends('adminlte::page')

@section('title', '【カテゴリー】アイテム登録')

@section('content_header')
    <h1>【カテゴリー】アイテム登録</h1>
@stop

@section('content')

<!-- 一覧に戻るボタン -->
<div class="text-right">
    <a href="{{url('categories/type')}}" class="btn btn-secondary mb-2 btn-sm back-btn ">一覧に戻る</a>
</div>

<!-- 入力フォームエリア -->
<div class="card card-primary type-add-form">
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body" >
            <div class="content-cards">
                <div class="content-card" >
                    <div class="form-group" >
                        <label for="type_code" class="mb-0">アイテムコード(5桁)<span class="text-danger">　(必須)</span></label>
                        <input type="text" class="form-control input-size" id="type_code" name="type_code" value="{{ old('type_code') }}">
                            @error('type_code')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group" >
                        <label for="type_name" class="mb-0">アイテム名(20文字以内)<span class="text-danger">　(必須)</span></label>
                        <input type="text" class="form-control input-size" id="type_name" name="type_name" value="{{ old('type_name') }}">
                            @error('type_name')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                            @enderror
                    </div>

                    <!-- 登録ボタン -->
                    <div class="card-footer mt-3">
                    <button type="submit" class="btn btn-secondary ml-2 btn-sm add-btn" >登録</button>
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

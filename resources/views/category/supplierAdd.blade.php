@extends('adminlte::page')

@section('title', '【カテゴリー】仕入先登録')

@section('content_header')
    <h1>【カテゴリー】仕入先登録</h1>
@stop

@section('content')

<!-- 一覧に戻るボタン -->
<div class="text-right">
    <a href="{{url('categories/supplier')}}" class="btn btn-secondary mb-2 btn-sm back-btn ">一覧に戻る</a>
</div>

<!-- 入力フォームエリア -->
<div class="card card-primary supplier-add-form">
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body" >
            <div class="content-cards">
                <div class="content-card" >
                    <div class="form-group" >
                        <label for="supplier_code" class="mb-0">仕入先コード(5桁)<span class="text-danger">　(必須)</span></label>
                            <input type="text" class="form-control input-size" id="supplier_code" name="supplier_code" value="{{ old('supplier_code') }}">
                                @error('supplier_code')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>
                    <div class="form-group" >
                        <label for="supplier_name" class="mb-0">仕入先名(20文字以内)<span class="text-danger">　(必須)</span></label>
                            <input type="text" class="form-control input-size" id="supplier_name" name="supplier_name" value="{{ old('supplier_name') }}">
                                @error('supplier_name')
                                <div class="text-danger error-font-size">{{ $message }}</div>
                                @enderror
                    </div>

            <!-- 登録ボタン -->
            <div class="card-footer mt-3">
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

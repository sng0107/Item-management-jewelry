@extends('adminlte::page')

@section('title', 'アカウント編集')

@section('content_header')
    <h1>アカウント編集</h1>
@stop


@section('content')
<!-- 一覧に戻るボタン -->
<div class="text-right">
    <a href="{{url('users')}}"class="btn btn-secondary mb-2 btn-sm back-btn">一覧に戻る</a>
</div>

<!-- 編集フォームエリア -->
<div class="card card-primary user-edit-form">
    <div class="card-body">
        <form method="POST" >
            @csrf
                <div class="form-group">
                    <label for="staff_number">社員番号</label>
                    <input type="text" class="form-control" id="staff_number" name="staff_number" value="{{ $user->staff_number }}">
                    @error('staff_number')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">氏名</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    @error('name')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    @error('email')
                        <div class="text-danger error-font-size">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3 mb-3">
                    <label  class="me-5">アカウント権限</label>
                    <input type="radio" id="role2" name="role" required value="0" @if($user->role==0) checked @endif><label for="role2" class="ms-1 me-3">利用者</label>
                    <input type="radio" id="role1" name="role" required value="1" @if($user->role==1) checked @endif><label for="role1" class="ms-1">管理者</label>
                </div>
                

                <div class="card-footer">
                    <!-- 更新ボタン -->
                    <a href='/users'><button type="submit" class="btn btn-secondary mr-2 btn-sm edit-btn">更新</button></a>                    
                
        </form>
                <!-- 削除ボタン -->
                <form action="/users/delete/{{$user->id}}" method="POST">
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
@stop

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="text-center mt-5">Welcome to the product management system.</h1>
@stop

@section('content')
<div class="text-center mt-2">
        <p>ようこそ、商品管理システムへ。<br>サイドバーのメニューをクリックしてシステムをご利用ください。</p>
        <!-- <img src="{{asset('storage/images/home_2_img.jpg')}}" alt="HOME IMAGE" class="mt-2" style="width:60%;"> -->
</div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

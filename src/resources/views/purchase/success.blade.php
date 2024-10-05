@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('content')
<div class="process-wrapper">
    <div class="process-content">
        <p class="process-content__text">お支払いが完了しました。</p>
        <a class="process-content__btn" href="/">ホームに戻る</a>
    </div>
</div>

@endsection
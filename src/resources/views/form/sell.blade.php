@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form__header">商品の出品</h1>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="form__element">
            <label class="form__element-label">商品画像</label>
            <div class="form__element-file-wrapper">
                <input class="form__element-input form__element-file " name="img" type="file" id="inputFile" accept="image/*" value="">
                <label class="form__element-file-btn" for="inputFile">画像を選択する</label>
            </div>
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('name')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <h2 class="form__subheader">商品の詳細</h2>
        <div class="form__element">
            <label class="form__element-label">カテゴリー</label>
            <input class="form__element-input" name="category" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('email')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">商品の状態</label>
            <input class="form__element-input" name="condition" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('password')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <h2 class="form__subheader">商品名と説明</h2>
        <div class="form__element">
            <label class="form__element-label">商品名</label>
            <input class="form__element-input" name="product_name" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('email')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">商品の説明</label>
            <input class="form__element-input" name="description" type="textarea">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('password')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <h2 class="form__subheader">販売価格</h2>
        <div class="form__element">
            <label class="form__element-label">販売価格</label>
            <input class="form__element-input" name="price" type="text" value="¥">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('email')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__btn">
            <button class="form__btn-submit">出品する</button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('header')
    @component('components.header_auth')
    @endcomponent
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form__header">会員登録</h1>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="form__element">
            <label class="form__element-label">名前</label>
            <input class="form__element-input" name="name" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('name')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">メールアドレス</label>
            <input class="form__element-input" name="email" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('email')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">パスワード</label>
            <input class="form__element-input" name="password" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('password')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__btn">
            <button class="form__btn-submit">登録する</button>
        </div>
    </form>
    <div class="form__link">
        <a class="form__link-anchor" href="/login">ログインはこちら</a>
    </div>
</div>
@endsection
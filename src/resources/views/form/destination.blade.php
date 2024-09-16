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
    <h1 class="form__header">住所の変更</h1>
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form__element">
            <label class="form__element-label">郵便番号</label>
            <input class="form__element-input" name="postcode" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('postcode')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">住所</label>
            <input class="form__element-input" name="address" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('address')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">建物名</label>
            <input class="form__element-input" name="building" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('building')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__btn">
            <button class="form__btn-submit">更新する</button>
        </div>
    </form>
</div>
@endsection
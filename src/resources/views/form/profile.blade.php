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
    <h1 class="form__header">プロフィール設定</h1>
    <form class="form" action="/mypage/profile/update" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form__element form__element--icon" id="previewFile">
            @empty($user->user_icon)
            <span class="material-symbols-outlined user-icon-default">
            person
            </span>
            @else
            <img class="form__element-img" src="{{ asset($user->user_icon) }}" alt="user_icon" id="imgFile">
            @endempty
            <input class="form__element-input form__element-file " name="user_icon" type="file" id="inputFile" accept="image/*" value="">
            <label class="form__element-file-btn" for="inputFile">画像を選択する</label>
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('user_icon')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">ユーザー名</label>
            <input class="form__element-input" name="name" type="text" value="{{ $user->name }}">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('name')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">郵便番号</label>
            <input class="form__element-input" name="postcode" type="text" value="<?php if(isset($address)){echo($address->postcode);} ?>">
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
            <input class="form__element-input" name="address" type="text" value="<?php if(isset($address)){echo($address->prefecture. $address->city. $address->block);} ?>">
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
            <input class="form__element-input" name="building" type="text" value="<?php if(isset($address)){echo($address->building);} ?>">
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

<script>
    const inputElm = document.getElementById('inputFile');
    inputElm.addEventListener('change', (e) => {
        const file = e.target.files[0];

        const fileReader = new FileReader();
        // 画像を読み込む
        fileReader.readAsDataURL(file);

        // 画像読み込み完了時の処理
        fileReader.addEventListener('load', (e) => {
            // imgタグ生成
            const imgElm = document.createElement('img');
            imgElm.src = e.target.result;

            // imgタグを挿入
            const targetElm = document.getElementById('previewFile');
            const firstChild = targetElm.children[0];
            targetElm.removeChild(firstChild);
            targetElm.prepend(imgElm);


        });
    });
</script>
@endsection
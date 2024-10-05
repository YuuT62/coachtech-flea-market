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
    <form class="form" action="/item/register" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form__element">
            <label class="form__element-label">商品画像</label>
            <div class="form__element-file-wrapper">
                <span class="form__element-file-name"  id="previewFile"></span>
                <input class="form__element-input form__element-file" name="item_img" type="file" id="inputFile" accept="image/*" value="">
                <label class="form__element-file-btn" for="inputFile">画像を選択する</label>
            </div>
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('item_img')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <h2 class="form__subheader">商品の詳細</h2>
        <div class="form__element form__element--category">
            <label class="form__element-label">カテゴリー</label>
            <input class="form__element-input" name="category" type="text" id="inputCategory">
            <p id="toolTip">カンマ(,)で区切ることで複数のカテゴリーを指定できます。（例：洋服,シャツ）</p>
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('category')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">ブランド名</label>
            <input class="form__element-input" name="brand_name" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('brand_name')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__element">
            <label class="form__element-label">商品の状態</label>
            <select class="form__element-select" name="condition">
                <option value="" disabled selected></option>
                @foreach($conditions as $condition)
                <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                @endforeach
            </select>
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('condition')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <h2 class="form__subheader">商品名と説明</h2>
        <div class="form__element">
            <label class="form__element-label">商品名</label>
            <input class="form__element-input" name="item_name" type="text">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('item_name')
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
                @error('description')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <h2 class="form__subheader">販売価格</h2>
        <div class="form__element">
            <label class="form__element-label">販売価格</label>
            <input class="form__element-input" name="price" type="text" value="" placeholder="¥">
        </div>
        <div class="form__error">
            <span class="form__error-text">
                @error('price')
                ※{{ $message }}
                @enderror
            </span>
        </div>
        <div class="form__btn">
            <button class="form__btn-submit" type="submit">出品する</button>
        </div>
    </form>
</div>

<script>
const inputElm = document.getElementById('inputFile');
inputElm.addEventListener('change', (e) => {
    document.getElementById('previewFile').textContent = "選択中：" + inputElm.files[0].name;
});

const inputCategory = document.getElementById('inputCategory');
const toolTip = document.getElementById('toolTip');
// ボタンにhoverした時
inputCategory.addEventListener('mouseover', () => {
    toolTip.style.display = 'block';
}, false);

// ボタンから離れた時
inputCategory.addEventListener('mouseleave', () => {
    toolTip.style.display = 'none';
}, false);

</script>
@endsection
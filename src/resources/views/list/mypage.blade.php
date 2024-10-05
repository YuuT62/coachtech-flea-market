@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('content')
<div class="list-header">
    <div class="list-header-content">
        @if(session('message'))
        <div class="session">
            {{session('message')}}
        </div>
        @endif
        <div class="list-header__user">
            @empty($user->user_icon)
            <span class="material-symbols-outlined user-icon-default">
            person
            </span>
            @else
            <img class="list-header__user-icon" src="{{ asset($user->user_icon) }}" alt="user_icon">
            @endempty
            <p class="list-header__user-name">{{ $user->name }}</p>
        </div>
        <div class="list-header__link">
            <a class="list-header__link-anchor" href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>
</div>
<div class="nav-wrapper">
    <nav class="nav-content">
        <div class="nav__form">
            <input class="nav__input" type="radio" name="nav" id="sell" onclick="listChange()" checked="checked">
            <label class="nav__label" id="labelSell" for="sell">出品した商品</label>
            <input class="nav__input" type="radio" name="nav" id="purchase" onclick="listChange()">
            <label class="nav__label" id="labelPurchase" for="purchase">購入した商品</label>
        </div>
    </nav>
</div>
<div class="list-wrapper">
    <div class="list-content" id="listSell">
        @foreach($items as $item)
        <form class="list__element list__element--mypage" action="/item/{{ $item->id}}" method="get">
            <button class="list__element-btn">
                <img class="list__element-img" src="{{ asset($item->item_img) }}" alt="item-img">
                <p class="list__element-price">¥{{ number_format($item->price) }}</p>
            </button>
        </form>
        @endforeach
    </div>

    <div class="list-content" id="listPurchase">
        @foreach($purchases as $purchase)
        <form class="list__element list__element--mypage">
            <button class="list__element-btn">
                <img class="list__element-img" src="{{ asset($purchase->item->item_img) }}" alt="item-img">
                <p class="list__element-price">¥{{ number_format($purchase->item->price) }}</p>
            </button>
        </form>
        @endforeach
    </div>
</div>

<script>
    function listChange(){

        var listSell = document.getElementById('listSell');
        var labelSell = document.getElementById('labelSell');
        var listPurchase = document.getElementById('listPurchase');
        var labelPurchase = document.getElementById('labelPurchase');

        if(document.getElementsByName('nav')[0].checked){
            listSell.style.display = "flex";
            labelSell.style.color = "#ff0000";
            listPurchase.style.display ="none";
            labelPurchase.style.color = "#000";
        }else{
            listSell.style.display = "none";
            labelSell.style.color = "#000";
            listPurchase.style.display ="flex";
            labelPurchase.style.color = "#ff0000";
        }
    }
</script>
@endsection
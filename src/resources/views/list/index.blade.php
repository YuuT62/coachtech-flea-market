@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('content')
<div class="nav-wrapper">
    <nav class="nav-content">
        <form class="nav__form">
            <input class="nav__input" type="radio" name="nav" id="rec" onclick="listChange()" value="rec" checked='<?php if(isset($a) && $a==1) echo checked?>'>
            <label class="nav__label" id="labelRec" for="rec">おすすめ</label>
            <input class="nav__input" type="radio" name="nav" id="fav" onclick="listChange()" value="fav" checked='<?php if(isset($a) && $a==2) echo checked?>'>
            <label class="nav__label" id="labelFav" for="fav" value="2">マイリスト</label>
        </form>
    </nav>
</div>
@if(session('messages'))
    <div class="session">
        {{session('messages')}}
    </div>
@endif
<div class="list-wrapper">
    <div class="list-content list-rec" id="listRec">
        @if(isset($rec_items) && (strpos(url()->full(),'page') === false || strpos(url()->full(),'1') !== false ))
        @foreach($rec_items as $rec_item)
        <form class="list__element" action="/item/{{ $rec_item->id}}" method="get">
            <button class="list__element-btn">
                @isset($rec_item->purchase)
                <div class="list__element-soldout">SOLD OUT</div>
                @endisset
                <img class="list__element-img" src="{{ asset($rec_item->item_img) }}" alt="item-img">
                <p class="list__element-price">¥{{ number_format($rec_item->price) }}</p>
                <p>{{$rec_item->id}}</p>
            </button>
        </form>
        @endforeach
        @endisset
        @foreach($items as $item)
        <form class="list__element" action="/item/{{ $item->id}}" method="get">
            <button class="list__element-btn">
                @isset($item->purchase)
                <div class="list__element-soldout">SOLD OUT</div>
                @endisset
                <img class="list__element-img" src="{{ asset($item->item_img) }}" alt="item-img">
                <p class="list__element-price">¥{{ number_format($item->price) }}</p>
                <p>{{$item->id}}</p>
            </button>
        </form>
        @endforeach
        <div class="list-content__paginate">
            {{ $items->links('vendor.pagination.default') }}
        </div>
    </div>

    @if(Auth::check())
    <div class="list-content" id="listFav">
        @foreach($favorites as $item)
        <form class="list__element" action="/item/{{ $item->item->id}}" method="get">
            <button class="list__element-btn">
                @isset($item->item->purchase)
                <div class="list__element-soldout">SOLD OUT</div>
                @endisset
                <img class="list__element-img" src="{{ asset($item->item->item_img) }}" alt="item-img">
                <p class="list__element-price">¥{{ number_format($item->item->price) }}</p>
            </button>
        </form>
        @endforeach
    </div>
    @endif
</div>

<script>
    function listChange(){

        const listRec = document.getElementById('listRec');
        const labelRec = document.getElementById('labelRec');
        const listFav = document.getElementById('listFav');
        const labelFav = document.getElementById('labelFav');

        if(document.getElementsByName('nav')[0].checked){
            listRec.style.display = "flex";
            labelRec.style.color = "#ff0000";
            listFav.style.display ="none";
            labelFav.style.color = "#000"
        }else{
            listRec.style.display = "none";
            labelRec.style.color = "#000";
            listFav.style.display ="flex";
            labelFav.style.color = "#ff0000";
        }
    }
</script>
@endsection
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
            <input class="nav__input" type="radio" name="nav" id="rec" onclick="listChange()" checked="checked">
            <label class="nav__label" id="labelRec" for="rec">おすすめ</label>
            <input class="nav__input" type="radio" name="nav" id="fav" onclick="listChange()">
            <label class="nav__label" id="labelFav" for="fav">マイリスト</label>
        </form>
    </nav>
</div>
<div class="list-wrapper">
    <div class="list-content list-rec" id="listRec">
        @foreach($items as $item)
        <form class="list__element" action="/item/{{ $item->id}}" method="get">
            <button class="list__element-btn">
                <img class="list__element-img" src="{{ asset('storage/img/'. $item->item_img) }}" alt="item-img">
                <p class="list__element-price">¥{{ number_format($item->price) }}</p>
            </button>
        </form>
        @endforeach
    </div>

    <div class="list-content" id="listFav">
        @foreach($favorites as $item)
        <form class="list__element" action="/item/{{ $item->item->id}}" method="get">
            <button class="list__element-btn">
                <img class="list__element-img" src="{{ asset('storage/img/'. $item->item->item_img) }}" alt="item-img">
                <p class="list__element-price">¥{{ number_format($item->item->price) }}</p>
            </button>
        </form>
        @endforeach
    </div>
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
            labelFav.style.color = "#000";
        }else{
            listRec.style.display = "none";
            labelRec.style.color = "#000";
            listFav.style.display ="flex";
            labelFav.style.color = "#ff0000";
        }
    }
</script>
@endsection
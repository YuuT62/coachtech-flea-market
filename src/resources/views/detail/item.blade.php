@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('content')
<div class="detail-wrapper">
    @if(session('messages'))
    <div class="session">
        {{session('messages')}}
    </div>
    @endif
    @error('comment')
    <div class="session">
        {{ $message }}
    </div>
    @enderror
    <div class="detail__img">
        <img src="{{ asset($item->item_img) }}" alt="item-img">
    </div>
    <div class="detail-content">
        <div class="detail-header">
            <h1 class="detail-header__name">{{ $item->item_name }}</h1>
            <h2 class="detail-header__brand">{{ $item->brand_name }}</h2>
            <h2 class="detail-header__price">¥{{ $item->price }}</h2>
            <ul class="detail-header__list">
                @if(Auth::check())
                <li class="detail-header__item favorites">
                    @if (!$item->isFavoriteBy(Auth::user()))
                    <button class="detail-header__item-btn favorite-toggle" data-item-id="{{ $item->id }}" type="button">
                        <span class="material-symbols-outlined detail-header__item-btn--star">star</span>
                    </button>
                    <p class="detail-header__item-count favorite-counter">{{ $favorite_count }}</p>
                    @else
                    <button class="detail-header__item-btn favorite-toggle" data-item-id="{{ $item->id }}" type="button">
                        <span class="material-symbols-outlined detail-header__item-btn--star favorite-on">star</span>
                    </button>
                    <p class="detail-header__item-count favorite-counter">{{ $favorite_count }}</p>
                    @endif
                </li>
                @else
                <li class="detail-header__item">
                    <a class="detail-header__item-btn" href="/login">
                        <span class="material-symbols-outlined detail-header__item-btn--star">star</span>
                    </a>
                    <p class="detail-header__item-count">{{ $favorite_count }}</p>
                </li>
                @endif
                <li class="detail-header__item">
                    <button class="detail-header__item-btn" id="commentBtn" onclick="commentView()">
                        <span class="material-symbols-outlined detail-header__item-btn--comment">chat_bubble</span>
                    </button>
                    <p class="detail-header__item-count">{{ $comment_count }}</p>
                </li>
            </ul>
        </div>
        @if(Auth::check())
        <form class="detail-btn" action="/purchase/{{ $item->id }}" method="get" id="detailBtn">
            @isset($item->purchase)
            <button class="detail-btn__submit" type="button" style="background-color:#C0C0C0; border:3px solid #C0C0C0; pointer-events:none;" >SOLD OUT</button>
            @else
                @if($item->user_id === Auth::id())
                <button class="detail-btn__submit" type="button" style="background-color:#C0C0C0; border:3px solid #C0C0C0; pointer-events:none;" >購入不可</button>
                @else
                <button class="detail-btn__submit" type="submit">購入する</button>
                @endif
            @endisset
        </form>
        @else
        <form class="detail-btn" action="/login" method="get" id="detailBtn">
            @isset($item->purchase)
            <button class="detail-btn__submit" type="button" style="background-color:#C0C0C0; border:3px solid #C0C0C0; pointer-events:none;" >SOLD OUT</button>
            @else
                @if($item->user_id === Auth::id())
                <button class="detail-btn__submit" type="button" style="background-color:#C0C0C0; border:3px solid #C0C0C0; pointer-events:none;" >購入不可</button>
                @else
                <button class="detail-btn__submit" type="submit">購入する</button>
                @endif
            @endisset
        </form>
        @endif

        <div class="detail-info" id="detailInfo">
            <div class="detail-info-desc">
                <h3 class="detail-info-desc__header">商品説明</h3>
                <p class="detail-info-desc__content">{{ $item->description }}</p>
            </div>
            <div class="detail-info-about">
                <h3 class="detail-info-about__header">商品の情報</h3>
                <div class="detail-info-about-category">
                    <h4 class="detail-info-about-category__header">カテゴリー</h4>
                    <ul class="detail-info-about-category__list">
                        @foreach($item->categories as $categories)
                            <li class="detail-info-about-category__item">{{ $categories->category}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="detail-info-about-condition">
                    <h4 class="detail-info-about-condition__header">商品の状態</h4>
                    <p class="detail-info-about-condition__content">{{ $item->condition->condition }}</p>
                </div>
            </div>
        </div>
        <div class="detail-comments-wrapper" id="detailComment">
            <div class="detail-comments">
                @foreach($comments as $comment)
                <div class="detail-comment">
                    @if($comment->user_id === Auth::id())
                    <div class="detail-comment-icon my-comment">
                        <span class="detail-comment-icon__name">{{ $comment->user->name }}</span>
                        @empty($comment->user->user_icon)
                        <span class="material-symbols-outlined user-icon-default">
                        person
                        </span>
                        @else
                        <img class="detail-comment-icon__img"  src="{{ asset($comment->user->user_icon) }}" alt="icon-img">
                        @endempty
                    </div>
                    <div class="detail-comment-content">
                        <p>{{ $comment->comment }}</p>
                        <span>{{substr($comment->created_at, 0, -3)}}</span>
                        <form class="detail-comment-delete" action="/item/comment/delete" method="post">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <button class="detail-comment-delete__submit" type="submit">削除</button>
                        </form>
                    </div>
                    @else
                    <div class="detail-comment-icon other-comment">
                        @empty($comment->user->user_icon)
                        <span class="material-symbols-outlined user-icon-default">
                        person
                        </span>
                        @else
                        <img class="detail-comment-icon__img"  src="{{ asset($comment->user->user_icon) }}" alt="icon-img">
                        @endempty
                        <span class="detail-comment-icon__name">{{ $comment->user->name }}</span>
                    </div>
                    <div class="detail-comment-content">
                        <p>{{ $comment->comment }}</p>
                        <span>{{substr($comment->created_at, 0, -3)}}</span>
                        @can('admin')
                        <form class="detail-comment-delete" action="/item/comment/delete" method="post">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <button class="detail-comment-delete__submit" type="submit">削除</button>
                        </form>
                        @endcan
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            <form class="detail-comment-form detail-btn" action="/item/comment" method="post">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <label class="detail-comment-form__label" for="comment">商品へのコメント</label>
                <textarea class="detail-comment-form__text" name="comment" id="comment" rows="8"></textarea>
                <button class="detail-btn__submit" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>

<script>
    // コメントボタン
    const detailBtn = document.getElementById('detailBtn');
    const detailInfo = document.getElementById('detailInfo');
    const detailComment = document.getElementById('detailComment');
    detailComment.style.display="none";
    function commentView(){
        if(detailComment.style.display == "none"){
            detailBtn.style.display = "none";
            detailInfo.style.display = "none";
            detailComment.style.display = "block";
            $('.detail-header__item-btn--comment').toggleClass('comment-on');
        }else{
            detailBtn.style.display = "block";
            detailInfo.style.display = "block";
            detailComment.style.display = "none";
            $('.detail-header__item-btn--comment').toggleClass('comment-on');
        }
    }

    // いいねボタン
    $(function () {
        let favorite = $('.favorite-toggle');
        favorite.on('click', function () {
            let $this = $(this);
            let favoriteItemId = $this.data('item-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                url: '/favorite',
                method: 'POST',
                data: {
                    'item_id': favoriteItemId
                },
            })
            //通信成功した時の処理
            .done(function (data) {
            $('.detail-header__item-btn--star').toggleClass('favorite-on');
            $this.next('.favorite-counter').html(data.favorite_count);
            })
            // 通信失敗した時の処理
            .fail(function () {
            console.log('fail');
            });
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
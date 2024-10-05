@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
<link rel="stylesheet" href="{{ asset('css/management.css') }}">
@endsection

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('content')
<div class="management-header">
    <h1>管理画面</h1>
</div>
<div class="nav-wrapper">
    @if(session('messages'))
    <div class="session">
        {{session('messages')}}
    </div>
    @endif
    <nav class="nav-content">
        <div class="nav__form">
            <input class="nav__input" type="radio" name="nav" id="users" onclick="listChange()" checked="checked">
            <label class="nav__label" id="labelUsers" for="users">ユーザ一覧</label>
            <input class="nav__input" type="radio" name="nav" id="mail" onclick="listChange()">
            <label class="nav__label" id="labelMail" for="mail">メール送信フォーム</label>
        </div>
    </nav>
</div>
<div class="management-content">
    <div class="list-table-wrapper" id="listUsers">
        <table class="list-table">
            <tr class="list-table__row">
                <th class="list-table__header">ユーザID</th>
                <th class="list-table__header">ユーザ名</th>
                <th class="list-table__header">メールアドレス</th>
                <th class="list-table__header">登録日</th>
                <th class="list-table__header">削除</th>
            </tr>
            @foreach($users as $user)
            <tr class="list-table__row">
                <td class="list-table__desc">{{ $user->id }}</td>
                <td class="list-table__desc">{{ $user->name }}</td>
                <td class="list-table__desc">{{ $user->email }}</td>
                <td class="list-table__desc">{{ explode(' ', $user->created_at)[0] }}</td>
                <td class="list-table__desc">
                    <form class="list-table__btn" action="/user/delete" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button class="list-table__btn-submit" type='submit'>削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="list-content__paginate">
            {{ $users->links('vendor.pagination.default') }}
        </div>
    </div>

    <form class="form-mail" id="formMail" action="/email" method="post">
        @csrf
        <div class="form-mail__subject">
            <input class="form-mail__subject-input" type="text" name="subject" value="{{ old('subject') }}" placeholder="件名">
            <p class="form-mail__error">
            @error('subject')
                {{ $message }}
            @enderror
            </p>
        </div>
        <div class="form-mail__message">
            <textarea class="form-mail__message-input" name="message" rows="10" placeholder="本文">{{ old('message') }}</textarea>
            <p class="form-mail__error">
            @error('message')
                {{ $message }}
            @enderror
            </p>
        </div>
        <div class="form-mail__btn">
            <button class="form-mail__btn-submit" type="submit">送信</button>
        </div>
    </form>
</div>

<script>
    function listChange(){

        var listUsers = document.getElementById('listUsers');
        var labelUsers = document.getElementById('labelUsers');
        var formMail = document.getElementById('formMail');
        var labelMail = document.getElementById('labelMail');

        if(document.getElementsByName('nav')[0].checked){
            listUsers.style.display = "block";
            labelUsers.style.color = "#ff0000";
            formMail.style.display ="none";
            labelMail.style.color = "#000";
        }else{
            listUsers.style.display = "none";
            labelUsers.style.color = "#000";
            formMail.style.display ="block";
            labelMail.style.color = "#ff0000";
        }
    }
</script>
@endsection
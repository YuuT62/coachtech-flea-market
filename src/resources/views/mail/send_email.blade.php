<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coachtech</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/send_email.css') }}">
</head>
<body>
    <div class="email-content">
        <div class="email-content__header">
            <h1 class="email-content__header-text">Coachtechからのお知らせ</h1>
        </div>
        <div class="email-content__message">
            <p>{{ $data['message'] }}</p>
        </div>
        <div class="email-content__footer">
            <p>Rese</p>
        </div>
    </div>
</body>
</html>
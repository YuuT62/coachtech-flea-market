##coachtechフリマ

ある企業が開発した独自のフリマアプリ

![home](https://github.com/user-attachments/assets/680bf604-fa8b-4858-a7ab-569db32b6bc2)


##作成した目的

coachtechブランドのアイテムを出品する。(実践学習ターム)

#アプリケーションのURL

http://ec2-52-194-186-51.ap-northeast-1.compute.amazonaws.com/

※メール認証機能はAWSの「Amazon Simple Email Service」を使用しており、本稼働アクセスのリクエスト未実施（サンドボックス状態）のため、認証されたメールアドレス以外は登録できない状態です。

##機能一覧

・会員登録

・ログイン機能

・ログアウト機能

・商品一覧取得

・商品詳細取得

・商品お気に入り一覧取得

・ユーザー購入商品一覧取得

・ユーザ出品商品一覧取得

・プロフィール変更

・商品お気に入り追加

・商品お気に入り削除

・商品コメント追加

・商品コメント削除

・出品

・配送先変更機能

・商品購入機能

・支払い方法の選択・変更機能

・メール送信機能

・ユーザー毎の権限付与機能（管理者、利用者）

・管理画面（管理者のみ）

・決済機能（Stripeによる決済）


##使用技術

・ PHP 8.1

・ Laravel 8.83.27

・ MySQL 8.0.26


##テーブル設計

![table-1](https://github.com/user-attachments/assets/5b9e22e7-bd8e-4e0a-ba3c-d8c81e273287)
![table-2](https://github.com/user-attachments/assets/5c2dc31a-888c-4812-a487-06de70cc545a)
![table-3](https://github.com/user-attachments/assets/50549668-56c9-495b-8e49-54995c803979)
![table-4](https://github.com/user-attachments/assets/c0cbed9c-6b75-440b-961f-19de6daccb4f)


##ER図

![index](https://github.com/user-attachments/assets/3aec24fe-2733-4a7e-8d3b-025ca2bcaad0)


##環境構築

git clone git@github.com:YuuT62/coachtech-flea-market.git

cd coachtech-flea-market/

docker-compose up -d --build

*MySQLは、OSによって起動しない場合があるので、それぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。

##Laravel環境構築

docker-compose exec php bash

composer install

.env.exampleファイルから.envファイルを作成し、環境変数を変更

　12行目)　DB_HOST=mysql

　14行目)　DB_DATABASE=laravel_db

　15行目)　DB_USERNAME=laravel_user

　16行目)　DB_PASSWORD=laravel_pass

　32行目)　MAIL_HOST=mailcatcher

  37行目)　MAIL_FROM_ADDRESS=hoge@example.com

  58行目）STRIPE_KEY="（Stripeアカウントの公開可能キー）"

  59行目）STRIPE_SECRET="（Stripeアカウントのシークレットキー）"
  

php artisan key:generate

php artisan migrate

php artisan db:seed

php artisan storage:link

以下URLよりロゴをダウンロードし、logoフォルダ(内部にlogo.svgファイルがある)ごと"CoachtechFleaMarket/src/storage/app/public"に配置してください。

https://1drv.ms/f/c/397a6ae1e8c40085/EoMXPmsPguFMubw7shwMXUYBrzosX4DTUGbfXcrDPn_Qlw?e=xam4lQ

ダウンロードフォルダ

　・logo

配置先

　・CoachtechFleaMarket/src/storage/app/public

"CoachtechFleaMarket/src/storage/app/public"に以下のフォルダを作成してください。

　・item-img
 
　・user-icon

フォルダ配置、作成後の"CoachtechFleaMarket/src/storage/app/public"フォルダには、以下のフォルダがあることを確認してください。

  ・item-img
  
  ・logo
  
  ・user-icon


##mysql

　アクセスURL：http://localhost:8080/

##MailCatcher

　アクセスURL：http://localhost:1080/

　※テスト用のメール受取ボックス

※Windowsの場合、ファイル権限エラーでアクセスできないことがあるため、以下のコマンドで回避

sudo chmod -R 777 src/*

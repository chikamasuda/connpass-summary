# Connpass Summary

ConnpassAPIを活用したツールです。コンセプトは「自分が好きそうなイベントを逃さないためのConnpassAPI駆動ツール」です。IT勉強会支援プラットフォームConnpassの情報をConnpassAPIで取得し、人気急上昇イベントや参加人数50名以上の人気イベント、PHPイベントの情報をピックアップしてバッチ処理で自動更新しています。  

<img width="820" alt="スクリーンショット 2022-01-27 8 20 57" src="https://user-images.githubusercontent.com/66733811/151263547-a8f1ccec-fb99-4a38-96cd-61fd63a83601.png">

## 使い方
イベント情報に対して、検索・CSVダウンロード・お気に入りの登録・削除ができます。   
イベントタイトルのリンクから、IT勉強会支援プラットフォームConnpassの該当のイベント情報に遷移することができます。

## 作成した経緯

自分や周りにいるエンジニアが、Connpassで有益なイベントが開催されているがイベント情報のキャッチアップをするのが大変と感じていました。  
上記のような問題を解決するためにConnpassの情報をキャッチアップしやすくするツールを作成しました。  


## URL
https://connpass-summary.work/  


## 機能一覧
•外部API連携  
•バッチ処理  
•メール送信機能(お問い合わせフォーム)    
•お気に入り機能（登録・削除をAjaxによる非同期処理で実装)   
•イベント情報一覧表示    
•検索機能  
•CSVダウンロード機能

## 使用技術
### フロントエンド  
•HTML/CSS  
•JavaScript  
•Bootstrap 4.5.1  
•Vue.js 2.6.11  
•jQuery 3.6.0    

### バックエンド  
•PHP 7.4  
•Laravel 8.65  
•MySQL 8.0  

### サーバー  
•ConoHa VPS(CentOS8)  

### 開発環境  
•Docker(Laradock)  

### 外部API  
•Connpass API 

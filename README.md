# Connpass Summary

ConnpassAPIを活用したツールです。コンセプトは「自分が好きそうなイベントを逃さないためのAPI駆動ツール」です。  
IT勉強会支援プラットフォームConnpassの情報をConnpassAPIで取得し、  人気急上昇イベントや参加人数50名  
以上の人気イベント、PHPイベントの情報をピックアップしてバッチ処理で自動更新しています。  

<img width="800" alt="スクリーンショット 2022-01-26 21 17 36" src="https://user-images.githubusercontent.com/66733811/151169156-256c452a-5bcc-41a6-9940-abfa867db8ff.png">

## 使い方
イベント情報に対して、検索・CSVダウンロード・お気に入り登録ができます。   
イベントタイトルのリンクから、IT勉強会支援プラットフォームConnpassの該当のイベント情報に遷移すること  
ができます。

## 作成した経緯

自分や周りのエンジニアが、Connpassで有益なイベントが開催されているがキャッチアップするのが大変と感じていました。  
上記のような問題を解決するためにConnpassの情報をキャッチアップしやすくするツールを作成しました。  


## URL
https://connpass-summary.work/  


## 機能一覧
・外部API連携  
・バッチ処理  
・メール送信機能  
・お気に入り機能  
・検索機能  
・CSVダウンロード機能

## 使用技術
フロントエンド  
•HTML/CSS  
•JavaScript  
•Bootstrap
•Vue.js 2.6.12  
•jQuery 3.6.0  

バックエンド  
•PHP 7.4  
•Laravel 8.12  
•Mysql 8.0.23  

サーバー  
•ConoHa VPS(CentOS8)  

開発環境  
•Docker(Laradock)  

外部API  
•Connpass API 

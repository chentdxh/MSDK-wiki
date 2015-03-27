自動授権とtoken確認
===
##概説
 - プラットフォーム（モバイルQQ又はウィーチャット）の各種のトークンには有効期間があり、ユーザーはゲームを実行する毎に授権する必要がありません。前回に授権したtokenが有効期間にあれば、再び授権する必要がありません。Tokenが有効期間にあっても、他の設備で授権することで無効となることがあります。
 - MSDK 2.0.0バージョンから、WGLoginWithLocalInfoインターフェースを追加し、このインターフェースはtokenの有効性（有効・無効と期限切れを含む）の確認を実現し、確認結果はOnLoginNotifyインターフェースを通じてゲームにコールバックします。成功の場合、eFlag_Succ又はeFlag_WX_RefreshTokenSuccを戻し、直接にゲームを実行します。失敗の場合、eFlag_Local_Invalidを戻し、ユーザーに重授権を注意します。
- ゲームを実行する毎に(デスクトップからの起動、バックからフロントへの切替、プラットフォームにる実行)、WGLoginWithLocalInfoを呼び出し、トークン確認をするよう提案します。

- サンプルコード：
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
LoginRet ret;
ePlatform platform = (ePlatform)plat->WGLoginWithLocalInfo ();
```

- 2.4.0iバージョン以降は、delegate方式を利用できます。コードは次の通りです。
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *service = [[MSDKAuthService alloc] init];
[service loginWithLocalInfo];
```

##注意事項
 - msdk 2.0.0バージョンから、定時的に期限間近のウィーチャットtokenを更新します。更新の結果はOnLoginNotifyを通じてゲームにコールバックします。 [2.0.0i新規追加]
 -ゲーム実行及びバックからフロントへの切替は、このインターフェースを呼び出します。他の状況ではこれを呼び出さないでください。 [重要]


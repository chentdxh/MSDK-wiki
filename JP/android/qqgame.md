MSDKゲームホール接続モジュール
====================

# ゲームホール

現在、2つの状況でゲームをホールに接続します。

- 1つはホールのログイントークンがなく、ホールを通じてゲームを起動します。

- もう1つはホールからゲームを実行する同時に、ユーザーのホールでの登録状態を付けて、ゲームを実行します。この時、ホールのログイントークンでゲームのプレーヤーのログイントークンに取り替えます。

## 1、ログイントークンがなく、ホールを通じてゲームを起動します

ホールを通じてゲームを実行する場合、ホールのログイントークンを獲得する必要がありません。次の何れかの方法でホールの実行をマスクできます。
ゲームの`onCreate`と`onNewIntent`では次の方法でホールからゲームを実行したか判断します。「はい」の場合、`handleCallback`を呼び出しません。「いいえ」の場合、`handleCallback`を呼び出して、他のプラットフォームの実行を処理します。コードは次の通りです。

```
Intent intent = this.getIntent();
if (intent != null && intent.getExtras() != null) {
	Bundle b = intent.getExtras();
	Set<String> keys = b.keySet();
	if(keys.contains("KEY_START_FROM_HALL")){
    //実行のプラットフォームはホールです
	Logger.d("Wakeup Plantform is Hall");
} else {
	//実行のプラットフォームはホールではありません
	Logger.d("Wakeup Plantform is not Hall");
	WGPlatform.handleCallback(this.getIntent()); //プラットフォームのコールバックを受信します
}
```

## ログイン状態付きでゲーム実行

ゲームをQQゲームホールに接続するには、先ずゲームホールの入口を設定する必要があります(テンセント製品の対応窓口によって配置されます。 [配置システムのリンク](http://mqqgameadmin4dev.3gqq.com/web_mqqgame_admin/crud_db_cobra_hall/dbbeans/index.jsp)). 
ゲームホールの結合テスト過程ではテスト環境を利用するため、テストアカウント(テンセント製品の対応窓口によって申込み、テストアカウントの種類を通常テストアカウントに選択します。[テストアカウントの申込みリンク](http://ceshihao.ied.com)). オンライン運営をしてから、正式環境で利用する場合、テストアカウントを必要なく、ゲームホールを通じてログインできます。
**注意:** ゲームホールに接続する場合、ゲームホールで設定する時、認証の種類 (auth_type) を **オープンプラットフォームToken (16)**. に設定する必要があります。下図のようになります。 

![qqgame_1](./qqgame_1.jpg)

ゲームホールに接続するには、先ずゲームホールの入口を設定し、ゲームをゲームホールに設定して、ゲームホールの担当者に完成してもらう必要があります。ホールでゲームの入口を獲得してから、ホールからゲームを実行できます。ゲーム実行の時、SDKはゲームに必要なトークン(OpenId+accessToken+paytoken)を交換して、ローカルに保管します。ゲームは`OnWakeupNotify`を受信した後、受信した`WakeupRet`の`platform`フィールドでホールからの実行であるか判断でできます。ホールからの実行を確認してから、`WGGetLoginRecord`インターフェースを呼び出し、ローカルに保存されているログイントークンを読み込みます。これらのトークンを獲得すれば、ログインが完成します。

### 接続配置

ホール接続のゲームに対する配置用件

```
<!--ゲームホールに接続するアプリはこのintent-filterを追加できません  start-->
<intent-filter>
	<action android:name="android.intent.action.MAIN" />
	<category android:name="android.intent.category.LAUNCHER" />
	</intent-filter>
<!-- ゲームホールに接続するアプリはこのintent-filterを追加できません  end -->

```

入口Activity(対応のMSDKSampleの`MainActivity`)のintent-filterを設定します

```
<!--入口Activityにはこのintent-filter startを追加します start -->
<intent-filter>
	<!-- xxxxx開発者のアプリ名を正しく記入しなければなりません。でないと起動できないおそれがあります。-->
    <action android:name="xxxxx" /> 
    <category android:name="android.intent.category.DEFAULT" />
</intent-filter>
<!--入口Activityにはこのintent-filter startを追加します end -->
```

AndroidManifest.xmlの<application>タブには次のような 内容を追加します。

```
<!-- ホール接続のゲームは、このmeta-dataを設定しなければなりません start -->
<meta-data
    android:name="QQGameHallMark"
    android:value="QQGameHallMark" />
<meta-data
    android:name="QQGameHallAuthorVer"
	android:value="10000" />
<!-- ホール接続のゲームは、このmeta-dataを設定しなければなりません end -->
```

`QQGameHallAuthorVer`の10000は、ホール・プラットフォームでの接続するアプリのバージョン番号で、バージョン更新に用いられます。ホールでバージョンが更新する毎にこの値に1をプラスします。初期値を10000に設定し、ホールでバージョン更新に用いられます。この値は`android:versionCode`と競合がなく、一致しなくてもいいですが、新しいバージョンを提出する毎に`android:versionCode`と`QQGameHallAuthorVer`の値は同時に1をプラスします。

**注意:** 

1. ゲームホールに接続するには、homeキーを長押しても自分のアプリのアイコンが出現しないことを保証しなければなりません。そのため、androidManifest.xmlファイルにあるActivityの`android:launchMode`を全てデフォルト値に設定し(即ち設定しないこと)、又はsingleTopに設定しなければなりません。`singleTask`又は`singleInstance`に設定できません。

2. ゲームでhomeキーを押してホームに戻り、homeキーを長押し、ゲームホールのアイコンをクリックしてホール画面が表示する場合 (一般的に、ゲームからhomeキーを押すとゲームに戻るべきです)、androidManifest.xmlファイルにはtrueとなるa`ndroid:excludeFromRecents`があるか検査してください。ある場合、それを削除しなければなりません。また、`android:allowTaskReparenting`, `android:alwaysRetainTaskState`のあるものを削除する必要があります。 



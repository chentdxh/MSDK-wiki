Android 接続
=======

## パッケージ構造の説明

MSDKのリリースパッケージ(zip)には、主に`MSDKLibrary`と`MSDKSample`の2部分があり、前者はMSDKライブラリーで、後者はMSDKインターフェースの使用例です。MSDKLibrary/jni/CommonFiles/WGPlatform.hのパッケージには全てのインターフェース説明があり(javaとC++のインターフェースは一対一です)、このファイルでインターフェースの説明を見ることができます。

`launchActivity`(ゲームを実行すると、初めてのActivity)のみでMSDKの初期化を行い、MSDKインターフェースの呼び出しを処理することを`推奨`します。複数のActivityでMSDKインターフェースの呼び出しを処理すると、ウィーチャット接続の時に、コールバック無のログインのエラーが発生します。

## Step1: MSDKパッケージの導入

### Android Library Projectを利用するゲームの場合

Eclipseでは`MSDKLibrary`項を導入し、ゲーム項を右クリック->属性->Android-> (ライブラリー) の追加-> MSDKLibraryを選択して、MSDKLibraryの導入を完成します。

### Android Library Projectのゲームを利用できません

#### java接続

Android Library Projectのゲームを利用できません。MSDKLibraryのlibs，resの2つのディレクトリーをゲームのエンジニアリング・ディレクトリーに複製する必要があります。

#### C++接続

Android Library Projectのゲームを利用できません。MSDKLibraryのlibs，resディレクトリーをゲームのエンジニアリング・ディレクトリーに複製し、またjniディレクトリーにある .cpp 及び .h フォルダをゲーム・エンジニアリングに複製し、Android.mkに追加する必要があります。

**注意事項：**

1. `MSDKLibrary`を導入した後、コンバイルでパッケージ競合(重複)が発生することがあります。MSDKにはウィーチャットSDK(`libammsdk.jar`)，QQ相互接続sdk(`open_sdk.jar`)，MTA(`mta-xxx.jar`)，ライトハウスSDK(`beacon-xxx.jar`) を含んでおり、これらsdkは最新版で安定していますから、ゲームは単独でこれらSDKを統合した場合、従来統合したjarパッケージを削除してください。
2. MSDKSample/assets/msdkconfig.ini はMSDKのコンフィグレーションファイルであり、環境の選択、それぞれの機能モジュールの配置などを含み、ゲームエンジニアリングにをコピーし、必要に応じて変更して利用できます。

## Step2: 配置の説明

### 権限配置

	<!-- TODO SDK接続は権限モジュールがなければなりません。 START -->
	<uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
	<uses-permission android:name="android.permission.ACCESS_WIFI_STATE" />
	<uses-permission android:name="android.permission.ACCESS_FINE_LOCATION" />
	<uses-permission android:name="android.permission.CHANGE_WIFI_STATE" />
	<uses-permission android:name="android.permission.GET_TASKS" />
	<uses-permission android:name="android.permission.INTERNET" />
	<uses-permission android:name="android.permission.MOUNT_UNMOUNT_FILESYSTEMS" />
	<uses-permission android:name="android.permission.READ_PHONE_STATE" />
	<uses-permission android:name="android.permission.RESTART_PACKAGES" />
	<uses-permission android:name="android.permission.SYSTEM_ALERT_WINDOW" />
	<uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE" />

	<!-- ログイン時、機器名を付けて送信し、ブルーティースモジュールで機器名を取得します -->
    <uses-permission android:name="android.permission.BLUETOOTH" />
    <uses-permission android:name="android.permission.BLUETOOTH_ADMIN" />
	<!-- TODO SDK接続は権限モジュールがなければなりません。END -->

### コンフィグレーションファイルの変更

assets/msdkconfig.ini には、アクセスするMSDKバックグラウンド環境(テスト環境/正式環境)が配置されています。結合テスト段階ではゲームはテスト環境を利用しますが、リリース時に正式環境(公司内测，公测，正式上线)に切り替える必要があります。環境を切り替える時、バックグラウンドを同時に対応の環境に切り替える必要があります。ここでフロントエンドからMSDKバックグラウンドのテスト環境にアクセスすることを配置します。

	;自作ゲーム又は精品代理ゲームの場合、このグループのドメインの何れかを利用してください。
	; msdktestのあるものはテスト環境のドメインで、msdkのあるものは正式環境のドメインです。
	;MSDK_URL=http://msdk.qq.com
	MSDK_URL=http://msdktest.qq.com
	
**PS:**テスト環境でゲームを運営することを防止するために、SDKではテスト環境又は開発環境を検出した時、**「You are using http://msdktest.qq.com」**のようなメッセージをToastさせ、ゲームは正式環境のドメインに切り替えると、これらのメッセージは自動的に消えます。.

## Step3: MSDK初期化

MSDK初期化をしてからこそ、SDKの機能を実行できます。ゲームを実行する時、MainActivityのonCreateメソッドから、MSDK初期化関数`WGPlatform.Initialized`を呼び出し、MSDKを初期化させます。
例えば

	public void onCreate(Bundle savedInstanceState) {
		...
		//ゲームは自分のQQ AppIdで結合テストを行います
		baseInfo.qqAppId = "1007033***";
		baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

		//ゲームは自分のウィーチャットAppIdで結合テストを行います
		baseInfo.wxAppId = "wxcde873f99466f***"; 
		baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

		//ゲームは自分の支払offerIdで結合テストを行います
		baseInfo.offerId = "100703***";
		WGPlatform.Initialized(this, baseInfo);

		// Initializedの後にhandleCallbackすることを保証します
		// launchActivityのonCreat()とonNewIntent()では
        // WGPlatform.handleCallback()を呼び出さなければなりません。でないとウィーチャットのコールバック無のログインをもたらします
		WGPlatform.handleCallback(getIntent());
		...
	}

    protected void onPause() {
        super.onPause();
        WGPlatform.onPause();
    }

    protected void onResume() {
        super.onResume();
        WGPlatform.onResume();
    }

    protected void onDestroy() {
        super.onDestroy();
        WGPlatform.onDestory(this);
    }

    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        WGPlatform.handleCallback(intent);
    }


また、MSDK2.5以前のバージョンの場合、MainActivtyではRQDのダイナミックライブラリーをロードする必要があります。サンプルコードは次の通りです。

	// TODO GAME は必要なダイナミックライブラリーをロードします
    static {
        System.loadLibrary("NativeRQD"); // ゲームはこのダイナミックライブラリーをロードし、データ報告に利用します
        System.loadLibrary("WeGameSample"); // MSDKDemoに必要なもので、ゲームはこれを必要としません
    }

**注意：**

* MSDK2.5以降ではRQDをBuglyに変更しています。2.5以降のバージョンに接続する時、ゲーム従来のエンジニアリングのlibsフォルダにある`libNativeRQD.so`を削除してください。「NativeRQD"ダイナミックライブラリーをロードする必要がありません。


**C++類ゲームは、MainActivityのonCreateメソッドでSDK初期化の他、**`JNI_OnLoad`**ではSDK関連の内容を初期化する必要があります。**
WGで開始するインターフェースはC++層及びJava層インターフェースを提供しています。Java層は`WGPlatform`で呼び出され, C++層は`WGPlatform::GetInstance()`で呼び出されます。呼び出し方式は jni/PlatformTest.cppを参照してください。

    GlobalCallback g_Test;
    JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
        WGPlatform::GetInstance()->init(vm);// C++層のSDK初期化
        WGPlatform::GetInstance()->WGSetObserver(&g_Test);
        return JNI_VERSION_1_4;
    }

	
#### **注意：**

**ゲームは`launchActivity`の`onCreat`と`onNewIntent`で`WGPlatform.handleCallback()`を呼び出さなければなりません。でないと、ゲームは一部のシーンでコールバックを受信できないことがあります。**
  
## Step4:グローバルコールバックの設定

MSDKは`WGPlatformObserver`抽象クラスのメソッドで授権、共有又は検索結果をゲームにコールバックします。ゲームはコールバックの結果によりUIなどを調整します。コールバックを設定してからこそ、ゲームはMSDKの反応を受信できます。
Java コールバックの設定：

	WGPlatform.WGSetObserver(new WGPlatformObserver() {
		@Override
		public void OnWakeupNotify(WakeupRet ret) { }
		@Override
		public void OnShareNotify(ShareRet ret) { }
		@Override
		public void OnRelationNotify(RelationRet relationRet) { }
		@Override
		public void OnLoginNotify(LoginRet ret) { }
	});

C++ コールバックの設定(**Java層のコールバックを設定した場合、Java層のコールバックが優先的に呼び出されます。C++層のコールバックを利用する場合、Java層のコールバックを設定できません**)：

	class GlobalCallback: public WGPlatformObserver {
	public:
	    virtual void OnLoginNotify(LoginRet& loginRet) { }
	    virtual void OnShareNotify(ShareRet& shareRet) { }
	    virtual void OnWakeupNotify(WakeupRet& wakeupRet) { }
	    virtual void OnRelationNotify(RelationRet& relationRet) { }
	    virtual ~GlobalCallback() { }
	};
	GlobalCallback g_Test;

	JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
		// C++層の初期化です。ゲームのマスタActivityのonCreateの前に呼び出されます
		WGPlatform::GetInstance()->init(vm);
		WGPlatform::GetInstance()->WGSetObserver(&g_Test);
		return JNI_VERSION_1_4;
	}

**注意：**
ゲームはC++ APIを利用する場合、** Java層のグローバルコールバック**を設定しないでください。SDKはJava層のコールバックを優先に呼び出し、C++層のコールバックを無視します。また、MSDKのコールバックはUIスレッドで行われるため、開発者は自分でスレッドの安全を確保する必要があります。
	
これにより、MSDKパッケージ接続と初期化が完成しました。ゲームは各モジュールの機能を利用する場合、相応モジュールの接続配置とインターフェース説明をご覧になってください。


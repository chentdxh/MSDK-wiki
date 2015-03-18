MSDK 基礎工具類
======

モバイルQQ/ウィーチャットの有無の検査
------
WGIsPlatformInstalledインターフェースを呼び出し、検査対象プラットフォームの有無を戻します。インターフェースの詳細は次の通りです。
#### インターフェース声明：

	/**
	 * @param platformType ゲームが伝えたプラットフォーム種類で、可能な値は: ePlatform_QQ, ePlatform_Weixinです
	 * @return プラットフォームの対応状況。Falseはプラットフォームの未インストールを示し、trueはインストール済みを示します。
	 */
	bool WGIsPlatformInstalled(ePlatform platformType);

#### インターフェースの呼び出し：

インターフェース呼び出しのサンプル：

	WGPlatform::GetInstance()->WGIsPlatformInstalled((ePlatform) platform);


モバイルQQ/ウィーチャットバージョンの取得
------
WGGetPlatformAPPVersionインターフェースを呼び出し、現在プラットフォームのバージョンを戻します。インターフェース詳細説明は次の通りです。
#### インターフェース声明：

	/**
	 * @return APPバージョン番号
	 */
	const std::string WGGetPlatformAPPVersion(ePlatform platform);

#### インターフェースの呼び出し：

インターフェース呼び出しのサンプル：

	WGPlatform::GetInstance()->WGGetPlatformAPPVersion((ePlatform) Platform);

ユーザーのモバイルQQ/ウィーチャットのインターフェース対応の検査
------
WGCheckApiSupportインターフェースを呼び出し、指定種類の現在有効な公告データリストを戻します。インターフェース詳細説明は次の通りです。
#### インターフェース声明：

	/**
	 * @return インターフェースの対応状況
	 * @param
	 * eApiName_WGSendToQQWithPhoto = 0,
	 * eApiName_WGJoinQQGroup = 1,
	 * eApiName_WGAddGameFriendToQQ = 2,
	 * eApiName_WGBindQQGroup = 3
	 */
	bool WGCheckApiSupport(eApiName);

#### インターフェースの呼び出し：

インターフェース呼び出しのサンプル：

	WGPlatform::GetInstance()->WGCheckApiSupport((eApiName) jApiName);

MSDKバージョンの取得
------
WGGetVersionインターフェースを呼び出し、MSDKのバージョン番号を戻します。インターフェース詳細説明は次の通りです。
#### インターフェース声明：

	/**
	 * MSDKバージョン番号を戻します
	 * @return MSDKバージョン番号
	 */
    const std::string WGGetVersion();

#### インターフェースの呼び出し：

インターフェース呼び出しのサンプル：

	WGPlatform::GetInstance()->WGGetVersion();

インストールチャンネルの取得
----------

WGGetChannelIdを呼び出し、ゲームのインストールチャンネルを戻します。インターフェース詳細説明は次の通りです。
#### インターフェース声明：

	/**
	 * @return インストールチャンネル
	 */
	const std::string WGGetChannelId();

#### インターフェースの呼び出し：

インターフェース呼び出しのサンプル：

	WGPlatform::GetInstance()->WGGetChannelId();

登録チャンネルの取得
----------

WGGetRegisterChannelIdを呼び出し、ユーザーの登録チャンネルを戻します。インターフェース詳細説明は次の通りです。
#### インターフェース声明：

	/**
	 * @return 登録チャンネル
	 */
	const std::string WGGetRegisterChannelId();

####インターフェースの呼び出し：

インターフェース呼び出しのサンプル：

	WGPlatform::GetInstance()->WGGetRegisterChannelId();

ローカルログ
------

#### 1、概説
このモジュールは2.0.0バージョン以降に提供されます。ゲームはスイッチでMSDK関連のLogの印刷を制御できます。
#### 2、配置方式
デフォルトではローカルログ・モジュールはオフとなっています。このモジュールを利用するゲームは、assets/msdkconfig.iniではlocalLogの値を要求に従って対応の値に設定する必要があります。

| スイッチ数値 | Log方式|
|: ------- :|: ------- :|
| 0 | 印刷しない|
| 1 | logcat印刷 |
| 2 |ローカルファイルに印刷します。Logcatで印刷しません |
| 3 | logcatとローカルファイルに同時に印刷します |	


# MSDK Android 定数

## プラットフォームの種類ePlatform

	typedef enum _ePlatform
	{
	ePlatform_None,
	ePlatform_Weixin,		//ウィーチャット・プラットフォーム
	ePlatform_QQ			//モバイルQQプラットフォーム
	}ePlatform;

## コールバック標識eFlag

### モバイルQQ関連：
	
|リターンコード|名称|記述|推奨処理|
|: ------- :|: ------- :|: ------- :|: ------- :|
|1000|eFlag_QQ_NoAcessToken|モバイルQQのログインに失敗し、accesstokenを取得できません|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|
|1001|eFlag_QQ_UserCancel|プレイヤーがモバイルQQの授権ログインをキャンセルしました|ログイン画面に戻り、プレイヤーがモバイルQQの授権ログインをキャンセルしたことを通知します|
|1002|eFlag_QQ_LoginFail|モバイルQQログインに失敗しました|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|
|1003|eFlag_QQ_NetworkErr|ネットワークエラー|再試行|
|1004|eFlag_QQ_NotInstall|プレイヤーの機器にはモバイルQQのクライアントをインストールしていません|プレイヤーのモバイルQQクライアントのインストールを案内します|
|1005|eFlag_QQ_NotSupportApi|プレイヤーモバイルQQクライアントはこのインターフェースに対応しません|プレイヤーのモバイルQQクライアントのアップグレードを案内します|
|1006|eFlag_QQ_AccessTokenExpired|accesstoken期間切れ|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|
|1007|eFlag_QQ_PayTokenExpired|paytoken期間切れ|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|

### ウィーチャット関連：

|リターンコード|名称|記述|推奨処理|
|: ------- :|: ------- :|: ------- :|: ------- :|
|2000|eFlag_WX_NotInstall|プレイヤー機器にはウィーチャットのクライアントをインストールしていません|プレイヤーのウィーチャットクライアントのインストールを案内します
|2001|eFlag_WX_NotSupportApi|プレイヤーのウィーチャットクライアントはこのインターフェースに対応しません|プレイヤーのウィーチャットクライアントのアップグレードを案内します|
|2002|eFlag_WX_UserCancel|プレイヤーがウィーチャットの授権ログインをキャンセルしました|ログイン画面に戻り、プレイヤーがウィーチャットの授権ログインをキャンセルしたことを通知します|
|2003|eFlag_WX_UserDeny|プレイヤーがウィーチャットの授権ログインを拒絶しました|ログイン画面に戻り、プレイヤーがウィーチャットの授権ログインを拒絶したことを通知します|
|2004|eFlag_WX_LoginFail|ウィーチャットのログインに失敗しました|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|
|2005|eFlag_WX_RefreshTokenSucc|ウィーチャットのトークン更新に成功しました|ウィーチャットのトークンを取得し、ログインしてゲームに入ります|
|2006|eFlag_WX_RefreshTokenFail|ウィーチャットのトークン更新に失敗しました|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|
|2007|eFlag_WX_AccessTokenExpired|ウィーチャットaccessToken期間切れ|refreshtokenでトークンの更新を試みます|
|2008|eFlag_WX_RefreshTokenExpired|ウィーチャットrefreshtoken期間切れ|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|

### 別アカウント関連：

|リターンコード|名称|記述|推奨処理|
|: ------- :|: ------- :|: ------- :|: ------- :|
|3001|eFlag_NeedLogin|ゲームのローカルアカウントも実行アカウントもログインできません|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|
|3002|eFlag_UrlLogin|別アカウントがなく、ゲームは実行アカウントでログインに成功しました|LoginRet構造体のトークンを読み込み、ゲームの授権プロセスを実行します|
|3003|eFlag_NeedSelectAccount|ゲームのローカルアカウントと実行アカウントには別アカウントがあります|ダイアログボックスをポップアップさせ、ユーザーにログインするアカウントを選択させます|
|3004|eFlag_AccountRefresh|別アカウントがなく、MSDKは更新インターフェースを通じてローカルアカウントのトークンを更新しました|LoginRet構造体のトークンを読み込み、ゲームの授権プロセスを実行します|

### その他

|リターンコード|名称|記述|推奨処理|
|: ------- :|: ------- :|: ------- :|: ------- :|
|0|eFlag_Succ|成功|インターフェースの成功ロジックで処理します|
|-1|eFlag_Error|エラー|インターフェースのデフォルトのエラー処理で処理します|
|-2|eFlag_Local_Invalid|アカウントの自動ログインに失敗しました。ローカルトークンの期間切れ、更新失敗など全てのエラーを含みます|ログイン画面に戻り、プレイヤーの再ログインと授権を案内します|
|-3|eFlag_NotInWhiteList|プレイヤーのアカウントはホワイトリストにありません|プレイヤーにアカウントのないというメッセージを表示させ、プレイヤーを応用宝に案内させ、アカウントの登録をします|
|-4|eFlag_LbsNeedOpenLocationService|ゲームに必要な測位サービスを起動していません|ユーザーの測位サービスの起動を案内します|
|-5|eFlag_LbsLocateFail|ゲームの測位に失敗しました|プレイヤーに測位失敗し、再試行するというメッセージを表示します|
	
## 各種の構造体

### eTokenType

	typedef enum _eTokenType
	{
		eToken_QQ_Access = 1,    //モバイルQQ accesstoken
		eToken_QQ_Pay,          //モバイルQQ paytoken
		eToken_WX_Access,       //ウィーチャット accesstoken
		eToken_WX_Code,        //ゲームはこれを考慮する必要がありません
		eToken_WX_Refresh,      //ウィーチャットrefreshtoken
	}eTokenType;



|プラットフォーム|token種類|token役割|type|有効期間|
|: ------- :|: ------- :|: ------- :|: ------- :|: ------- :|: ------- :|
|モバイルQQ	|accesstoken|モバイルQQ個人、友達、関係チェーン、共有など機能の検索|eToken_QQ_Access|	90日|
|モバイルQQ	|paytoken	|支払関連|eToken_QQ_Pay|	6日|
|ウィーチャット|	accesstoken|ウィーチャットの個人、友達、関係チェーン、共有、支払などの検索|	eToken_WX_Access|	2時間|
|ウィーチャット|refreshtoken|	accesstokenの更新|	eToken_WX_Refresh|	30日|

### TokenRet
MSDK serverはトークンでゲームユーザーの身分を確認します。TokenRet構造定義の説明は次の通りです。

		typedef struct {
	 		int type; //トークンの種類  eTokenTypeの種類
	 		std::string value; //トークンのvalue
	 		long long expiration; //トークンの期間切れ後の時間（ゲームはこれを考慮する必要がありません）
		}TokenRet;

### LoginRet
ユーザーの授権後、アカウント情報はこの構造に保存されております。LoginRet定義は次の通りです。

		typedef struct loginRet_ {
			int flag;               //戻り標識。授権又は更新の成功・失敗を示すeFlag種類
			std::string desc;       //戻りの記述
			int platform;           //現在授権するプラットフォーム、ePlatformの種類
			std::string open_id;     //ユーザーアカウントの唯一標識
			std::vector<TokenRet> token;     //トークンを記憶するアレイ
			std::string user_id;    //ユーザーID。ウィーチャットと打ち合わせるために、予約としています。
			std::string pf;        //支払に利用します。    WGGetPf()の呼び出しで取得します。
			std::string pf_key;    //支払に利用します。     WGGetPfKey()の呼び出しで取得します。
			loginRet_ ():flag(-1),platform(0){}; //構造メソッド
		}LoginRet;
                                    	
### ShareRet
共有の結果情報はこの構造に保存されています。ShareRet定義は次の通りです。

		typedef struct{
			int platform;           //プラットフォームの種類   ePlatform種類
			int flag;            //操作結果      eFlag種類
			std::string desc;       //結果の記述（保留）
    		std::string extInfo;   //ゲーム共有の時に伝送された自己定義の文字列であり、共有を標識します。
		}ShareRet;
	
### WakeupRet
プラットフォームによるゲーム実行の情報はこの構造に保存されております。WakeupRet 構造の定義は次の通りです。

		typedef struct{
			int flag;                //エラーコード   eFlagの種類
			int platform;               //どのプラットフォームで実行されますか。  ePlatform種類
			std::string media_tag_name; //wxからコールバックされたmeidaTagName
			std::string open_id;        //プラットフォームの授権アカウントのopenid
			std::string desc;           //記述

			std::string lang;          //言語     現在ウィーチャット5.1以上のみで使用します。モバイルQQはこれを利用しません。
			std::string country;       //国     現在ウィーチャット5.1以上のみで使用します。モバイルQQはこれを利用しません。
			std::string messageExt; //ゲーム共有で伝送された自己定義の文字列です。プラットフォームではゲームを実行してから、何れの処理もせずに戻ります。現在ウィーチャット5.1以上のみで使用します。モバイルQQはこれを利用しません。
		}WakeupRet;

### PersonInfo
検索の結果、１人の友達又は個人情報はこの構造に保存され、PersonInfo定義は次の通りです。

		typedef struct {
    		std::string nickName;  //ニックネーム
    		std::string openId;    //アカウントの唯一の標識
    		std::string gender;    //性別
    		std::string pictureSmall;     //小さい顔写真
    		std::string pictureMiddle;    //中間サイズ顔写真
    		std::string pictureLarge;     //datouxiang
    		std::string provice;          //省
    		std::string city;           //都市
		}PersonInfo;
### RelationRet
検索結果はこの構造に保存され、RelationRet定義は次の通りです。

		typedef struct {
    		int flag;     //検索結果flagで、0は成功
    		std::string desc;    // 記述
    		std::vector<PersonInfo> persons;//友達又は個人情報を保存します
		}RelationRet;


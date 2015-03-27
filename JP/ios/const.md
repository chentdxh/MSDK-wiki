定数検索
---

1. プラットフォームの種類ePlatform

		typedef enum _ePlatform
		{
            ePlatform_None,
            ePlatform_Weixin,		//ウィーチャット・プラットフォーム
            ePlatform_QQ,			//モバイルQQプラットフォーム
            ePlatform_Guest = 5     //ゲスト
		}ePlatform;

2. コールバック標識eFlag

        typedef enum _eFlag
        {
            eFlag_Succ              = 0,
            eFlag_QQ_NoAcessToken   = 1000,     //QQ&QZone login fail and can't get accesstoken
            eFlag_QQ_UserCancel     = 1001,     //QQ&QZone user has cancelled login process (tencentDidNotLogin)
            eFlag_QQ_LoginFail      = 1002,     //QQ&QZone login fail (tencentDidNotLogin)
            eFlag_QQ_NetworkErr     = 1003,     //QQ&QZone networkErr
            eFlag_QQ_NotInstall     = 1004,     //QQ is not install
            eFlag_QQ_NotSupportApi  = 1005,     //QQ don't support open api
            eFlag_QQ_AccessTokenExpired = 1006, // QQ Actoken無効となり、再ログインを必要とします
            eFlag_QQ_PayTokenExpired = 1007,    // QQ Pay token期間切れ
            eFlag_QQ_UnRegistered = 1008,    // qqで登録していません
            eFlag_QQ_MessageTypeErr = 1009,    // QQメッセージのタイプエラー
            eFlag_QQ_MessageContentEmpty = 1010,    // QQメッセージは空白です
            eFlag_QQ_MessageContentErr = 1011,     // 利用不可のQQメッセージ（長すぎるか他の原因）
            eFlag_WX_NotInstall     = 2000,     //Weixin is not installed
            eFlag_WX_NotSupportApi  = 2001,     //Weixin don't support api
            eFlag_WX_UserCancel     = 2002,     //Weixin user has cancelled
            eFlag_WX_UserDeny       = 2003,     //Weixin User has deny
            eFlag_WX_LoginFail      = 2004,     //Weixin login fail
            eFlag_WX_RefreshTokenSucc = 2005, // Weixin のトークン更新に成功しました
            eFlag_WX_RefreshTokenFail = 2006, // Weixin のトークン更新に失敗しました
            eFlag_WX_AccessTokenExpired = 2007, // Weixin AccessTokenが無効となり、refreshTokenでトークン交換を試みます。
            eFlag_WX_RefreshTokenExpired = 2008, // Weixin refresh token 期間切れ、再授権を必要とします
            eFlag_Error				= -1,
            eFlag_Local_Invalid = -2, // ローカルトークンが無効となり、ゲームはログイン画面で再授権する必要があります
            eFlag_LbsNeedOpenLocationService = -4, //ユーザーに測位サービスの起動を案内します
            eFlag_LbsLocateFail = -5, // 測位に失敗しました
            eFlag_UrlTooLong = -6,     // for WGOpenUrl
            eFlag_NeedLogin = 3001,     //ログインページに入る必要があります
            eFlag_UrlLogin = 3002,    //URLでログインできました
            eFlag_NeedSelectAccount = 3003, //別アカウントのメッセージをポップアップする必要があります。
            eFlag_AccountRefresh = 3004, //URLでトークンを更新します
            eFlag_InvalidOnGuest = -7, //この機能はGuestモードでは利用できません。
            eFlag_Guest_AccessTokenInvalid = 4001, //Guestのトークンが無効です
            eFlag_Guest_LoginFailed = 4002,  //Guestモードでログインに失敗しました
            eFlag_Guest_RegisterFailed = 4003  //Guestモードで登録に失敗しました
        }eFlag;


3.トークン種類eTokenType

		typedef enum _eTokenType
		{
			eToken_QQ_Access = 1,    //モバイルQQ accesstoken
			eToken_QQ_Pay,          //モバイルQQ paytoken
			eToken_WX_Access,       //ウィーチャット accesstoken
			eToken_WX_Code,        //ウィーチャットcode、既に廃棄されました
			eToken_WX_Refresh,      //ウィーチャットrefreshtoken
            eToken_Guest_Access     // Guestモードでのトークン
		}eTokenType;
||プラットフォーム	token種類||	token役割||	token ||type	||有効期間||
	
		モバイルQQ	accesstoken	モバイルQQ個人、友達、関係チェーン、共有などの機能の検索	eToken_QQ_Access	90日
		paytoken	支払関連	eToken_QQ_Pay	2日
		ウィーチャット	accesstoken	ウィーチャット個人、友達、関係チェーン、共有、支払などの検索	eToken_WX_Access	2時間
		refreshtoken	accesstokenの更新	eToken_WX_Refresh	30日

4. TokenRet トークンstructure
MSDK serverはトークンでゲームユーザーの身分を確認します。TokenRet構造定義の説明は次の通りです。

		typedef struct {
	 		int type; //トークンの種類  eTokenTypeの種類
	 		std::string value; //トークンのvalue
	 		long long expiration; //トークンの期間切れ時間（ゲームはこれを考慮する必要がありません）
		}TokenRet;

5. LoginRet アカウントstructure
ユーザーの授権後、アカウント情報はこの構造に保存されております。LoginRet定義は次の通りです。

		typedef struct loginRet_ {
			int flag;               //戻り標識。授権又は更新の成功・失敗を示すeFlag種類
			std::string desc;       //戻りの記述
			int platform;           //現在授権するプラットフォーム、ePlatformの種類
			std::string open_id;     //ユーザーアカウントの唯一標識
			std::vector<TokenRet> token;     //トークンを記憶するアレイ
			std::string user_id;    //ユーザーID。ウィーチャットと打ち合わせるために、予約としています。
			std::string pf;        //支払に利用します。    WGGetPf()の呼び出しで取得します
			std::string pf_key;    //支払に利用します。     WGGetPfKey()の呼び出しで取得します
			loginRet_ ():flag(-1),platform(0){}; //構造メソッド
		}LoginRet;
                                    	
6. ShareRet 共有結果structure
共有結果情報はこの構造に保存されています。ShareRet定義は次の通りです。

		typedef struct{
			int platform;           //プラットフォームの種類   ePlatform種類
			int flag;            //操作結果      eFlag種類
			std::string desc;       //結果の記述（保留）
    		std::string extInfo;   //ゲーム共有の時に伝送された自己定義の文字列であり、共有を標識します。
		}ShareRet;
	
7. WakeupRet 実行structure
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
            std::vector<KVPair> extInfo;  //ゲーム－プラットフォームの自己定義パラメータであり、モバイルQQ専用です。
		}WakeupRet;

8. PersonInfo 個人情報structure
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
            bool        isFriend;         //友達か否か
            int         distance;         //今回の測位場所からの距離
            std::string lang;             //言語
            std::string country;          //国
            std::string gpsCity;          // GPS情報で取得した都市
		}PersonInfo;

9. RelationRet 検索結果structure
検索結果はこの構造に保存され、RelationRet定義は次の通りです。

		typedef struct {
    		int flag;     //検索結果flagで、0は成功
    		std::string desc;    // 記述
    		std::vector<PersonInfo> persons;//友達又は個人情報を保存します
            std::string extInfo; //ゲーム検索の時に伝送された自己定義フィールドであり、検索を標識します
		}RelationRet;

10. ADRet 広告structure
ADRet定義は次の通りです。
        typedef struct
        {
            std::string viewTag;   //Buttonクリックのtag
            _eADType scene;   //一時停止箇所か終了箇所かを示します
        } ADRet;

11. AddressInfo アドレス情報structure
LBSアドレス情報はこの構造に保存されており、AddressInfo定義は次の通りです。

        typedef struct
        {
            std::string name;           //場所の名称
            std::string addr;           //具体的なアドレス
            int distance;               //今回の測位場所からの距離
        }AddressInfo;

12. LocationRet 地理位置structure
LBS地理位置情報はこの構造に保存されており、LocationRet定義は次の通りです。

        typedef struct {
            int flag;
            std::string desc;
            double longitude;           //経度
            double latitude;            //緯度
        }LocationRet;

13. PicInfo 画像情報structure
画像情報はこの構造体に保存されており、PicInfo定義は次の通りです。

        typedef struct
        {
            eMSDK_SCREENDIR screenDir;      //横画面・縦画面   1：横画面2：縦画面
            std::string picPath;            //画像のローカルパス
            std::string hashValue;          //画像のhash値
        }PicInfo;

14. NoticeInfo 公告情報structure
公告情報はこの構造体に保存されており、NoticeInfo定義は次の通りです。

        typedef struct
        {
            std::string msg_id;			//公告id
            std::string open_id;		//ユーザーopen_id
            std::string msg_url;		//公告からのリンク先
            eMSG_NOTICETYPE msg_type;	//公告種類，eMSG_NOTICETYPE
            std::string msg_scene;		//公告表示のシーン、管理側のバックグラウンド配置
            std::string start_time;		//公告の有効期間の開始時間
            std::string end_time;		//公告の有効期間の終了時間
            eMSG_CONTENTTYPE content_type;	//公告内容の種類、eMSG_CONTENTTYPE
            //ウェブページ公告の特殊フィールド
            std::string content_url;     //ウェブページ公告URL
            //画像公告の特殊フィールド
            std::vector<PicInfo> picArray;    //画像アレイ
            //テキスト公告の特殊フィールド
            std::string msg_title;		//公告タイトル
            std::string msg_content;	//公告内容
        }NoticeInfo;


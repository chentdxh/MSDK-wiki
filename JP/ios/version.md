変更履歴
===
## 2.5.0
- 【コード変更】
1.【新規追加】オンライン時間の報告・統計を新規追加しました。
2.【新規追加】内蔵ブラウザの共有入口スイッチを新規追加し、info.plistファイルで配置できますMSDK_WebView_Share_SWITCH，YESの時、内蔵ブラウザは共有ボタンを表示するのに対して、NOの時に表示しません。
3.【変更】Guestモードを最適化し、keychainデータのバックアップをします。
4.【変更】内蔵ブラウザに対して、iOS5.1.1のiPad側でウィーチャットの共有不可のbugを修復しました。
- 【コンポーネントの新規追加】
1.【新規追加】demoでは手遊宝アシスタントSDKをインテグレーションしており、ゲームは必要に応じてインテグレーションできます。

## 2.4.0
- 【コード変更】
1.【変更】MSDKのモジュール化、機能により4モジュールに分けられます。
  1. MSDKFoundation：基本的なライブラリーであり、他のライブラリーを利用するには、先ずこのフレームを導入する必要があります。
  2. MSDK:モバイルQQとウィーチャットのログイン・共有の機能；
  3. MSDKMarketing：クロス販売、内蔵ブラウザの機能を提供します。公告、内蔵ブラウザに必要なリソースファイルはWGPlatformResources.bundleファイルにあります。
  4. MSDKXG：伝書鳩Push機能を提供します。
  これら4つのコンポーネントは同時に、C99及びC11言語のバージョンを提供し、**_C11パッケージはC11のバージョンです。
  ![linkBundle](./2.4.0_structure_of_framework.png)
    また、モジュール化バージョンは2.3.4以前のObserverのコールバックに対応する他、delegateコールバックを新規追加しました。ここでモバイルQQ授権ログインを例として説明します（他のインターフェースの詳細はそれぞれインターフェースの説明ドキュメントを参照してください）。
    元の授権呼び出しコードは次の通りです。
```
WGPlatform* plat = WGPlatform::GetInstance();//MSDKの初期化
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);//コールバックの設定
plat->WGSetPermission(eOPEN_ALL);//権限の設定
plat->WGLogin(ePlatform_QQ);//モバイルQQクライアントを呼び出し、又はwebで授権
```
    元の授権コールバックコードは次の通りです。
```ruby
void MyObserver::OnLoginNotify(LoginRet& loginRet)
{
if(eFlag_Succ == loginRet.flag)
{
…//login success
std::string openId = loginRet.open_id;
std::string payToken;
std::string accessToken;
if(ePlatform_QQ == loginRet.Platform)
{
for(int i=0;i< loginRet.token.size();i++)
{
TokenRet* pToken = & loginRet.token[i];
if(eToken_QQ_Pay == pToken->type)
{
paytoken = pToken->value;
}
else if (eToken_QQ_Access == pToken->type)
{
accessToken = pToken->value;
}
}
}
else if (ePlatform_Weixin == loginRet.platform)
{
….
}
} 
else
{
…//login fail
NSLog(@"flag=%d,desc=%s",loginRet.flag,loginRet.desc.c_str()); 
}
}
```
    2.4.0i以降は、delegate方式を利用できます。コードは次の通りです。
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *authService = [[MSDKAuthService alloc] init];
[authService setPermission:eOPEN_ALL];
[authService login:ePlatform_QQ];
```
    コールバックコードは次の通りです。
```
-(void)OnLoginWithLoginRet:(MSDKLoginRet *)ret
{
//内部の実現ロジックはvoid MyObserver::OnLoginNotify(LoginRet& loginRet)
}
```


## 2.3.4
 - 【コンポーネント更新】
1.【変更】OpenSDK2.5.1に更新し、5.1.1でのcrash問題を修復しました。

## 2.3.3
 - 【コード変更】
1.【変更】ログインしていない時、モバイルQQの快速起動によるcrashを修復しました。
2.【変更】ゲストモードで初めてログインする時、pfとpfkeyのない問題を修復しました。
 - 【コンポーネント更新】
1.【変更】MTA1.4.2に更新し、SDK8でコンバイルする時、エンジニアリングcrashの問題を修復しました。

## 2.3.2
 - 【コード変更】
1.【変更】OpenSDK2.5.1に更新し、iOS8.1.1ではモバイルQQをインストールしていない時、webViewでログインできない問題を修復しました。
 - 【コンバイル変更】
1. Tencent_MSDK_IOS_V2.3.2i(arm32、iOS SDK7コンバイルに対応)：一部のゲームのゲームエンジンはiOS SDK8を良くサポートしていませんから、MSDKはiOS SDK7で32ビットのパッケージをコンバイルして、これらのゲームに供します。
2. Tencent_MSDK_IOS_V2.3.2i(arm64, iOS SDK8コンバイルに対応)： iOS SDK8でコンバイルし、arm64に対応するパッケージ。
---

## 2.3.1
 - 【コード変更】
1.【変更】RQDとライトハウスを更新し、Crash報告によるCrashの問題を修復しました。
---

## 2.3.0

 - 【コード変更】
1.【変更】リソースファイルをWGplatformResources.bundleとしてパッケージングしました。
2.【削除】米大師の結合を解除し、次のインターフェースを削除しました。
```
void WGRegisterPay(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* custom);// since 1.2.6
void WGPay(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGIAPRestoreCompletedTransactions(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGIAPLaunchMpInfo(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGDipose();//since 1.2.6
bool WGIsSupprotIapPay();//since 1.2.6
void WGSetOfferId(unsigned char* offerId);//since 1.2.6
void WGSetIapEnvirenment(unsigned char* envirenment);
void WGSetIapEnalbeLog(bool enabled);
```
3、【新規追加】ウィーチャットでのURL共有インターフェース：
        void WGSendToWeixinWithUrl(
                        const eWechatScene& scene,
                        unsigned char* title,
                        unsigned char* desc,
                        unsigned char* url,
                        unsigned char* mediaTagName,
                        unsigned char* thumbImgData,
                        const int& thumbImgDataLen,
                        unsigned char* messageExt
                        );
4、【新規追加】プッシュのメインスイッチであり、plistではMSDK_PUSH_SWITCH(string)をONに設定する必要があります。他の値に設定し、又は設定しない場合、プッシュは無効となります
5、【変更】スクロール公告の配置項目では (top,left,width)の配置を削除し、公告が画面のトップに位置し、全画面の幅となり、高さを設定しないと、デフォルトでは30ptとなります。
6、【新規追加】iOS8に対応します。LBSインターフェースにはplistフィールドrequestWhenInUseAuthorizationを追加する必要があります。公告・広告などの表示異常を修復しました。
7、【変更】Guestの記憶を最適化し、Appはそれぞれkeyに保存され、企業証書をGuestデータに書き込まず、上書きを回避できます。同時にマイグレーションロジックを追加し、進捗の失いを回避できます。
8、【変更】2つのtry－catch保護を追加し、user defaultの読書きによるcrashを回避します

 - 【BUG修復】
1、【変更】モバイルQQゲームで友達追加、友達備考及び申請情報のひっくり返しの問題を修復しました。
2、【変更】広告起動os=1(Android)の問題を修復しました。
3、【変更】AHAlertView及びサブクラスの横画面での表示エラーの問題を修復しました。
4、【変更】WGRotationView及びサブクラスのios7,8の横画面での表示エラーの問題を修復しました。
5、【変更】ゲストモードで1つの証書に異なるアプリの場合、guestiD上書きの問題を修復しました。
6、【変更】内蔵ブラウザのiOS7,8での共有ページの表示問題を修復しました。
7、【変更】広告無しの場合、内蔵ブラウザの広告ボタンの表示問題を修復しました。
8、【変更】ゲストモードで登録メッセージを送信する時、失敗の問題を修復しました。
9、【変更】RDM Crash報告の時、AppIDを報告しない問題を修復しました。

---

## 2.2.0
- 【コード変更】
1、クラウド側でのローカルログの制御・報告
2、httpヘッダーのUser-agentフィールドに端末源の追加というMSDKの要求			
3、全てのユーザーに対する伝書鳩のPUSH送信	新規要求であり、plistでMSDK_XGPUSH_URLを配置する必要があります			
4、ウィーチャット個人情報をパッケージングするMSDK のインターフェース

---

##2.1.0
- 【コード変更】
1、広告特性を追加し、WGShowAD(_eADType& scene)インターフェースを呼び出して広告を表示します。WGADObserverを追加し、広告クリックのコールバックに利用します。広告の関連配置はMsdkResources/AdvertisementResources/AdvertisementConfig.plistにあります。
2、WGGetLocationInfoインターフェース及びOnLocationGotNotifyコールバックを追加し、ユーザーのGPSアドレスを取得し、MSDKバックグラウンドに送信します。
3、WGGetNearByインターフェースはgpsCity戻りを追加しました。
4、内蔵ブラウザのリンクには明文openidを付けます。
5、LoginInfoクラスを追加し、反射によるログイン・トークンの取得を提供し、結合性を低減します。コードサンプル：
```
 Class loginInfoClass = NSClassFromString(@"LoginInfo");
    if (loginInfoClass) {
        id obj = [[[loginInfoClass alloc]init]autorelease];
        if ([obj respondsToSelector:@selector(description)]) {
            NSLog(@"Login info:%@",[obj description]);
        }
    }
```

---

## 2.0.7
 - 【コード変更】
1.【変更】更新OpenSDK2.5.1に更新し、iOS8.1.1ではモバイルQQをインストールしていない時、webViewでログインできない問題を修復しました。
---

## 2.0.6
 - 【コード変更】
1.【変更】Crash報告時のAppIDとOpenId報告を追加しました。
2.【変更】RQDとライトハウスを更新し、Crash報告によるCrashの問題を修復しました
---

##2.0.5
- 【コード変更】
1. Apple社独自のインターフェースを利用するコードを削除しました

---

##2.0.4
- 【コード変更】
このバージョンでは2.0.2iと2.0.3iを併合したものです。新規追加の機能がありません。

---

##2.0.3
- 【コード変更】
1. 【新規追加】WGPlatform.hでは次のインターフェースを新規追加しました。
```
   /**
     *  ゲストモードのidを取得します
     * 
     *
     */
    std::string WGGetGuestID();
    
    /**
     *  ゲストモードでのidを更新します
     *
     *
     */
    void WGResetGuestID();
```
2. 【削除】次のインターフェースを削除しました。
```
    void WGRegisterAPNSPushNotification(NSDictionary *dict);
    void WGSuccessedRegisterdAPNSWithToken(NSData *data);
    void WGFailedRegisteredAPNS();
    void WGCleanBadgeNumber();
    void WGReceivedMSGFromAPNSWithDict(NSDictionary* userInfo);
```
3. 【変更】WGPublicDefine.hエラーの#endifマクロ位置を変更しました
4. 【新規追加】公共ファイルWGApnsInterfaceを新規追加し、次のインターフェースを含めています。
```
    + (void)WGRegisterAPNSPushNotification:(NSDictionary*)dict;
    + (void)WGSuccessedRegisterdAPNSWithToken:(NSData *)data;
    + (void)WGFailedRegisteredAPNS;
    + (void)WGCleanBadgeNumber;
    + (void)WGReceivedMSGFromAPNSWithDict:(NSDictionary*) userInfo;
```
5. 【新規追加】内部ファイルGuestInterfaceのゲストモードの処理ロジックを追加しました

【ドキュメント調整】
1. 【新規追加】第13章：ゲストモードの関連説明；
2. 【新規追加】第1章： C99とC11パッケージを同時にリリースする説明を追加しました。
2. 【新規追加】第12章： APNS関連説明を変更し、WGApnsInterfaceの呼び出しに変更しました

---

##2.0.2
- 【コード変更】
1、ゲーム内の友達に関する3つのインターフェースを追加し、OpenSDK2.5に更新しました。相応にモバイルQQの新しいバージョンを使用する必要があります。
```
    /**
	 * ゲームでグループを追加し、ギルドはQQグループをバンディングしてから、ギルドの成員は「グループ加入」ボタンをクリックすることで、このギルドグループに参加できます。
	 * @param cQQGroupKey追加するQQグループの対応keyであり、ゲームserverはopenAPIのインターフェースを呼び出し、これを取得します。呼び出し方法はRTXで OpenAPIHelperにお問合せください。
	 */
	void WGJoinQQGroup(unsigned char* cQQGroupKey);
	/**
	 * ゲームグループのバンディング：ゲームギルド/連合内，ギルド会長は「バンディング」ボタンをクリックすることで、自分で作成したグループを選択し、あるグループをこのギルドのギルドグループとしてバンディングできます。
	 * @param cUnionid ギルドID，opensdk制限只能填数字，字符可能会导致バンディング失敗
	 * @param cUnion_name ギルド名称
	 * @param cZoneid ゾーンID，opensdkでは数字だけ記入できます。文字を記入するとバンディング失敗をもたらします。
	 * @param cSignature ゲーム連盟会長の身分確認の署名で、生成アルゴリズムとしてはopenid_appid_appkey_ギルドid_区id に対してmd5を行います。
	 * 					   この方法でバンディングできない場合、RTXで OpenAPIHelperにお問合せください
	 *
	 */
	void WGBindQQGroup(unsigned char* cUnionid, unsigned char* cUnion_name,
                       unsigned char* cZoneid, unsigned char* cSignature);
	/**
	 * ゲーム内での友達追加
	 * @param cFopenid追加する友達のopenid
	 * @param cDesc追加する友達の備考
	 * @param cMessage友達追加の時に送信する確認情報
	 */
	void WGAddGameFriendToQQ(unsigned char* cFopenid, unsigned char* cDesc,
                             unsigned char* cMessage);
```
---

##2.0.1
- 【コード変更】
1、公告では画像公告の種類を追加し、公告の構造体には画像データを追加しました。詳細はMSDK接続ドキュメント2.0を参照してください
2、LoginWithLocalInfoインターフェースを追加し、トークンを確認します。ゲーム実行又はバックグラウンドからフロントエンドへの切り替えは、このメソッドを呼び出します。

---

##2.0.0
- 【コード変更】
1. ブラウザ機能を最適化し、内蔵ブラウザを修復しました。
2.画像、ウェブページ公告を追加しました。定時的に公告データをダウンロードします。
3.自動ログインのプロセスを追加し、トークンのベリファイを行い、定時的にaccessToken等のトークンを更新します。
4.モバイルQQ sdk1.1.1バージョンに更新し、ゲームでモバイルQQ授権の回収による授権失敗のbugを修復しました。
5. ローカルログの方案に関して、info.plistではMSDK_LOG_TO_FILEをYESに設定し、MSDKの出力ログをCaches/msdk.logに記録します。


MSDK ウィーチャット 関連モジュール
=======


接続配置
------

#### AndroidMainfest配置

ゲームは次のサンプルで配置情報を記入します。

```
<!-- TODO SDK接続 ウィーチャット接続配置 START -->
<activity
	<!-- 注意：ここでゲームパッケージ名.wxapi.WXEntryActivityに変更します -->
 	android:name="com.example.wegame.wxapi.WXEntryActivity"
	android:excludeFromRecents="true"
	android:exported="true"
	android:label="WXEntryActivity"
	android:launchMode="singleTop"
	<!-- 注意：ここで ゲームパッケージ名.diff に変更します-->
	android:taskAffinity="com.example.wegame.diff" >
	<intent-filter>
		<action android:name="android.intent.action.VIEW" />
		<category android:name="android.intent.category.DEFAULT" />
		<!-- 注意：ここでゲームのウィーチャットappidに変更します -->
		<data android:scheme="wxcde873f99466f74a" />
	</intent-filter>
</activity>
<!-- TODO SDK接続 ウィーチャット接続配置 END -->
```

##### 注意事項：
	
* `アプリパッケージ名+.wxapi`の配下に`WXEntryActivity.java`を入れます。
* ウィーチャット接続のActivityでは`ゲームは3箇所を自分で変更します`(上のサンプルでマークを付いています)。


#### Appid 配置：

この部分の内容はJava層の初期化で完成しました, ** MSDKSampleのappIdとappKeyで結合テストをすることができず、ゲームは自分のappIdとappKeyを利用する必要があります。**

```
public void onCreate(Bundle savedInstanceState) {
	...
	//ゲームは自分のQQ AppIdで結合テストをしなければなりません
    baseInfo.qqAppId = "1007033***";
    baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

    //ゲームは自分のウィーチャットAppIdで結合テストをしなければなりません
    baseInfo.wxAppId = "wxcde873f99466f***"; 
    baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

    //ゲームは自分の支払offerIdで結合テストをしなければなりません
    baseInfo.offerId = "100703***";
	...
	WGPlatform.Initialized(this, baseInfo);
	WGPlatform.handleCallback(getIntent());
	...
}
```

#### 次のメソッドを呼び出さなければなりません

ゲームは自分の`launchActivity`(ゲーム実行の最初Activity)の`onCreat()`と`onNewIntent()`で`handleCallback`を呼び出す必要があります。でないとコールバック無のログインなどの問題をもたらします。

- **onCreate**:

```	
@Override
protected void onCreate(Bundle savedInstanceState) {
	super.onCreate(savedInstanceState);
	......
    if (WGPlatform.wakeUpFromHall(this.getIntent())) {
    	//起動プラットフォームはホールです。 
    	Logger.d("LoginPlatform is Hall");
    } else {  
    	//起動プラットフォームはホールではありません
        Logger.d("LoginPlatform is not Hall");
        WGPlatform.handleCallback(this.getIntent());
    }
}
```

- **onNewIntent**

```
@Override
protected void onNewIntent(Intent intent) {
	super.onNewIntent(intent);
	if (WGPlatform.wakeUpFromHall(intent)) {
	    Logger.d("LoginPlatform is Hall");
	} else {
	    Logger.d("LoginPlatform is not Hall");
	    WGPlatform.handleCallback(intent);
	}
}
```

個人情報の検索
------

ユーザーはウィーチャットで授権してから、openIdとaccessTokenを獲得できます。表示のためにゲームではまたユーザーのニックネーム, 顔写真その他の情報を必要とします。SDKでは現在、nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, cityなどの情報を獲得できます。この機能を完成するために、WGQueryWXMyInfoというインターフェースを利用する必要があります。インターフェースの詳細は次の通りです。

#### インターフェース声明：

	/**
	 *   OnRelationNotifyでコールバックされます。その中RelationRet.personsはVectorで、Vectorの第１項は自分の資料となります。
	 *   個人情報にはnickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, cityがあります。
	 */
	bool WGQueryWXMyInfo();

#### 呼び出しサンプルコード：

	WGPlatform::GetInstance()->WGQueryWXMyInfo();

#### コールバック (Demo)コードは次の通りです。

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // relationRet.persons.at(0) に保存されているのは個人情報です
		std::string gender = relationRet.persons.at(0).gender;
		std::string nickName = relationRet.persons.at(0).nickName;
		std::string openId = relationRet.persons.at(0).openId;
		std::string pictureLarge = relationRet.persons.at(0).pictureLarge;
		std::string pictureMiddle = relationRet.persons.at(0).pictureMiddle;
		std::string pictureSmall = relationRet.persons.at(0).pictureSmall;
        break;
    default:
        break;
    	}
	}


友達情報の検索
------

ユーザーはウィーチャットでゲームの授権を獲得してから、ゲームにある友達情報(例えば友達のランキング)を実行する必要があります。SDKでは現在、nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, cityなどの情報を獲得できます。この機能を完成するために、WGQueryWXGameFriendsInfoというインターフェースを利用する必要があります。インターフェースの詳細は次の通りです。
#### インターフェース声明：

	/**
	 *ウィーチャットの友達情報を取得し、コールバックはOnRelationNotifyにあります。
	 *   コールバックはOnRelationNotifyにあり、ここのRelationRet.personsはVector, Vectorの内容は友達情報です
	 *   友達情報にはnickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, cityなどがあります。
	 */
	bool WGQueryWXGameFriendsInfo();

このインターフェースの呼び出し結果はOnRelationCallBack(RelationRet& relationRet) でデータをゲームにコールバックします。 RelationRet対象のpersons属性はVector<PersonInfo>であり、その中、それぞれPersonInfo対象は即ち友達情報です。友達情報にはnickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, cityがあります。

#### 呼び出しサンプルコード：

	WGPlatform::GetInstance()->WGQueryWXGameFriendsInfo();

#### コールバック (Demo)コードは次の通りです。

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
	case eFlag_Succ: {
		// relationRet.persons.at(0) に保存されているのは個人情報です
		for (int i = 0; i < relationRet.persons.size(); i++) {
			std::string city = relationRet.persons.at(i).city;
			std::string gender = relationRet.persons.at(i).gender;
			std::string nickName = relationRet.persons.at(i).nickName;
			std::string openId = relationRet.persons.at(i).openId;
			std::string pictureLarge = relationRet.persons.at(i).pictureLarge;
			std::string pictureMiddle = relationRet.persons.at(i).pictureMiddle;
			std::string pictureSmall = relationRet.persons.at(i).pictureSmall;
			std::string provice = relationRet.persons.at(i).provice;
				}
		break;
			}
    default:
        break;
    	}
	}

構造化メッセージの共有
------

このメッセージを共有するために、ウィーチャットクライアントを運行し、ユーザーの参与で共有の過程を完成する必要があります。ゲーム内外の友達に共有できます。ゲーム外の友達を招待するのに用いられます。 
メッセージが共有されると、 メッセージ受信者はメッセージをクリックすることで、ゲームを実行できます。この機能を完成するために、WGSendToWeixinというインターフェースを利用する必要があります。インターフェースの詳細は次の通りです。

#### インターフェース声明

	/**
	 * @param title 構造化メッセージのタイトル（注意：サイズ512Bytes以下）
	 * @param desc 構造化メッセージの概要情報（注意：サイズ1KB以下）
	 * @param mediaTagName実情に応じて下記値の何れかを記入し、この値はウィーチャットに伝えられ、統計に利用します。共有戻りの時にもこの値を付け、共有の出所を区分できます。
		 "MSG_INVITE";                   // 招待
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //今週最高点数をモーメンツに共有します。
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //歴史最高点数をモーメンツに共有します。
		 "MSG_SHARE_MOMENT_CROWN";         //クラウンをモーメンツに共有します。
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //今週最高点数を友達に共有します。
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //歴史最高点数を友達に共有します。
		 "MSG_SHARE_FRIEND_CROWN";          //クラウンを友達に共有します。
		 "MSG_friend_exceed"         // 自慢
		 "MSG_heart_send"            // 好意
	 * @param thumbImgData 構造化メッセージのサムネイル
	 * @param thumbImgDataLen 構造化メッセージのサムネイルのデータ長さ（注意：内容サイズは32KB以下）
	 * @param messageExt ゲーム共有は文字列を伝えます。このメッセージでゲームを実行すると、OnWakeUpNotify(WakeupRet ret)のret.messageExtでゲームにコールバックします
	 * @return void
	 *   ゲームで設定したグローバルコールバックのOnShareNotify(ShareRet& shareRet)データをゲームにコールバックします。 shareRet.flag値はリターン状態を示し、 可能な値と説明は次の通りです。
	 *     eFlag_Succ: 共有に成功しました
	 *     eFlag_Error: 共有に失敗しました
	 */
	 void WGSendToWeixin(
		unsigned char* title, 
		unsigned char* desc,
		unsigned char* mediaTagName,
		unsigned char* thumbImgData,
		const int& thumbImgDataLen, 
		unsigned char* messageExt
	); 

#### インターフェース呼び出し

	std::string title = " title ";
	std::string desc = " desc ";
	std::string mediaTagName = " mediaTag_wxAppInvite ";
	unsigned char * thumbImgData = getImageData();
	int thumbImgDataLen = getImageDataLength();
	std::string messageExt = "extend message";
	
	WGPlatform::GetInstance()->WGSendToWeixin(
		(unsigned char *)title.c_str(),
		(unsigned char *)desc.c_str(),
		(unsigned char *)mediaTagName.c_str(),
		thumbImgData,
		thumbImgDataLen,
		(unsigned char *)messageExt.c_str()
	);

#### コールバック (Demo)コード

	virtual void OnShareNotify(ShareRet& shareRet) {
	//共有コールバックの処理
	if (shareRet.platform == ePlatform_QQ) {
		…
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 共有に成功しました
			break;
		case eFlag_Error:
			// 共有に失敗しました
			break;
		}
		}
	}

#### 注意事項

1.	ウィーチャットのバージョンが4.0以上でなければなりません。 
2. 長さと幅の比率を問わないが、`サムネイルのサイズが32kを超えることができません。`サイズが大きすぎると、ウィーチャットを実行できません。
3.共有にはsdカードを利用する必要があります。sdカードがない場合、又はsdカードに空き空間がない場合、共有は失敗となります。


大画像メッセージの共有
------
このメッセージを共有するために、ウィーチャットを運行し、ユーザーの参与で共有の過程を完成する必要があります。ゲーム内外の友達に共有できます。一般的に成績を自慢するか、詳細図を必要とする他の機能に用いられます。このメッセージを会話(友達)又はmomentsに共有でき、ウィーチャット4.0以降の場合、会話への共有に対応し、ウィーチャット4.2以降の場合、momentsへの共有に対応します。画像サイズは10Mを超えることができません。ウィーチャットでは共有の画像を相応に圧縮します。この機能を完成するには、WGSendToWeixinWithPhotoというインターフェースを利用します。インターフェースの詳細は次の通りです。
#### インターフェース声明

	/**
	 * @param scene moments、又はウィーチャット会話への共有を指定します。可能な値と役割は次の通りです。
	 *   WechatScene_Session: ウィーチャット会話に共有します。
	 *   WechatScene_Timeline: ウィーチャットmomentsに共有します。
	 * @param mediaTagName実情に応じて下記値の何れかを記入し、この値はウィーチャットに伝えられ、統計に利用します。共有戻りの時にもこの値を付け、共有の出所を区分できます。
		 "MSG_INVITE";                   // 招待
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //今週最高点数をモーメンツに共有します。
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //歴史最高点数をモーメンツに共有します。
		 "MSG_SHARE_MOMENT_CROWN";         //クラウンをモーメンツに共有します。
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //今週最高点数を友達に共有します。
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //歴史最高点数を友達に共有します。
		 "MSG_SHARE_FRIEND_CROWN";          //クラウンを友達に共有します。
		 "MSG_friend_exceed"         //自慢
		 "MSG_heart_send"            // 好意
	 * @param imgData オリジナル画像のフィアルデータ
	 * @param imgDataLen オリジナル画像のフィアルデータの長さ(画像サイズは10M以下)
	 * @param messageExt ゲーム共有は文字列を伝えます。このメッセージでゲームを実行すると、OnWakeUpNotify(WakeupRet ret)のret.messageExtでゲームにコールバックします
	 * @param messageAction sceneが1の時に(ウィーチャットのモーメンツに共有します)役割を果たします。
	 *   WECHAT_SNS_JUMP_SHOWRANK       ランキングへジャンプ
	 *   WECHAT_SNS_JUMP_URL            リンクへジャンプ
	 *   WECHAT_SNS_JUMP_APP           APPへジャンプ
	 * @return void
	 *   ゲームで設定したグローバルコールバックのOnShareNotify(ShareRet& shareRet)データをゲームにコールバックします。 shareRet.flag値はリターン状態を示し、 可能な値と説明は次の通りです。
	 *     eFlag_Succ: 共有に成功しました
	 *     eFlag_Error: 共有に失敗しました
	 */
	void WGSendToWeixinWithPhoto(
	const eWechatScene &scene,
	unsigned char *mediaTagName,
	unsigned char *imgData, 
	const int &imgDataLen,
	unsigned char *messageExt,
	unsigned char *messageAction
	);

#### インターフェース呼び出し

	std::string mediaTagName = " mediaTagName ";
	jbyte * imgDataJb = pEnv->GetByteArrayElements(j_imgData, &isCopy);
	unsigned char * imgData = getImageData();
	int imgDataLen = getImageDataLength();
	std::string messageExt = " messageExt ";
	std::string messageAction = " messageAction ";
	WGPlatform::GetInstance()->WGSendToWeixinWithPhoto(
	1,
	(unsigned char *)mediaTagName.c_str(),
	(unsigned char*) imgData,
	imgDataLen,
	(unsigned char *)messageExt.c_str(),
	(unsigned char *)messageAction.c_str()
	);

#### コールバック (Demo)コード

	virtual void OnShareNotify(ShareRet& shareRet) {
	LOGD("OnShareNotify: platform:%d flag:%d",
			shareRet.platform, shareRet.flag);
	// 共有コールバックの処理
	if (shareRet.platform == ePlatform_QQ) {
		… // モバイルQQ共有から戻るコールバックを処理します
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 共有に成功しました
			break;
		case eFlag_Error:
			// 共有に失敗しました
			break;
			}
		}
	}

#### 注意事項：
- **momentsボタンの表示は、ネットワークによる遅延があります。また、ウィーチャット5.1以降を必要とします。**
- `大画像共有では画像は10M以下とします`。でないと共有に失敗したことがあります

音楽メッセージの共有
------
このメッセージを共有するために、ウィーチャットクライアントを運行し、ユーザーの参与で共有の過程を完成する必要があります。ゲーム内外の友達に共有できます。ゲーム外の友達を招待するのに用いられます。
メッセージが共有されると、 メッセージ受信者はメッセージをクリックすることで、ゲームを実行できます. この機能を完成するために、WGSendToWeixinWithMusicというインターフェースを利用します。インターフェースの詳細は次の通りです。
#### インターフェース声明

	/**
	 *音楽メッセージをウィーチャットの友達に共有します
	 * @param scene moments、又はウィーチャット会話への共有を指定します。可能な値と役割は次の通りです。
	 *   WechatScene_Session: ウィーチャット会話に共有します。
	 *   WechatScene_Timeline: ウィーチャットmomentsに共有します(このメッセージはmomentsに共有できないと制限されています)
	 * @param title 音楽メッセージのタイトル（注意：サイズ512Bytes以下）
	 * @param desc	音楽メッセージの概要情報（注意：サイズ1KB以下）
	 * @param musicUrl	音楽メッセージのターゲットURL
	 * @param musicDataUrl	音楽メッセージのデータURL
	 * @param imgData オリジナルデータ
	 * @param imgDataLen オリジナルデータの長さ (画像のサイズは10Mを超えないこと)
	 * @param messageExt ゲーム共有では文字列が伝えられ、この共有メッセージを通じてゲームを実行し、OnWakeUpNotify(WakeupRet ret)のret.messageExtでゲームにコールバックします
	 * @param messageAction sceneがWechatScene_Timeline(ウィーチャットmomentsに共有)の時にのみ機能します。
	 *   WECHAT_SNS_JUMP_SHOWRANK       ランキングにジャンプし、ランキングを照合ます
	 *   WECHAT_SNS_JUMP_URL            リンクにジャンプし、詳細を照合します
	 *   WECHAT_SNS_JUMP_APP            APPにジャンプし、ゲームを楽しみます
	 * @return void
	 *   ゲームで設定したグローバルコールバックのOnShareNotify(ShareRet& shareRet)データをゲームにコールバックします。 shareRet.flag値はリターン状態を示し、 可能な値と説明は次の通りです。
	 *     eFlag_Succ: 共有に成功しました
	 *     eFlag_Error: 共有に失敗しました
	 */
	void WGSendToWeixinWithMusic(
		const eWechatScene& scene,
		unsigned char* title,
		unsigned char* desc,
		unsigned char* musicUrl,
		unsigned char* musicDataUrl,
		unsigned char *mediaTagName,
		unsigned char *imgData,
		const int &imgDataLen,
		unsigned char *messageExt,
		unsigned char *messageAction
	);

リアエンド共有
------
ゲームはメッセージを指定の友達(友達のopenIdを指定)に共有する必要があります。この共有ではウィーチャットクライアントを実行する必要がなく、共有の過程でユーザーの参与を必要とせず、インターフェースを呼び出すことで共有を完成できます。但し、ゲーム内の友達しか共有できません。メッセージが共有されると、メッセージの受信者はメッセージをクリックするとゲームを実行できます。この機能を完成するには、`WGSendToWXGameFriend`というインターフェースを利用する必要があります。このインターフェースは歴史的な原因によりC++インターフェースとJavaインターフェースのパラメータ順序は異なります。詳細はそれぞれは次の通りです。

#### インターフェース説明

##### C++インターフェース

	/**
	 * このインターフェースはWGSendToQQGameFriendに近く、このインターフェースを利用してメッセージをウィーチャット友達に共有できます。共有する時、友達openidを指定しなければなりません。
	 * @param fOpenId 友達のopenid
	 * @param title 共有のタイトル
	 * @param description 共有の記述
	 * @param mediaId 画像のid はバックグラウンド・インターフェース/share/upload_wxを通じて取得します
	 * @param messageExt ゲーム共有では文字列が伝えられ、この共有メッセージを通じてゲームを実行し、OnWakeUpNotify(WakeupRet ret)のret.messageExtでゲームにコールバックします
	 * @param mediaTagName実情に応じて下記値の何れかを記入し、この値はウィーチャットに伝えられ、統計に利用します。共有戻りの時にもこの値を付け、共有の出所を区分できます。
		 "MSG_INVITE";                   // 招待
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //今週最高点数をモーメンツに共有します。
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //歴史最高点数をモーメンツに共有します。
		 "MSG_SHARE_MOMENT_CROWN";         //クラウンをモーメンツに共有します。
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //今週最高点数を友達に共有します。
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //歴史最高点数を友達に共有します。
		 "MSG_SHARE_FRIEND_CROWN";          //クラウンを友達に共有します。
		 "MSG_friend_exceed"         //自慢
		 "MSG_heart_send"            // 好意
	 * @param extMsdkInfo ゲームの自己定義した透明伝送フィールドです。共有結果shareRet.extInfoをゲームに戻すことで、ゲームはextInfoでrequestを区分できます
	*/
	
	bool WGSendToWXGameFriend(
		unsigned char *fOpenId, 
		unsigned char *title,
		unsigned char *description, 
		unsigned char *mediaId,
		unsigned char* messageExt, 
		unsigned char *mediaTagName，
	    unsigned char * msdkExtInfo
	);

##### Javaインターフェース

```
/**
 * このインターフェースはWGSendToQQGameFriendに近く、このインターフェースを利用してメッセージをウィーチャット友達に共有できます。共有する時、友達openidを指定しなければなりません。
 * @param friendOpenId 友達のopenid
 * @param title 共有のタイトル
 * @param description 共有の記述
 * @param messageExt ゲーム共有では文字列が伝えられ、この共有メッセージを通じてゲームを実行し、OnWakeUpNotify(WakeupRet ret)のret.messageExtでゲームにコールバックします
 * @param mediaTagName実情に応じて下記値の何れかを記入し、この値はウィーチャットに伝えられ、統計に利用します。共有戻りの時にもこの値を付け、共有の出所を区分できます。
	 "MSG_INVITE";                   // 招待
	 "MSG_SHARE_MOMENT_HIGH_SCORE";    //今週最高点数をモーメンツに共有します。
	 "MSG_SHARE_MOMENT_BEST_SCORE";    //歴史最高点数をモーメンツに共有します。
	 "MSG_SHARE_MOMENT_CROWN";         //クラウンをモーメンツに共有します。
	 "MSG_SHARE_FRIEND_HIGH_SCORE";     //今週最高点数を友達に共有します。
	 "MSG_SHARE_FRIEND_BEST_SCORE";     //歴史最高点数を友達に共有します。
	 "MSG_SHARE_FRIEND_CROWN";          //クラウンを友達に共有します。
	 "MSG_friend_exceed"         //自慢
	 "MSG_heart_send"            // 好意
 * @param thumbMediaId画像のid はバックグラウンド・インターフェース/share/upload_wxを通じて取得します
 * @param extMsdkInfo ゲームの自己定義した透明伝送フィールドです。共有結果shareRet.extInfoをゲームに戻すことで、ゲームはextInfoでrequestを区分できます
*/
public static boolean WGSendToWXGameFriend(
    String friendOpenId, 
    String title, 
    String description, 
    String messageExt,
    String mediaTagName, 
    String thumbMediaId, 
    String msdkExtInfo);
```

#### インターフェース呼び出し

	std::string friendOpenId = "oGRTijrV0l67hDGN7dstOl8Cp***";
	std::string title = " title ";
	std::string description = " description ";
	std::string thumbMediaId = " thumbMediaId ";
	std::string extinfo = " extinfo ";
	std::string mediaTagName = " mediaTagName ";
	std::string msdkExtInfo = "msdkExtInfo";
	
	WGPlatform::GetInstance()->WGSendToWXGameFriend(
	(unsigned char *) friendOpenId.c_str(),
	(unsigned char *) title.c_str(),
	(unsigned char *) description.c_str(),
	(unsigned char *) thumbMediaId.c_str(),
	(unsigned char *) extinfo.c_str(),
		(unsigned char *) mediaTagName.c_str()，
	    (unsigned char *) msdkExtInfo.c_str()
	);

#### コールバック (Demo)コード

	virtual void OnShareNotify(ShareRet& shareRet) {
	// 共有コールバックの処理
	if (shareRet.platform == ePlatform_QQ) {
		…
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 共有に成功しました
			break;
		case eFlag_Error:
			// 共有に失敗しました
			break;
		}
		}
	}

リンク共有
------

リンクメッセージは実に構造化メッセージの一種です。ウィーチャットの構造化メッセージは構造体をクリックして指定リンクにジャンプできないため、リンクメッセージを追加しました。リンクメッセージも任意の友達に送信でき、構造体をクリックするとリンクを開くことができます。従って、リンクメッセージは招待、自慢、イベントページの共有などに用いられます。

#### インターフェース声明

```
/**
 * @param title リンクメッセージのタイトル
 * @param desc リンクメッセージの概要情報
 * @param url 共有のURL
 * @param mediaTagName実情に応じて下記値の何れかを記入し、この値はウィーチャットに伝えられ、統計に利用します。共有戻りの時にもこの値を付け、共有の出所を区分できます。
 "MSG_INVITE";                   // 招待
 "MSG_SHARE_MOMENT_HIGH_SCORE";    //今週最高点数をモーメンツに共有します。
 "MSG_SHARE_MOMENT_BEST_SCORE";    //歴史最高点数をモーメンツに共有します。
 "MSG_SHARE_MOMENT_CROWN";         //クラウンをモーメンツに共有します。
 "MSG_SHARE_FRIEND_HIGH_SCORE";     //今週最高点数を友達に共有します。
 "MSG_SHARE_FRIEND_BEST_SCORE";     //歴史最高点数を友達に共有します。
 "MSG_SHARE_FRIEND_CROWN";          //クラウンを友達に共有します。
 "MSG_friend_exceed"         // 自慢
 "MSG_heart_send"            // 好意
 * @param thumbImgData 構造化メッセージのサムネイル
 * @param thumbImgDataLen 構造化メッセージのサムネイルデータ長さ
 * @param messageExt ゲーム共有は文字列を伝えます。このメッセージでゲームを実行すると、OnWakeUpNotify(WakeupRet ret)のret.messageExtでゲームにコールバックします
 * @return void
 *   ゲームで設定したグローバルコールバックのOnShareNotify(ShareRet& shareRet)データをゲームにコールバックします。 shareRet.flag値はリターン状態を示し、 可能な値と説明は次の通りです。
 *     eFlag_Succ: 共有に成功しました
 *     eFlag_Error: 共有に失敗しました
 */
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
```

#### 呼び出しサンプル

```
String title = "title";
String desc = "desc";
String mediaTagName = "MSG_INVITE";
String messageExt = "message Ext";
Bitmap thumb = BitmapFactory.decodeResource(mMainActivity.getResources(),
		R.drawable.ic_launcher);
byte[] imgData = CommonUtil.bitmap2Bytes(thumb);
String url = "www.qq.com";
if ("cpp".equals(ModuleManager.LANG)) { // C++でMSDKを呼び出す場合、ゲームは1つの方式を採用すればいいです
	PlatformTest.WGSendToWeixinWithUrl(scene, title, desc, url,
			mediaTagName, imgData, imgData.length, messageExt);
} else if ("java".equals(ModuleManager.LANG)) { // JavaでMSDKを呼び出します
	WGPlatform.WGSendToWeixinWithUrl(scene, title, desc, url, 
			mediaTagName, imgData, imgData.length, messageExt);
}
```

Androidウィーチャットのログイン不可の検査手順
------

### ステップ1： Logには次の内容があるか検査します。

	lauchWXPlatForm wx SendReqRet: true

これがあれば、クエストをウィーチャットに出したことを示します

ウィーチャットクライアントが起動しない場合、ステップ2へ進みます。 
ウィーチャットクライアントが起動したが、コールバックがない場合、ステップ3へ進みます。

### ステップ2：署名とパッケージ名を検査します

 [https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk](https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk)をダウンロードし、 このapkを携帯電話にインストールし、入力ボックスではゲームの署名を入力します。ボタンをクルックして、ゲームパッケージの署名を読み込みます。

![署名検査](./wechat_GenSig.png "署名検査")

上述ツールで取得した署名とウィーチャットのバックグラウンドで配置された署名の一致性を検査します（ウィーチャットのバックグラウンドで配置された署名情報の検索について、RTXでMSDKにお問い合わせください）

### ステップ3： WXEntryActivity.javaの場所を検査します（このファイルはMSDKSampleにあります）

このファイルを ゲーム+.wxapi配下に入れなければなりません。例えばゲームのパッケージ名がcom.tencent.msdkgameの場合、WXEntryActivity.java をcom.tencent.msdkgame.wxapi配下に入れなければなりません。同時にWXEntryActivityの内容が次のものと同じであるか検査します。

	/**
	 * !!このファイルのコードロジックを変更しないでください。MSDKは1.7から、親クラスの名称をWXEntryActivityからBaseWXEntryActivityに変更しました。ファイルのエラーが発生すると、先ずこのことを検査してください
	 */
	public class WXEntryActivity extends com.tencent.msdk.weixin.BaseWXEntryActivity { }

この手順で問題がなければ、ステップ4へ進みます。


### ステップ4： handleCallbackを検査します

ゲームのLaunch ActivityのonCreateとonNewIntentでは、WGPlatform.handleCallbackを呼び出したか検査します。


### ステップ5：ゲームのグローバルObserverが設定されているか検査します

ゲームがWGSetObserver（C++層とJava層）を正しく呼び出したか検査します。


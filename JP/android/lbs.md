MSDK LBS 関連モジュール
=======
現在、MSDKのLBSによりフロントエンドの測位ができ、バックグラウンドにて周りの友達を請求する機能を実現しています。ユーザーがこの機能を利用したくない場合、SDKもユーザーの地理位置情報を消去するインターフェースを提供しています。関連インターフェースの記述は次の通りです。

周りの人の取得
---
#### インターフェース声明：

    /**
    *  周りの人の情報を取得します
    *  @return OnLocationNotifyにコールバックします
    *  @return void
    *   ゲームで設定したグローバルコールバックのOnLocationNofity(RelationRet& rr)メソッドでデータをゲームに戻します
    *     rr.platformは現在の授権プラットフォームを示し、 値のタイプはePlatformであり、可能な値はePlatform_QQ, ePlatform_Weixinです。
    *     rr.flag値はリターン状態を示し、可能値(eFlag枚挙)は次の通りです。
    * 			eFlag_LbsNeedOpenLocationService:ユーザーに測位サービスの起動を案内します
    *  		eFlag_LbsLocateFail: 測位に失敗しました。再試行できます。
    *  		eFlag_Succ: 周りの人の所得に成功しました
    *  		eFlag_Error:  測位に成功しましたが、周りの人の請求に失敗しました。再試行できます。
    *     rr.personsはVectorであり、周りのプレイヤーの情報を保存しています。
    */*/
    void WGGetNearbyPersonInfo ();
   
#### 呼び出しサンプルコード：

	WGPlatform::GetInstance()->WGGetNearbyPersonInfo();

#### コールバック (Demo)コードは次の通りです。

    void OnLocationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // relationRet.persons.at(0) に保存されているのは周りプレイヤーの情報です
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
	
	
位置情報の消去
---

#### インターフェース声明：

       /**
     *  個人の位置情報を消去します
     *  @return OnLocationNotifyにコールバックします
     *  @return void
     *   ゲームで設定したグローバルコールバックのOnLocationNofity(RelationRet& rr)メソッドでデータをゲームに戻します
     *     rr.platformは現在の授権プラットフォームを示し、 値のタイプはePlatformであり、可能な値はePlatform_QQ, ePlatform_Weixinです
     *     rr.flag値はリターン状態を示し、可能値(eFlag枚挙)は次の通りです。
     * 			eFlag_LbsNeedOpenLocationService:ユーザーに測位サービスの起動を案内します
     *  		eFlag_LbsLocateFail: 測位に失敗しました。再試行できます
     *  		eFlag_Succ: 消去に成功しました
     *  		eFlag_Error:  消去に失敗しました。再試行できます
     */*/
     bool WGCleanLocation ();
     
#### 呼び出しサンプルコード：

	WGPlatform::GetInstance()->WGCleanLocation();
	
	
プレイヤーの位置情報の取得
---

#### インターフェース声明：

    /**
     *  現在のプレイヤーの位置情報を取得し、ゲームに戻す同時にMSDKバックグラウンドに送信します。
     *  @return OnLocationGotNotifyにコールバックします
     *  @return boolean，trueの場合、クライアント側のエラーがないことを示します。Falseの場合、クライアント側でエラーが発生したことを示します。
	 *   ゲームで設定したグローバルコールバックのOnLocationGotNotify(LocationRet& rr)メソッドでデータをゲームに戻します
	 *     rr.platformは現在の授権プラットフォームを示し、 値のタイプはePlatformであり、 可能な値はePlatform_QQ, ePlatform_Weixinです。
	 *     rr.flag値はリターン状態を示し、 可能値(eFlag枚挙)は次の通りです。
	 *  		eFlag_Succ: 取得に成功しました
	 *  		eFlag_Error: 取得に失敗しました
	 *     rr.longitude プレイヤー位置の経度であり、doubleタイプです
	 *     rr.latitude プレイヤー位置の緯度であり、doubleタイプです
	 *     /
	 *     
     bool WGGetLocationInfo ();
     
#### 呼び出しサンプルコード：

	WGPlatform::GetInstance()->WGGetLocationInfo();


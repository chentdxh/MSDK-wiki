    
MSDK 위챗 관련 모듈
=======


액세스 설정
------

#### AndroidMainfest 설정

게임은 다음의 사례에 따라 설정 정보를 입력해야 한다.

```
<!-- TODO SDK 액세스  위챗 액세스 설정 START -->
<activity
	<!-- 주의: 이곳은 게임 패키지명.wxapi.WXEntryActivity --으로 변경>
 	android:name="com.example.wegame.wxapi.WXEntryActivity"
	android:excludeFromRecents="true"
	android:exported="true"
	android:label="WXEntryActivity"
	android:launchMode="singleTop"
	<!-- 주의: 이곳은 게임 패키지명.diff --으로 변경>
	android:taskAffinity="com.example.wegame.diff" >
	<intent-filter>
		<action android:name="android.intent.action.VIEW" />
		<category android:name="android.intent.category.DEFAULT" />
		<!-- 주의: 이곳은 게임의 위챗appid –로 변경>
		<data android:scheme="wxcde873f99466f74a" />
	</intent-filter>
</activity>
<!-- TODO SDK 액세스  위챗 액세스 설정 END -->
```

##### 주의사항: 
	
* ‘앱 패키지 이름+.wxapi’ 아래에 ‘WXEntryActivity.java’ 배치.
* 위챗에 액세스한 Activity 중 ‘세곳은 게임이 자체적으로 수정해야 함’(위의 예에서 표시)


#### Appid 설정:

이 부분 내용은 Java 계층 초기화 부분에서 이미 완료되었다. **MSDKSample의 appId와 appKey로 연동 테스트를 진행할 수 없으며 게임은 자체 appId와 appKey를 사용해야 한다.**

```
public void onCreate(Bundle savedInstanceState) {
	...
	//게임은 반드시 자신의 QQ AppId를 사용하여 연동 테스트 진행
    baseInfo.qqAppId = "1007033***";
    baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

    //게임은 반드시 자신의 위챗 AppId를 사용하여 연동 테스트 진행
    baseInfo.wxAppId = "wxcde873f99466f***"; 
    baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

    //게임은 반드시 자신의 결제 offerId를 사용하여 연동 테스트 진행
    baseInfo.offerId = "100703***";
	...
	WGPlatform.Initialized(this, baseInfo);
	WGPlatform.handleCallback(getIntent());
	...
}
```

#### 반드시 콜해야 하는 방법:

게임은 자신의 `launchActivity`(게임 시작할 때의 첫번째 Activity)의`onCreat()`및`onNewIntent()`에서 `handleCallback`를 호출해야 한다. 그렇지 않으면 로그인에 콜백이 없음을 초래할 수 있다.

- **onCreate**:

```	
@Override
protected void onCreate(Bundle savedInstanceState) {
	super.onCreate(savedInstanceState);
	......
    if (WGPlatform.wakeUpFromHall(this.getIntent())) {
    	// 호출한 플랫폼은 게임 로비이다 
    	Logger.d("LoginPlatform is Hall");
    } else {  
    	// 호출한 플랫폼은 게임 로비가 이니다
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

개인 정보 조회
------

유저가 위챗 인증 통과 후 openId와 accessToken만 획득할 수 있고 게임은 유저 닉네임, 아바타 등 기타 정보를 화면에 출력해야 한다. SDK가 현재 획득할 수 있는 정보는 nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city를 포함한다. 이 기능 구현에 필요한 인터페이스는: WGQueryWXMyInfo, 인터페이스의 자세한 설명은 다음과 같다.

#### 인터페이스 선언:

	/**
	 *   OnRelationNotify에 콜백, 그중 RelationRet.persons는 하나의 Vector이며 Vector 첫항이 곧 자신의 자료이다
	 *   개인 정보는 nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city 포함
	 */
	bool WGQueryWXMyInfo();

#### 호출 샘플 코드:

	WGPlatform::GetInstance()->WGQueryWXMyInfo();

#### 콜백 구현(Demo) 코드:

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // relationRet.persons.at(0) 에 저장된 것이 개인 정보이다
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


친구 정보 조회
------

유저가 위챗을 통해 게임 인증을 받은 후 게임내 친구 정보(친구 점수 랭킹 등)를 불러와야 한다. SDK가 현재 획득할 수 있는 정보는 nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city를 포함한다. 이 기능 구현에 필요한 인터페이스는: WGQueryWXGameFriendsInfo, 인터페이스의 자세한 설명은 다음과 같다.
#### 인터페이스 선언:

	/**
	 * 위챗 친구 정보 획득, OnRelationNotify에 콜백,
	 *   OnRelationNotify에 콜백, 그중 RelationRet.persons는 하나의 Vector이며 Vector 내용이 곧 친구 정보이다
	 *   친구 정보는 nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city 포함
	 */
	bool WGQueryWXGameFriendsInfo();

이 인터페이스의 호출 결과는 OnRelationCallBack(RelationRet& relationRet) 콜백을 통해 게임에 데이터를 반환한다. RelationRet 객체의 persons 속성은 하나의 Vector<PersonInfo>이며, 그중 각 PersonInfo 객체가 곧 친구 정보이다. 친구 정보는 nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city를 포함한다.

#### 호출 샘플 코드:

	WGPlatform::GetInstance()->WGQueryWXGameFriendsInfo();

#### 콜백 구현(Demo) 코드:

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
	case eFlag_Succ: {
		// relationRet.persons.at(0) 에 저장된 것이 개인 정보이다
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

구조화 메시지 공유
------

이런 메시지 공유는 위챗 클라이언트를 실행해야 하며 전체 공유 과정을 진행하려면 유저의 참여가 필요하다. 게임 내외 친구에게 공유할 수 있으며 일반적으로 게임밖 친구를 초대하는 데 사용된다. 
메시지를 공유한 후 수신자는 메시지를 클릭하여 게임을 실행할 수 있다. 이 기능 구현에 필요한 인터페이스는: WGSendToWeixin, 인터페이스의 자세한 설명은 다음과 같다.

#### 인터페이스 선언

	/**
	 * @param title 구조화 메시지 제목(주의: 길이를 512Bytes 이하로 제한)
	 * @param desc 구조화 메시지 개요 정보(주의: 길이를 1KB 이하로 제한)
	 * @param mediaTagName 실제 상황에 따라 아래 값 중 하나 입력. 이 값은 위챗에 통계용으로 제공. 공유 리턴 시에도 이 값을 반환하며 공유 소스 구분용으로 사용된다
		 "MSG_INVITE";                   // 초대
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //금주 최고를 모멘트에 공유
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //사상 최고를 모멘트에 공유
		 "MSG_SHARE_MOMENT_CROWN";         //금관을 모멘트에 공유
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //금주 최고를 친구에게 공유
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //사상 최고를 친구에게 공유
		 "MSG_SHARE_FRIEND_CROWN";          //금관을 친구에게 공유
		 "MSG_friend_exceed"         // 초월 자랑하기
		 "MSG_heart_send"            // 하트 보내기
	 * @param thumbImgData 구조화 메시지 썸네일
	 * @param thumbImgDataLen 구조화 메시지 썸네일 데이터 길이(주의: 내용은 32KB 이하로 제한된다)
	 * @param messageExt 게임 공유시 전송한 문자열, 이 메시지를 통해 게임을 실행하면 OnWakeUpNotify(WakeupRet ret) 중 ret.messageExt를 통해 게임에 리턴한다
	 * @return void
	 *   게임이 설정한 전역 콜백의 OnShareNotify(ShareRet& shareRet)를 통해 리턴 데이터를 게임에 콜백한다. shareRet.flag 값은 반환 상태를 표시하고 가능한 값과 설명은 다음과 같다.
	 *     eFlag_Succ: 공유 성공
	 *     eFlag_Error: 공유 실패
	 */
	 void WGSendToWeixin(
		unsigned char* title, 
		unsigned char* desc,
		unsigned char* mediaTagName,
		unsigned char* thumbImgData,
		const int& thumbImgDataLen, 
		unsigned char* messageExt
	); 

#### 인터페이스 호출

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

#### 콜백 구현(Demo) 코드

	virtual void OnShareNotify(ShareRet& shareRet) {
	// 공유 콜백 처리
	if (shareRet.platform == ePlatform_QQ) {
		…
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 공유 성공
			break;
		case eFlag_Error:
			// 공유 실패
			break;
		}
		}
	}
	
#### 주의사항

1. 위챗 공유는 위챗 버전이 반드시 4.0보다 높아야 한다
2. `썸네일 용량은 32k를 초과하지 못하고` 길이와 너비 비율은 제한하지 않는다. 용량을 초과하면 위챗을 실행하지 못한다
3. 공유는 sd카드를 사용해야 한다. sd카드가 없거나 sd카드가 점용되면 공유 실패를 초래하게 된다


빅이미지 메시지 공유
------
이런 메시지 공유는 위챗을 실행해야 하며 전체 공유 과정을 진행하려면 유저의 참여가 필요하다. 게임 내외 친구에게 공유할 수 있으며 일반적으로 성적 자랑하기 또는 자세한 그림이 필요한 기능에 사용된다. 이런 메시지는 대화(친구) 또는 모멘트에 공유할 수 있다. 위챗 4.0 및 이상은 대화 공유를 지원하고 위챗 4.2 및 이상은 모멘트 공유를 지원한다. 이미지 용량은 10M를 초과하지 못하고 위챗은 공유한 이미지에 대해 필요한 압축 처리를 진행한다. 이 기능 구현에 필요한 인터페이스는: WGSendToWeixinWithPhoto, 인터페이스의 자세한 설명은 다음과 같다.
#### 인터페이스 선언

	/**
	 * @param scene 모멘트 또는 위챗 대화에 지정하여 공유, 가능한 값과 역할은 다음과 같다.
	 *   WechatScene_Session: 위챗 대화에 공유
	 *   WechatScene_Timeline: 위챗 모멘트에 공유
	 * @param mediaTagName 실제 상황에 따라 아래 값 중 하나 입력. 이 값은 위챗에 통계용으로 제공. 공유 리턴 시에도 이 값을 반환하며 공유 소스 구분용으로 사용된다
		 "MSG_INVITE";                   // 초대
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //금주 최고를 모멘트에 공유
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //사상 최고를 모멘트에 공유
		 "MSG_SHARE_MOMENT_CROWN";         //금관을 모멘트에 공유
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //금주 최고를 친구에게 공유
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //사상 최고를 친구에게 공유
		 "MSG_SHARE_FRIEND_CROWN";          //금관을 친구에게 공유
		 "MSG_friend_exceed"         // 초월 자랑하기
		 "MSG_heart_send"            // 하트 보내기
	 * @param imgData 이미지 원본 파일 데이터
	 * @param imgDataLen 이미지 원본 파일 데이터 길이(이미지 크기는 10M를 초과하지 못함)
	 * @param messageExt 게임 공유시 전송한 문자열, 이 메시지를 통해 게임을 실행하면 OnWakeUpNotify(WakeupRet ret) 중 ret.messageExt를 통해 게임에 리턴한다
	 * @param messageAction scene이 1(위챗 모멘트에 공유)인 경우에만 유효
	 *   WECHAT_SNS_JUMP_SHOWRANK       랭킹 이동
	 *   WECHAT_SNS_JUMP_URL            링크 이동
	 *   WECHAT_SNS_JUMP_APP           APP 이동
	 * @return void
	 *   게임이 설정한 전역 콜백의 OnShareNotify(ShareRet& shareRet)를 통해 리턴 데이터를 게임에 콜백한다. shareRet.flag 값은 반환 상태를 표시하고 가능한 값과 설명은 다음과 같다.
	 *     eFlag_Succ: 공유 성공
	 *     eFlag_Error: 공유 실패
	 */
	void WGSendToWeixinWithPhoto(
	const eWechatScene &scene,
	unsigned char *mediaTagName,
	unsigned char *imgData, 
	const int &imgDataLen,
	unsigned char *messageExt,
	unsigned char *messageAction
	);

#### 인터페이스 호출

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

#### 콜백 구현(Demo) 코드

	virtual void OnShareNotify(ShareRet& shareRet) {
	LOGD("OnShareNotify: platform:%d flag:%d",
			shareRet.platform, shareRet.flag);
	// 공유 콜백 처리
	if (shareRet.platform == ePlatform_QQ) {
		… // 모바일QQ 공유 리턴의 콜백 처리
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 공유 성공
			break;
		case eFlag_Error:
			// 공유 실패
			break;
			}
		}
	}

#### 주의사항:
- **모멘트 버튼에 네트워크 지연이 표시되고 반드시 위챗 5.1 및 이상 버전이어야 한다**
- `빅 이미지 공유시 이미지 사이즈는 10M초과 하면 안 되고`，그렇지 않으면 공유 실패할 것이다

음악 메시지 공유
------
이런 메시지 공유는 위챗 클라이언트를 실행해야 하며 전체 공유 과정을 진행하려면 유저의 참여가 필요하다. 게임 내외 친구에게 공유할 수 있으며 일반적으로 게임밖 친구를 초대하는 데 사용된다. 
메시지를 공유한 후 수신자는 메시지를 클릭하여 게임을 실행할 수 있다. 이 기능 구현에 필요한 인터페이스는: WGSendToWeixinWithMusic, 인터페이스의 자세한 설명은 다음과 같다.
#### 인터페이스 선언

	/**
	 * 음악 소식을 위챗 친구에게 공유
	 * @param scene 모멘트 또는 위챗 대화에 지정하여 공유, 가능한 값과 역할은 다음과 같다.
	 *   WechatScene_Session: 위챗 대화에 공유
	 *   WechatScene_Timeline: 위챗 모멘트에 공유(이런 메시지는 모멘트에 공유하지 못하도록 제한되었음)
	 * @param title 음악 소식 제목(주의: 길이는 512Bytes를 초과하지 못함)
	 * @param desc	음악 소식 개요 정보(주의: 길이는 1KB를 초과하지 못함)
	 * @param musicUrl	음악 소식의 타겟 URL
	 * @param musicDataUrl	음악 소식의 데이터 URL
	 * @param imgData 이미지 원본 파일 데이터
	 * @param imgDataLen 이미지 원본 파일 데이터 길이(이미지 용량은 10M를 초과하지 못함)
	 * @param messageExt 게임 공유시 전송한 문자열, 이 공유 메시지를 통해 게임을 실행하면 OnWakeUpNotify(WakeupRet ret) 중 ret.messageExt를 통해 게임에 리턴한다
	 * @param messageAction scene이 WechatScene_Timeline(위챗 모멘트에 공유)인 경우에만 유효
	 *   WECHAT_SNS_JUMP_SHOWRANK       랭킹 이동, 랭킹 확인
	 *   WECHAT_SNS_JUMP_URL            링크 이동, 세부정보 보기
	 *   WECHAT_SNS_JUMP_APP            APP 이동, 즐겨보자
	 * @return void
	 *   게임이 설정한 전역 콜백의 OnShareNotify(ShareRet& shareRet)를 통해 리턴 데이터를 게임에 콜백한다. shareRet.flag 값은 반환 상태를 표시하고 가능한 값과 설명은 다음과 같다.
	 *     eFlag_Succ: 공유 성공
	 *     eFlag_Error: 공유 실패
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

백엔드 공유
------
게임이 지정된 친구(지정된 친구의 openId)에게 메시지 공유. 이런 공유는 위챗 클라이언트를 실행하지 않고 유저가 공유 과정에 참여할 필요가 없이 인터페이스만 호출하면 공유를 완료할 수 있지만 게임내 친구에게만 공유가 가능하다. 메시지를 공유한 후 수신자는 메시지를 클릭하면 게임을 실행할 수 있다. 이 기능 구현에 필요한 인터페이스는: `WGSendToWXGameFriend`. 이 인터페이스는 역사적 이유로 인해 C++인터페이스와 Java 인터페이스 파라미터 순서가 부동하다. 자세한 설명은 다음과 같다.

#### 인터페이스 설명

##### C++인터페이스

	/**
	 * 이 인터페이스는 WGSendToQQGameFriend와 유사하다. 이 인터페이스는 메시지를 위챗 친구에게 공유하는 데 사용되며 공유시 반드시 친구 openid를 지정해야 한다
	 * @param fOpenId 친구의openid
	 * @param title 제목 공유
	 * @param description 설명 공유
	 * @param mediaId 이미지 id는 백그라운드 인터페이스/share/upload_wx를 통해 획득
	 * @param messageExt 게임 공유시 전송한 문자열, 이 메시지를 통해 게임을 실행하면 OnWakeUpNotify(WakeupRet ret) 중 ret.messageExt를 통해 게임에 리턴한다
	 * @param mediaTagName 실제 상황에 따라 아래 값 중 하나 입력. 이 값은 위챗에 통계용으로 제공. 공유 리턴 시에도 이 값을 반환하며 공유 소스 구분용으로 사용된다
		 "MSG_INVITE";                   // 초대
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //금주 최고를 모멘트에 공유
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //사상 최고를 모멘트에 공유
		 "MSG_SHARE_MOMENT_CROWN";         //금관을 모멘트에 공유
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //금주 최고를 친구에게 공유
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //사상 최고를 친구에게 공유
		 "MSG_SHARE_FRIEND_CROWN";          //금관을 친구에게 공유
		 "MSG_friend_exceed"         // 초월 자랑하기
		 "MSG_heart_send"            // 하트 보내기
	 * @param extMsdkInfo 게임 자체정의 투과전송 필드, 공유 결과 shareRet.extInfo를 통해 게임에 반환. 게임은 extInfo을 이용하여 request 구분 가능
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

##### Java 인터페이스

```
/**
 * 	 * 이 인터페이스는 WGSendToQQGameFriend와 유사하다. 이 인터페이스는 메시지를 위챗 친구에게 공유하는 데 사용되며 공유시 반드시 친구 openid를 지정해야 한다
 * @param friendOpenId 친구의 openid
 * @param title 제목 공유
 * @param description 설명 공유
 * @param messageExt 게임 공유시 전송한 문자열, 이 메시지를 통해 게임을 실행하면 OnWakeUpNotify(WakeupRet ret) 중 ret.messageExt를 통해 게임에 리턴한다
 * @param mediaTagName 실제 상황에 따라 아래 값 중 하나 입력. 이 값은 위챗에 통계용으로 제공. 공유 리턴 시에도 이 값을 반환하며 공유 소스 구분용으로 사용된다
	 "MSG_INVITE";                   // 초대
	 "MSG_SHARE_MOMENT_HIGH_SCORE";    //금주 최고를 모멘트에 공유
	 "MSG_SHARE_MOMENT_BEST_SCORE";    //사상 최고를 모멘트에 공유
	 "MSG_SHARE_MOMENT_CROWN";         //금관을 모멘트에 공유
	 "MSG_SHARE_FRIEND_HIGH_SCORE";     //금주 최고를 친구에게 공유
	 "MSG_SHARE_FRIEND_BEST_SCORE";     //사상 최고를 친구에게 공유
	 "MSG_SHARE_FRIEND_CROWN";          //금관을 친구에게 공유
	 "MSG_friend_exceed"         // 초월 자랑하기
	 "MSG_heart_send"            // 하트 보내기
 * @param thumbMediaId 이미지 id 는 백그라운드 인터페이스 /share/upload_wx를 통해 획득
 * @param extMsdkInfo 게임 자체정의 투과전송 필드, 공유 결과 shareRet.extInfo를 통해 게임에 반환. 게임은 extInfo을 이용하여 request 구분 가능
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

#### 인터페이스 호출

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

#### 콜백 구현(Demo) 코드

	virtual void OnShareNotify(ShareRet& shareRet) {
	// 공유 콜백 처리
	if (shareRet.platform == ePlatform_QQ) {
		…
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 공유 성공
			break;
		case eFlag_Error:
			// 공유 실패
			break;
		}
		}
	}

링크 공유
------

링크 메시지는 구조화 메시지의 하나로서 위챗 구조화 메시지가 구조체 클릭하여 이동하는 기능을 지원 못하기 때문에 링크 메시지를 추가한다.링크 메시지는 임의 친구에게 전송할 수 있고 구조체를 클릭하면 링크 열 수 있다.때문에 링크 메시지는 초대, 자랑하기, 이벤트 페이지 공유에 자주 사용한다.

#### 인터페이스 선언

```
/**
 * @param title 링크 메시지의 타이틀
 * @param desc 링크 메시지 개요
 * @param url 공유 URL
 * @param mediaTagName 실제 상황에 따라 아래 값중 하나 선택해서 작성.해당 값은 위챗으로 전송되어 통계하는 데 사용한다. 공유 리턴할 때 공유의 출처를 구분하기 위해해당 값을 가지고 리턴할 것이다
 "MSG_INVITE";                   // 초대
 "MSG_SHARE_MOMENT_HIGH_SCORE";    //금주 최고점을 모멘트로 공유
 "MSG_SHARE_MOMENT_BEST_SCORE";    //역대 최고점을 모멘트로 공유
 "MSG_SHARE_MOMENT_CROWN";         //금크라운를 모멘트로 공유
 "MSG_SHARE_FRIEND_HIGH_SCORE";     //금주 최고점을 친구에게 공유
 "MSG_SHARE_FRIEND_BEST_SCORE";     //역대 최고점을 친구에게 공유
 "MSG_SHARE_FRIEND_CROWN";          //금크라운을 친구에게 공유
 "MSG_friend_exceed"         // 초월 저랑하기
 "MSG_heart_send"            // 하트 보내기
 * @param thumbImgData 구조화 메시지 약도
 * @param thumbImgDataLen 구조화 메시지 약도 데이터 길이
 * @param messageExt 게임 공유는 스트링을 전송하는 것이고 해당 메시지로 게임 호출하여 OnWakeUpNotify(WakeupRet ret)에 있는 ret.messageExt를 통해 게임에 리턴한다.
 * @return void
 *   게임 설정하는 전역 콜백의 OnShareNotify(ShareRet& shareRet)를 통해 콜백하여 데이터를 게임에 리턴한다. shareRet.flag값은 리턴 상태를 표시하며, 가능한 값 및 설명은 아래와 같다:
 *     eFlag_Succ: 공유 성공
 *     eFlag_Error: 공유 실패
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

#### 호출 예시

```
String title = "title";
String desc = "desc";
String mediaTagName = "MSG_INVITE";
String messageExt = "message Ext";
Bitmap thumb = BitmapFactory.decodeResource(mMainActivity.getResources(),
		R.drawable.ic_launcher);
byte[] imgData = CommonUtil.bitmap2Bytes(thumb);
String url = "www.qq.com";
if ("cpp".equals(ModuleManager.LANG)) { // C++를 사용하여 MSDK 호출, 게임은 한 가지 방법이 있으면 된다
	PlatformTest.WGSendToWeixinWithUrl(scene, title, desc, url,
			mediaTagName, imgData, imgData.length, messageExt);
} else if ("java".equals(ModuleManager.LANG)) { // Java를 사용하여 MSDK호출
	WGPlatform.WGSendToWeixinWithUrl(scene, title, desc, url, 
			mediaTagName, imgData, imgData.length, messageExt);
}
```
	
Android 위챗 로그인 실패시 검사 절차
------

### 1단계: Log에

	lauchWXPlatForm wx SendReqRet: true 가 있는 지 검사.

있으면 성공적으로 위챗에 요청을 보냈음을 표시

위챗 클라이언트를 실행하지 못하면 2단계 참조
위챗 클라이언트가 실행되었지만 콜백이 없으면 3단계 참조

### 2단계: 서명 및 패키지명 검사

[https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk](https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk)를 내려받아 이 apk를 휴대폰에 설치한다. 입력창에 게임 서명을 입력하고 버튼을 클릭하여 게임 패키지 서명을 획득한다.

![서명 검사](./wechat_GenSig.png "서명 검사")

상기 툴로 획득한 서명과 위챗 백그라운드에 설정된 서명의 일치 여부 확인(위챗 백그라운드에 설정된 서명 정보 조회는 RTX에서 MSDK 연락 바람)

### 3단계: WXEntryActivity.java 배치 위치 검사(이 파일은 MSDKSample에 있음)

이 파일은 반드시 게임 +.wxapi 에 있어야 한다. 예하면, 게임 패키지명: com.tencent.msdkgame이면 WXEntryActivity.java는 com.tencent.msdkgame.wxapi에 있어야 한다. 동시에 WXEntryActivity 내용과 아래 내용의 일치성 여부를 확인

	/**
	 * !!사용자는 이 파일의 코드 로직 부분을 변경하지 못한다. MSDK는 1.7부터 부모 클래스는 WXEntryActivity에서 BaseWXEntryActivity로 변경된다. 이 파일에 오류가 발생하면 이 내용을 우선적으로 검사
	 */
	public class WXEntryActivity extends com.tencent.msdk.weixin.BaseWXEntryActivity { }

이 단계에 문제가 없으면 4단계 참조


### 4단계: handleCallback 검사

게임 Launch Activity의 onCreate와 onNewIntent에서 WGPlatform.handleCallback 호출 여부


### 5단계: 게임의 전역 Observer 설정 여부 검사

게임이 WGSetObserver(C++계층과 Java 계층)를 정확히 호출했는 지 검사


변경 역사
===

## 2.6.0
- 【코드 변경】
  1.【MSDKFoundation】
	* 로그 기록（MSDKLogger）이 NSUserdefaults에 대한 빈범 방문을 수정하여 crash가능성 낮춘다.
	* idfa의 획득 및 보고를 추가하여 향후 게임 IOS 심의에 제출할 때, iTC에서 iAD관련 옵션을 선택해야 한다.（[설명](http://km.oa.com/articles/show/234073)），공정에서 AdSupport.framework도입해야 한다；
	
  2.【MSDK】
	* 2.5.0버전에 토큰 자동 갱신 메커니즘 bug 수정된다；
	* 2.5.0버전에 로그인되지 않았을 경우에 appid획득 오류 보고 받는 문제를 수정된다；
	* 토큰 갱신 메커니즘 최적화, 상세한 설명은 [MSDK2.6.0i및 이후버전의 토큰 자동 갱신 프로세스](login.md#MSDK2.6.0i및 이후버전의 토큰 자동 갱신 프로세스)에서 참고 ；
	* QQ는 내부 블라우저 형식을 통해 공유 가능. 해당 기능을 사용하려면 게임은 OpenApiHelper에게 QQ H5공유 권한 오픈을 신청해야 한다. 공유 조작은 게임 내부 브라우저에서 완료하므로 심의 리스크를 피할 수 있다；
- 【모듈 업데이트】
	* 【업데이트】OpenSDK를 2.8.1버전으로 업데이트하여 QQ H5공유 기능을 지원하도록 한다.

## 2.5.0
- 【코드 변경】
1.【신규 추가】올라인 시간 집계 보고 새로 추가.
2.【신규 추가】내장 브라우저 공유 입구 스위치를 새로 추가.info.plist파일에서 MSDK_WebView_Share_SWITCH 설정할 수 있고 YES일 경우 내장 브라우저는 공유 버튼을 표시하고 NO일 경우는 버튼 표시 안 한다.
3.【수정】Guest모드 최적화，keychain데이터 백업을 진행.
4.【수정】내장 브라우저가 iOS5.1.1시스템의 iPad 단말에서 위챗을 호출하여 공유하지 못하는 bug를 수정.
- 【플러그인 새로 추가】
1.【신규 추가】demo에서 모바일 게임 조수 SDK통합하고 게임은 수요에 따라 통합 진행.

## 2.4.0
- 【코드 변경】
1.【수정】MSDK모듈화 하여 기능에 의하여 4모듈로 나눈다：
  1. MSDKFoundation：기초 의뢰 라이브러리, 기타 라이브러리를 사용하려면 우선 해당 이 프레임을 도입해야 한다.
  2. MSDK:QQ와 위챗 로그인, 공유 기능；
  3. MSDKMarketing：크로스 마케팅, 내장 브라우저 기능을 제공한다.공지, 내장 브라우저 필요한 리소스 파일은 WGPlatformResources.bundle파일에 있다.
  4. MSDKXG：XG Push기능을 제공.
  위에 언급한 4 모듈은 동시에 C99 및 C11언어 기준을 제공 가능하다. 그 중에 **_C11패킷은 C11버전이다.
  ![linkBundle](./2.4.0_structure_of_framework.png)
  
  C++인터페이스를 사용하려면 아래 몇가지 헤더 파일을 도입하면 된다：
```
<MSDKFoundation/MSDKStructs.h>
<MSDK/WGInterface.h>
<MSDK/WGPlatform.h>
<MSDK/WGPlatformObserver.h>
```  
    그 외에, 모듈화 버전은 2.3.4 및 이전 버전의 Observer콜백을 지원 가능할 뿐만 아니라 delegate콜백을 새로 추가했다. 여기서는 QQ 인증 로그인을 예로 설명한다（기타 인터페이스는 각 인터페이스의 설명 문서를 참고）：
    원래의 인증 호출 코드는 아래와 같다：
```
WGPlatform* plat = WGPlatform::GetInstance();//MSDK 초기화
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);//콜백 설정
plat->WGSetPermission(eOPEN_ALL);//인증 권한 설정
plat->WGLogin(ePlatform_QQ);//QQ클라이언트 혹 web 호출해서 인증 진행
```
    원래의 인증 호출 코드는 아래와 같다：
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
    2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *authService = [[MSDKAuthService alloc] init];
[authService setPermission:eOPEN_ALL];
[authService login:ePlatform_QQ];
```
    콜백 코드는 아래와 같다：
```
-(void)OnLoginWithLoginRet:(MSDKLoginRet *)ret
{
//내부 실현 로직은 void MyObserver::OnLoginNotify(LoginRet& loginRet)와 같다
}
```


## 2.3.4
 - 【플러그인 업데이트】
1.【수정】OpenSDK2.5.1 업데이트，5.1.1버전에 crash문제를 수정.

## 2.3.3
 - [코드 변경]
1.[수정]로그인하지 않았을 때 모바일QQ 빠른실행이 초래한 crash 수정.
2.[수정]게스트 모드 최초 로그인시 pf와 pfkey가 없는 문제 수정
 - [컴포넌트 업데이트]
1.[수정]MTA1.4.2 업데이트, SDK8에서 컴파일한 프로젝트 crash 취약점 보완

## 2.3.2
 - [코드 변경]
1.[수정]OpenSDK2.5.1 업데이트, iOS8.1.1에서 모바일QQ가 설치되지 않았을 때 webView를 사용하여 정상적으로 로그인하지 못하는 문제 수정
 - [컴파일 변경]
1. Tencent_MSDK_IOS_V2.3.2i(arm32, iOS SDK7 컴파일 지원): 일부 게임 엔진이 iOS SDK8을 충분히 지원하지 못하기에 MSDK는 iOS SDK7로 32비트 패키지를 컴파일하여 이런 게임에 제공.
2. Tencent_MSDK_IOS_V2.3.2i(arm64, iOS SDK8 컴파일 지원): iOS SDK8로 컴파일한 arm64를 지원하는 패키지.
---

## 2.3.1
 - [코드 변경]
1.[수정]RQD와 등탑 업데이트, Crash 리포팅 자체가 초래하는 Crash 취약점 수정
---

## 2.3.0

 - [코드 변경]
1.[수정]리소스 파일을 WGplatformResources.bundle에 패키징
2.[삭제]MIDAS 디커플링, 다음 인터페이스 삭제:
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
3. [추가]위챗 공유 URL 인터페이스:
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
4.[추가]푸시 메인 스위치, plist에서 MSDK_PUSH_SWITCH(string)를 ON으로 설정해야 한다. 다른 값을 사용하거나 설정하지 않으면 푸시 실패
5.[수정]롤링 공지 구성 항목 중 (top,left,width) 설정 삭제, 공지를 상단에 배치할 때 화면 폭 전부 차지, 높이를 설정하지 않으면 기본값 30pt 사용
6.[추가]iOS8 지원, LBS 인터페이스는 plist 필드 requestWhenInUseAuthorization을 추가해야 함, 공지 광고 등 표시 오류 복구
7.[수정]Guest의 저장에 대해 최적화 진행, App별로 부동한 key에 저장하여 기업 인증서가 Guest데이터에 기록되어 서로 덮어쓰는 것을 방지. 이 외에, 이전 로직을 추가하여 진행률 손실 방지.
8.[수정]2개의 try－catch 보호를 추가하여 user default 읽기 및 쓰기를 할 때 crash 방지

 - [BUG 수정]
1. [수정]모바일QQ 인게임 친구 추가, 친구 비고 및 신청 정보가 뒤바뀌는 문제 수정
2. [수정]광고 불러오기 os=1(안드로이드) 문제 수정
3. [수정]AHAlertView 및 서브 클래스가 가로 화면에서 발생하는 표시 오류 수정
4. [수정]WGRotationView 및 서브 클래스가 가로/세로 화면 ios7,8에서 발생하는 표시 오류 수정
5. [수정]게스트 모드 인증서가 부동한 앱에서 guestid를 서로 덮어쓰는 문제 수정
6. [수정]내장 브라우저 공유 화면이 iOS7,8에서 발생하는 표시 문제 수정
7. [수정]내장 브라우저 광고 버튼이 광고가 없을 때에도 표시되는 문제 수정
8. [수정]게스트 모드가 등록 정보를 전송할 때 일정 확률로 실패하는 문제 수정
9. [수정]RDM Crash 리포팅시 AppID가 리포팅되지 않는 문제 수정

---

## 2.2.0
- [코드 변경]
1. 클라우드로 로컬 중요 로그의 리포팅 제어
2. MSDK가 http 헤더의 User-agent 필드에 단말기 소스 정보를 추가하는 수요
3. XG PUSH가 전량 유저 발송	새로운 수요, plist에서 MSDK_XGPUSH_URL 설정 필요
4. MSDK의 위챗 개인정보 패키징 인터페이스

---

##2.1.0
- [코드 변경]
1. 광고 특성 추가, WGShowAD(_eADType& scene) 인터페이스를 호출하여 광고 표시, WGADObserver를 추가하여 광고 클릭 콜백; 광고 관련 설정을 MsdkResources/AdvertisementResources/AdvertisementConfig.plist에 배치
2. WGGetLocationInfo 인터페이스와 OnLocationGotNotify 콜백 추가, 유저 GPS 주소를 획득하고 MSDK 백그라운드에 리포팅;
3. WGGetNearBy 인터페이스에 gpsCity 리턴 추가;
4. 내장 브라우저 링크에 평문 openid 보충;
5. LoginInfo 클래스 추가, 리플렉션 형식으로 로그인 토큰 획득, 커플링 감소. 코드 사용 예:
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
 - [코드 변경]
1.[수정]OpenSDK2.5.1 업데이트, iOS8.1.1에서 모바일QQ가 설치되지 않았을 때 webView를 사용하여 정상적으로 로그인하지 못하는 문제 수정
---

## 2.0.6
 - [코드 변경]
1.[수정]Crash 리포팅시 AppID와 OpenId 추가 리포팅
2.[수정]RQD와 등탑 업데이트, Crash 리포팅이 초래한 Crash 취약점 수정
---

##2.0.5
- [코드 변경]
1.애플 고유 인터페이스를 사용하는 코드 삭제

---

##2.0.4
- [코드 변경]
2.0.2i와 2.0.3i를 통합한 버전, 새로운 기능을 추가하지 않음

---

##2.0.3
- [코드 변경]
1. [추가]WGPlatform.h 다음 인터페이스 추가:
```
   /**
     *  게스트 모드에서의 id 획득
     * 
     *
     */
    std::string WGGetGuestID();
    
    /**
     *  게스트 모드에서의 id 새로고침
     *
     *
     */
    void WGResetGuestID();
```
2. [삭제]다음 인터페이스 삭제:
```
    void WGRegisterAPNSPushNotification(NSDictionary *dict);
    void WGSuccessedRegisterdAPNSWithToken(NSData *data);
    void WGFailedRegisteredAPNS();
    void WGCleanBadgeNumber();
    void WGReceivedMSGFromAPNSWithDict(NSDictionary* userInfo);
```
3. [수정]WGPublicDefine.h 잘못된 #endif 매크로 위치 수정;
4. [추가]공공 파일 WGApnsInterface 추가, 다음 인터페이스 포함:
```
    + (void)WGRegisterAPNSPushNotification:(NSDictionary*)dict;
    + (void)WGSuccessedRegisterdAPNSWithToken:(NSData *)data;
    + (void)WGFailedRegisteredAPNS;
    + (void)WGCleanBadgeNumber;
    + (void)WGReceivedMSGFromAPNSWithDict:(NSDictionary*) userInfo;
```
5. [추가]내부 파일 GuestInterface를 추가하여 게스트 모드 로직 처리

[문서 조정]
1. [추가]제13장: 게스트 모드 관련 설명;
2. [추가]제1장: 한번에 C99와 C11 패키지를 생성하는 설명 추가;
2. [추가]제12장: APNS 관련 설명 수정, WGApnsInterface 호출로 변경

---

##2.0.2
- [코드 변경]
1. 게임내 친구를 추가하는 3개 인터페이스, OpenSDK2.5 업데이트, 알맞는 모바일QQ 신버전을 사용해야 한다.
```
    /**
	 * 게임에서 그룹 추가, 길드가 qq그룹을 성공적으로 바인딩한 후 길드원은 “그룹 추가” 버튼을 클릭하여 길드 그룹에 가입할 수 있다
	 * @param cQQGroupKey 추가해야 할 QQ그룹에 대응되는 key. 게임 server는 openAPI 인터페이스를 호출하여 획득할 수 있다. 호출 방법은 RTX를 통해 OpenAPIHelper에 문의
	 */
	void WGJoinQQGroup(unsigned char* cQQGroupKey);
	/**
	 * 게임 그룹 바인딩: 게임 길드/연맹 내에서 길드장은 “바인딩” 버튼을 클릭하여 길드장이 만든 그룹을 불러와 해당 길드의 길드 그룹으로 바인딩시킬 수 있다
	 * @param cUnionid 길드ID, opensdk는 숫자만 입력 가능 문자를 입력하면 바인딩 실패를 초래할 수 있음
	 * @param cUnion_name 길드명
	 * @param cZoneid 큰구역ID，opensdk는 숫자만 입력 가능 문자를 입력하면 바인딩 실패를 초래할 수 있음
	 * @param cSignature 게임 맹주 신분 인증 서명, 생성 알고리즘은openid_appid_appkey_길드id_구역id md5 생성.
	 * 					   이 방법으로도 바인딩에 실패하면 RTX를 통해 OpenAPIHelper에게 문의
	 *
	 */
	void WGBindQQGroup(unsigned char* cUnionid, unsigned char* cUnion_name,
                       unsigned char* cZoneid, unsigned char* cSignature);
	/**
	 * 인게임 친구 추가
	 * @param cFopenid 추가할 친구의 openid
	 * @param cDesc 추가할 치구의 비고
	 * @param cMessage 친구 추가시 전송한 인증 정보
	 */
	void WGAddGameFriendToQQ(unsigned char* cFopenid, unsigned char* cDesc,
                             unsigned char* cMessage);
```
---

##2.0.1
- [코드 변경]
1. 공지에 이미지 공지 유형 추가, 공지 구조체에 이미지 데이터 추가, 자세한 내용은 MSDK 액세스 문서 2.0 참조
2. LoginWithLocalInfo 인터페이스를 추가하여 토큰 검증, 게임 시작 또는 백그라운드에서 포어그라운드로 전환할 때 이 방법 호출.

---

##2.0.0
- [코드 변경]
1. 브라우저 기능 최적화, 내장 브라우저 수정;
2. 이미지, 웹페이지 공지 유형 추가; 정기적으로 공지 데이터 다운로드;
3. 자동 로그인 프로세스 추가, 토큰 검증 진행, 정기적으로 accessToken 등 토큰 갱신;
4. 모바일QQ sdk1.1.1 버전 업데이트, 모바일QQ 인증 게임이 회수되어 인증에 실패하는 bug 수정;
5. 로컬 로그 방안, info.plist에서 MSDK_LOG_TO_FILE을 YES로 설정, MSDK를 기록한 로그를 Caches/msdk.log에 출력;

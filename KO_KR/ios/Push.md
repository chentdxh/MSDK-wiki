메시지 푸시
===

 > 버전 2.2부터 MSDK는 XG Push를 연동할 수 있습니다.[XG 공홈](http://xg.qq.com/)。

##개요

 - info.plist에서 푸시 스위치 설정. 아래 이미지 참조 바랍니다.
![Alt text](./Push1.png)
이미 XG Push를 연동한 게임은 MSDK2.3.0 업데이트 시 MSDK의 XG Push를 닫으려면 이 스위치를 구성하지 않거나 OFF로 설정해야 합니다. 기타 게임은 MSDK의 XG Push를 연동하면 스위치를 ON으로 설정해야 합니다.
MSDK2.4.0i 이후 버전에서 해당 값은 이미 Boolean타입으로 수정되었고 Info.plist수정 바랍니다.

 - MSDK ios 푸시는 애플 APNS에 의존하여 구현됩니다. developer.apple.com에서 앱 푸시 기능을 개통하고 푸시 인증서 및 서명 파일을 생성해야 합니다(.mobileprovision)
 - 푸시 ssl 인증서: MSDK는 이 인증서를 이용하여 앱에 푸시 메시지를 발송하므로 이 인증서와 비밀번호를 MSDK에 제공하여 dev.ied.com에서 이 인증서를 설정해야 합니다.
 - 시그네쳐 파일: 게임 런칭 시 프로젝트 Build PhasesProvisioning Profile에서 이 시그네쳐 파일을 설정해야 합니다.
 - 게임은 UIApplicationDelegate에서 푸시와 관련된 5개 방법도 구현해야 합니다.
>*게임에서 MSDK 푸시 기능을 테스트할 시 공식 푸시 인증서를 사용하여 AD Hoc 방식으로 패킹 후 테스트를 진행해야 합니다. 이럴 경우 전량 푸시 방식은 금지입니다!*

##pem증서 만들고 올리기
 - 증서 만들기

XG 공식 사이트에서 제공하는 절차에 따라 pem증서를 만듭니다.[만들기 절차](http://developer.xg.qq.com/index.php/IOS_%E8%AF%81%E4%B9%A6%E8%AE%BE%E7%BD%AE%E6%8C%87%E5%8D%97).

만들기 절차 내용 오픈 불가할 경우[여기 클릭](http://developer.xg.qq.com/index.php/Main_Page)，오픈된 페이지에서 좌측 안내탭에 있는iOS SDK->iOS 증사 설정 가이드를 클릭하면 됩니다.아래 이미지처럼：

![Alt text](./Push2.png)

 - 증서 올리기
### Step1:
[Dev 시스템](http://dev.ied.com)에 들어가, 좌측 안내탭 게임관리->전체게임 클릭하여 자신의 게임을 조회합니다.여기서는 MSDK를 예로 아래 이미지를 참고：

![Alt text](./Push3.png)

### Step2:
위 이미지에 있는 보기 버튼을 클릭하여 게임 상세정보 페이지로 이동하여 아래와 같은 정보를 찾아냅니다：

![Alt text](./Push4.png)

### Step3:
위 이미지에 있는 IOS정보 편집 버튼을 클릭하여 iOS정보 페이지에 들어갑니다. 아래 이미지처럼：

![Alt text](./Push5.png)

XG 시스템 공식페이지에 있는 절차에 따라 만드는 개발환경 pem증서 및 생산환경의 pem증서를 따로 올리면 됩니다.증서에서 비밀번호를 설정하지 않을 경우 비번옵션은 작성 불가. 마지막으로 좌상쪽에 있는  게임IOS정보 업데이트 버튼을 클릭하여 저장합니다.

**주의 사항**

생산환경 증서는 RDM에서 다운 받아야 합니다. 구체적 경로：게임->발포관리->증서관리，MSDK를 예로 아래 이미지 보여주는 바와 같이：

![Alt text](./Push_RDM1.png)

열려 있는 페이지에서 대응한 xxx_push.p12파일을 다운받고 단말기 시동하여 xxx_push.p12파일이 있는 디렉터리로 이동하여 아래 커맨드를 실행합니다：

```
openssl pkcs12 -in xxx_push.p12 -out xxx_push.pem -nodes
```
생성된 xxx_push.pem파일을 Dev시스템에 올리면 됩니다.

##푸시 등록
 - 개요에서 시그네쳐 파일을 정확히 설정해야 푸시를 등록할 수 있습니다.
게임은 didFinishLaunchingWithOptions 방법에서 MSDK의 WGRegisterAPNSPushNotification 방법을 호출하여 푸시 등록을 진행해야 합니다.
코드 샘플:
```
- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    …
    [WGApnsInterface WGRegisterAPNSPushNotification:launchOptions];
    …
} 
```

- 2.4.0i 및 이후 버전에는 아래와 같은 방식을 사용할 수 있습니다：
```
-(BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
	…
	[MSDKXG WGRegisterAPNSPushNotification:launchOptions];
	…
}
```

---

##등록 성공
 - 등록 성공 후 게임은 didRegisterForRemoteNotificationsWithDeviceToken 콜백 방법을 수신합니다. 게임은 이 방법에서 WGSuccessedRegisterdAPNSWithToken 방법을 호출하여 deviceToken를 MSDK에 전송해야 합니다.
코드 예시:
```
- (void)application:(UIApplication *)application didRegisterForRemoteNotificationsWithDeviceToken:(NSData *)deviceToken
{
    [WGApnsInterface WGSuccessedRegisterdAPNSWithToken:deviceToken];
} 
```

- 2.4.0i 및 이후 버전에는 다음과 같은 방식을 사용할 수 있습니다：
```
-(void)application:(UIApplication *)application didRegisterForRemoteNotificationsWithDeviceToken:(NSData *)deviceToken
{
	[MSDKXG WGSuccessedRegisterdAPNSWithToken:deviceToken];
}
```

---

##등록 실패
 - 등록 실패시 게임은 didFailToRegisterForRemoteNotificationsWithError 방법 콜백을 수신합니다. 게임은 WGFailedRegisteredAPNS 방법을 호출하여 MSDK에 푸시 등록 실패를 통지합니다.
예시 코드:
```
- (void)application:(UIApplication *)application didFailToRegisterForRemoteNotificationsWithError:(NSError *)error
{
    [WGApnsInterface WGFailedRegisteredAPNS];
} 
```

- 2.4.0i 및 이후 버전에는 다음과 같은 방식을 사용할 수 있습니다：
```
-(void)application:(UIApplication *)application didFailToRegisterForRemoteNotificationsWithError:(NSError *)error
{
	[MSDKXG WGFailedRegisteredAPNS];
}
```

---


##메시지 수신
 - 푸시 등록 성공시, 앱이 푸시 메시지를 받으면 didReceiveRemoteNotification 방법에 들어갑니다. 게임은 이 방법에서 WGReceivedMSGFromAPNSWithDict 방법을 호출하여 푸시 메시지를 MSDK에 제공해 분석을 진행하, 분석 결과를 게임에 통지합니다.
예시 코드:
```
- (void)application:(UIApplication *)application didReceiveRemoteNotification:(NSDictionary *)userInfo
{
    [WGApnsInterface WGReceivedMSGFromAPNSWithDict:userInfo];
} 
```

- 2.4.0i 및 이후 버전에는 다음과 같은 방식을 사용할 수 있습니다.
```
-(void)application:(UIApplication *)application didReceiveRemoteNotification:(NSDictionary *)userInfo
{
	[MSDKXG WGReceivedMSGFromAPNSWithDict:userInfo];
}
```

---

## badge 제거

 - 앱은 applicationDidBecomeActive에서 WGCleanBadgeNumber 방법을 호출하여 앱 바탕화면 아이콘 우측 상단의 푸시 항목을 제거해야 합니다.
예시 코드:
```
- (void)applicationDidBecomeActive:(UIApplication *)application
{
    [WGApnsInterface WGCleanBadgeNumber];
} 
```

- 2.4.0i 및 이후 버전에는 다음과 같은 방식을 사용할 수 있습니다.
```
-(void)applicationDidBecomeActive:(UIApplication *)application
{
	[MSDKXG WGCleanBadgeNumber];
}
```
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

```
- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions;
- (void)application:(UIApplication *)application didRegisterForRemoteNotificationsWithDeviceToken:(NSData *)deviceToken;
- (void)application:(UIApplication *)application didFailToRegisterForRemoteNotificationsWithError:(NSError *)error;
- (void)application:(UIApplication *)application didReceiveRemoteNotification:(NSDictionary *)userInfo;
- (void)applicationDidBecomeActive:(UIApplication *)application;
```

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
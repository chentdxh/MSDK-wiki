LBS 위치추적
===

##개요
 - 이 기능은 버전 1.6.2 이후부터 제공되며 인근 유저 정보를 획득하고 자신의 위치 정보를 삭제하는 인터페이스를 제공한다.

>**버전 2.3.0i부터 iOS8 시스템에서 액세스할 때 info.plist에 NSLocationWhenInUseUsageDescription(string) 필드를 추가해야 한다. 아래 그림 참조**

![Alt text](./LBS1.png)

MSDK 갱신 과정에서 이 인터페이스의 iOS8 호환성 문제가 존재하면 MSDK 백그라운드 인터페이스를 직접 사용할 수 있다(자세한 내용은 MSDK 백그라운드 문서 참조) : /relation/nearby

---

##근처 유저 조회
- ###개요
근처 유저 정보 조회
```ruby
void WGGetNearbyPersonInfo();
```
>설명: WGGetNearbyPersonInfo를 호출하여 인근 유저 정보를 획득할 때 유저는 App가 현재 위치를 사용하도록 허락해야 한다. 그렇지 않으면 데이터를 획득하지 못한다.
공유 성공과 실패는 OnLocationNotify(RelationRet &ret) 를 통해 게임에 콜백한다. ret.flag는 부동한 공유 결과를 표시한다. 자세한 내용은 eFlag(부록A) 참조

- ###코드 예시
호출 코드 샘플：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
 plat->WGGetNearbyPersonInfo();
//****** WGGetNearbyPersonInfo와 WGCleanLocation는 짝을 이루어 나타나는 것이 아니고 이곳에서는 예로 제공된다
plat->WGCleanLocation();
```
- 콜백 코드 샘플:
```ruby
void MyObserver::OnLocationNotify(RelationRet &relationRet) {
NSLog(@"relation callback");
NSLog(@"count == %d",relationRet.persons.size());
for (int i = 0; i < relationRet.persons.size(); i++)
{
PersonInfo logInfo = relationRet.persons[i];
NSLog(@"nikename == %@",[NSString stringWithCString:(const char*)logInfo.nickName.c_str() encoding:NSUTF8StringEncoding]);
NSLog(@"openid==%@",[NSString stringWithCString:(const char*)logInfo.openId.c_str() encoding:NSUTF8StringEncoding]);
}
}
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용 가능. 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service GetNearbyPersonInfo];
```
- 콜백 코드 샘플：
```
-(void)OnLocationWithRelationRet:(MSDKRelationRet *)ret
{
    //내부 실현 로직은 void MyObserver::OnLocationNotify(RelationRet &relationRet)와 일치.
}
```

##위치 정보 제거
- ###개요
위치 정보 제거
```ruby
bool WGCleanLocation();
```
>설명: 유저 자신의 위치 정보를 제거, 로그인 필요
리턴：정상일 경우 YES리턴，로그인되지 않거나 appid null, openid null일 경우는 NO리턴.
공유 성공 혹 공유 실패는 OnLocationNotify(RelationRet &ret)를 통해 게임에 리턴할 것이다.Ret.flag는 다른 공유 결과를 표시한다.구체적 내용은 eFlag(부록A를 참고)

- ###예시 코드
호출 코드 샘플：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver(); 
plat->WGSetObserver(ob);//콜백 객체 설정
plat->WGCleanLocation();
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용 가능하며 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service CleanLocation];
```

##유저 위치 정보 획득
- ###개요
유저 위치 정보 획득
```ruby
bool WGReportLocationInfo (); 2.0.0i 및 후속 버전에 제공
```
>설명: 유저 자신의 위치정보를 획득하여 게임에 리턴하는 동시에 MSDK백그라운드에 전달. 로그인 필요
리턴：정상일 경우는 YES리턴,로그인 하지 않은 상태,appid null, openid null 일 경우는 NO리턴.
공유 성공 혹 공유 실패는 OnLocationGotNotify(LocationRet &ret)를 통해 게임에 리턴할 것이다.Ret.flag는 다른 공유 결과를 표시한다.구체적 내용은 eFlag(부록A를 참고).LocationRet 정의는 부록B 참조.

- ###예시 코드
호출할 코드는 아래와 같다：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver(); 
plat->WGSetObserver(ob);//콜백 객체 설정
plat-> WGReportLocationInfo ();
```
- 콜백 코드 예시：
```ruby
void MyObserver:: OnLocationNotify (LocationRet &ret)
{
    NSLog(@"get GPS: callback:%d, longtitude:%f, latitude:%f",flag,ret.longtitude,ret.latitude);
}
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용 가능하며 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service GetLocationInfo];
```
- 콜백 코드 예시：
```
-(void)OnLocationGotWithLocationRet:(MSDKLocationRet *)ret
{
    //내부 실현 로직은 void MyObserver:: OnLocationNotify (LocationRet &ret)와 일치
}
```
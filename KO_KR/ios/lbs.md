LBS 위치추적
===

##개요
 - 이 기능은 버전 1.6.2 이후부터 제공되며 인근 유저 정보를 획득하고 자신의 위치 정보를 삭제하는 인터페이스를 제공한다.

>**버전 2.3.0i부터 iOS8 시스템에서 액세스할 때 info.plist에 NSLocationWhenInUseUsageDescription(string) 필드를 추가해야 한다. 아래 그림 참조**

![Alt text](./LBS1.png)

MSDK 갱신 과정에서 이 인터페이스의 iOS8 호환성 문제가 존재하면 MSDK 백그라운드 인터페이스를 직접 사용할 수 있다(자세한 내용은 MSDK 백그라운드 문서 참조) : /relation/nearby

---

##인터페이스 설명
 - 
```ruby
void WGGetNearbyPersonInfo();
```
>설명: WGGetNearbyPersonInfo를 호출하여 인근 유저 정보를 획득할 때 유저는 App가 현재 위치를 사용하도록 허락해야 한다. 그렇지 않으면 데이터를 획득하지 못한다.
공유 성공과 실패는 OnLocationNotify(RelationRet &ret) 를 통해 게임에 콜백한다. ret.flag는 부동한 공유 결과를 표시한다. 자세한 내용은 eFlag(부록A) 참조
 - 
```ruby
bool WGCleanLocation();
```
>설명: 유저 자신의 위치 정보 삭제, 로그인 필요
리턴: 정상시 YES 리턴. 로그인하지 않았거나 appid가 없거나 openid가 없으면 NO 리턴.
공유 성공과 실패는 OnLocationNotify(RelationRet &ret)를 통해 게임에 콜백한다. Ret.flag는 부동한 공유 결과를 표시한다. 자세한 내용은 eFlag(부록A) 참조

 - 
```ruby
bool WGReportLocationInfo (); 2.0.0i 및 후속 버전에서 제공
```
>설명: 유저 자신의 위치 정보를 획득하여 게임에 리턴하는 동시에 MSDK 백그라운드에 전송. 로그인 필요 
리턴: 정상시 YES 리턴. 로그인하지 않았거나 appid가 없거나 openid가 없으면 NO 리턴.
공유 성공과 실패는 OnLocationGotNotify(LocationRet &ret)를 통해 게임에 콜백한다. Ret.flag는 부동한 공유 결과를 표시한다. 자세한 내용은 eFlag(부록A) 참조, LocationRet 정의는 부록B 참조

---

##샘플 코드
 - 
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
WGPlatform *plat = WGPlatform::GetInstance();
 plat-> WGReportLocationInfo ();
//****** WGGetNearbyPersonInfo와 WGCleanLocation는 짝을 이루어 나타나는 것이 아니고 이곳에서는 예로 제공된다
plat->WGCleanLocation();
```

 - 콜백 코드 샘플:
```ruby
void MyObserver:: OnLocationNotify (LocationRet &ret)
{
NSLog(@"get GPS: callback:%d, longtitude:%f, latitude:%f",flag,ret.longtitude,ret.latitude);
 }
```

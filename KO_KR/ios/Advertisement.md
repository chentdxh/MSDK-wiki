광고
===

##개요
 - 이 기능은 버전 2.1.0 이후부터 제공되며 게임에서 info에 다음 설정을 추가하여 광고 데이터를 특정 시간에 실행하면 됩니다.
![Alt text](./Advertisement1.png)

---

##광고 인터페이스
 - WGShowAD를 호출하면 MSDK에 설정된 UI를 사용하여 현재 유효한 공지를 표시합니다. WGHideScrollNotice를 호출하면 표시된 롤링 공지를 숨김니다.
```ruby
 void WGPlatform::WGShowAD(const _eADType& scene) const;
```
>설명: 지정된 scene에서 현재 유효한 공지를 표시합니다. 파라미터 type를 통하여 아래와 같이 어떤 공지를 표시할 지 확정합니다.
```ruby
typedef enum _eADType
{
   Type_Pause  = 1, // 일시정지 위치 광고
Type_Stop = 2, // 종료위치 광고
}eADType;
```
iOS는 현재 Type_Pause(일시정지 위치 광고)만 사용합니다.
파라미터:
  - Type 표시할 광고 유형

 - 
```ruby
void WGCloseAD (const _eADType& scene);
```
>설명: 이미 출력된 광고 숨기기
주: 광고 표시 화면의 버튼은 AdvertisementConfig.plist를 통하여 커스터마이징합니다. plist를 통하여 버튼 수량,이미지와 tag를 설정할 수 있습니다. 이 tag는 유저가 클릭한 후 콜백을 통하여 게임에 리턴됩니다. 이 plist 파일은 framework/Resources/ AdvertisementResources의 하위 디렉토리에 있습니다. 양식의 요소와 해당 설명은 부록 G를 참조 바랍니다.

---
##예시 코드
 - 공지 데이터 리스트 획득 인터페이스 호출 코드 예시:
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGShowAD(Type_Pause);
```

 - “Get Started-Step5”에 따라 WGAdObserver를 설정한 후, 유저가 버튼을 클릭하는 이벤트는 observer의 OnADNotify 함수를 콜백합니다. 예시 코드:
```ruby
void MyAdObserver::OnADNotify(ADRet& adRet) 
{
NSString *string = [NSString stringWithCString:(const char*)adRet.viewTag.c_str() encoding:NSUTF8StringEncoding];
    NSLog(@"btn tag == %@",string);
    
    WGPlatform *plat = WGPlatform::GetInstance();
    plat->WGCloseAD(Type_Pause);
}
```

자동 인증과 token 검증
===
##개요
 - 플랫폼(모바일QQ 또는 위챗)의 각종 토큰은 일정한 유효 기간이 있기에 게임을 실행할 때마다 인증할 필요가 없다. 지난번에 인증한 token 기한이 만료되지 않으면 다시 인증하지 않아도 된다. 유효 기간에 있는 token도 다른 설비에서 인증을 진행함으로 하여 효력을 잃는 등 문제가 발생할 수 있다.
 - MSDK는 2.0.0부터 WGLoginWithLocalInfo 인터페이스를 추가했다. 이 인터페이스는 token 유효성(유효 및 만료 여부) 검증을 실현하며 검증 결과는 직접 OnLoginNotify 인터페이스를 통해 게임에 콜백한다. 성공 시 eFlag_Succ 또는 eFlag_WX_RefreshTokenSucc를 반환하고 바로 게임에 들어간다. 실패 시 eFlag_Local_Invalid를 반환하고 유저는 다시 인증해야 한다.
- 게임을 매번 실행할 때마다(바탕화면 실행, 백그라운드에서 포어그라운드로 전환 또는 플랫폼 실행) WGLoginWithLocalInfo를 호출하여 토큰을 검증할 것을 제안한다.

 - 샘플 코드:
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
LoginRet ret;
ePlatform platform = (ePlatform)plat->WGLoginWithLocalInfo ();
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있다. 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *service = [[MSDKAuthService alloc] init];
[service loginWithLocalInfo];
```

##주의사항
 - msdk 2.0.0 이후부터 정기적으로 곧 만료될 위챗 token을 갱신한다. 갱신 결과는 OnLoginNotify를 통해 게임에 콜백된다.[2.0.0i 신규 추가]
 - 게임 시작과 백그라운드에서 포어그라운드로 전환할 때 이 인터페이스를 호출하고 다른 경우에는 호출하지 말아야 한다[중요]
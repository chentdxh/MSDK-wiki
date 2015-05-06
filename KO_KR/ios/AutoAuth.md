자동 인증과 token 검증
===
##개요
 - 플랫폼(모바일QQ 혹은 위챗)의 각종 토큰은 일정한 유효 기간이 있으므로 게임 실행할 때마다 인증할 필요는 없습니다. 전에 인증한 token 기한이 만료되지 않을 경우 다시 인증하지 않아도 됩니다. 유효 기간에 있는 token도 다른 설비에서 인증을 진행한 관계로 효력을 잃는 등 문제가 발생할 수 있습니다.
 - MSDK는 2.0.0부터 WGLoginWithLocalInfo 인터페이스를 추가하였습니다. 이 인터페이스는 token 유효성(유효 및 만료 여부) 검증을 구현하였으며 검증 결과는 직접 OnLoginNotify 인터페이스를 통하여 게임에 콜백합니다. 성공 시 eFlag_Succ 혹은 eFlag_WX_RefreshTokenSucc를 리턴하고 바로 게임을 접속할 수 있습니다. 실패 시 eFlag_Local_Invalid를 리턴하고 유저는 다시 인증하여야 합니다.
- 게임을 매번 실행할 때마다(바탕화면 실행, 백그라운드에서 포어그라운드로 전환 혹은 플랫폼 실행) WGLoginWithLocalInfo를 호출하여 토큰을 검증할 것을 권장드립니다.

 - 샘플 코드:
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
LoginRet ret;
ePlatform platform = (ePlatform)plat->WGLoginWithLocalInfo ();
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같습니다.
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *service = [[MSDKAuthService alloc] init];
[service loginWithLocalInfo];
```

##주의사항
 - msdk 2.0.0 이후부터 정기적으로 곧 만료될 위챗 token을 업데이트하며 업데이트 결과는 OnLoginNotify를 통하여 게임에 콜백합니다.[2.0.0i 신규 추가]
 - 게임 시작과 백그라운드에서 포어그라운드로 전환할 시 이 인터페이스를 호출하며 다른 경우에는 호출 금지입니다.[중요]
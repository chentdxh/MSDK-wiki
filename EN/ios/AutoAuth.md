Automatic authorization and token verification
===
## Overview
 - Because various tokens of the platform (mobile QQ or Wechat) all have some validity period, the user doesn’t need to authorize the game each time the user starts the game. If the last authorized token does not expire, there is n need for re-authorization. Valid tokens may also become invalid because other devices are authorized.
 - Starting from V2.0.0, MSDK has added WGLoginWithLocalInfo interface, which implements the validity verification of tokens (including whether the tokens are valid or expired). The verification results will be directly called back to the game through OnLoginNotify interface. In case of success, MSDK will return EFlag_Succ or EFlag_WX_RefreshTokenSucc, and the user can straightly enter the game. Otherwise, MSDK will return eFlag_Local_Invalid, and the game allows the user to re-authorize.
- It is proposed that every time the game is started (desktop startup, the switch from the backend to the front desk or platform wakeup), it always calls WGLoginWithLocalInfo to verify the token.

- Demo code:
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
LoginRet ret;
ePlatform platform = (ePlatform)plat->WGLoginWithLocalInfo ();
```

- 2.4.0i and later versions can also use delegate. The code is as follows:
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *service = [[MSDKAuthService alloc] init];
[service loginWithLocalInfo];
```

## Notes
- After V2.0.0, MSDK will refresh expired WeChat tokens regularly and call back the refresh results to the game through OnLoginNotify. [Added in 2.0.0i]
- When the game is started and the backend switches to the frontend, MSDK will call this interface; in other circumstances, it does not need to call it [important].

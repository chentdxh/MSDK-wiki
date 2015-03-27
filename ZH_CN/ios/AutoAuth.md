自动授权与token校验
===
##概述
 - 由于平台（手Q或微信）的各种票据都有一段时间的有效期，所以不需要用户每次启动游戏都授权，如果上次授权的token没过有效期就不需要再重新授权。有效期内的token也可能因为在其他设备授权而导致无效等问题。
 - MSDK从2.0.0版本开始增加WGLoginWithLocalInfo接口，此接口实现token的有效性（包括是否有效和过期）验证，验证结果会直接通过OnLoginNotify接口回调给游戏，成功返回eFlag_Succ或eFlag_WX_RefreshTokenSucc，直接进游戏。失败返回eFlag_Local_Invalid，游戏让用户重新授权。
- 建议游戏每次启动(桌面启动、后台切前台或被平台唤起)都调用WGLoginWithLocalInfo进行票据校验。

- 示例代码：
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
LoginRet ret;
ePlatform platform = (ePlatform)plat->WGLoginWithLocalInfo ();
```

- 2.4.0i及以后版本还可使用delegate方式，代码如下：
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *service = [[MSDKAuthService alloc] init];
[service loginWithLocalInfo];
```

##注意事项
 - msdk 2.0.0版本后会定时对将要过期的微信token进行刷新，刷新结果会通过OnLoginNotify回调给游戏。[2.0.0i新增]
 - 游戏启动和后台切前台调用此接口，其他情况下不要调用[重要]
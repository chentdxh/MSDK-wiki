LBS定位
===

##概述
 - 该功能在1.6.2版本以后提供，提供了获取附近人信息和清除自己位置信息的接口。

>**从2.3.0i版本起，在iOS8系统接入时，需要在info.plist加入NSLocationWhenInUseUsageDescription(string)字段，如下图**

![Alt text](./LBS1.png)

若更新MSDK过程中存在此接口的iOS8兼容问题，也可以直接使用MSDK的后台接口（详情见MSDK后台文档）：/relation/nearby

---

##获取附近的人
- ###概述
获取附近的人信息
```ruby
void WGGetNearbyPersonInfo();
```
>描述: 调用WGGetNearbyPersonInfo获取周围人的信息，需要用户允许App使用当前位置，否则是不会有数据的。
调用成功或失败都会通过OnLocationNotify(RelationRet &ret)回调给游戏。ret.flag表示不同的分享结果，具体见eFlag(附录A)

- ###示例代码
调用代码如下：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver(); 
plat->WGSetObserver(ob);//设置回调对象
plat->WGGetNearbyPersonInfo();
```
- 回调代码示例：
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

- 2.4.0i及以后版本还可使用delegate方式，代码如下：
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service GetNearbyPersonInfo];
```
- 回调代码如下：
```
-(void)OnLocationWithRelationRet:(MSDKRelationRet *)ret
{
    //内部实现逻辑同void MyObserver::OnLocationNotify(RelationRet &relationRet)
}
```

##清除位置信息
- ###概述
清除位置信息
```ruby
bool WGCleanLocation();
```
>描述: 清除用户自己的位置信息，需要登录 
返回：正常返回YES，没有登录、appid为空、openid为空返回NO。
分享成功或失败都会通过OnLocationNotify(RelationRet &ret)回调给游戏。Ret.flag表示不同的分享结果，具体见eFlag(附录A)

- ###示例代码
调用代码如下：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver(); 
plat->WGSetObserver(ob);//设置回调对象
plat->WGCleanLocation();
```

- 2.4.0i及以后版本还可使用delegate方式，代码如下：
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service CleanLocation];
```

##获取玩家位置信息
- ###概述
获取玩家位置信息
```ruby
bool WGReportLocationInfo (); 2.0.0i及后续版本提供
```
>描述: 获得用户自己的位置信息，返回给游戏的同时上报到MSDK后台，需要登录 
返回：正常返回YES，没有登录、appid为空、openid为空返回NO。
分享成功或失败都会通过OnLocationGotNotify(LocationRet &ret)回调给游戏。Ret.flag表示不同的分享结果，具体见eFlag(附录A)，LocationRet定义详见附录B

- ###示例代码
调用代码如下：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver(); 
plat->WGSetObserver(ob);//设置回调对象
plat-> WGReportLocationInfo ();
```
- 回调代码示例：
```ruby
void MyObserver:: OnLocationNotify (LocationRet &ret)
{
    NSLog(@"get GPS: callback:%d, longtitude:%f, latitude:%f",flag,ret.longtitude,ret.latitude);
}
```

- 2.4.0i及以后版本还可使用delegate方式，代码如下：
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service GetLocationInfo];
```
- 回调代码如下：
```
-(void)OnLocationGotWithLocationRet:(MSDKLocationRet *)ret
{
    //内部实现逻辑同void MyObserver:: OnLocationNotify (LocationRet &ret)
}
```
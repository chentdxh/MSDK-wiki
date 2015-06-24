LBS
===

##Overview
 - This function is provided versions higher than 1.6.2. It provides interfaces for the user to acquire nearby persons’ location information and to remove the user’s own location information.

>** From the 2.3.0i version on, when LBS gets access to the iOS8 system, it is needed to add NSLocationWhenInUseUsageDescription(string) field in info.plist, as shown in the following diagram**

![Alt text](./LBS1.png)

If there occurs the iOS8 compatibility issue in the update process of MSDK, you can also directly use the backend interfaces of MSDK (see MSDK’s backend documentation for details): /relation/nearby

---

## Acquire nearby persons’ location info
- ### Overview
Acquire nearby persons’ location info
```ruby
void WGGetNearbyPersonInfo();
```
>Description: Call WGGetNearbyPersonInfo to get the nearby people’s location information. This needs the user to allow App to use the current location; otherwise, there will not be data available.
The call results, no matter whether success or failure, will all be returned to the game via OnLocationNotify(LocationRet &ret) callback. Ret.flag represents different sharing results. For details, please see eFlag (Appendix A)

- ###Demo code
The call code is as follows:
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver(); 
plat->WGSetObserver(ob);//Set callback object
plat->WGGetNearbyPersonInfo();
```
- Callback code example:
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

- 2.4.0i and later versions may also use delegate; the code is as follows:
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service GetNearbyPersonInfo];
```
- The callback code is as follows:
```
-(void)OnLocationWithRelationRet:(MSDKRelationRet *)ret
{
    //The internal implementation logic is the same with void MyObserver::OnLocationNotify(RelationRet &relationRet)
}
```

## Clear location information
- ###Overview
Clear location information
```ruby
bool WGCleanLocation();
```
>Description: clear the user’s own location information; it is needed to log in the game.
Return: return YES in the normal case; return NO if the game is not logged in, appid is empty and openid is empty.
The sharing results, no matter whether success or failure, will all be returned to the game via OnLocationNotify(LocationRet &ret) callback. Ret.flag represents different sharing results. For details, please see eFlag (Appendix A)

- ###Demo code
The call code is as follows:
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver(); 
plat->WGSetObserver(ob);//Set callback object
plat->WGCleanLocation();
```

- 2.4.0i and later versions may also use delegate; the code is as follows:
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service CleanLocation];
```

##Get the player’s location information
- ###Overview
Get the player’s location information
```ruby
bool WGReportLocationInfo (); provided by 2.0.0i and later versions
```
>Description: Get the current player’s location information; return the data to the game and also report them to the MSDK backend at the same time. It is needed to log in the game.
Return: return YES in the normal case; return NO if the game is not logged in, appid is empty and openid is empty.
The sharing results, no matter whether success or failure, will all be returned to the game via OnLocationNotify(LocationRet &ret) callback. Ret.flag represents different sharing results. For details, please see eFlag (Appendix A). LocationRet is defined in Appendix B

- ###Demo code
The call code is as follows:
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);//Set callback object
plat-> WGReportLocationInfo ();
```
- Callback code example:
```ruby
void MyObserver:: OnLocationNotify (LocationRet &ret)
{
    NSLog(@"get GPS: callback:%d, longtitude:%f, latitude:%f",flag,ret.longtitude,ret.latitude);
}
```

- 2.4.0i and later versions may also use delegate; the code is as follows:
```
[MSDKService setMSDKDelegate:self];
MSDKLocationBasedService *service = [[MSDKLocationBasedService alloc] init];
[service GetLocationInfo];
```
- The callback code is as follows:
```
-(void)OnLocationGotWithLocationRet:(MSDKLocationRet *)ret
{
    //The internal implementation logic is the same with void MyObserver:: OnLocationNotify (LocationRet &ret)
}
```
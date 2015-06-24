Revision History

##  2.6.2
- 【Code changes】 1.【MSDK】
	* Fix a bug: WGGetNoticeData interface can’t get announcement data;
	* Fix a bug: after the user shares a url messages to a WeChat friend, an error occurs when the friend clicks the shared message on the Android side to open the url-specified page
	* Comb and revise the token automatic refresh process;## 2.6.1
- 【Code changes】
  1.【MSDKFoundation】
	* Add AppID, IDFA, OpenID and other fields to the gaming time statistics reporting.

  2.【MSDK】
	* Fix a bug: Crash reporting can’t be enabled automatically in V2.6.0;
	* Fix a bug: Crash reporting doesn’t have userID in case of automatic login in V2.6.0;
	* Fix a bug: When V2.6.0 achieves quick login with token through the Game Center, the local token is not refreshed simultaneously;
	* Fix a bug: When a game is launched through the shared message in case of account inconsistency in V2.6.0, there is no prompt about account inconsistency;
- 【Component update】
	* 【Update】Update OpenSDK to 2.8.2, and fix a bug: non-H5 whitelist games can’t share big pictures to Qzone
	* 【Update】Upgrade RQD to Bugly2.1.3

## 2.6.0
- 【Code changes】
  1.【MSDKFoundation】
	* Revise the frequent access of MSDKLogger to NSUserdefaults to reduce crash risks.
	* Add the acquisition and reporting of IDFA; subsequent games require iTC to check iAD-related items in case of audit ([instruction](http://km.oa.com/articles/show/234073)); it is needed to import AdSupport.framework in the project.
	
  2.【MSDK】
	* Fix a bug related to the token automatic refresh mechanism in 2.5.0;
	* Fix a bug: Report and obtain appid incorrectly in absence of login in 2.5.0;
	* Optimize the token refresh mechanism; as for details, please see [Automatic refresh process of token in MSDK2.6.0i and later versions](login.md# Automatic refresh process of token in MSDK2.6.0i and later versions) ；
	*  mobile QQ can share messages via built-in Webview; if wanting to use this feature, the game is required to apply from OpenApiHelper to open the mobile QQ H5 share permission. After the permission is open, the share operation can be completed in the internal WebView of the game, thus avoiding audit risks;
- 【Component update】
	* 【Update】Update OpenSDK to 2.8.1 to support the H5 share feature of mobile QQ

## 2.5.0
- 【Code changes】
1.【Add】Add online time reporting and statistics.
2. 【Add】Add the share entrance switch to built-in Webview, so that game developers can configure MSDK_WebView_Share_SWITCH in info.plist file: in case of YES, built-in Webview can display “Share” button; in case of NO, it doesn’t do so.
3.【Modify】Optimize Guest mode, and make keychain data backup.
4. 【Modify】Fix a bug: built-in Webview can’t launch WeChat sharing in the iPad terminal in iOS5.1.1.
- 【Add component】
1.【Add】 Integrate QMi Assistant SDK in demo. Game developers can integrate it according to their needs.

## 2.4.0
- 【Code changes】
1.【Modify】MSDK is modularized and is divided into 4 modules by function:
  1. MSDKFoundation: The basic dependency library; if you want to use other libraries, you are required to import this framework;
  2. MSDK: Login and share functions of mobile QQ and WeChat;
  3. MSDKMarketing: provide cross-marketing and built-in Webview functions. Resource files required by announcement and built-in Webview are placed in WGPlatformResources.bundle file;
  4. MSDKXG: provide Pigeon Push function.
  The above four components can provide both C99 and C11 language standards at the same time, in which **_C11 package is C11 version.
  ![linkBundle](./2.4.0_structure_of_framework.png)
  
  If you only want to use C++ interfaces, you only need to import the following header files:
```
<MSDKFoundation/MSDKStructs.h>
<MSDK/WGInterface.h>
<MSDK/WGPlatform.h>
<MSDK/WGPlatformObserver.h>
```  
    In addition: the modularized version not only supports the Observer callback of 2.3.4 and earlier versions but also adds delegate callback. Here, take mobile QQ authorized login for example (as for details about other interfaces, please refer to their respective interface documentations):
   The original authorization call code is as follows:
```
WGPlatform* plat = WGPlatform::GetInstance();//initialize MSDK
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);//set callback
plat->WGSetPermission(eOPEN_ALL);//set authorization permission
plat->WGLogin(ePlatform_QQ);//call mobile QQ client or web to authorize
```
    The original authorization callback code is as follows:
```ruby
void MyObserver::OnLoginNotify(LoginRet& loginRet)
{
if(eFlag_Succ == loginRet.flag)
{
…//login success
std::string openId = loginRet.open_id;
std::string payToken;
std::string accessToken;
if(ePlatform_QQ == loginRet.Platform)
{
for(int i=0;i< loginRet.token.size();i++)
{
TokenRet* pToken = & loginRet.token[i];
if(eToken_QQ_Pay == pToken->type)
{
paytoken = pToken->value;
}
else if (eToken_QQ_Access == pToken->type)
{
accessToken = pToken->value;
}
}
}
else if (ePlatform_Weixin == loginRet.platform)
{
….
}
} 
else
{
…//login fail
NSLog(@"flag=%d,desc=%s",loginRet.flag,loginRet.desc.c_str()); 
}
}
```
    2.4.0i and later versions may also use delegate; the code is as follows:
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *authService = [[MSDKAuthService alloc] init];
[authService setPermission:eOPEN_ALL];
[authService login:ePlatform_QQ];
```
    Callback code is as follows:
```
-(void)OnLoginWithLoginRet:(MSDKLoginRet *)ret
{
//The internal implementation logic is the same with void MyObserver::OnLoginNotify(LoginRet& loginRet)
}
```


## 2.3.4
 - 【Component update】
1.【Modify】Update OpenSDK2.5.1, and solve the crash issue in 5.1.1;

## 2.3.3
 - 【Code changes】
1.【Modify】Fix a bug: crash resulted by the quick startup of mobile QQ without logging in it
2.【Modify】Fix a bug: there isn’t pf or pfkey in case of first login in the guest mode
 - 【Component update】
1.【Modify】Update MTA1.4.2, and remove the crash risks of the project compiled under SDK8

## 2.3.2
 - 【Code changes】
1.【Modify】Update OpenSDK2.5.1, and fix a bug: OpenSDK can’t be logged in normally with webView in iOS8.1.1 when mobile QQ is not installed
 - 【Compilation changes】
1. Tencent_MSDK_IOS_V2.3.2i (support arm32, iOS SDK7 compilation): because the game engine used by some games has a poor support for SDK8 iOS, MSDK uses SDK7 iOS to compile 32-bit packages for these games to use.
2. Tencent_MSDK_IOS_V2.3.2i (support arm64, iOS SDK8 compilation): use arm64 package supported by iOS SDK8 compilation
---

## 2.3.1
 - 【Code changes】
1.【Modify】Update RQD和 Beacon, and remove the Crash risks caused by Crash reporting itself
---

## 2.3.0

 - 【Code changes】
1.【Modify】Resource files are packed to WGplatformResources.bundle
2.【Delete】Midas decoupling; delete the following interfaces:
```
void WGRegisterPay(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* custom);// since 1.2.6
void WGPay(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGIAPRestoreCompletedTransactions(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGIAPLaunchMpInfo(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGDipose();//since 1.2.6
bool WGIsSupprotIapPay();//since 1.2.6
void WGSetOfferId(unsigned char* offerId);//since 1.2.6
void WGSetIapEnvirenment(unsigned char* envirenment);
void WGSetIapEnalbeLog(bool enabled);
```
3. 【Add】 WeChat share URL interface :
        void WGSendToWeixinWithUrl(
                        const eWechatScene& scene,
                        unsigned char* title,
                        unsigned char* desc,
                        unsigned char* url,
                        unsigned char* mediaTagName,
                        unsigned char* thumbImgData,
                        const int& thumbImgDataLen,
                        unsigned char* messageExt
                        );
4. 【Add】the total push switch; it is needed to configure MSDK_PUSH_SWITCH (string) as ON in plist; in case of other values or not being configured, push is invalid
5. 【Modify】Delete the (top, left, width) configuration in configuration items of the scroll announcement; if configured as top, the announcement will occupy the full width of the screen; if not set, the height is 30pt by default
6. 【Add】iOS8 support; LBS interfaces need to add plist field requestWhenInUseAuthorization; fix the display exceptions of announcements and ads
7. 【Modify】Optimize Guest storage; each App is stored in a different key to avoid Guest data written into corporate certificates from overriding each other. At the same time, add the migration logic to avoid the progress loss.
8.【Modify】Add two try-catch protections to avoid crash caused by the user’s default read and write

 - 【Fix BUG】
1. 【Modify】Fix a bug:  When the player adds friend within the game in mobile QQ, the friends’ notes and application information are upside down
2. 【Modify】Fix a bug:  Ads draw os = 1 (Android)
3. 【Modify】Fix a bug: AHAlertView and subclasses are displayed wrongly in the landscape mode
4. 【Modify】Fix a bug: WGRotationView and subclasses are displayed wrongly in horizontal and vertical screen in iOS 7,8
5. 【Modify】Fix a bug: In the Guest mode, the same certificates override guestid mutually in different applications
6. 【Modify】Fix a bug: the share page of built-in Webview can’t display correctly in iOS7, 8
7. 【Modify】Fix a bug: The “Advertising” button of the built-in WebView can’t appear in the absence of advertising
8. 【Modify】Fix a bug: Sending the registration message may fail in the Guest mode
9. 【Modify】Fix a bug: when RDM Crash is reported, AppID is not reported

---

## 2.2.0
- 【Code changes】
1. Add the local key log cloud control reporting
2. MSDK adds the demand of terminal source information in the User-agent field of the HTTP header
3. Add new needs for Pigeon PUSH to send full amount to users; it is required to configure MSDK_XGPUSH_URL in plist
4. MSDK adds an interface which can capsulate WeChat user’s personal information

---

##2.1.0
- 【Code changes】
1, Add a new ad feature: display ads through calling WGShowAD(_eADType& scene) interface; add WGADObserver, which is used for the ad click callback; the ad-related settings are placed in MsdkResources/AdvertisementResources/AdvertisementConfig.plist
2. Add WGGetLocationInfo interface and OnLocationGotNotify callback to get the user’s GPS address and report it to MSDK backend server;
3. WGGetNearBy interface adds gpsCity return;
4. Built-in Webview link is added with clear-text opened;
5. Add LoginInfo class to provide to get the login token in the reflection form to reduce coupling. Demo code is as follows:
```
 Class loginInfoClass = NSClassFromString(@"LoginInfo");
    if (loginInfoClass) {
        id obj = [[[loginInfoClass alloc]init]autorelease];
        if ([obj respondsToSelector:@selector(description)]) {
            NSLog(@"Login info:%@",[obj description]);
        }
    }
```

---

## 2.0.7
 - 【Code changes】
1.【Modify】Update OpenSDK2.5.1, and fix a bug: OpenSDK can’t be logged in normally with webView in iOS8.1.1 when mobile QQ is not installed
---

## 2.0.6
 - 【Code changes】
1.【Modify】Add AppID and OpenId reporting in Crash reporting;
2.【Modify】Update RQD and Beacon, and remove the Crash risks caused by Crash reporting itself
---

##2.0.5
- 【Code changes】
1. Delete the code which use Apple’s private interface

---

##2.0.4
- 【Code changes】
The version merges 2.0.2i and 2.0.3i but has no new features

---

##2.0.3
- 【Code changes】
1. 【Add】WGPlatform.h adds the following interfaces:
```
   /**
     *  Get id in the guest mode
     * 
     *
     */
    std::string WGGetGuestID();
    
    /**
     *  Refresh id in the guest mode
     *
     *
     */
    void WGResetGuestID();
```
2. 【Delete】Delete the following interfaces:
```
    void WGRegisterAPNSPushNotification(NSDictionary *dict);
    void WGSuccessedRegisterdAPNSWithToken(NSData *data);
    void WGFailedRegisteredAPNS();
    void WGCleanBadgeNumber();
    void WGReceivedMSGFromAPNSWithDict(NSDictionary* userInfo);
```
3. 【Modify】Modify wrong #endif macro location of WGPublicDefine.h
4. 【Add】Add a public file called WGApnsInterface, which includes the following interfaces:
```
    + (void)WGRegisterAPNSPushNotification:(NSDictionary*)dict;
    + (void)WGSuccessedRegisterdAPNSWithToken:(NSData *)data;
    + (void)WGFailedRegisteredAPNS;
    + (void)WGCleanBadgeNumber;
    + (void)WGReceivedMSGFromAPNSWithDict:(NSDictionary*) userInfo;
```
5. 【Add】Add an internal file called GuestInterface to handle the guest mode logic

【Document adjustment】
1. 【Add】Chapter 13: Relevant description in the guest mode;
2. 【Add】Chapter 1: Add description about how to produce C99 and C11 packages at one time;
2. 【Add】Chapter 12: Improve the APNS-related instructions, and change to call WGApnsInterface

---

##2.0.2
- 【Code changes】
1. Add three interfaces for in-game friends, update OpenSDK2.5, and correspondingly the user needs to use the new version of mobile QQ:
```
    /**
	 * Join a group within the game; after a union successfully binds a QQ group, union members can join the union group by clicking on the “Join Group” button
	 * @param cQQGroupKey needs the corresponding key of the joined QQ group, and the game server can get the key by calling openAPI interface; as for the call method, RTX to consult OpenAPIHelper
	 */
	void WGJoinQQGroup(unsigned char* cQQGroupKey);
	/**
	 * Game group binding: In the game union/alliance, by clicking on the “Bind” button the union president can draw the group created the president himself and bind to a group as the union group of the union
	 * @param cUnionid: union id, which can only be filled with numbers, for characters can cause the binding failure
	 * @param cUnion_name: union name
	 * @param cZoneid: zone ID, which can only be filled with numbers, for characters can cause the binding failure
	 * @param cSignature: the game union president’s identity verification signature, whose generation algorithm is: MD5 value of openid_appid_appkey_union’s id_zone’s id
	 * 	If the union still can not bind a group successfully by the method, RTX to consult OpenAPIHelper
	 *
	 */
	void WGBindQQGroup(unsigned char* cUnionid, unsigned char* cUnion_name,
                       unsigned char* cZoneid, unsigned char* cSignature);
	/**
	 * Add friends with the game
	 * @param cFopenid: need to add friend’s openid
	 * @param cDesc: need to add friend’s description
	 * @param cMessage: verification message sent when adding a friend
	 */
	void WGAddGameFriendToQQ(unsigned char* cFopenid, unsigned char* cDesc,
                             unsigned char* cMessage);
```
---

##2.0.1
- 【Code changes】
1.  Announcement adds the image announcement type, and the announcement struct adds image data; for details, please see MSDKAccess documentation2.0
2. Add LoginWithLocalInfo interface to verify token; when the game is started or switches from the backend to the frontend, this interface will be called.

---

##2.0.0
- 【Code changes】
1. Optimize the features of built-in Webview, and improve the built-in Webview;
2. Add image and webpage announcement types; download announcement data regularly;
3. Add the automatic login process to verify tokens and refresh accessToken and other tokens;
4. Update mobile QQ sdk1.1.1 version, and fix a bug: the retrieval of the authorization given by mobile QQ to the game can result in the authorization failure;
5. Improve the local log scheme: set MSDK_LOG_TO_FILE as YES in info.plist, and output the MSDK-recording log to Caches/msdk.log.


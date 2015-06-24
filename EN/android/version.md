# Version History of MSDK

Version history of Android 2.7
---

### Modified content of Android 2.7.2

#### Code changes:

- New features:
  - Add WeChat big picture share function [`Local image path-based share interface `](wechat.md# Local image path-based sharing)

- SDK upgrade:
  -  upgrade Beacon version to 1.9.4a

- Bug repair
  - Repair the null pointer exception occasionally arising from reading the version
  - Repair the null pointer exception of lbs under special model
  - Repair My App Center’s null pointer exception

#### Document changes

- Add the local image path-based share interface for WeChat big picture share, and modify the description about [** WeChat big picture share **](wechat.md#Big picture message share )

### Modified content of Android 2.7.1

#### Code changes:

- New features:
  - Dynamically set number version in initialization

- SDK upgrade:
  -  Upgrade Beacon version to 1.9.1

- Bug repair:
  - Repair a bug: when pf_key value is saved after WeChat is logged in, pf value is regarded as pf_key value to be saved. This bug can lead to payment failure
  - Repair a bug: On Beacon page, the user crash rate gotten by version number can not be seen, but the overall user crash rate can be seen
  - Repair a bug: When the group information query C++ interface is not bound with the group, the query results can cause crash

#### Document adjustment:
- Adjust the section of Access to SDK about [`Step3: MSDK initialization`](android.md#Step3:_MSDK initialization): About how to dynamically set number version, that is, MsdkBaseInfo adds two settings: appVersionName and appVersionCode
- Adjust the section of Access to SDK about [`MSDK initialization`](android.md#Step3:_MSDK initialization): it is a must to call WGPlatform.onRestart, WGPlatform.onResume, WGPlatform.onPause, WGPlatform.onStop and WGPlatform.onDestroy. **`Game developers should pay special attention to this amendment!`**

### Modified content of Android 2.7.0

#### Code changes:

- New features:
	- Add two interfaces for joining a group and binding a group in mobile QQ: [Query QQ group’s binding information](qq.md#Query QQ group’s binding information) and [Unbinding QQ group](qq.md#Unbinding QQ group) and [three callbacks](qq.md#Callback settings for joining a group and binding a group). All interfaces for joining a group and binding a group in mobile QQ call MSDK。

- SDK upgrade:
	-  Upgrade payment to 1.3.9e
	-  Upgrade Pigeon version to 2.37
	-  Upgrade My App Center’s traffic-saving update SDK to 1.1

- Bug repair:
	- Repair JG Audit’s WxEntryActivity loophole and Pigeon loophole

- MSDK’s internal optimization:
	-  Built-in Webview switches to be enabled with the independent process. Please be sure to refer to the new configuration method to modify the content.
	- Optimize the login process. Please be sure to refer to the new configuration method to modify the content.
	- Add login time statistics

#### Document adjustment:

- Add relevant documents about the two interfaces for joining a group and binding a group in mobile QQ: [Query QQ group’s binding information](qq.md#Query QQ group’s binding information) and [Unbinding QQ group](qq.md#Unbinding QQ group) and [three callbacks](qq.md#Callback settings for joining a group and binding a group). Adjust [Relevant questions about joining a group and binding a group in mobile QQ](qq.md# Common questions about joining a group and binding a group)
- Optimize solutions to questions about [JG Audit] (http://wiki.dev.4g.qq.com/v2/ZH_CN/android/index.html#!jg.md)
- Adjust My App Center module’s [`content about traffic-saving update`](myApp.md)。**`This content has much adjustment. Game developers should pay special attention to it!`**
- Adjust the Push module’s content about [`Configure AndroidManifest.xml`](msdkpush.md#Access configuration), which indicates the settings needed to supplement for the access of 2.6.1 version to Pigeon
- Add the Push module’s content about [`Precautions for copying SO library`](msdkpush.md# Precautions for copying SO library).
- Adjust the built-in Webview module’s content about [` Access configuration `](webview.md).**`Game developers should pay special attention to this content adjustment!`**
- Adjust the login module’s content about [`Specific work for access to login (must-see for developers)`](login.md# Specific work for access to login (must-see for developers))。**`Game developers should pay special attention to this content adjustment and instructions on the calling of the login module in 2.7.0a version!`**
- Adjust the content of Access to SDK about [`MSDK initialization`](android.md#Step3: MSDK initialization). It is a must to call onRestart, onResume, onPause, onStop and onDestroy**`Game developers should pay special attention to this content adjustment!`**

Version history of Unity
---

### 2015/5/12
- Publish 2.6.2a-based Unity interface version, [`Download site`] (http://mcloud.ied.com/wiki/MSDK%E4%B8%8B%E8%BD%BD)(intranet)
- Add [Instructions on how projects should use MSDKUnitySample] (msdk_android_unity.md# Instructions on how projects should use MSDKUnitySample)

### 2015/4/7

- Publish 2.6.0a-based Unity interface version
- Add Unity version’s [`Access documentation`](msdk_android_unity.md)

Version history of Android 2.6
---
### Modified content of Android 2.6.2

#### Code changes:

- SDK upgrade:
	- Upgrade Beacon version to v1.9.4 (Fix the crash problem caused by the unclosing of DB cursor)

#### Document adjustment:
-  None 



### Modified content of Android 2.6.1

#### Code changes:

- SDK upgrade:
	-  Upgrade Beacon version to v1.9.1 (Repair the bug: Beacon has no crash rate statistics by version)
	- Upgrade Pigeon to v2.37 (Improve the arrival rate and repair JG Audit’s detection loophole)

- MSDK’s internal optimization:
	- Optimize MSDK WeChat authorization-related logic
	
#### Document adjustment:
- Adjust push module’s content about [`Configure AndroidManifest.xml`](msdkpush.md# Access configuration ), , which indicates the settings needed to supplement for the access of 2.6.1 version to Pigeon.
- Add push module’s content about [`Precautions for copying SO library`](msdkpush.md# Precautions for copying SO library).
- Adjust the content of Access to SDK about [`MSDK initialization`](android.md#Step3:_MSDK initialization). It is a must to call WGPlatform.onRestart, WGPlatform.onResume, WGPlatform.onPause, WGPlatform.onStop and WGPlatform.onDestroy.**`Game developers should pay special attention to this content adjustment!`**

### Modified content of Android 2.6.0

#### Code changes:

- New features:
	- Add WeChat login via scan code (for games at the TV Hall game use)
	- Optimize configuration read, announcement and advertisement modules
	- Optimize WeChat’s token automatic refresh logic
	- Optimize log reporting logic
- SDK upgrade:
	-  Upgrade openSDK to 2.8 (Repair a bug: authorization at special scenes has no callback)
	-  Upgrade payment to 1.3.9d
- Bug repair:
	- Repair a bug: mobile QQ’s quick login skips My App Center’s number-grabbing module
	- Repair JG Audit’s weak check loophole

#### Document adjustment:
-  None 

Version history of Android 2.5
---

### Modified content of Android 2.5.1

#### Code changes:

- Bug repair

	1. Repair a bug: users can’t log in games in some models (currently known models include Coolpad 7296, DOOV-QC L1, ETON P5, Hasee w50t2)
	
#### Document adjustment:
None 

### Modified content of Android 2.5.0 (It is suggested to update it to the latest version of the current series)

#### Code changes:

- New features:
	- Built-in Webview UI optimization
	- Online time reporting and statistics
	- MSDK adds the handling of the event that the game process is killed by the system in the mobile QQ authorization process
	- **rqd is changed into bugly (namely crash reporting); in the configuration file, add CLOSE_BUGLY_REPORT; if this item is true, msdk does not initialize bugly by default**
	- Add statistics on the success rate and failure rate of Pigeon registration interface

#### Document adjustment:

- Add:
	- Add MSDK login module’s introduction [Click to view](login.md), including:
		- Comb MSDK’s authorization login-related modules, such as authorization login, automatic login and quick login modules
		- Description, comparison and recommended usages of MSDK’s authorization login-related interfaces
		-Access steps of MSDK authorization login module
		- Special scene introduction of MSDK authorization login module, such as: mobile QQ access module adds instructions on the scheme to log in the game after the game process is killed in the authorization process in the low-memory machine [Click to view `A scheme to log in the game after the game process is killed in the authorization process in the low-memory machine`](login.md# Other special handling logics).
	- Add MSDK share module’s introduction [Click to view](share.md), including:
		- Comb the share methods, use scene, share effects, click effects and precautions of MSDK share module’s interfaces
		- The method to combine MSDK share module’s interfaces with the specific use scenarios of games.
	-  The account inconsistency module adds FQA [Click to view](diff-account.md).
- Modify:
	-  Some contents of mobile QQ and WeChat’s login-related modules are moved to the login module
	-  The mobile QQ quick login module in the account inconsistency module is moved to mobile QQ
	- rqd is changed into bugly; MSDK Crash reporting module in the data reporting is adjusted [Click to view](rqd.md).

Version history of Android 2.4
---

### Modified content of Android 2.4.2

#### Code changes:

- Bug repair

	1. Repair a bug: users can’t log in games in some models (currently known models include Coolpad 7296, DOOV-QC L1, ETON P5, Hasee w50t2)
	
#### Document adjustment:
None 

### Modified content of Android 2.4.1 (It is suggested to update it to the latest version of the current series)

#### Code changes:

- SDK upgrade:

	1. Adjust OpenSDK to v2.6
	2. Upgrade WebView SDK version to 1.2
	
- New features:
	-  None
- ** Interface adjustment:**
	-  None

#### Document adjustment:

- Add:
	- Adjust the documents of the announcement module about [Announcement display interface `WGShowNotice`](notice.md#Announcement display interface) and [Announcement data acquisition interface `WGShowNotice`](notice.md# Announcement data acquisition interface); and add the usage instructions of the adjusted interfaces

### Modified content of Android 2.4.0 (It is suggested to update it to the latest version of the current series)

#### Code changes:

- SDK upgrade:

	1. Update Midas version to 1.3.9b
	2. Update OpenSDK to v2.7
	3. Update QMi to 1.5.1
	
- New features:
	- Add the callback of the game logout to QMi
- ** Interface adjustment:**
	- Modify the announcement module [Announcement display interface `WGShowNotice`](notice.md#Announcement display interface) and [Announcement data acquisition interface `WGShowNotice`](notice.md# Announcement data acquisition interface, and delete parameter noticeType.

#### Document adjustment:

- Add:
	- Adjust the document of the announcement module about [Announcement display interface `WGShowNotice`](notice.md#Announcement display interface) and [Announcement data acquisition interface `WGShowNotice`](notice.md# Announcement data acquisition interface); and add the usage instructions of the adjusted interfaces

Version history of Android 2.3
---

### Modified content of Android 2.3.4

#### Code changes:

- Bug repair

	1. Repair a bug: the upgrading of version 2.0 (higher than 2.0.4a) to version 2.3 may lead to crash
	
#### Document adjustment:
None 


### Modified content of Android 2.3.3 (It is suggested to update it to the latest version of the current series)

#### Code changes:

- Bug repair

	1.Repair a bug: users can’t log in games in some models (currently known models include Coolpad 7296, DOOV-QC L1, ETON P5, Hasee w50t2)
	
#### Document adjustment:
None 

### Modified content of Android 2.3.2 (It is suggested to update it to the latest version of the current series)

#### Code changes:

- SDK upgrade

	1. Update Midas version to 1.3.9d
	
#### Document adjustment:
None 

### Modified content of Android 2.3.1 (It is suggested to update it to the latest version of the current series)

#### Code changes:

- SDK upgrade

	1. Update Midas version to 1.3.9a
	2. Update built-in Webview to v1.2
	3. Update rdm to 1.8.3
	4. Update QMi to 1.4.1
	
#### Document adjustment:
None

### Modified content of Android 2.3.0 (It is suggested to update it to the latest version of the current series)

#### Code changes:


- SDK upgrade

	1. Update Midas version to 1.3.8c
	- Update OpenSDK to v2.6.1

- New features
    1. Add API
		- Share Url to WeChat, WGSendtoWeixinWithUrl
		- Bind a game to a QQ group, WGBindQQGroup
		- Join a group in the game, WGJoinQQGroup
		- Add friends in the game, WGAddFriendToQQ
		- Get WeChat or mobile QQ version, WGGetPlatformAPPVersion
		- Return the interface’s support situation, WGCheckApiSupport, increase the number of parameters to 4, which are respectively: eApiName_WGSendToQQWithPhoto=0, eApiName_WGJoinQQGroup=1, eApiName_WGAddGameFriendToQQ=2 and eApiName_WGBindQQGroup=3
    - Add automatic refresh switch configuration for WeChat accesstoken
    - Add Dop advertising data reporting statistics
- Function adjustment
	1.  QMi decoupling
		1. Update QMi version to 1.2
		2. Delete three QMi-related interfaces: WGShowQMi, WGHideQMi, WGSetGameEngineType
- Bug repair
    - When overdue ads are deleted, the local images are not deleted

#### Document adjustment:

- Add:
	1. The mobile QQ access module adds Part 7 (Joining a group and adding friends within the game)
	2. The WeChat access module adds Part 7 (URL sharing (Wechat moment/session)
	3. Add description documentation for some tool interfaces (detect if the platform is installed and if the interface is supported, get the platform version, get the channel number)
	4. Access SDK Pigeon push function
- Modify:
	1. Add precautions for WeChat access: If you don’t need WeChat’s accesstoken automatic refresh function, just set WXTOKEN_REFRESH as false in assets\msdkconfig.ini

Version history of Android 2.2
---
### Modified content of Android 2.2.0 (internal version; not published)

#### Code changes:

- New features
	1. MSDK encapsulate WeChat personal information interface
	- Access Pigeon push function
	- Storage and reporting of local key logs
- Bug repair 
	1. Repair a bug: AMS can’t be shared when built-in Webview opens it
	- The User-agent field of the HTTP header is added with the demand for the terminal source of information
	
#### Document adjustment:
- Delete 
	1. Delete the “Share with game friends 2” part in the “Structured message sharing” section in Chapter 6
- Modify 
	1. In the “Share with game friends 1” part, the interface uses WGSendToWXGameFriend function carrying parameter extMsdkInfo, but the function didn’t carry parameter extMsdkInfo before
	- It is not recommended to use “Refresh WeChat accesstoken” in Chapter 6: Access to WeChat


Version history of Android 2.1
---
### Modified content of Android 2.1.0 (internal version; not published)
#### Code changes:

1. Midas Android SDK V1.3.7b version integration
- Correct errors in the documentation
3. Built-in Webview URL is added with openid in plaintext
4. Add a personal info query interface
5. Add that the image supports the local path in mobile QQ structured message sharing
6. Add to get city info in LBS
7. MSDK advertisement system’s Phase I

Version history of Android 2.0
---

### Modified content of Android 2.0.6
#### Code changes:

1. Repair a bug: AMS can’t be shared when built-in Webview opens it
- Payment SDK is upgraded to 1.3.8c
- Repair a bug: QMi can’t be logged in after the Game Hall launches a game
- Adjust MSDK’s announcement module to be enabled by default
- All login interface calls are added with deviceinfo reporting
- The built-in Webview removal interface searchBoxJavaBridge_ passes the test of JG Audit

#### Document adjustment:
 None 
### Modified content of Android 2.0.5
#### Code changes:
    1.MTA upgrade
        【Modify】Update MTA version to 2.0
    2.Repair a bug: No data available for Beacon Crash analysis
	【Modify】Update eup_1.8.0->eup1.8.0.1, and add CrashReport.setDengta_AppKey(context, qqAppId) in the initialization of Beacon;
    3. Update Midas to V1.3.8
    4. Add a new field to the login data unified reporting
 
##### Document adjustment:
	【Delete】Delete “Share with game friends 2” in Chapter 6: Access to WeChat
    【Modify】In the “Share with game friends 1” part, the interface uses WGSendToWXGameFriend function carrying parameter extMsdkInfo, but the function didn’t carry parameter extMsdkInfo before
        
### Modified content of Android 2.0.4
#### Code changes:
    1.OpenSDK upgrade
		【Modify】Update opensdk version to 2.5
		【Add】Add three interfaces for joining a group and adding friends within the game in mobile QQ :WGAddGameFriendToQQ, WGJoinQQGroup, WGBindQQGroup
		【Modify】Modify WGCheckApiSupport, and add support to the three interfaces for joining a group and adding friends
    2. QMi decoupling
		【Modify】Update QMi version to 1.2
		【Delete】Delete three QMi-related interfaces: WGShowQMi, WGHideQMi, WGSetGameEngineType
    3. Bug repair for built-in Webview sharing
		【Modify】Repair a bug: When built-in Webview  shares pictures  to  mobile QQ/QZone, the small picture in the share window always display the first shared small picture
		【Modify】When built-in Webview shares messages, it doesn’t need to send callback to the game; when QQ shares messages, the device must be installed with QQ; when WeChat shares messages, the device must be installed with WeChat
    4. Add interfaces to read mobile QQ and WeChat version numbers
		【Add】Add the interface to get mobile QQ or WeChat version number: WGGetPlatformAPPVersion
#### Document adjustment:
	【Add】Add Part 7 (Joining a group and adding friends within the game) in Chapter 5: Access to mobile QQ
	【Add】Add Chapter 19, and add description documentation for some tool interfaces (detect if the platform is installed and if the interface is supported, get the platform version, get the channel number)
	
### Modified content of Android 2.0.3
1. Repair a bug: crash arising from getting Bluetooth device name

### Modified content of Android 2.0.2
1. Update payment SDK to 1.3.7b
2. Optimize the callbacks of mobile QQ big picture and music sharing, which no longer only return “Success”
3. Adjust QMi SDK resources
4. Update rqd version to eup_1.8.6.jar
5. Make mid-sdk-2.10.jar independent and don’t merge it into MSDK’s jar package
6. Repair a bug: MSDK’s local log may be unable to be deleted
7. Add BLUETOOTH_ADMIN permission to the local log reporting

### Modified content of Android 2.0.1
1. Add the login data reporting, and require that the game call WGPlatform.onPause() within onPause of the game’s Activity;
2. Update My App Center’s traffic-saving SDK to version TMAssistantSDK_toMsdk_201407151049.jar
3. Update Beacon SDK to 1.8.10
4. Import mid-sdk-2.10.jar, and use mat mid as the device id
5. Update QMi SDK to qqgamemi_r226394.jar
6. Repair a bug: that ExtMsdkInfo shared by WGSendMessageToWechatGameCenter interface is null may lead to crash


### Modified content of Android 2.0.0

1. Delete WGSendToWeixin(const eWechatScene& scene, unsigned char* title, unsigned char* desc, unsigned char* url, unsigned char* mediaTagName, unsigned char* thumbImgData, const int& thumbImgDataLen) interface, which is replaced with a new interface which doesn’t have the first parameter “scene”; the platform asks to do so in order to prevent some games from using this interface to share contents to Wechat moment
2. Modify WGLoginWithLocalInfo interface to provide more convenient access for non-first visitors
3. Add the local timed token refresh function, which checks the token every 10 minutes and refreshes it once it expires
4. Optimize the announcement module, add image and webpage  announcements; add  the timed announcement draw function
5. Integrate QMi
6. Repair a bug: When token expires, WGGetLoginRecord doesn’t return openid
7. Optimize the built-in Webview module, upgrade the built-in Webview SDK version; add a download monitor; download through opening a new browser, solve the problem that click has no response when downloading something


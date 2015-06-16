
Introduction of MSDK iOS
=======

### [SDK download site](http://mcloud.ied.com/wiki/MSDK%E4%B8%8B%E8%BD%BD) [Quick Download](iOSPlugin.md)

## Introduction of Functions
 
#### MSDK is developed and provided by Tencent IEG for its own R&D teams and third-party mobile game development teams, designed to help developers quickly access various major platforms of Tencent and its online operating common components and services libraries

## Structure of the installation package

* 2.3.4i and earlier versions:


	The compressed file contains the demo project, which includes WGPlatform.embeddedframework/WGPlatform_C11.embeddedframework:
	WGPlatform.embeddedframework is applicable to projects with “Build Setting->C++ Language Dialect” as GNU++98 and “Build Setting->C++ Standard Library” as “libstdc++(GNU C++ standard library)” ; 
	WGPlatform_C11.embeddedframework is applicable to projects with the above two configurations as “GNU++11” and “libc++(LLVM C++ standard library with C++11 support)”, respectively.


![linkBundle](./File structure 1.PNG)


  WGPlatform.embeddedframework and WGPlatform_C11.embeddedframework have the same file structure. Take WGPlatform.embeddedframework for example. For the uses of folders [including contents] in it, please see relevant chapters in the documentation. When you upgrade the version, what you need to do is to delete its original files and import new files into it.
![linkBundle](./file structure 2.PNG) 


* 2.4.0i and earlier versions:


    The compressed file contains the demo project, which includes:
    1. MSDKFoundation.framework: basic dependencies library.
    2. MSDK.framework: provide the basis login and sharing functions.
    3. MSDKMarketing.framework: provide cross-marketing and built-in browser functions.
    4. MSDKXG.framework: offer the push functionality.
    Of them, MSDKFoundation.framework is the basic dependencies library and must be imported; and the other three are optional libraries and imported according to the actual needs.
    MSDK.framework, MSDKFoundation.framework, MSDKMarketing.framework and MSDKXG.framework are applicable to projects with “Build Setting->C++ Language Dialect” as GNU++98 and “Build Setting->C++ Standard Library” as “libstdc++(GNU C++ standard library)”;
    Corresponding framework with C11 are applicable to projects with the above two configurations as “GNU++11” and “libc++(LLVM C++ standard library with C++11 support)”, respectively.


![linkBundle](./file structure_2.4.0_1.PNG)


   The upgrade method of the version is the same with that of 2.3.4i version, that is, to delete its original files and import new files into it.

## Contained contents

* 2.3.4i and earlier versions:
#### Header files and static library files are placed in: `WGPlatform.framework`; resource files are placed in: `WGPlatformResources.bundle` (the folder in versions earlier than 2.3.4i is "MsdkResources").
#### Major interfaces are placed in `WGPlatform.h` file, MSDK’s relevant structures are placed in `WGCommon.h` file, enumeration values are defined in `WGPublicDefine.h`, push interfaces are placed in ` WGApnInterface.h` file, the main callback objects are in `WGObserver.h` file, and advertising callback objects are in `WGADObserver.h` file.

* 2.4.0i and earlier versions:

#### Header files and static library files are placed in various framework, respectively; resource files are placed in `/MSDKMarketing/WGPlatformResources.bundle`.
#### Major interfaces are placed in `MSDK.framework/WGPlatform.h` file, MSDK’s relevant structures are placed in `MSDKFoundation.framework/MSDKStructs.h` file, enumeration values are defined in `MSDKFoundation.framework/MSDKEnums.h` file, push interfaces are placed in `MSDKXG.framework/MSDKXG.h` file, the main callback objects are in `MSDK.framework/WGPlatformObserver.h` file, and advertising callback objects are in `MSDK.framework/WGADObserver.h` file.

### Module Description

| Module | Function | Access condition |
| ------------- |:-------------:|:----:|
| Platform| WeChat and mobile QQ are collectively called platform||	
|Data analysis module	Provide data reporting and exception reporting	||	
|Mobile QQ	 |Provide the ability to log in mobile QQ and share messages among mobile QQ users	|Require appId and appKey in mobile QQ
|WeChat |	Provide the ability to log in WeChat and share messages among WeChat users	|Require appId and appKey in WeChat|
|QQ Game Hall	| Provide the Game Hall the ability to launch games	||	
|Built-in Webview	| Provide built-in Webview capabilities within the application	||	
|Notification Board	|Provide the ability to scroll and pop up notices	||	
|LBS	|Provide location-based capabilities to draw friends	||	
|Guest mode|Offer login and payment functions for visitors	|Require mobile QQ or WeChat’s AppID and appKey|
|Push|Provide message push capabilities|||	

  
### Terminology


| Term | Description |
| ------------- |:-------------|
| Platform| WeChat and mobile QQ are collectively called platform|
|openId|The unique identifier returned by the platform for the user after the user is authorized|
|accessToken|The user’s authorization token. After getting the token, the user can be considered to be authorized. Sharing, payment and other functions need the token. Mobile QQ accessToken is valid for 90 days. WeChat accessToken is valid for only two hours.|
|payToken|A payment token, which is used to pay in mobile QQ. After the user is authorized in mobile QQ, the token will be returned to the user. After the user is authorized in WeChat, the token will not be returned to the user. The token is valid for 6 days.|
|refreshToken|A WeChat platform-specific token, valid for 30 days, used to refresh accessToken after WeChat accessToken expires.|
|Account inconsistency|The authorized account in the game is not the same with the authorized account in mobile QQ / WeChat. This phenomenon is called account inconsistency.|
|Structured message|A type of shared message. After such message is shared, its display form is: the left is the thumb, the top right is the message header, and the bottom right is the message summary.|
|Big picture message|A type of shared message. Such a message contains only a picture or an image and is also |shown with only a picture or an image. It is also called big picture sharing or pure picture sharing.|
|Game friends|Among mobile QQ or WeChat friends, those who have played the same game are called game friends|
|Game Center|Game centers in mobile QQ client or WeChat client are collectively called Game Center|
|Game Hall|Specifically refer to QQ Game Hall|
|Platform wakeup|Launch a game through the platform or channel (Mobile QQ / WeChat / Game Hall / MyApp, etc.)|
|Relation chain|The user’s friends in the platform|
|Conversation|Chat messages in mobile QQ or WeChat. It is also sometimes called session.|
|Installation channel|CHANNEL_DENGTA value configured by info.plist; the current default value is 1001 (AppStore)|
|Registration channel|When the user first logs on, the game's installation channel will be recorded in the back-end of MSDK and counted as the user’s registration channel.|
|Pf|A required field for payment, used for data analysis. Its composition: platform wakeup _ account system - registration channel - operating system - installation channel - account system – appid - openid. For example: desktop_m_qq-73213123-android-73213123-qq-100703379-A65A1614A2F930A0CD4C2FB2C4C5DBE1.|
|pfKey| Used for payment|
|AMS|	Senior IEG marketing system, which is responsible for the marketing planning and development of games|
|Quick login|	In the mobile QQ game list or share link, directly pass the logged account information of mobile QQ to the game to achieve login and do not require the game to be reauthorized by the user. Such a function is called quick login. Required environment: MSDK 1.8.0i and above, mobile QQ4.6.2 and above.|
|Guest mode|	Apple requires that iOS mobile game should provide login modes besides mobile QQ/WeChat platform so that the visitor can directly enter the game to experience the full game content and can complete the payment under this mode.|
|GuestID|	A visitor identifier generated by registering to MSDK through the device information, it is a 34-bit string, with a format: _"G_ number/letter/_ /@"|
|Guest AppID|	In order to identify the visitor mode, AppID under the Guest mode uses "G\ _ mobile QQ AppId" format. If the game does not have mobile QQ AppID, it can use "G\_WeChat AppID", such as G_12345|
|Guest AppKey|	Paired with Guest AppID; use the corresponding mobile QQ/WeChat AppKey.|
|Payment id|	Also called OfferId, and configured in MSDK_OfferId item of info.plist. <br> Tencent’s self-developed games: directly register an iOS application in midas.qq.com to generate offerid <br> Agent games: the games first apply Apple information in rdm.oa.com, then submit the applied information to the Cooperative Planning Group’s jiaganzheng to input it into the device backstage, and then the developer adds the IAP version in the Administration Center; after the addition is completed,  offerid will be generated

## Notes

Midas, a mobile payment app launched by Tencent, is independent of MSDK. For relevant payment documents, please refer to http://midas.qq.com
appId, appKey and offerId are tokens used to access related modules.   The methods to apply for them are described in "Introduction to MSDK Products".

## Version history
 
* [Click to view the version change history of MSDK] (version.md)


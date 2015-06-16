Introduction of MSDK Android
=======

Module Description
---

| Module | Function | Access condition |
| ------------- |:-------------:|
|Data analysis module|Provide data reporting and exception reporting	||	
|Mobile QQ	 |Provide the ability to log in mobile QQ and share messages among mobile QQ users	| Require appId and appKey in mobile QQ|
|WeChat | Provide the ability to log in WeChat and share messages among WeChat users	|Require | appId and appKey in WeChat|
|QQ Game Center	| Provide the Game Hall the ability to launch games	|	
|Built-in Webview	| Provide built-in Webview capabilities within the application	|	
|Announcement	| Provide the ability to scroll and pop up announcements	||	
|LBS	| Provide LBS capabilities	||	
|MyAppCenter early game experienceing registration|	Provide the capabilities to experience game in MyAppCenter	|The access process should |refer to "Guide to Access the game experiencing registration Function of MyAppCenter" in the SDK package|
|MyAppCenter traffic-saving update|	Provide the ability to update the traffic-saving of MyAppCenter|	
Note:
- Midas, a mobile payment app launched by Tencent, is independent of MSDK. Please read relevant payment documents.
- appId, appKey and offerId are tokens used to access related modules.   The methods to apply for them are described in "Introduction to MSDK Products".

Terminology
---

| Term | Description |
| ------------- |:-------------:|
| Platform| WeChat and mobile QQ are collectively called platform|
|openId|The unique identifier returned by the platform for the user after the user is authorized|
|accessToken|The user’s authorization token. After getting the token, the user can be considered to be authorized. Sharing, payment and other functions need the token. Mobile QQ accessToken is valid for 90 days. WeChat accessToken is valid for only two hours.|
|payToken|A payment token, which is used to pay in mobile QQ. After the user is authorized in mobile QQ, the token will be returned to the user. After the user is authorized in WeChat, the token will not be returned to the user. The token is valid for 6 days.|
|offerId|Used in the payment. Android’s offerId is mobile QQ appid|
|refreshToken|A WeChat platform-specific token, valid for 30 days, used to refresh accessToken after WeChat accessToken expires.|
|Account inconsistency	The authorized account in the game is not the same with the authorized account in mobile QQ / WeChat. This phenomenon is called account inconsistency.|
|Structured message|A type of shared message. After such message is shared, its display form is: the left is the thumb, the top right is the message header, and the bottom right is the message summary.| 
|Big picture message|A type of shared message. Such a message contains only a picture or an image and is also shown with only a picture or an image. It is also called big picture sharing or pure picture sharing.|
|Game friends|Among mobile QQ or WeChat friends, those who have played the same game are called game friends|
|Game Center|Game centers in mobile QQ client or WeChat client are collectively called Game Center
|Game Hall|Specifically refer to QQ Game Hall|
|Platform wakeup|Launch a game through the platform or channel (Mobile QQ / WeChat / Game Hall / MyApp, etc.)|
|Relation chain|The user’s friends in the platform|
|Conversation|Chat messages in mobile QQ or WeChat|
|Installation channel|Before a game is launched online, packaging can generate apk packages with different channel numbers according to different channels (such as Tencent MyApp, Wandoujia, 91, etc.). The channel number on the installation package is called installation channel.|
|Registration channel|When the user first logs on, the game's installation channel will be recorded in the back-end of MSDK and counted as the user’s registration channel.|
|Pf|A required field for payment, used for data analysis. Its composition: platform wakeup _ account system - registration channel - operating system - installation channel - account system – appid - openid. For example: desktop_m_qq-73213123-android-73213123-qq-100703379-A65A1614A2F930A0CD4C2FB2C4C5DBE1.|
|pfKey| Used for payment| 

Version History
---
* [Click to view the version change history of MSDK] (version.md)

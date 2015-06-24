# 2.Mobile QQ interfaces

## 2.1 Oauth service

　Realize the relevant functions of the authorized login of mobile Oauth
### 2.1.1/auth/verify_login 

#### 2.1.1.1Interface specification

　　　Verify the user's login status and judge whether or not openkey has expired. If openkey has not expired, renew its validity (calling it once can renew its validity for two hours).
msdkExtInfo =xxx (request serial number) is carried in URL. The returned content can bring back the original data of msdkExtInfo. This can achieve a purely exceptional request. msdkExtInfo is an optional parameter.

#### 2.1.1.2Input parameter description


| Parameter name| Type|Description|
| ------------- |:-------------:|:-----|
| appid| int| The exclusive id of an app in the QQ open platform|
| openid|string|The unique identifier of a common user (QQ platform)|
| openkey|string|Authorized token access_token|
| userip|string|The user’s client ip|


#### 2.1.1.3Output parameter description

| Parameter name| Description|
| ------------- |:-----|
| ret|Return code  0: correct，Others：failure|
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|


#### 2.1.1.4 Interface call description

| Parameter name| Description|
| ------------- |:-----|
|url|http://msdktest.qq.com/auth/verify_login/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format|JSON |
| Request mode|POST  |


#### 2.1.1.5 Request example
	POST /auth/verify_login/?timestamp=*&appid=**&sig=***&openid=**&encode=1 
	HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198

	{
	    "appid": 100703379,
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	    "openkey": "933FE8C9AB9C585D7EABD04373B7155F",
	    "userip": "192.168.5.114"
	}

	//return result: 
	{"ret":0,"msg":"user is logged in"}

2.2 Share service
---
　Provide the directed sharing ability of mobile QQ and mobile Qzone

### 2.2.1 /share/qq ###

#### 2.2.1.1 Interface specification ####

Point-to-point directed sharing (share information to mobile QQ friends, and display such info in a public account called “QQ mobile game”)

***PS: The shared content can only be seen on mobile QQ but can’t be seen on PC QQ. The recipient needs to pay attention to the public account “QQ mobile game” so that he or she can receive the shared message. The same user can receive about 20 pieces of message about the same game on the same day. The size of the whole message is controlled within 700byte. ***

#### 2.2.1.2 Input parameter description ####

| Parameter| Type|	Description
| ------------- |:-------------:|:-----|
| openid|string	The ordinary user’s exclusive identifier (QQ platform)
| userip|string	The user client ip
|Act|int|Skip behavior(0: URL skip；1:APP skip，default:0)|
|oauth_consumer_key|int|appid(The exclusive id of an app in QQ platform)|
|Dst|int|msf-mobile QQ (including iphone, android QQ, etc.);currently only able to be filled with 1001|
|Flag|int|Roaming (0: yes; 1: no; currently only able to be filled with 1)|
|image_url|string|URL to share pictures (picture size specification: 128 * 128; need to ensure that the URL is accessible; and the picture size can not exceed 2M)|
|openid|string|User ID|
|access_token|string|Authorized token|
|Src|int|information source (default:0)|
|Summary|string|Summary, no longer than 45 bytes|
|target_url|string|URL of the Game Center’s details page <br>http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite<br>， no longer than 512 bytes|
|Title|string|Shared message’s title, no longer than 45 bytes|
|Fopenids|vector<json Object> or json string (compatible)|Json array, whose data format is [{"openid":"","type":0}]，openid is a friend's openid; type is fixed to pass 0， only support to share message to a friend.|
|previewText|string	Optional. Don’t need to be filled in with any value
|game_tag|string|Optional. game_tag	is used for the platform to make statistics of “share” type, such as “send heart” share and “exceed” share. The value is set by the developer and sent synchronically to the mobile QQ platform. The current values include:MSG_INVITE                //inviteMSG_FRIEND_EXCEED       //show off “exceed”MSG_HEART_SEND          //send heartMSG_SHARE_FRIEND_PVP    //PVP fight</td>|
***Please note that the type of input parameters. Refer to 1.5***
#### 2.2.1.3Output parameter description 

| Parameter name| Description|
|------------- |:-----|
| ret|Return code  0：correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|


#### 2.2.1.4 Interface call description

| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/auth/share/qq/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST |


#### 2.2.1.5 Request example ####

	POST 
	/share/qq/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198

        {
	    "act": 0,
	    "oauth_consumer_key": 100703379,
	    "dst": 1001,
	    "flag": 1,
	    "image_url": "http://mat1.gtimg.com/www/images/qq2012/erweimaVideoPic.png",
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	    "access_token": "933FE8C9AB9C585D7EABD04373B7155F",
	    "src": 0,
	    "summary": "Summary",
	    "target_url”: “http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite
	",
	    "title": "test by hunter",
	    "fopenids": [{"openid":"69FF99F3B17436F2F6621FA158B30549","type":0}],//json array
	    "previewText": "I am playing LinkLink"
	}

	//return result
	{"ret":0,"msg":"success"}

#### 2.2.1.6 Return code ####
Return code is the integer before the first comma in the parameters in msg in the returned result

| Return code| Description|
| ------------- |:-----|
| 100000|Authentication error！uin, skey are wrong|
| 100001|Parameter error！Lack the required parameters, or the parameter type is wrong|
| 100003|Service error！Please contact the relevant developer|
| 100004|Dirty word error！Keywords involve porn, politics, etc.|
|100100|CGI can only be requested by post|
|100101|CGI has restrictions on Referer| 
|100012|Service timeout error! Please contact the relevant developer|
|111111 |Unknown error! Please contact the relevant developer|
|99999 | Frequency limit error|
|Other |Back-end service returns an error code! Please contact the relevant developer|


#### 2.2.1.8 Share screenshot example ####
![shareQQ](shareQQ.jpg)


![Shared image](./shareQQ_detail.jpg)


##2.3 Relation service ##
---
### 2.3.1/relation/qqprofile ###
#### 2.3.1.1 Interface specification####
　　　Acquire the basic information of the user’s QQ account
#### 2.3.1.2 Input parameter description ####

| Parameter name| Type|Description|
| ------------- |:-------------:|:-----|
| appid| string| The exclusive id of an app in the platform |
| accessToken|string|The login status |
| openid|string|The unique identifier of the user in an app |

#### 2.3.1.3 Output parameter description ####

| Parameter| Description|
| ------------- |:-----|
| Ret|Return code  0：correct  Others: failure |
| Msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| nickName|The user's nickname in QZone (be synchronous with the user's nickname in mobile QQ) |
| gender|Gender. If the value can't be acquired, the default return value is “Male”  |
| picture40|URL of QQ head portrait with a size of 40 × 40 pixels |
| picture100|URL of QQ head portrait with a size of 100 × 100 pixels. Notice: not every user has a 100x100 head portrait, but every user certainly has a 40x40 head portrait |
| yellow_vip|Whether the user is a yellow diamond VIP. 0 indicates he/she is not a yellow diamond VIP|
| yellow_vip_level|Yellow diamond level |
| yellow_year_vip|Whether the user is an annual fee yellow-diamond VIP. 0 indicates no. |
| is_lost|When is_lost is 1, it indicates that the acquired data have been downgraded: At this point, if the business layer has the cached data, the user can use the cached data at first; if not, use the current data. When the flag is marked with 1, do not cache the data. |

#### 2.3.1.4 Interface call description ####

| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqprofile/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

#### 2.3.1.5 Request example ####

	POST /relation/qqprofile/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198

	{
	    "appid": 100703379,
	    "accessToken": "FCCDE5C8CDAD70A9A0E229C367E03178",
	    "openid": "69FF99F3B17436F2F6621FA158B30549"
	}
	//return result
	{
	    "ret": 0,
	    "msg": “success”,
	    "nickName": “Hunter”,
	    "gender": “Male”,
	    "picture40": “http://q.qlogo.cn/qqapp/100703379/A3284A812ECA15269F85AE1C2D94EB37/40”,
	    "picture100": “http://q.qlogo.cn/qqapp/100703379/A3284A812ECA15269F85AE1C2D94EB37/100”,
	    "yellow_vip": 0,
	    "yellow_vip_level": 0,
	    "yellow_year_vip": 0,
	    "is_lost": “0”
	}

### 2.3.2/relation/qqfriends_detail ###

#### 2.3.2.1Interface specification ####
Interface used to obtain the detailed personal information of QQ game friends
#### 2.3.2.2Input parameter description ####

| Parameter name| Type| Description|
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| accessToken|string|The login status |
| openid|string|The unique identifier of the user in an app |
| flag|int| When flag=1, return a friend relationship chain which doesn’t contain the user himself/herself; when flag=2, return a friend relationship chain which contains the user himself/herself. Other values are invalid. Use the current logic.|

*** (Please notice the type of the input parameter,Refer to 1.5) ***

#### 2.3.2.3 Output parameter description ####
| Parameter name| Description|
| ------------- |:-----|
| ret|Return code  0：correct  Others: failure |
| msg|If ret is not 0, it means "Error code, error prompt". For details, please refer to Section 5|
| list|QQ game friends’ personal info list, type	`vector<QQGameFriendsList>`|
| is_lost|When is_lost is 1, it indicates that the acquired data have been downgraded: At this point, if the business layer has the cached data, the user can use the cached data at first; if not, use the current data. When the flag is marked with 1, do not cache the data. |

	struct QQGameFriendsList {
    	    string          openid;      //a frient’s openid
    	    string          nickName;   //nickname (output the remarks at first; in case of no remark, output nickname)
    	    string          gender;      //gender; if the user doesn’t fill in it, return “male” by default
		string          figureurl_qq;  //a friend’s QQ head portrait URL; it is a must to add the following parameters /40, /100 behind URL, so that to get pictures with different sizes:
	　　40*40(/40),100*100(/100)
	 };

#### 2.3.2.4 Interface call description ####

| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqfriends_detail/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

#### 2.3.2.5  Request example ####
	POST /relation/qqfriends_detail/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa852&openid=F4382318AFBBD94F856E8%2066043C3472E&encode=1
	
	{
	    "appid": “100703379”,
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	　　　"accessToken": "933FE8C9AB9C585D7EABD04373B7155F",
	    "flag": 1
	}
	//return result
	{
	    "ret": 0,
	    "msg": "success",
	    "lists": [
	        {
	            "openid": "69FF99F3B17436F2F6621FA158B30549",
	            "nickName": "Zhang Hong",
	            "gender": "Male",
	            "figureurl_qq": "http://q.qlogo.cn/qqapp/100703379/69FF99F3B17436F2F6621FA158B30549/"
	        }
	    ],
	    "is_lost": "0"
	}

### 2.3.3/relation/qqstrange_profile ###
#### 2.3.3.1 Interface specification ####
Get the personal information of QQ strangers (including QQ friends). <br>
***PS: 1. The interface is now only available to games which have developed functions like “Nearby People”<br>
2. It is needed to get the openid list of QQ strangers in the client before the interface can be called***


#### 2.3.3.2 Input parameter description ####


| Parameter name| Type|Description|
| ------------- |:-------------:|:-----|
| appid| string| The exclusive id of an app in the platform |
| accessToken| string| The login status |
| openid| string| The unique identifier of the user in an app |
| vcopenid| vector<string>| It is needed to query the openid list of QQ strangers (including QQ friends), such as: vcopenid:[“${openid}”,”${openid1}”]|


***(Please notice the type of the input parameter. Refer to 1.5)***

#### 2.3.3.3 Output parameter description ####

| Parameter name| Description|
| ------------- |:-----|
| ret|Return code  0: correct，Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| list|The personal info list of QQ strangers (including QQ friends): Type vector< QQStrangeList>|
| is_lost | When is_lost is 1, it indicates that the acquired data have been downgraded: At this point, if the business layer has the cached data, the user can use the cached data at first; if not, use the current data. When the flag is marked with 1, do not cache the data. |
	struct QQStrangeList {
	    string          openid;          //openid
	    string          gender;          //gender “1”
	    string          nickName;        //nickname
	    string          qzonepicture50;  // The user’s head portrait size is the 50×50 head portrait URL in the friend’s QZone
	    string          qqpicture40;     // The user’s head portrait size is the 40×40 head portrait URL in the friend’s QZone
	    string          qqpicture100;    // The user’s head portrait size is the 100×100 head portrait URL in the friend’s QZone
	    string          qqpicture;       // The user’s head portrait size is the self-adaptive head portrait URL in the friend’s QZone; it is a must to add the following parameters /40, /100 behind URL, so that to get pictures with different sizes:40*40(/40),100*100(/100)
	};

#### 2.3.3.4 Interface call description ####

| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqstrange_profile/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST |

#### 2.3.3.5 Request example ####

	POST /relation/qqstrange_profile/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa***&openid=F4382318AFBBD94F856E8%2066043C3472E&encode=1
	
	{
	    "appid": 100732256,
	    "openid": "B9EEA5EE1E99694146AC2700BFE6B88B",
	    "accessToken": "C9A1F622B7B4AAC48D0AF3F73B1A3D83",
	    "vcopenid": [
	        "B9EEA5EE1E99694146AC2700BFE6B88B"
	    ]
	}
	//return result
	{
	    "ret": 0,
	    "msg": “success”,
	    "lists": [
	        {
	            "openid": "B9EEA5EE1E99694146AC2700BFE6B88B",
	            "gender": "1",
	            "nickName": "/xu゛♥ Hurry into the bowl!",
	            "qzonepicture50": "http://thirdapp1.qlogo.cn/qzopenapp/aff242e95d20fb902bedd93bb1dcd4c01ed5dc2a14b37510a81685c74529ab1e/50",
	            "qqpicture40": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B/40",
	            "qqpicture100": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B/100",
	            "qqpicture": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B"
	        }
	　　　],
	　　　"is_lost": "0"
	}


### 2.3.4 /relation/qqfriends_vip ###

#### 2.3.4.1Interface specification ####
 　Query the information of QQ members in batch

#### 2.3.4.2 Input parameter description ####

| Parameter| Type|Description|
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |
| accessToken|string|The user's login token in the app |
| fopenids|vector<string>|Friends' openid list. It is allowed to input up to 50 openid in the vector each time|
| flags|string|VIP business query identifier. Currently only support the query of QQ members' information: qq_vip, QQ super member: QQ_svip. It will support the query of more business users' VIP information. If you want to query a variety of VIP services, separate keywords with “,”; if you do not enter any value, query all by default. |
| userip|string|The caller's ip information|
| pf|string|The login platform for gamers. Default: openmobile, including openmobile_android/openmobile_ios/openmobile_wp etc.; the value comes from the return results of the client's logging in mobile QQ|

*** (Please notice the type of the input parameter. Refer to 1.5) ***

### 2.3.4.3 Output parameter description ###

| Parameter name| Description|
| ------------- |: -----|
| ret|Return code  0：correct, Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| list|Type: vector<QQFriendsVipInfo>,QQ game friends’ vip info list (see the following text)|
| is_lost|When is_lost is 1, it indicates that oidb gets data over time. It is proposed that when the game business detects that is_lost is 1, it should downgrade the acquired data and directly read the cached data or default data|
	
	struct QQFriendsVipInfo {
	    1   optional     string          openid;          //Friend’s openid
            2   optional     int             is_qq_vip;       //Is the user a QQ member? (0: no; 1: yes)
            3   optional     int             qq_vip_level;    //QQ member level  (return this field only in case that the user is a QQ member)
            4   optional     int             is_qq_year_vip;  //Is the user a QQ member who pays the annual fee? (0: no; 1: yes)
                5   optional     int             is_qq_svip;      //Is the user a QQ super member (0: no; 1: yes）
	};

#### 2.3.4.4   Interface call description####


| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqfriends_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST |

#### 2.3.4.5 Request example ####

	POST /relation/qqfriends_vip/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "appid": “100703379”,
	    "openid": “A3284A812ECA15269F85AE1C2D94EB37”,
	    "accessToken": “964EE8FACFA24AE88AEEEEBD84028E19”,
	    "fopenids‘: [
	        "69FF99F3B17436F2F6621FA158B30549"
	    ],
	    "flags": "qq_vip,qq_svip",
	    "pf": "openmobile_android",
	    "userip": "127.0.0.1"
	}
	//return result
	{
	    "is_lost": "0",
	    "lists": [
	        {
	            "is_qq_vip": 1,
	            "is_qq_year_vip": 1,
	            "openid”: “69FF99F3B17436F2F6621FA158B30549",
	            "qq_vip_level": 6,
				"is_qq_svip": 1
	        }
	    ],
	    "msg": "success",
	    "ret": 0
	}


### 2.3.5 /relation/get_groupopenid ###

#### 2.3.4.1 Interface specification ####
 　Get the relevant info of the QQ group bound with QQ union

#### 2.3.4.2 Input parameter description ####

| Parameter name| Type|Description|
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |
| accessToken|string|The user’s login token in the app |
| opt|string|Functional option; pass 0 or null (compatible with the previous calling situation): Use union id and zone id to exchange groupOpenid; when opt is 1: that is, use QQ group number to exchange group_openid|
| unionid|string|the union id of the game bound with groupOpenid; when opt pass null or opt = 0, this parameter is required|
| Zoneid|string|The game’s zone id; when union id is bound with QQ group, pass the value of parameter “zoneid”. |
| GroupCode|string|QQ group's original number|

*** (Please notice the type of the input parameter. Refer to 1.5) ***

### 2.3.4.3 Output parameter description ###

| Parameter name| Description|
| ------------- |: -----|
| ret| Return code  0: correct  Others: failure |
| msg| If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| is_lost| Judge whether there is data loss; if app does not use cache, do not care about this parameter; 0 or null: no data is lost, and you can cache the data; 1: there are some data loss or errors, do not cache data.|
| groupOpenid| groupOpenid of the group bound with the game’s union id; it is used as an input parameter when you get group members’ information or unbind a group|
| platCode| Platform error code; when ret is not zero, pay attention to it|

#### 2.3.4.4 Interface call description####


| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_groupopenid/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| Format |JSON |
| Request mode |POST  |

#### 2.3.4.5  Request example ####

	POST /relation/get_groupopenid/?timestamp=*&appid=**&sig=***&openid=**&encode=1&opua=AndroidSDK_17_maguro_4.2.2 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "appid":"100703379",
		"openid":"A3284A812ECA15269F85AE1C2D94EB37",
		"accessToken":"964EE8FACFA24AE88AEEEEBD84028E19",
		"opt":"0",	//string
		"unionid":"xxx",
		"zoneid":"0", //string
		"groupCode":"113172721" //string
	}
	//return result
	{
		"is_lost":"0",
		"platCode":"0",
		"groupOpenid":"xxxx",
	    "msg": "success",
	    "ret": 0
	}

#### 2.3.4.6 Description of returned error codes (platCode) ####
| Error code| Description |
| ------------- |:-----|
|2001 	|Parameter error. |
|2002 	|Have no binding records; please check if the incoming union id and zone id are correct. |
|2003 	|The entered openid is not a group member; only group members can view group_openid. |
|2004 	|The group has no binding relationship with appid. |
|2010 	|System error; please contact technical support through enterprise QQ; investigate the cause of the problem and get solutions. |
 
### 2.3.5 /relation/get_groupinfo ###

#### 2.3.5.1 Interface specification####
 　Get the basic info of QQ group bound with the game union

#### 2.3.5.2 Input parameter description ####

| Parameter name| Type | Description |
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |
| accessToken|string|The user’s login token in the app |
| groupOpenid|string|groupOpenid of QQ group bound with game union id; the parameter is gotten from the output parameters of /relation/get_groupopenid interface|


*** (Please notice the type of the input parameter. Refer to 1.5) ***

### 2.3.5.3 Output parameter description ###

| Parameter name| Description|
| ------------- |: -----|
| ret|Return code  0: correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| platCode|Platform error code; when ret is not zero, pay attention to it|
| is_lost|Judge whether there is data loss; if app does not use cache, do not care about this parameter; 0 or null: no data is lost, and you can cache the data; 1: there are some data loss or errors, do not cache data.|
| groupName|Group name|
| fingerMemo|The group’s relevant introduction|
| memberNum|Number of group members|
| maxNum|The maximum number of members that the group can accommodate|
| ownerOpenid|The group owner’s openid|
| unionid|union id bound with the QQ group|
| zoneid|zone id|
| adminOpenids|Administrator’s openid. If there are more than one administrators, separate them with ","; for example: 0000000000000000000000002329FBEF, 0000000000000000000000002329FAFF|


#### 2.3.5.4   Interface call description####


| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_groupinfo/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| Format|JSON |
| Request mode |POST  |

#### 2.3.5.5 Request example ####

	POST /relation/get_groupinfo/?timestamp=*&appid=**&sig=***&openid=**&encode=1&opua=AndroidSDK_17_maguro_4.2.2 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "appid":"100703379",
		"openid":"A3284A812ECA15269F85AE1C2D94EB37",
		"accessToken":"964EE8FACFA24AE88AEEEEBD84028E19",
		"groupOpenid":"84A812ECA15269F85AE1C2"
	}
	//return result
	{
		"is_lost":"0",
		"platCode":"0",
		"groupName":"xxxx",
		"fingerMemo":"xxxx",
		"memberNum":"1000",
		maxNum:"2000",
		"ownerOpenid":"A3284A812ECA15269F85AE1C2D94EB38",
		"unionid":"xxxx",
		"zoneid":"1",
		"adminOpenids":"0000000000000000000000002329FBEF,0000000000000000000000002329FAFF",
	    "msg": "success",
	    "ret": 0
	}

#### 2.3.5.6 Description of returned error codes (platCode) ####
| Error code| Description |
| ------------- |:-----|
|2001 	|Parameter error.    
|2002 	|The group’s openid has no binding records.  |
|2003 	|Only group members can view it. |
|2006 	|Failure in the correspondence relationship of the group’s openid and application verification.  |
|2007 	|The group has been disbanded or does not exist.|
|2100	|System error; please contact technical support through enterprise QQ; investigate the cause of the problem and get solutions. |  


### 2.3.6 /relation/unbind_group ###

#### 2.3.6.1 Interface specification ####
 　Information of QQ game union unbinding QQ group

#### 2.3.6.2 Input parameter description ####

| Parameter name| Type|Description|
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |
| accessToken|string|The user’s login token in the app |
| groupOpenid|string|groupOpenid of QQ group bound with game union id|
| unionid|string|union id bound with groupOpenid|


*** (Please notice the type of the input parameter. Refer to 1.5) ***

### 2.3.6.3 Output parameter description ###

| Parameter name| Description|
| ------------- |: -----|
| ret|Return code  0：correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| is_lost|Judge whether there is data loss; if app does not use cache, do not care about this parameter; 0 or null: no data is lost, and you can cache the data; 1: there are some data loss or errors, do not cache data. |
| platCode|Platform error code; when ret is not zero, pay attention to it|


#### 2.3.6.4   Interface call description ####


| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/unbind_group/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| Format |JSON |
| Request mode |POST  |

#### 2.3.6.5  Request example ####

	POST /relation/unbind_group/?timestamp=*&appid=**&sig=***&openid=**&encode=1&opua=AndroidSDK_17_maguro_4.2.2 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "appid":"100703379",
		"openid":"A3284A812ECA15269F85AE1C2D94EB37",
		"accessToken":"964EE8FACFA24AE88AEEEEBD84028E19",
		"groupOpenid":"84A812ECA15269F85AE1C2",
		"unionid":"xxxx"
	}
	//return result
	{
		"is_lost":"0",
		"platCode":"0",
	    "msg": "success",
	    "ret": 0
	}


#### 2.3.6.6 Description of returned error codes (platCode) ####
| Error code| Description |
| ------------- |:-----|
|2001 	|Can’t query any binding record of QQ group openid.  |
|2002 	|Fail to verify the correspondence relationship of QQ group opened and appid or union id.  |
|2003 	|Fail to verify the login status. |
|2004 	|Operate too often, please wait and then unbind QQ group.  |
|2006 	|Parameter error. |
|2007-2010 	|System error; please contact technical support through enterprise QQ; investigate the cause of the problem and get solutions.|  

### 2.3.7 /relation/get_group_detail ###

#### 2.3.7.1 Interface specification####
 　An interface used to get the detailed info of the QQ group binding with the game union

#### 2.3.7.2 Input parameter description ####

| Parameter name| Type |Description|
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |
| accessToken|string|The user’s login token in the app |
| opt|string|Functional option; pass 0 or null (compatible with the previous calling situation): Use union id and zone id to exchange groupOpenid; when opt is 1: that is, use QQ group number to exchange group_openid|
| unionid|string|the union id of the game bound with groupOpenid; when opt pass null or opt = 0, this parameter is required|
| Zoneid|string|The game’s zone id; when union id is bound with QQ group, pass the value of parameter “zoneid”.|
| GroupCode|string|QQ group's original number|


*** (Please notice the type of the input parameter. Refer to 1.5) ***

### 2.3.7.3 Output parameter description ###

| Parameter name| Description|
| ------------- |: -----|
| ret| Return code  0: correct  Others: failure |
| msg| If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| is_lost|Judge whether there is data loss; if app does not use cache, do not care about this parameter; 0 or null: no data is lost, and you can cache the data; 1: there are some data loss or errors, do not cache data. |
| platCode|Platform error code; when ret is not zero, pay attention to it|
| groupName|Group name|
| fingerMemo|The group’s relevant introduction|
| memberNum|Number of group members|
| maxNum|The maximum number of members that the group can accommodate|
| ownerOpenid|The group owner’s openid|
| unionid|union id bound with the QQ group|
| zoneid|zone id|
| adminOpenids|Administrator’s openid. If there are more than one administrators, separate them with ","; for example: 0000000000000000000000002329FBEF, 0000000000000000000000002329FAFF|
| groupOpenid|groupOpenid of QQ group bound with game union id|
| joinGroupKey|group_key used to join a QQ group|


#### 2.3.7.4   Interface call description ####


| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_group_detail |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| Format |JSON |
| Request mode |POST  |

#### 2.3.7.5  Request example ####

	POST /relation/get_group_detail?timestamp=*&appid=**&sig=***&openid=**&encode=1&opua=AndroidSDK_17_maguro_4.2.2 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
    "appid": "1000000688",
    "openid": "ECF664F0127DAB4004821795B40797F6",
    "accessToken": "A3296A00BA6E44EF739CC2EE52D35F52",
    "opt": "1",
    "unionid": "35502799",
    "zoneid": "35",
    "groupCode": "188959810"
	}
	//return result
	{
	    "adminOpenids": "",
	    "fingerMemo": "",
	    "groupName": "傲世西游35区绑群",
	    "groupOpenid": "4944D5C58AF654020B010465AC945E76",
	    "is_lost": "0",
	    "joinGroupKey": "",
	    "maxNum": "200",
	    "memberNum": "1",
	    "msg": "success",
	    "ownerOpenid": "ECF664F0127DAB4004821795B40797F6",
	    "platCode": "0",
	    "ret": 0,
	    "unionid": "35502799",
	    "zoneid": "35"
	}

#### 2.3.7.6 Description of returned error codes (platCode) ####
| Error code| Description |
| ------------- |:-----|
|2001 	|Parameter error. |
|2002 	|Have no binding records; please check if the incoming union id and zone id are correct.|
|2003 	|The entered openid is not a group member; only group members can view group_openid.|
|2004 	|The group has no binding relationship with appid.|
|2010 	|System error; please contact technical support through enterprise QQ; investigate the cause of the problem and get solutions.|

### 2.3.8 /relation/get_group_key ###

#### 2.3.8.1 Interface specification####
 　 An interface for QQ game union to get groupKey used to join a QQ group (currently only applicable to android)

#### 2.3.8.2 Input parameter description ####

| Parameter name| Type | Description |
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |
| accessToken|string|The user’s login token in the app |
| groupOpenid|string| groupOpenid of QQ group bound with game union id; it is gotten when the union president binds a QQ group|


*** (Please note that the type of the input parameter. Refer to 1.5) ***

### 2.3.8.3 Output parameter description ###

| Parameter name| Description|
| ------------- |: -----|
| ret|Return code  0: correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| is_lost|Judge whether there is data loss; if app does not use cache, do not care about this parameter; 0 or null: no data is lost, and you can cache the data; 1: there are some data loss or errors, do not cache data.|
| platCode|Platform error code; when ret is not zero, pay attention to it|
| joinGroupKey|groupKey for union members to join a group|



#### 2.3.8.4   Interface call description####


| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_group_key |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| Format |JSON |
| Request mode |POST  |

#### 2.3.8.5  Request example ####

	POST /relation/get_group_key?timestamp=*&appid=**&sig=***&openid=**&encode=1&opua=AndroidSDK_17_maguro_4.2.2 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
    "appid": "1000000688",
    "openid": "ECF664F0127DAB4004821795B40797F6",
    "accessToken": "A3296A00BA6E44EF739CC2EE52D35F52",
    "groupOpenid": "4944D5C58AF654020B010465AC945E76",
	}

	//return result
	{
		"ret": 0,
	    "msg": "success",
		"is_lost": "0",
		"joinGroupKey":"ggpas1lMAu9rDASaEXf2be1DYiw0o27I",
	    "platCode": "0"
	}



### 2.3.9 /relation/get_vip_rich_info ###

#### 2.3.9.1 Interface specification####
　　　Query the detailed info (recharge time & expiration date) of mobile QQ members

#### 2.3.9.2 Input parameter description ####


| Parameter name| Type|Description|
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |
| accessToken|string|The third party’s access token, which is gotten through the token acquisition interface |


*** (Please notice the type of the input parameter. Refer to 1.5)***

#### 2.3.9.3 Output parameter description ####

| Parameter name| Description|
| ------------- |:-----|
| ret|Return code  0: correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| is_lost|Judge whether there is data loss; if app does not use cache, do not care about this parameter; 0 or null: no data is lost, and you can cache the data; 1: there are some data loss or errors, do not cache data.|
| Is_qq_vip|Identify whether the user is a QQ Member (0: no; 1: yes)|
| Qq_vip_start|QQ member’s last recharge time, standard timestamp|
| Qq_vip_end|QQ membership term, standard timestamp|
| Qq_year_vip_start|Last recharge time of a QQ member paying the annual fee, standard timestamp|
| Qq_year_vip_end|Membership term of a QQ member paying the annual fee, standard timestamp|
| Qq_svip_start|QQ SVIP’s last recharge time, reserved field; the current information is not valid; standard timestamp|
| Qq_svip_end|QQ SVIP’s membership term, reserved field; the current information is not valid; standard timestamp|
| Is_qq_year_vip|Identify if the user is a QQ member paying the annual fee (0: no; 1: yes)|
| Is_svip|Identify if the user is a QQ super member (0: no; 1: yes)|


#### 2.3.9.4 Interface call description####

| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_vip_rich_info/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

### 2.3.9.5  Request example ###

	POST http://msdktest.qq.com/relation/get_vip_rich_info/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "accessToken": "E16A9965C446956D89303747C632C27B",
	    "openid": "F4382318AFBBD94F856E866043C3472E"
	}
	
	//return result
	{
	    "is_lost": "0",
	    "is_qq_vip": "0",
	    "msg": "success",
	    "qq_svip_end": "0",
	    "qq_svip_start": "0",
	    "qq_vip_end": "0",
	    "qq_vip_start": "0",
	    "qq_year_vip_end": "0",
	    "qq_year_vip_start": "0",
	    "ret": 0,
		"is_qq_year_vip":"1",
		"is_svip":"1"
	}





##  2.4.profile service  ##

    Provide services to query the VIP information of QQ account.

### 2.4.1 /profile/load_vip (the interface will stop service on June 30, 2015. If you want to query information about membership privileges, please call /profile/query_vip interface) ###
  Get the VIP information of QQ account.

#### 2.4.1.2 Input parameter description ####

| Parameter name | Type|Description|
| ------------- |:-------------:|:-----|
| appid|int| The exclusive id of an app in the platform |
| Login | int | Login type, default value: 2 |
| Uin | int | User identification; if openid account system is used, the default value is 0 |
| openid|string|The unique identifier of the user in an app|
| accessToken|string| `The user’s login status (new parameter)`|
| wxAppid|string| WeChat’s appid; at this time, login needs to be filled with 1, vip needs to be filled with 64; only used to query the privileges of WeChat Xinyue membership|
| vip|int| Query the type of membership:<br\>Member:vip&0x01 !=0; <br/>Blue Diamond:vip&0x04 != 0; <br/>Red Diamond:vip&0x08 != 0; <br/>Super Member:vip&0x10 != 0;<br/>Game Member:vip&0x20 != 0; <br/>Xinyue:vip&0x40 != 0; <br/>Yellow Diamond::vip&0x80 != 0; <br/>The above items can be combined freely (logical AND); if you want to query Member and Blue Diamond at the same time, (vip&0x01 !=0) && (vip&0x04 != 0) is true, (Note: when you request such info, you only need to fill in relevant flag bits)|
*** (Please notice the type of the input parameter. Refer to 1.5) ***

#### 2.4.1.3 Output parameter description ####

| Parameter name| Description|
| ------------- |:-----|
| ret|Return code 0: correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| list|info list vector<VIP> type (see the below); when getting Super Member, only isvip and flag parameters in struct VIP are valid.|
	
	struct VIP {
	　　VIPFlag: flag; //what type of VIP
            int isvip; //Judge if the user is VIP (the unique identifier to judge if the user is VIP; 0: no, 1: yes)
            int year; //Judge if the user pays the annual fee (0: no, 1: yes)
            int level; //VIP level
            int luxury; //Is it the luxury edition (0: no, 1: yes)
            int ispay;//Is the user a Game Member; only valid for querying Game Member
            int qqLevel;// QQ level: the crown, the sun, the moon, the star; only valid for VIP_NORMAL
	};
	enum VIPFlag
	{
	　　VIP_NORMAL(member) = 1
	　　VIP_BLUE (Blue Diamond) = 4,
	　　VIP_RED  (Red Diamond)= 8,
	　　VIP_SUPER (Super Member)= 16,
	　　VIP_GAME(Game Member)=32,
	　　VIP_XINYUE = 64,  //Xinyue club’s privileged member; when the flag bit is requested, only isvip and level are valid
	　　VIP_YELLOW = 128, //Yellow Diamond member, level field is invalid but others are valid
	};

#### 2.4.1.4   Interface call description ####
| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/load_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

#### 2.4.1.5  Request example ####
	
	POST /profile/load_vip/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	{
	    "appid": 100703379,
	    "login": 2,
	    "uin": 0,
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	    "vip": 13,
		"accessToken":"A3284A812ECA15A3284A812ECA15269F85AE1C2D94EB37269F85AE1C2D94EB37"
	}
	//Return format
	{
	    "ret": 0,
	    "msg": "",
	    "lists": [{
	        "flag": 1,
	        "year": 0,
	        "level": 0,
	        "luxury": 0,
	　　	"ispay": 0,
	        "isvip": 0,
	        "qqLevel": 1
	    },
	    {
	        "flag": 4,
	        "year": 0,
	        "level": 0,
	        "luxury": 0,
	　　	"ispay": 0,
	        "isvip": 0,
	        "qqLevel": 0
	
	    },
	    {
	        "flag": 8,
	        "year": 0,
	        "level": 0,
	        "luxury": 0,
	        "ispay": 0,
	        "isvip": 0,
	        "qqLevel": 0
	    }]
	}


### 2.4.2 /profile/query_vip ###
  Get the VIP info of QQ account (with the login status). 

#### 2.4.2.2 Input parameter description ####

| Parameter name | Type|Description|
| ------------- |:-------------:|:-----|
| appid|`string`| The exclusive id of an app in the platform; `Special attention: the type is string` |
| openid|string|The unique identifier of the user in an app|
| accessToken|string|` The user’s login status (new parameter)`|
| vip|int| Query type:<br/>member:vip&0x01 !=0; <br/>QQ level:vip&0x02 !=0; <br/>Blue Diamond:vip&0x04 != 0; <br/>Red Diamond:vip&0x08 != 0; <br/>Super Member:vip&0x10 != 0;<br/>Xinyue:vip&0x40 != 0; <br/>Yellow Diamond::vip&0x80 != 0; <br/> The above items can be combined freely (logical AND); if you want to query Member and Blue Diamond at the same time, (vip&0x01 !=0) && (vip&0x04 != 0) is true, (Note: when you request such info, you only need to fill in relevant flag bits)|
*** (Please notice the type of the input parameter. Refer to 1.5) ***

#### 2.4.2.3 Output parameter description ####

| Parameter name| Description|
| ------------- |:-----|
| ret|Return code 0: correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5, `”oidb decode0x5e1 failed, ret:116” occurring in the error description indicates that accessToken expires or opened is invalid`|
| list|info list vector<VIP> type (see the below); when getting Super Member, only isvip and flag parameters in struct VIP are valid.|
	
	struct VIP {
            VIPFlag: flag; // what type of VIP
            int isvip; // Judge if the user is VIP (the unique identifier to judge if the user is VIP; 0: no, 1: yes)
            int year; // Judge if the user pays the annual fee (0: no, 1: yes)
            int level; // VIP level
            int luxury; // Is it the luxury edition (0: no, 1: yes)
	};
	enum VIPFlag
	{
	　　VIP_NORMAL (member) = 1,
       VIP_QQ_LEVEL(QQ level) = 2,  //QQ level; only need to pay attention to level parameter, and others are invalid
	　　VIP_BLUE (Blue Diamond) = 4,
	　　VIP_RED  (Red Diamond)= 8, //Red Diamond, without the return of annual fee-paying member flag
	　　VIP_SUPER (Super Member)= 16,
	　　VIP_XINYUE = 64,  // Xinyue club’s privileged member; when the flag bit is requested, only isvip and level are valid
	　　VIP_YELLOW = 128,
	};

#### 2.4.2.4 Interface call description ####
| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/query_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

#### 2.4.2.5  Request example ####

	POST /profile/query_vip/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	{
	    "appid": "100703379",
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	    "vip": 15,
		"accessToken":"A3284A812ECA15A3284A812ECA15269F85AE1C2D94EB37269F85AE1C2D94EB37"
	}
	//Return format
	{
	     "ret": 0,
	    "msg": "",
	    "lists": [{
	        "flag": 1,
	        "year": 0,
	        "level": 0,
	        "luxury": 0,
	        "isvip": 0
	    },{
	        "flag": 2,
	        "year": 0,  
	        "level": 10, 
	        "luxury": 0, 
	        "isvip": 1  
	    },
	    {
	        "flag": 4,
	        "year": 0,
	        "level": 0,
	        "luxury": 0,
	        "isvip": 0
	    },
	    {
	        "flag": 8,
	        "year": 0,
	        "level": 0,
	        "luxury": 0,
	        "isvip": 0
	    }]
	}

### 2.4.3 /profile/get_gift ###

#### 2.4.3.1 Interface specification ####
　　　Receive Blue Diamond gift bag, which will be cleared after being called once.

#### 2.4.3.2 Input parameter description ####

| Parameter name| Type|Description|
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |

#### 2.4.3.3 Output parameter description ####

| Parameter name| Description|
| ------------- |:-----|
| ret|Return code  0: correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| GiftPackList|vector<GiftPackInfo> type|
	struct GiftPackInfo
	{
	  string     giftId;                 //gift bag id
	  string     giftCount;              //Number of gift bags
	};


#### 2.4.3.4   Interface call description ####
| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_gift/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

#### 2.4.3.5  Request example ####

	POST http://msdktest.qq.com/profile/get_gift/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "openid": "F4382318AFBBD94F856E866043C3472E"
	}
	//return result
	{
	    "GiftPackList": [
	        {
	            "giftCount": "1",
	            "giftId": "1001"
	        }
	    ],
	    "msdkExtInfo": "testhunter",
	    "msg": "success",
	    "ret": 0
	}

### 2.4.4 /profile/get_wifi ###

#### 2.4.4.1 Interface specification####
　　　Get portable wifi qualification
#### 2.4.4.2 Input parameter description ####

| Parameter name| Type | Description |
| ------------- |:-------------:|:-----|
| appid|string| The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |

#### 2.4.4.3 Output parameter description ####

| Parameter name| Description|
| ------------- |:-----|
| ret|Return code 0: correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|
| wifiVip|1: wifivip qualification, 0: non-wifivip qualification|

#### 2.4.4.4 Interface call description####

| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/get_wifi/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

#### 2.4.4.5  Request example ####

	POST http://msdktest.qq.com/profile/get_wifi/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    “appid”: “100703379”,
	    “openid”: “A3284A812ECA15269F85AE1C2D94EB37”
	}
	
	//return result
	{
	    “msg”: “success”,
	    “ret”: 0,
	    “wifiVip”: 1
	}

### 2.4.5 /profile/qqscore_batch ###

#### 2.4.5.1 Interface specification####
　　　Report the player’s score to QQ platform; display friends’ score ranking in the QQ Game Center. (Take effect in time; you can use this page to verify if the report is successful: http://youxi.vip.qq.com/act/201502/Gamecheck.html)

#### 2.4.5.2 Input parameter description ####


| Parameter name| Type|Description|
| ------------- |:-------------:|:-----|
| appid|string|The exclusive id of an app in the platform |
| openid|string|The unique identifier of the user in an app |
| accessToken|string|The third party’s access token, which is gotten through the token acquisition interface |
| Param|Vector <ReportParam>|ReportParam structure is shown below `For detailed data types, refer to the reporting data type description as shown in 2.4.4.6` <br> 1. data: score value <br> 2. expires: timeout, unix timestamp. unit s, indicating which time-point data expire, 0 marks that data never expire, passing null means 0 by default <br> 3. bcover: 1 indicates overridden reporting, that is this report can overwrite the previous data; passing null or passing other values represents incremental reporting, which can only record data higher than the previous data <br> 4. about bcover, data relating to the ranking chart bcover = 0, others bcover = 1. The Game Center’s ranking chart keeps consistent with the game ranking chart.|
	
	struct ReportParam
	{
	    0   optional     int             type;    
	    1   optional     string          data;    
	    2   optional     string          expires; 
	    3   optional     int             bcover;  
	};
*** (Please notice the type of the input parameter. Refer to 1.5)***

#### 2.4.5.3 Output parameter description ####

| Parameter name| Description|
| ------------- |:-----|
| ret|Return code 0: correct  Others: failure |
| msg|If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5|

#### 2.4.5.4   Interface call description####

| Parameter name| Description|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/qqscore_batch/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

#### 2.4.5.5  Request example ####
POST http://msdktest.qq.com/profile/qqscore_batch/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "accessToken": "E16A9965C446956D89303747C632C27B",
	    "openid": "F4382318AFBBD94F856E866043C3472E",
	    "param": [
	        {
	            "type": 3,
	            "bcover": 1,
	            "data": "999",
	            "expires": "123459751"
	        },
	        {
	            "type": 2,
	            "bcover": 1,
	            "data": "1999",
	            "expires": "123459751"
	        }
	    ]
	}
	
	//return result
	{“msg”:”success”,”ret”:0,”type”:0}


#### 2.4.5.6 Reporting data type description (If you have any doubts, please contact: joceyzhou&kyleli&samzou) ####

| type(reporting data type, int)| data(score value, string)| expires(expiration time, string, such as 2015-05-30 23:59:59; if expired, fill in ”1433001599”)| bcover(whether or not it is overridden reporting, int)| remarks`(note: very important)`|
| ------------- |:-------------:|:-----|:-----|:-----|
|1  |Level                                          |  "0"|1|Report when the item changes                                                                |
|2  |Money                                          |  "0"|1|Report when the item changes                                                                |
|3  |Sales income score (data used for the ranking chart)                               |  Consistent with the settlement time of the game|0|Report when the item changes                                                                |
|4  |Experience                                          |  "0"|1|Report when the item changes                                                                |
|5  |Historical highest score                                       |  "0"|1|mobile QQ platform calculates according to 3, do not report                                                       |
|6  |Last week’s settlement ranking chart                                      |  Consistent with the settlement time of the game|1| mobile QQ platform calculates according to 3, do not report                                                       |
|7  |Challenge match reports scores                                     |  Consistent with the settlement time of the game|1|Report when the item changes                                                                |
|8  |The last logon time                                      |  "0"|1|Reporting format: Unix timestamp                                                         |
|9  |Number of past rounds                                         |  "0"|1|mobile QQ platform calculates according to 3, do not report                                                       |
|10 |Number of weekly rounds                                         |  "0"|1|mobile QQ platform calculates according to 3, do not report                                                       |
|11 |Past highest score                                        |  "0"|1|mobile QQ platform calculates according to 3, do not report                                                       |
|12 |Platform type, 1-android, 2-ios                        |  "0"|1|*When reporting other data items, all games must also report this item at the same time                                               |
|13 |Game mode; for its value, refer to the game mode values of various games                          |  "0"|1|*When reporting other data items, multi-mode games must also report this item at the same time                                               |
|14 |Time length of single gaming                                      |  "0"|1|Reporting unit: seconds (accumulative gaming time calculated by mobile QQ platform).                                             |
|15 |This week’s highest score                                       |  "0"|1|mobile QQ platform calculates according to 3, do not report                                                       |
|16 |This week’s ranking                                        |  "0"|1|mobile QQ platform calculates according to 3, do not report                                                       |
|17 |Fighting capacity                                          |  "0"|1|Report when the item changes                                                                |
|18 |Ranking of fighting capacity                                       |  "0"|1|Ranking within the game                                                                |
|19 |Number of passes passed in the past                                       |  "0"|1|Report when the item changes                                                                |
|20 |Number of passes passed in the weak                                       |  "0"|1|Unused temporarily                                                                 |
|21 |Accumulated score                                          |  "0"|1|Report when the item changes                                                                |
|22 |Ranking of accumulated score                                        |  "0"|1|Ranking within the game                                                                |
|23 |Total number of rounds                                         |  "0"|1|Report when the item changes                                                                |
|24 |Total win rate                                         |  "0"|1|Report when the item changes                                                                |
|25 |The user’s registration time                                      |  "0"|1|Previously reported as 3001; need to be changed to 25                                                     |
|26 |Zone info                                        |  "0"|1|*Report zone id; when reporting other data items, the multi-zone and multi-server game must also report this item at the same time                                       |
|27 |Server info                                       |  "0"|1|*Report server ID; when reporting other data items, the multi-zone and multi-server game must also report this item at the same time                                      |
|28 |Role ID                                        |  "0"|1|*When reporting other data items, the multi-zone and multi-server game must also report this item at the same time; multiple roles in the same zone do not need to remove duplication                                |
|29 |Role name                                        |  "0"|1|Report when a role is initially created                                                              |
|30 |Affiliated union id                                      |  "0"|1|*The item must be reported at the same time when reporting union data                                                      |
|31 |Time of joining union                                      |  "0"|1|Report this item when joining the union; reporting format: Unix timestamp                                                   |
|301|Union name                                        |  "0"|1|Report when the item changes                                                                |
|302|Union level (upgrade）                                    |  "0"|1|Report when the item changes                                                                |
|303|The union’s fighting capacity                                        |  "0"|1|Report when the item changes                                                                |
|304|The union’s ranking                                        |  "0"|1|Report when the item changes                                                                |
|305|The union’s honors                                        |  "0"|1|Report when the item changes                                                                |
|306|The union’s founding time                                      |  "0"|1|Report when the union is founded; reporting format: Unix timestamp                                                   |
|307|The union’s dissolving time                                      |  "0"|1|Report when the union is dissolved; reporting format: Unix timestamp                                                   |
|308|Number of union members                                      |  "0"|1|Report when the item changes                                                                |
|309|Change of union members (1-join, 2-quit）                           |  "0"|1|Report when the item changes                                                                |
|310|Union profile                                        |  "0"|1|Report when the item changes                                                                |
|311|Change of union members’ identity (1-president, 2-vice president, 3-member）                   |  "0"|1|加入、Report when the item changes                                                             |
|312|union-bound QQ group                                    |  "0"|1|Binding; report when the item changes                                                             |
|313|QQ group’s binding time                                    |  "0"|1|Binding; report when the item changes                                                             |

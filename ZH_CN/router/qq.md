# 2.手机QQ接口 

## 2.1 Oauth服务 

　实现手机Oauth授权登录相关功能。
### 2.1.1/auth/verify_login 

#### 2.1.1.1接口说明 

　　　验证用户的登录态，判断openkey是否过期，没有过期则对openkey有效期进行续期（一次调用续期2小时）。
url中带上msdkExtInfo=xxx（请求序列号），可以在后回内容中，将msdkExtInfo原数据带回来，即可实现纯异常请求。msdkExtInfo为可选参数。

#### 2.1.1.2输入参数说明 


| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|int| 应用在QQ开放平台中的唯一id |
| openid|string|普通用户唯一标识（QQ平台） |
| openkey|string|授权凭证access_token |
| userip|string|用户客户端ip|


#### 2.1.1.3输出参数说明 

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|


#### 2.1.1.4 接口调用说明 

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/auth/verify_login/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |


#### 2.1.1.5 请求示例 
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

	//返回结果：
	{"ret":0,"msg":"user is logged in"}

2.2 Share服务
---
　提供手机QQ和手机Qzone的定向分享能力。

### 2.2.1 /share/qq ###

#### 2.2.1.1接口说明 ####

点对点定向分享(分享消息给手机QQ好友，在公众账号“QQ手游”中显示)。

***PS：分享的内容只有手机QQ上才可以看到，PCQQ上看不到。接收方需要关注“QQ手游”公众号才能接收到，同一用户同一天收到的同一款游戏能接收的在20条消息左右。***

#### 2.2.1.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|int| 应用在QQ开放平台中的唯一id |
| openid|string|普通用户唯一标识（QQ平台） |
| openkey|string|授权凭证access_token |
| userip|string|用户客户端ip|
|act|int|跳转行为(0: URL跳转；1:APP跳转,默认:0)|
|oauth_consumer_key|int|appid(应用在QQ平台的唯一id)|
|dst|int|msf-手q(包括iphone, android qq等),目前只能填1001|
|flag|int|漫游 (0:是；1:否. 目前只能填1)|
   |image_url|string|分享图片url (图片尺寸规格为128*128；需要保证网址可访问；且图片大小不能超过2M)|
    |openid|string|用户标识|
    |access_token|string|授权凭证|
    |src|int|消息来源 (默认值:0)|
    |summary|string|摘要，长度不超过45字节|
    |target_url|string|游戏中心详情页的URL<br>http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite<br>，长度不超过1024字节|
   |title|string|分享标题,长度不能超过45字节|
    |fopenids|vector<jsonObject>或者json字符串(兼容)|Json数组，数据格式为 [{"openid":"","type":0}]，openid为好友openid，type固定传0 .只支持分享给一个好友|
    |appid|int|应用在QQ平台的唯一id，同上oauth_consumer_key|
	|previewText|string|非必填。分享的文字内容，可为空。如“我在天天连萌”，长度不能超过45字节|
    |game_tag|string|非必填。game_tag	用于平台对分享类型的统计，比如送心分享、超越分享，该值由游戏制定并同步给手Q平台，目前的值有：<br>MSG_INVITE                //邀请<br>MSG_FRIEND_EXCEED       //超越炫耀<br>MSG_HEART_SEND          //送心<br>MSG_SHARE_FRIEND_PVP    //PVP对战</td>
    |
***请注意输入参数的类型，参考1.5***
#### 2.2.1.3输出参数说明 

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|


#### 2.2.1.4 接口调用说明 

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/auth/share/qq/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |


#### 2.2.1.5 请求示例 ####

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
	    "appid": 100703379,
	    "src": 0,
	    "summary": "摘要",
	    "target_url": "http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite
	",
	    "title": "test by hunter",
	    "fopenids": [{"openid":"69FF99F3B17436F2F6621FA158B30549","type":0}],//json数组
	    "previewText": "我在天天连萌游戏"
	}

	//返回结果
	{"ret":0,"msg":"success"}

#### 2.2.1.6 返回码 ####
返回码见返回结果中msg中的参数的第一个逗号前的整数

| 返回码| 描述|
| ------------- |:-----|
| 100000|鉴权错误！uin,skey错误|
| 100001|参错错误！缺少必要参数，或者参数类型不对|
| 100003|服务错误！请联系相关开发人员 |
| 100004|脏词错误！关键字涉黄、涉政等  |
|100100|CGI只能用post方式请求|
|100101|CGI有Referer限制|
|100012|服务超时错误！请联系相关开发人员|
|111111 |未知错误！请联系相关开发人员 |
|99999 | 频率限制错误|
|其他 |后台服务返回错误吗 ！请联系相关开发人员 |


#### 2.2.1.8 分享截图示例 ####
![shareQQ](shareQQ.jpg)


![分享图片](./shareQQ_detail.jpg)


2.3 Relation服务
---
### 2.3.1.1接口说明 ###
　　　获取用户QQ帐号基本信息。
#### 2.3.1.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| accessToken|string|登录态 |
| openid|string|用户在某个应用的唯一标识 |

#### 2.3.1.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| nickName|用户在QQ空间的昵称（和手机QQ昵称是同步的） |
| gender|性别 如果获取不到则默认返回"男"  |
| picture40|大小为40×40像素的QQ头像URL |
| picture100|大小为100×100像素的QQ头像URL，需要注意，不是所有的用户都拥有QQ的100x100的头像，但40x40像素则是一定会有 |
| yellow_vip|是否是黄钻用户，0表示没有黄钻 |
| yellow_vip_level|黄钻等级 |
| yellow_year_vip|是否是年费黄钻用户，0表示否 |
| is_lost|is_lost为1的时候表示获取的数据做了降级处理：此时业务层有缓存数据时，可以先用缓存数据；如果没有的话，再使用当前的数据。并且该标志打上1时，不要对这个数据进行缓存。|

#### 2.3.1.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqprofile/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.1.5 请求示例 ####

	POST /relation/qqprofile/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198

	{
	    "appid": 100703379,
	    "accessToken": "FCCDE5C8CDAD70A9A0E229C367E03178",
	    "openid": "69FF99F3B17436F2F6621FA158B30549"
	}

	//返回结果
	{
	    "ret": 0,
	    "msg": "success",
	    "nickName": "憨特",
	    "gender": "男",
	    "picture40": "http://q.qlogo.cn/qqapp/100703379/A3284A812ECA15269F85AE1C2D94EB37/40",
	    "picture100": "http://q.qlogo.cn/qqapp/100703379/A3284A812ECA15269F85AE1C2D94EB37/100",
	    "yellow_vip": 0,
	    "yellow_vip_level": 0,
	    "yellow_year_vip": 0,
	    "is_lost": "0"
	}

### 2.3.2/relation/qqfriends_detail ###

#### 2.3.2.1接口说明 ####
获取QQ同玩好友详细的个人信息接口
#### 2.3.2.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| accessToken|string|登录态 |
| openid|string|用户在某个应用的唯一标识 |
| flag|int|flag=1时，返回不包含自己在内的好友关系链; flag=2时，返回包含自己在内的好友关系链。其它值无效，使用当前逻辑。|

***（请注意输入参数的类型，参考1.5）***

#### 2.3.2.3输出参数说明 ####
| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| list|QQ同玩好友个人信息列表，类型	`vector<QQGameFriendsList>`|
| is_lost|is_lost为1的时候表示获取的数据做了降级处理：此时业务层有缓存数据时，可以先用缓存数据；如果没有的话，再使用当前的数据。并且该标志打上1时，不要对这个数据进行缓存。|

	struct QQGameFriendsList {
	    string          openid;      //好友的openid
	    string          nickName;   //昵称(优先输出备注，无则输出昵称)
	    string          gender;      //性别，用户未填则默认返回男
		string          figureurl_qq;  //好友QQ头像URL,必须在URL后追加以下参数/40，/100这样可以分别获得不同规格的图片：
	　　40*40(/40)、100*100(/100)
	 };

#### 2.3.2.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqfriends_detail/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.2.5 请求示例 ####
	POST /relation/qqfriends_detail/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa852&openid=F4382318AFBBD94F856E8%2066043C3472E&encode=1
	
	{
	    "appid": “100703379”,
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	　　　"accessToken": "933FE8C9AB9C585D7EABD04373B7155F",
	    "flag": 1
	}
	//返回结果
	{
	    "ret": 0,
	    "msg": "success",
	    "lists": [
	        {
	            "openid": "69FF99F3B17436F2F6621FA158B30549",
	            "nickName": "张鸿",
	            "gender": "男",
	            "figureurl_qq": "http://q.qlogo.cn/qqapp/100703379/69FF99F3B17436F2F6621FA158B30549/"
	        }
	    ],
	    "is_lost": "0"
	}

### 2.3.3/relation/qqstrange_profile ###
#### 2.3.3.1接口说明 ####
获取同玩陌生人（包括好友）个人信息。<br>
***PS：1.此接口目前仅供开发了“附近的人”等功能的游戏使用<br>
2. 即需要先在客户端获取到同玩陌生人openid列表才能调用此接口***


#### 2.3.3.2输入参数说明 ####


| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| accessToken|string|登录态 |
| openid|string|用户在某个应用的唯一标识 |
| vcopenid|vector<string>|需要查询的同玩陌生人（包括好友）的openid列表，如：vcopenid:[“${openid}”,”${openid1}”]|


***（请注意输入参数的类型，参考1.5）***

#### 2.3.3.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| list| QQ同玩陌生人（包括好友）个人信息信息列表，类型vector< QQStrangeList>|
| is_lost | is_lost为1的时候表示获取的数据做了降级处理：此时业务层有缓存数据时，可以先用缓存数据；如果没有的话，再使用当前的数据。并且该标志打上1时，不要对这个数据进行缓存。|
	struct QQStrangeList {
	    string          openid;          //openid
	    string          gender;          //性别 "1"
	    string          nickName;        //昵称
	    string          qzonepicture50;  //用户头像大小为50×50像素的好友QQ空间头像URL
	    string          qqpicture40;     //用户头像大小为40×40像素的好友QQ头像URL
	    string          qqpicture100;    //用户头像大小为100×100像素的好友QQ头像URL
	    string          qqpicture;       //用户头像大小为自适应像素的好友QQ头像URL，必须在URL后追加以下参数/40，/100这样可以分别获得不同规格的图片：40*40(/40)、100*100(/100)
	}; 

#### 2.3.3.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqstrange_profile/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.3.5 请求示例 ####

	POST /relation/qqstrange_profile/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa***&openid=F4382318AFBBD94F856E8%2066043C3472E&encode=1
	
	{
	    "appid": 100732256,
	    "openid": "B9EEA5EE1E99694146AC2700BFE6B88B",
	    "accessToken": "C9A1F622B7B4AAC48D0AF3F73B1A3D83",
	    "vcopenid": [
	        "B9EEA5EE1E99694146AC2700BFE6B88B"
	    ]
	}
	//返回结果
	{
	    "ret": 0,
	    "msg": "success",
	    "lists": [
	        {
	            "openid": "B9EEA5EE1E99694146AC2700BFE6B88B",
	            "gender": "1",
	            "nickName": "/xu゛♥快到碗里来இ",
	            "qzonepicture50": "http://thirdapp1.qlogo.cn/qzopenapp/aff242e95d20fb902bedd93bb1dcd4c01ed5dc2a14b37510a81685c74529ab1e/50",
	            "qqpicture40": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B/40",
	            "qqpicture100": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B/100",
	            "qqpicture": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B"
	        }
	　　　],
	　　　"is_lost": "0"
	}


### 2.3.4 /relation/qqfriends_vip ###

#### 2.3.4.1接口说明 ####
 　批量查询QQ会员信息。

#### 2.3.4.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| fopenids|vector<string>|好友openid列表，每次最多可输入50个|
| flags|string|VIP业务查询标识。目前只支持查询QQ会员信息：qq_vip。后期会支持更多业务的用户VIP信息查询。如果要查询多种VIP业务，通过“,”分隔。如果不输入该值，默认为全部查询|
| userip|string|调用方ip信息|
| pf|string|玩家登录平台，默认openmobile，有openmobile_android/openmobile_ios/openmobile_wp等，该值来自客户端手Q登录返回|

***（请注意输入参数的类型，参考1.5） ***

### 2.3.4.3输出参数说明 ###

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| list|类型：vector<QQFriendsVipInfo>,QQ游戏好友vip信息列表(见下文)|
| is_lost|is_lost为1时表示oidb获取数据超时，建议游戏业务检测到is_lost为1时做降级处理，直接读取缓存数据或默认数据|
	
	struct QQFriendsVipInfo {
	    1   optional     string          openid;          //好友openid
	    2   optional     int             is_qq_vip;       //是否为QQ会员（0：不是； 1：是）
	    3   optional     int             qq_vip_level;    //QQ会员等级（如果是QQ会员才返回此字段）
	    4   optional     int             is_qq_year_vip;  //是否为年费QQ会员（0：不是； 1：是）
	};

#### 2.3.4.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqfriends_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.4.5 请求示例 ####

	POST /relation/qqfriends_vip/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "appid": "100703379",
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	    "accessToken": "964EE8FACFA24AE88AEEEEBD84028E19",
	    "fopenids": [
	        "69FF99F3B17436F2F6621FA158B30549"
	    ],
	    "flags": "qq_vip",
	    "pf": "openmobile",
	    "userip": "127.0.0.1"
	}
	//返回结果
	{
	    "is_lost": "0",
	    "lists": [
	        {
	            "is_qq_vip": 1,
	            "is_qq_year_vip": 1,
	            "openid": "69FF99F3B17436F2F6621FA158B30549",
	            "qq_vip_level": 6
	        }
	    ],
	    "msg": "success",
	    "ret": 0
	}


### 2.3.5 /relation/get_groupopenid ###

#### 2.3.4.1接口说明 ####
 　获取QQ公会绑群相关信息

#### 2.3.4.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| opt|string|功能选项；传0或者不传（兼容之前的调用情况）：使用公会id和区id换取groupOpenid；opt为1时：即使用QQ群号换取group_openid|
| unionid|string|跟groupOpenid绑定的游戏公会ID，opt不传或者opt=0时必须要|
| zoneid|string|游戏大区值，将公会ID与QQ群绑定时，传入参数“zoneid”的值。|
| groupCode|string|QQ群的原始号码|

***（请注意输入参数的类型，参考1.5） ***

### 2.3.4.3输出参数说明 ###

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|
| groupOpenid|和游戏公会ID绑定的QQ群的groupOpenid，获取群成员信息、解绑群的时候作为输入参数|

#### 2.3.4.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_groupopenid/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.4.5 请求示例 ####

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
	//返回结果
	{
		"is_lost":"0",
		"groupOpenid":"xxxx",
	    "msg": "success",
	    "ret": 0
	}



### 2.3.5 /relation/get_groupinfo ###

#### 2.3.5.1接口说明 ####
 　QQ获取游戏公会绑定QQ群基本信息

#### 2.3.5.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| groupOpenid|string|和游戏公会ID绑定的QQ群的groupOpenid|


***（请注意输入参数的类型，参考1.5） ***

### 2.3.5.3输出参数说明 ###

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|
| groupName|群名称|
| fingerMemo|群的相关简介|
| memberNum|群成员数|
| maxNum|该群可容纳的最多成员数|
| ownerOpenid|群主openid|
| unionid|与该QQ群绑定的公会ID|
| zoneid|大区ID|
| adminOpenids|管理员openid。如果管理员有多个的话，用“,”隔开，例如:0000000000000000000000002329FBEF,0000000000000000000000002329FAFF|


#### 2.3.5.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_groupinfo/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.5.5 请求示例 ####

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
	//返回结果
	{
		"is_lost":"0",
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


### 2.3.6 /relation/unbind_group ###

#### 2.3.6.1接口说明 ####
 　QQ游戏公会解绑QQ群息

#### 2.3.6.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| groupOpenid|string|和游戏公会ID绑定的QQ群的groupOpenid|
| unionid|string|与该groupOpenid绑定的公会ID|


***（请注意输入参数的类型，参考1.5） ***

### 2.3.6.3输出参数说明 ###

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|


#### 2.3.6.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/unbind_group/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.6.5 请求示例 ####

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
	//返回结果
	{
		"is_lost":"0",
	    "msg": "success",
	    "ret": 0
	}





##  2.4.profile服务  ##

　　提供查询QQ账号VIP信息服务。

### 2.4.1 /profile/load_vip ###
  获取QQ账号VIP信息。

#### 2.4.1.2输入参数说明 ####

| 参数名称 | 类型|描述|
| ------------- |:-------------:|:-----|
| appid|int| 应用在平台的唯一id |
| login|login|登录类型，默认填2 |
| uin|int|用户标识,如使用openid帐号体系则默认填0 |
| openid|string|用户在某个应用的唯一标识|
| vip|int|查询类型:(1会员；4蓝钻；8红钻；16超级会员;32游戏会员；64心悦；128黄钻；以上可任意组合，<br>如需同时查询会员和蓝钻则输入5，如需同时查询蓝钻和红钻则输入12，如果三种都要查询则输入13).|
***（请注意输入参数的类型，参考1.5） ***

#### 2.4.1.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| list|信息列表vector<VIP> 类型（见下文），获取超级会员的时候，struct VIP中，只有isvip和flag参数有效.|
	
	struct VIP {
	　　VIPFlag :flag; //什么类型VIP
	　　int isvip; //是否VIP(判断用户VIP状态的唯一标识，0否，1是)
	　　int year; //是否年费(0否，1是)
	　　int level; //VIP等级(0否，1是)
	　　int luxury; //是否豪华版(0否，1是)
	　　int ispay;//是否是游戏会员,仅当查询游戏会员的时候有效
	　　int qqLevel;//QQ皇冠、太阳、月亮、星星的那个等级，只对VIP_NORMAL有效
	};
	enum VIPFlag
	{
	　　VIP_NORMAL(会员) = 1
	　　VIP_BLUE（蓝钻） = 4,
	　　VIP_RED （红钻）= 8,
	　　VIP_SUPER (超级会员)= 16,
	　　VIP_GAME(游戏会员)=32,
	　　VIP_XINYUE = 64,  //心悦俱乐部特权会员，该标志位请求时只有isvip及level有效
	　　VIP_YELLOW = 128, //黄钻会员，level字段无效，其它有效
	};

#### 2.4.1.4 接口调用说明 ####
| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/load_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.4.1.5 请求示例 ####

	POST /profile/load_vip/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	{
	    "appid": 100703379,
	    "login": 2,
	    "uin": 0,
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	    "vip": 13
	}
	//返回格式
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

### 2.4.2 /profile/get_gift ###

#### 2.4.2.1接口说明 ####
　　　领取蓝钻礼包，调用一次过后就清空了礼包。

#### 2.4.2.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |

#### 2.4.2.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| GiftPackList|vector<GiftPackInfo> 类型|
	struct GiftPackInfo
	{
	  string     giftId;                 //礼包id
	  string     giftCount;              //对应礼包个数
	};


#### 2.4.2.4 接口调用说明 ####
| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_gift/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.4.2.5 请求示例 ####

	POST http://msdktest.qq.com/profile/get_gift/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "openid": "F4382318AFBBD94F856E866043C3472E"
	}
	//返回结果
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

### 2.4.3 /profile/get_wifi ###

#### 2.4.3.1接口说明 ####
　　　获取随身wifi的资格。
#### 2.4.3.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |

#### 2.4.3.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| wifiVip|1:表示是wifivip资格，0:表示非wifivip资格|

#### 2.4.3.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/get_wifi/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.4.3.5 请求示例 ####

	POST http://msdktest.qq.com/profile/get_wifi/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37"
	}
	
	//返回结果
	{
	    "msg": "success",
	    "ret": 0,
	    "wifiVip": 1
	}

### 2.4.4 /profile/qqscore_batch ###

#### 2.4.4.1接口说明 ####
　　　上报玩家成就到QQ平台，在QQ游戏中心显示好友分数排行。（实时生效）

#### 2.4.4.2输入参数说明 ####


| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|第三方调用凭证，通过获取凭证接口获得 |
| param|Vector<ReportParam>|ReportParam结构体见下文。<br>type:1:LEVEL（等级），2:MONEY（金钱）, 3:SCORE（得分）, 4:EXP（经验）, 5:HST_SCORE(历史最高分)，<br>6:PRE_WEEK_FINAL_RANK(上周数据结算排名,注意结算数据应该在下次结算前过期，否则拉取到过期数据)， <br>7：CHALLENGE_SCORE（pk流水数据，登录时不报，每一局都报） 传对应数字,一一对应，千万不要传错<br> data:成就值<br>expireds:超时时间，unix时间戳，单位s，表示哪个时间点数据过期，0时标识永不超时，不传递则默认为0<br>bcover:1表示覆盖上报，本次上报会覆盖以前的数据，不传递或者传递其它值表示增量上报，只会记录比上一次更高的数据 |
	
	struct ReportParam
	{
	    0   optional     int             type;    
	    1   optional     string          data;    
	    2   optional     string          expires; 
	    3   optional     int             bcover;  
	};
***（请注意输入参数的类型，参考1.5）***

#### 2.4.4.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|

#### 2.4.4.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqscore_batch/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

### 2.4.4.5 请求示例 ###

	POST http://msdktest.qq.com/profile/qqscore_batch/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "accessToken": "E16A9965C446956D89303747C632C27B",
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
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
	
	//返回结果
	{"msg":"success","ret":0,"type":0}


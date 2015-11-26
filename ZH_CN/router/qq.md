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

***PS：分享的内容只有手机QQ上才可以看到，PCQQ上看不到。接收方需要关注“QQ手游”公众号才能接收到，同一用户同一天收到的同一款游戏能接收的在20条消息左右。整个消息体大小控制在700byte内。***

#### 2.2.1.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| openid|string|普通用户唯一标识（QQ平台） |
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
|target_url|string|游戏中心详情页的URL<br>http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite<br>，长度不超过512字节|
|title|string|分享标题,长度不能超过45字节|
|fopenids|vector<jsonObject>或者json字符串(兼容)|Json数组，数据格式为 [{"openid":"","type":0}]，openid为好友openid，type固定传0 .只支持分享给一个好友|
|previewText|string|不需要填写|
|game_tag|string|非必填。game_tag	用于平台对分享类型的统计，比如送心分享、超越分享，该值由游戏制定并同步给手Q平台，目前的值有：<br>MSG_INVITE                //邀请<br>MSG_FRIEND_EXCEED       //超越炫耀<br>MSG_HEART_SEND          //送心<br>MSG_SHARE_FRIEND_PVP    //PVP对战</td>|
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


##2.3 Relation服务##
---
### 2.3.1/relation/qqprofile ###
#### 2.3.1.1接口说明 ####
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
 　批量查询QQ会员信息（好友非好友均支持）。

#### 2.3.4.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| fopenids|vector<string>|待查询openid列表，`每次最多可输入50个`|
| flags|string|VIP业务查询标识。目前支持查询QQ会员信息:qq_vip,QQ超级会员：qq_svip。后期会支持更多业务的用户VIP信息查询。如果要查询多种VIP业务，通过“,”分隔。|
| userip|string|调用方ip信息|
| pf|string|玩家登录平台，默认openmobile，有openmobile_android/openmobile_ios/openmobile_wp等，该值来自客户端手Q登录返回|

***（请注意输入参数的类型，参考1.5） ***

#### 2.3.4.3输出参数说明 ####

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
		5   optional     int             is_qq_svip;      //是否为QQ超级会员（0：不是； 1：是）
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
	    "flags": "qq_vip,qq_svip",
	    "pf": "openmobile_android",
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
	            "qq_vip_level": 6,
				"is_qq_svip": 1
	        }
	    ],
	    "msg": "success",
	    "ret": 0
	}


### 2.3.5 /relation/get_groupopenid ###

#### 2.3.5.1接口说明 ####
 　获取QQ公会绑群相关信息

#### 2.3.5.2输入参数说明 ####

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

#### 2.3.5.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|
| groupOpenid|和游戏公会ID绑定的QQ群的groupOpenid，获取群成员信息、解绑群的时候作为输入参数|
| platCode|平台错误码,当ret非0时关注|

#### 2.3.5.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_groupopenid/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.5.5 请求示例 ####

	POST /relation/get_groupopenid/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
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
		"platCode":"0",
		"groupOpenid":"xxxx",
	    "msg": "success",
	    "ret": 0
	}

#### 2.3.5.6 错误返（platCode）回码说明 ####
| 错误码| 含义说明 |
| ------------- |:-----|
|2001 	|参数错误。|
|2002 	|没有绑定记录，请检查传入的公会ID和分区ID是否正确。|
|2003 	|输入的openid不是群成员，需要群成员才能查看到group_openid。|
|2004 	|该群与appid没有绑定关系。|
|2010 	|系统错误，请通过企业QQ联系技术支持，调查问题原因并获得解决方案。| 


### 2.3.6 /relation/get_groupinfo ###

#### 2.3.6.1接口说明 ####
 　QQ获取游戏公会绑定QQ群基本信息

#### 2.3.6.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| groupOpenid|string|和游戏公会ID绑定的QQ群的groupOpenid,该参数从/relation/get_groupopenid接口输出参数获取|


***（请注意输入参数的类型，参考1.5） ***

#### 2.3.6.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| platCode|平台错误码,当ret非0时关注|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|
| groupName|群名称|
| fingerMemo|群的相关简介|
| memberNum|群成员数|
| maxNum|该群可容纳的最多成员数|
| ownerOpenid|群主openid|
| unionid|与该QQ群绑定的公会ID|
| zoneid|大区ID|
| adminOpenids|管理员openid。如果管理员有多个的话，用“,”隔开，例如:0000000000000000000000002329FBEF,0000000000000000000000002329FAFF|


#### 2.3.6.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_groupinfo/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.6.5 请求示例 ####

	POST /relation/get_groupinfo/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
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

#### 2.3.6.6 错误返（platCode）回码说明 ####
| 错误码| 含义说明 |
| ------------- |:-----|
|2001 	|参数错误。 |
|2002 	|该群openid没有绑定记录。  |
|2003 	|需要群成员才能查看。 |
|2006 	|该群openid和应用验证对应关系失败。  |
|2007 	|该群已被解散或者不存在。|
|2100	|系统错误，请通过企业QQ联系技术支持，调查问题原因并获得解决方案。|  


### 2.3.7 /relation/unbind_group ###

#### 2.3.7.1接口说明 ####
 　QQ游戏公会解绑QQ群息

#### 2.3.7.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| groupOpenid|string|和游戏公会ID绑定的QQ群的groupOpenid|
| unionid|string|与该groupOpenid绑定的公会ID|


***（请注意输入参数的类型，参考1.5） ***

#### 2.3.7.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|
| platCode|平台错误码,当ret非0时关注|


#### 2.3.7.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/unbind_group/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.7.5 请求示例 ####

	POST /relation/unbind_group/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
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
		"platCode":"0",
	    "msg": "success",
	    "ret": 0
	}

#### 2.3.7.6 错误返（platCode）回码说明 ####
| 错误码| 含义说明 |
| ------------- |:-----|
|2001 	|查不到该QQ群openid的绑定记录。 |
|2002 	|验证QQ群openid和appid或者公会id的对应关系失败。 |
|2003 	|验证登录态失败。|
|2004 	|操作过于频繁，请稍后再解绑qq群。 |
|2006 	|参数错误。|
|2007-2010 	|系统错误，请通过企业QQ联系技术支持，调查问题原因并获得解决方案。|  

### 2.3.8 /relation/get_group_detail ###

#### 2.3.8.1接口说明 ####
 　QQ游戏公会绑群详细信息接口

#### 2.3.8.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| opt|string|功能选项；传0或者不传（兼容之前的调用情况）：使用公会id和区id换取groupOpenid；opt为1时：即使用QQ群号换取groupOpenid|
| unionid|string|跟groupOpenid绑定的游戏公会ID，opt不传或者opt=0时必须要|
| zoneid|string|游戏大区值，将公会ID与QQ群绑定时，传入参数“zoneid”的值|
| groupCode|string|QQ群的原始号码|


***（请注意输入参数的类型，参考1.5） ***

#### 2.3.8.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|
| platCode|平台错误码,当ret非0时关注|
| groupName|群名称|
| fingerMemo|群的相关简介|
| memberNum|群成员数|
| maxNum|该群可容纳的最多成员数|
| ownerOpenid|群主openid|
| unionid|与该QQ群绑定的公会ID|
| zoneid|大区ID|
| adminOpenids|管理员openid。如果管理员有多个的话，用“,”隔开，例如0000000000000000000000002329FBEF,0000000000000000000000002329FAFF|
| groupOpenid|和游戏公会ID绑定的QQ群的groupOpenid|
| joinGroupKey|加群用的group_key|


#### 2.3.8.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_group_detail |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.8.5 请求示例 ####

	POST /relation/get_group_detail?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
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
	//返回结果
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

#### 2.3.8.6 错误返（platCode）回码说明 ####
| 错误码| 含义说明 |
| ------------- |:-----|
|2001 	|参数错误。|
|2002 	|没有绑定记录，请检查传入的公会ID和分区ID是否正确。|
|2003 	|输入的openid不是群成员，需要群成员才能查看到group_openid。|
|2004 	|该群与appid没有绑定关系。|
|2010 	|系统错误，请通过企业QQ联系技术支持，调查问题原因并获得解决方案。| 

### 2.3.9 /relation/get_group_key ###

#### 2.3.9.1接口说明 ####
 　QQ游戏公会获取加群用的groupKey接口（目前只针对android）

#### 2.3.9.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|用户在应用中的登录凭据 |
| groupOpenid|string|和游戏公会ID绑定的QQ群的groupOpenid，来自于公会会长绑群时获得|


***（请注意输入参数的类型，参考1.5） ***

#### 2.3.9.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |: -----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|
| platCode|平台错误码,当ret非0时关注|
| joinGroupKey|公会成员加群用的groupKey|



#### 2.3.9.4 接口调用说明 ####


| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_group_key |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.9.5 请求示例 ####

	POST /relation/get_group_key?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
    "appid": "1000000688",
    "openid": "ECF664F0127DAB4004821795B40797F6",
    "accessToken": "A3296A00BA6E44EF739CC2EE52D35F52",
    "groupOpenid": "4944D5C58AF654020B010465AC945E76",
	}

	//返回结果
	{
		"ret": 0,
	    "msg": "success",
		"is_lost": "0",
		"joinGroupKey":"ggpas1lMAu9rDASaEXf2be1DYiw0o27I",
	    "platCode": "0"
	}



### 2.3.10 /relation/get_vip_rich_info ###

#### 2.3.10.1接口说明 ####
　　　查询手Q会员详细信息（充值时间&到期时间）

#### 2.3.10.2输入参数说明 ####


| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|第三方调用凭证，通过获取凭证接口获得 |


***（请注意输入参数的类型，参考1.5）***

#### 2.3.10.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| is_lost|判断是否有数据丢失。如果应用不使用cache，不需要关心此参数。0或者不返回：没有数据丢失，可以缓存。1：有部分数据丢失或错误，不要缓存。|
| is_qq_vip|标识是否QQ会员（0：不是； 1：是）|
| qq_vip_start|QQ会员最后一次充值时间，标准时间戳|
| qq_vip_end|QQ会员期限，标准时间戳|
| qq_year_vip_start|QQ年费会员最后一次充值时间，标准时间戳|
| qq_year_vip_end|QQ年费会员期限，标准时间戳|
| qq_svip_start|QQ SVIP最后一次充值时间，标准时间戳|
| qq_svip_end|QQ SVIP期限，标准时间戳|
| is_qq_year_vip|标识是否QQ年费会员（0：不是； 1：是）|
| is_svip|标识是否QQ超级会员（0：不是； 1：是）|


#### 2.3.10.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_vip_rich_info/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.10.5 请求示例 ####

	POST http://msdktest.qq.com/relation/get_vip_rich_info/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "accessToken": "E16A9965C446956D89303747C632C27B",
	    "openid": "F4382318AFBBD94F856E866043C3472E"
	}
	
	//返回结果
	{
	    "is_lost": "0",
	    "is_qq_vip": "0",
	    "msg": "success",
	    "qq_svip_end": "0",
	    "qq_svip_start": "0",
	    "qq_vip_end": "1448817920",
	    "qq_vip_start": "1443461120",
	    "qq_year_vip_end": "0",
	    "qq_year_vip_start": "0",
	    "ret": 0,
		"is_qq_year_vip":"1",
		"is_svip":"1"
	}

### 2.3.11 /relation/qq_gain_chest ###

#### 2.3.11.1接口说明 ####
　　　生成手Q宝箱

#### 2.3.11.2输入参数说明 ####


| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|第三方调用凭证，通过获取凭证接口获得 |
| pf|string|宝箱发送者平台信息 |
| actid|int|活动号（活动上线前由产品提供） |
| num|int|物品的总数量(物品总量应大于人数，保证至少一人有一件物品，如果传入的物品总数小于人数，则物品总数取值等于人数) |
| peoplenum|int|人数 |
| type|int|宝箱类型，填0 |



***（请注意输入参数的类型，参考1.5）***

#### 2.3.11.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| platCode|手Q平台错误码，1001：无登录态或登录态过期；1002：无数据|
| boxid|宝箱id|



#### 2.3.11.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qq_gain_chest/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.3.11.5 请求示例 ####

	POST http://msdktest.qq.com/relation/qq_gain_chest/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "accessToken": "E16A9965C446956D89303747C632C27B**",
	    "openid": "F4382318AFBBD94F856E866043C3472E",
		"pf":"qq_m_qq-0-iap-1001-qq-11043**00-BC7AA8D7DA6**",
		"actid":92,
		"num":5,
		"peoplenum":4,
		"type":0//默认填写0
	}
	
	//返回结果
	{
	  	"ret":0,
		"msg":"",
		"platCode":"",
		"boxid":"xxxx"
	}





##  2.4.profile服务  ##

　　提供查询QQ账号VIP信息服务。

### 2.4.2 /profile/query_vip ###
  获取QQ账号VIP信息(带登录态)。

#### 2.4.2.2输入参数说明 ####

| 参数名称 | 类型|描述|
| ------------- |:-------------:|:-----|
| appid|`string`| 应用在平台的唯一id，`特别注意，类型为string` |
| openid|string|用户在某个应用的唯一标识|
| accessToken|string|`用户登录态（新增参数）`|
| vip|int|查询类型:<br/>会员:vip&0x01 !=0；<br/>QQ等级:vip&0x02 !=0；<br/>蓝钻:vip&0x04 != 0；<br/>红钻:vip&0x08 != 0；<br/>超级会员:vip&0x10 != 0;<br/>心悦:vip&0x40 != 0；<br/>黄钻::vip&0x80 != 0；<br/>动漫::vip&0x100 != 0；<br/>以上可任意组合(逻辑与)，如需同时查询会员和蓝钻则(vip&0x01 !=0) && (vip&0x04 != 0) 为真,(备注：请求时请只填相关的标识位)|
***（请注意输入参数的类型，参考1.5） ***

#### 2.4.2.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节，`错误描述中出现"oidb decode0x5e1 failed, ret:116"表示accessToken过期或openid无效`|
| list|信息列表vector<VIP> 类型（见下文），获取超级会员的时候，struct VIP中，只有isvip和flag参数有效.|
	
	struct VIP {
	　　VIPFlag :flag; //什么类型VIP
	　　int isvip; //是否VIP(判断用户VIP状态的唯一标识，0否，1是)
	　　int year; //是否年费(0否，1是)
	　　int level; //VIP等级
	　　int luxury; //是否豪华版(0否，1是)
	};
	enum VIPFlag
	{
	　　VIP_NORMAL(会员) = 1,
	　　VIP_QQ_LEVEL(QQ等级) = 2,  //QQ等级，只需要关注level参数，其它无效
	　　VIP_BLUE（蓝钻） = 4,
	　　VIP_RED （红钻）= 8, //红钻没有年费会员标识返回
	　　VIP_SUPER (超级会员)= 16,  //QQ超级会员，只有isvip有效
	　　VIP_XINYUE = 64,   //心悦俱乐部特权会员，该标志位请求时只有isvip及level有效
	　　VIP_YELLOW = 128,  //黄钻会员，level字段无效
	    VIP_ANIMIC = 256,  //动漫会员，只有isvip有效
	};

#### 2.4.2.4 接口调用说明 ####
| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/query_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.4.2.5 请求示例 ####

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
	//返回格式
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

#### 2.4.3.1接口说明 ####
　　　领取蓝钻礼包，调用一次过后就清空了礼包。

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
| GiftPackList|vector<GiftPackInfo> 类型|
	struct GiftPackInfo
	{
	  string     giftId;                 //礼包id
	  string     giftCount;              //对应礼包个数
	};


#### 2.4.3.4 接口调用说明 ####
| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_gift/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.4.3.5 请求示例 ####

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

### 2.4.4 /profile/get_wifi ###

#### 2.4.4.1接口说明 ####
　　　获取随身wifi的资格。
#### 2.4.4.2输入参数说明 ####

| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |

#### 2.4.4.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|
| wifiVip|1:表示是wifivip资格，0:表示非wifivip资格|

#### 2.4.4.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/get_wifi/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.4.4.5 请求示例 ####

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

### 2.4.5 /profile/qqscore_batch ###

#### 2.4.5.1接口说明 ####
　　　上报玩家成就到QQ平台，在QQ游戏中心显示好友分数排行。（实时生效，可以通过该页面验证是否成功上报：http://youxi.vip.qq.com/act/201502/Gamecheck.html ）

#### 2.4.5.2输入参数说明 ####


| 参数名称| 类型|描述|
| ------------- |:-------------:|:-----|
| appid|string| 应用在平台的唯一id |
| openid|string|用户在某个应用的唯一标识 |
| accessToken|string|第三方调用凭证，通过获取凭证接口获得，`必须传递有效值，后台进行强校验` |
| param|Vector<ReportParam>|ReportParam结构体见下文。`详细数据类型请参考2.4.4.6上报数据类型说明`<br>1、data:成就值<br>2、expires:超时时间，unix时间戳，单位s，表示哪个时间点数据过期，0时标识永不超时，不传递则默认为0<br>3、bcover:1表示覆盖上报，本次上报会覆盖以前的数据，不传递或者传递其它值表示增量上报，只会记录比上一次更高的数据<br>4、关于bcover，与排行榜有关的数据bcover=0，其他bcover=1。游戏中心排行榜与游戏排行榜保持一致。|
	
	struct ReportParam
	{
	    0   optional     int             type;    
	    1   optional     string          data;    
	    2   optional     string          expires; 
	    3   optional     int             bcover;  
	};
***（请注意输入参数的类型，参考1.5）***

#### 2.4.5.3输出参数说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|

#### 2.4.5.4 接口调用说明 ####

| 参数名称| 描述|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/qqscore_batch/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 2.4.5.5 请求示例 ####

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
	
	//返回结果
	{"msg":"success","ret":0,"type":0}


#### 2.4.5.6上报数据类型说明（有疑问请联系：joceyzhou&kyleli&samzou） ####

| type(上报数据类型，int，若以前直接调用游戏中心接口，该type值不变)| data(成就值，string)| expires(过期时间，string，如2015-05-30 23:59:59过期，则填写"1433001599")| bcover(是否覆盖上报，int)| 备注`(非常重要，请关注)`|
| ------------- |:-------------:|:-----|:-----|:-----|  
|1  |等级                                          |  "0"|1|变化时上报                                                                |
|2  |金钱                                          |  "0"|1|变化时上报                                                                |
|3  |流水得分(用于排行榜数据)                               |  与游戏结算时间一致|0|变化时上报                                                                |
|4  |经验                                          |  "0"|1|变化时上报                                                                |
|5  |历史最高分                                       |  "0"|1|手Q平台依据3计算，不用上报                                                       |
|6  |上周结算排名                                      |  与游戏结算时间一致|1|手Q平台依据3计算，不用上报                                                       |
|7  |挑战赛上报成绩                                     |  与游戏结算时间一致|1|变化时上报                                                                |
|8  |最近登录时间                                      |  "0"|1|上报格式：Unix时间戳                                                         |
|9  |日局数                                         |  "0"|1|手Q平台依据3计算，不用上报                                                       |
|10 |周局数                                         |  "0"|1|手Q平台依据3计算，不用上报                                                       |
|11 |日最高分                                        |  "0"|1|手Q平台依据3计算，不用上报                                                       |
|12 |平台类型，1-android，2-ios                        |  "0"|1|*所有游戏，其他数据项上报时必须同时上报此项                                                |
|13 |游戏模式，取值参考各游戏的游戏模式值                          |  "0"|1|*多模式游戏，其他数据项上报时必须同时上报此项                                               |
|14 |单次游戏时长                                      |  "0"|1|上报单位：秒。（累计游戏时长手Q平台计算）                                                |
|15 |本周最高分                                       |  "0"|1|手Q平台依据3计算，不用上报                                                       |
|16 |本周排名                                        |  "0"|1|手Q平台依据3计算，不用上报                                                       |
|17 |战力                                          |  "0"|1|变化时上报                                                                |
|18 |战斗力排名                                       |  "0"|1|游戏内排名                                                                |
|19 |已闯关卡数                                       |  "0"|1|变化时上报                                                                |
|20 |周闯关卡数                                       |  "0"|1|暂不使用                                                                 |
|21 |积分                                          |  "0"|1|变化时上报                                                                |
|22 |积分排行                                        |  "0"|1|游戏内排名                                                                |
|23 |总局数                                         |  "0"|1|变化时上报                                                                |
|24 |总胜率                                         |  "0"|1|变化时上报                                                                |
|25 |用户注册时间                                      |  "0"|1|以前报成3001，需更改为25                                                      |
|26 |大区信息                                        |  "0"|1|*上报大区ID，多区多服游戏其他数据项上报时，必须同时上报此项                                       |
|27 |服务器信息                                       |  "0"|1|*上报服务器ID，多区多服游戏其他数据项上报时，必须同时上报此项                                      |
|28 |角色ID                                        |  "0"|1|*多区多服游戏，其他数据项上报时，必须同时上报此项，同区多角色不去重                                    |
|29 |角色名称                                        |  "0"|1|创建角色时上报                                                              |
|30 |所属公会ID                                      |  "0"|1|*上报工会相关数据时必须同时上报                                                      |
|31 |加入公会时间                                      |  "0"|1|加入时上报，上报格式：Unix时间戳                                                   |
|301|公会名称                                        |  "0"|1|变化时上报                                                                |
|302|公会等级（升级）                                    |  "0"|1|变化时上报                                                                |
|303|公会战力                                        |  "0"|1|变化时上报                                                                |
|304|公会排名                                        |  "0"|1|变化时上报                                                                |
|305|公会荣誉                                        |  "0"|1|变化时上报                                                                |
|306|公会创建时间                                      |  "0"|1|创建时上报，上报格式：Unix时间戳                                                   |
|307|公会解散时间                                      |  "0"|1|解散时上报，上报格式：Unix时间戳                                                   |
|308|公会成员人数                                      |  "0"|1|变化时上报                                                                |
|309|公会成员变动（1-加入，2-退出）                           |  "0"|1|变化时上报                                                                |
|310|公会简介                                        |  "0"|1|变化时上报                                                                |
|311|公会人员身份变更（1-会长，2-副会长，3-成员）                   |  "0"|1|加入、变化时上报                                                             |
|312|公会绑定的QQ群                                    |  "0"|1|绑定、变化时上报                                                             |
|313|QQ群的绑定时间                                    |  "0"|1|绑定、变化时上报                                                             |
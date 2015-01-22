1.概述
===
1.1 接口调用方式
---
　　　通过http协议，将要接口需要的参数，组装成数组，然后转换成json格式，放在http body中，通过post发送到指定的url中。http 协议的url 必须带有 appid,sig, timestamp,encode opendid等参数。接口中所有的参数都是utf8编码。

接口调用域名：

测试环境 msdktest.qq.com 

正式环境客户端使用 msdk.qq.com

正式环境（内网IDC）的gameSvr访问MSDK域名 msdk.tencent-cloud.net (TGW) 


***游戏正式发布前请务必切换到正式环境的域名***

1.2 接口Url参数说明
---
appid：指游戏在微信或者手Q平台所对应的唯一ID。

timestamp：是指当前的标准时间戳（秒）。

sig：是加密串。由appid对应的appkey,连接上timestamp参数，md5加密而成32位小写的字符串。

sig =  md5 ( appkey + timestamp ) "+"表示两个字符串的连接符，不要将"+"放入md5加密串中

encode：值必须为1（表示http+json格式）,不可缺少。

conn:表示是否启用长连接。注意，只有gameSvr的请求才可以使用conn=1.客户端的请求请不要使用长连接。

msdkExtInfo:表示透传的参数，会在返回的json中带上该透传参数，注意，msdkExtInfo不能带特殊字符，只能由英文字母，数字，下划线组成。

openid:表示用户在应用中的唯一标识。

opua:终端来源信息，由客户端上报给手Q开放平台，例如：AndroidSDK_17_maguro_4.2.2

1.3 如何获取返回结果
---
　　　通过http协议发送数据以后，获取状态码，如果为200，则表示请求正常，即可以获取http返回的内容，将json字符串解析成数组。如果不为200，表示请求失败，直接打印结果查看问题。

1.4 PHP调用示例
---
	<?php
	require_once ‘SnsNetwork.php’;
	$appid = “100703379”;
	$appKey = ”f92212f75cd8d**”;
	$openid = “F4382318AFBBD94F856E8%2066043C3472E”;
	$ts = time();
	//md5 32位小写,例如”111111”的md5是” 96e79218965eb72c92a549dd5a330112”;
	$sig = md5($appKey.$ts);
	$url= “http://msdktest.qq.com/relation/qqfriends_detail/?timestamp=$ts&appid=$appid&
	sig=$sig&openid=$openid&encode=1”;
	$param = array(
		‘appid’=> 100703379,
		‘openid’=>’A3284A812ECA15269F85AE1C2D94EB37’,
		‘accessToken’=>’ 933FE8C9AB9C585D7EABD04373B7155F’
	);
	$result = SnsNetwork:: makeRequest($url,json_encode($param));
	print_r($result);


<a href="SnsNetwork.php.txt" target="_blank">SnsNetwork.php文件下载</a>

1.5 json数据格式说明
---
在每个接口输入参数描述中，都有说明参数的类型。请注意int,string,struct等参数的区别。　如:
   
	   appid的值为int型:{“appid”:369}
	
	　 appid的值为string型：{“appid”:”appid”}
	   
       openid的值为string数组类型：{“openid”:[“openid1”,”openid2”]}

1.6 游客模式
---
游客模式是通过url中的appid和openid来识别的。即在原有的手Q的appid前面加上”G_”即可（注意：个别游戏只接入了微信，则使用微信的appid。例如：G_wx***,注册的时候用哪个appid，则后面调用游客模式接口的时候，就用该appid）。例如：“G_100703379”.游客模式下通常还会访问/auth/guest_check_token鉴权接口。其它的接口访问时，则会报-901的错误 ，表示游客没有权限访问该接口。

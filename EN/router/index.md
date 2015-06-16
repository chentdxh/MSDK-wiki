1. Overview
===
1.1 Calling Interface Method
---
　　　Through the HTTP protocol, the parameters required by the interface are assembled into an array, which is then converted into JSON format, placed in the HTTP body and sent to the specified URL via post. The URL in the HTTP protocol must carry the following parameters: appid, sig, timestamp, encode and opendid. All the parameters in the interface are utf8 coded.

Interface call domain name:

Test environment: msdktest.qq.com
The formal environment for client use: msdk.qq.com
The domain name for gameSvr of the formal environment (intranet IDC) to access MSDK: msdk.tencent-cloud.net (TGW)


*** The domain name must be switched to the formal environment before the game is officially released ***

1.2 Description of parameters in the interface’s Url
---
appid: the corresponding unique ID of the game in WeChat or QQ mobile platform.

timestamp: the current standard timestamp (second).

sig: encrypted string, which is a 32-bit lowercase string which is MD5 encrypted with appid’s corresponding appkey plus timestamp

sig =  md5 ( appkey + timestamp ) "+" indicates the connector for two strings. Don't put '+' into the MD5- encrypted string.

encode: value must be 1 (representing the http+json format); required

conn: whether to enable the long connection? Note: only gameSvr requests can use conn=1. Client requests please do not use the long connection.

msdkExtInfo: transparently transmitted parameter; which is carried in the returned JSON. Note: msdkExtInfo can not bring any special characters and can only be made of letters, figures and underscores.

openid: the only identifier of the user in the application.

opua: terminal-sourced information, which is reported by the client to the QQ mobile open platform, such as: AndroidSDK_17_maguro_4.2.2

1.3 How to get the returned result
---
　　　After data are sent through the HTTP protocol, the status code is obtained. If it is 200, this indicates that the request is normal, that is, the returned content of HTTP can be obtained, and the JSON string is parsed into an array. If it is not 200, this indicates that the request fails. At this time, you can directly print the result to view the problem.

1.4 Calling PHP sample
---
	<?php
	require_once ‘SnsNetwork.php’;
	$appid = “100703379”;
	$appKey = “f92212f75cd8d**”;
	$openid = “F4382318AFBBD94F856E8%2066043C3472E”;
	$ts = time();
	//md5 32-bit lowercase; for example, the md5 value of “111111” is “96e79218965eb72c92a549dd5a330112”;
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


<a href="SnsNetwork.php.txt" target="_blank">download SnsNetwork.php file </a>

1.5 Description of JSON data format
---
The descriptions of each interface’s input parameters all indicate the types of the parameters. Note: pay attention to the distinction between int, string, struct, etc. For example:
   
	   appid’s value is int:{“appid”:369}
	
	　 appid’s value is string: {“appid”:”appid”}
	   
       openid’s value is string array: {“openid”:[“openid1”,”openid2”]}

1.6 Guest mode
---
The guest mode is identified through appid and openid in URL, that is, add “G_” in front of appid of the original mobile QQ (Note: individual games only access WeChat, so they use WeChat’s appid. For example: G_wx***, which appid is used when the game is registered will be used when the guest mode interface is called. For example: "G_100703379" indicates that in the guest mode, the visitor usually also accesses /auth/guest_check_token authentication interface. When other interfaces are accessed, the system will report the “ -901” error, indicating that the visitor does not have the permission to access the interface.
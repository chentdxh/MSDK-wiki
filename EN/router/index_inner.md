1. Overview
===
1.1 Interface call mode
---
　　　Through the HTTP protocol, the parameters required by interfaces are assembled into an array, which is then converted into JSON format, placed in HTTP body and sent to the specified URL via Post. The URL of the HTTP protocol must carry parameters such as appid, sig, timestamp, encode and opendid. All the parameters in the interface are utf8 coded.

Domain names called by the interfaces:

Test environment: 10.194.146.218 msdktest.qq.com

Domain name visited by the client in the formal environment: msdk.qq.com

MSDK domain name visited by gameSvr of the formal environment (intranet IDC): msdk.tencent-cloud.net (TGW)

Stress testing environment: 10.217.143.5:8080


If self-developed or boutique games have joint debugging in the development machine (access to the test environment), they need to open the network strategy of the development machine.
Website: http://web.itil.com/ServiceRequestWeb/IdcRequest/Index.aspx.


*** Before a game is officially released, it must switch to the formal environment’s domain name ***

1.2 Description of interface Url parameters
---
appid: the corresponding.only ID of a game in WeChat or mobile QQ platform

timestamp: the current standard timestamp (second).

sig: encryption string, which is a 32-bit lowercase string formed by merging the corresponding appkey of appid and timestamp and being encrypted with MD5.

$sig =  md5 ($appkey . $timestamp), "." indicates the connector, equivalent to string “+" in C++.

encode：value must be 1 (indicate http+json format); required

conn: indicate whether to enable the long connection. Note: only gameSvr requests can use conn=1. Client requests please do not use the long connection.

msdkExtInfo: represent the transparently transmitted parameter, which is carried in the returned JSON. Note that msdkExtInfo can't bring special characters and can only be made of letters, figures and underscores.

openid: the unique identifier of a user in an application.

1.3 How to get the result returned
---
　　　After you send data via the HTTP protocol and get the status code, if the code is 200, it means that the request is normal, that is the content returned by HTTP can be obtained and the JSON string can be parsed into an array. If it is not 200, it means the request fails, and you can directly print the result to view the problem.

1.4 PHP call example
---
	<?php
	require_once ‘SnsNetwork.php’;
	$appid = “100703379”;
	$appKey = “f92212f75cd8d**”;
	$openid = “F4382318AFBBD94F856E8%2066043C3472E”;
	$ts = time();
	//md5 32-bit lowercase; for example, md5 value of “111111” is “96e79218965eb72c92a549dd5a330112”;
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


<a href="SnsNetwork.php.txt" target="_blank">SnsNetwork.php download the file</a>

1.5 json data format description
---
In the input parameters of each interface, there are descriptions about the types of the parameters. Note the distinction between int, string, struct, etc. For example:
   
	   appid value is int: {“appid”:369}
	
	　 appid value is string: {“appid”:”appid”}
	   
       openid value is string array: {“openid”:[“openid1”,”openid2”]}

1.6 Guest mode
---	
The guest mode is identified by appid and openid in URL, that is, add G_ in front of appid in the original QQ mobile. (Note: individual games only access WeChat, so they use appid of WeChat. For example: G_wx*** means that which appid is used to register the game is used when the guest mode interface is called later. For example, "G_100703379": /auth/guest_check_token authentication interface is usually accessed in the guest mode; when other interfaces are accessed, the “-901” error will be reported, indicating that the visitor does not have the permission to access the interfaces.

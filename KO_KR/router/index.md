1. 개요
===
1.1 인터페이스 호출 방식
---
　　　http 프로토콜을 통해 인터페이스에 필요한 파라미터를 배열로 조합한 후 json 포맷으로 전환시켜 http body에 넣고, 그 다음 post를 통해 지정된 url에 발송합니다. http 프로토콜의 url은 반드시 appid,sig, timestamp,encode opendid 등 파라미터를 망라해야 합니다. 인터페이스에서 모든 파라미터는 utf8 코드입니다.

인터페이스 호출 도메인:

테스트 환경 msdktest.qq.com 

공식 환경 클라이언트는 msdk.qq.com을 사용합니다.

공식 환경（내부전산망 IDC）의 gameSvr는 MSDK도메인 msdk.tencent-cloud.net (TGW)을 방문합니다. 


***공식적으로 게임을 발표하기 전에 공식 환경의 도메인으로 전환하십시오.***

1.2 인터페이스 Url 파라미터에 관한 설명
---
appid：위챗 또는 휴대폰 Q 플랫폼에서 게임과 상응하는 유일한 ID를 말합니다.

timestamp：현재 표준 타임스탬프(초)를 말합니다.

sig：암호화된 스트링을 말합니다. appid과 상응하는 appkey로부터 timestamp 파라미터를 연결하고 md5 암호화를 거쳐 32자리 소문자열을 형성합니다.

sig =  md5 ( appkey + timestamp ) "+"는 2개 문자열의 링크 마크를 뜻합니다. "+"를 md5 암호화된 스트링에 넣지 마십시오.

encode：값은 1（http+json 포맷을 나타냄）이여야 하며 없어서는 안 됩니다.

conn: 긴 연결을 시작할지 여부를 뜻합니다. 주의: gameSvr의 요청만이 conn=1. 을 사용할 수 있습니다. 클라이언트 요청시 긴 연결을 사용하지 마십시오.

msdkExtInfo: 투명적으로 전송한 파라미터를 뜻합니다. 복귀된 json중 투명적으로 전송한 해당 파라미터를 지닙니다. 주의: msdkExtInfo는 특수 문자를 포함해서는 안 되며 영문자, 숫자, 밑줄로만 구성되어야 합니다.

openid: 애플리케이션에서 유저의 유일한 표지를 뜻합니다.

opua:단말 래원 메시지, 클라이언트에서 QQ 오픈 플랫폼에게 보고. 예를 들어：AndroidSDK_17_maguro_4.2.2

1.3 복귀 결과 획득 방법
---
　　　http 프로토콜을 통해 데이터를 발송한 후 상태 코드를 획득합니다. 200일 경우 요청이 정상임을 뜻하며 http 복귀 내용을 획득하여 json 문자열을 배열로 해석할 수 있습니다. 200이 아닐 경우 요청이 실패하였음을 뜻하며 결과를 직접 프린트하여 문제점을 확인합니다.

1.4 PHP호출 예시
---
	<?php
	require_once ‘SnsNetwork.php’;
	$appid = “100703379”;
	$appKey = ”f92212f75cd8d**”;
	$openid = “F4382318AFBBD94F856E8%2066043C3472E”;
	$ts = time();
	//md5 32자리 소문자, 예를 들어 ”111111”의 md5는 ” 96e79218965eb72c92a549dd5a330112”;
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


<a href="SnsNetwork.php.txt" target="_blank">SnsNetwork.php 파일 다운로드</a>

1.5 json 데이터 포맷에 관한 설명
---
각 인터페이스에 입력된 파라미터에 관한 설명 중 파라미터 유형에 관한 설명이 포함되어 있습니다. int,string,struct 등 파라미터의 구별점에 유의하십시오.　예:
   
	   appid의 값은 int형:{“appid”:369}
	
	　 appid의 값은 string형：{“appid”:”appid”}
	   
       openid의 값은 string 배열 유형：{“openid”:[“openid”,”openid”]}

1.6 게스트 모드
---
게스트 모드는 url 중의 appid와 openid로 식별됩니다. 기존 휴대폰 Q의 appid 앞에 ”G_”를 추가하면 됩니다.(주의：개별적인 게임은 위챗만 접속하였으므로 위챗의 appid를 사용합니다. 예를 들어：G_wx***, 가입시 사용한 appid를 이후에 게스트 모드 인터페이스 호출시에도 사용합니다.). 예를 들어：“G_100703379”.게스트 모드에서 흔히 /auth/guest_check_token 인증 인터페이스도 방문합니다. 기타 인터페이스 방문시 -901 오류가 뜨는데 게스트가 해당 인터페이스를 방문할 권한이 없음을 뜻합니다.

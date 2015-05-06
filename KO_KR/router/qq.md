# 2.모바일 QQ 인터페이스 

## 2.1 Oauth서비스 

　모바일 Oauth 권한부여 로그인 관련 기능을 구현하였습니다.
### 2.1.1/auth/verify_login 

#### 2.1.1.1 인터페이스에 관한 설명 

　　　유저의 로그인 상태를 검증하고 openkey의 기간 만료 여부를 판단합니다. 기간이 만료되지 않은 경우에는 openkey 유효기간을 연장합니다 (1회 호출시 2시간 연장됨).
url 중에 msdkExtInfo=xxx（요청 일련번호）를 추가하면 향후 내용에서 msdkExtInfo오리지널 데이터를 가져와 이상 요청을 구현할 수 있습니다.msdkExtInfo는 옵션 파라미터입니다.

#### 2.1.1.2 파라미터 입력에 관한 설명 


| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|int| QQ 오픈 플랫폼에서 게임 유니크ID. |
| openid|string|일반 유저의 유니크ID（QQ플랫폼） |
| openkey|string|권한부여 증거 access_token |
| userip|string|유저 클라이언트 ip|


#### 2.1.1.3 파라미터 출력에 관한 설명 

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|


#### 2.1.1.4 인터페이스 호출에 관한 설명 

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/auth/verify_login/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |


#### 2.1.1.5 요청 예시 
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

	//리턴 결과:
	{"ret":0,"msg":"user is logged in"}

2.2 Share서비스
---
　모바일 QQ 및 모바일 Qzone의 1:1 공유 능력 제공합니다.

### 2.2.1 /share/qq ###

#### 2.2.1.1 인터페이스에 관한 설명 ####

1:1 공유 (메시지를 모바일 QQ 친구와 공유하면 공용계정 “QQ 모바일 게임”에 표시됨).

***PS：공유한 내용은 모바일 QQ에서만 읽을 수 있으며 PCQQ에서는 읽을 수 없습니다. 수신자는 “QQ 모바일 게임” 공용계정을 팔로업하여야만 메시지를 수신할 수 있습니다. 동일한 유저가 동일한 날에 얻은 동일한 게임이 수신할 수 있는 메시지는 20개 정도 됩니다.***

#### 2.2.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|int| QQ 온픈 플랫폼에서 게임의 유니크ID. |
| openid|string|일반 유저의 유니크ID（QQ플랫폼） |
| openkey|string|권한부여 증거 access_token |
| userip|string|유저 클라이언트 ip|
|act|int|건너뛰기 행위(0: URL건너뛰기；1:APP건너뛰기, 디폴트:0)|
|oauth_consumer_key|int|appid(QQ플랫폼에서 게임의 유니크ID)|
|dst|int|msf-모바일 q(iphone, android qq등을 포함), 현재 1001만 입력가능|
|flag|int|로밍 (0:예；1:아니요. 현재 1만 입력가능)|
   |image_url|string|공유 이미지 url(이미지 치수 규격은 128*128임；웹사이트 주소가 방문 가능함을 보장할 수 있어야 함；이미지 크기는 2M을 초과해서는 안 됨)|
    |openid|string|유저 표지|
    |access_token|string|권한부여 증거|
    |src|int|메시지 출처 (디폴트값:0)|
    |summary|string|요약，길이는 45바이트를 초과하지 않음|
    |target_url|string|게임 센터에 관한 자세한 정보 페이지의 URL<br>http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite<br>，길이는 1024바이트를 초과하지 않음|
   |title|string|공유 타이틀, 길이는 45바이트를 초과해서는 안 됨|
    |fopenids|vector<jsonObject> 혹은 json스트링(호환 가능)|Json배열，데이터 포맷은  [{"openid":"","type":0}]，openid는 친구 openid이고，type고정 전송0 . 친구 한 명에게만 공유 가능|
    |appid|int|QQ플랫폼에서 게임의 유니크ID， 위의 oauth_consumer_key와 동등|
	|previewText|string|필수입력 아님공유한 문자 내용은 비어있어도 무방합니다. 예를 들어 “난 지금 2Day’s Match에 있어요”, 길이는 45바이트를 초과하면 안 됩니다.
    |game_tag|string|필수입력 아님.game_tag	플랫폼에서 공유 유형 통계시 적용됩니다. 예를 들어, 하트 보내기 공유, 초월 공유가 있습니다. 해당 값은 게임이 설정한 후 Q 플랫폼과 동기화시킵니다. 현재 값은 ：<br>MSG_INVITE                //초청 <br>MSG_FRIEND_EXCEED       //초월 자랑하기<br>MSG_HEART_SEND          //하트 보내기<br>MSG_SHARE_FRIEND_PVP    //PVP교전</td>
	|
***입력된 파라미터 유형에 대해 주목바라며 1.5를 참조 바랍니다.***
#### 2.2.1.3 파라미터 출력에 관한 설명 

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|


#### 2.2.1.4 인터페이스 호출에 관한 설명 

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/auth/share/qq/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |


#### 2.2.1.5 요청 예시 ####

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
	    "summary": "요약",
	    "target_url": "http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite
	",
	    "title": "test by hunter",
	    "fopenids": [{"openid":"69FF99F3B17436F2F6621FA158B30549","type":0}],//json배열
	    "previewText": "난 2Day’s Match 게임하고 있어요"
	}

	//리턴 결과
	{"ret":0,"msg":"success"}

#### 2.2.1.6 리턴 코드 ####
리턴 코드에 관해서는 리턴 결과 중 msg에 있는 파라미터의 첫번째 콤마 앞의 정수를 참조 바랍니다.

| 리턴 코드| 설명|
| ------------- |:-----|
| 100000|인증 오류！uin,skey오류|
| 100001|파라미터 오류！필요한 파라미터가 부족하거나 파라미터 유형이 맞지 않습니다.|
| 100003|서비스 오류！관련 개발자와 연락 바랍니다. |
| 100004|금칙어 오류！ 키워드에 음란, 정치 등 내용이 포함되어 있습니다. |
|100100|CGI는 post 방식으로만 요청이 가능합니다. |
|100101|CGI는 Referer 제한이 있습니다.|
| 100012|서비스 시간초과 오류！관련 개발자와 연락 바랍니다. |
| 111111|알 수 없는 오류！관련 개발자와 연락 바랍니다. |
|99999 | 빈도 제한 오류|
|기타 |백그라운드 서비스 리턴 오류코드！관련 개발자와 연락 바랍니다. |


#### 2.2.1.8 공유 캡처화면 예시 ####
![shareQQ](shareQQ.jpg)


![공유 이미지](./shareQQ_detail.jpg)


2.3 Relation서비스
---
### 2.3.1.1 인터페이스에 관한 설명 ###
　　　유저 QQ 계정 기본정보를 획득.
#### 2.3.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string| 플랫폼에서 게임의 유니크ID|
| accessToken|string|로그인 상태 |
| openid|string|특정 게임에서 유저의 유니크ID|

#### 2.3.1.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다..|
| nickName| Qzone에서 유저의 닉네임（모바일 QQ 닉네임과 동기화） |
| gender|성별, 획득하지 못한 경우에는 디폴트 상태인 “남자”로 되돌아감  |
| picture40|크기가 40×40픽셀인 QQ 아이콘 URL |
| picture100|크기가 100×100픽셀인 QQ 아이콘 URL. 유의할 점은, 모든 유저가 QQ의 100x100 아이콘을 갖고 있는 것이 아니라는 점입니다. 단, 40x40픽셀은 얼마든지 있습니다. |
| yellow_vip|옐로 다이아몬드 유저인지 여부，0은 옐로 다이아몬드가 없음을 나타냄 |
| yellow_vip_level|옐로 다이아몬드 등급 |
| yellow_year_vip|연간회원 옐로 다이아몬드 유저인지 여부，0은 아님을 뜻함 |
| is_lost|is_lost가 1인 경우 획득한 데이터가 강등 처리를 받았음을 뜻하며, 이러한 경우 게임에서 캐시 데이터가 있으면 우선 캐시 데이터를 사용할 수 있고 캐시 데이터가 없으면 현재 데이터를 사용할 수 있습니다. 또한 해당 내용에 1이 표시되어 있는 경우에는 이 데이터에 대해 캐시 처리를 하지 않습니다.|

#### 2.3.1.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqprofile/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.3.1.5 요청 예시 ####

	POST /relation/qqprofile/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198

	{
	    "appid": 100703379,
	    "accessToken": "FCCDE5C8CDAD70A9A0E229C367E03178",
	    "openid": "69FF99F3B17436F2F6621FA158B30549"
	}

	//리턴 결과
	{
	    "ret": 0,
	    "msg": "success",
	    "nickName": "헌터",
	    "gender": "남자",
	    "picture40": "http://q.qlogo.cn/qqapp/100703379/A3284A812ECA15269F85AE1C2D94EB37/40",
	    "picture100": "http://q.qlogo.cn/qqapp/100703379/A3284A812ECA15269F85AE1C2D94EB37/100",
	    "yellow_vip": 0,
	    "yellow_vip_level": 0,
	    "yellow_year_vip": 0,
	    "is_lost": "0"
	}

### 2.3.2/relation/qqfriends_detail ###

#### 2.3.2.1 인터페이스에 관한 설명 ####
QQ 함께 플레이하는 친구의 자세한 개인정보 인터페이스를 획득.
#### 2.3.2.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string| 플랫폼에서 게임의 유니크ID|
| accessToken|string|로그인 상태 |
| openid|string|특정 게임에서 유저의 유니크ID|
| flag|int|flag=1인 경우 자기를 뺀 친구 관계 링크로 리턴하고, flag=2인 경우 자기를 포함한 친구 관계 링크로 리턴합니다. 기타 값은 무효이며 현재 로직을 사용합니다.|

*** (입력된 파라미터 유형에 대해 주목 바라며 1.5를 참조 바랍니다.) ***

#### 2.3.2.3 파라미터 출력에 관한 설명 ####
| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다..|
| list|QQ 함께 플레이하는 친구의 개인정보 리스트, 유형	`vector<QQGameFriendsList>`|
| is_lost|is_lost가 1인 경우 획득한 데이터가 강등 처리를 받았음을 뜻하며, 이러한 경우 게임에서 캐시 데이터가 있으면 우선 캐시 데이터를 사용할 수 있고 캐시 데이터가 없으면 현재 데이터를 사용할 수 있습니다. 또한 해당 내용에 1이 표시되어 있는 경우에는 이 데이터에 대해 캐시 처리를 하지 않습니다.|

	struct QQGameFriendsList {
	    string          openid;      //친구의 openid
	    string          nickName;   //닉네임(우선 비고를 출력하고, 비고가 없는 경우에는 닉네임을 출력함)
	    string          gender;      //성별，유저가 입력하지 않은 경우에는 디폴트 상태인 “남자”로 리턴함
		string          figureurl_qq;  //친구 QQ아이콘URL을 뜻하며, URL 뒤에 다음의 파라미터 40，/100 를 추가해야만 규격이 다른 이미지를 각각 획득할 수 있습니다.
	　　40*40(/40)、100*100(/100)
	 };

#### 2.3.2.4 인터페이스 호출 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqfriends_detail/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.3.2.5 요청 예시 ####
	POST /relation/qqfriends_detail/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa852&openid=F4382318AFBBD94F856E8%2066043C3472E&encode=1
	
	{
	    "appid": “100703379”,
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37",
	　　　"accessToken": "933FE8C9AB9C585D7EABD04373B7155F",
	    "flag": 1
	}
	//리턴 결과
	{
	    "ret": 0,
	    "msg": "success",
	    "lists": [
	        {
	            "openid": "69FF99F3B17436F2F6621FA158B30549",
	            "nickName": "짱훙(张鸿)",
	            "gender": "남자",
	            "figureurl_qq": "http://q.qlogo.cn/qqapp/100703379/69FF99F3B17436F2F6621FA158B30549/"
	        }
	    ],
	    "is_lost": "0"
	}

### 2.3.3/relation/qqstrange_profile ###
#### 2.3.3.1 인터페이스에 관한 설명 ####
함께 플레이하는 낯선 유저(친구 포함)의 개인정보를 획득함.<br>
***PS：1.이 인터페이스는 현재 “인근 유저” 등 기능을 개발한 게임에만 제공됩니다.<br>
2. 다시 말하면 클라이언트에서 함께 플레이하는 낯선 유저의 opened 리스트를 획득해야만 이 인터페이스를 호출할 수 있습니다.***


#### 2.3.3.2 파라미터 입력에 관한 설명 ####


| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string| 플랫폼에서 게임의 유니크ID|
| accessToken|string|로그인 상태 |
| openid|string|특정 게임에서 유저의 유니크ID|
| vcopenid|vector<string>|검색하고자 하는 함께 플레이 중인 낯선 유저(친구 포함)의 opened 리스트, 예：vcopenid:[“${openid}”,”${openid1}”]|


*** (입력된 파라미터 유형에 대해 주목 바라며 1.5를 참조 바랍니다.) ***

#### 2.3.3.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다..|
| list| QQ를 함께 플레이하는 낯선 유저(친구 포함)의 개인정보 리스트，유형vector< QQStrangeList>|
| is_lost|is_lost가 1인 경우 획득한 데이터가 강등 처리를 받았음을 뜻하며, 이러한 경우 게임에서 캐시 데이터가 있으면 우선 캐시 데이터를 사용할 수 있고 캐시 데이터가 없으면 비로소 현재 데이터를 사용할 수 있습니다. 또한 해당 표지에 1이 표시되어 있는 경우에는 이 데이터에 대해 캐시 처리를 하지 마십시오.|
	struct QQStrangeList {
	    string          openid;          //openid
	    string          gender;          //성별 "1"
	    string          nickName;        //닉네임
	    string          qzonepicture50;  //유저 아이콘 크기가 50×50픽셀인 친구 Qzone 아이콘 URL
	    string          qqpicture40;     //유저 아이콘 크기가 40×40픽셀인 친구 QQ 아이콘 URL
	    string          qqpicture100;     //유저 아이콘 크기가 100×100픽셀인 친구 QQ 아이콘 URL
	    string          qqpicture;       //유저 아이콘 크기가 작아 적응 픽셀인 친구 QQ아이콘 URL; URL 뒤에 다음의 파라미터 /40，/100을 추가해야만 규격이 다른 이미지를 각각 획득할 수 있습니다.40*40(/40), 100*100(/100)
	}; 

#### 2.3.3.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqstrange_profile/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.3.3.5 요청 예시 ####

	POST /relation/qqstrange_profile/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa***&openid=F4382318AFBBD94F856E8%2066043C3472E&encode=1
	
	{
	    "appid": 100732256,
	    "openid": "B9EEA5EE1E99694146AC2700BFE6B88B",
	    "accessToken": "C9A1F622B7B4AAC48D0AF3F73B1A3D83",
	    "vcopenid": [
	        "B9EEA5EE1E99694146AC2700BFE6B88B"
	    ]
	}
	//리턴 결과
	{
	    "ret": 0,
	    "msg": "success",
	    "lists": [
	        {
	            "openid": "B9EEA5EE1E99694146AC2700BFE6B88B",
	            "gender": "1",
	            "nickName": "/xu゛♥얼른 그릇안에 들어와요இ",
	            "qzonepicture50": "http://thirdapp1.qlogo.cn/qzopenapp/aff242e95d20fb902bedd93bb1dcd4c01ed5dc2a14b37510a81685c74529ab1e/50",
	            "qqpicture40": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B/40",
	            "qqpicture100": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B/100",
	            "qqpicture": "http://q.qlogo.cn/qqapp/100732256/B9EEA5EE1E99694146AC2700BFE6B88B"
	        }
	　　　],
	　　　"is_lost": "0"
	}


### 2.3.4 /relation/qqfriends_vip ###

#### 2.3.4.1인터페이스 설명 ####
 　대규모로 QQ회원 정보 조회

#### 2.3.4.2 입력 파라미터 설명 ####

| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 플랫폼에 있는 유니크ID |
| openid|string|유저가 모 앱에 유니크ID |
| accessToken|string|유저가 응용앱에 로그인 토큰 |
| fopenids|vector<string>|친구openid리스트, 한번에 최대 50개 입력 가능|
| flags|string|VIP업무 조회 표지. 현재 QQ회원 정보 조회만 지원 가능：qq_vip. 향후 보다 많은 게임의 유저 VIP정보 조회를 지원할 것입니다. 만약 여러 VIP업무를 조회할 경우,“,”로 구분. 해당 값을 입력하지 않으면 디폴트로 모두 조회|
| userip|string|호출측 ip정보|
| pf|string|유저의 로그인 플랫폼，디폴트로 openmobile，openmobile_android/openmobile_ios/openmobile_wp 등이 있으며 해당 값의 출처는  클라이언트 QQ 로그인 리턴|

***（입력된 파라미터의 타입에 대해 주목 바라며 1.5 참조 바랍니다.） ***

### 2.3.4.3출력 파라미터 설명 ###

| 파라미터명| 설명|
| ------------- |: -----|
| ret|리턴 코드  0：정확，기타：실패 |
| msg|ret비0일 경우,“에러코드，에러 알림”를 표시，상세한 내용은 제5장 확인 바람|
| list|타입：vector<QQFriendsVipInfo>,QQ 게임 친구 vip정보 리스트(다음 내용 확인)|
| is_lost|is_lost가 1일 경우는 oidb데이터 불러오기 시간 초과를 표시. 게임 업무에서 is_lost가 1인 것을 알아냈을 때 강등을 처리하고 직접 캐시 데이터 혹은 디폴트 데이터 읽는 것을 권장합니다.|
	
	struct QQFriendsVipInfo {
	    1   optional     string          openid;          //친구openid
	    2   optional     int             is_qq_vip;       //QQ회원 여부（0：no； 1：yes）
	    3   optional     int             qq_vip_level;    //QQ 회원 등급（QQ일 경우 해당 필드에 리턴）
	    4   optional     int             is_qq_year_vip;  //연간 QQ회원 여부（0：no； 1：yes）
	};

#### 2.3.4.4 인터페이스 호출 설명 ####


| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqfriends_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.3.4.5 요청 예시 ####

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
	//리턴 결과
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

#### 2.3.4.1인터페이스 설명 ####
 　QQ 길드 그룹과 바인딩 관련 정보를 획득

#### 2.3.4.2입력 파라미터 설명 ####

| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 응용프로그램이 플랫폼에 유니크ID |
| openid|string|유저가 모 응용프로그램에 유니크ID |
| accessToken|string|유저가 응용프로에 있는 로그인 증빙 |
| opt|string|기능 옵션；0 전송 혹은 전송하지 않을 경우（호환 전의 호출 상황）：길드id와 월드id로 groupOpenid를 교환；opt가 1일 경우：QQ 그룹 번호로 group_openid를 교환|
| unionid|string|groupOpenid와 바인딩 한 게임 길드ID，opt 전송 안 하거나 opt=0일 경우 꼭 필요|
| zoneid|string|게임 월드값，길드ID를 QQ그굽과 바인딩을 하면， 파라미터“zoneid”의 값을 전송|
| groupCode|string|QQ그룹의 원사 넘버|

***（입력 파라미터의 타입을 주의해야 한다. 1.5참고） ***

### 2.3.4.3출력 파라미터 설명 ###

| 파라미터명| 설명|
| ------------- |: -----|
| ret|리턴 코드  0：정확，기타：실패 |
| msg|ret비0일 경우，“에러 코드，에러 알림”을 표시，자세한 내용은 제5절을 참조 바랍니다.|
| is_lost|분실된 데이터가 있는지를 판단.응용프로그래밍 cache를 사용하지 않을 경우 이 파라미터를 무시해도 됩니다.0 혹은 리턴이 없을 경우,분실된 데이터가 없고 캐시할 수 있습니다.1：일부 데이터가 분실되거나 에러가 있어서 캐시하지 않아야 합니다.|
| groupOpenid|게임 길드ID와 같이 바인딩한 QQ그룹의 groupOpenid，그룹 멘버 정보, 바인딩 해제때 입력 파라미터로 사용.|
| platCode|플랫폼 에러 코드,ret 비0일 경우 주목|

#### 2.3.4.4 인터페이스 호출 설명 ####


| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_groupopenid/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.3.4.5 요청 예시 ####

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
	//리턴 결과
	{
		"is_lost":"0",
		"platCode":"0",
		"groupOpenid":"xxxx",
	    "msg": "success",
	    "ret": 0
	}

#### 2.3.4.6 리턴（platCode）에러 코드 설명 ####
| 에러 코드| 설명 |
| ------------- |:-----|
|2001 	|파라미터 에러|
|2002 	|바인딩 기록이 없어, 전입된 길드ID 및 월드ID 정확 여부를 확인 필요|
|2003 	|입력된 openid가 그룹 멤버가 아니다. 그룹 멤버여야 group_openid볼 수 있음|
|2004 	|해당 그룹은 appid와 바인딩을 하지 않았다|
|2010 	|시스템 에러，회사QQ를 통해 기술 지원을 요청하여 문제 발생한 원인 파악하고 해결방안을 획득.| 


### 2.3.5 /relation/get_groupinfo ###

#### 2.3.5.1인터페이스 설명 ####
 　QQ에서 게임 길드 바인딩한 QQ그룹 기본정보를 획득

#### 2.3.5.2입력 파라미터 설명 ####

| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 응용프로그램이 플랫폼에 있는 유니크ID |
| openid|string|유저가 모 응용프로그램에 유니크ID |
| accessToken|string|유저가 응용프로그램에 있는 로그인 토큰 |
| groupOpenid|string|게임 길드 ID와 바인딩한 QQ그룹의 groupOpenid,해당 파라미터는 /relation/get_groupopenid인터페이스 출력 파라미터에서 획득.|


***（입력 파라미터의 타입에 대해 주목 바라며 1.5 참조 바랍니다.） ***

### 2.3.5.3출력 파라미터 설명 ###

| 파라미터명| 설명|
| ------------- |: -----|
| ret|리턴 코드  0：정확，기타：실패 |
| msg|ret비0일경우，“에러코드, 에러 알림”을 표시，자세한 내용은 5절을 참조 바랍니다.|
| platCode|플랫폼 에러 코드, ret 비0일 경우 주목|
| is_lost|분실된 데이터가 있는지를 판단한다.응용프로그래밍 cache를 사용하지 않을 경우 이 파라미터를 무시해도 된다.0 혹은 리턴이 없을 경우,분실된 데이터가 없고 캐시할 수 있다.1：일부 데이터가 분실되거나 에러가 있어서 캐시하지 않아야 한다|
| groupName|그룹명|
| fingerMemo|그룹에 관련 소개|
| memberNum|그룹 멘버수|
| maxNum|그룹 수용할 수 있는 최대 멘버수|
| ownerOpenid|그룹 리더openid|
| unionid|해당 QQ그룹과 바인딩한 길드 ID|
| zoneid|월드ID|
| adminOpenids|관리원openid. 관리원이 여러명이 있을 경우,“,”로 구분.예를 들어:0000000000000000000000002329FBEF,0000000000000000000000002329FAFF|


#### 2.3.5.4 인터페이스 호출 설명 ####


| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_groupinfo/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.3.5.5 요청 예시 ####

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
	//리턴 결과
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

#### 2.3.5.6 리턴 에러（platCode）코드 설명 ####
| 에러 코드| 설명 |
| ------------- |:-----|
|2001 	|파라미터 설명 |
|2002 	|해당 그룹의 openid에 바인딩 기록이 없다  |
|2003 	|QQ 그룹 멤버여야 조화 가능 |
|2006 	|해당 그룹openid와 응용앱의 대응 관계 검증 실패  |
|2007 	|해당 그룹이 해산되거나 존재하지 않는다|
|2100	|시스템 에러, 회사QQ를 통해 기술 지원 요청하여 문제 파악하고 해결방안을 획득.|  


### 2.3.6 /relation/unbind_group ###

#### 2.3.6.1인터페이스 설명 ####
 　QQ 게임 길드 QQ구룹과의 바인딩을 해제 정보

#### 2.3.6.2입력 파라미터 설명 ####

| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 응용프로그램이 플랫폼에 있는 유니크ID |
| openid|string|유저가 모 응용프로그램에 유니크ID |
| accessToken|string|유저가 응용프로그램에 있는 로그인 증빙 |
| groupOpenid|string|게임 길드 ID와 바인딩한 QQ그룹의groupOpenid|
| unionid|string|해당 groupOpenid와 바인딩한 길드 ID|


***（입력 파라미터의 타입을 주의해야 한다.1.5 참고） ***

### 2.3.6.3출력 파라미터 설명 ###

| 파라미터명| 설명|
| ------------- |: -----|
| ret|리턴코드  0：정확，기타：실패 |
| msg|ret비0일 경우，“에러코드，에레 알림”，상세한 주석은 제5장 내용을 참고|
| is_lost|분실된 데이터가 있는지를 판단한다.응용프로그래밍 cache를 사용하지 않을 경우 이 파라미터를 무시해도 된다.0 혹은 리턴이 없을 경우,분실된 데이터가 없고 캐시할 수 있다.1：일부 데이터가 분실되거나 에러가 있어서 캐시하지 않아야 한다|
| platCode|플랫폼 에러 코드, ret 비0일 경우 주목|


#### 2.3.6.4 파리미터 호출 설명 ####


| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/unbind_group/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.3.6.5 요청 예시 ####

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
	//리턴 결과
	{
		"is_lost":"0",
		"platCode":"0",
	    "msg": "success",
	    "ret": 0
	}

#### 2.3.6.6 리턴（platCode）에러 코드 설명 ####
| 에러 코드| 설명 |
| ------------- |:-----|
|2001 	|해당 QQ그룹openid의 바인딩 기록이 없다|
|2002 	|QQ그룹openid와  appid 혹 길드id간의 대응 관계 검증 실패 |
|2003 	|로그인 상태 검증 실패|
|2004 	|조작 액션이 너무나 빈범하여 잠시 후 qq그룹과의 바인딩 해제를 시도하기 바란다 |
|2006 	|파라미터 에러|
|2007-2010 	|시스템 에러, 회사QQ를 통해 기술 지원 요청하여 문제 파악하고 해결방안을 획득.|  

### 2.3.7 /relation/get_group_detail(연동 테시트에만 적용하며 정식 환경에는 미발포) ###

#### 2.3.7.1인터페이스 설명 ####
 　QQ 게임 길드에 그룹과 바인딩 상세 메시지 인터페이스

#### 2.3.7.2입력 파라미터 설명 ####

| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 응용프로그램이 플랫폼에 있는 유니크ID  |
| openid|string|유저가 모 응용프로그램에 유니크ID |
| accessToken|string|유저가 응용프로그램에 있는 로그인 증빙 |
| opt|string|기능 옵션；0을 기입하거나 기입하지 않을 경우（이전 호출 상황을 호환 가능）：길드id 및 월드id로 groupOpenid획득；opt가 1일 경우：즉 QQ그룹을 사용하여 groupOpenid 획득|
| unionid|string|groupOpenid와 바인딩한 게임 길드ID，opt 기입하지 않거나 opt=0일 경우 반드시 필요|
| zoneid|string|게임 월드 값，길드ID와 QQ그룹 바인딩을 해제할 때，파라미터“zoneid”의 값을 기입한다|
| groupCode|string|QQ그룹의 원시 번호|


***（입력 파라미터의 타입을 주의해야 한다.1.5 참고） ***

### 2.3.7.3출력 파라미터 설명 ###

| 파라미터명| 설명|
| ------------- |: -----|
| ret|리턴 코드  0：정확，기타：실패 |
| msg|ret가 0이 아닐 경우，“에러 코드，에러 알림”를 뜻하며 상세한 설명은 5절 내용 참조|
| is_lost|데이터 분실 여부를 판단.응용프로그램이 cache를 사용하지 않을 경우, 해당 파라미터를 주목할 필요 없다.0 혹은 리턴이 없을 경우：분실한 데이터가 없어, 저장 가능.1：일부 데이터가 분실하거나 에러 발생, 캐시하지 말하야 한다.|
| platCode|플랫폼 에러 코드,ret 0이 아닐 경우 주목|
| groupName|그룹 명칭|
| fingerMemo|그룹에 관련 소개|
| memberNum|그룹 멤버 수|
| maxNum|해당 그룹 용납할 수 있는 최대 멤버 수|
| ownerOpenid|그룹 리더openid|
| unionid|해당 QQ그룹과 바인딩한 길드ID|
| zoneid|월드ID|
| adminOpenids|관리원openid, 관리원이 여러명이 있을 경우 “,”로 구분. 예를 들면,0000000000000000000000002329FBEF,0000000000000000000000002329FAFF|
| groupOpenid|게임 길드ID와 바인딩한 QQ그룹의 groupOpenid|
| joinGroupKey|그룹에 가입시 사용하는 group_key|


#### 2.3.7.4 인터페이스 호출 설명 ####


| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_group_detail |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1&opua=**|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.3.7.5 요청 예시 ####

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
	//리턴 결과
	{
	    "adminOpenids": "",
	    "fingerMemo": "",
	    "groupName": "거시서유 월드35 그룹과 바인딩",
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

#### 2.3.7.6 리턴（platCode）에러 코드 설명 ####
| 에러코드| 설명 |
| ------------- |:-----|
|2001 	|파라미터 에러|
|2002 	|바인딩 기록이 없어 기입한 길드 ID 및 월드ID의 정확성을 확인 필요|
|2003 	|입력된 openid가 그룹멤버가 아니다. 그룹 멤베가 되어야 group_openid를 볼 수 있음|
|2004 	|해당 그룹은 appid와 바인딩을 하지 않았다|
|2010 	|시스템 에러, 회사QQ를 통해 기술 지원 요청하여 문제 파악하고 해결방안을 획득.| 


### 2.3.8 /relation/get_vip_rich_info ###

#### 2.3.8.1인터페이스 설명 ####
　　　QQ 상세 정보 조회（충전 시간&서비스 기간 만료 시간）

#### 2.3.8.2인터페이스 입력 설명 ####


| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 응용프로그램이 플랫폼에 있는 유니크ID |
| openid|string|유저가 모 응용프로그램에 유니크ID |
| accessToken|string|유저가 응용프로그램에 있는 로그인 증빙 |


***（입력 파라미터의 타입을 주의해야 한다.1.5 참고）***

#### 2.3.8.3출력 파라미터 설명 ####

| 파라미터명| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확，기타：실패 |
| msg|ret가 0이 아닐 경우，“에러 코드，에러 알림”를 뜻하며 상세한 설명은 5절 내용 참조|
| is_lost|데이터 분실 여부를 판단.응용프로그램이 cache를 사용하지 않을 경우, 해당 파라미터를 주목할 필요 없다.0 혹은 리턴이 없을 경우：분실한 데이터가 없어, 저장 가능.1：일부 데이터가 분실하거나 에러 발생, 캐시하지 말하야 한다.|
| is_qq_vip|QQ회원 여부를 표지.（0：no； 1：yes）|
| qq_vip_start|QQ회원이 마지막 충전 시간，표준 시간 스템프|
| qq_vip_end|QQ회원 서비스 기간만료 시간，표준 시간 스템프|
| qq_year_vip_start|QQ연간 회원 마지막 충전 시간，표준 시간 스템프|
| qq_year_vip_end|QQ SVIP마지막 충전 시간，미리 남겨준 필드，현재 메시지 무효，표준 시간 스템프|
| qq_svip_end|QQ SVIP기간 만료 시간，미리 남겨준 필드，현재 메시지 무효，표준 시간 스템프|
| is_qq_year_vip|QQ연간 회원 여부를 표지（0：no； 1：yes）|
| is_svip|QQ SVIP 신부 여부를 표지（0：no； 1：yes）|


#### 2.3.8.4 인터페이스 호출 설명 ####

| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_vip_rich_info/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

### 2.3.8.5 요청 예시 ###

	POST http://msdktest.qq.com/relation/get_vip_rich_info/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "accessToken": "E16A9965C446956D89303747C632C27B",
	    "openid": "F4382318AFBBD94F856E866043C3472E"
	}
	
	//리턴 결과
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




	
##  2.4.profile서비스  ##

　　QQ계정 VIP정보 검색 서비스 제공.

### 2.4.1 /profile/load_vip(곧 사용 정지이니 /profile/query_vip인터페이스 사용하기 바란다) ###
  QQ계정 VIP정보 획득.

#### 2.4.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|int| 플랫폼에서 게임의 유니크ID|
| login|int|로그인 유형, 디폴트 상태에서 2를 입력 |
| uin|int|유저 표지, openid 계정 시스템을 사용할 경우 디폴트 상태에서 0을 입력함 |
| openid|string|특정 게임에서 유저의 유니크ID|
| accessToken|string|`유저 로그인 상태（신규 추가한 파라미터）`|
| vip|int|조회 타입:<br\>회원:vip&0x01 !=0；<br/>불루 보석:vip&0x04 != 0；<br/>레드 보석:vip&0x08 != 0；<br/>슈퍼 회원:vip&0x10 != 0;<br/>게임 회원:vip&0x20 != 0；<br/>tencent joy club:vip&0x40 != 0；<br/>옐로 보석::vip&0x80 != 0；<br/>위에 모두 임의로 조합하여 조회될 수 있으며 (로직)，동시에 회원 및 블루 보석 조회필요할 때(vip&0x01 !=0) && (vip&0x04 != 0) 이 맞는 것이다.(비고：요청할 때 관련 표지위를 기입하면 된다.)|
*** (입력된 파라미터 유형에 유의하십시오. 1.5를 참조.) ***

#### 2.4.1.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻한다. 자세한 주석은 제5절을 참조|
| list|정보 리스트vector<VIP> 유형（아래 문장을 참조），슈퍼급 회원 획득시，struct VIP중에서 isvip와 flag 파라미터만 유효함|
	
	struct VIP {
	　　VIPFlag :flag; //어떠한 유형의 VIP
	　　int isvip; //VIP인지 여부(유저 VIP 상태를 판단하는 유니크ID，0 아니요，1 예)
	　　int year; //연간회원인지 여부(0아니요，1예)
	　　int level; //VIP등급
	　　int luxury; //럭셔리 버전인지 여부(0아니요，1예)
	　　int ispay;//게임 회원인지 여부, 게임 회원 검색시에만 유효함.
	　　int qqLevel;//QQ왕관、해、달、별 중 어느 등급, VIP_NORMAL에만 유효함.
	};
	enum VIPFlag
	{
	　　VIP_NORMAL(회원) = 1
	　　VIP_BLUE（블루 다이아몬드） = 4,
	　　VIP_RED （레드 다이아몬드）= 8,
	　　VIP_SUPER (슈퍼급 회원)= 16,
	　　VIP_GAME(게임 회원)=32,
	　　VIP_XINYUE = 64,  //씬웨(心悦) 클럽 특권 회원, 해당 플래그 비트 요청시 isvip 및 level 레벨만 유효함.
	　　VIP_YELLOW = 128, //옐로 다이아몬드 회원，level 필드 무효이고, 기타 유효함.
	};

#### 2.4.1.4 인터페이스 호출에 관한 설명 ####
| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/load_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.4.1.5 요청 예시 ####

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
	//리턴 포맷
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

	
### 2.4.2 /profile/query_vip（현제 연동 테이스할 수 있으며 미발포 상태） ###
  QQ계정의 VIP정보를 획득.(로그인 상태를 가지고 있다)

#### 2.4.2.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름 | 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 게임의 유니크ID|
| openid|string|특정 게임에서 유저의 유니크ID|
| accessToken|string|`유저 로그인 상태（신규 추가한 파라미터）`|
| vip|int|조회 타입:<br/>회원:vip&0x01 !=0；<br/>QQ레벨:vip&0x02 !=0；<br/>블루 보석:vip&0x04 != 0；<br/>레드 보석:vip&0x08 != 0；<br/>슈퍼 회원:vip&0x10 != 0;<br/>tencent joy club:vip&0x40 != 0；<br/>옐로 보석::vip&0x80 != 0；<br/>위에 모두 임의로 조합하여 조회될 수 있으며 (로직)，동시에 회원 및 블루 보석 조회필요할 때(vip&0x01 !=0) && (vip&0x04 != 0)이 맞습니다.(비고：요청할 때 관련 표지위를 기입하면 된다.)|
***（입력된 파라미터 유형에 주목바라며 1.5를 참조 바랍니다.） ***

#### 2.4.2.3 파라미터 출력에 관한 설명 ####

| 파라미터명| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret가 0이 아닐 경우，“에러 코드，에러 알림”를 뜻하며 상세한 설명은 5절 내용 참조|
| list|메시지 리스트vector<VIP> 타입（아래 내용 확인），SUIP 불러올 때，struct VIP중에 isvip 및 flag파라미터만 유효.|
	
	struct VIP {
	　　VIPFlag :flag; //어떤 타입의 VIP
	　　int isvip; //VIP 여부(유저 VIP상태를 판단하는 유니크ID，0 no，1yes)
	　　int year; //연간 VIP 여부(0 no，1yes)
	　　int level; //VIP등급
	　　int luxury; //럭셔리 여부(0 no，1yes)
	};
	enum VIPFlag
	{
	　　VIP_NORMAL(회원) = 1,
      VIP_QQ_LEVEL(QQ등급) = 2,  //QQ등급，level파라미터만 주목하면 되고 기타는 무효
	　　VIP_BLUE（블루 보석） = 4,
	　　VIP_RED （레드 보석）= 8, //레드 보석 서비스에 연간 회원 표지 리턴이 없음
	　　VIP_SUPER (슈퍼 회원)= 16,
	　　VIP_XINYUE = 64,  //tencent joy club 특권 화원, 해당 표지위치 요청할 때는 isvip 및 level만 유효.
	　　VIP_YELLOW = 128,
	};

#### 2.4.2.4 인터페이스 호출 설명 ####
| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/query_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.4.2.5 요청 예시 ####

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
	//리턴 포맷
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

#### 2.4.3.1인터페이스 설명 ####
　　　블루 보석 선물 패키지 수령. 한 번 호출한 후 선물 패키지를 리셋.

#### 2.4.3.2입력 파라미터 설명 ####

| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 응용프로그램이 플랫폼에 있는 유니크ID |
| openid|string|특정 게임에서 유저의 유니크ID |

#### 2.4.3.3출력 파라미터 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|
| GiftPackList|vector<GiftPackInfo> 유형|
	struct GiftPackInfo
	{
	  string     giftId;                 //선물보따리 id
	  string     giftCount;              //상응하는 선물보따리 수
	};


#### 2.4.3.4 인터페이스 호출에 관한 설명 ####
| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_gift/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.4.3.5 요청 예시 ####

	POST http://msdktest.qq.com/profile/get_gift/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "openid": "F4382318AFBBD94F856E866043C3472E"
	}
	//리턴 결과
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

#### 2.4.4.1 인터페이스에 관한 설명 ####
　　　휴대용 wifi 자격 획득.
#### 2.4.4.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 게임의 유니크ID|
| openid|string|특정 게임에서 유저의 유니크ID|

#### 2.4.4.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|
| wifiVip|1: wifivip자격임을 뜻함，0: wifivip 자격이 아님을 뜻함|

#### 2.4.4.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/get_wifi/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.4.4.5 요청 예시 ####

	POST http://msdktest.qq.com/profile/get_wifi/?timestamp=1381288134&appid=100703379&sig=3f308f92212f75cd8d682215cb3fa8**&openid=F4382318AFBBD94F856E866043C3472E&encode=1
	
	{
	    "appid": "100703379",
	    "openid": "A3284A812ECA15269F85AE1C2D94EB37"
	}
	
	//리턴 결과
	{
	    "msg": "success",
	    "ret": 0,
	    "wifiVip": 1
	}

### 2.4.5 /profile/qqscore_batch ###

#### 2.4.5.1 인터페이스에 관한 설명 ####
　　　게이머 실적을 QQ 플랫폼에 전송하고, QQ 게임 센터에 친구 스코어 순위를 표시합니다.(실시간 발효)

#### 2.4.5.2 파라미터 입력에 관한 설명 ####


| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 게임의 유니크ID|
| openid|string|특정 게임에서 유저의 유니크ID|
| accessToken|string|제3자 호출 증거， 증거 인터페이스를 얻는 방식으로 획득 |
| param|Vector<ReportParam>|ReportParam 구조체에 관해서는 아래 내용 참조.`<br>1.data:업적 값<br>2.expires:초과한 시간，unix타임 스템프，단위s，어느 시각에 데이터 기간 만료를 표시.0일 경우 영구 기간 만료가 없는 것을 뜻하며 값을 기입하지 않을 경우 디폴트로 0입니다.<br>3.bcover:1기존 데이터 덮어서 전송，이번 전송은 기존 데이터를 덮을 것이고 값을 기입하지 않거나 기타 값을 기입할 경우 증량 전송을 뜻하여 기존 데이터보다 높은 데이터만 기록합니다.<br>4.bcover에 관련하여 ，랭킹에 관련된 데이터는 bcover=0，기타일 경우 bcover=1. 게임 센터에 랭킹은 게임 랭킹과 일치하여야 합니다.|
	
	struct ReportParam
	{
	    0   optional     int             type;    
	    1   optional     string          data;    
	    2   optional     string          expires; 
	    3   optional     int             bcover;  
	};
*** (입력된 파라미터 유형에 대해 주목 바라며 1.5를 참조 바랍니다.) ***

#### 2.4.5.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|

#### 2.4.5.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/qqscore_batch/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

### 2.4.5.5 요청 예시 ###

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
	
	//리턴 결과
	{"msg":"success","ret":0,"type":0}


#### 2.4.5.6전송 데이터 타입 설명（문의 사항이 있을 경우 joceyzhou&kyleli&samzou와 연락 바람） ####	

| type(전송 데이터 타입，int)| data(성취값，string)| expires(기간 만료 시간，string)| bcover(전송 데이터 덮어쓰기 여부，int)| 비고`(아주 중요, 주목 필요)`|
| ------------- |:-------------:|:-----|:-----|:-----|  
|1  |레벨                                          |  "0"|1|변화시 전송                                                                |
|2  |골드                                          |  "0"|1|변화시 전송                                                                |
|3  |프로우 득점(랭킹 데이터에서 사용)                               |  게임 결산 시간과 일치|0|변화시 전송                                                                |
|4  |경험치                                          |  "0"|1|변화시 전송                                                                |
|5  |역대 최고점                                       |  "0"|1|QQ플랫폼에서 3에 의거하여 결산, 전송할 필요없다                                                       |
|6  |지난주 결산 랭킹                                      |  게임 결산 시간과 일치|1|QQ플랫폼에서 3에 의거하여 결산, 전송할 필요없다                                                       |
|7  |도전전 전송 성적                                     |  게임 결산 시간과 일치|1|변화시 전송                                                                |
|8  |최근 로그인 시간                                      |  "0"|1|전송 포맷：Unix시간 스탬프                                                        |
|9  |일간 라운드 수                                        |  "0"|1|QQ플랫폼에서 3에 의거하여 결산, 전송할 필요없다                                                       |
|10 |주간 라운드 수                                         |  "0"|1|QQ플랫폼에서 3에 의거하여 결산, 전송할 필요없다                                                       |
|11 |일 최고 득점                                        |  "0"|1|QQ플랫폼에서 3에 의거하여 결산, 전송할 필요없다                                                       |
|12 |플랫폼 타입，1-android，2-ios                        |  "0"|1|*모든 게임，기타 데이터 전송할 때 해당 이 데이터도 전송해야 한다                                                |
|13 |게임 모드，값은 각 게임의 게임모드 값을 참고                          |  "0"|1|*멀티 모드 게임，기타 데이터 전송할 때 해당 이 데이터도 전송해야 한다                                               |
|14 |한 라운드 게임 시간                                      |  "0"|1|전송 단위：초.（게임 시간 누적은 QQ플랫폼에서 결산）                                                |
|15 |금주 최고점                                       |  "0"|1|QQ플랫폼에서 3에 의거하여 결산, 전송할 필요없다                                                       |
|16 |금주 랭킹순위                                        |  "0"|1|QQ플랫폼에서 3에 의거하여 결산, 전송할 필요없다                                                       |
|17 |전투력                                          |  "0"|1|변화시 전송                                                                |
|18 |전투력 랭킹순위                                      |  "0"|1|게임내 랭킹                                                               |
|19 |클리어한 스테이지수                                       |  "0"|1|변화시 전송                                                                |
|20 |주간 클리어한 스테이지수                                       |  "0"|1|당분간 사용 안 한다                                                                 |
|21 |포인트                                          |  "0"|1|변화시 전송                                                                |
|22 |포인트 랭킹                                        |  "0"|1|게임내 랭킹                                                                |
|23 |총 라운드수                                         |  "0"|1|변화시 전송                                                                |
|24 |총 승율                                         |  "0"|1|변화시 전송                                                                |
|25 |유저 가입 시간                                      |  "0"|1|예전에는 3001로 전송，25로 수정하여 전송                                                      |
|26 |월드 정보                                        |  "0"|1|*전송 월드ID，월드별 서버별 게임의 기타 데이터 전송할 때, 해당 이 항목의 데이터도 동시에 전송해야 한다                                       |
|27 |서버정보                                      |  "0"|1|*전송 서버ID，월드별 서버별 게임의 기타 데이터 전송할 때, 해당 이 항목의 데이터도 동시에 전송해야 한다                                      |
|28 |캐릭터ID                                        |  "0"|1|*월드별 서버별 게임, 기타 데이터 전송할 때, 해당 이 항목의 데이터도 동시에 전송해야 한다. 통일 월드 멀티 캐릭터에 중복을 여과하지 않는다                                    |
|29 |캐릭터명                                        |  "0"|1|캐릭터 만들 때 전송                                                              |
|30 |소속 길드ID                                      |  "0"|1|*길드 관련 데이터 전송할 때 동시 해당 데이터를 전송해야 한다                                                      |
|31 |길드에 가입 시간                                      |  "0"|1|가입할 때 전송，전송 포맷：Unix시간 스탬프                                                   |
|301|길드명                                        |  "0"|1|변화시 전송                                                                |
|302|길드 레벨（레벨업）                                    |  "0"|1|변화시 전송                                                                |
|303|길드 전투력                                        |  "0"|1|변화시 전송                                                                |
|304|길드랭킹                                        |  "0"|1|변화시 전송                                                                |
|305|길드명예                                        |  "0"|1|변화시 전송                                                                |
|306|길드 구현 시간                                      |  "0"|1|만들 때 전송，전송 포맷：Unix시간 스탬프                                                   |
|307|길드 해산 시간                                      |  "0"|1|해산할 때 전송，전송 포맷：Unix시간 스탬프                                                   |
|308|길드 멘버수                                       |  "0"|1|변화시 전송                                                                |
|309|길드 멘버 변경（1-가입，2-아웃）                           |  "0"|1|변화시 전송                                                            |
|310|길드 소개                                        |  "0"|1|변화시 전송                                                                |
|311|길드 멘버 신분 변경（1-회장，2-부회장，3-회원）                   |  "0"|1|加入、변화시 전송                                                             |
|312|길드 바인딩한 QQ그룹                                    |  "0"|1|바인딩, 변화시 전송                                                             |
|313|QQ그룹 바인딩한 시간                                    |  "0"|1|바인딩, 변화시 전송                                                             |

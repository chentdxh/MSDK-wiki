# 2.휴대폰 QQ 인터페이스 

## 2.1 Oauth서비스 

　휴대폰 Oauth 권한부여 로그인 관련 기능을 구현.
### 2.1.1/auth/verify_login 

#### 2.1.1.1 인터페이스에 관한 설명 

　　　유저의 로그인 상태를 검증하고 openkey의 기간 만료 여부를 판단합니다. 기간이 만료되지 않은 경우에는 openkey 유효기간을 연장합니다 (1회 호출시 2시간 연장됨).
url 중에 msdkExtInfo=xxx（요청 일련번호）를 추가하면 후속 내용에서 msdkExtInfo오리지널 데이터를 가져와 이상 요청을 구현할 수 있습니다.msdkExtInfo는 옵션 파라미터입니다.

#### 2.1.1.2 파라미터 입력에 관한 설명 


| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|int| QQ 오픈 플랫폼에서 애플리케이션의 유일한 id입니다. |
| openid|string|일반 유저의 유일한 표지（QQ플랫폼） |
| openkey|string|권한부여 증거 access_token |
| userip|string|유저 클라이언트 ip|


#### 2.1.1.3 파라미터 출력에 관한 설명 

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|


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

	//복귀 결과:
	{"ret":0,"msg":"user is logged in"}

2.2 Share서비스
---
　휴대폰 QQ 및 휴대폰 Qzone의 지향성 공유 능력 제공.

### 2.2.1 /share/qq ###

#### 2.2.1.1 인터페이스에 관한 설명 ####

점 대 점 지향성 공유 (메시지를 휴대폰 QQ 친구와 공유하면 공중계정 “QQ 모바일 게임”에 표시됨).

***PS：공유한 내용은 휴대폰 QQ에서만 읽을 수 있으며 PCQQ에서는 읽을 수 없습니다. 수신자는 “QQ 모바일 게임” 공중계정에 “관심갖기”를 해야만 메시지를 수신할 수 있습니다. 동일한 유저가 동일한 날에 얻은 동일한 게임이 수신할 수 있는 메시지는 20개 정도 됩니다.***

#### 2.2.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|int| QQ 온픈 플랫폼에서 애플리케이션의 유일한 id입니다. |
| openid|string|일반 유저의 유일한 표지（QQ플랫폼） |
| openkey|string|권한부여 증거 access_token |
| userip|string|유저 클라이언트 ip|
|act|int|건너뛰기 행위(0: URL건너뛰기；1:APP건너뛰기, 디폴트:0)|
|oauth_consumer_key|int|appid(QQ플랫폼에서 애플리케이션의 유일한 id)|
|dst|int|msf-휴대폰 q(iphone, android qq등을 포함), 현재 1001만 입력가능|
|flag|int|로밍 (0:예；1:아니요. 현재 1만 입력가능)|
   |image_url|string|공유 이미지 url(이미지 치수 규격은 128*128임；웹사이트 주소가 방문 가능함을 보장할 수 있어야 함；이미지 크기는 2M을 초과해서는 안 됨)|
    |openid|string|유저 표지|
    |access_token|string|권한부여 증거|
    |src|int|메시지 출처 (디폴트값:0)|
    |summary|string|요약，길이는 45바이트를 초과하지 않음|
    |target_url|string|게임 센터에 관한 자세한 정보 페이지의 URL<br>http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite<br>，길이는 1024바이트를 초과하지 않음|
   |title|string|공유 타이틀, 길이는 45바이트를 초과해서는 안 됨|
    |fopenids|json문자열|Json배열，데이터 포맷은  [{"openid":"","type":0}]，openid는 친구 openid이고，type고정 전송0 . 친구 한 명에게만 공유 가능|
    |appid|int|QQ플랫폼에서 애플리케이션의 유일한 id， 위의 oauth_consumer_key와 동등|
	|previewText|string|필수입력 아님공유한 문자 내용은 비어있어도 무방합니다. 예를 들어 “난 지금 2Day’s Match에 있어요”, 길이는 45바이트를 초과하면 안 됩니다.
    |game_tag|string|필수입력 아님.game_tag	플랫폼에서 공유 유형 통계시 적용됩니다. 예를 들어, 하트 보내기 공유, 초월 공유가 있습니다. 해당 값은 게임이 설정한 후 Q 플랫폼과 동기화시킵니다. 현재 값은 ：<br>MSG_INVITE                //초청 <br>MSG_FRIEND_EXCEED       //초월 자랑하기<br>MSG_HEART_SEND          //하트 보내기<br>MSG_SHARE_FRIEND_PVP    //PVP교전</td>|
***입력된 파라미터 유형에 유의하십시오. 1.5를 참조하십시오.***
#### 2.2.1.3 파라미터 출력에 관한 설명 

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|


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

	//복귀 결과
	{"ret":0,"msg":"success"}

#### 2.2.1.6 복귀 코드 ####
복귀 코드에 관해서는 복귀 결과 중 msg에 있는 파라미터의 첫번째 콤마 앞의 정수를 참조하십시오.

| 복귀 코드| 설명|
| ------------- |:-----|
| 100000|인증 오류！uin,skey오류|
| 100001|파라미터 오류！필요한 파라미터가 부족하거나 파라미터 유형이 맞지 않습니다.|
| 100003|서비스 오류！관련 개발자와 연락을 취하십시오. |
| 100004|외설적인 단어 오류！ 키워드에 음란, 정치 등 내용이 포함되어 있습니다. |
|100100|CGI는 post 방식으로만 요청이 가능합니다. |
|100101|CGI는 Referer 제한이 있습니다.|
| 100012|서비스 시간초과 오류！관련 개발자와 연락을 취하십시오. |
| 111111|알 수 없는 오류！관련 개발자와 연락을 취하십시오. |
|99999 | 빈도 제한 오류|
|기타 |백그라운드 서비스 복귀 오류코드！관련 개발자와 연락을 취하십시오. |


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
| appid|string| 플랫폼에서 애플리케이션의 유일한 id|
| accessToken|string|로그인 상태 |
| openid|string|특정 애플리케이션에서 유저의 유일한 표지|

#### 2.3.1.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|
| nickName| QQ공간에서 유저의 닉네임（휴대폰 QQ 닉네임과 동기화） |
| gender|성별, 획득하지 못한 경우에는 디폴트 상태인 “남자”로 되돌아감  |
| picture40|크기가 40×40픽셀인 QQ 아이콘 URL |
| picture100|크기가 100×100픽셀인 QQ 아이콘 URL. 유의할 점은, 모든 유저가 QQ의 100x100 아이콘을 갖고 있는 것이 아니라는 점입니다. 단, 40x40픽셀은 얼마든지 있습니다. |
| yellow_vip|옐로 다이아몬드 유저인지 여부，0은 옐로 다이아몬드가 없음을 나타냄 |
| yellow_vip_level|옐로 다이아몬드 등급 |
| yellow_year_vip|연간회원 옐로 다이아몬드 유저인지 여부，0은 아님을 뜻함 |
| is_lost|is_lost가 1인 경우 획득한 데이터가 강등 처리를 받았음을 뜻하며, 이러한 경우 업무층에 캐시 데이터가 있으면 우선 캐시 데이터를 사용할 수 있고 캐시 데이터가 없으면 현재 데이터를 사용할 수 있습니다. 또한 해당 표지에 1이 표시되어 있는 경우에는 이 데이터에 대해 캐시 처리를 하지 마십시오.|

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

	//복귀 결과
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
| appid|string| 플랫폼에서 애플리케이션의 유일한 id|
| accessToken|string|로그인 상태 |
| openid|string|특정 애플리케이션에서 유저의 유일한 표지|
| flag|int|flag=1인 경우 자기를 뺀 친구 관계 링크로 복귀하고, flag=2인 경우 자기를 포함한 친구 관계 링크로 복귀합니다. 기타 값은 무효이며 현재 논리를 사용합니다.|

*** (입력된 파라미터 유형에 유의하십시오. 1.5를 참조하십시오.) ***

#### 2.3.2.3 파라미터 출력에 관한 설명 ####
| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|
| list|QQ 함께 플레이하는 친구의 개인정보 리스트, 유형	`vector<QQGameFriendsList>`|
| is_lost|is_lost가 1인 경우 획득한 데이터가 강등 처리를 받았음을 뜻하며, 이러한 경우 업무층에 캐시 데이터가 있으면 우선 캐시 데이터를 사용할 수 있고 캐시 데이터가 없으면 비로소 현재 데이터를 사용할 수 있습니다. 또한 해당 표지에 1이 표시되어 있는 경우에는 이 데이터에 대해 캐시 처리를 하지 마십시오.|

	struct QQGameFriendsList {
	    string          openid;      //친구의 openid
	    string          nickName;   //닉네임(우선 비고를 출력하고, 비고가 없는 경우에는 닉네임을 출력함)
	    string          gender;      //성별，유저가 입력하지 않은 경우에는 디폴트 상태인 “남자”로 복귀함
		string          figureurl_qq;  //친구 QQ아이콘URL을 뜻하며, URL 뒤에 다음의 파라미터 40，/100 를 추가해야만 규격이 다른 이미지를 각각 획득할 수 있음：
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
	//복귀 결과
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
***PS：1.이 인터페이스는 현재 “인근 유저” 등 기능을 개발한 게임에만 제공됨<br>
2. 다시 말하면 클라이언트에서 함께 플레이하는 낯선 유저의 opened 리스트를 획득해야만 이 인터페이스를 호출할 수 있음***


#### 2.3.3.2 파라미터 입력에 관한 설명 ####


| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string| 플랫폼에서 애플리케이션의 유일한 id|
| accessToken|string|로그인 상태 |
| openid|string|특정 애플리케이션에서 유저의 유일한 표지|
| vcopenid|vector<string>|검색하고자 하는 함께 플레이 중인 낯선 유저(친구 포함)의 opened 리스트, 예：vcopenid:[“${openid}”,”${openid1}”]|


*** (입력된 파라미터 유형에 유의하십시오. 1.5를 참조하십시오.) ***

#### 2.3.3.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|
| list| QQ를 함께 플레이하는 낯선 유저(친구 포함)의 개인정보 리스트，유형vector< QQStrangeList>|
| is_lost|is_lost가 1인 경우 획득한 데이터가 강등 처리를 받았음을 뜻하며, 이러한 경우 업무층에 캐시 데이터가 있으면 우선 캐시 데이터를 사용할 수 있고 캐시 데이터가 없으면 비로소 현재 데이터를 사용할 수 있습니다. 또한 해당 표지에 1이 표시되어 있는 경우에는 이 데이터에 대해 캐시 처리를 하지 마십시오.|
	struct QQStrangeList {
	    string          openid;          //openid
	    string          gender;          //성별 "1"
	    string          nickName;        //닉네임
	    string          qzonepicture50;  //유저 아이콘 크기가 50×50픽셀인 친구 QQ공간 아이콘 URL
	    string          qqpicture40;     //유저 아이콘 크기가 40×40픽셀인 친구 QQ 아이콘 URL
	    string          qqpicture100;     //유저 아이콘 크기가 100×100픽셀인 친구 QQ 아이콘 URL
	    string          qqpicture;       //유저 아이콘 크기가 자가 적응 픽셀인 친구 QQ아이콘 URL; URL 뒤에 다음의 파라미터 /40，/100을 추가해야만 규격이 다른 이미지를 각각 획득할 수 있음：40*40(/40), 100*100(/100)
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
	//복귀 결과
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

##  2.4.profile서비스  ##

　　QQ계정 VIP정보 검색 서비스 제공.

### 2.4.1 /profile/load_vip ###
  QQ계정 VIP정보 획득.

#### 2.4.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|int| 플랫폼에서 애플리케이션의 유일한 id|
| login|login|로그인 유형, 디폴트 상태에서 2를 입력 |
| uin|int|유저 표지, openid 계정 시스템을 사용할 경우 디폴트 상태에서 0을 입력함 |
| openid|string|특정 애플리케이션에서 유저의 유일한 표지|
| vip|int|검색 유형: (1회원；4블루 다이아몬드；8레드 다이아몬드；16슈퍼급 회원;32게임 회원；64씬웨(心悦)；128옐로 다이아몬드；위의 회원들은 임의로 조합 가능，<br>회원과 블루 다이아몬드를 동시에 검색할 경우 5를 입력，블루 다이아몬드와 레드 다이아몬드를 동시에 검색할 경우 12를 입력，3가지를 모두 검색할 경우 13을 입력함).|
*** (입력된 파라미터 유형에 유의하십시오. 1.5를 참조하십시오.) ***

#### 2.4.1.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|
| list|정보 리스트vector<VIP> 유형（아래 문장을 참조），슈퍼급 회원 획득시，struct VIP중에서 isvip와 flag 파라미터만 유효함|
	
	struct VIP {
	　　VIPFlag :flag; //어떠한 유형의 VIP
	　　int isvip; //VIP인지 여부(유저 VIP 상태를 판단하는 유일한 표지，0 아니요，1 예)
	　　int year; //연간회원인지 여부(0아니요，1예)
	　　int level; //VIP등급(0아니요，1예)
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
| url|http://msdktest.qq.com/relation/load_vip/ |
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
	    "vip": 13
	}
	//복귀 포맷
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

### 2.4.2 /relation/qqfriends_vip ###

#### 2.4.2.1 인터페이스에 관한 설명 ####
 　QQ 회원 정보 대량 검색.

#### 2.4.2.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 애플리케이션의 유일한 id|
| openid|string|특정 애플리케이션에서 유저의 유일한 표지|
| accessToken|string|애플리케이션에서 유저의 로그인 증거 |
| fopenids|vector<string>|친구 openid 리스트，매회 50개까지 입력 가능|
| flags|string|VIP 업무 검색 표지현재 QQ 회원정보：qq_vip 검색만 지원.향후 다양한 업무의 유저 VIP 정보검색 지원 예정. 다양한 VIP 업무 검색시 “,”로 구분.해당 값을 입력하지 않을 경우 디폴트 상태에서 전부 검색으로 설정됨.|
| userip|string|호출측 ip정보|
| pf|string|게이머 로그인 플랫폼, 디폴트 상태는 openmobile이고, openmobile_android/openmobile_ios/openmobile_wp 등이 있으며，해당 값은 클라이언트 휴대폰 Q 로그인 복귀를 통해 획득|

*** (입력된 파라미터 유형에 유의하십시오. 1.5를 참조하십시오.) ***

### 2.4.2.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |: -----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|
| list|유형：vector<QQFriendsVipInfo>,QQ게임 친구 vip정보 리스트(아래 문장 참조)|
| is_lost|is_lost가 1인 경우 oidb 데이터 획득 시간초과를 뜻함. 게임 업무에서 is_lost가 1임을 검출하는 시점에서 강등 처리를 하여 캐시 데이터 또는 디폴트 데이터를 직접 판독할 것을 권장함.|
	
	struct QQFriendsVipInfo {
	    1   optional     string          openid;          //친구 openid
	    2   optional     int             is_qq_vip;       //QQ 회원인지 여부（0：아니요； 1：예）
	    3   optional     int             qq_vip_level;    //QQ 회원 등급（QQ 회원인 경우에만 이 필드로 복귀됨）
	    4   optional     int             is_qq_year_vip;  //연간 QQ 회원인지 여부（0：아니요； 1：예）
	};

#### 2.4.2.4 인터페이스 호출에 관한 설명 ####


| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqfriends_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 2.4.2.5 요청 예시 ####

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
	//복귀 결과
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

### 2.4.3 /profile/get_gift ###

#### 2.4.3.1 인터페이스에 관한 설명 ####
　　　블루 다이아몬드 선물보따리 획득, 1회 호출 완료 후 선물보따리를 비움.

#### 2.4.3.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 애플리케이션의 유일한 id|
| openid|string|특정 애플리케이션에서 유저의 유일한 표지|

#### 2.4.3.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|
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
	//복귀 결과
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
| appid|string|플랫폼에서 애플리케이션의 유일한 id|
| openid|string|특정 애플리케이션에서 유저의 유일한 표지|

#### 2.4.4.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|
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
	
	//복귀 결과
	{
	    "msg": "success",
	    "ret": 0,
	    "wifiVip": 1
	}

### 2.4.5 /profile/qqscore_batch ###

#### 2.4.5.1 인터페이스에 관한 설명 ####
　　　게이머 실적을 QQ 플랫폼에 보고하고, QQ 게임 센터에 친구 스코어 순위를 표시함.(실시간 발효)

#### 2.4.5.2 파라미터 입력에 관한 설명 ####


| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 애플리케이션의 유일한 id|
| openid|string|특정 애플리케이션에서 유저의 유일한 표지|
| accessToken|string|제3자 호출 증거， 증거 인터페이스를 얻는 방식으로 획득 |
| param|Vector<ReportParam>|ReportParam 구조체에 관해서는 아래 문장 참조.<br>type:1:LEVEL（등급），2:MONEY（금화）, 3:SCORE（스코어）, 4:EXP（경험）, 5:HST_SCORE(역대 최고 스코어)，<br>6:PRE_WEEK_FINAL_RANK(지난 주 데이터 정산 순위, 주의: 정산 데이터는 차기 정산 전에 기간이 만료되어야 하며 그렇지 않을 경우 기간 만료 데이터에 옮겨감)， <br>7：CHALLENGE_SCORE（pk플로우 데이터，로그인시 보고하지 않음，매 라운드마다 보고） 상응하는 숫자를 전달하되, 일대일로 대응하여 잘못 전달하는 일이 없도록 함<br> data:실적값<br>expireds:초과시간，unix타임스탬프，단위s，데이터 기간이 만료되는 시간점을 나타냄; 0인 경우 영구적으로 시간초과 현상이 발생하지 않음을 뜻함，전달하지 않을 경우 디폴트값은 0<br>bcover:1 덮어쓰기 보고를 뜻함. 즉 이번의 보고서가 지난번 데이터를 덮어쓰는 형식. 전달하지 않거나 기타 값을 전달할 경우 증량 보고를 뜻함. 즉 지난번 데이터보다 큰 데이터만 기록됨 |
	
	struct ReportParam
	{
	    0   optional     int             type;    
	    1   optional     string          data;    
	    2   optional     string          expires; 
	    3   optional     int             bcover;  
	};
*** (입력된 파라미터 유형에 유의하십시오. 1.5를 참조하십시오.) ***

#### 2.4.5.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|복귀 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 주석은 제5절을 참조하십시오.|

#### 2.4.5.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/qqscore_batch/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

### 2.4.5.5 요청 예시 ###

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
	
	//복귀 결과
	{"msg":"success","ret":0,"type":0}


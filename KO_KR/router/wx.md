# 3.위챗 인터페이스 #

## 3.1auth서비스 ##

　　위챗 Oauth 권한부여 로그인 관련 기능을 구현하였습니다.

### 3.1.1 /auth/refresh_token ###

#### 3.1.1.1 인터페이스에 관한 설명 ####

　　　access_token의 유효기간이 상대적으로 짧기 때문에(2시간), access_token 시간이 초과된 후 refresh_token을 사용해 리프레시할 수 있습니다. refresh_token의 유효기간은 30일로서 상대적으로 길며，refresh_token이 효력을 잃은 후에는 다시 로그인해야 합니다.<br>
　　　url 중에 msdkExtInfo=xxx（요청 일련번호）를 추가하면 후속 내용에서 msdkExtInfo오리지널 데이터를 가져와 이상 요청을 구현할 수 있습니다.msdkExtInfo는 옵션 파라미터.

#### 3.1.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 게임의 유일한 id|
| refreshToken|string|프론트 사이드 로그인을 통하여 획득한 refreshToken 파라미터를 입력 |

#### 3.1.1.3 파라미터 출력에 관한 설명 ####


| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|
| accessToken|인터페이스 호출 증거|
| expiresIn|accessToken인터페이스 호출 증거 기간 만료 시간, 단위 초 |
| refreshToken|accessToken 리프레시용 |
| openid|일반 유저의 유니크ID（위챗 플랫폼） |
| scope|유저 권한부여의 변수 영역，콤마（,）로 구분, 변수 영역에 관한 자세한 내용은 아래 표를 참조. 변수 영역의 명칭	작용	디폴트 상태<br>snsapi_friend	권한부여시 디폴트 상태는 체크표시를 하지 않음.	권한부여를 통하여 유저의 친구 자료를 획득<br>snsapi_message	권한부여시 디폴트 상태는 체크표시를 하지 않습니다.	권한부여를 통하여 위챗 발송 자격을 획득<br>snsapi_userinfo	권한부여시 디폴트 상태는 체크표시를 함.	권한부여를 통하여 유저 개인 자료를 획득 |

#### 3.1.1.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/auth/refresh_token/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.1.1.5 요청 예시 ####

	POST /auth/refresh_token/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "appid": "wxcde873f99466f74a",
	    "refreshToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJPLafWudG-idTVMbKesBkhBO_ZxFWN4zlXCpCHpYcrXFXf2RE2ETF5F7lhiPkxA9ewAu90r3JLXpM1T4nfr9Iz184ZB0G7br72EfycDenriw"
	}
	
	//리턴 결과
	{
	    "ret": 0,
	    "msg": "success",
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2AnzoP_nZ6CrBdwZ3VEQcqDPNZ-wLIvK998t3s2ecEM4Q",
	    "expiresIn": 7200,
	    "refreshToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9D8IrNu9lm2w4XfMqS3j9OJgjv_8L1vvSkTjBt0q7X5foYiJOhVaNx6tDGzFkJw0vw",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "scope": "snsapi_friend,snsapi_message,snsapi_userinfo,"
	}


### 3.1.2 /auth/check_token ###

#### 3.1.2.1 인터페이스에 관한 설명 ####

위챗 검증 권한부여 증거(access_token)의 유효성 여부.
url 중에 msdkExtInfo=xxx（요청 일련번호）를 추가하면 향후 내용에서 msdkExtInfo오리지널 데이터를 가져와 이상 요청을 구현할 수 있습니다. msdkExtInfo는 옵션 파라미터.

#### 3.1.2.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| accessToken|string|로그인 상태 |
| openid|string|특정 게임에서 유저의 유니크ID|

#### 3.1.2.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 | 
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|

#### 3.1.2.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/auth/check_token/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.1.2.5 요청 예시 ####
	
	POST /auth/check_token/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJPLafWudG-idTVMbKesBkhBO_ZxFWN4zlXCpCHpYcrXNG6Vs-cocorhdT5Czj_23QF6D1qH8MCldg0BSMdEUnsaWcFH083zgWJcl_goeBUSQ",
	    "openid": "oGRTijiaT-XrbyXKozckdNHFgPyc"
	}
	
	//리턴 결과
	{"ret":0,"msg":"ok"}

## 3.2 Share서비스 ##
위챗의 1:1공유 능력 제공

### 3.2.1/share/upload_wx ###

#### 3.2.1.1 인터페이스에 관한 설명 ####

이미지를 위챗에 업로드하여 media_id를 획득하여，/share/wx인터페이스에 입력된 파라미터 thumb_media_id에 사용하며, 공유시 디폴트 이미지（app가입시 업로드한 icon）를 사용하면 해당 인터페이스를 호출할 필요가 없이 thumb_media_id=""만 하면 됩니다.（해당 인터페이스는 공유할 때마다 호출할 필요가 없으며 공유시 이미지를 교체하고자 할 경우에 한 번 호출하여 media_id를 획득하면 됨. 이후에 /share/wx 인터페이스 호출시 이미 획득한 media_id를 직접 입력하면 됨）
주의 사항:해당 인터페이스를 통하여 획득한 media_id는 Android OS의 위챗 5.4-6.1버전에서 무효（운영 매니져가 디폴트icon를 다시 업로드해야 한다），Android 위챗6.2버전에 해당 문제를 수정 완료.

#### 3.2.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| flag|int| 디폴트 상태에서는 1을 입력，secret을 사용해 로그인함 |
| appid|string|게임의 유니크ID |
| secret|string|appkey 입력|
| access_token|string|디폴트 상태는 비어있음"" |
| type|string|미디어 파일 유형，디폴트 상태는 섬네일（thumb） |
| filename|string|파일명|
| filelength|int|파일의 2진 스트림 길이，단위는 바이트，최대 64KB|
| content_type|string|파일 유형，아래 유형을 사용하십시오. 예："image/jpeg" 또는 "image/jpg" |
| binary|string|파일의 2진 스트림， urlencode로 코드 변환，예(php언어)：
	$filename = 'b.jpg';
	$image = './image/'.$filename;
	$handle = fopen($image,'r');
	$filelength = filesize($image);//바이트 수
	$contents=fread($handle,filesize($image));
	$binary = rawurlencode($contents);
	Java중 유의할 번호：“ISO-8859-1”， 예 URLEncoder.encode(new String(bs, "ISO-8859-1"), "ISO-8859-1"); |


#### 3.2.1.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|
| type|미디어 파일 유형，기존 섬네일（thumb） |
| media_id|미디어 파일 업로드 후 획득한 유니크ID， 이 ID는 위챗 공유 인터페이스의 파라미터에 사용됨 |
| created_at|미디어 파일 업로드 시간|
| access_token|인터페이스 호출 증거 |
| expire|이 파라미터를 무시함|

#### 3.2.1.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/share/upload_wx/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.2.1.5 요청 예시 ####

	POST /share/upload_wx/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{"flag":1,"appid":"wx6f15c6c03a84433d","secret":"bf159627552fa6bc8473d492c5b3e06d","access_token":"","type":"thumb","filename":"b.jpg","filelength":65050,"content_type":"image\/jpeg","binary":"%FF%D8%FF%E0%00%10JFIF%00%01%01%01%00%60%00%60%00%00%FF%DB%00C%00%03%02%02%03%02%02%03%03%03%03%04%03%03%04%05%08%05%05%04%04%05%0A%07%07%06%08%0C%0A%0C%0C%0B%0A%0B%0B%0D%0E%12%10%0D%0E%11%0E%0B%0B%10%16%10%11%13%14%15%15%15%0C%0F%17%18%16%14%18%12%14%15%14%FF%DB%00C%01%03%04%04%05%04%05%09%05%05%09%14%0D%0B%0D%14%14%14%...."}
	
	//리턴 결과
	{
	    "ret": 0,
	    "msg": "success",
	    "type": "thumb",
	    "media_id": "CAUmtmwCq6jSGWaypYRzJRpErL-vUZj8UPeU8UupzyMFGGpmOnkeUDGLLI9RiTqN",
	    "created_at": "1379579554",
	    "access_token": "avl-4_K9aZ7MY88Tb-FKfCt3LNvsFkkCXGErRmX7tn19iqw0p45nGjB76tdRfhfi-7oWAQr8ZbvwC1EuWx_f8m5-A0kNNhEC7HAaePUokAtb6xGgRGyyAkoftjlk42sp4OSVJCgkuwWvithft4a00Q",
	    "expire": ’’
	}

### 3.2.2/share/wx ###

#### 3.2.2.1 인터페이스에 관한 설명 ####
　　　공유 메시지를 위챗 친구에게 발송 (동일한 게임을 설치한 친구에게만 발송 가능)

#### 3.2.2.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| openid|string|특정 게임에서 유저의 유니크ID|
| fopenid|string| 공유한 친구 openid |
| access_token|string|로그인 상태 |
| extinfo|string|제3자 프로그램의 사용자 정의 간단한 데이터로서，위챗은 제3자 프로그램에 되돌려서 처리하도록 하며， 길이 제한은 2k, 클라이언트 클릭시 이 바이트를 획득할 수 있음.|
| title|string|게임 메시지 타이틀 |
| description|string|게임 메시지 설명 |
| media_tag_name|string|게임 메시지 유형 구분， 데이터 통계에 사용됨 |
| thumb_media_id|string|디폴트 상태는 비어있음: 해당 파라미터가 비어있을 경우 공유시 사용한 이미지는 위챗 플랫폼 가입시 사용했던 이미지이며, 공유시 이미지를 변경하고자 할 경우 /share/upload_wx인터페이스를 통하여 해당 media_id 를 획득함|


#### 3.2.2.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|

#### 3.2.2.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/share/wx/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.2.2.5 요청 예시 ####

	POST /share/wx/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	{
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "fopenid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "access_token": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2BZMgzJc8KWgXT8uGw242GeNigmf9VQCouPmZ9ciBE4MA",
	    "extinfo": "extinfo",
	    "title": "to myself",
	    "description": "test by hunter",
	    "media_tag_name": "media_tag_name",
	    "thumb_media_id": ""
	}
	
	//리턴 결과
	{"ret":0,"msg":"success"}

#### 3.2.20.6 공유 캡처화면 예시 ####

![공유 이미지](./shareWX.jpg)


### 3.2.3/share/wxgame（해당 인터페이스는 잠시 대외적으로 개방하지 않음） ### ###

#### 3.2.3.1 인터페이스에 관한 설명 ####

동일 개발자 계정 권한을 부여받은 친구에게 메시지를 발송하면 메시지는 게임 센터에 표시됩니다.
메시지는 전시 모듈(텍스트, 이미지, 비디오 및 링크를 지원)과 버튼 모듈(게임 플레이, 
랭킹순위 열기 및 링크 열기를 지원)로 나뉩니다. 인터페이스 요청을 통하여 메시지 요청을 만들 수 있습니다.

#### 3.2.3.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 게임의 유일한 id|
| openid|string|특정 게임에서 유저의 유니크ID|
| access_token|string|로그인 상태 |
| touser|string|수신측 openid |
| msgtype|string|메시지 유형， 현재 text（텍스트）, image（이미지）, video（비디오） 및 link（링크）를 지원 |
| title|string|로그인 상태 |
| content|string|메시지 내용， text,image,video,link에 해당한 내용 |
| type_info|struct|유형 파라미터 |
| button|struct|버튼 효과 |
요청 예시 중의 파라미터에 관한 설명:

![공유 이미지](shareWXGame.jpg)

#### 3.2.3.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|

#### 3.2.3.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/share/wxgame/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

3.2.3.5 요청 예시

	POST /share/wxgame/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	//텍스트 유형 메시지 발송, 버튼을 누르면 랭킹순위로 건너뜀
	{
	    "access_token": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2B9F0OYlWIOzWjd_GdcKvIZX4PQn0Qs651yNntCvTeIUg",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "appid": "wxd477edab60670232",
	    "touser": "OPENID",
	    "msgtype": "text",
	    "title": "TITLE",
	    "content": "CONTENT",
	    "button": {
	        "type": "rank",
	        "name": "BUTTON_NAME",
	        "rankview": {
	            "title": "RANK_TITLE",
	            "button_name": "LAUNCH_GAME",
	            "message_ext": "MESSAGE_EXT"
	        }
	    }
	}
	//이미지 유형 메시지 발송, 버튼을 누르면 랭킹순위로 건너뜀
	{
	    "access_token": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2B9F0OYlWIOzWjd_GdcKvIZX4PQn0Qs651yNntCvTeIUg",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "appid": "wxd477edab60670232",
	    "touser": "OPENID",
	    "msgtype": "image",
	    "title": "TITLE",
	    "content": "CONTENT",
	    "type_info": {
	        "picurl": "PICURL",
	        "width": 180,
	        "height": 180
	    },
	    "button": {
	        "type": "rank",
	        "name": "BUTTON_NAME",
	        "rankview": {
	            "title": "RANK_TITLE",
	            "button_name": "LAUNCH_GAME",
	            "message_ext": "MESSAGE_EXT"
	        }
	    }
	}
	//비디오 유형 메시지 발송, 버튼을 누르면 링크를 열기
	{
	    "access_token": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2B9F0OYlWIOzWjd_GdcKvIZX4PQn0Qs651yNntCvTeIUg",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "appid": "wxd477edab60670232",
	    "touser": "OPENID",
	    "msgtype": "video",
	    "title": "TITLE",
	    "content": "CONTENT",
	    "type_info": {
	        "picurl": "PICURL",
	        "width": 300,
	        "height": 300,
	        "mediaurl": "http://v.youku.com/v_show/id_XNjc0NTA4MzM2.html?f=21949327&ev=2"
	    },
	    "button": {
	        "type": "web",
	        "name": "BUTTON_NAME",
	        "webview": {
	            "url": "http://www.qq.com/"
	        }
	    }
	}
	//링크 유형 메시지 발송, 버튼을 누르면 게임을 열기
	{
	    "access_token": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2B9F0OYlWIOzWjd_GdcKvIZX4PQn0Qs651yNntCvTeIUg",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "appid": "wxd477edab60670232",
	    "touser": "ocfbNjkN8WfPRFlTx4cLU-jNiXKU",
	    "msgtype": "link",
	    "title": "Youku 링크",
	    "content": "이건 뚀짜탠(屌炸天) 링크입니다",
	    "type_info": {
	        "url": "http://www.youku.com/",
	        "iconurl": "http://tp4.sinaimg.cn/1949746771/180/5635873654/1"
	    },
	    "button": {
	        "type": "app",
	        "name": "시작",
	        "app": {
	            "message_ext": "ext"
	        }
	    }
	}
	
	//리턴 결과
	{"ret":0,"msg":"success"}


## 3.3.Relation서비스 ##

　위챗 개인 및 친구 계정 기본정보 검색 서비스 제공.

### 3.3.1 /relation/wxfriends_profile ###

#### 3.3.1.1 인터페이스에 관한 설명 ####
　위챗 개인 및 함께 플레이하는 친구의 기본정보를 획득.

***PS：이 인터페이스는 /relation/wxprofile&/relation/wxfriends 2개 인터페이스를 통합한 신규 인터페이스로서， 한 번만 요청하면 함께 플레이하는 친구의 기본정보를 획득할 수 있으므로 우선 친구 리스트를 얻은 후에 다시 친구의 개인정보를 요청할 필요가 없게 됩니다. 통합하기 전의 인터페이스와 공존하므로 이 인터페이스를 통하여 함께 플레이하는 친구의 정보를 획득할 것을 권장합니다.***

#### 3.3.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| accessToken|string|로그인 상태 |
| openid|string|특정 게임에서 유저의 유니크ID|

#### 3.3.1.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|
| list|위챗을 함께 플레이하는 친구의 개인정보 리스트, 유형`vector<WXInfo>`|
| privilege|유저 특권 정보， json 배열，위챗 WO 카드 유저가（chinaunicom）인 경우 첫자리 openid와 상응하는 WO 카드 정보에만 리턴되며 그 뒤의 openid는 WO 카드 정보를 획득할 수 없습니다. |
| country|국가 |
| language|언어 |

	struct WXInfo {
		string          nickName;        //닉네임
		int             sex;            //성별 1남자 2여자
		string          picture;        //유저 프로필URL,반드시 URL뒤에 아래 파라미터를 추가해야 한다./0，/132，/96，/64，이렇게 해서 각 규격 이미지를 획득할 수 있다：원시 이미지(/0)、132*132(/132)、96*96(/96)、64*64(/64)、46*46(/46)
		string          provice;        //성(省)
		string          city;           //도시
		string          openid;        //유저ID
	};

#### 3.3.1.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/wxfriends_profile/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.3.1.5 요청 예시 ####

	POST /relation/wxfriends_profile/?timestamp=1380018062&appid=wxcde873f99466f74a&sig=dc5a6330d54682c88846b1294fbd5fde&openid=A3284A812E%20CA15269F85AE1C2D94EB37&encode=1
	
	{
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2DJrEqoT5SW76pqG7N3Mh6ZI79VLoFSM7wdVpS4bz61Vg",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0"
	}
	
	//리턴 결과
	{
	    "country": "CN",
	    "language": "zh_CN",
	    "ret": 0,
	    "msg": "success",
	    "lists": [{
	        "nickName": "ufo",
	        "sex": 1,
	        "picture": "http:\/\/wx.qlogo.cn\/mmhead\/LwcbhAmMnZBAqZyUkv1z3qJibczZRdrZRkTgcNnqKqovicmDxLmyffdQ",
	        "provice": "",
	        "city": "Shenzhen",
	        "openid": "oy6-ljl-aYH1tl3L2clpVhhVXHtY"
	    },
	    {
	        "nickName": "\u8054\u901atest",
	        "sex": 2,
	        "picture": "",
	        "provice": "",
	        "city": "",
	        "openid": "oy6-ljtb1PKnNtRKlouJAj952hlg"
	    },
	    {
	        "nickName": "ila",
	        "sex": 2,
	        "picture": "http:\/\/wx.qlogo.cn\/mmhead\/Q3auHgzwzM5wrVe0CbkibUDWDvJpgzt1W4QicbXF09SPo1rLO8Glff5Q",
	        "provice": "",
	        "city": "",
	        "openid": "oy6-ljqJeurpVex1kyRAZl5blq3U"
	    },
	    {
	        "nickName": "KDS\u9648\u5c0f\u4eae\u5f88\u5c4c\u4e1d",
	        "sex": 1,
	        "picture": "http:\/\/wx.qlogo.cn\/mmhead\/HS9jXWzBezdQrNojlmPvvQlwhGJcrN923nrJCSmv2rk",
	        "provice": "",
	        "city": "Yangpu",
	        "openid": "oy6-ljrzoW6jjxS2jI2LHZvGdsqA"
	    },
	    {
	        "nickName": "Lewis",
	        "sex": 1,
	        "picture": "http:\/\/wx.qlogo.cn\/mmhead\/zreQPiaCicYfReYeU0sicsc92cfBdMejRFsicXK1fZibP7aM",
	        "provice": "",
	        "city": "Po",
	        "openid": "oy6-ljoHSdnupQFMgHNTWoqSXXVg"
	    }],
	    "privilege": []
	}


### 3.3.2/relation/wxprofile(프리미엄 게임에만 제공됨) ###

#### 3.3.2.1 인터페이스에 관한 설명 ####

위챗 계정 개인의 기본자료를 획득.

#### 3.3.2.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| accessToken|string|로그인 상태 |
| openids|`vector<string>`|`vector<string>`유형， 획득하고자 하는 openid 계정 리스트 (현재 로그인한 유저의 WO 카드 정보를 획득하려면 유저 openid를 첫자리에 놓아야 함. 이유는 첫자리에 있는 openid만 WO 카드 정보를 획득할 수 있고 그 뒤의 openid는 WO 카드 정보를 획득할 수 없기 때문임) |

#### 3.3.2.3 파라미터 출력에 관한 설명 ####


| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|
| lists|정보 리스트`vector<WXInfo>`유형|
|privilege|유저 특권 정보， json 배열，위챗 WO 카드 유저가（chinaunicom）인 경우 첫자리 openid와 상응하는 WO 카드 정보에만 리턴되며 그 뒤의 openid는 WO 카드 정보를 획득할 수 없습니다.|

	struct WXInfo {
		string          nickName;        //닉네임
		int             sex;           //성별 1남자 2여자, 유저가 입력하지 않으면 디폴트 값은 1남자
		string          picture;        //유저 아이콘 URL, URL뒤에 아래의 파라미터를 /0，/132，/96，/64 추가해야만 규격이 다른 이미지를 각각 획득할 수 있음: 오리지널 이미지(/0)、132*132(/132)、96*96(/96)、64*64(/64)、46*46(/46)
		string          provice;        //성(省)
		string          city;           //도시
		string          openid;        //유저ID
		string          country        //국가
		string          language      //언어
	};


#### 3.3.2.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/wxprofile/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.3.2.5 요청 예시 ####

	POST /relation/wxprofile/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	{
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2Ccq_dcbciAvC8frI3gYk5d2p6pDFy-bOqyPTNysUxOQg",
	    "openids": ["oGRTijrV0l67hDGN7dstOl8CphN0", "oGRTijlTxQPrvr-H5-pgoZMhZgog"]
	}
	
	//리턴 결과
	{
	    "country": "CN",
	    "language": "zh_CN",
	    "lists": [
	        {
	            "city": "Shenzhen",
	            "nickName": "헌터",
	            "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	            "picture": "http://wx.qlogo.cn/mmhead/RpIhxf6qwjeF1QA6YxVvE8El3ySJHWCJia63TePjLSIc",
	            "provice": "",
	            "sex": 1
	        },
	        {
	            "city": "Zhongshan",
	            "nickName": "WeGame테스트",
	            "openid": "oGRTijlTxQPrvr-H5-pgoZMhZgog",
	            "picture": "",
	            "provice": "",
	            "sex": 2
	        }
	    ],
	    "msg": "success",
	    "privilege": [],
	    "ret": 0
	}

### 3.3.3/relation/wxfriends ###

#### 3.3.3.1 인터페이스에 관한 설명 ####

위챗을 함께 플레이하는 친구의 openid리스트를 획득; 리스트를 획득한 후 /relation/wxprofile인터페이스를 통하여 친구의 기본정보를 대량으로 검색할 수 있습니다.

#### 3.3.3.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| accessToken|string|로그인 상태 |
| openid|string|특정 게임에서 유저의 유니크ID|

#### 3.3.3.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|
| openids|친구 리스트 vector<string>유형 |

#### 3.3.3.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/wxfriends/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.3.3.5 요청 예시 ####

	POST 
	/relation/wxfriends/?timestamp=*&appid=**&sig=**&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198

	{
	    "openid": "oGRTijiaT-XrbyXKozckdNHFgPyc",
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJPLafWudG-idTVMbKesBkhaKJhRmjhioMlDM_zBq_SxfYO2jdJKzAR6DSHL5-02O6oATRKHf57K-teO6bPsB1RHjH5Z0I1TzMn4DllSYrf3Q"
	}
	
	//리턴 결과
	{
	    "ret": 0,
	    "msg": "success",
	    "openids": ["oy6-ljtb1PKnNtRKlouJAj952hlg", "oy6-ljrzoW6jjxS2jI2LHZvGdsqA", "oy6-ljqJeurpVex1kyRAZl5blq3U", "oy6-ljoHSdnupQFMgHNTWoqSXXVg", "oy6-ljl-aYH1tl3L2clpVhhVXHtY"]
	}

### 3.3.4/relation/wxuserinfo(비프리미엄 업무에 사용됨) ###

### 3.3.4.1 인터페이스에 관한 설명 ###

위챗의 개인정보 획득

#### 3.3.4.2 파라미터 입력에 관한 설명 ####


| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 게임의 유일한 id|
| accessToken|string|로그인 상태 |
| openid|string|특정 게임에서 유저의 유니크ID|

#### 3.3.4.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|
| nickname|닉네임 |
| picture|`유저 아이콘 URL; URL뒤에 아래의 파라미터를 /0，/132，/96，/64` 추가해야만 규격이 다른 이미지를 각각 획득할 수 있음: 오리지널 이미지(/0)、132*132(/132), 96*96(/96), 64*64(/64), 46*46(/46)|
| province|성(省) |
| city|도시 |
| country|국가 |
| sex|성별 1남자 2여자, 유저가 입력하지 않으면 디폴트 값은 1남자, 0은 알 수 없음을 뜻함 |
| unionid|유저 통일 표지위챗 오픈 플랫폼 계정 하의 게임을 놓고 볼 때 동일 유저의 unionid는 유일함. |
|privilege|유저 특권 정보， json 배열，위챗 WO 카드 유저（chinaunicom）인 경우 첫자리 openid와 상응하는 WO 카드 정보에만 리턴되며 그 뒤의 openid는 WO 카드 정보는 획득할 수 없습니다.|
| language|언어(비워둘 수 있음)|
| gpsCity|GPS를 통하여 획득한 도시|
| openid|게임에서 유저의 유니크ID|

#### 3.3.4.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/relation/wxuserinfo/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.3.4.5 요청 예시 ####

	POST /relation/wxuserinfo/?timestamp=*&appid=**&sig=***&openid=**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
		"appid": "wxcde873f99466f74a",
		"openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
		"accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2C-TqXCXdT-DZ44iKkidglb5Q9jQbXnMPrSTck_DUdGMg"
	}
	
	//리턴 결과
	{
		"city": "Shenzhen",
		"country": "CN",
		"msg": "success",
		"nickname": "헌터",
		"picture": "http://wx.qlogo.cn/mmopen/uQDECzzFUic3xMCxSqQwsgXZqgCB2MtscmicF20OGZiaKia6fMlqOLuGjlibiaUnVPk0GoGwkKWv2MIa8e4BSwXRHn7ia7zRn1bVz9E/0",
		"privilege": [],
		"province": "Guangdong",
		"ret": 0,
		"sex": "1",
		"unionid": "o1A_BjhwQHB2BUyasZ_Lb2rkkOpE"
	}

## 3.4.Profile서비스 ##

### 3.4.1/profile/wxscore （해당 인터페이스는 곧 사용 불가능하니 신규 인터페이스 /profile/wxbattle_report 사용하기 바람） ###

#### 3.4.1.1 인터페이스에 관한 설명 ####

게이머 실적을 위챗 플랫폼에 전송하면 위챗 게임 센터에 친구 랭킹순위를 표시합니다 (즉각 발효).
（해당 인터페이스는 곧 사용 불가능하니 신규 인터페이스: 3.4.2/profile/wxbattle_report 사용하기 바람）

#### 3.4.1.2 파라미터 입력에 관한 설명 ####

| 파라미터 이름| 유형|설명|
| ------------- |:-------------:|:-----|
| appid|string|플랫폼에서 게임의 유일한 id|
| openid|string|특정 게임에서 유저의 유니크ID|
| grantType|string|권한부여 유형， 디폴트 상태：“client_credential” |
| score|string|스코어 |
| expires|string|초과시간， unix타임스탬프， 0인 경우 영구적으로 시간초과 현상이 발생하지 않음을 뜻함|
*** (입력된 파라미터 유형에 대해 주목 바라며 1.5를 참조 바랍니다.) ***

#### 3.4.1.3 파라미터 출력에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 뜻합니다. 자세한 내용은 5절을 참조 바랍니다.|

#### 3.4.1.4 인터페이스 호출에 관한 설명 ####

| 파라미터 이름| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/wxscore/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 3.4.1.5 요청 예시 ####

	POST http://msdktest.qq.com/profile/wxscore/?timestamp=1380018062&appid=wxcde873f99466f74a&sig=dc5a6330d54682c88846b1294fbd5fde&openid=A3284A812E%20CA15269F85AE1C2D94EB37&encode=1
	
	{
	    "appid": "wxcde873f99466f74a",
	    "grantType": "client_credential",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "score": "1000000",
	    "expires": "12345612312"
	}
	
	//리턴 결과
	{
	    "msg": "success",
	    "ret": 0
	}

#### 3.4.1.6 효과 전시 ####

![공유 이미지](./profileWxscore.jpg)

### 3.4.2/profile/wxbattle_report ###

#### 3.4.2.1인터페이스 설명 ####

게임 업적 정보（점수, 대전 등）를 위챗 게임 센터에 전송

#### 3.4.2.2입력 파라미터 설명 ####

| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 응용포로가 플랫폼에 유일한 id |
| openid|string|유저가 모 응용프로에 유니크ID |
| json|json객체|전투json데이터 |

	//전투json데이터
	{
	    "baseinfo": { //게임 기본 정보
	        "gamename": "xxx",//게임명;
	        "platid": 0,//플랫폼id ios:0, android:1
	        "partitionid": 2,//월드ID，디폴트값 0
	        "roleid": "",//캐릭터ID 문자열
	        "level": 2 //유저 게임 레벨
	    },
	    "battleinfo": {//대전 정보
	        "score": 1,//점수
	        "modeid": 0,//게임 모드 1:클래식 모드 2
	        "acttime": "2014-09-24 13:10:45"//대전 시간 2014-09-24 13:10:45
	    }
	}

***（입력 파라미터의 타입에 대해 주목 바라며 1.5를 참조 바랍니다.）***

#### 3.4.2.3출력 파라미터 설명 ####

| 파라미터명| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확，기타：실패 |
| msg|ret비0일 경우,“에러 코드, 에러 알림”을 표시，자세한 내용을 5절을 참조 바랍니다.|

#### 3.4.2.4 인터페이스 호출 설명 ####

| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/wxbattle_report/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 격식|JSON |
| 요청 방식|POST  |

#### 3.4.2.5 요청 예시 ####

	POST http://msdktest.qq.com/profile/wxbattle_report/?timestamp=1380018062&appid=wxcde873f99466f74a&sig=dc5a6330d54682c88846b1294fbd5fde&openid=A3284A812E%20CA15269F85AE1C2D94EB37&encode=1
	
	{
	    "appid": "wxcde873f99466f74a",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
		"json":{
		    "baseinfo": { 
		        "gamename": "xxx",
		        "platid": 0,
		        "partitionid": 2,
		        "roleid": "hunter",
		        "level": 2 
		    },
		    "battleinfo": {
		        "score": 1,
		        "modeid": 0,
		        "acttime": "2014-09-24 13:10:45"
		    }
		}
	}
	
	//리턴 결과
	{
	    "msg": "success",
	    "ret": 0
	}

### 3.4.3/profile/wxget_vip ###

#### 3.4.3.1인터페이스 설명 ####

위챗 특권 획득

#### 3.4.3.2입력 파라미터 설명 ####

| 파라미터명| 타입|설명|
| ------------- |:-------------:|:-----|
| appid|string| 응용포로가 플랫폼에 유일한 id |
| openid|string|유저가 모 응용프로에 유니크ID |
| accessToken|string|요청하는 유저의 로그인 상태 |
| json|json캑체|요청json,내용은：{"optype":1}, "optype:1"：자신과 친구유저를 획득, 현재로써 기타 값이 없습니다. |


***（입력 파라미터의 타입을 주의해야 한다. 1.5 참고）***

#### 3.4.3.3출력 파라미터 설명 ####

| 파라미터명| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확，기타：실패 |
| msg|ret비0일 경우,“에러 코드, 에러 알림”을 표시，자세한 내용은 5절을 참조 바랍니다|
| data|특권 메시지 `vipinfo`|

	{
	    "vipinfo": [	//vipinfo배열에 첫번째 기록은 디폴트로 요청자이고 친구는 그 뒤에 정열；데이터가 없을 경우 data는 비어 있습니다.
						//logo_url 및 logo_faceurl 파라미터는 현재 사용 불가 상태이며 주목할 필요 없습니다.
	        {
	            "openid": "xxx",
	            "level": 1,			//레벨
	            "score": 310,		//포인트
	            "nick": "VIP1",		//vip명
	            "logo_url": "xxxx", //vip logo이미지url
	            "logo_faceurl": "xxx" //프로필에 기입할 vip logo 이미지의 url
	        },
	        {
	            "openid": "xxx",
	            "level": 0,
	            "score": 0,
	            "nick": "VIP0",
	            "logo_url": "xxxx",
	            "logo_faceurl": "xxx"
	        }
	    ]
	}

#### 3.4.3.4 인터페이스 호출 설명 ####

| 파라미터명| 설명|
| ------------- |:-----|
| url|http://msdktest.qq.com/profile/wxget_vip/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 격식|JSON |
| 요청 방식|POST  |

#### 3.4.3.5 요청 예시 ####

	POST http://msdktest.qq.com/profile/wxget_vip?timestamp=1380018062&appid=wxcde873f99466f74a&sig=dc5a6330d54682c88846b1294fbd5fde&openid=A3284A812E%20CA15269F85AE1C2D94EB37&encode=1
	
	{
	    "appid": "wxcde873f99466f74a",
	    "openid": "oGRTijrV0l67hDGN7dstOl8CphN0",
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJYyBcXKXYWTlxU_BAMfu7Rzsr51Nu-CarhcPT6zYlD9FrWRzuA0ccQMgrTGqpao2C-TqXCXdT-DZ44iKkidglb5Q9jQbXnMPrSTck_DUdGMg",
	    "json": {
	        "optype": 1
	    }
	}
	
	//리턴 결과
	{
	    "msg": "success",
	    "ret": 0,
		"data":{
		    "vipinfo": [
		        {
		            "openid": "xxx",
		            "level": 1,			
		            "score": 310,		
		            "nick": "VIP1",		
		            "logo_url": "xxxx", 
		            "logo_faceurl": "xxx" 
		        },
		        {
		            "openid": "xxx",
		            "level": 0,
		            "score": 0,
		            "nick": "VIP0",
		            "logo_url": "xxxx",
		            "logo_faceurl": "xxx"
		        }
		    ]
		}
	}


# 4. 게스트 모드

## 4.1 auth서비스

　　게스트 모드에서 권한부여 로그인 관련 기능을 구현하였습니다.

### 4.1.1 /auth/guest_check_token 


#### 4.1.1.1 인터페이스에 관한 설명 

　　게스트 모드에서 해당 인터페이스 인증을 호출합니다.

#### 4.1.1.2 파라미터 입력에 관한 설명 

| 파라미터 이름| 유형|설명|
| ------------- |:-------------|:-----|
| guestid|string| 게스트의 유일한 표지.|
| accessToken|string|유저 로그인 증거 |

#### 4.1.1.3 파라미터 출력에 관한 설명 

| 파라미터 이름| 설명|
| ------------- |:-----|
| ret|리턴 코드  0：정확함，기타：실패 |
| msg|ret는 0이 아닐 경우 “오류 코드，오류 표시”를 의미합니다. 자세한 내용은 5장을 참조 바랍니다.|

#### 4.1.1.4 인터페이스 호출에 관한 설명 
|이름| 설명|
| ------------- |:-----|
| URL|http://msdktest.qq.com/auth/guest_check_token/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 포맷|JSON |
| 요청 방식|POST  |

#### 4.1.1.5 요청 예시 

	POST /auth/guest_check_token/?timestamp=&appid=G_**&sig=***&openid=G_**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJPLafWudG-idTVMbKesBkhBO_ZxFWN4zlXCpCHpYcrXNG6Vs-cocorhdT5Czj_23QF6D1qH8MCldg0BSMdEUnsaWcFH083zgWJcl_goeBUSQ",
	     guestid": "G_oGRTijiaT-XrbyXKozckdNHFgPyc"
	}
	
	//리턴 결과
	{
	    "ret": 0,
	    "msg": "ok"
	}


# FAQ #


1. 결과를 프린트할 때 ” Request overly frequency” 혹은 “too many times”가 출력할 경우 요청한 횟수가 너무 많음을 의미합니다. 백그라운드 서비스는  1초에 1회 이상의 요청을 처리할 수 없습니다.

2. 이상 “msdk.qq.com연결 실패 (0)” 혹은 “msdktest.qq.com연결 실패(0)”가 출력할 경우 서버가 msdk.qq.com 혹은 msdktest.qq.com 도메인을 해석하지 못함을 의미하므로 운영팀에 문의 바랍니다.

3. ret=-309 혹은 ret=-308 혹은 ret=-306, 혹은 ret=-101은 위챗 플랫폼 복귀 시간초과 혹은 연결 차단으로 인해 발생한 것입니다. 이런 이상 현상에 대해 msdk 백그라운드는 매일 통계 및 추적 처리를 실시합니다.

4.“-73，internal error”는 유저가 비밀번호를 변경하여 token이 효력을 상실하여 발생한 것입니다.<br>

		시나리오		
		a. 유저는 비밀번호를 변경한 뒤 권한을 다시 부여받아 신규 token을 획득하였습니다.
		b. 전의 token으로 다시 검증할 경우 이런 오류가 발생합니다.
5.“-1，system error”는 위챗 플랫폼 처리 데이터 오류로 인해 발생한 것입니다. 따라서 이러한 오류에 대해 모니터링 및 추적 처리를 실시해야 합니다. 필연적으로 발생하거나 발생한 횟수가 상대적으로 많을 경우 운영팀에 연락 바랍니다.

6.“-69,internal error”는 애플리케이션이 권한 시스템에 있지 않음을 의미합니다. 운영팀에 연락 바랍니다.

7.“100015，access token is revoked” 는 token이 이미 유저에 의해 폐기되었음을 의미합니다.

8./share/qq 흔히 보는 오류：
	
	A. {"msg":"100030,is_friend is 0","ret":-10000}  친구로 추가되지 않은 유저에게 하트 보내기 메시지 오류.<br>
		　　
    B. {"msg":"30,null ServiceError: :workid=yaaf_mpqq_msgsendsvr cmdid=1 com.tencent.jungle.api.APIException: 	30,response errorCode error 30","ret":-10000}<br>
		각 유저의 공용계정 하의 동일한 게임이 매일 수신할 수 있는 공유 메시지가 30개를 초과할 수 없음을 의미합니다.<br>
		
	C. {"msg":"103, 1:1 공유（휴대폰 단말기）친구 ServiceError: :workid=qconnshare cmdid=11 com.tencent.jungle.api.APIException: 103,response errorCode error 103","ret":-10000}
		　　파라미터가 너무 깁니다. title 은 45바이트를 초과할 수 없습니다.<br>
		　　
	D. {"msg":"32,null ServiceError: :workid=yaaf_mpqq_msgsendsvr cmdid=1 com.tencent.jungle.api.APIException: 32,response errorCode error 32","ret":-10000}
		공용계정 공유에 관심갖기 취소
		
	

9. “100030,this api without user authorization  ”이 뜰 경우 권한을 부여받지 못했음을 뜻합니다.예 <br>
    ![이미지 공유](./faq1.jpg)

10./auth/check_token 위챗 token 검증 인터페이스에 “40001,invalid credential”출력할 경우 정상 현상으로 간주됩니다. 2시간이 지나면 기간이 만료되는데 기간 만료 후 이 인터페이스를 호출할 경우 이러한 오류 코드가 나타납니다.

11./share/wx 위챗 인터페이스와 공유할 때 화면에 표시되지 않습니까？

	　　각 유저는 동일한 appid를 사용할 경우 매일 요청을 5개까지 수신할 수 있습니다.더 많을 경우 성공 여부를 보장할 수 없습니다.

12./share/upload_wx 인터페이스에 업로드한 이미지가 흐리게 나타납니까？

	　　urlencode 는 “스페이스 바”를 “+”부호로 바꿉니다.Rawurlencode를 사용하면 됩니다.

13. 위챗 및 모바일QQ에서 친구 추가를 한 후 얼마 지나야 게임에서 방금 추가한 친구를 획득할 수 있습니까？

	위챗은 시간당으로 처리하지만 모바일QQ는 바로 업데이트 가능합니다.



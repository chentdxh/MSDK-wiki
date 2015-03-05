# MSDK Android 상수

## 플랫폼 유형 ePlatform

	typedef enum _ePlatform
	{
	ePlatform_None,
	ePlatform_Weixin,		//위챗 플랫폼
	ePlatform_QQ			//모바일QQ 플랫폼
	}ePlatform;

## 콜백 표시 eFlag

### 모바일QQ 관련:
	
|리턴 코드|명칭|설명|권장 처리방법|
|: ------- :|: ------- :|: ------- :|: ------- :|
|1000|eFlag_QQ_NoAcessToken|모바일QQ 로그인 실패, accesstoken을 획득하지 못함|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|
|1001|eFlag_QQ_UserCancel|유저가 모바일QQ 인증 로그인 취소|로그인 화면에 돌아가서 유저에게 모바일QQ 인증 로그인을 취소했다고 통지|
|1002|eFlag_QQ_LoginFail|모바일QQ 로그인 실패|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|
|1003|eFlag_QQ_NetworkErr|네트워크 오류|재시도|
|1004|eFlag_QQ_NotInstall|유저 설비에 모바일QQ 클라이언트가 설치되지 않음|유저가 모바일QQ 클라이언트를 설치하도록 유도|
|1005|eFlag_QQ_NotSupportApi|유저 모바일QQ 클라이언트가 이 인터페이스를 지원하지 않음|유저가 모바일QQ 클라이언트를 업데이트하도록 유도|
|1006|eFlag_QQ_AccessTokenExpired|accesstoken 만료|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|
|1007|eFlag_QQ_PayTokenExpired|paytoken 만료|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|

### 위챗 관련:

|리턴 코드|명칭|설명|권장 처리방법|
|: ------- :|: ------- :|: ------- :|: ------- :|
|2000|eFlag_WX_NotInstall|유저 설비에 위챗 클라이언트가 설치되지 않음|유저가 위챗 클라이언트를 설치하도록 유도
|2001|eFlag_WX_NotSupportApi|유저 위챗 클라이언트가 이 인터페이스를 지원하지 않음|유저가 위챗 클라이언트를 업데이트하도록 유도|
|2002|eFlag_WX_UserCancel|유저가 위챗 인증 로그인 취소|로그인 화면에 돌아가서 유저에게 위챗 인증 로그인을 취소했다고 통지|
|2003|eFlag_WX_UserDeny|유저가 위챗 인증 로그인 거절|로그인 화면에 돌아가서 유저에게 위챗 인증 로그인이 거절되었음을 통지|
|2004|eFlag_WX_LoginFail|위챗 로그인 실패|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|
|2005|eFlag_WX_RefreshTokenSucc|위챗 토큰 새로고침 성공|위챗 토큰 획득, 게임 로그인 성공|
|2006|eFlag_WX_RefreshTokenFail|위챗 토큰 새로고침 실패|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|
|2007|eFlag_WX_AccessTokenExpired|위챗 accessToken 만료|refreshtoken으로 토큰 새로고침|
|2008|eFlag_WX_RefreshTokenExpired|위챗 refreshtoken 만료|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|

### 다른계정 관련:

|리턴 코드|명칭|설명|권장 처리법|
|: ------- :|: ------- :|: ------- :|: ------- :|
|3001|eFlag_NeedLogin|게임 로컬 계정과 실행 계정이 전부 로그인할 수 없음|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|
|3002|eFlag_UrlLogin|다른계정이 존재하지 않고 게임은 계정을 실행하여 빠른 로그인 성공|LoginRet 구조체 중 토큰을 획득하여 게임 인증 절차 진행|
|3003|eFlag_NeedSelectAccount|게임 로컬 계정과 실행 계정에 다른 계정이 존재|대화창을 팝업하여 유저에게 로그인 계정을 선택하게 함|
|3004|eFlag_AccountRefresh|다른 계정이 존재하지 않고 MSDK가 이미 인터페이스 새로고침을 통해 로컬 계정 토컨을 새로고침|LoginRet 구조체 중 토큰을 획득하여 게임 인증 절차 진행|

### 기타

|리턴 코드|명칭|설명|권장 처리방법|
|: ------- :|: ------- :|: ------- :|: ------- :|
|0|eFlag_Succ|성공|인터페이스 성공 로직에 따라 처리|
|-1|eFlag_Error|오류|인터페이스의 기본 오류 처리 방법에 따라 처리|
|-2|eFlag_Local_Invalid|계정 자동 로그인 실패, 로컬 토큰 만료와 새로고침 실패 등 모든 오류 포함|로그인 화면에 돌아가서 유저를 다시 로그인하도록 유도|
|-3|eFlag_NotInWhiteList|유저 계정이 화이트리스트에 없음|유저에게 계정 가챠를 사용하지 않았음을 알리고 유저가 마이앱에서 계정 가챠를 사용하도록 유도|
|-4|eFlag_LbsNeedOpenLocationService|게임에 필요한 위치 추적 서비스 미실행|유저에게 위치 추적 서비스를 실행하도록 유도|
|-5|eFlag_LbsLocateFail|게임 위치 추적 실패|유저에게 위치 추적 실패를 알리고 재시도 필요|
	
## 각종 구조체

### eTokenType

	typedef enum _eTokenType
	{
		eToken_QQ_Access = 1,    //모바일QQ accesstoken
		eToken_QQ_Pay,          //모바일QQ paytoken
		eToken_WX_Access,       //위챗 accesstoken
		eToken_WX_Code,        //게임과 관계없음
		eToken_WX_Refresh,      //위챗refreshtoken
	}eTokenType;



|플랫폼|token유형|token역할|type|유효시간|
|: ------- :|: ------- :|: ------- :|: ------- :|: ------- :|: ------- :|
|모바일QQ	|accesstoken|모바일QQ 개인, 친구, 관계사슬, 공유 등 기능 조회|eToken_QQ_Access|	90일|
|모바일QQ	|paytoken	|결제 관련|eToken_QQ_Pay|	6일|
|위챗|	accesstoken|위챗 개인, 친구, 관계사슬, 공유, 결제 등 조회|	eToken_WX_Access|	2시간|
|위챗|refreshtoken|	accesstoken 갱신|	eToken_WX_Refresh|	30일|

### TokenRet
MSDK server는 토큰을 통해 게임 유저 신분을 인증한다. TokenRet 구조 정의는 다음과 같다

		typedef struct {
	 		int type; //토큰유형  eTokenType유형
	 		std::string value; //토큰value
	 		long long expiration; //토큰 만료 시간(게임과 관계없음)
		}TokenRet;

### LoginRet
유저가 인증한 후 계정 정보는 이 구조에 저장된다. LoginRet 정의는 다음과 같다

		typedef struct loginRet_ {
			int flag;               //표시 리턴, 인증 또는 새로고침 성공 여부 표시 eFlag유형
			std::string desc;       //설명 리턴
			int platform;           //현재 인증한 플랫폼, ePlatform유형
			std::string open_id;     //유저 계정 고유 표시
			std::vector<TokenRet> token;     //토컨 배열 저장
			std::string user_id;    //유저ID, 일단 보류, 위챗과 협의 후 결정
			std::string pf;        //결제용    WGGetPf()를 호출하여 획득
			std::string pf_key;    //결제용     WGGetPfKey()를 호출하여 획득
			loginRet_ ():flag(-1),platform(0){}; //구조 방법
		}LoginRet;
                                    	
### ShareRet
공유 결과 정보는 이 구조에 저장된다. ShareRet 정의는 다음과 같다

		typedef struct{
			int platform;           //플랫폼유형   ePlatform유형
			int flag;            //조작결과      eFlag유형
			std::string desc;       //결과설명(보류)
    		std::string extInfo;   //게임 공유시 수신한 자체정의 문자열, 공유 표시
		}ShareRet;
	
### WakeupRet
플랫폼이 게임을 실행시킨 정보는 이 구조에 저장된다. WakeupRet 구조 정의는 다음과 같다

		typedef struct{
			int flag;                //오류코드   eFlag유형
			int platform;               //실행시킨 플랫폼  ePlatform유형
			std::string media_tag_name; //wx 반환하여 meidaTagName 획득
			std::string open_id;        //플랫폼 인증 계정의 openid
			std::string desc;           //설명

			std::string lang;          //언어     현재 위챗 5.1 이상에만 사용되며 모바일QQ에는 사용되지 않는다
			std::string country;       //국가     현재 위챗 5.1 이상에만 사용되며 모바일QQ에는 사용되지 않는다
			std::string messageExt; //게임 공유시 수신한 자체정의 문자열, 플랫폼이 게임 실행시 아무런 처리도 하지 않고 리턴, 현재 위챗 5.1 이상에만 사용되며 모바일QQ에는 사용되지 않는다
		}WakeupRet;

### PersonInfo
단일 친구 또는 개인의 정보 조회 결과는 이 구조에 저장된다.  PersonInfo 정의는 다음과 같다.

		typedef struct {
    		std::string nickName;  //닉네임
    		std::string openId;    //계정 고유 표시
    		std::string gender;    //성별
    		std::string pictureSmall;     //작은 아바타
    		std::string pictureMiddle;    //일반 아바타
    		std::string pictureLarge;     //datouxiang
    		std::string provice;          //성
    		std::string city;           //도시
		}PersonInfo;
### RelationRet
조회 결과는 이 구조에 저장된다. RelationRet 정의는 다음과 같다.

		typedef struct {
    		int flag;     //조회 결과 flag, 0은 성공
    		std::string desc;    // 설명
    		std::vector<PersonInfo> persons;//친구 또는 개인 정보 저장
		}RelationRet;

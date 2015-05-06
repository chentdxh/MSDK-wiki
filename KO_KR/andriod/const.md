# MSDK Android 상수

## 플랫폼 유형 ePlatform

	typedef enum _ePlatform
	{
	ePlatform_None,
	ePlatform_Weixin,		//위챗 플랫폼
	ePlatform_QQ			//모바일QQ 플랫폼
	}ePlatform;

## 콜백 ID eFlag

### 모바일QQ 관련:
	
|리턴 코드|명칭|설명|권장 처리방법|
|: ------- :|: ------- :|: ------- :|: ------- :|
|1000|eFlag_QQ_NoAcessToken|모바일QQ 로그인 실패, accesstoken을 획득 불가|로그인 화면으로 돌아가 다시 로그인하도록 유도|
|1001|eFlag_QQ_UserCancel|유저가 모바일QQ 인증 로그인 취소|로그인 화면으로 돌아가 유저에게 모바일QQ 인증 로그인을 취소하였음을 안내|
|1002|eFlag_QQ_LoginFail|모바일QQ 로그인 실패|로그인 화면으로 돌아가 다시 로그인하도록 유도|
|1003|eFlag_QQ_NetworkErr|네트워크 오류|재시도|
|1004|eFlag_QQ_NotInstall|유저 설비에 모바일QQ 클라이언트 미설치|모바일QQ 클라이언트를 설치하도록 유도|
|1005|eFlag_QQ_NotSupportApi|유저 모바일QQ 클라이언트에서 해당 인터페이스 지원불가|모바일QQ 클라이언트를 업데이트하도록 유도|
|1006|eFlag_QQ_AccessTokenExpired|accesstoken 만료|로그인 화면으로 돌아가 다시 로그인하도록 유도|
|1007|eFlag_QQ_PayTokenExpired|paytoken 만료|로그인 화면으로 돌아가 다시 로그인하도록 유도|

### 위챗 관련:

|리턴 코드|명칭|설명|권장 처리방법|
|: ------- :|: ------- :|: ------- :|: ------- :|
|2000|eFlag_WX_NotInstall|유저 설비에 위챗 클라이언트 미설치|위챗 클라이언트를 설치하도록 유도|
|2001|eFlag_WX_NotSupportApi|유저 위챗 클라이언트에서 해당 인터페이스 지원불가|위챗 클라이언트를 업데이트하도록 유도|
|2002|eFlag_WX_UserCancel|유저가 위챗 인증 로그인 취소|로그인 화면으로 돌아가 위챗 인증 로그인을 취소하였음을 안내|
|2003|eFlag_WX_UserDeny|유저가 위챗 인증 로그인 거절|로그인 화면에 돌아가서 유저에게 위챗 인증 로그인이 거절되었음을 통지|
|2004|eFlag_WX_LoginFail|위챗 로그인 실패|로그인 화면으로 돌아가 다시 로그인하도록 유도|
|2005|eFlag_WX_RefreshTokenSucc|위챗 토큰 리셋 성공|위챗 토큰 획득, 게임 로그인 성공|
|2006|eFlag_WX_RefreshTokenFail|위챗 토큰 리셋 실패|로그인 화면으로 돌아가 다시 로그인하도록 유도|
|2007|eFlag_WX_AccessTokenExpired|위챗 accessToken 만료|refreshtoken으로 토큰 리셋|
|2008|eFlag_WX_RefreshTokenExpired|위챗 refreshtoken 만료|로그인 화면으로 돌아가 다시 로그인하도록 유도|

### Diff계정 관련:

|리턴 코드|명칭|설명|권장 처리법|
|: ------- :|: ------- :|: ------- :|: ------- :|
|3001|eFlag_NeedLogin|게임 로컬 계정과 실행 계정 모두 로그인 불가|로그인 화면으로 돌아가 다시 로그인하도록 유도|
|3002|eFlag_UrlLogin|Diff계정이 없으며 실행 계정으로 빠른 로그인 성공|LoginRet 구조체의 토큰을 획득하여 게임 인증 절차 진행|
|3003|eFlag_NeedSelectAccount|게임 로컬 계정과 실행 계정에 Diff계정이 존재|팝업창을 출력하여 유저들이 선택하여 로그인하도록|
|3004|eFlag_AccountRefresh|Diff계정이 없으며 MSDK에서 이미 인터페이스 리셋을 통하여 로컬 계정 토컨을 리셋|LoginRet 구조체의 토큰을 획득하여 게임 인증 절차 진행|

### 기타

|리턴 코드|명칭|설명|권장 처리방법|
|: ------- :|: ------- :|: ------- :|: ------- :|
|0|eFlag_Succ|성공|인터페이스 성공 로직에 따라 처리|
|-1|eFlag_Error|오류|인터페이스의 기본 오류 처리 방법에 따라 처리|
|-2|eFlag_Local_Invalid|계정 자동 로그인 실패, 로컬 토큰 만료와 리셋 실패 등 모든 오류 포함|로그인 화면으로 돌아가 다시 로그인하도록 유도|
|-3|eFlag_NotInWhiteList|유저 계정이 화이트리스트에 없음|유저에게 계정 가챠를 사용하지 않았음을 안내하고 응용보에서 계정 가챠를 진행하도록 유도|
|-4|eFlag_LbsNeedOpenLocationService|게임에 필요한 위치 추적 서비스 미실행|유저에게 위치 추적 서비스를 실행하도록 유도|
|-5|eFlag_LbsLocateFail|게임 위치 추적 실패|유저에게 위치 추적 실패를 안내하고 재시도|
	
## 각 구조체

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
|모바일QQ	|accesstoken|모바일QQ 개인,친구,SNS친구관계,공유 등 기능 조회|eToken_QQ_Access|	90일|
|모바일QQ	|paytoken	|결제 관련|eToken_QQ_Pay|	6일|
|위챗|	accesstoken|위챗 개인,친구,SNS친구관계,공유,결제 등 조회|	eToken_WX_Access|	2시간|
|위챗|refreshtoken|	accesstoken 업데이트|	eToken_WX_Refresh|	30일|

### TokenRet
MSDK server는 토큰을 통하여 게임 유저 신분을 인증합니다. TokenRet 구조 정의는 아래와 같습니다.

		typedef struct {
	 		int type; //토큰유형  eTokenType유형
	 		std::string value; //토큰value
	 		long long expiration; //토큰 만료 시간(게임과 무관)
		}TokenRet;

### LoginRet
유저 인증후의 계정 정보는 이 구조에 저장됩니다. LoginRet 정의는 아래와 같습니다.

		typedef struct loginRet_ {
			int flag;               //표식 리턴, 인증 혹은 리셋 성공 여부 표시 eFlag유형
			std::string desc;       //설명 리턴
			int platform;           //현재 인증한 플랫폼, ePlatform유형
			std::string open_id;     //유저 계정 유니크 ID
			std::vector<TokenRet> token;     //토컨 배열 저장
			std::string user_id;    //유저ID, 일단 보류, 위챗과 협의 후 결정
			std::string pf;        //결제용    WGGetPf()를 호출하여 획득
			std::string pf_key;    //결제용     WGGetPfKey()를 호출하여 획득
			loginRet_ ():flag(-1),platform(0){}; //구축 방법
		}LoginRet;
                                    	
### ShareRet
결과 정보 공유는 이 구조에 저장됩니다. ShareRet 정의는 아래와 같습니다.

		typedef struct{
			int platform;           //플랫폼유형   ePlatform유형
			int flag;            //조작결과      eFlag유형
			std::string desc;       //결과설명(보류)
    		std::string extInfo;   //공유시 전송하는 것은 자체정의 스트링, 공유를 표시
		}ShareRet;
	
### WakeupRet
플랫폼에서 호출한 게임 정보는 이 구조에 저장됩니다. WakeupRet 구조 정의는 아래와 같습니다.

		typedef struct{
			int flag;                //오류코드   eFlag유형
			int platform;               //호출한 플랫폼  ePlatform유형
			std::string media_tag_name; //wx 리턴하여 meidaTagName 획득
			std::string open_id;        //플랫폼에서 인증한 openid
			std::string desc;           //설명

			std::string lang;          //언어     현재 위챗 5.1 이상에만 사용되며 모바일QQ에는 사용되지 않습니다.
			std::string country;       //국가     현재 위챗 5.1 이상에만 사용되며 모바일QQ에는 사용되지 않습니다.
			std::string messageExt; //공유시 전송하는 것은 자체정의 스트링, 플랫폼에서 호출하며 게임에서 처리하지 않고 리턴, 현재 위챗 5.1 이상에만 사용하며 모바일QQ에는 사용하지 않습니다.
		}WakeupRet;

### PersonInfo
단일 친구 혹은 개인의 정보 조회 결과는 이 구조에 저장됩니다.  PersonInfo 정의는 아래와 같습니다.

		typedef struct {
    		std::string nickName;  //닉네임
    		std::string openId;    //계정 유니크 ID
    		std::string gender;    //성별
    		std::string pictureSmall;     //작은 아바타
    		std::string pictureMiddle;    //일반 아바타
    		std::string pictureLarge;     //datouxiang
    		std::string provice;          //성
    		std::string city;           //도시
		}PersonInfo;
### RelationRet
조회 결과는 이 구조에 저장됩니다. RelationRet 정의는 아래와 같습니다.

		typedef struct {
    		int flag;     //조회 결과 flag, 0은 성공
    		std::string desc;    // 설명
    		std::vector<PersonInfo> persons;//친구 혹은 개인 정보 저장
		}RelationRet;

상수 조회
---

1. 플랫폼 유형 ePlatform

		typedef enum _ePlatform
		{
            ePlatform_None,
            ePlatform_Weixin,		//위챗 플랫폼
            ePlatform_QQ,			//모바일QQ 플랫폼
            ePlatform_Guest = 5     //게스트
		}ePlatform;

2. 콜백 표시 eFlag

        typedef enum _eFlag
        {
            eFlag_Succ              = 0,
            eFlag_QQ_NoAcessToken   = 1000,     //QQ&QZone login fail and can't get accesstoken
            eFlag_QQ_UserCancel     = 1001,     //QQ&QZone user has cancelled login process (tencentDidNotLogin)
            eFlag_QQ_LoginFail      = 1002,     //QQ&QZone login fail (tencentDidNotLogin)
            eFlag_QQ_NetworkErr     = 1003,     //QQ&QZone networkErr
            eFlag_QQ_NotInstall     = 1004,     //QQ is not install
            eFlag_QQ_NotSupportApi  = 1005,     //QQ don't support open api
            eFlag_QQ_AccessTokenExpired = 1006, // QQ Actoken 효력 상실, 재로그인 필요
            eFlag_QQ_PayTokenExpired = 1007,    // QQ Pay token 기한만료
            eFlag_QQ_UnRegistered = 1008,    // qq에서 등록하지 않음
            eFlag_QQ_MessageTypeErr = 1009,    // QQ 메시지 유형 오류
            eFlag_QQ_MessageContentEmpty = 1010,    // QQ 메시지는 null
            eFlag_QQ_MessageContentErr = 1011,     // QQ 메시지 불가용(너무 길거나 기타)
            eFlag_WX_NotInstall     = 2000,     //Weixin is not installed
            eFlag_WX_NotSupportApi  = 2001,     //Weixin don't support api
            eFlag_WX_UserCancel     = 2002,     //Weixin user has cancelled
            eFlag_WX_UserDeny       = 2003,     //Weixin User has deny
            eFlag_WX_LoginFail      = 2004,     //Weixin login fail
            eFlag_WX_RefreshTokenSucc = 2005, // Weixin 토큰 갱신 성공
            eFlag_WX_RefreshTokenFail = 2006, // Weixin 토큰 갱신 실패
            eFlag_WX_AccessTokenExpired = 2007, // Weixin AccessToken 효력 상실, 이때 refreshToken으로 토큰 갱신을 시도할 수 있다
            eFlag_WX_RefreshTokenExpired = 2008, // Weixin refresh token 기한만료, 재인증 필요
            eFlag_Error				= -1,
            eFlag_Local_Invalid = -2, // 로컬 토큰 무효, 게임은 로그인 화면에서 다시 인증해야 한다
            eFlag_LbsNeedOpenLocationService = -4, // 유저가 위치확인 서비스를 실행하도록 안내해야 한다
            eFlag_LbsLocateFail = -5, // 위치추적 실패
            eFlag_UrlTooLong = -6,     // for WGOpenUrl
            eFlag_NeedLogin = 3001,     //로그인 페이지 방문 필요
            eFlag_UrlLogin = 3002,    //URL로 로그인 성공
            eFlag_NeedSelectAccount = 3003, //다른계정 제시 팝업 필요
            eFlag_AccountRefresh = 3004, //URL을 통해 토큰 갱신
            eFlag_InvalidOnGuest = -7, //이 기능은 Guest 모드에서 불가용
            eFlag_Guest_AccessTokenInvalid = 4001, //Guest 토큰 효력 상실
            eFlag_Guest_LoginFailed = 4002,  //Guest 모드 로그인 실패
            eFlag_Guest_RegisterFailed = 4003  //Guest 모드 등록 실패
        }eFlag;


3. 토큰 유형 eTokenType

		typedef enum _eTokenType
		{
			eToken_QQ_Access = 1,    //모바일QQ accesstoken
			eToken_QQ_Pay,          //모바일QQ paytoken
			eToken_WX_Access,       //위챗 accesstoken
			eToken_WX_Code,        //위챗 code, 사용하지 않음
			eToken_WX_Refresh,      //위챗 refreshtoken
            eToken_Guest_Access     // Guest 모드에서의 토큰
		}eTokenType;
||플랫폼	token 유형||	token 역할||	token ||type	||유효 기간||
	
		모바일QQ	accesstoken	 모바일QQ 개인, 친구, 관계사슬, 공유 등 조회 기능  eToken_QQ_Access	90일
		paytoken	 결제 관련	 eToken_QQ_Pay	2일
		위챗	accesstoken	 위챗 개인, 친구, 관계사슬, 공유, 결제 조회 등  eToken_WX_Access	2시간
		refreshtoken	accesstoken갱신	eToken_WX_Refresh	30일

4. TokenRet 토큰 structure
MSDK server는 토큰을 통해 게임 유저 신분을 검증한다. TokenRet 구조 정의에 대한 설명은 다음과 같다.

		typedef struct {
	 		int type; //토큰 유형  eTokenType 유형
	 		std::string value; //토큰 value
	 		long long expiration; //토큰 기한만료 시간(게임과 무관)
		}TokenRet;

5. LoginRet 계정 structure
유저 인증 후 계정 정보는 이 구조에 저장된다. LoginRet 정의:

		typedef struct loginRet_ {
			int flag;               //표시 리턴, 인증 또는 갱신 성공 여부 표시  eFlag유형
			std::string desc;       //설명 반환
			int platform;           //현재 인증한 플랫폼, ePlatform 유형
			std::string open_id;     //유저 계정 고유 표시
			std::vector<TokenRet> token;     //토큰 배열 저장
			std::string user_id;    //유저ID, 일단 보류, 위챗과 협상 후 결정
			std::string pf;        //결제용    WGGetPf()를 호출하여 획득
			std::string pf_key;    //결제용    WGGetPfKey()를 호출하여 획득
			loginRet_ ():flag(-1),platform(0){}; //구조 방법
		}LoginRet;
                                    	
6. ShareRet 공유 결과 structure
공유 결과 정보는 이 구조에 저장된다. ShareRet 정의:

		typedef struct{
			int platform;           //플랫폼 유형   ePlatform 유형
			int flag;            //조작결과      eFlag유형
			std::string desc;       //결과 설명(보류)
    		std::string extInfo;   //게임 공유시 수신한 자체정의 문자열, 공유 표시
		}ShareRet;
	
7. WakeupRet 실행 structure
플랫폼이 게임을 실행하는 정보는 이 구조에 저장된다. WakeupRet 구조 정의:

		typedef struct{
			int flag;                //오류 코드   eFlag 유형
			int platform;               //실행시킨 플랫폼  ePlatform유형
			std::string media_tag_name; //wx 반환하여 meidaTagName 획득
			std::string open_id;        //플랫폼 인증 계정의 openid
			std::string desc;           //설명

			std::string lang;          //언어     현재 위챗 5.1이상에서만 사용, 모바일QQ는 사용하지 않음
			std::string country;       //국가     현재 위챗 5.1이상에서만 사용, 모바일QQ는 사용하지 않음
			std::string messageExt; //게임 공유시 전송한 자체정의 문자열, 플랫폼에서 게임 실행시 어떤 처리도 반환하지 않는다. 현재 위챗5.1 이상만 사용. 모바일QQ는 사용하지 않는다
            std::vector<KVPair> extInfo;  //게임－플랫폼에 운반하는 자체정의 파라미터, 모바일QQ 전용
		}WakeupRet;

8. PersonInfo 개인정보 structure
조회 결과에서 단일 친구 또는 개인 정보는 이 구조에 저장된다. PersonInfo 정의:

		typedef struct {
    		std::string nickName;  //닉네임
    		std::string openId;    //계정 고유 표시
    		std::string gender;    //성별
    		std::string pictureSmall;     //작은 아바타
    		std::string pictureMiddle;    //일반 아바타
    		std::string pictureLarge;     //datouxiang
    		std::string provice;          //성
    		std::string city;           //도시
            bool        isFriend;         //친구 여부
            int         distance;         //이번 위치추적 지점까지 거리
            std::string lang;             //언어
            std::string country;          //국가
            std::string gpsCity;          //GPS 정보에 따라 획득한 도시
		}PersonInfo;

9. RelationRet 조회 결과 structure
조회 결과는 이 구조에 저장된다. RelationRet 정의:

		typedef struct {
    		int flag;     //조회 결과 flag, 0는 성공
    		std::string desc;    // 설명
    		std::vector<PersonInfo> persons;//친구 또는 개인 정보 저장
            std::string extInfo; //게임 조회시 전송된 자체정의 필드, 조회 1회를 표시한다
		}RelationRet;

10. ADRet 광고 structure
ADRet 정의:
        typedef struct
        {
            std::string viewTag;   //Button 클릭 tag
            _eADType scene;   //일시정지 또는 종료 위치
        } ADRet;

11. AddressInfo 주소 정보 structure
LBS 주소 정보는 이 구조에 저장된다. AddressInfo 정의:

        typedef struct
        {
            std::string name;           //지명
            std::string addr;           //구체 주소
            int distance;               //이번 위치추적 지점까지 거리
        }AddressInfo;

12. LocationRet 지리적 위치 structure
LBS 지리적 위치 정보는 이 구조에 저장된다. LocationRet 정의:

        typedef struct {
            int flag;
            std::string desc;
            double longitude;           //경도
            double latitude;            //위도
        }LocationRet;

13. PicInfo 이미지 정보 structure
이미지 정보는 이 구조체에 저장된다. PicInfo 정의:

        typedef struct
        {
            eMSDK_SCREENDIR screenDir;      //가로세로 화면   1: 가로 2:세로
            std::string picPath;            //이미지 로컬 경로
            std::string hashValue;          //이미지 hash 값
        }PicInfo;

14. NoticeInfo 공지 정보 structure
공지 정보는 이 구조체에 저장된다. NoticeInfo 정의:

        typedef struct
        {
            std::string msg_id;			//공지id
            std::string open_id;		//유저 open_id
            std::string msg_url;		//공지 이동 링크
            eMSG_NOTICETYPE msg_type;	//공지 유형, eMSG_NOTICETYPE
            std::string msg_scene;		//공지가 표시되는 씬, 관리자 백그라운드 설정
            std::string start_time;		//공지 유효 기간 시작시간
            std::string end_time;		//공지 유효 기간 종료시간
            eMSG_CONTENTTYPE content_type;	//공지 내용 유형, eMSG_CONTENTTYPE
            //웹페이지 공지 특수 필드
            std::string content_url;     //웹페이지 공지 URL
            //이미지 공지 특수 필드
            std::vector<PicInfo> picArray;    //이미지 배열
            //텍스트 공지 특수 필드
            std::string msg_title;		//공지 제목
            std::string msg_content;	//공지 내용
        }NoticeInfo;

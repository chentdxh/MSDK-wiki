#MSDK 버전 역사

Android 2.7 버전 역사
---

###Android 2.7.0변경 내용

#### 코드 변경：

- 신규 추가 기능：
	- QQ 그룹 추가 및 그룹 바인딩 두 인터페이스를 추가：[QQ그룹 바인딩 정보 조회](qq.md#QQ그룹 바인딩 정보 조회)및 [QQ그룹 바인딩 해제](qq.md#QQ그룹 바인딩 해제)그리고[3개 콜백](qq.md#그룹 추가 및 그룹 바인딩 콜백 설정).모든 QQ 그룹 추가 및 그룹 바인딩 인터페이스는 MSDK호출 필요.

- SDK업데이트：
	- 결제 SDK를 1.3.9e버전으로 업데이트
	- XG 푸시는 2.37버전으로 업데이트
	- 응용보 미니패치SDK를  1.1버전으로 업데이트

- bug 수정：
	- JG 심의WxEntryActivity버그 및 XG버그 수정.

- MSDK내부 최적화：
	- 내장 브라우저는 독립적 프로스세 사용으로 수정하여 새로운 설정 방법에 따라 수정 진행해야 한다.
	- 로그인 프로세스 최적화,새로운 호출 방법에 의해 수정 진행해야 한다.
	- 로그인 시간 통게 기능 추가

#### 문서 변경：

- QQ에 그룹 추가 및 바인딩 두 인터페이스 신규 추가：[QQ그룹 바인딩 정보 조회](qq.md#QQ그룹 바인딩 정보 조회)와 [QQ그룹 바인딩 해제](qq.md#QQ그룹 바인딩 해제)그리고[3개 콜백](qq.md#그룹 추가 및 바인딩 콜백 설정)에 관련 문서.[QQ그룹 추가 및 바인딩 관련 문제](qq.md#QQ그룹 추가 및 바인딩 FAQ)
- [JG심사](http://wiki.dev.4g.qq.com/v2/ZH_CN/android/index.html#!jg.md)문제에 관련 해결 방안을 최적화
- 응용보 모듈에 [`미니패니 내용`](myApp.md)조정한다.**`이 부분에 조정 내용이 많이 있어 특별히 주목하시기 바란다！`**
- 내장 브라우저에 [`연동 설정`](webview.md)부분을 조정.**`이부분 내용은 게임측 특별히 관심 가져야 한다！`**
- 로그인 모듈에 [`로그인 연동에 관련 구체적 작업（개발자 필독）`](login.md#로그인 연동 구체적 작업（개발자 필독）)내용을 조정한다.**`이 부분에 조정 내용이 있어, 게임측은 2.7.0a버전의 로그인 호출 설명을 특별히 주목해야 한다！`**
- SDK연동에[`MSDK초기화`](android.md#Step3: MSDK초기화)내용을 조정하여 onRestart,onResume,onPause,onStop,onDestroy를 반드시 호출해야 한다.**`이 부분 내용도 게임측 특별 주목 필요！`**

Android 2.6 버전 역사
---

###Android 2.6.0변경 내용

#### 코드 변경：

- 신규 추가 기능：
	- 위챗 코드 스캔으로 로그인하는 기능을 추가（TV 로비 게임에서 사용） 
	- 설정 불러오기, 공지 광고등 모듈 최적화한다
	- 위챗 토큰 자동으로 새로고침 로직을 최적화한다
	- 로그 보고 로직 최적화
- SDK업데이트：
	- openSDK를 2.8버전으로 업데이트（특정 스테이지에서 인증시 콜백 없는 bug수정）
	- 결제 SDK를 1.3.9d로 업데이트
- bug 수정：
	- QQ 퀵 로그인시 응용보 계정 가챠를 뛰어넘는 bug 수정
	- JG 심사 약한 타입의 검증 버그를 수정

#### 문서 변경：
- 없음

Android 2.5 버전 역사
---

###Android 2.5.1변경 내용

#### 코드 변경：

- Bug 수정

	1. 특정 폰모델（현재 알고 있는 일부Coolpad 7296,Duowei-QingchengL1,ETON P5,신주w50t2 모델에서 존재 가능）유저가 게임에 로그인 불가의 bug를 수정
	
#### 문서 변경：
없음

###Android 2.5.0변경 내용（현재 시리즈의 최신 버전으로 업데이트를 권장）

#### 코드 변경:

- 신규 기능:
	- 내장 브라우저 UI 최적화
	- 접속시간 보고 및 통계
	- MSDK는 모바일QQ 인증 과정에서 게임이 시스템에 의해 종료되는 문제에 대한 해결 추가
	- **rdm을 bugly(즉 crash 리포팅)로 변경, 구성 파일에 CLOSE_BUGLY_REPORT 추가, 만일 true이면 msdk는 기본적으로 bugly를 초기화하지 않는다**
	- XG Push 등록 인터페이스에 대한 성공률과 실패률 통계 추가

#### 문서 조정:

- 추가:
	- MSDK로그인 모듈 소개를 추가[클릭하여 살펴보기](login.md).아래 내용 포함：
		- MSDK인증 로그인에 관련된 로그인 인증, 자동 로그인, 퀵 로그인등 모듈의 정리
		- MSDK인증 로그인에 관련된 인터페이스 설명, 비교 및 추천 사용법.
		- MSDK인증 로그인 모듈 연동 스텝.
		- MSDK인증 로그인 모듈 특수 스테이지 소개.예를 들어,모바일QQ 액세스 모듈은 게임이 메모리가 적은 설비에서 인증 진행 시 시스템에 의해 종료된 후의 로그인 방안에 대한 설명 추가.[클릭하여 살펴보기`게임이 메모리가 적은 설비에서 인증 진행 시 시스템에 의해 종료된 후의 로그인 방안`](login.md#나머지는 특수 로직으로 처리한다.)
	- MSDK공유 모듈 소개 추가.[클릭하여 살펴보기](share.md).아래 내용을 포함：
		- MSDK공유모듈 인터페이스의 공유 방법, 사용 스테이지,공유 효과, 주의 사항 정리 등.
		- MSDK공유 모듈 인터페이스와 구체적 게임의 사용 스테이지와 결합하는 방법.
	- 다른 계정 모듈에는 FAQ 안내를 추가.[클릭하여 살펴보기](diff-account.md)。
- 수정：
	- QQ，위챗 로그인 관련 모듈 내용을 로드인 모듈로 옮긴다.	
	- 다른 계정 모듈에 QQ 퀵 로그인에 관련 모듈은 QQ로 이동.
	
Android 2.4 버전 역사
---

###Android 2.4.2변경 내용

#### 코드 변경：

- Bug 수정

	1. 특정 폰모델（현재 알고 있는 일부Coolpad 7296,Duowei-QingchengL1,ETON P5,신주w50t2 모델에서 존재 가능）유저가 게임에 로그인 불가의 bug를 수정
	
#### 문서 변경：
없음

###Android 2.4.1변경 내용（현재 시리즈의 최신 버전으로 업데이트를 권장）

#### 코드 변경:

- SDK 업데이트:

	1. OpenSDK를 v2.6으로 조정
	2. 브라우저 SDK 버전을 1.2로 업데이트
	
- 신규 기능:
	- 없음
- **인터페이스 조정:**
	- 없음

#### 문서 조정:

- 추가:
	- 공지 모듈에서 [공지 표시 인터페이스`WGShowNotice`](notice.md#공지 표시 인터페이스)와 [공지 데이터 획득 인터페이스`WGShowNotice`](notice.md#공지 데이터 획득 인터페이스) 관련 문서 내용이 조정되어 조정 후 인터페이스의 사용 설명이 추가되었다

###Android 2.4.0 변경 내용（현재 시리즈의 최신 버전으로 업데이트를 권장）

#### 코드 변경:

- SDK 업데이트:

	1. Midas 버전을 1.3.9b로 업데이트
	2. OpenSDK를 v2.7로 업데이트
	3. Mobgame을 1.5.1로 업데이트
	
- 신규 기능:
	- 게임 로그인/로그아웃을 Mobgame에 콜백
- **인터페이스 조정:**
	- 공지 모듈에서 [공지 표시 인터페이스`WGShowNotice`](notice.md#공지 표시 인터페이스)와 [공지 데이터 획득 인터페이스`WGShowNotice`](notice.md#공지 데이터 획득 인터페이스)를 삭제하고 파라미터 noticeType가 삭제되었다


#### 문서 조정:

- 추가:
	- 공지 모듈에서 [공지 표시 인터페이스`WGShowNotice`](notice.md#공지 표시 인터페이스)와 [공지 데이터 획득 인터페이스`WGShowNotice`](notice.md#공지 데이터 획득 인터페이스) 관련 문서 내용이 조정되어 조정 후 인터페이스의 사용 설명이 추가되었다

Android 2.3 버전 역사
---

###Android 2.3.4변경 내용

#### 코드 변경：

- Bug 수정

	1. 2.0.4a이상 2.0버전을 2.3버전으로 업데이트 시 crash를 유발할 수 있는 bug 수정.
	
#### 문서 변경：
없음


###Android 2.3.3변경 내용（현재 시리즈의 최신 버전으로 업데이트를 권장）

#### 코드 변경：

- Bug 수정

	1. 특정 폰 모델（현재 알고 있는 일부Coolpad 7296,Duowei-QingchengL1,ETON P5,신주w50t2 모델에서 존재 가능）유저가 게임에 로그인 불가의 bug를 수정
	
#### 문서 조정：
없음

###Android 2.3.2변경 내용（현재 시리즈의 최신 버전으로 업데이트를 권장）

#### 코드 변경：

- SDK업데이트

	1. Midas버전을 1.3.9d버전으로 업데이트
	
#### 문서 변경：
없음

###Android 2.3.1변경 내용（현재 시리즈의 최신 버전으로 업데이트를 권장）

#### 코드 변경:

- SDK 업데이트

	1. Midas 버전을 1.3.9a로 업데이트
	2. 내장 브라우저를 v1.2로 업데이트
	3. rdm를 1.8.3으로 업데이트
	4. Mobgame을 1.4.1로 업데이트
	
#### 문서 조정:
없음
###Android 2.3.0변경 내영（현재 시리즈의 최신 버전으로 업데이트를 권장）

#### 코드 변경:


- SDK 업데이트

	1. Midas 버전을 1.3.8c로 업데이트
	- OpenSDK를 v2.6.1로 업데이트

- 신규 기능
    1. 신규 API
		- Url을 위챗에 공유, WGSendtoWeixinWithUrl
		- 게임 QQ그룹 바인딩, WGBindQQGroup
		- 인게임 그룹추가, WGJoinQQGroup
		- 인게임 친구추가, WGAddFriendToQQ
		- 위챗 또는 모바일QQ 버전 획득, WGGetPlatformAPPVersion
		- 로컬 지원 상황 리턴, WGCheckApiSupport, 파라미터가 eApiName_WGSendToQQWithPhoto=0, eApiName_WGJoinQQGroup=1, eApiName_WGAddGameFriendToQQ=2, eApiName_WGBindQQGroup=3 등 4개로 증가
    - 위챗 accesstoken 자동 새로고침 스위치 설정 추가
    - Dop 광고 데이터 리포팅 통계 추가
- 기능 조정
	1. Mobgame 디커플링
		1. Mobgame 버전을 1.2로 업데이트
		2. Mobgame과 관련된 WGShowQMi, WGHideQMi, WGSetGameEngineType 인터페이스 삭제
- BUG 수정
    - 기한만료 광고 삭제시 로컬 이미지 무삭제

#### 문서 조정:

- 추가:
	1. 모바일QQ 액세스 모듈에 7번째 부분 추가(인게임 그룹/친구 추가)
	2. 위챗 액세스 모듈에 7번째 부분 추가(URL공유(모멘트/대화)
	3. 일부 툴 인터페이스 설명 문서 추가(플랫폼 설치 여부 검사, 인터페이스 지원 여부, 플랫폼 버전 획득, 채널 번호 획득)
	4. SDK XG push 기능 액세스
- 수정:
	1. 위챗 액세스 주의사항: 위챗 accesstoken 자동 새로고침 기능이 필요없으면 assets\msdkconfig.ini에서 WXTOKEN_REFRESH를 false로 설정하면 된다

Android 2.2 버전 역사
---
###Android 2.2.0변경 내용(내부 버전, 외부로 발표하지 않음)

#### 코드 변경:

- 신규 기능
	1. MSDK의 위챗 개인 정보 캡슐화 인터페이스
	- XG Push 기능 액세스
	- 로컬 중요 로그 저장 및 리포팅
- BUG 수정
	1. 내장 브라우저가 AMS를 열고 공유하지 못하는 문제 수정
	- http 헤더의 User-agent 필드에 단말기 소스 정보의 수요 추가
	
#### 문서 조정:
- 삭제
	1. 제6장 위챗 액세스 구조화 메시지 공유 게임친구에게 공유2 삭제
- 수정
	1. 게임친구에게 공유1 인터페이스가 파라미터 extMsdkInfo가 달린 함수 WGSendToWXGameFriend 사용, 이전에 사용한 것은 파라미터가 달리지 않은 extMsdkInfo의 이 함수이다
	- 제6장 위챗 액세스 위챗accesstoken 새로고침 사용을 권장하지 않음


Android 2.1 버전 역사
---
### Android 2.1.0 변경 내용(내부 버전, 외부로 발표하지 않음)
#### 코드 변경:

1. Midas Android SDK V1.3.7b 버전 통합 
- 문서 중 오류 수정 
3. 내장 브라우저 URL에 평문 openid 추가
4. 개인 위치 조회 인터페이스 추가
5. 모바일QQ 구조화 메시지가 이미지 공유시 로컬 경로 지원 
6. LBS 도시 정보 획득
7. MSDK 광고 시스템 1기

Android 2.0 버전 역사
---

### Android 2.0.6 변경 내용
#### 코드 변경:

1. 내장 브라우저가 AMS를 열고 공유하지 못하는 문제 수정
- 결제 SDK를 1.3.8c로 업데이트
- 게임로비가 게임을 실행한 후 Mobgame이 로그인하지 못하는 bug 수정
- MSDK 공지 모듈 기본값을 오픈으로 변경	
- 모든 로그인 인터페이스 호출은 deviceinfo를 추가하여 리포팅
- 내장 브라우저에서 searchBoxJavaBridge_ 인터페이스 제거, 금강 감사(보안 취약점 감사 시스템) 검측 통과

#### 문서 조정:
없음
### Android 2.0.5 변경 내용
#### 코드 변경:
    1.MTA 업데이트
        [수정] mta 버전을 2.0로 업데이트
    2.등탑 Crash 분석시 데이터가 없는 문제 수정
	[수정] eup_1.8.0->eup1.8.0.1을 업데이트하고 등탑 초기화시 CrashReport.setDengta_AppKey 추가(context, qqAppId);
    3.MIDAS를 V1.3.8로 업데이트
    4.로그인 데이터 일괄 전송에 신규 필드 추가		
 
##### 문서 조정:
	[삭제] 제6장 위챗 액세스 게임친구에게 공유2 삭제
[수정] 게임친구에게 공유1 인터페이스가 파라미터 extMsdkInfo가 달린 함수 WGSendToWXGameFriend 사용, 이전에 사용한 것은 파라미터가 달리지 않은 extMsdkInfo의 이 함수이다
        
### Android 2.0.4 변경 내용
#### 코드 변경:
    1.OpenSDK 업데이트
		[수정] opensdk 버전을 2.5로 업데이트
		[신증] 모바일QQ 인게임 그룹/친구 등록 인터페이스 추가: WGAddGameFriendToQQ, WGJoinQQGroup, WGBindQQGroup
		[수정] WGCheckApiSupport를 수정하고 그룹/친구 등록 3개 인터페이스에 대한 지원 추가
    2.Mobgame 디커플링
		[수정] Mobgame 버전을 1.2로 업데이트
		[삭제] Mobgame과 관련된 WGShowQMi, WGHideQMi, WGSetGameEngineType 3개 인터페이스 삭제
    3.내장브라우저 공유 BUG 수정
		[수정] 내장 브라우저가 모바일QQ/공간에 공유할 때 공유창의 미리보기가 항상 첫번째 공유한 미리보기만 표시하는 문제 수정
                [수정] 내장 브라우저 공유시 게임에 콜백할 필요가 없다. QQ 공유시 반드시 QQ가 설치되어 있어야 하고 위챗 공유 시에는 반드시 위챗이 설치되어 있어야 한다
    4.모바일QQ 위챗 버전 획득 인터페이스 추가
		[신증] 모바일QQ 또는 위챗 버전 획득 인터페이스 추가: WGGetPlatformAPPVersion
#### 문서 조정:
	[신증] 제5장, 모바일QQ 액세스 모듈에 7번째 부분 추가(인게임 그룹/친구 추가)
	[신증] 제19장 추가, 일부 툴 인터페이스 설명 문서 추가(플랫폼 설치 여부 검사, 인터페이스 지원 여부, 플랫폼 버전 획득, 채널 번호 획득)
	
### Android 2.0.3 변경 내용
1. 블루투스 설비명 획득 crash 문제 수정

### Android 2.0.2 변경 내용
1. 결제 SDK를 1.3.7b로 업데이트
2. 모바일QQ 빅이미지, 음악 공유 콜백을 최적화, 이전처럼 성공만 리턴하지 않음
3. MobgameSDK 리소스 조정
4. rqd 버전을 eup_1.8.6.jar로 업데이트
5. mid-sdk-2.10.jar를 독립시켜 MSDK의 jar 패키지에 통합하지 않는다
6. MSDK 로컬 로그를 삭제하지 못하는 문제 수정
7. 로컬 로그 리포팅에 BLUETOOTH_ADMIN의 permission 추가

### Android 2.0.1 변경 내용
1. 로그인 데이터 리포팅 추가, 게임이 게임 Activity의 onPause에서 WGPlatform.onPause()를 호출할 것을 요구;
2. 마이앱 트래픽 절약SDK를 버전 TMAssistantSDK_toMsdk_201407151049.jar로 업데이트
3. 등탑 SDK를 1.8.10으로 업데이트
4. mid-sdk-2.10.jar 도입, mat의 mid를 사용하여 설비 id로 삼는다
5. MobgameSDK를 qqgamemi_r226394.jar로 업데이트
6. WGSendMessageToWechatGameCenter 인터페이스 공유 ExtMsdkInfo가 null일 때 crash를 초래할 수 있는 BUG 수정


### Android 2.0.0 변경 내용

1. WGSendToWeixin(const eWechatScene& scene, unsigned char* title, unsigned char* desc, unsigned char* url, unsigned char* mediaTagName, unsigned char* thumbImgData, const int& thumbImgDataLen)이 달린 인터페이스 삭제, 이 인터페이스는 첫번째 scene 파라미터가 없는 인터페이스로 교체, 플랫폼을 제한하여 일부 게임이 이 인터페이스를 이용하여 콘텐츠를 모멘트에 공유하는 것을 방지
2. WGLoginWithLocalInfo 인터페이스를 수정하여 더욱 간편한 비최초 로그인 액세스 제공
3. 로컬에서 일정 시간마다 티켓을 새로 고치는 기능을 추가하여 10분마다 검사하여 만료되면 새로 고친다
4. 공지 모듈 최적화, 이미지와 네트워크 공지 추가; 특정 시간 공지 실행 추가
5. Mobgame 통합
6. 티겟 만료시 WGGetLoginRecord가 openid를 반환하지 않는 문제 수정
7. 내장 브라우저 모듈 최적화, 내장 브라우저 SDK 버전 교체; 다운로드 모니터링 추가, 새로 연 브라우저를 통해 다운로드 진행, 다운로드시 클릭 무응답 bug 해결

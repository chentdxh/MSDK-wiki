MSDK 기본 툴
======

모바일QQ/위챗 설치 여부 검토
------
WGIsPlatformInstalled 인터페이스를 호출하면 플랫폼에서 설치되었는 지 결과를 리턴합니다. 인터페이스에 대한 자세한 설명은 아래와 같습니다.
#### 인터페이스 설명: 

	/**
	 * @param platformType 게임에 전송된 플랫폼 유형, 가능한 값: ePlatform_QQ, ePlatform_Weixin
	 * @return 플랫폼 지원 상황. False는 미설치, true는 이미 설치되었음을 표시합니다.
	 */
	bool WGIsPlatformInstalled(ePlatform platformType);

#### 인터페이스 호출: 

인터페이스 호출 예시: 

	WGPlatform::GetInstance()->WGIsPlatformInstalled((ePlatform) platform);


모바일QQ/위챗 버전 획득
------
WGGetPlatformAPPVersion 인터페이스를 호출하면 현재 설치한 플랫폼에 해당한 버전을 리턴합니다. 인터페이스에 대한 자세한 설명은 아래와 같습니다.
#### 인터페이스 설명: 

	/**
	 * @return APP 버전 번호
	 */
	const std::string WGGetPlatformAPPVersion(ePlatform platform);

#### 인터페이스 호출: 

인터페이스 호출 예시: 

	WGPlatform::GetInstance()->WGGetPlatformAPPVersion((ePlatform) Platform);

인터페이스가 유저의 모바일QQ/위챗 설치에 대한 지원 여부 체크
------
WGCheckApiSupport 인터페이스를 호출하면 지정된 유형 현재 유효한 공지 데이터 리스트를 리턴합니다. 인터페이스에 대한 자세한 설명은 아래와 같습니다.
#### 인터페이스 설명: 

	/**
	 * @return 인터페이스의 지원 상황
	 * @param
	 * eApiName_WGSendToQQWithPhoto = 0,
	 * eApiName_WGJoinQQGroup = 1,
	 * eApiName_WGAddGameFriendToQQ = 2,
	 * eApiName_WGBindQQGroup = 3
	 */
	bool WGCheckApiSupport(eApiName);

#### 인터페이스 호출: 

인터페이스 호출 예시: 

	WGPlatform::GetInstance()->WGCheckApiSupport((eApiName) jApiName);

MSDK 버전 획득
------
WGGetVersion 인터페이스를 호출하면 MSDK 버전 번호를 리턴합니다. 인터페이스에 대한 자세한 설명은 아래와 같습니다.
#### 인터페이스 설명: 

	/**
	 * MSDK 버전 번호 반환
	 * @return MSDK 버전 번호
	 */
    const std::string WGGetVersion();

#### 인터페이스 호출: 

인터페이스 호출 예시: 

	WGPlatform::GetInstance()->WGGetVersion();

설치 채널 획득
----------

WGGetChannelId를 호출하면 게임의 설치 채널을 리턴합니다. 인터페이스에 대한 자세한 설명은 아래와 같습니다.
#### 인터페이스 설명: 

	/**
	 * @return 설치 채널
	 */
	const std::string WGGetChannelId();

#### 인터페이스 호출: 

인터페이스 호출 예시: 

	WGPlatform::GetInstance()->WGGetChannelId();

등록 채널 획득
----------

WGGetRegisterChannelId를 호출하면 유저의 등록 채널을 리턴합니다. 인터페이스에 대한 자세한 설명은 아래와 같습니다.
#### 인터페이스 설명:

	/**
	 * @return 등록 채널
	 */
	const std::string WGGetRegisterChannelId();

####인터페이스 호출: 

인터페이스 호출 예시: 

	WGPlatform::GetInstance()->WGGetRegisterChannelId();

로컬 로그
------

#### 1. 개요
이 모듈은 버전 2.0.0 이후부터 제공하며 게임에서 스위치를 통하여 MSDK 관련 Log의 프린트 여부를 제어할 수 있습니다.
#### 2. 설정 방식
로컬 로그 모듈은 디폴트로 off되어 있으며 해당 모듈 필요한 게임은 assets/msdkconfig.ini에서 localLog 값을 해당한 값으로 설정하면 됩니다.

| 스위치 수치 | Log 모드 |
|: ------- :|: ------- :|
| 0 | 프린트하지 않음 |
| 1 | logcat 프린트 |
| 2 | 로컬 파엘에 프린트, logcat에서 프린트하지 않음 |
| 3 | logcat와 로컬 파일에서 동시에 프린트 |	

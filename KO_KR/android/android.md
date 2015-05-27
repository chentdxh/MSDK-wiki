Android 
=======

## 패키지 구조 설명

MSDK 릴리즈 패키지(zip)는 주로‘MSDKLibrary’와 ‘MSDKSample’2개 중요 부분으로 구성됩니다. 하나는 MSDK 라이브러리이고 다른 하나는 MSDK 인터페이스 사용 예시입니다. MSDKLibrary/jni/CommonFiles/WGPlatform.h에 모든 인터페이스 설명이 포함되어 있으므로(java와 C++ 인터페이스는 대응 관계) 흔히 사용하지 않는 인터페이스관련 설명은 이 파일에서 확인할 수 있습니다.

`launchActivity`를 (게임 부팅 후 첫번째 Activity)사용하여 MSDK를 초기화하는 동시에 MSDK인터페이스 호출을 처리할 것을 `권장`합니다. 여러 Activity로 MSDK인터페이스 호출을 처리할 경우 위챗 연동시 쉽게 로그인 콜백 불가 에러가 발생할 가능성이 있습니다.

## Step1: MSDK 패키지 연동

### Android Library Project를 사용하는 게임

Eclipse에서 ‘MSDKLibrary’ 프로젝트를 등록합니다. 게임 프로젝트 우클릭->속성->Android->추가(라이브러리)->MSDKLibrary 선택으로 MSDKLibrary 액세스를 완료합니다.

### Android Library Project를 사용할 수 없는 게임

#### java 연동

Android Library Project를 사용할 수 없는 게임은 MSDKLibrary의 libs, res 두 디렉토리를 게임 프로젝트에 해당한 디렉토리에 복사합니다.

#### C++ 연동

Android Library Project를 사용할 수 없는 게임은 MSDKLibrary의 libs, res 두 디렉토리를 게임 프로젝트에 해당한 디렉토리에 복사합니다. 동시에 jni 디렉토리의 .cpp와 .h 두 파일을 게임 프로젝트에 복사 후 Android.mk에 등록합니다.

**주의사항:**

1. `MSDKLibrary`를 연동 후 컴파일 패킷 충돌(중복)이 발생하는 이유는 MSDK에 위챗 SDK(`libammsdk.jar`),QQ SDK(`open_sdk.jar`),MTA(`mta-xxx.jar`),Beacon SDK(`beacon-xxx.jar`)가 포함되어 있으며 게다가 상기 SDK가 모두 최신 버전이기 때문입니다. 전에 게임에서 별도로 SDK를 통합하였을 경우 전의 jar 패키지를 삭제하면 됩니다.
2. MSDKSample/assets/msdkconfig.ini는 MSDK 설정파일이며 환경 선택 및 각 기능 모듈의 설정 등이 포함됩니다. 게임 프로젝트내에 복사하여 해당 수요에 따라 변경할 수 있습니다.

## Step2: 설정 설명

### 권한 설정

	<!-- TODO SDK연동 필수 권한 모듈 START -->
	<uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
	<uses-permission android:name="android.permission.ACCESS_WIFI_STATE" />
	<uses-permission android:name="android.permission.ACCESS_FINE_LOCATION" />
	<uses-permission android:name="android.permission.CHANGE_WIFI_STATE" />
	<uses-permission android:name="android.permission.GET_TASKS" />
	<uses-permission android:name="android.permission.INTERNET" />
	<uses-permission android:name="android.permission.MOUNT_UNMOUNT_FILESYSTEMS" />
	<uses-permission android:name="android.permission.READ_PHONE_STATE" />
	<uses-permission android:name="android.permission.RESTART_PACKAGES" />
	<uses-permission android:name="android.permission.SYSTEM_ALERT_WINDOW" />
	<uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE" />

	<!—로그인 정보 전송 시 장비명도 전송.블루투스 모듈을 통하여 장비명 획득 -->
    <uses-permission android:name="android.permission.BLUETOOTH" />
    <uses-permission android:name="android.permission.BLUETOOTH_ADMIN" />
	<!-- TODO SDK연동 필수 권한 모듈 END -->

### 설정파일 수정

assets/msdkconfig.ini에서 방문해야 할 MSDK 백그라운드 환경(테스트 환경/공식 환경)을 설정합니다.연동 테스트 단계에서는 테스트 환경을 사용하며 공식 배포시 공식 환경(사내 테스트,오픈베타,공식 출시)을 사용합니다. 환경 변경 시 백그라운드에서도 해당한 환경으로 동시에 변경하여야 합니다. 아래는 포그라운드에서 MSDK 백그라운드 테스트 환경으로 방문하는 예시입니다.

	;인하우스 스튜디오 게임과 정품 퍼블리싱 게임은 아래 도메인에서 하나를 사용하면 됩니다.
	;msdktest는 테스트 환경 도메인이며 msdk는 공식 환경 도메인입니다.
	;MSDK_URL=http://msdk.qq.com
	;MSDK_URL=http://msdktest.qq.com
	
**PS:** 게임이 테스트 환경으로 출시하는 것을 피면하기 위해 SDK내에 테스트 환경 혹은 개발 환경으로 사용하는 것이 검증될 경우 **“You are using http://msdktest.qq.com”** 와 같은 안내를 Toast합니다. 게임이 공식 환경 도메인으로 변경될 경우 안내는 자동으로 사라집니다.

## Step3: MSDK 초기화

MSDK초기화 기능을 사용하는 전제는 SDK에서 제공하는 모든 기능을 사용할 수 있어야 합니다. 게임에서 앱을 실행할 시 MainActivity의 onCreate 방법에서 MSDK 초기화 함수 `WGPlatform.Initialized`를 호출하여 MSDK초기화를 진행합니다.
예시:

	public void onCreate(Bundle savedInstanceState) {
		...
		//게임은 자신의 QQ AppId를 사용하여 연동 테스트 진행
		baseInfo.qqAppId = "1007033***";
		baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

		//게임은 자신의 위챗 AppId를 사용하여 연동 테스트 진행
		baseInfo.wxAppId = "wxcde873f99466f***"; 
		baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

		//게임은 자신의 결제 offerId를 사용하여 연동 테스트 진행
		baseInfo.offerId = "100703***";

        // MSDK 2.7.1a 버전부터 게임은 msdk초기화 시 다이내믹적으로 버전번호 설정 가능하며 비콘 및 bugly의 버전번호는 msdk에서 통일로 설정합니다.
        // 2.7.1a이전 버전은 설정하지 않습니다.
        // 1.버전번호 구성 = versionName + versionCode
        // 2.게임이 appVersionName（혹 ""로 기입）및 appVersionCode(혹 -1로 기입)에게 값을 부여하지 않을 경우，
        // msdk디폴트로 AndroidManifest.xml에 있는 android:versionCode="51" 및 android:versionName="2.7.1"를 불러옵니다.
        // 3.게임이 여기에서 아래와 같은 appVersionName（빈칸 불가）및 appVersionCode（양의 정수）기입할 경우，비콘과 bugly에서 획득한 버전번호는 2.7.1.271입니다.
        baseInfo.appVersionName = "2.7.1";
        baseInfo.appVersionCode = 271;

		WGPlatform.Initialized(this, baseInfo);
		// QQ호출 시 필요한 인증 옵션을 설정
		WGPlatform.WGSetPermission(WGQZonePermissions.eOPEN_ALL); 

		// handleCallback는 Initialized 후 진행
		// launchActivity의 onCreat()와 onNewIntent()에서 필수 호출
        // WGPlatform.handleCallback(). 아닐 경우 위챗 로그인 콜백 불가
		WGPlatform.handleCallback(getIntent());
		...
	}

	
    protected void onResume() {
        super.onResume();
        WGPlatform.onResume();
    }

    @Override
    protected void onRestart() {
        super.onRestart();
        WGPlatform.onRestart();
    }

    protected void onPause() {
        super.onPause();
        WGPlatform.onPause();
    }

    @Override
    protected void onStop() {
        super.onStop();
        WGPlatform.onStop();
    }

    protected void onDestroy() {
        super.onDestroy();
        WGPlatform.onDestory(this);
    }

    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        WGPlatform.handleCallback(intent);
    }


추가로 MSDK2.5이하 버전은 MainActivty에서 RQD 다이나믹 라이브러리를 로딩하여야 합니다. 예시 코드：

	// TODO GAME은 필요한 다이나믹 라이브러리를 로딩
    static {
        System.loadLibrary("NativeRQD"); // 게임은 이 다이나믹 라이브러리를 로딩.데이터 전송용
        System.loadLibrary("WeGameSample"); // 게임은 필요 없음.MSDK Demo용
    }

**주의 사항：**

* MSDK2.5 및 그 이상 버전에는 이미 RQD를 Bugly로 변경하였으며 2.5 및 그 이상 버전을 연동할 시 게임 기존 프로젝트의 libs폴더에 `libNativeRQD.so`가 있으면 삭제 바랍니다. 또한 “NativeRQD"의 dynamic 라이브러리를 로딩할 필요가 없습니다.


**C++ 게임은 MainActivity의 onCreate 방법에서 SDK를 초기화하는 외에  **`JNI_OnLoad`**에서 SDK 관련 내용을 초기화하여야 합니다.**
WG로 시작되는 모든 인터페이스는 C++층과 Java층 인터페이스를 제공하였습니다. Java층은‘WGPlatform’를 통하여 호출하며 C++층은 `WGPlatform::GetInstance()`를 통하여 호출합니다. 호출 방법은 jni/PlatformTest.cpp를 참조 바랍니다.

    GlobalCallback g_Test;
    JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
        WGPlatform::GetInstance()->init(vm);// C++ 계층 초기화 SDK
        WGPlatform::GetInstance()->WGSetObserver(&g_Test);
        return JNI_VERSION_1_4;
    }

	
#### **주의 사항:**

**게임은‘launchActivity’의‘onCreat’와 ‘onNewIntent’에서 ‘WGPlatform.handleCallback()’를 호출하여야 합니다. 아닐 경우 게임은 일부 상황에서 콜백을 받을 수 없는 상황이 발생합니다.**
  
## Step4: 전역 콜백 설정

MSDK는 ‘WGPlatformObserver’Abstract Class중의 방법으로 인증,공유,조회 결과를 게임에 콜백하며 게임은 콜백 결과에 따라 UI 등을 튜닝합니다. 게임은 콜백을 설정하여야만 MSDK 응답을 받을 수 있습니다.
Java 콜백 설정:

	WGPlatform.WGSetObserver(new WGPlatformObserver() {
		@Override
		public void OnWakeupNotify(WakeupRet ret) { }
		@Override
		public void OnShareNotify(ShareRet ret) { }
		@Override
		public void OnRelationNotify(RelationRet relationRet) { }
		@Override
		public void OnLoginNotify(LoginRet ret) { }
	});

C++ 콜백 설정(**Java층 콜백을 설정하면 Java층 콜백을 우선 호출하게 됩니다. C++층 콜백을 사용할 경우 Java층 콜백을 설정하지 않습니다.**):

	class GlobalCallback: public WGPlatformObserver {
	public:
	    virtual void OnLoginNotify(LoginRet& loginRet) { }
	    virtual void OnShareNotify(ShareRet& shareRet) { }
	    virtual void OnWakeupNotify(WakeupRet& wakeupRet) { }
	    virtual void OnRelationNotify(RelationRet& relationRet) { }
	    virtual ~GlobalCallback() { }
	};
	GlobalCallback g_Test;

	JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
		// C++층 초기화,게임 메인 Activity의 onCreate전에 호출
		WGPlatform::GetInstance()->init(vm);
		WGPlatform::GetInstance()->WGSetObserver(&g_Test);
		return JNI_VERSION_1_4;
	}

**주의 사항:**
게임이 C++ API를 사용할 경우 **Java층의 전역 콜백을 설정하지 않습니다. 아닐 경우 SDK는 Java층 콜백을 우선적으로 호출하며 C++층의 콜백을 무시합니다. 그외 MSDK 콜백은 UI스레드에 있으므로 개발사에서 스레드 보안을 확보하여야 합니다.
	
여기까지 MSDK 연동 및 초기화 부분에 대해 모두 설명드렸습니다. 게임에서 각 모듈의 기능을 사용할 경우 해당 모듈의 연동 설정과 인터페이스 설명은 해당 파일을 참조 바랍니다.

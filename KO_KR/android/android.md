Android 
=======

## 패키지 구조 설명

MSDK 릴리스 패키지(zip)는 주로 2 개 중요한 부분 ‘MSDKLibrary’와 ‘MSDKSample’로 구성된다. 전자는 MSDK 라이브러리이고 후자는 MSDK 인터페이스 사용 예이다. MSDKLibrary/jni/CommonFiles/WGPlatform.h에 모든 인터페이스 설명이 포함되었기에 (java와 C++ 인터페이스는 대응 관계) 자주 사용되지 않는 인터페이스 설명은 이 파일에서 찾아볼 수 있다.

`launchActivity`를 (게임 시동한 첫번째 Activity)사용해서 MSDK 초기화하고 MSDK인터페이스 호출 처리하는 것을 `권장함`.여러 개 Activity로 MSDK인터페이스 호출 처리할 경우，위챗에 연동할 때는 로그인에 콜백 없는 에러가 쉽게 발생할 수 있다.

## Step1: MSDK 패키지 도입

### Android Library Project를 사용하는 게임

Eclipse에서 ‘MSDKLibrary’ 항목 도입. 게임 항목 우클릭->속성->Android->추가(라이브러리)->MSDKLibrary 선택, MSDKLibrary에 대한 참조 완료.

### Android Library Project를 사용하지 못하는 게임

#### java 액세스

Android Library Project를 사용하지 못하는 게임은 MSDKLibrary에서 libs, res 디렉토리를 복사하여 게임 프로젝트의 상응한 디렉토리에 붙여 넣어야 한다.

#### C++ 액세스

Android Library Project를 사용하지 못하는 게임은 MSDKLibrary에서 libs, res 디렉토리를 복사하여 게임 프로젝트의 상응한 디렉토리에 붙여 넣고 jni 디렉토리의 .cpp와 .h 파일을 복사하여 게임 프로젝트에 붙여 넣고 Android.mk에 추가해야 한다.

**주의 사항:**

1. `MSDKLibrary`를 도입한 후 컴파일시 패킷 충돌(중복)이 발생하는 이유는 MSDK에 위챗 SDK(`libammsdk.jar`), QQ 연동 sdk(`open_sdk.jar`), MTA(`mta-xxx.jar`), 등탑 SDK(`beacon-xxx.jar`)가 포함되었고 상기 sdk가 전부 최신 안정 버전이기 때문이다. 게임에 이런 SDK를 별도로 설치한 적이 있으면 이전에 설치한 jar 패키지를 삭제해야 한다.
2. MSDKSample/assets/msdkconfig.ini는 MSDK 구성 파일이며 환경의 선택, 각 기능 모듈의 설정 등을 포함한다. 게임 프로젝트로 복사하여 수요에 따라 변경하여 사용할 수 있다.

## Step2: 설정 설명

### 권한 설명

	<!-- TODO SDK 액세스 필수 권한 모듈 START -->
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

	<!—로그인 보고 시 장치명을 보고해야 함, 블루투스 모듈을 통해 장치명 획득 -->
    <uses-permission android:name="android.permission.BLUETOOTH" />
    <uses-permission android:name="android.permission.BLUETOOTH_ADMIN" />
	<!-- TODO SDK 액세스 필수 권한 모듈 END -->

### 구성 파일 수정

assets/msdkconfig.ini 에서 설정한 액세스해야 할 MSDK 백그라운드 환경(테스트 환경/공식 환경), 연동 테스트 단계에서 게임은 테스트 환경을 사용해야 하고 런칭 시 공식 환경으로 바꿔야 한다(사내테스트, 오픈베타, 공식런칭). 환경 전환 시 백그라운드도 대응한 환경으로 동시에 전환해야 한다는 점에 주의해야 한다. 다음은 프런트엔드가 MSDK 백그라운드에 액세스하는 테스트 환경 설정이다.

	;자체개발 게임과 프리미엄 대리게임은 이중 하나의 도메인을 사용하기 바란다
	;msdktest가 있는 것은 테스트 환경 도메인이고 msdk는 공식 환경 도메인이다
	;MSDK_URL=http://msdk.qq.com
	MSDK_URL=http://msdktest.qq.com
	
**PS:** 게임이 테스트 환경으로 런칭되는 것을 피면하기 위해 SDK에서 게임이 테스트 환경 또는 개발 환경을 사용하고 있다는 것이 검측되면 **“You are using http://msdktest.qq.com”** 와 같은 제시를 Toast한다. 게임이 공식 환경 도메인으로 전환하면 제시가 자동으로 사라진다

## Step3: MSDK 초기화

MSDK 초기화는 SDK가 제공하는 기능을 사용할 수 있는 전제이다. 게임은 앱이 실행될 때 MainActivity의 onCreate 방법에서 MSDK 초기화 함수 `WGPlatform.Initialized`를 호출하여 MSDK 초기화를 진행한다.
예하면:

	public void onCreate(Bundle savedInstanceState) {
		...
		//게임은 반드시 자신의 QQ AppId를 사용하여 연동 테스트 진행
		baseInfo.qqAppId = "1007033***";
		baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

		//게임은 반드시 자신의 위챗 AppId를 사용하여 연동 테스트 진행
		baseInfo.wxAppId = "wxcde873f99466f***"; 
		baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

		//게임은 반드시 자신의 결제 offerId를 사용하여 연동 테스트 진행
		baseInfo.offerId = "100703***";
		WGPlatform.Initialized(this, baseInfo);

		// handleCallback는 반드시 Initialized 뒤에 있어야 한다
		// launchActivity의 onCreat()와 onNewIntent()에서 반드시 호출
        // WGPlatform.handleCallback(). 그렇지 않으면 위챗 로그인 콜백이 없게 된다
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


또한，MSDK2.5이하의 버전은 MainActivty에서 RQD의 dynamic 라이브러리를 로딩해야 한다.예시 코드：

	// TODO GAME 은 필요한 동적 라이브러리를 로딩해야 함
    static {
        System.loadLibrary("NativeRQD"); // 게임은 이 동적 라이브러리를 로딩해야 한다. 데이터 보고용
        System.loadLibrary("WeGameSample"); // 게임은 이것이 필요치 않다. 이것은 MSDKDemo용
    }

**주의 사항：**

* MSDK2.5 및 이상 버전에는 이미 RQD를 Bugly로 바꿨고，2.5 및 그 이상버전에 연동할 때 게임 원 공정에 있는 libs폴더에 `libNativeRQD.so`가 있으면 삭제해야 한다.그리고 “NativeRQD"의 dynamic 라이브러리를 로딩할 필요가 없다.


**C++ 게임은 MainActivity의 onCreate 방법에서 SDK를 초기화해야 하는 것 외에  **`JNI_OnLoad`**에서 SDK 관련 내용을 초기화해야 한다.**
WG로 시작되는 모든 인터페이스는 C++ 계층과 Java 계층 인터페이스를 제공한다. Java 계층은 ‘WGPlatform’를 통해, C++ 계층은 `WGPlatform::GetInstance()`를 통해 호출한다. 이곳 호출 방법은 jni/PlatformTest.cpp를 참조하면 된다.

    GlobalCallback g_Test;
    JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
        WGPlatform::GetInstance()->init(vm);// C++ 계층 초기화 SDK
        WGPlatform::GetInstance()->WGSetObserver(&g_Test);
        return JNI_VERSION_1_4;
    }

	
#### **주의:**

**게임은 반드시 ‘launchActivity’의 ‘onCreat’와 ‘onNewIntent’에서 ‘WGPlatform.handleCallback()’를 호출해야 한다. 그렇지 않으면 게임은 일부 상황에서 콜백을 받을 수 없게 된다.**
  
## Step4: 전역 콜백 설정

MSDK는 ‘WGPlatformObserver’ 추상 클래스 중의 방법을 통해 인증, 공유 및 조회 결과를 게임에 콜백하고 게임은 콜백 결과에 따라 UI 등을 조정한다. 콜백을 설정해야 게임은 MSDK 응답을 받을 수 있다.
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

C++ 콜백 설정(**Java 계층 콜백을 설정하면 Java 계층 콜백을 우선적으로 호출하게 된다. C++ 계층 콜백을 사용하려면 Java 계층 콜백을 설정하지 말아야 한다**):

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
		// C++계층 초기화, 반드시 게임 메인 Activity의 onCreate 전에 호출되어야之前함
		WGPlatform::GetInstance()->init(vm);
		WGPlatform::GetInstance()->WGSetObserver(&g_Test);
		return JNI_VERSION_1_4;
	}

**주의:**
게임이 C++ API를 사용하면 ** Java 계층의 전역 콜백을 설정하지 말아야 한다. 그렇지 않으면 SDK는 Java 계층 콜백을 우선적으로 호출하고 C++ 계층의 콜백을 무시하게 된다. 그외, MSDK 콜백은 UI 스레드에 있기에 개발자는 스레드 보안을 자체적으로 확보해야 한다.
	
지금까지 MSDK 패키지 액세스 및 초기화 부분을 설명했다. 게임이 이용하는 각 모듈의 기능은 대응하는 모듈의 액세스 설정과 인터페이스 설명을 읽어야 한다.

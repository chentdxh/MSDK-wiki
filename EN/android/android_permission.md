Access Android
=======

## Description of the package structure

The release package (zip) of MSDK mainly contains two important parts: `MSDKLibrary` and `MSDKSample`. The former is the MSDK library, and the latter is the use examples of MSDK interfaces. MSDKLibrary/jni/CommonFiles/WGPlatform.h contains the descriptions of all the interfaces (java interfaces correspond with C++ interfaces), and the descriptions of some uncommon interfaces can also be seen in the file.

`Recommend`: only use `launchActivity` (the first Activity started by the game) to initialize MSDK and handle the call of MSDK interfaces. If you use multiple Activity to handle the call of the MSDK interfaces, the error that login has no callback can easily occur when MSDK accesses WeChat.

## Step1: Import MSDK package

### Games using Android Library Project

Import `MSDKLibrary` in eclipse: right click the game project - > properties ->Android-> add (libraries) - > select MSDKLibrary. This can complete the import of MSDKLibrary.

### Games not using Android Library Project

#### Access to Java

Games not using Library Project Android need to copy libs and res directories under MSDKLibrary into the corresponding directories of the game project

#### Access to C++

Games not using Library Project Android need to copy libs and res directories under MSDKLibrary into the corresponding directories of the game project, and copy .cpp and .h files under jni directory into the game project and add them to android.mk

** Notes: **

1. After `MSDKLibrary` is imported, package conflicts (repetition) may occur in the compilation process, because MSDK already includes WeChat SDK (`libammsdk.jar`), QQ Internet SDK (`open_sdk.jar`), MTA (`mta-xxx.jar`) and beacon SDK (`beacon-xxx.jar`) and these SDK are all the latest stable versions. If the game integrated these SDK alone in the past, please delete the jar packages integrated before.
2. MSDKSample/assets/msdkconfig.ini is MSDK’s configuration file. It includes the choice of the environment, the configuration of various functional modules, etc. and can be copied to the game project to modify and use according to the needs.

## Step2: Instructions on the configuration

### Configuration of permissions

	<!-- TODO SDK  Access to the required permission modules  START -->
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

	<!-- When you log in to report relevant data, you need to report the device names, too; you can get the device names through the Bluetooth module -->
    <uses-permission android:name="android.permission.BLUETOOTH" />
    <uses-permission android:name="android.permission.BLUETOOTH_ADMIN" />
	<!-- TODO SDK  Access to the required permission modules  END -->

### Modify the configuration file

In assets/msdkconfig.ini, configure the MSDK backend environments (test environment/formal environment) required to access. In the joint debugging stage, the game needs to use a test environment; when it is released, the game needs to switch to a formal environment (closed beta test, OBT, formally launch). When the game switches environments, it is needed to pay attention to that the backend also needs to simultaneously switch into the corresponding environments. The below is the configuration of the test environment for the frontend to access the MSDK backend.

	;for self-developed games or boutique agent games, please use this group of domain names, using one of the domain names
	;msdktest is the test environment’s domain name, and msdk is the formal environment’s domain name
	;MSDK_URL=http://msdk.qq.com
	MSDK_URL=http://msdktest.qq.com

**PS: ** in order to prevent the game from being launched online with the test environment, when SDK detects that the game uses the test or development environment, it will toast a prompt like ** "You are using http://msdktest.qq.com" **. After the game switches into the formal environment’s domain name, this prompt will disappear automatically.

## Step3: MSDK initialization

MSDK initialization is the premise for the implementation of the functions provided by SDK. When the game is started and used, the onCreate method of MainActivity will call MSDK’s initialization function `WGPlatform.Initialized` to initialize MSDK.
For example:

	public void onCreate(Bundle savedInstanceState) {
		...
		//The game must use its own QQ AppId for joint debugging
		baseInfo.qqAppId = "1007033***";
		baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

		// The game must use its own WeChat AppId for joint debugging
		baseInfo.wxAppId = "wxcde873f99466f***"; 
		baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

		//The game must use its own payment offerId for joint debugging
		baseInfo.offerId = "100703***";

        // Since MSDK 2.7.1a, the game can dynamically set the version number in the initialization of msdk, and the version numbers of beacon and bugly are all set by msdk
        // Versions earlier 2.7.1a do not set them
        // 1. Version number = versionName + versionCode
        // 2. If the game does not assign any value to appVersionName (or fill in "") and appVersionCode (or fill in -1),
        // MSDK reads android:versionCode= "51" and android:versionName=”2.7.1" in AndroidManifest.xml by default
        // 3. If the game passes in appVersionName (non empty) and appVersionCode (positive integer) as shown as follows, the version number acquired from beacon and bugly is 2.7.1.271
        baseInfo.appVersionName = "2.7.1";
        baseInfo.appVersionCode = 271;

		WGPlatform.Initialized(this, baseInfo);
		// Set the items which require the user's authorization when QQ is evoked
		WGPlatform.WGSetPermission(WGQZonePermissions.eOPEN_ALL); 

		// Must ensure that handleCallback is behind Initialized
		// Must be called in onCreat() and onNewIntent() of launchActivity
        // WGPlatform.handleCallback(). Otherwise, this can cause that WeChat login has no callback
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


In addition, versions earlier than MSDK2.5 need to load the RQD dynamic library from MainActivty. The sample code for this is as follows:

	// TODO GAME Load the necessary dynamic library
    static {
        System.loadLibrary("NativeRQD"); //the game needs to load the dynamic library; data are used for reporting
        System.loadLibrary("WeGameSample"); // the game does not need this. This is for the own use of MSDKDemo
    }

**Note: **

* MSDK2.5 and higher versions have replaced RQD with Bugly. When the game accesses MSDK2.5 and higher versions, if `libNativeRQD.so` exists in libs file under the original project of the game, it is needed to delete it. And the game does not need to load the “NativeRQD” dynamic library.


** C++ games not only need to initialize SDK in onCreate method of MainActivity, but also need to initialize SDK’s related contents in **`JNI_OnLoad`**. **
All interfaces beginning with WG provide C++ layer and Java layer interfaces. The Java layer is called through `WGPlatform`, and the C++ layer is called through `WGPlatform::GetInstance()`. As for the call methods here, please refer to jni/PlatformTest.cpp.

    GlobalCallback g_Test;
    JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
        WGPlatform::GetInstance()->init(vm);// C++ layer initializes SDK
        WGPlatform::GetInstance()->WGSetObserver(&g_Test);
        return JNI_VERSION_1_4;
    }

	
#### **Note: **

** The game must be sure to call `WGPlatform.handleCallback()` in `onCreat` and `onNewIntent` of `launchActivity`. Otherwise, this can cause the game to fail to receive any callback at some scenarios. **

## Step4: Set global callback

Through the methods of `WGPlatformObserver` abstract class, MSDK can return authorization, share or query results to the game. The game adjusts UI, etc. according to the callback results. Only the callback is set can the game receive responses from MSDK.
Set Java callback:

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

Set C++ callback (** when Java layer callback is set, the game will give priority to call Java layer callback, if the game wants to use C++ layer callback, it should not set Java layer callback * *):

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
		// C++ layer initialization must be called before onCreate of the game’s main Activity is called
		WGPlatform::GetInstance()->init(vm);
		WGPlatform::GetInstance()->WGSetObserver(&g_Test);
		return JNI_VERSION_1_4;
	}

**Note: **
If the game uses C++ API, ** it should not set the global callback of Java layer **, otherwise SDK will give priority to call the Java layer callback but ignore the C++ layer callback. In addition, MSDK’s callback is in the UI thread. Developers need to ensure the thread safety on their own.

By now, the access and initialization of the MSDK package have been completed. When game developers use the modules’ functions, they should read instructions on the access configuration and interfaces of the corresponding modules.
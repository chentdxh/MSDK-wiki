Android 接入
=======

## 包结构说明

MSDK的发布包(zip)主要包含两个重要部分`MSDKLibrary`和`MSDKSample`，前者为MSDK库，后者MSDK接口的使用示例。在MSDKLibrary/jni/CommonFiles/WGPlatform.h中包含了所有的接口说明(java与C++的接口是对应的)，一些不常用在接口的说明可在这个文件中查看。

`推荐`只使用`launchActivity`(游戏启动的第一个Activity)初始化MSDK并处理MSDK接口调用。若使用多个Activity处理MSDK接口调用，在接入微信时容易发生登录无回调的错误。

## Step1: 引入MSDK包

### 使用Android Library Project的游戏

在Eclipse中引入`MSDKLibrary`项目，右击游戏项目->属性->Android->添加(库)->选择MSDKLibrary，完成对MSDKLibrary的引用。

### 不能使用Android Library Project的游戏

#### java接入

不能使用Android Library Project的游戏，需要复制MSDKLibrary下的libs，res两个目录到游戏工程相应目录。

#### C++接入

不能使用Android Library Project的游戏，需要复制MSDKLibrary下的libs，res目录到游戏工程相应目录，并复制jni目录下的 .cpp 和 .h 文件加到游戏工程，并添加到 Android.mk。

**注意事项：**

1. 引入`MSDKLibrary`以后编译发生包冲突(重复)，因为MSDK里面已经包含了 微信SDK(`libammsdk.jar`)，QQ互联sdk(`open_sdk.jar`)，MTA(`mta-xxx.jar`)，灯塔SDK(`beacon-xxx.jar`) 且上述sdk均是其最新稳定版，游戏如果以前有单独集成这些SDK，请删除之前集成的jar包。
2. MSDKSample/assets/msdkconfig.ini 是MSDK的配置文件，包括环境的选择，各部分功能模块的配置等，可以拷贝到游戏工程中按需修改使用。

## Step2: 配置说明

### 权限配置

	<!-- TODO SDK接入必须权限模块 START -->
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

	<!-- 登录上报时需要带设备名称, 通过蓝牙模块来获取设备名称 -->
    <uses-permission android:name="android.permission.BLUETOOTH" />
    <uses-permission android:name="android.permission.BLUETOOTH_ADMIN" />
	<!-- TODO SDK接入 必须权限模块 END -->

### 配置文件修改

在 assets/msdkconfig.ini 中配置访问的需要访问的MSDK后台环境(测试环境/正式环境)，联调阶段游戏需要使用测试环境，发布时需要切换到正式环境(公司内测，公测，正式上线)，切换环境时候需要注意，后台也要同时切换成对应的环境。下面是配置前端访问MSDK后台测试环境。

	;自研游戏或精品代理游戏请使用此组域名, 使用其中一个域名
	;带msdktest为测试环境域名, msdk为正式环境域名
	;MSDK_URL=http://msdk.qq.com
	MSDK_URL=http://msdktest.qq.com
	
**PS:** 为了防止游戏用测试环境上线, SDK内检测到游戏使用测试环境或者开发环境时, 会Toast出类似: **“You are using http://msdktest.qq.com”**这样的提示, 游戏切换成正式环境域名以后此提示自动消失.

## Step3: MSDK初始化

MSDK初始化是使用SDK所提供功能可以执行的前提。游戏在应用启动时MainActivity的onCreate方法中调用MSDK初始化函数`WGPlatform.Initialized`初始化MSDK。
例如：

	public void onCreate(Bundle savedInstanceState) {
		...
		//游戏必须使用自己的QQ AppId联调
		baseInfo.qqAppId = "1007033***";
		baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

		//游戏必须使用自己的微信AppId联调
		baseInfo.wxAppId = "wxcde873f99466f***"; 
		baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

		//游戏必须使用自己的支付offerId联调
		baseInfo.offerId = "100703***";
		WGPlatform.Initialized(this, baseInfo);

		// 必须保证handleCallback在Initialized之后
		// launchActivity的onCreat()和onNewIntent()中必须调用
        // WGPlatform.handleCallback()。否则会造成微信登录无回调
		WGPlatform.handleCallback(getIntent());
		...
	}

    protected void onPause() {
        super.onPause();
        WGPlatform.onPause();
    }

    protected void onResume() {
        super.onResume();
        WGPlatform.onResume();
    }

    protected void onDestroy() {
        super.onDestroy();
        WGPlatform.onDestory(this);
    }

    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        WGPlatform.handleCallback(intent);
    }


此外，MSDK2.5以下版本需要在MainActivty中加载RQD的动态库，示例代码如下：

	// TODO GAME 要加载必要的动态库
    static {
        System.loadLibrary("NativeRQD"); // 游戏需要加载此动态库, 数据上报用
        System.loadLibrary("WeGameSample"); // 游戏不需要这个, 这是MSDKDemo自用的
    }

**注意：**

* MSDK2.5及以上版本已经将RQD替换为Bugly，接入2.5及以上版本时，如果游戏原工程下的libs文件平中存在`libNativeRQD.so`则需要将其删除。并且不需要加载“NativeRQD"动态库。


**C++类游戏除了在MainActivity的onCreate方法中初始化SDK外，还要在 **`JNI_OnLoad`**中初始化SDK相关的内容。**
所有WG开头的接口均提供了C++层和Java层接口。Java层通过`WGPlatform`调用, C++层通过`WGPlatform::GetInstance()`调用。这里调用方式可以参考 jni/PlatformTest.cpp 。

    GlobalCallback g_Test;
    JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
        WGPlatform::GetInstance()->init(vm);// C++层初始化SDK
        WGPlatform::GetInstance()->WGSetObserver(&g_Test);
        return JNI_VERSION_1_4;
    }

	
#### **注意：**

**游戏一定要保证在`launchActivity`的`onCreat`和`onNewIntent`中调用`WGPlatform.handleCallback()`。否则会造成游戏在某些场景下无法收到回调。**
  
## Step4: 设置全局回调

MSDK通过`WGPlatformObserver`抽象类中的方法将授权、分享或查询结果回调给游戏。游戏根据回调结果调正UI等。只有设置回调，游戏才能收到MSDK的响应。
设置Java 回调：

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

设置C++ 回调(**设置了Java层回调会优先调用Java层回调, 如果要使用C++层回调则不能设置Java层回调**)：

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
		// C++层初始化, 必须在游戏主Activity的onCreate之前被调用
		WGPlatform::GetInstance()->init(vm);
		WGPlatform::GetInstance()->WGSetObserver(&g_Test);
		return JNI_VERSION_1_4;
	}

**注意：**
 如果游戏使用C++ API，则**不要再设置Java层的全局回调**，否则SDK会优先调用Java层的回调，忽略C++层回调。另外MSDK的回调在UI线程, 开发者需自己确保线程安全。
	
至此, MSDK包接入与初始化部分完成，游戏使用各模块的功能，还应阅读相应模块的接入配置与接口说明。
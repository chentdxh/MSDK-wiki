MSDK应用宝相关模块
==================


# 应用宝抢号

## 抢号开关配置

在**assets/msdkconfig.ini**中配置客户端抢号开关:

	BETA=true

要从前端关闭抢号功能只需要删除此项设置即可.如下：

	; MSDK可选模块功能开关
	; 应用宝抢号开关
	BETA=false

## 抢号接入步骤

- **第一步：**将MSDKLibrary/res目录下所有以com_tencent_msdk开头的资源文件全都复制到游戏工程对应的目录下.

- **第二步：**在游戏的AndroidMenifest.xml中添加Service声明

```
<service 
	android:name="com.tencent.tmassistantsdk.downloadservice.TMAssistantDownloadSDKService"
    android:exported="false"
    android:process=":TMAssistantDownloadSDKService" >
</service>
```

- **第三步：**在游戏主Acitivity的onResume和onDestroy分别调用MSDK对应方法

```
@Override
protected void onResume() {
    super.onResume();
    WGPlatform.onResume();
}
@Override
protected void onDestroy() {
    super.onDestroy();
    WGPlatform.onDestroy();
}
```

- **第四步：**修改抢号文案为对应游戏名文件路径：**MSDKLibrary\res\values\com_tencent_tmassistant_sdk_strings.xml**修改方法：将下面的**“天天飞车”**改成对应的游戏名即可。
	
```
<string name="white_list_dlg_body">您还没有天天飞车限量内测的资格，快去应用宝抢号吧！</string>
```

平台登陆完成以后回到MSDK, MSDK会发起白名单验证请求, 此请求返回时候. MSDK会通过OnLoginNotify通知游戏, 如果用户在白名单内, 这flag为eFlag_Succ, 此种情况更正常登陆一致; 如果用户不在白名单内, 则flag为eFlag_NotInWhiteList, 返回给游戏同时, MSDK会弹窗引导用户到应用宝抢号.

**PS：验证抢号功能接入成功的方法**
当使用任何一个新的QQ号或微信号登录游戏弹出如下弹框则表示应用宝抢号功能已接入完成：

<div align=center> <img src="./myapp_beta_success.jpg" alt="抢号接入完成" height=640 weight=360> </div>


# 省流量更新

## 省流量更新开关配置

使用更新功能需要在**assets/msdkconfig.ini**中配置开关`SAVE_UPDATE`,如：
	
	; SAVE_UPDATE
	SAVE_UPDATE=true

## 省流量更新接入配置

配置`AndroidManifest.xml`
	
	<service 
		android:name="com.tencent.tmassistantsdk.downloadservice.TMAssistantDownloadSDKService"
        android:exported="false"
        android:process=":TMAssistantDownloadSDKService" >
    </service>

通过应用宝sdk更新游戏包含两种方式: 

- 普通更新, 直接在游戏内从应用宝后台的下载更新包。
- 省流量更新, 也叫增量更新, 这种更新方式需要有应用包客户端。省流量更新是通过文件对比，只给用户更新有变化的部分，进而减小更新包的大小，提高更新成功率。

游戏接入应用宝省流量更新的流程图如下:

![myapp_update](./myapp_update.jpg "应用宝更新的流程图")

## 省流量更新调试

使用应用宝省流量更新有以下几步：

- 第一步: 游戏Activity生命周期埋点  

```
@Override
protected void onResume() {
    super.onResume();
    WGPlatform.onResume();
}
@Override
protected void onDestroy() {
	super.onDestroy();
	WGPlatform.onDestory(this);
}
```

- 第二步: 初始化时设置应用宝省流量更新的全局回调对象,涉及到的回调详细说明见: **MSDKLibrary/jni/CommonFiles/WGSaveUpdateObserver.h**

```
class SaveUpdateCallback: public WGSaveUpdateObserver {
virtual void OnCheckNeedUpdateInfo(long newApkSize, std::string newFeature, long patchSize,
		int status, std::string updateDownloadUrl, int updateMethod) {
	LOGD("SaveUpdateCallback  OnCheckNeedUpdateInfo  "
			"newApkSize: %ld; newFeature: %s; patchSize: %ld; status: %d; updateDownloadUrl: %s; updateMethod: %d",
			newApkSize, newFeature.c_str(), patchSize,
			status, updateDownloadUrl.c_str(),  updateMethod);
}

virtual void OnDownloadAppProgressChanged(long receiveDataLen, long totalDataLen) {
	LOGD("SaveUpdateCallback  OnDownloadAppProgressChanged  receiveDataLen: %ld; totalDataLen: %ld;",
			receiveDataLen, totalDataLen);
}

virtual void OnDownloadAppStateChanged(int state, int errorCode, std::string errorMsg) {
	LOGD("SaveUpdateCallback  OnDownloadAppStateChanged state: %d; errorCode: %d; errorMsg: %s",
			state, errorCode, errorMsg.c_str());
}

virtual void OnDownloadYYBProgressChanged(std::string url, long receiveDataLen, long totalDataLen) {
	LOGD("SaveUpdateCallback  OnDownloadYYBProgressChanged url: %s; receiveDataLen: %ld; totalDataLen: %ld",
			url.c_str(), receiveDataLen, totalDataLen);
}

virtual void OnDownloadYYBStateChanged(std::string url, int state, int errorCode, std::string errorMsg) {
	LOGD("SaveUpdateCallback  OnDownloadYYBStateChanged  url: %s, state: %d, errorCode: %d, errorMsg: %s",
			url.c_str(), state, errorCode, errorMsg.c_str());
}
};
SaveUpdateCallback callback;
JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
	// C++层初始化, 必须在游戏主Activity的onCreate之前被调用
	WGPlatform::GetInstance()->init(vm);
	WGPlatform::GetInstance()->WGSetObserver(&g_Test);
	
    // 设置C++层更新回调
	WGPlatform::GetInstance()->WGSetSaveUpdateObserver(&callback);
	return JNI_VERSION_1_4;
}
```

- 第三步: 调用更新接口更新(选择其中一种使用)

```
	// 调用省流量更新
	WGPlatform::GetInstance()->WGStartSaveUpdate();

	// 调用普通更新
	WGPlatform::GetInstance()->WGStartCommonUpdate();
```

其中涉及到的接口有: `WGCheckNeedUpdate`, `WGStartSaveUpdate`, `WGStartCommonUpdate`, 详细的接口说明如下:

```
/**
 * 开始普通更新, 此种更新不依赖应用宝客户端, 下载进度和状态变化会通过OnDownloadAppProgressChanged和OnDownloadAppStateChanged回调给游戏
 */
void WGStartCommonUpdate();
/**
 * 如果手机上没有安装应用宝则此接口会自动下载应用宝, 并通过OnDownloadYYBProgressChanged和OnDownloadYYBStateChanged两个接口分别回调
 * 如果手机上已经安装应用宝则此接口会拉起应用宝下载有, 下载进度和状态变化会通过OnDownloadAppProgressChanged和OnDownloadAppStateChanged回调给游戏
 */
void WGStartSaveUpdate()
/**
 * @param saveUpdateObserver 省流量更新全局回调, 和更新相关的所有回调都会通过此对象回调
 */
void WGSetSaveUpdateObserver(WGSaveUpdateObserver * saveUpdateObserver);
/**
 * @return void
 * 	 查询结果回调到由WGSetSaveUpdateObserver接口设置的回调对象的OnCheckNeedUpdateInfo方法
 */
void WGCheckNeedUpdate()
```


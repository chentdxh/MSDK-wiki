#MSDK版本历史


Android 主线版本历史
---


###Android 2.2.0变更内容
#### 代码变更：

- 游戏需要关注

	1. MSDK 封装微信个人信息接口
	
	- 接入信鸽推送功能
	
	-  本地关键日志保存及上报
	
- 游戏无需关注：
	1. 修复内置浏览器打开AMS不能分享的问题
	- http报头的User-agent字段加上终端来源信息的需求
	
#### 文档调整：
- 删除
	
	1. 删除第六章微信接入结构化消息分享分享到同玩好友2
	
- 修改

	1. 分享到同玩好友1接口使用带参数extMsdkInfo的函数WGSendToWXGameFriend，之前使用的是不带参数extMsdkInfo的该函数
	
	- 不建议使用第六章微信接入刷新微信accesstoken

### Android 2.1.0 变更内容(内部版本，未外发)

1. Midas Android SDK V1.3.7b版本集成 
2. 修正文档中的错误 
3. 内置浏览器URL附带明文openid 
4. 新增个人位置查询接口 
5. 手Q结构化消息分享图片支持本地路径 
6. LBS城市信息获取 
7. MSDK广告系统一期 



### Android 2.0.1 变更内容
1. 增加登录数据上报, 要求游戏在游戏Activity的onPause中调用 WGPlatform.onPause();
2. 更新应用宝省流量SDK到版本TMAssistantSDK_toMsdk_201407151049.jar
3. 更新灯塔SDK到1.8.10
4. 引入mid-sdk-2.10.jar, 使用mat的mid作为设备id
5. 更新手游宝SDK到 qqgamemi_r226394.jar
6. WGSendMessageToWechatGameCenter接口分享ExtMsdkInfo为null可能会导致crash的bug修复


### Android 2.0.0 变更内容

1. 删除带WGSendToWeixin(const eWechatScene& scene, unsigned char* title, unsigned char* desc, unsigned char* url, unsigned char* mediaTagName, unsigned char* thumbImgData, const int& thumbImgDataLen)接口, 此接口由没有第一个scene参数的接口替代, 平台限制, 防止部分游戏使用此接口分享内容到朋友圈
2. 修改WGLoginWithLocalInfo接口, 提供更方便的非首次登录接入
3. 增加本地定时刷新票据功能, 每10分钟检查一遍, 过期则刷新
4. 优化公告模块, 增加图片、网页公告；增加公告定时拉取
5. 集成了手游宝
6. 修复票据过期时WGGetLoginRecord没有返回openid的问题
7. 优化内置浏览器模块，替换内置浏览器SDK版本；添加下载监听，通过打开新的浏览器进行下载，解决下载时点击无响应的bug

### Android 1.8.3 变更内容
1. 修改推送的命令字(内部修复)
2. 删除wup.jar(内部调整)
3. WGGetLoginRecord即使票据过期也返回open_id


### Android 1.8.2 变更内容
1. 修复某些手机上启动直接Crash的问题(推送模块BUG)

### Android 1.8.1 变更内容

1. 更新opensdk2.3版本
2. AMS传参协议变更(URLEncode改为16进制编码)
3. 添加推送模块

### Android 1.8.0 变更内容

 1. 新增应用宝省流量SDK更新功能
 2. 支持平台拉起自动登录, 同时支持异账号提示
 3. 修正获取pf时始终给后台传递qq appid的问题
 4. 公告模块优化
 

### Android 1.7.0 变更内容

 1、公告二期
 2、增加AMS活动中心接口
 3、微信游戏中心消息改造
 4、异步分享接口回调标识
 5、灯塔手Qappid数据上报
 6、pf改造
 7、删除WGSendToQzone接口
 8、分享接口scene参数由int改为enum
 9、手Q微信音乐分享
 10、微信国家语言信息改造
 11、去网络调度SDK
 12、crash上报回调游戏，支持上报游戏自定义日志
 12、替换OpenSDK版本为2.2解决之前版本存在的安全风险
 
 
Android 2.0 版本历史
---
### Android 2.0.6 变更内容
#### 代码变更：
    1.修复内置浏览器打开AMS不能分享的问题
    		
 
#### 文档调整：

### Android 2.0.5 变更内容
#### 代码变更：
    1.MTA升级
        【修改】更新mta版本到2.0
    2.修复灯塔Crash分析无数据
	【修改】更新eup_1.8.0->eup1.8.0.1并在初始化灯塔时添加CrashReport.setDengta_AppKey(context, qqAppId);
    3.更新米大师到V1.3.8
    4.登录数据统一上报添加新字段		
 
##### 文档调整：
	【删除】删除第六章微信接入分享到同玩好友2
        【修改】分享到同玩好友1接口使用带参数extMsdkInfo的函数WGSendToWXGameFriend，之前使用的是不带参数extMsdkInfo的该函数
        
### Android 2.0.4 变更内容
#### 代码变更：
    1.OpenSDK升级
		【修改】更新opensdk版本到2.5
		【新增】增加手Q游戏内加群加好友接口：WGAddGameFriendToQQ，WGJoinQQGroup，WGBindQQGroup
		【修改】修改WGCheckApiSupport，增加对加群加好友三个接口的支持
    2.手游宝解耦
		【修改】更新手游宝版本到1.2，
		【删除】删除手游宝相关的WGShowQMi、WGHideQMi、WGSetGameEngineType三个接口
    3.内置浏览器分享Bug修复
		【修改】修复内置浏览器分享到手Q/空间时，分享窗口的小图总是显示第一次分享的小图
                【修改】内置浏览器分享时不需要回调到游戏，QQ分享时必须安装有QQ，微信分享时必须安装有微信
    4.增加读取手Q微信版本接口
		【新增】增加获取手Q或者微信版本的接口：WGGetPlatformAPPVersion
#### 文档调整：
	【新增】第五章，手Q接入模块新增第7部分（游戏内加群加好友）
	【新增】增加第十九章，新增部分工具接口说明文档（检测平台是否安装，接口是否支持，获取平台版本，获取渠道号）
	
### Android 2.0.3 变更内容
1. 修复获取蓝牙设备名crash问题

### Android 2.0.2 变更内容
1. 更新支付SDK到1.3.7b
2. 优化手Q大图、音乐分享回调，不再只返回成功
3. 调整手游宝SDK资源
4. 更新rqd版本到eup_1.8.6.jar
5. 独立出mid-sdk-2.10.jar，不合入MSDK的jar包
6. 修复MSDK本地日志可能无法删除的问题
7. 本地日志上报增加BLUETOOTH_ADMIN 的permission

Android 1.8 版本历史
---
### Android 1.8.8 变更内容
1. 将android-support-v4.jar 从MSDK.jar分离出来，放到MSDKLibrary
2. 升级支付SDK1.3.6a版本
3. 修复Logger 中 content为空可能引起的crash

### Android 1.8.7 变更内容
1. 修复电视大厅拉起游戏导致paytoken失效的问题
2. 优化分享参数msdkExtInfo，支持特殊字符
3. 删除枚举eQQScene中无效的参数 QQScene_None
4. 修复音乐分享参数错误可能引起crash
5. 增加MSDK DB 降级的处理

### Android 1.8.6 变更内容
1. 更新支付SDK到1.3.6版本

### Android 1.8.5 变更内容
1. 修复重启以后再次拉起游戏不能启动PUSH的BUG

### Android 1.8.4 变更内容
1. 应用宝省流量SDK更新, 解决via可能错误的问题


Android 1.7 版本历史
---
### Android 1.7.5 变更内容:
 1. 公告增加定时拉取
 2. 优化手Q大图、音乐分享回调，不再只返回成功
 3. 更新opensdk版本到2.5。增加手Q游戏内加群加好友接口：WGAddGameFriendToQQ，WGJoinQQGroup，WGBindQQGroup
 4. 修复音乐分享到手Q没有异帐号的问题

### Android 1.7.4 变更内容:
 1. 删除枚举eQQScene中无效的参数 QQScene_None
 2. 增加MSDK DB 降级的处理
 3. 对分享消息中的masdkExtinfo字段增加url编码
 4. 获取公告取消matid限制、修复获取matId可能引起的crash
 5. 修复Logger 中 content为空可能引起的crash
 6. 修复音乐分享参数错误可能引起crash
 7. 修复获取pf，pf传入空会带-的问题
 8. 升级支付版本到1.3.6a

### Android 1.7.3 变更内容:
 1. 更新支付SDK到1.3.6
 2. 修正手Q拉起微信登录的游戏时, 更新pf时始终使用qqAppId的bug


### Android 1.7.2 变更内容:
 1、更新openSDK到2.3

### Android 1.7.1 变更内容
 1、公告bug修复，请求公告链接使用msdkconfig.ini内配置域名
 2、内置QQ浏览器SDK unity编译失败

Android 1.3 版本历史
---
=====================================修改历史===================================== 1.3.0.13
1. 更新open SDK 2.3

=====================================修改历史===================================== 1.3.0.12
1. 更新支付版本

=====================================修改历史===================================== 1.3.0.11
1. 更新支付版本

=====================================修改历史===================================== 1.3.0.10
1. 更新MTA到1.6.2
2. 请在manifest.xml新增权限：<uses-permission android:name="android.permission.WRITE_SETTINGS" />
3. 修复自动登录情况下手Q可能没有异账号提示的问题


=====================================修改历史===================================== 1.3.0.9
1. 修改pfKey，手Q使用payToken生成，微信使用accessToken生成
2. 修复微信拉起游戏可能没有异账号的问题
3. 修复自动登录情况下拉起微信没有异账号的问题
4. 修复WGGetRegisterChannel接口自动登录情况下会返回 "" 的问题




=====================================修改历史===================================== 1.3.0.7
变更内容:
在1.3.0.6的基础上合入应用宝抢号


Android 1.7 以前主线版本历史
---

=====================================修改历史===================================== 1.6.0
变更内容:
    1. 增加LBS功能, 提供获取附近的人的接口\清除当前位置的接口, 接口分别是WGGetNearbyPersonInfo和WGCleanLocation
	2. 增加新的WGFeedback接口, 此接口只需要填入一个参数, 并且有对应的回调OnFeebackCallback
	3. MSDK前后端数据传输加密
	4. 公告模块增加开关, 开关在assets/msdkconfig.ini中, 配置needNotice的值为true和false分别表示打开和关闭


=====================================修改历史===================================== 1.5.1
变更内容:
    1. 修改pfKey生成方式, 之前手Q和微信都使用accessToken生成pfKey, 改为手Q使用payToken, 微信使用accessToken
	2. 在Java层WGPlatform.java中添加WGGetPaytokenValidTime接口用于获取后台下发的payToken过期时间(老游戏需要则使用, 新游戏不必关心此接口)

=====================================修改历史===================================== 1.5.0
变更内容:
    1、增加公告系统
    2、PayToken有效期由后台下发
    3. WGReportEvent接口优化，支持用户自定义事件按照key-value格式上报
    4. 增加接口wakeUpFromHall；判断游戏唤起是否来源于大厅
    5. MTA-Android-SDK 1.6.2版本集成
    6. 新增内置浏览器
    7  新增WGLoginWithLocalInfo接口, 此接口会自动刷新微信token
    8  增加应用宝抢号支持


=====================================修改历史===================================== 1.3.0.6
变更内容:
1. JNI中内存泄露修复
2. 所有接口调用放到Ui线程中, 回调也全都在Ui线程回调
3. 添加WGSendToQQWithPhoto的实现
4. WGIsPlatformInstalled/WGIsPlatformSupportApi接口参数由_ePlatform改为ePlatform
5. 添加WGLogPlatformSDKVersion接口打印各个平台SDK版本(手Q,微信,MTA,灯塔)
6. 修复了从微信登陆后, kill游戏, 再从最近访问列表里面拉起游戏可能会回调游戏OnLoginNotify的bug
7. 修复本地数据库多线程访问可能被锁导致crash的bug

已接入游戏需要关注的调整: 
1. JNI中内存泄露修复, 游戏需要替换jni目录下的.cpp和.h文件

 
=====================================修改历史===================================== 1.3.0
功能优化: 
	1. 网络请求接口合并，涉及QQ,微信，游戏大厅拉起，将原登录后的几次网络请求合并为一个。
	2. Demo 全面更改，游戏调用代码更直观，模拟游戏登录流程，使手Q，微信帐号体系独立。
	3. WGLogin，WGIsPlatformInstalled，WGIsPlatformSupportApi 三个接口参数改为枚举，WGLogout 接口无参数，与IOS保持统一，

用户需要关注的调整: 
	1. Demo loginActivity 变直观，java ,c++ 调用更简单。
	2. WGLogin，WGLogout 等接口参数，名称有改变，保持与IOS的统一。
	3. 微信WXEntryActivity 改为在msdk 中实现，不暴露给游戏。
	
无需用户关注的调整:
	1. 网络模块优化，请求接口合并
	2. 网络传输协议由jce 统一改为 json 

	
=====================================修改历史===================================== 1.2.7
功能变更: 
	1. 剔除支付SDK部分, 自研和精品代理游戏支付接入请参考MSDK包中payment目录下的非插件版集成支付. dev.4g游戏参考payment目录下的插件版接入

用户需要关注的调整: 
	1. assets/msdkconfig.ini中去除RELEASE和TEST两个域名的设置, 只使用MSDK_URL一个key来设定域名. 详细配置见assets/msdkconfig.ini文件 
	2. 为接入更清晰, MSDK中剔除支付SDK部分, MSDKSample中继续保留MSDK和支付结合使用的示例, 自研和精品代理游戏支付接入请参考MSDK包中payment目录下的非插件版集成支付. dev.4g游戏参考payment目录下的插件版接入

无需用户关注的调整:
	1. MSDK分享图片到微信朋友圈的接口, 缩略图大小由固定的最大边85像素改为支持最大缩略图大小, 32k, 游戏无需关心, 此改动表现为分享出去到微信的图片, 缩略图会更清晰.
	2. 修复登陆时候报Webview接口只能在Ui线程里面调用的警告

	
	
=====================================修改历史===================================== 1.2.6
功能新增: 
	1. 增加MSDK访问后台域名配置, 在assets/msdkconfig.ini中根据文件提示配置域名

用户需要关注的调整: 
	1. 支付SDK更新到1.2.1, MSDKUiLib中的资源文件更新, 不能使用Android Library Project的用户需要手动更新这部分资源文件.
	2. 支付接入需要将sdklib/assets/unipay_tenpay_bin_json放到游戏的assets/目录下
	3. MSDK会对接入配置进行自检, 请游戏使用MSDK Doctor这个Tag过滤, 查看是否有配置的错误信息.
	
无需用户关注的调整:
	1. DB结构改造
	2. 对所有JCE的处理增加try catch
	3. 处理了部分接口必须在有消息循环的线程调用的问题, 解除了此限制
	4. 支付更新版本: 1.2.1
	5. 灯塔更新版本: 1.6.9



=====================================修改历史===================================== 1.2.5
功能新增: 
	1. 增加WGGetPf()接口获取pf, pf会在支付时候用到
	2. 增加onActivityResult接口，需游戏按 demo方式在MainActivity 中的 处理 onActivityResult 方法，否则将收不到手Q的回调。

用户需要关注的调整: 
	1. WGLogin,WGSendToQQ,WGSendToWeixin,WGSendToWeixinWithPhoto,WGRefreshWXToken 这五个接口增加了权限管理功能，调用不成功时，查看log 信息 是否无权限导致。
	2. 改变了手Q的回调实现，防止activity被kill后无回调，去掉manifest 中 QQAcitivity的配置，增加了游戏主Activity中需要实现onActivityResult并在其中调用WGPlatform.onActivityResult调用, 参数透传即可。
	3. pf,pfkey由异步改成获取pf,pfkey 后再回调游戏, 游戏可以在OnLoginNotify回调中获取到pf+pfKey, 之后可以通过WGGetPf和WGGetPfKey两个接口分别获取。

无需用户关注的调整:
	1. 无


=====================================修改历史===================================== 1.2.5
新增: 
	1. 权限控制模块，对5个接口进行了权限管理
	2. 增加onActivityResult接口，需游戏按 demo方式在MainActivity 中的 处理 onActivityResult 方法，否则将收不到手Q的回调。

用户需要关注的调整: 
	1. WGLogin,WGSendToQQ,WGSendToWeixin,WGSendToWeixinWithPhoto,WGRefreshWXToken 这五个接口增加了权限管理功能，调用不成功时，查看log 信息 是否无权限导致。
	2. 改变了手Q的回调实现，防止activity被kill后无回调，去掉manifest 中 QQAcitivity的配置，增加了游戏主Activity中需要实现onActivityResult并在其中调用WGPlatform.onActivityResult调用, 参数透传即可。
	3. pf,pfkey由异步改成获取pf,pfkey 后再回调游戏, 游戏可以在OnLoginNotify回调中获取到pf+pfKey, 之后可以通过WGGetPf和WGGetPfKey两个接口分别获取。

无需用户关注的调整:
	1. 无

=====================================修改历史===================================== 1.2.4
功能新增: 
	1. 增加WGGetPf()接口获取pf, pf会在支付时候用到
	2. 增加WGGetPfKey()接口获取pfKey, pfKey和pf配对, 在支付时会用到
	3. 增加WGGetBestSchedulingIp(SchedulingInfo ipPort, List<String> denyIpList), 调用此接口返回最优游戏接入IP:PORT, 需将MSDKSample中 asserts 目录下ip.data 放入 工程同目录下 打包。
	4. 增加WGIsPlatformInstalled(int platform)和WGIsPlatformSupportApi(int platform), 提供检测平台是否安装和API是否支持

用户需要关注的调整: 
	1. msdk基础包名由com.example.wegame改为com.tencent.msdk, 在Java文件中使用者直接import中的com.example.wegame替换为com.tencent.msdk即可, jni部分替换所有MSDK提供的.h和.cpp文件
	2. Java层Initialized接口参数调整, 将之前各种appid封装到MsdkBaseInfo中, 用户new MsdkBaseInfo()之后分别填入填入对应的ID再调用Initialized.
	3. MSDKUiLib中的资源文件更新, 不能使用Android Library Project的用户需要手动更新这部分资源文件.

无需用户关注的调整:
	1. MTA升级到1.2.0
	2. 支付SDK升级到1.1.2

=====================================修改历史===================================== 1.2.2
功能新增: 
	1. 能够接受QQ游戏大厅拉起时候带过来的票据, 换成openid+accesstoken+paytoken后存入SDK中, 用户可以再接收到OnWakeupNotify时候检测WakeupRet的platform为WeGame.QQHall知道是大厅拉起, 此时用户可以直接调用WGGetLoginRecord接口读取大厅传入的票据并使用此票据让用户登陆.

用户需要关注的调整: 
	1.分离出Java调用和CPP调用的Demo, MsdkJavaDemo, MsdkCppDemo分别展示了SDKJava层调用和Cpp层调用的示例
	2.调整LoginRet, ShareRet, WakeupRet全都继承自CallbackRet, CallbackRet中定义了公用需要返回的东西, OnLoginNotify, OnShareNotify, OnWakeupNotify几个回调中的返回码为flag, 返回信息为desc; 之前ShareRet和WakeupRet中的errorCode字段需要改为flag, 此处为命名的统一, 不影响其他地方
	3.WGPlatformObserver接口中删除没有用到的Init接口, SDK没有调用此接口, 用户如果此接口实现为空, 删除即可
	4.删除WakeupRet中没有用到的code, 如果之前在代码中有使用此字段的用户直接删除这部分不使用即可
	5.以前在MSDKUiLib项目下libs目录中的armeabi/libcftutils.so移动到MSDKSample\jni\prebuilt下, 并在MSDKSample\jni\Android.mk中添加prebuild libcftutils.so的代码, 使用者需要根据自己的情况引入此so
	6.以前在MSDKUiLib/libs下面的jar已经合入到MSDK_Android_1.2.2.jar中, 整个SDK合入只需引入MSDK_Android_1.2.2.jar一个jar包即可
	7.包名com.tencent.msdk
无需用户关注的调整:
	1.PlatformTest方法名变更: login-->WGLogin  // SDKSample的改变, 此变更不影响用户使用
	2.PlatformTest方法名变更: logout-->WGLogout // SDKSample的改变, 此变更不影响用户使用
	3.PlatformTest变更: hasLoginRecord-->WGGetLoginRecord(LoginRet lr) // SDKSample的改变, 更真实的模拟Cpp层调用WGGetLoginRecord接口, 此变更不影响用户使用

=====================================修改历史===================================== 1.2.1
在数据库中保存了QQ登陆返回的pf,pf_key,登陆返回时候会返回到游戏侧, 调用支付接口时会使用到
把closeDb设置为synchronized
合入了支付SDK, 增加了MSDKUiLib项目, 其中包含MSDK需要的所有资源文件
文档中添加支付接入指引和支付接口说明
添加WGRefreshWXToken接口, 在微信accesstoken过期, refresh没过期时用refreshtoken刷新accesstoken
修改Qzone权限项eOpen_None为eOPEN_NONE, eOpen_All为eOPEN_ALL

=====================================修改历史===================================== 1.2.0
添加WGGetRegisterChannelID接口, 在登陆后调用能获取到注册渠道
在Initialized接口中wx_appid和qq_appid后分别添加了对应的appkey需要调用者填入
修复没有安装微信时候返回platform为0的bug
修复分享时没有安装微信会返回LoginRet的BUG

=====================================修改历史===================================== 1.0.20

    添加eFlag_Error
    修改微信错误码透传的问题
    集成了新版灯塔1.6 



=====================================修改历史===================================== 1.0.19

    1. 增加WGTestSpeed接口
    2. 使用灯塔1.6
    3. 使用MTA1.0.0
    4. MTA使用开平APPID, WGGetChannel读取MTA配置的渠道



=====================================修改历史===================================== 1.0.18

新增接口: java层WGTestSpeed
实现功能: 集成灯塔1.6的网络测速功能


=====================================修改历史===================================== 1.0.17

替换微信SDK包
    登陆返回的参数中token名字改为code


=====================================修改历史===================================== 1.0.16
修复WGFeedback接口中潜在的BUG


=====================================修改历史===================================== 1.0.15
使用新的微信SDK包, 登陆返回时的token变为code, 改名, 在WXEntryActivity中做相应修改


=====================================修改历史===================================== 1.0.14
LoginNotify的延迟通知
添加灯塔自定义上报
微信分享时去掉   filePath
修复微信禁止授权时   返回的platform为0的bug
更新互联sdk为外网最新版1.6


=====================================修改历史===================================== 1.0.13
添加WakeupNotify中media_tag_name的返回
设置Observer的地方统一通过setObserver接口设置, 保证延迟回调的正确性
使用新的微信sdk
微信登陆上报时机改为在服务器获取到openId设置到客户端时上报, 避免微信上报登陆的数据中openId为null
手QSDK jar包中有assets文件, 之前没有添加到WeGameSDK的jar包. 添加手Q的assets文件


=====================================修改历史===================================== 1.0.12
延迟Notify机制中, 使用新的标志位来标志是否需要 延迟Notify
在WGSendToWeixin和WGSendToWeixinWithPhoto中添加mediaTagName字段
使用5.8日晚给的最新微信sdk包
所有sendReq的地方去除Options参数

=====================================修改历史===================================== 1.0.11
添加WGEnableReport接口, WGReportEvent接口待协商实现
灯塔默认修改为关闭上报
在SDK初始化时候, 初始化手Q API mTencent, 保证自动登录时候能调用到. 相应的去除QQEntryActivity中的手Q api初始化

=====================================修改历史===================================== 1.0.10
缩略图按比例缩放
使用cpp源码方式集成
修复多次分享内存泄露的bug


=====================================修改历史===================================== 1.0.9
测底移除Sample相关代码
修复在最近使用应用里出现两个游戏图标的bug
在分享时没有安装微信, 或者微信版本太低不支持api, OnShareNotify到上层
Sample完全和SDK分离, 跟新SDK集成文档


=====================================修改历史===================================== 1.0.8
修改图片不能传大图的bug, 现在传4.5m图片成功, 传入9M图片仍然有问题.
在sdk中自动生成缩略图
WXEntryActivity中直做跳转工作, 跳转之后再游戏内部onCreate  onNewIntent中调用handleCallback来处理微信或手Q回调的通知.


=====================================修改历史===================================== 1.0.7
C++接口去掉namespace WeGame
添加WGSetOpenID接口
添加WXEntryActivity的androi:taskAffinity属性, 游戏能正常拉起
换用了微信新的sdk包 libammsdk.jar 
用fatjar打包所有第三方jar包


=====================================修改历史===================================== 1.0.6
删除WGHasLoginRecord, 添加WGGetLoginRecord
LogRet删除appid
设置MainActivity的launcherMode和微胖相同
添加C++的WGGetVersion接口
添加C++WGEnableReport  WGReportEvent接口, 暂时留空

=====================================修改历史===================================== 1.0.5
1. 删除C++中的WGGetVersion接口, WGPlatformTest中的WGGetVersion也删除
2. 在WXEntryActivity的onReq,启动游戏的Launcher Activity
3. 调用登陆时候如果有登陆记录, 是微信登陆的情况下, 只返回refresh token, 不再返回code
4. 删除无用注释


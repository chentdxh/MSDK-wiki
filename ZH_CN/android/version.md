#MSDK版本历史

Android 2.7 版本历史
---

### Android 2.7.2变更内容

#### 代码变更：

- 新增功能：
  - 增加微信大图分享[`使用本地图片路径分享接口`](wechat.md#使用图片路径分享)

- SDK升级：
  - 升级灯塔版本到1.9.4a

- Bug 修复
  - 修复偶现读取版本空指针异常
  - 修复特殊机型下lbs空指针异常
  - 修复应用宝空指针异常

#### 文档变更

- 增加微信大图分享使用本地图片路径分享接口，并修改[**微信大图分享**](wechat.md#大图消息分享)的描述。

###Android 2.7.1变更内容

#### 代码变更：

- 新增功能：
  - 初始化时动态设置版本号

- SDK升级：
  - 升级灯塔版本到1.9.1

- bug 修复：
  - 修复微信登录后保存pf_key值时，将pf值当作pf_key值进行了保存，该bug可能导致支付失败
  - 修复灯塔页面看不到按版本号统计的用户crash率，可以看到总体用户crash率
  - 修复查询群信息C++接口在没有绑定群时，查询结果引起crash的问题

#### 文档调整：
- 调整SDK接入关于[`Step3: MSDK初始化`](android.md#Step3:_MSDK初始化)。其中关于动态版本号设置，即MsdkBaseInfo新增appVersionName和appVersionCode设置。
- 调整SDK接入关于[`MSDK初始化`](android.md#Step3:_MSDK初始化),务必调用WGPlatform.onRestart, WGPlatform.onResume, WGPlatform.onPause,WGPlatform.onStop,WGPlatform.onDestroy。**`这部分内容调整游戏需要特别关注！`**

###Android 2.7.0变更内容

#### 代码变更：

- 新增功能：
	- 增加手Q加群绑群相关的两个接口：[查询QQ群绑定信息](qq.md#查询QQ群绑定信息)和[解绑QQ群](qq.md#解绑QQ群)以及[三个回调](qq.md#加群绑群回调设置)。所有手Q加群绑群接口全部调用MSDK。

- SDK升级：
	- 升级支付到1.3.9e
	- 升级信鸽版本到2.37
	- 升级应用宝省流量更新SDK到 1.1

- bug 修复：
	- 修复金刚审计WxEntryActivity漏洞及信鸽漏洞

- MSDK内部优化：
	- 内置浏览器改用独立进程启用，请务必参照新配置方法进行修改
	- 优化登陆流程,请务必参照新调用方法进行修改。
	- 添加登录时长统计

#### 文档调整：

- 增加手Q加群绑群相关的两个接口：[查询QQ群绑定信息](qq.md#查询QQ群绑定信息)和[解绑QQ群](qq.md#解绑QQ群)以及[三个回调](qq.md#加群绑群回调设置)相关的文档。调整[手Q加群绑群相关问题](qq.md#加群绑群常见问题)
- 优化关于[金刚审计](http://wiki.dev.4g.qq.com/v2/ZH_CN/android/index.html#!jg.md)问题的解决方案
- 调整应用宝模块关于[`省流量更新的内容`](myApp.md)。**`这部分内容调整较多，游戏需要特别关注！`**
- 调整push模块关于[`配置AndroidManifest.xml`](msdkpush.md#接入配置)。其中说明了2.6.1版本接入信鸽需要补充的配置
- 新增push模块关于[`SO库拷贝注意事项`](msdkpush.md#SO库拷贝注意事项)。
- 调整内置浏览器模块关于[`接入配置`](webview.md)。**`这部分内容调整游戏需要特别关注！`**
- 调整登录模块关于[`接入登录具体工作（开发必看）`](login.md#接入登录具体工作（开发必看）)。**`这部分内容调整游戏需要特别关注2.7.0a版本登录调用的说明！`**
- 调整SDK接入关于[`MSDK初始化`](android.md#Step3: MSDK初始化),务必调用onRestart,onResume,onPause,onStop,onDestroy。**`这部分内容调整游戏需要特别关注！`**

Unity版本历史
---

### 2015/5/12
- 发布基于2.6.2a的Unity接口版本,[`下载地址`](http://mcloud.ied.com/wiki/MSDK%E4%B8%8B%E8%BD%BD)(内网)
- 增加[MSDKUnitySample工程使用说明](msdk_android_unity.md#MSDKUnitySample工程使用说明)

### 2015/4/7

- 发布基于2.6.0a的Unity接口版本
- 增加Unity版本的[`接入文档`](msdk_android_unity.md)

Android 2.6 版本历史
---
###Android 2.6.2变更内容

#### 代码变更：

- SDK升级：
	- 升级灯塔版本到v1.9.4(修复因DB游标未关闭引起的crash问题)

#### 文档调整：
- 无



###Android 2.6.1变更内容

#### 代码变更：

- SDK升级：
	- 升级灯塔版本到v1.9.1(修复灯塔无分版本crash率统计的bug)
	- 升级信鸽到v2.37（提高抵达率和修复金刚检测漏洞)

- MSDK内部优化：
	- 优化MSDK微信授权相关逻辑
	
#### 文档调整：
- 调整push模块关于[`配置AndroidManifest.xml`](msdkpush.md#接入配置)。其中说明了2.6.1版本接入信鸽需要补充的配置
- 新增push模块关于[`SO库拷贝注意事项`](msdkpush.md#SO库拷贝注意事项)。
- 调整SDK接入关于[`MSDK初始化`](android.md#Step3:_MSDK初始化),务必调用WGPlatform.onRestart, WGPlatform.onResume, WGPlatform.onPause,WGPlatform.onStop,WGPlatform.onDestroy。**`这部分内容调整游戏需要特别关注！`**

###Android 2.6.0变更内容

#### 代码变更：

- 新增功能：
	- 增加微信扫码登陆（电视大厅游戏使用） 
	- 优化配置读取、公告广告等模块
	- 优化微信票据自动刷新逻辑
	- 优化日志上报逻辑
- SDK升级：
	- 升级openSDK到2.8（修复特定场景授权无回调bug）
	- 升级支付到1.3.9d
- bug 修复：
	- 修复手Q快速登陆跳过应用宝抢号的bug
	- 修复金刚审计弱类型校验的漏洞

#### 文档调整：
- 无

Android 2.5 版本历史
---

###Android 2.5.1变更内容

#### 代码变更：

- Bug 修复

	1. 修复特定机型（目前已知部分Coolpad 7296、朵唯-倾城L1、ETON P5、神州w50t2可能存在）用户无法登陆游戏的bug
	
#### 文档调整：
无

###Android 2.5.0变更内容（建议更新到当前系列最新版本）

#### 代码变更：

- 新增功能：
	- 内置浏览器UI优化
	- 在线时长上报统计
	- MSDK增加对手Q授权过程中游戏被系统杀死的处理
	- **rqd更换为bugly（即crash上报），配置文件中添加CLOSE_BUGLY_REPORT，如果为true，则msdk默认不初始化bugly**
	- 添加对信鸽注册接口的成功率和失败率统计

#### 文档调整：

- 增加：
	- 增加MSDK登陆模块介绍[点击查看](login.md)。内容包括：
		- MSDK授权登陆相关授权登陆、自动登陆、快速登陆等模块梳理
		- MSDK授权登陆相关接口说明、对比及推荐用法。
		- MSDK授权登陆模块接入步骤。
		- MSDK授权登陆模块特殊场景介绍。例如：手Q接入模块增加关于低内存机器授权过程游戏被杀后的登陆方案的说明[点击查看`低内存机器授权过程游戏被杀后的登陆方案`](login.md#其余特殊逻辑处理)。
	- 增加MSDK分享模块介绍[点击查看](share.md)。内容包括：
		- MSDK分享模块接口的分享方法、使用场景、分享效果、点击效果、注意事项的梳理。
		- MSDK分享模块接口与具体游戏使用场景的结合方法。
	- 异帐号模块增加常见问题指引[点击查看](diff-account.md)。
- 修改：
	- 手Q，微信登陆相关模块内容迁移到登陆模块	
	- 异帐号模块关于手Q快速登陆的模块迁移到手Q
	- rqd更换为bugly,数据上报中MSDK Crash上报模块调整[点击查看](rqd.md)。

Android 2.4 版本历史
---

###Android 2.4.2变更内容

#### 代码变更：

- Bug 修复

	1. 修复特定机型（目前已知部分Coolpad 7296、朵唯-倾城L1、ETON P5、神州w50t2可能存在）用户无法登陆游戏的bug
	
#### 文档调整：
无

###Android 2.4.1变更内容（建议更新到当前系列最新版本）

#### 代码变更：

- SDK升级：

	1. 调整OpenSDK至v2.6
	2. 升级浏览器SDK版本到 1.2
	
- 新增功能：
	- 无
- **接口调整：**
	- 无

#### 文档调整：

- 增加：
	- 公告模块关于[展示公告接口`WGShowNotice`](notice.md#展示公告接口)和[获取公告数据接口`WGShowNotice`](notice.md#获取公告数据接口)的文档有调整，增加调整后接口的使用说明

###Android 2.4.0变更内容（建议更新到当前系列最新版本）

#### 代码变更：

- SDK升级：

	1. 更新Midas版本到1.3.9b
	2. 更新OpenSDK至v2.7
	3. 更新手游宝到1.5.1
	
- 新增功能：
	- 增加游戏登陆注销的回调给手游宝
- **接口调整：**
	- 公告模块修改[展示公告接口`WGShowNotice`](notice.md#展示公告接口)和[获取公告数据接口`WGShowNotice`](notice.md#获取公告数据接口)，删除参数noticeType。

#### 文档调整：

- 增加：
	- 公告模块关于[展示公告接口`WGShowNotice`](notice.md#展示公告接口)和[获取公告数据接口`WGShowNotice`](notice.md#获取公告数据接口)的文档有调整，增加调整后接口的使用说明

Android 2.3 版本历史
---

###Android 2.3.4变更内容

#### 代码变更：

- Bug 修复

	1. 修复2.0.4a以上2.0版本升级到2.3可能会引起crash的bug
	
#### 文档调整：
无


###Android 2.3.3变更内容（建议更新到当前系列最新版本）

#### 代码变更：

- Bug 修复

	1. 修复特定机型（目前已知部分Coolpad 7296、朵唯-倾城L1、ETON P5、神州w50t2可能存在）用户无法登陆游戏的bug
	
#### 文档调整：
无

###Android 2.3.2变更内容（建议更新到当前系列最新版本）

#### 代码变更：

- SDK升级

	1. 更新Midas版本到1.3.9d
	
#### 文档调整：
无

###Android 2.3.1变更内容（建议更新到当前系列最新版本）

#### 代码变更：

- SDK升级

	1. 更新Midas版本到1.3.9a
	2. 更新内置浏览器到v1.2
	3. 更新rdm到1.8.3
	4. 更新手游宝到1.4.1
	
#### 文档调整：
无

###Android 2.3.0变更内容（建议更新到当前系列最新版本）

#### 代码变更：


- SDK升级

	1. 更新Midas版本到1.3.8c
	- 更新OpenSDK至v2.6.1

- 新增功能
    1. 增加API
		- 分享Url到微信，WGSendtoWeixinWithUrl
		- 游戏QQ群绑定，WGBindQQGroup
		- 游戏内加群，WGJoinQQGroup
		- 游戏内加好友，WGAddFriendToQQ
		- 获取微信或手Q版本，WGGetPlatformAPPVersion
		- 返回接口支持情况，WGCheckApiSupport，参数增加至四个，分别为eApiName_WGSendToQQWithPhoto=0,eApiName_WGJoinQQGroup=1,eApiName_WGAddGameFriendToQQ=2,eApiName_WGBindQQGroup=3
    - 添加微信accesstoken自动刷新开关配置
    - 新增Dop广告数据上报统计	
- 功能调整
	1. 手游宝解耦
		1. 更新手游宝版本到1.2
		2. 删除手游宝相关的WGShowQMi、WGHideQMi、WGSetGameEngineType三个接口
- BUG修复
    - 删除过期广告时未将本地图片删除

#### 文档调整：

- 增加：
	1. 手Q接入模块新增第7部分（游戏内加群加好友）
	2. 微信接入模块新增第7部分（URL分享（朋友圈/会话）
	3. 新增部分工具接口说明文档（检测平台是否安装，接口是否支持，获取平台版本，获取渠道号）
	4. 接入SDK信鸽推送功能
- 修改：
	1. 微信接入增加注意事项：如不需要微信accesstoken自动刷新功能，在assets\msdkconfig.ini中，将WXTOKEN_REFRESH设为false即可

Android 2.2 版本历史
---
###Android 2.2.0变更内容 (内部版本，未外发)

#### 代码变更：

- 新增功能
	1. MSDK 封装微信个人信息接口
	- 接入信鸽推送功能
	- 本地关键日志保存及上报
- BUG修复
	1. 修复内置浏览器打开AMS不能分享的问题
	- http报头的User-agent字段加上终端来源信息的需求
	
#### 文档调整：
- 删除
	1. 删除第六章微信接入结构化消息分享分享到同玩好友2
- 修改
	1. 分享到同玩好友1接口使用带参数extMsdkInfo的函数WGSendToWXGameFriend，之前使用的是不带参数extMsdkInfo的该函数
	- 不建议使用第六章微信接入刷新微信accesstoken


Android 2.1 版本历史
---
### Android 2.1.0 变更内容(内部版本，未外发)
#### 代码变更：

1. Midas Android SDK V1.3.7b版本集成 
- 修正文档中的错误 
3. 内置浏览器URL附带明文openid 
4. 新增个人位置查询接口 
5. 手Q结构化消息分享图片支持本地路径 
6. LBS城市信息获取 
7. MSDK广告系统一期 

Android 2.0 版本历史
---

### Android 2.0.6 变更内容
#### 代码变更：

1. 修复内置浏览器打开AMS不能分享的问题
- 支付SDK升级到1.3.8c
- 修复游戏大厅拉起游戏以后手游宝无法登陆的bug
- 调整MSDK的公告模块默认为开启	
- 所有登录接口调用都添加deviceinfo上报
- 内置浏览器移除接口searchBoxJavaBridge_，通过金刚审计检测

#### 文档调整：
无
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

#MSDK版本历史

Android 2.3 版本历史
---
###Android 2.3.0变更内容 (测试中，尚未发布)

#### 代码变更：

- 新增功能

	1. Midas升级
		1. 更新Midas版本到1.3.8c
	- OpenSDK升级
		- 更新至v2.6.1
    - 增加API
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
###Android 2.2.0变更内容 (测试中，尚未发布)

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

### Android 2.0.6 变更内容 (测试中，尚未发布)
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

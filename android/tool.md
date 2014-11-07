MSDK 基础工具类
======

检查手Q/微信是否安装
------
调用WGIsPlatformInstalled接口会返回检测的平台是否安装。接口详细说明如下:
#### 接口声明：

	/**
	 * @param platformType 游戏传入的平台类型, 可能值为: ePlatform_QQ, ePlatform_Weixin
	 * @return 平台的支持情况, false表示平台未安装, true则表示已经安装
	 */
	bool WGIsPlatformInstalled(ePlatform platformType);

#### 接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGIsPlatformInstalled((ePlatform) platform);


获取手Q/微信版本
------
调用WGGetPlatformAPPVersion接口会返回当前安装的平台对应的版本。接口详细说明如下：
#### 接口声明：

	/**
	 * @return APP版本号
	 */
	const std::string WGGetPlatformAPPVersion(ePlatform platform);

#### 接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGGetPlatformAPPVersion((ePlatform) Platform);

检查接口在用户安装手Q/微信上是否支持
------
调用WGCheckApiSupport接口会返回一个指定类型的当前有效的公告数据的列表。接口详细说明如下：
#### 接口声明：

	/**
	 * @return 接口的支持情况
	 * @param
	 * eApiName_WGSendToQQWithPhoto = 0,
	 * eApiName_WGJoinQQGroup = 1,
	 * eApiName_WGAddGameFriendToQQ = 2,
	 * eApiName_WGBindQQGroup = 3
	 */
	bool WGCheckApiSupport(eApiName);

#### 接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGCheckApiSupport((eApiName) jApiName);

获取MSDK版本
------
调用WGGetVersion接口会返回MSDK的版本号。接口详细说明如下：
#### 接口声明：

	/**
	 * 返回MSDK版本号
	 * @return MSDK版本号
	 */
    const std::string WGGetVersion();

#### 接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGGetVersion();

获取安装渠道
----------

调用WGGetChannelId会返回游戏的安装渠道。接口详细说明如下：
#### 接口声明：

	/**
	 * @return 安装渠道
	 */
	const std::string WGGetChannelId();

#### 接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGGetChannelId();

获取注册渠道
----------

调用WGGetRegisterChannelId会返回用户的注册渠道。接口详细说明如下：
#### 接口声明：

	/**
	 * @return 注册渠道
	 */
	const std::string WGGetRegisterChannelId();

####接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGGetRegisterChannelId();

本地日志
------

#### 1、概述
该模块在2.0.0版本以后提供，游戏可以通过开关控制是否打印MSDK相关的Log。
#### 2、配置方式
本地日志模块默认为关闭,需要使用该模块的游戏需要在assets/msdkconfig.ini中将localLog一项的值按照需求设置为对应的值。

| 开关数值 | Log模式 |
|: ------- :|: ------- :|
| 0 | 不打印 |
| 1 | logcat打印 |
| 2 | 打印到本地文件，不在logcat打印 |
| 3 | logcat和本地文件同时打印 |	
MSDK 基础工具类
===

##检查手Q/微信是否安装
- ###概述
调用WGIsPlatformInstalled接口会返回检测的平台是否安装。

```
	/**
     * @param platformType 游戏传入的平台类型, 可能值为: ePlatform_QQ, ePlatform_Weixin
     * @return 平台的支持情况, false表示平台不支持授权, true则表示支持
     */
    bool WGIsPlatformInstalled(ePlatform platformType);
```

- ###示例代码
调用代码如下:

```
	WGPlatform::GetInstance()->WGIsPlatformInstalled((ePlatform) platform);
```
---

##获取手Q/微信版本
- ###概述
调用WGGetPlatformAPPVersion接口会返回当前安装的平台对应的版本。

```
	/**
     * @return APP版本号
     */
    const std::string WGGetPlatformAPPVersion(ePlatform platform);
```

- ###示例代码
接口调用示例：

```
	WGPlatform::GetInstance()->WGGetPlatformAPPVersion((ePlatform) Platform);
```
---

##获取MSDK版本
- ###概述
调用WGGetVersion接口会返回MSDK的版本号。

```
	/**
     * 返回MSDK版本号
     * @return MSDK版本号
     */
    const std::string WGGetVersion();
```

- ###示例代码
接口调用示例：

```
	WGPlatform::GetInstance()->WGGetVersion();
```
---

##获取安装渠道
- ###概述
调用WGGetChannelId会返回游戏的安装渠道。

```
	/**
     * 如果没有再读assets/channel.ini中的渠道号, 故游戏测试阶段可以自己写入渠道号到assets/channel.ini用于测试.
     * IOS返回plist中的CHANNEL_DENGTA字段
     * @return 安装渠道
     */
    const std::string WGGetChannelId();
```

- ###示例代码
接口调用示例：


```
	WGPlatform::GetInstance()->WGGetChannelId();
```
---

##获取注册渠道
- ###概述
调用WGGetRegisterChannelId会返回用户的注册渠道。

```
	/**
	 * @return 注册渠道
	 */
	const std::string WGGetRegisterChannelId();
```

- ###示例代码
接口调用示例：

```
	WGPlatform::GetInstance()->WGGetRegisterChannelId();
```
---

##Url添加加密票据
- ###概述
通过内置浏览器打开的第一个页面的Url中会添加经过MSDK加密的票据(参考[内置浏览器](webview.md#透传参数说明))，2.10.0i版本后增加了**Url添加加密票据**接口。使用此接口可在传入的Url后自动添加经过MSDK加密的票据，可满足游戏使用自定义浏览器通过Url安全获取票据的需求。加密后的票据如何解密请参考内置浏览器文档的[加密传输登录态参数](webview.md#加密传输登录态参数)。

```
	/*
     * 加密Url，返回票据加密后的url
     * @param openUrl 需要增加加密参数的url
     */
    const std::string WGGetEncodeUrl(unsigned char * openUrl);
```

- ###示例代码
接口调用示例：

```
 	std::string encodeUrl = WGPlatform::GetInstance()->WGGetEncodeUrl((unsigned char*)"http://www.qq.com");
```
---

##控制台日志
- ###概述
该模块在2.0.0版本以后提供，游戏可以通过开关控制是否打印MSDK相关的Log。

```
	/**
     *
     *  @param enabled true:打开 false:关闭
     */
    void WGOpenMSDKLog(bool enabled);
```

- ###示例代码
接口调用示例：

```
 	WGPlatform::GetInstance()->WGOpenMSDKLog(true);
```


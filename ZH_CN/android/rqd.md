MSDK Crash上报模块
===
概述
---
Crash上报在MSDK2.5a之前（不包括MSDK2.5a)使用的是RQD上报，上报成功后具体crash详细堆栈只能在 http://rdm.wsd.com/ 上查看，必须是腾讯公司员工用RTX登录进行查看，非自研游戏查看起来非常不方便。自MSDK2.5及以后使用的bugly上报，此时可以在 http://bugly.qq.com/ 上进行查看。可使用QQ账号绑定相关应用，这样，非自研游戏可以方便的查看。当然，在 http://rdm.wsd.com/ 同样是可以查看的。游戏无需额外操作，只是关闭crash上报的开关不一致而已，具体请参照**RQD上报开关设置**和**Bugly上报开关设置**。

RQD上报开关设置
---
打开和关闭rdm数据上报的设置函数:

     public static void WGEnableCrashReport(boolean bRdmEnable, boolean bMtaEnable)

在WGPlatform里面有这个函数，如果将bRdmEnable设为false（bMtaEnable可设为false），则关闭rdm crash上报，默认情况下crash上报是开启的，因此无需调用该函数。

Bugly上报开关设置
---
打开和关闭bugly上报的开关需要在/assets/msdkconfig.ini中设置

      ;关闭bugly上报开关，默认应将其设为false，设为true即关闭了crash上报功能
      CLOSE_BUGLY_REPORT=false



在RDM平台上查看Crash数据
---
####注册绑定

如果是DEV注册的游戏会自动注册RDM，不需要手动注册; 手动注册，直接登录RDM，点击异常上报模块，配置一下产品 BoundID 即可。

步骤：登录[http://rdm.wsd.com/](http://rdm.wsd.com/), 进入你们的产品 -> 异常上报，如果未注册会提醒如图：

![rdmregister](./rmdregister.png)

其中，boundID 就是你的AndroidManifest中的packageName。未注册的产品，数据上报时直接丢弃。

具体请咨询rdm小秘书，android问题可联系spiritchen

####如何查看上报数据
- 网址:[http://rdm.wsd.com/](http://rdm.wsd.com/)->异常上报->问题列表

![rdmwsd](./rdmwsd.png)
![rdmdetail](./rdmdetail.png)


在bugly平台上查看Crash数据
---
- 网址:[http://rdm.wsd.com/](http://rdm.wsd.com/)->用QQ账号登录->选择相应的App

![bugly](./bugly1.png)

Crash上报添加额外业务日志
---

当程序Crash时，有时需要添加一些额外的业务日志，随crash日志一起上报到http://rdm.wsd.com/ 平台，这样可以更好的定位造成crash的原因。最终可以在rdm平台上查看错误详情，其中额外业务日志保存在extraMessage.txt中。bugly暂未开放查看extraMessage.txt的功能，目前正在开发中。

![rqd](./rqd_extramsg.png)

要完成此功能只需要在全局observer(即WGPlatformObserver)中添加回调函数OnCrashExtMessageNotify。java按如下方式调用：

    @Override
    public String OnCrashExtMessageNotify() {
      // 此处游戏补充crash时上报的额外信息,用于帮忙分析产生crash的原因
      // 例如，String str = "test extra crash upload!";
      // 如果不需要，请填写为String str = ""
      String str = "test extra crash upload!";
      return str;
    }

cpp按如下方式调用：

    virtual std::string OnCrashExtMessageNotify() {
    	// 此处游戏补充crash时上报的额外信息,用于帮忙分析产生crash的原因
    	// 例如，std::string str = "test extra crash upload!";
    	// 如果不需要，请填写为std::string str = ""
    	std::string str = "test extra crash upload!";
    	LOGD("OnCrashExtMessageNotify test %s", str.c_str());
    	return str;
    }


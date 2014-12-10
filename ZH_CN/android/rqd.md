MSDK RQD(RDM) 相关模块
===


RQD接入配置
---
一、接入时需要loadlibrary:![loadlibrary](./rdmloadlibrary.png)
添加了这个才会有native crash的上报

二、打开和关闭rdm数据上报的设置函数:

     public static void WGEnableCrashReport(boolean bRdmEnable, boolean bMtaEnable)

在WGPlatform里面有这个函数，如果将bRdmEnable设为false（bMtaEnable可设为false），则关闭rdm crash上报，默认情况下crash上报是开启的，因此无需调用该函数。

Crash数据上报查询
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

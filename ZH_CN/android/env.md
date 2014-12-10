开发环境配置
===

概述
---

这部分内容主要协助游戏明确一些开发环境相关的配置

C++编译配置
---
#### 概述：

MSDK的C++接口由JNI实现，使用MSDK的C++接口的游戏在集成时，需要使用NDK完成编译，MSDK直接向游戏游戏提供源码编译.MSDK提供了NDK环境配置和完成编译的事例，游戏可以参照修改。

#### Eclipse 环境配置：

选择 **window -> preferences -> Android -> NDK**,按照下图配置

![NDK配置](./ndk.png "ndk 配置")

备注：在最新的adt版本（adt-bundle-windows-x86-20140702）中没有集成ndk，游戏在Android选项中可能无法看到上述配置。解决方法如下：

1. 下载eclipse关于ndk的插件[com.android.ide.eclipse.ndk_23.0.2.1259578.jar](https://github.com/bihe0832/Settings-Tools/tree/master/adt/plugins)
2. 将下载好的`com.android.ide.eclipse.ndk_23.0.2.1259578.jar` 放入adt目录下的 `\eclipse\plugins`中，重启eclipse。

#### 代码引入：

游戏需要复制`MSDKLibrary/jni`目录下的.cpp和.h文件加到游戏工程

#### makefile 配置：

游戏在引入代码以后需要同时将相关代码添加到makefile。游戏可以根据实际情况将`MSDKLibrary/jni`下面的Android.mk中的配置信息引入到游戏的makefile文件或者Android.mk。


接入配置自检
---

#### 概述：

游戏接入中开发同学经常会直接复制、粘贴MSDK的demo的代码，导致有时候会把部分MSDK的demo相关的配置内容一起拷贝到游戏工程，触发一些异常。因此MSDK增加了一个内部检查模块，游戏开发中可以借助这部分功能来减少一些接入成本。

####使用方法：

当游戏连接的环境为联调或者测试环境时，MSDK在初始化的时候配置检查模块会去检查一些常见设置是否有误。游戏可以通过查看logcat的内容查看：

- **当游戏存在配置错误的时候的log事例：**

		11-18 17:10:47.373: E/WeGame CheckBase.queryIntentFilter(9855): Msdk: the intent-filter of com.tencent.tauth.AuthActivity has not be configured correctly
		11-18 17:10:47.373: E/WeGame CheckBase.queryIntentFilter(9855): Msdk: the intent-filter of com.tencent.tauth.AuthActivity has not be configured correctly
		11-18 17:10:47.393: W/WeGame WeGame.Initialized(9855): MSDK Config Error!!!!
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): Check Result: 2
		11-18 17:10:47.403: D/WeGame WeGame.Initialized(9855):  ********************check result start********************
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): QQ AppID for Initialiezed must be the same as configed in AndroidMenifest.xml
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): AuthActivity Category Error
		11-18 17:10:47.403: D/WeGame WeGame.Initialized(9855):  ********************check result end**********************

- **当游戏基本配置都没有问题的时候的log事例：**

		11-18 17:15:16.825: W/WeGame WeGame.Initialized(13524): Check Result: 0

#### 备注：

- 该模块的检查结果**仅供游戏开发参考**，所有配置检查为强检查，游戏根据检查结果和游戏自身需求修改对应的配置检查项的内容。游戏无须完全解决所有的配置检查问题。
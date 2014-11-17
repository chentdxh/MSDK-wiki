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
MSDK(iOS) for Unity3D 接入
===

## 概述

MSDK的Unity3D版本是使用Unity3D引擎对MSDK的接口的C#封装。使用此版本游戏可直接在C#层调用MSDK的接口，减少手机平台相关的操作。

MSDK(iOS)的Unity发布包(zip)主要包含`UnityCode`、`MSDKDemo`及`MSDKUnityPlugin.unityPackage`。如下图所示：

![ImportPackage](./Unity_PackageStruct.png)

其中`UnityCode`是调用MSDK的C#接口的Unity3D示例工程，可参考`Assets\MSDKDemo.cs`了解MSDK接口的调用。`MSDKDemo`是UnityCode导出为Xcode工程后的MSDK示例工程。`MSDKUnityPlugin.unityPackage`是此版本的Unity资源包，包含MSDK的C#接口。

## 接入配置

### Step1:引入C#接口

在Unity3D的IDE中打开游戏工程，双击`MSDKUnityPlugin.unityPackage`，选择需要的文件导入，如下图：

![ImportPackage](./unity_ImportPackage.png)

**注意：**
导入过程文件如果已经存在不会进行覆盖，所以更新版本时，请务必先删除插件的内容

### Step2:挂载脚本

选择第一个或主场景(Scene)，新建一个空游戏对象(GameObject)，命名为MSDKMessage。打开Plugins/iOS目录，将MSDKMessage.cs脚本文件拖动到新建的游戏对象上进行脚本挂接。

### Step3:接口调用

在Unity3D中，与MSDK iOS有关的部分放在Assets/Plugins/iOS文件夹下：

![ImportPackage](./Unity_Interface.png)

与Android通用的文件放在Assets/Plugins/Msdk文件夹下：

![ImportPackage](./Unity_Interface2.png)

MSDK API都封装在WGPlatform类，回调都封装在MSDKMessage类。在"UnityCode"中`MSDKDemo.cs`是对MSDK的C#接口的调用示例，游戏可参考此类进行C#接口调用。

现在以QQ登陆为例，演示如何调用MSDK API与处理回调：

    // Msdk的命名空间
    using Msdk;
    // LitJson的命名空间
    using LitJson;
    // WGPlatform类采用单例设计
    WGPlatform.Instance.WGLogin(ePlatform.ePlatform_QQ);      // 登陆QQ
    
接下来处理登陆回调（在MSDKMessage里，该登陆回调方法命名为OnLoginNotify)

	/// <summary>
	///  登陆回调
	/// </summary>
	/// <param name="jsonRet">Json ret.</param>
	void OnLoginNotify(string jsonRet)
	{
		Debug.Log ("\n\nUnity Receive Message From iOS\n\n OnLoginNotify = " + jsonRet);
		LoginRet ret = LoginRet.ParseJson (jsonRet);
		if (ret == null) 
		{
			Debug.Log ("登陆失败");
			return;
		}
		
		Debug.Log ("OnLoginNotify" + ret.ToString());
		/*
		 *  loginRet.platform表示当前的授权平台, 值类型为ePlatform, 可能值为ePlatform_QQ, ePlatform_Weixin,ePlatform_Guest
	 	 *     loginRet.flag值表示返回状态, 可能值(eFlag枚举)如下：
		 *       eFlag_Succ: 返回成功, 游戏接收到此flag以后直接读取LoginRet结构体中的票据进行游戏授权流程.
		 *       eFlag_QQ_NoAcessToken: 手Q授权失败, 游戏接收到此flag以后引导用户去重新授权(重试)即可.
		 *       eFlag_QQ_UserCancel: 用户在授权过程中
		 *       eFlag_QQ_LoginFail: 手Q授权失败, 游戏接收到此flag以后引导用户去重新授权(重试)即可.
		 *       eFlag_QQ_NetworkErr: 手Q授权过程中出现网络错误, 游戏接收到此flag以后引导用户去重新授权(重试)即可.
		 *     loginRet.token是一个List<TokenRet>, 其中存放的TokenRet有type和value, 通过遍历Vector判断type来读取需要的票据. type(TokenType)类型定义如下:
		 *       eToken_QQ_Access,
		 *       eToken_QQ_Pay,
		 *       eToken_WX_Access,
		 *       eToken_WX_Refresh
		 */
		switch (ret.flag)
		{
		case eFlag.eFlag_Succ:				
		case eFlag.eFlag_WX_RefreshTokenSucc:
			Debug.Log ("登陆成功");
			break;
		case eFlag.eFlag_Local_Invalid:
			// 自动登录失败, 需要重新授权, 包含本地票据过期, 刷新失败登所有错误
			Debug.Log ("自动登陆失败");
			break;
		case eFlag.eFlag_WX_UserCancel:
		case eFlag.eFlag_WX_NotInstall:
		case eFlag.eFlag_WX_NotSupportApi:
		case eFlag.eFlag_WX_LoginFail:
		default:
			Debug.Log ("登陆失败");
			break;
		}
	}

### Step4:导出为Xcode工程，copy接口文件

将Unity工程导出为Xcode工程，从MSDKDemo/Classes/NeedFiles/中copy下图中的四个文件至Xcode工程中。

![ImportPackage](./Unity_NeedFiles.png)

### Step5:接入MSDK各framework

按需接入MSDK各个framework。


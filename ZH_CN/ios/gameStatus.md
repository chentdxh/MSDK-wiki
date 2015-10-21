MSDK 游戏关键场景设置模块
===

模块介绍
---

### 概述
MSDK 游戏关键场景设置模块主要用于准确定位到游戏的具体场景，目前主要用于游戏的Crash场景分析。用于准确定位当游戏发生Crash时，用户所处的使用场景。目前统计范围包括登陆、分享、支付、游戏单局等场景。

## 接入须知（重要，接入必看）

1. 该函数的参数为String类型，建议游戏优先使用MSDK官方提供的参考值。具体的值可以查看[游戏常用场景值](gameStatus.md#游戏常用场景值)。
2. 对一同一游戏场景，游戏进入场景和退出场景时的GameStatus参数要一致，否则会导致场景无法退出一直记录下来。
3. 建议游戏在场景一开始的处理逻辑优先设置场景，然后再完成场景对应的逻辑代码；在离开时优先处理场景逻辑，最后再退出场景。可以保证准备的记录游戏场景。

## 接口说明

### 设置游戏当前场景开始点接口

该接口在游戏开始进入指定的场景的时候调用。标示当前用户操作的实际场景。

#### 接口声明：
	
	/**
	 * 设置游戏当前所处的场景开始点
	 * @param cGameStatus 场景值，MSDK提供的场景值请参考GameStatus的定义，游戏也可以自定义场景参数
	 */
	 
	 void WGStartGameStatus(unsigned char* cGameStatus);

#### 接口调用：

	cGameStatus ＝ "MSDKGamePre";
	WGPlatform::GetInstance()->WGStartGameStatus((unsigned char *)cGameStatus.c_str());
	
#### 注意事项：



### 设置游戏当前场景结束点接口

该接口在游戏退出指定场景时，所有的操作结束的时候调用。标示当前用户离开之前进入的实际场景。

#### 接口声明：
	
	/**
	 * 设置游戏当前所处的场景结束点
	 * @param cGameStatus 场景值，MSDK提供的场景值请参考GameStatus的定义，游戏也可以自定义场景参数
	 * @param succ 游戏对该场景执行结果的定义，成功为0、失败为-1、异常为-2。
	 * @param errorCode 游戏该场景异常的错误码，用户标识或者记录该场景失败具体是因为什么原因
	 */
	 
	 void WGEndGameStatus(unsigned char* cGameStatus, int succ, int errorCode);

#### 接口调用：

	cGameStatus ＝ "MSDKGamePre";
	cSucc = 0；
	cErrorCode＝ 0；
	WGPlatform::GetInstance()->WGEndGameStatus((unsigned char *)cGameStatus.c_str(),cSucc,cErrorCode);

#### 注意事项：

- **`在接口调用中标识用户离开场景的状态的参数succ的取值为：成功为0、失败为-1、异常为-2。`**

## 游戏常用场景值


| 对应场景 | 场景说明 | 参数值 |
|: ------------- :|
| 拉起支付| 从用户点击支付按钮到在支付界面选择购买的商品 | MSDKPayLauncher |
| 用户付款| 从用户选择购买的商品到发起支付的请求 | MSDKPayIng |
| 支付回调| 从用户发起支付到游戏处理完支付回调 | MSDKPayNotify |
| 用户登陆| 从用户触发登陆到游戏处理完自身的登陆逻辑 | MSDKGameLogin |
| 单局游戏准备| 从用户点击开始单局游戏到开始游戏的准备阶段 | MSDKGamePre |
| 单局游戏中| 从用户开始单局游戏到单局游戏结束的阶段 | MSDKGameIng |
| 单局游戏暂停| 从单局游戏暂停到再次恢复的阶段 | MSDKGamePause |
| 单局游戏结算| 从单局游戏结束到单局游戏结算结束的阶段 | MSDKGameCalculate |
| 单局对局准备| 从用户点击开始单局对局到开始对局的准备阶段 | MSDKPvPre |
| 单局对局中| 从用户开始单局对局到单局对局结束的阶段 | MSDKPvIng |
| 单局对局暂停| 从单局对局暂停到再次恢复的阶段 | MSDKPvPause |
| 单局对局结算| 从单局对局结束到单局对局结算结束的阶段 | MSDKPvCalculate |
| 购买道具| 从用户点击道具到购买结束 | MSDKItemPurchase |

## 测试验证

#### 控制台Log日志

MSDK会在游戏进入、退出、修改场景的时候打印一条log日志。该日志以MSDK_STATU作为Tag标签。例如：

	2015-09-17 20:15:09.260 MSDKDevDemo[91596:13718176] -[MSDKCrashReportModule startGameStatus:]# MSDK_STATUS:MSDKGamePre START
	2015-09-17 20:15:09.260 MSDKDevDemo[91596:13718176] -[MSDKCrashReportModule endGameStatus:succ:errorCode:]# MSDK_STATUS:MSDKGamePre END
	2015-09-17 20:15:09.260 MSDKDevDemo[91596:13718176] -[MSDKCrashReportModule startGameStatus:]# MSDK_STATUS:MSDKGameIng START
	2015-09-17 20:15:09.260 MSDKDevDemo[91596:13718176] -[MSDKCrashReportModule endGameStatus:succ:errorCode:]# MSDK_STATUS:MSDKGameIng END
	2015-09-17 20:15:09.260 MSDKDevDemo[91596:13718176] -[MSDKCrashReportModule startGameStatus:]# MSDK_STATUS:MSDKGameCalculate START
	2015-09-17 20:15:09.260 MSDKDevDemo[91596:13718176] -[MSDKCrashReportModule endGameStatus:succ:errorCode:]# MSDK_STATUS:MSDKGameCalculate END


﻿
MSDK iOS 介绍
=======

### [SDK下载](http://mcloud.ied.com/wiki/MSDK%E4%B8%8B%E8%BD%BD) [极速上手](iOSPlugin.md)
---

 ## 功能介绍
 
  #### MSDK 是腾讯IEG为自研以及第三方 手游开发团队开发提供的，旨在帮助游戏快速接入腾讯各个主要平台并上线运营的公共组件及服务库
---

 ## 包含内容
 
  ####　头文件与静态库文件在：`WGPlatform.framework`；资源文件在：`WGPlatformResources.bundle`。
  ####　主要接口在`WGPlatform.h`文件，MSDK相关结构体在`WGCommon.h`文件，枚举值在`WGPublicDefine.h`中定义，推送接口在`WGApnInterface.h`文件，主回调对象在`WGObserver.h`文件，广告回调对象在`WGADObserver.h`文件。

---

 ## 模块介绍
 
| 模块名称 | 模块功能 | 接入条件 |
| ------------- |:-------------:|:----:|
| 平台| 微信，手Q统称平台||
|数据分析模块|提供数据上报, 异常上报	||
|手Q	 |提供登录和分享到手Q能力	|需要手Q appId和appKey|
|微信 |	提供微信的登录和分享能力	|需要微信 appId 和 appKey|
|QQ游戏大厅	| 提供游戏大厅拉起游戏能力	||
|内置浏览器	| 提供应用内内置浏览器能力	||
|公告	|提供滚动弹出公告能力	||
|LBS	|基于地理位置拉取好友能力	||
|游客模式|提供游客登录与支付	|需要手Q或微信appId和appKey|
|推送|提供推送消息能力|||

---

 ## 名词解释


| 名称 | 名词概述 |
| ------------- |:-------------|
| 平台| 微信，手Q统称平台|
|openId|用户授权后平台返回的唯一标识|
|accessToken|用户授权票据, 获取此票据以后可以认为用户已经授权, 分享/支付等功能需要此票据. 手Q的accessToken有效时间为90天. 微信的accessToken有效时间为2小时.|
|payToken|支付票据, 此票据用于手Q支付, 手Q授权会返回此票据。微信授权不会返回此票据. 有效时间为6天。|
|offerId|Midas的appId|
|refreshToken|微信平台特有票据, 有效期为30天, 用于微信accessToken过期之后刷新accessToken.|
|异帐号|游戏中授权的账号和手Q/微信中授权的账号不相同, 此种场景称之为异账号.|
|结构化消息|分享消息的一种, 此种消息分享后的展示形式为: 左边缩略图, 右上是消息标题, 右下是消息概要。|
|大图消息|分享消息的一种, 此种消息只包含一张图片, 显示也只有一张图片. 也叫做大图分享, 纯图分享。|
|同玩好友|手Q或微信好友中玩过同一个游戏的称为同玩好友|
|游戏中心|手Q客户端或微信客户端中的游戏中心统称游戏中心。|
|游戏大厅|特指 QQ游戏大厅|
|平台唤起|通过平台或渠道（手Q/微信/游戏大厅/应用宝等）启动游戏|
|关系链|用户在平台上的好友关系|
|会话|手Q或微信的聊天信息|
|安装渠道|游戏上线前打包会根据不同渠道(例如应用宝,豌豆荚,91等)生成不同渠道号的apk包, 在安装包中的渠道号称之为安装渠道.|
|注册渠道|用户首次登陆时, 游戏的安装渠道, 会在MSDK后台记录, 算作用户注册渠道.|
|Pf|支付需要使用到的字段, 用于数据分析使用, pf的组成为: 唤起平台_账号体系-注册渠道-操作系统-安装渠道-自定义字段.|
|pfKey| 支付使用|
|AMS|	互娱高级营销系统，负责游戏营销活动策划和开发|
|快速登录|	可以在手Q游戏列表，或分享链接中直接将手Q已登录的帐号信息传到游戏实现登录，不需要游戏再次授权。依赖：MSDK 1.8.0i以上、手Q4.6.2以上。|
|Guest模式|	Apple要求iOS手游提供手Q/微信平台以外的登录方式，直接进入游戏体验完整游戏内容，并可以在这个方式下完成支付。|
|GuestID|	通过设备信息，向MSDK注册生成的游客身份标识，格式为"G_数字/字母/_/@"组成的34位长的字符串。|
|Guest AppID|	为了辨识游客模式，Guest模式下的APPID使用“G_手QAppID”的格式，如果游戏没有手Q AppID，则使用"G_微信AppID"。|
|Guest AppKey|	与Guest AppID配对,使用对应手Q/微信的AppKey。|

---
## 注意事项

支付独立于MSDK存在，相关文档请参照[米大师官网](http://midas.qq.com)。
appId、appKey、offerId是接入相关模块的凭证，申请方法在“MSDK产品介绍”中。

---
## 版本历史

* [点击查看MSDK版本变更历史](version.md)

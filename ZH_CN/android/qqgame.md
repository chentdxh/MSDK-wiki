MSDK游戏大厅接入模块
====================

# 游戏大厅

目前游戏接入大厅有两种情况:

- 一种是只是通过大厅启动游戏，此时不带大厅的登录票据。

- 另一种是从大厅拉起游戏的同时带上用户在大厅的登录票据进入游戏。此时大厅的登录票据会直接替换游戏中的玩家登录票据。

## 不带登录态拉起游戏

如果游戏只是通过大厅拉起游戏，并不需要获取大厅的登录票据可以通过以下方法屏蔽大厅的拉起。
在游戏的`onCreate`和`onNewIntent`里用以下方法判断游戏拉起是否来源于大厅，如果是，则不调用`handleCallback`。如果不是，调用`handleCallback`处理其余平台的拉起。代码如下：

```
Intent intent = this.getIntent();
if (intent != null && intent.getExtras() != null) {
	Bundle b = intent.getExtras();
	Set<String> keys = b.keySet();
	if(keys.contains("KEY_START_FROM_HALL")){
    //拉起平台为大厅
	Logger.d("Wakeup Plantform is Hall");
} else {
	//拉起平台不是大厅
	Logger.d("Wakeup Plantform is not Hall");
	WGPlatform.handleCallback(this.getIntent()); // 接收平台回调
}
```

## 带登录态拉起游戏

游戏接入QQ游戏大厅需要先配置游戏大厅入口 (由对应腾讯产品接口人配置, [配置系统链接](http://mqqgameadmin4dev.3gqq.com/web_mqqgame_admin/crud_db_cobra_hall/dbbeans/index.jsp)). 
游戏大厅联调过程因为使用到的是测试环境, 需要使用测试号(由对应产品接口人申请, 测试号类型选择普通测试号即可. [测试号申请链接](http://ceshihao.ied.com)). 上线以后使用正式环境则无需测试号即可通过游戏大厅登录.
**注意:** 接入游戏大厅在游戏大厅配置时候需要配置 鉴权类型(auth_type) 为 **开放平台Token (16)**.如下图: 

![qqgame_1](./qqgame_1.jpg)

接入游戏大厅首先需要有游戏大厅的入口, 需要将游戏配置到游戏大厅中, 这一部分需要找游戏大厅的相关人员完成. 游戏在大厅有入口之后, 从大厅可以拉起游戏, 拉起游戏时SDK会换取游戏需要的票据(OpenId+accessToken+paytoken)存到本地, 游戏在接收到`OnWakeupNotify`之后可以根据接收到的`WakeupRet`的`platform`字段和来判断是否来自大厅拉起, 确认是大厅拉起以后可以调用`WGGetLoginRecord`接口读取存在本地的登录票据, 拿到这些票据以后即可完成登录.

### 接入配置

接入大厅游戏的几点配置要求

```
<!--接入游戏大厅应用不可加此intent-filter  start-->
<intent-filter>
	<action android:name="android.intent.action.MAIN" />
	<category android:name="android.intent.category.LAUNCHER" />
	</intent-filter>
<!-- 接入游戏大厅应用不可加此intent-filter  end -->

```

设置入口Activity(对应MSDKSample的`MainActivity`)的intent-filter

```
<!-- 在入口Activity中添加此intent-filter start -->
<intent-filter>
	<!-- xxxxx 替换为开发者自己的应用包名,必须填入正确, 否则无法启动。-->
    <action android:name="xxxxx" /> 
    <category android:name="android.intent.category.DEFAULT" />
</intent-filter>
<!-- 在入口Activity中添加此intent-filter end -->
```

在AndroidManifest.xml中的<application>标签内加入以下内容

```
<!-- 接入大厅游戏必须设置这个meta-data start -->
<meta-data
    android:name="QQGameHallMark"
    android:value="QQGameHallMark" />
<meta-data
    android:name="QQGameHallAuthorVer"
	android:value="10000" />
<!-- 接入大厅游戏必须设置这个meta-data end -->
```

`QQGameHallAuthorVer`中的10000代表的是指接入应用在大厅的平台上的版本号, 用来做更新版本的,每次在大厅上更新一个版本该值就加1, 初始值可设为10000, 用来在大厅里面做版本更新用的, 此值跟`android:versionCode`没有冲突, 不需要一致, 但是每次提交新版本`android:versionCode`和`QQGameHallAuthorVer`的值都同时加1。

**注意:** 

1. 接入游戏大厅必须保证长按home键没有出现自己的应用图标. 要保证这个点就必须确认androidManifest.xml文件中所有Activity的`android:launchMode`设置为默认值(即不设置)或者是singleTop, 不能设置为`singleTask`或`singleInstance`.

2. 如果出现在游戏中按home键回到桌面, 再长按home键点击游戏大厅图标变成回到大厅界面的情况(正常应该是从游戏中按home键就应该是回到游戏). 那么先检查androidManifest.xml文件中是否含有a`ndroid:excludeFromRecents`为true的, 有的话必须删除。另外含有`android:allowTaskReparenting`, `android:alwaysRetainTaskState`的也都要去掉. 

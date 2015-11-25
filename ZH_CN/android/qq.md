
MSDK 手Q 相关模块
=======

接入配置
------

### AndroidMainfest配置

- 游戏按照下面的事例填写配置信息。

		<!-- TODO SDK接入 QQ接入配置 START -->
		<activity
		    android:name="com.tencent.tauth.AuthActivity"
		    android:launchMode="singleTask"
		    android:noHistory="true" >
		    <intent-filter>
		        <action android:name="android.intent.action.VIEW" />
		        <category android:name="android.intent.category.DEFAULT" />
		        <category android:name="android.intent.category.BROWSABLE" />
		        <data android:scheme="tencent游戏的手Q appid" />
		    </intent-filter>
		</activity>
		<activity
		    android:name="com.tencent.connect.common.AssistActivity"
		    android:configChanges="orientation|screenSize|keyboardHidden"
		    android:screenOrientation="portrait"
		    android:theme="@android:style/Theme.Translucent.NoTitleBar" />
		<!-- TODO SDK接入 QQ接入配置 END -->

- **注意事项：**

	1. **com.tencent.tauth.AuthActivity的intent-filter中的```<data android:scheme="tencent游戏的手Q appid" />```
	中tencent后填写游戏的手Q appid。**例如：```<data android:scheme="tencent100703379" />```

	- **游戏的Activity的launchMode需要设置为singleTop**, 设置为singleTop以后在平台拉起游戏的场景下, 有可能会出现游戏Activity被拉起两个的情况, 所以游戏Activity的onCreate里面需要检测当前Activity是否是重复的游戏Activity, 如果是则要finish掉当前游戏Activity.

### Appid 配置：

- 这部分内容在Java层初始化部分中已经完成。

		public void onCreate(Bundle savedInstanceState) {
			...
    		//游戏必须使用自己的QQ AppId联调
            baseInfo.qqAppId = "1007033***";
            baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

            //游戏必须使用自己的微信AppId联调
    		baseInfo.wxAppId = "wxcde873f99466f***"; 

			//游戏必须使用自己的msdkKey联调
			baseInfo.msdkKey = "5d1467a4d2866771c3b289965db3****";

            //游戏必须使用自己的支付offerId联调
            baseInfo.offerId = "100703***";
    		...
    		WGPlatform.Initialized(this, baseInfo);
    		WGPlatform.handleCallback(getIntent());
    		...
		}
- **注意事项：**

	1. baseInfo值游戏填写错误将导致 QQ、微信的分享，登录失败 ，切记 ！！！

## 快速登录

快速登陆是指当玩家在手Q或者微信内点击分享消息直接拉起并进入游戏时，平台会透传登陆相关的票据信息从而直接完成登陆进入游戏。这种场景下，游戏在被拉起以后无需用户再次授权才能进入游戏。

### 手Q游戏中心快速登陆配置

手Q通过游戏中心点击启动的时候可以直接快速登录游戏，但是通过游戏中心详情页进入的时候取决于游戏的配置，具体配制方法由游戏的**`运营协同规划PM`**提交需求给手Q游戏中心，由游戏中心的负责人完成配置。配置如下：

1. 支持openID：

	勾选openID一项，如下图

	![1](./diff-account-1.png) 

2. 支持带openID、accessToken、PayToken

	1. 勾选对应的选项

	2. 填写游戏支持异帐号的版本对应的versionCode。填写以后此code及以上的版本可以带票据拉起游戏，之前版本只会带openID拉起游戏，不会影响游戏的正常逻辑。

	![2](./diff-account-2.png) 

3. 注意事项

	在配置的时候一般只需要配置前三项即可，后面几项不用配置。

查询个人信息
------

用户通过手Q授权后, 游戏需要用户昵称, 头像等其他信息, 个人信息包含: nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge. 要完成此功能需要用到的接口有: WGQueryQQMyInfo, 接口详细说明如下:
#### 接口声明：

	/**
	 * 获取自己的QQ资料
	 * @return void
	 *   此接口的调用结果通过OnRelationCallBack(RelationRet& relationRet) 回调返回数据给游戏,
	 *   RelationRet对象的persons属性是一个Vector<PersonInfo>, 取第0个即是用户的个人信息.
	 *   手Q授权的用户可以获取到的个人信息包含:
	 *   nickname, gender, pictureSmall（40*40）, pictureMiddle（40*40）, pictureLarge（100*100）, 其他字段为空.
	 */
	bool WGQueryQQMyInfo();

#### 接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGQueryQQMyInfo();
回调接受事例：

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // relationRet.persons.at(0) 中保存的即是个人信息
        break;
    default:
        break;
    	}
	}

查询同玩好友信息
------

用户通过手Q授权游戏后, 需要拉起游戏内好友信息(例如好友高分排行). 要完成此功能需要用到的接口有: WGQueryQQGameFriendsInfo, 接口详细说明如下:
#### 接口声明：
	
	/**
	* 获取QQ好友信息, 回调在OnRelationNotify中,
	* 其中RelationRet.persons为一个Vector, Vector中的内容即使好友信息, QQ好友信息里面province和city为空
	* @return void
	* 此接口的调用结果通过OnRelationNotify(RelationRet& relationRet)
	* 回调返回数据给游戏, RelationRet对象的persons属性是一个Vector<PersonInfo>,
	* 其中的每个PersonInfo对象即是好友信息,
	* 好友信息包含: nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge
	*/
	bool WGQueryQQGameFriendsInfo();
	
#### 接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGQueryQQGameFriendsInfo();

回调接受事例：

	virtual void OnRelationNotify(RelationRet& relationRet) {
    	switch (relationRet.flag) {
    	case eFlag_Succ:
        // relationRet.persons 中保存的即是所有好友信息
       		break;
    	default:
        	break;
    	}
	}

#### 注意事项
1. 为了避免当获取个人信息（比如头像、名字）、 好友信息（比如头像、名字）失败时，导致游戏登入失败，请将查询个人信息、查询好友信息设置为`非关键路径`。
1. 另建议游戏侧在获得个人信息和好友信息做缓存处理，避免每次登入都进行拉取刷新个人信息和好友信息，造成微访问量过大；并且每天进行1次访问，避免好友更新头像和名字时，不能及时在游戏内更新。

分享展示效果
---
核心模块中的[`分享模块`](share.md)图文并茂的总结了QQ/微信分享的展示效果和点击效果，在接入分享功能前强烈建议先阅读[`分享模块`](share.md)文档。

结构化消息分享
------

此种消息分享需要唤起手Q, 需要用户参与才能完成整个分享过程, 可以分享给游戏内和游戏外好友, 通常用来邀请游戏外好友.

消息分享出去以后, 消息接收者点击消息可以拉起调用接口时候传入的URL, 通常此URL配置成游戏中心URL, 如此则可以在 手Q游戏中心 配置自动拉起, 实现点击消息唤起游戏的效果.

如果用户手机上没有安装手Q或者安装的手Q版本低于4.0, 此接口唤起Web页面完成分享功能. 要完成此功能需要用到的接口有: WGSendToQQ, 接口详细说明如下: 
#### 使用场景：
	邀请、炫耀
#### 接口声明：

	/**
	 * @param scene 标识发送手Q会话或者Qzone
	 * 		eQQScene.QQScene_QZone: 分享到空间(4.5以上版本支持)
	 * 		eQQScene.QQScene_Session: 分享到手Q会话
	 * @param title 结构化消息的标题
	 * @param desc 结构化消息的概要信息
	 * @param url  内容的跳转url，填游戏对应游戏中心详情页，游戏被分享消息拉起时, MSDK会给游戏OnWakeup(WakeupRet& wr)回调, wr.extInfo中会以key-value的方式带回所有的自定义参数.
	 * @param imgUrl 分享消息缩略图URL
	 * @param imgUrlLen 分享消息缩略图URL长度
	 * @return void
	 *   通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *     eFlag_Succ: 分享成功
	 *     eFlag_Error: 分享失败
	 *     
	 *     @return void
	 *	通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *     eFlag_Succ: 分享成功
	 *     eFlag_Error: 分享失败
	 *   注意:
	 *     如果分享的是本地图片，则需要放置到sdcard分区, 或其他外部程序有权限访问之处
	 *     由于手Q客户端部分的版本返回的回调是有问题的, 故建议不要依赖此回调做其他逻辑。
	 *     
	 */ 
	void WGSendToQQ(
		const eQQScene& scene,
		unsigned char* title, 
		unsigned char* desc,
		unsigned char* url, 
		unsigned char* imgUrl,
		const int& imgUrlLen
		);
	
#### 接口调用：

接口调用示例：

	int scene = 1; 
	std::string title = "title";
	std::string summary = "summary";
	std::string targetUrl = "http://www.qq.com";
	std::string imgUrl = "http://mat1.gtimg.com/erweimaNewsPic.png";
	WGPlatform::GetInstance()-> WGSendToQQ(
		1, 
		((unsigned char *) title.c_str()),
		((unsigned char *)summary.c_str()), 
		((unsigned char *)targetUrl.c_str()),
		((unsigned char *)imgUrl.c_str()),
		imgUrl.length()
	);

回调接受事例：

	virtual void OnShareNotify(ShareRet& shareRet) {
    	LOGD("OnShareNotify: platform:%d flag:%d",
            shareRet.platform, shareRet.flag);
    	// 处理分享回调
    	if (shareRet.platform == ePlatform_QQ) {
        	switch (shareRet.flag) {
        		case eFlag_Succ:
            		// 分享成功
            		break;
        		case eFlag_Error:
            		// 分享失败
            		break;
        		}
    		} else if (shareRet.platform == ePlatform_Weixin) {
        	...
    	}
	}

#### 注意事项：

* 拉起手Q并默认弹出分享到空间的弹框要手Q4.5以上版本才能支持
* `分享的图片推荐大小为200*200，若图片中有一边小于100将无法显示正常显示`
* 分享图片需要放置到sdcard分区, 或其他外部程序有权限访问之处

音乐消息分享
------
要完成音乐分享需要唤起手Q, 需要用户参与才能完成整个分享过程。

消息分享出去以后，消息接收者点击播放按钮可以直接播放音乐，退出会话任然可以继续播放。点击消息会跳转到指定页面。 

如果用户手机上没有安装手Q或者安装的手Q版本低于4.0, 此接口唤起Web页面完成分享功能。要完成此功能需要用到的接口有: 
#### 使用场景：
	邀请、炫耀
#### 接口声明：

	/**
	 * 把音乐消息分享到手Q会话
	 * @param scene eQQScene:
	 * QQScene_QZone : 分享到空间
	 * QQScene_Session：分享到会话
	 * @param title 结构化消息的标题
	 * @param desc 结构化消息的概要信息
	 * @param musicUrl  点击消息后跳转的URL
	 * @param musicDataUrl  音乐数据URL（例如http:// ***.mp3）
	 * @param imgUrl 		分享消息缩略图URL
	 * @return void
	 * 通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 * 	   eFlag_Succ: 分享成功
	 * 	   eFlag_Error: 分享失败
	 *   注意:
	 *     由于手Q客户端部分的版本返回的回调是有问题的, 故建议不要依赖此回调做其他逻辑。
	 */
	void WGSendToQQWithMusic(
		const eQQScene& scene,
		unsigned char* title,
		unsigned char* desc,
		unsigned char* musicUrl,
		unsigned char* musicDataUrl,
		unsigned char* imgUrl
	);

#### 接口调用：

接口调用示例：

	int scene = 1; 
	std::string title = "title";
	std::string desc = "desc";
	std::string musicUrl = "http://y.qq.com/i/song.html?songid=1135734&source=qq";
	std::string musicDataUrl = "http://wekf.qq.com/cry.mp3";
	std::string imgUrl = "http://imgcache.qq.com/music/photo/mid_album_300/g/l/002ma2S64Gjtgl.jpg";
	WGPlatform::GetInstance()->WGSendToQQWithMusic(
		1, 
		((unsigned char *) title.c_str()),
		((unsigned char *)desc.c_str()), 
		((unsigned char *)musicUrl.c_str()),
		((unsigned char *)musicDataUrl.c_str()),
		((unsigned char *)imgUrl.c_str()),
		imgUrl.length()
	);

回调接受事例：

	virtual void OnShareNotify(ShareRet& shareRet) {
    	LOGD("OnShareNotify: platform:%d flag:%d",
            shareRet.platform, shareRet.flag);
    	// 处理分享回调
    	if (shareRet.platform == ePlatform_QQ) {
        	switch (shareRet.flag) {
        		case eFlag_Succ:
            		// 分享成功
            		break;
        		case eFlag_Error:
            		// 分享失败
            		break;
        		}
    		} else if (shareRet.platform == ePlatform_Weixin) {
        	...
    	}
	}

#### 注意事项：

* `分享的图片推荐大小为200*200，若图片中有一边小于100将无法显示正常显示`

后端分享
------

在上面步骤中获取到好友信息以后, 游戏需要分享消息给指定好友(指定好友的openId). 此种分享不需要拉起手Q客户端, 分享过程无需用户参与, 调用接口即可完成分享. 但是只能分享给游戏内好友. 消息分享出去以后, 消息接收者点击消息可以拉起分享调用时候传入的URL, 通常此URL配置成游戏中心URL, 如此则可以在 手Q游戏中心 配置自动拉起, 实现点击消息唤起游戏的效果. 要完成此功能需要用到的接口有: WGSendToQQGameFriend, 接口详细说明如下:
#### 使用场景：
	送心后通知好友
#### 接口声明：

	/**
	 * @param act 好友点击分享消息拉起页面还是直接拉起游戏, 传入 1 拉起游戏, 传入 0, 拉起targetUrl
	 * @param fopenid 好友的openId
	 * @param title 分享的标题
	 * @param summary 分享的简介
	 * @param targetUrl 内容的跳转url，填游戏对应游戏中心详情页，游戏被分享消息拉起时, MSDK会给游戏OnWakeup(WakeupRet& wr)回调, wr.extInfo中会以key-value的方式带回所有的自定义参数.
	 * @param imageUrl 分享缩略图URL
	 * @param previewText 可选, 预览文字
	 * @param gameTag 可选, 此参数必须填入如下值的其中一个
				 MSG_INVITE                //邀请
				 MSG_FRIEND_EXCEED       //超越炫耀
				 MSG_HEART_SEND          //送心
				 MSG_SHARE_FRIEND_PVP    //PVP对战
	 */ 
		bool WGSendToQQGameFriend(
			int act, 
			unsigned char* fopenid,
			unsigned char *title, 
			unsigned char *summary,
			unsigned char *targetUrl, 
			unsigned char *imgUrl,
			unsigned char* previewText, 
			unsigned char* gameTag
		);

#### 接口调用：

接口调用示例：

	int act = 1;
	std::string friendOpenId = "791AB3A5864670BB6E331986FB86582A";
	std::string title = "qq title";
	std::string summary = "qq summary";
	std::string targetUrl = "http://qq.com";
	std::string imageUrl = "http://mat1.gtimg.com//erweimaNewsPic.png";
	std::string previewText = "qq previewText";
	std::string gameTag = "qq gameTag";
	WGPlatform::GetInstance()->WGSendToQQGameFriend(
		1, 
		((unsigned char *) friendOpenId.c_str()), 
		((unsigned char *)title.c_str()), 
		((unsigned char *)summary.c_str()), 
		((unsigned char *)targetUrl.c_str()), 
		((unsigned char *)picUrl.c_str()), 
		((unsigned char *)previewText.c_str()), 
		((unsigned char *)game_tag.c_str())
	);

回调接受事例：

	virtual void OnShareNotify(ShareRet& shareRet) {
    	LOGD("OnShareNotify: platform:%d flag:%d",
            shareRet.platform, shareRet.flag);
    	// 处理分享回调
    	if (shareRet.platform == ePlatform_QQ) {
       		switch (shareRet.flag) {
        	case eFlag_Succ:
            	// 分享成功
            	break;
        	case eFlag_Error:
            	// 分享失败
            	break;
        	}
    	} else if (shareRet.platform == ePlatform_Weixin) {
        	...
    	}
	}

#### 注意事项：
此分享消息在PC QQ上不显示。接收方需要关注“QQ手游”公众号才能接收到，同一用户同一天收到的同一款游戏能接收的在20条消息左右。

大图消息分享
------
要完成此种消息分享需要唤起手Q, 需要用户参与才能完成整个分享过程,可以分享给游戏内和游戏外好友, 通常用来炫耀成绩或者其他需要详图的功能. 

消息分享出去以后, 消息接收者点击消息不能唤起游戏.

如果用户手机上没有安装手Q或者安装的手Q版本低于4.5, 此接口唤起Web页面完成分享功能. 图片最短边大于640px时, 后台会对图片做压缩. 要完成此功能需要用到的接口有: WGSendToQQWithPhoto, 接口详细说明如下:
#### 使用场景：
	炫耀

#### 接口声明：

	/**
	 * @param scene 标识发送手Q会话或者Qzone
	 * 		eQQScene.QQScene_QZone: 分享到空间
	 * 		eQQScene.QQScene_Session: 分享到手Q会话
	 * @param imgFilePath 需要分享图片的本地文件路径, 图片需放在sdcard分区。每次分享的图片路径不能相同，相同会导致图片显示有问题，游戏需要自行保证每次分享图片的地址不相同
	 * @return void
	 *   通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *     eFlag_Succ: 分享成功
	 *     eFlag_Error: 分享失败
	 *   注意:
	 *     分享图片需要放置到sdcard分区, 或其他外部程序有权限访问之处
	 *     由于手Q客户端部分的版本返回的回调是有问题的, 故建议不要依赖此回调做其他逻辑。
	 */
	void WGSendToQQWithPhoto(const eQQScene& scene, unsigned char* imgFilePath);
#### 接口调用：
接口调用示例：

	//图片支持png,jpg 必须放在 sdcard 中
	std::string filePath = "/mnt/sdcard/test.png";
	WGPlatform::GetInstance()->WGSendToQQWithPhoto(
	1, 
	((unsigned char *)filePath.c_str())
	);
		
回调接受事例：

	virtual void OnShareNotify(ShareRet& shareRet) {
    	LOGD("OnShareNotify: platform:%d flag:%d",
            shareRet.platform, shareRet.flag);
    	// 处理分享回调
    	if (shareRet.platform == ePlatform_QQ) {
        	switch (shareRet.flag) {
        		case eFlag_Succ:
            		// 分享成功
            		break;
        		case eFlag_Error:
            		// 分享失败
            		break;
        		}
    		} else if (shareRet.platform == ePlatform_Weixin) {
        	...
    	}
	}

#### 注意事项：

1. 此接口只支持传入本地图片路径。每次分享的图片路径不能相同，相同会导致图片显示有问题，游戏需要自行保证每次分享图片的地址不相同
2. 拉起手Q并默认弹出分享到空间的弹框要手Q4.5以上版本才能支持
3. 大图消息不能通过web分享




添加QQ好友
------
玩家在游戏中直接其他游戏玩家为QQ好友。调用接口：WGAddGameFriendToQQ。

####版本情况：

- 自MSDK1.7.5 开始提供此功能。
- **MSDK2.6.0a版本以下的游戏，该接口游戏必须需要在主线程调用。**

#### 接口声明：

	/**
	 * 游戏内加好友
	 * @param cFopenid 需要添加好友的openid
	 * @param cDesc 要添加好友的备注
	 * @param cMessage 添加好友时发送的验证信息
	 */
	void WGAddGameFriendToQQ(unsigned char* cFopenid, unsigned char* cDesc,
			unsigned char* cMessage);

#### 接口调用：
接口调用示例：

	std::string cFopenid = "66C7CFB0D5336EA1FABAD9B0FEECCE74";
	std::string cDesc = "apiWGAddGameFriendToQQ";
	std::string cMessage = "add";
	WGPlatform::GetInstance()->WGAddGameFriendToQQ(
		(unsigned char *)cFopenid.c_str(),
		(unsigned char *)cDesc.c_str(), 
		(unsigned char *)cMessage.c_str()
	);


手Q功能对应支持版本
------
1. **概述**：
	
	手Q的功能与手Q版本相关，具体功能版本支持情况如下：
	
| 功能名称| 功能说明|Android 手Q支持情况|
|: ------------- :|: ------------- :|: ------------- :|
| 授权登陆| 拉起web授权 | 手Q 4.0及以上 |
| 结构化消息分享|分享|手Q 4.5及以上 |
| 授权 |  |	4.1及以上 |
| 定向分享 |  | 4.1及以上 |
| 大图分享 |  | 4.1及以上 |
| QZone分享弹框	| 拉起手Q默认有弹框	| 4.5及以上 |
| 快速授权 | 手Q拉起游戏带授权态 | 4.6及以上 |
| Qzone&朋友圈分享 |  | 4.5及以上 |
| 异帐号 | 平台拉起游戏是否带openid到游戏（异帐号） | 4.2及以上 |
| 游戏内加群 | 手Q拉起游戏带授权态 | 4.7及以上 |
| 游戏内绑定群 | 手Q拉起游戏带授权态 | 5.1及以上 |
| 游戏内加好友 | 手Q拉起游戏带授权态 | 5.1及以上 |

游戏中心详情页
------
手Q游戏中心详情页是手Q提供给精品游戏的一个手Q游戏中心链接（效果如下图）。当游戏消息分享的目标地址填写该链接时，点击消息可以跳转到该目标链接并自动带票据拉起游戏实现游戏的快速登陆（相当于在游戏中心点启动按钮）。

分享URL地址：

http://gamecenter.qq.com/gcjump

字段规范	
					
| 字段| 是否必须 | 类型 | 说明 |
|: ------- :|: ------- :|: ------- :|: ------- :|
| appid | 必须 | Integer | 应用唯一标识ID |
| pf | 必须 | String | 历史原因固定为“invite”，游戏中心检测到pf值为invite将直接呼起游戏 |
| plat | 必须 |	String | 来源平台，值为qq |
| from | 必须 | String | <p>消息来源平台，可能值有：</p><p>androidqq：安卓QQ</p><p>iphoneqq：iPhone QQ</p> |
| ADTAG | 必须 | String | <p>标识不同的结构化消息来源，可能值有：</p><p>gameobj.msg_invite（代表邀请）</p><p>gameobj.msg_exceed（代表超越）</p><p>gameobj.msg_heart（代表送心）</p><p>gameobj.msg_pvp（代表挑战）</p><p>gameobj.msg_show（代表炫耀）</p> |
| originuin	| 必须 | String | 发起方openID |
| platformdata | 可选 | String | 透传给游戏的数据 |
| gamedata | 可选 | String | 透传给游戏的数据 |

实例

http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite

使用场景：

在客户端的以下几个接口会用到：

	WGSendToQQ：对应参数为url
	WGSendToQQGameFriend：对应参数为targetUrl
	WGSendToQQWithMusic：对应参数为musicUrl
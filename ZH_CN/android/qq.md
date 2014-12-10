
MSDK 手Q 相关模块
=======

接入配置
------

#### AndroidMainfest配置

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

#### Appid 配置：

- 这部分内容在Java层初始化部分中已经完成。

		public void onCreate(Bundle savedInstanceState) {
			...
    		//游戏必须使用自己的QQ AppId联调
            baseInfo.qqAppId = "1007033***";
            baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

            //游戏必须使用自己的微信AppId联调
            baseInfo.wxAppId = "wxcde873f99466f***"; 
            baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

            //游戏必须使用自己的支付offerId联调
            baseInfo.offerId = "100703***";
    		...
    		WGPlatform.Initialized(this, baseInfo);
    		WGPlatform.handleCallback(getIntent());
    		...
		}
- **注意事项：**

	1. baseInfo值游戏填写错误将导致 QQ、微信的分享，登录失败 ，切记 ！！！

授权登录
------

拉起手Q客户端或web页面(手Q未安装)授权, 授权完成返回游戏openId、accessToken、payToken, pf, pfKey几种票据。要完成此功能需要用到的接口有: WGLogin。 接口详细说明如下:

#### 接口声明：
	
	/**
	 * @param platform 游戏传入的平台类型, 可能值为: ePlatform_QQ, ePlatform_Weixin
	 * @return void
	 *   通过游戏设置的全局回调的OnLoginNotify(LoginRet& loginRet)方法返回数据给游戏
	 *     loginRet.platform表示当前的授权平台, 值类型为ePlatform, 可能值为ePlatform_QQ, ePlatform_Weixin
	 *     loginRet.flag值表示返回状态, 可能值(eFlag枚举)如下：
	 *       eFlag_Succ: 返回成功, 游戏接收到此flag以后直接读取LoginRet结构体中的票据进行游戏授权流程.
	 *       eFlag_QQ_NoAcessToken: 手Q授权失败, 游戏接收到此flag以后引导用户去重新授权(重试)即可.
	 *       eFlag_QQ_UserCancel: 用户在授权过程中
	 *       eFlag_QQ_LoginFail: 手Q授权失败, 游戏接收到此flag以后引导用户去重新授权(重试)即可.
	 *       eFlag_QQ_NetworkErr: 手Q授权过程中出现网络错误, 游戏接收到此flag以后引导用户去重新授权(重试)即可.
	 *     loginRet.token是一个Vector<TokenRet>, 其中存放的TokenRet有type和value, 通过遍历Vector判断type来读取需要的票据. type(TokenType)类型定义如下:
	 *       eToken_QQ_Access,
	 *       eToken_QQ_Pay,
	 *       eToken_WX_Access,
	 *       eToken_WX_Refresh
	 */
	void WGLogin(ePlatform platform);

#### 接口调用：

接口调用示例：

	WGPlatform::GetInstance()->WGLogin(ePlatform_QQ); 
回调接受事例：

	virtual void OnLoginNotify(LoginRet& loginRet) {
	if (loginRet.platform == ePlatform_QQ) {
		// 读取QQ的授权票据
		switch (loginRet.flag) {
		case eFlag_Succ: {
			// 进行正常游戏登陆逻辑
			std::string accessToken = "";
			std::string payToken = "";
			for (int i = 0; i < loginRet.token.size(); i++) {
				if (loginRet.token.at(i).type == eToken_QQ_Access) {
					accessToken.assign(loginRet.token.at(i).value);
				} else if (loginRet.token.at(i).type == eToken_QQ_Pay) {
					payToken.assign(loginRet.token.at(i).value);
				}
			}
			break;
		}
		case eFlag_QQ_NotInstall:
		case eFlag_QQ_NotSupportApi:
			// 没有安装或者版本太低, 引导用户下载新版手Q
			break;
		case eFlag_QQ_UserCancel:
			// 用户取消, 提示用户重新授权
			break;
		case eFlag_QQ_NoAcessToken:
		case eFlag_QQ_LoginFail:
		case eFlag_QQ_NetworkErr:
			// 授权过程中网络失败, 或者其他错误, 引导用户重新授权即可
			break;
		}
	} else if (loginRet.platform == ePlatform_Weixin) {
        ...
		}
	}


#### 注意事项：

1.	没有安装手Q的时，精品游戏可以拉起Web页面授权,请确保AndroidMenifest.xml中AuthActivity的声明中要在intent-filter中配置<data android:scheme="***" />, 详见本节手Q相关AndeoidMainfest配置处。 **海纳游戏现在不支持拉起页面授权**。可以通过WGIsPlatformInstalled接口判断是否安装手Q，未安装手Q则提示用户不能授权。

- **偶尔收不到OnLoginNotify回调。**

	请确保com.tencent.tauth.AuthActivity和com.tencent.connect.common.AssistActivity在AndroidManifest.xml 与本节前面部分的说明一致。

- 如果游戏的Activity为Launch Activity, 则需要在游戏Activity声明中添加android:configChanges="orientation|screenSize|keyboardHidden", 否则可能造成没有登录没有回调。

快速登录
-------


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
	 *   nickname, openId, gender, pictureSmall（40*40）, pictureMiddle（40*40）, pictureLarge（100*100）, 其他字段为空.
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
	 * @param imgUrl 分享消息说略图URL
	 * @param imgUrlLen 分享消息说略图URL长度
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
	 *     分享需要SD卡, 没有SD卡不能保证分享成功
	 *     由于手Q客户端4.6以前的版本返回的回调是有问题的, 故不要依赖此回调做其他逻辑. (当前flag全都返回均为eFlag_Succ)
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

拉起手Q并默认弹出分享到空间的弹框要手Q4.5以上版本才能支持


音乐消息分享
------
要完成音乐分享需要唤起手Q, 需要用户参与才能完成整个分享过程。

消息分享出去以后，消息接收者点击播放按钮可以直接播放音乐，退出会话任然可以继续播放。点击消息会跳转到指定页面。 

如果用户手机上没有安装手Q或者安装的手Q版本低于4.0, 此接口唤起Web页面完成分享功能。要完成此功能需要用到的接口有: 
#### 使用场景：
	邀请、炫耀
#### 接口声明：

	WGSendToQQWithMusic。
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
	 *通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *eFlag_Succ: 分享成功
	 *eFlag_Error: 分享失败
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
	 * @param imgFilePath 需要分享图片的本地文件路径, 图片需放在sd卡。每次分享的图片路径不能相同，相同会导致图片显示有问题，游戏需要自行保证每次分享图片的地址不相同
	 * @return void
	 *   通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *     eFlag_Succ: 分享成功
	 *     eFlag_Error: 分享失败
	 * 注意: 由于手Q客户端4.6以前的版本返回的回调是有问题的, 故不要依赖此回调做其他逻辑. (当前flag全都返回均为eFlag_Succ)
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


绑定QQ群
------

游戏公会/联盟内，公会会长可在游戏内拉取会长自己创建的群，绑定某个群作为该公会的公会群。调用接口：WGBindQQGroup。**目前该接口游戏需要在主线程调用。**

#### 接口声明：
	
	/**
	 * 游戏群绑定：游戏公会/联盟内，公会会长可通过点击“绑定”按钮，拉取会长自己创建的群，绑定某个群作为该公会的公会群
	 * @param cUnionid 公会ID，opensdk限制只能填数字，字符可能会导致绑定失败	 
	 * @param cUnion_name 公会名称
	 * @param cZoneid 大区ID，opensdk限制只能填数字，字符可能会导致绑定失败	 
	 * @param cSignature 游戏盟主身份验证签名，生成算法为
					玩家openid_游戏appid_游戏appkey_公会id_区id 做md5如果按照该方法仍然不能绑定成功，可RTX 咨询 OpenAPIHelper
	 *
	 */
	void WGBindQQGroup(unsigned char* cUnionid, unsigned char* cUnion_name,
			unsigned char* cZoneid, unsigned char* cSignature);

#### 接口调用：
接口调用示例：

	std::string cUnionid = "1";
	std::string cUnion_name = "union_name";
	std::string cZoneid = "1";
	//sigature 跟unionid和zoneid，相关，修改的时候要同步改动
	std::string cSignature = "5C336B37DBCDB04D183A3F4E84B2AB0E";
	WGPlatform::GetInstance()->WGBindQQGroup(
		(unsigned char *)cUnionid.c_str(),
		(unsigned char *)cUnion_name.c_str(), 
		(unsigned char *)cZoneid.c_str(),
		(unsigned char *)cSignature.c_str()
	);

### 绑群流程：
![绑群流程图](bindqqgroup.jpg)
### 解绑流程：
![绑群流程图](unbindqqgroup.jpg)
#### 注意事项：

1.	**游戏内绑定群的时候公会id和大区id必须是数字**，如果使用字符可能会导致绑定失败，一般提示为“参数校验失败”。

- 游戏内绑定群的时候签名目生成的规则为：玩家openid\_游戏appid\_游戏appkey\_公会id\_区id的md5值，如果按照次规则生成的签名不可用，直接RTX 咨询 OpenAPIHelper

- 游戏一个公会ID只能和一个QQ群进行绑定。如果用户解散了公会QQ群，公会ID和公会QQ群不会自动解绑，这样公会ID就无法绑定新的QQ群。此时，应用需要调用本接口将公会ID与QQ群解绑，以便创建新的公会QQ群，或与其他已有的QQ群进行绑定。接口调用方法可以RTX 咨询 OpenAPIHelper，或者参照opensdk wiki：[http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup](http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup)

- **调用api的变量最好不要是临时变量**

- 更多内容参考[游戏内加群加好友常见问题](qq.md#加群加好友常见问题)

加入QQ群
------
玩家在游戏中直接加入QQ群调用接口：WGJoinQQGroup。**目前该接口游戏需要在主线程调用。**

#### 接口声明：

	/**
	 * 游戏内加群,公会成功绑定qq群后，公会成员可通过点击“加群”按钮，加入该公会群
	 * @param cQQGroupKey 需要添加的QQ群对应的key，游戏server可通过调用openAPI的接口获取，调用方法可RTX 咨询 OpenAPIHelper
	 */
	void WGJoinQQGroup(unsigned char* cQQGroupKey);

#### 接口调用：
接口调用示例：

	std::string cQqGroupKey = "xkdNFJyLwQ9jJnozTorGkwN30Gfue5QN";
	WGPlatform::GetInstance()->WGJoinQQGroup((unsigned char *)cQqGroupKey.c_str());

### 加群流程：
![加群流程图](joinqqgroup.jpg)

#### 注意事项：

1. 游戏内加群时使用的参数不是对应的QQ群的群号码，而是openAPI后台生成的一个特殊Key值，在游戏中使用的时候需要调用openAPI的接口获取，调用方法可RTX 咨询 OpenAPIHelper，联调阶段可以在[http://qun.qq.com](http://qun.qq.com)**(加群组件/Android代码处查看)**，如下图：![加群示意图](qqgrouup.png)

- **调用api的变量最好不要是临时变量**

- 更多内容参考[游戏内加群加好友常见问题](qq.md#加群加好友常见问题)

添加QQ好友
------
玩家在游戏中直接其他游戏玩家为QQ好友。调用接口：WGAddGameFriendToQQ。**目前该接口游戏需要在主线程调用。**
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

加群加好友常见问题
---

### 1. 为什么提示身份验证失败？

- 游戏内绑定群的时候公会id和大区id必须是数字，如果使用字符可能会导致绑定失败，一般提示为“参数校验失败”。
- 游戏内绑定群的时候签名生成的规则为：玩家openid\_游戏appid\_游戏appkey\_公会id\_区id的md5值，如果按照此规则生成的签名不可用，直接RTX 咨询 OpenAPIHelper。
- 如果区id没有，则用0表示。（demo里面绑定不成功的原因是里面的签名是写死的，不对，需要自己重新算一下签名，appid、appkey、openid都可以在logcat里面找到）

### 2. 查询某个公会ID绑定了哪个群？

请参考：[http://wiki.open.qq.com/wiki/v3/qqgroup/get_group_openid](http://wiki.open.qq.com/wiki/v3/qqgroup/get_group_openid)。返回码错误码为2004，该群与appid没有绑定关系

### 3. 如何查询公会成员是否在群中？
 
请参考：[http://wiki.open.qq.com/wiki/v3/qqgroup/get_group_openid](http://wiki.open.qq.com/wiki/v3/qqgroup/get_group_openid)。返回码错误码为2003，该群与appid没有绑定关系

### 4. 怎么判断绑定QQ群是否成功？
请参考：[http://wiki.open.qq.com/wiki/v3/qqgroup/get_group_openid](http://wiki.open.qq.com/wiki/v3/qqgroup/get_group_openid)。返回码为0，group_openid则表示QQ群的group_openid。再通过group_openid查询群名称（参考第六条） 

**特别说明，msdk和手q不会返回绑定结果，需要游戏主动去查询是否绑定成功**

### 5. 怎么解绑群？
请参考：[http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup](http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup)
### 6. 查询某个公会ID绑定了哪个群？
请参考：[http://wiki.open.qq.com/wiki/v3/qqgroup/get_group_info](http://wiki.open.qq.com/wiki/v3/qqgroup/get_group_info)
### 7. 更多问题
请参考：[http://wiki.open.qq.com/wiki/API%E5%88%97%E8%A1%A8](http://wiki.open.qq.com/wiki/API%E5%88%97%E8%A1%A8)
应用推广类API----QQ能力推广----公会QQ群

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
| originuin	| 必须 | Integer | 发起方openID |
| platformdata | 可选 | String | 透传给游戏的数据 |
| gamedata | 可选 | String | 透传给游戏的数据 |

实例

http://gamecenter.qq.com/gcjump?appid={YOUR_APPID}&pf=invite&from=iphoneqq&plat=qq&originuin=111&ADTAG=gameobj.msg_invite

使用场景：

在客户端的以下几个接口会用到：

	WGSendToQQ：对应参数为url
	WGSendToQQGameFriend：对应参数为targetUrl
	WGSendToQQWithMusic：对应参数为musicUrl
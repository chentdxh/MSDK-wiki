    
MSDK 微信 相关模块
=======


接入配置
------

#### AndroidMainfest配置

游戏按照下面的事例填写配置信息。

```
<!-- TODO SDK接入 微信接入配置 START -->
<activity
	<!-- 注意：此处应改为 游戏包名.wxapi.WXEntryActivity -->
 	android:name="com.example.wegame.wxapi.WXEntryActivity"
	android:excludeFromRecents="true"
	android:exported="true"
	android:label="WXEntryActivity"
	android:launchMode="singleTop"
	<!-- 注意：此处应改为 游戏包名.diff -->
	android:taskAffinity="com.example.wegame.diff" >
	<intent-filter>
		<action android:name="android.intent.action.VIEW" />
		<category android:name="android.intent.category.DEFAULT" />
		<!-- 注意：此处应改为 游戏的微信appid -->
		<data android:scheme="wxcde873f99466f74a" />
	</intent-filter>
</activity>
<!-- TODO SDK接入 微信接入配置 END -->
```

##### 注意事项：
	
* 在`应用包名+.wxapi`下面放置`WXEntryActivity.java`.
* 微信接入的Activity中有`三处需要游戏自行修改`(在上面示例有标注)。


#### Appid 配置：

这部分内容在Java层初始化部分中已经完成, **不能用MSDKSample的appId和appKey进行联调, 游戏需要使用自己的appId和appKey.**

```
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
```

#### 必须调用的方法:

游戏需要在自己的`launchActivity`(游戏启动的第一个Activity)的`onCreat()`和`onNewIntent()`中调用`handleCallback`，否则会造成登录无回调等问题。

- **onCreate**:

```	
@Override
protected void onCreate(Bundle savedInstanceState) {
	super.onCreate(savedInstanceState);
	......
    if (WGPlatform.wakeUpFromHall(this.getIntent())) {
    	// 拉起平台为大厅 
    	Logger.d("LoginPlatform is Hall");
    } else {  
    	// 拉起平台不是大厅
        Logger.d("LoginPlatform is not Hall");
        WGPlatform.handleCallback(this.getIntent());
    }
}
```

- **onNewIntent**

```
@Override
protected void onNewIntent(Intent intent) {
	super.onNewIntent(intent);
	if (WGPlatform.wakeUpFromHall(intent)) {
	    Logger.d("LoginPlatform is Hall");
	} else {
	    Logger.d("LoginPlatform is not Hall");
	    WGPlatform.handleCallback(intent);
	}
}
```

## 接入登录
[接入登录具体工作](login.md#概述)
[调试时请注意签名是否正确](#第二步： 检查签名和包名)

查询个人信息
------

用户通过微信授权后只能获取到openId和accessToken, 游戏需要用户昵称, 头像等其他信息用于显示, SDK目前能获取到的信息包括nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city. 要完成此功能需要用到的接口有: WGQueryWXMyInfo, 接口详细说明如下:

#### 接口声明：

	/**
	 *   回调在OnRelationNotify中,其中RelationRet.persons为一个Vector, Vector的第一项即为自己的资料
	 *   个人信息包括nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city
	 */
	bool WGQueryWXMyInfo();

#### 调用示例代码：

	WGPlatform::GetInstance()->WGQueryWXMyInfo();

#### 回调实现(Demo)代码如下:

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // relationRet.persons.at(0) 中保存的即是个人信息
		std::string gender = relationRet.persons.at(0).gender;
		std::string nickName = relationRet.persons.at(0).nickName;
		std::string openId = relationRet.persons.at(0).openId;
		std::string pictureLarge = relationRet.persons.at(0).pictureLarge;
		std::string pictureMiddle = relationRet.persons.at(0).pictureMiddle;
		std::string pictureSmall = relationRet.persons.at(0).pictureSmall;
        break;
    default:
        break;
    	}
	}


查询好友信息
------

用户通过微信授权游戏后, 需要拉起游戏内好友信息(例如好友高分排行). SDK目前能获取到的信息包括nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city. 要完成此功能需要用到的接口有: WGQueryWXGameFriendsInfo, 接口详细说明如下:
#### 接口声明：

	/**
	 * 获取微信好友信息, 回调在OnRelationNotify中,
	 *   回调在OnRelationNotify中,其中RelationRet.persons为一个Vector, Vector中的内容即为好友信息
	 *   好友信息包括nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city
	 */
	bool WGQueryWXGameFriendsInfo();

此接口的调用结果通过OnRelationCallBack(RelationRet& relationRet) 回调返回数据给游戏, RelationRet对象的persons属性是一个Vector<PersonInfo>, 其中的每个PersonInfo对象即是好友信息, 好友信息包含: nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city.

#### 调用示例代码：

	WGPlatform::GetInstance()->WGQueryWXGameFriendsInfo();

#### 回调实现(Demo)代码如下:

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
	case eFlag_Succ: {
		// relationRet.persons.at(0) 中保存的即是个人信息
		for (int i = 0; i < relationRet.persons.size(); i++) {
			std::string city = relationRet.persons.at(i).city;
			std::string gender = relationRet.persons.at(i).gender;
			std::string nickName = relationRet.persons.at(i).nickName;
			std::string openId = relationRet.persons.at(i).openId;
			std::string pictureLarge = relationRet.persons.at(i).pictureLarge;
			std::string pictureMiddle = relationRet.persons.at(i).pictureMiddle;
			std::string pictureSmall = relationRet.persons.at(i).pictureSmall;
			std::string provice = relationRet.persons.at(i).provice;
				}
		break;
			}
    default:
        break;
    	}
	}

#### 注意事项
1. 为了避免当获取个人信息（比如头像、名字）、 好友信息（比如头像、名字）失败时，导致游戏登入失败，请将查询个人信息、查询好友信息设置为非关键路径。
1. 另建议游戏侧在获得个人信息和好友信息做缓存处理，避免每次登入都进行拉取刷新个人信息和好友信息，造成微信端访问量过大；并且每天进行1次访问，避免微信好友更新头像和名字时，不能及时在游戏内更新。


添加卡券到微信卡包
------

用户把获取到的卡券插入到微信卡包:

#### 接口声明：

	 /**
	 * 将微信卡券插入到微信卡包
	 * @param cardId 卡券ID
	 * @param timestamp 计算签名的时间戳
	 * @param sign 签名
	 */
	  void WGAddCardToWXCardPackage(unsigned char* cardId,unsigned char* timestamp,unsigned char* sign);

#### 调用示例代码：
	
	std::string cCardid ＝ “pe7Gmjg3EpKtnwzNAGHMGJhNKSo4”；
	std::String cTimeStamp = "1212124445";
	std::String cSign = "sdffsfffff";
	WGPlatform::GetInstance()->WGAddCardToWXCardPackage((unsigned char *)cCardid.c_str(),(unsigned char *)cTimeStamp.c_str(),(unsigned char *)cSign.c_str());


#### 回调实现(Demo)代码如下:

	JNIEXPORT void JNICALL Java_com_tencent_msdk_api_WGPlatformObserverForSO_OnAddWXCardNotify
		(JNIEnv * env, jclass, jobject jCardRet){
	 		LOGD("Java_com_tencent_msdk_api_WGPlatformObserverForSO_OnAddWXCardNotify start%s", "");
	 		jclass jCardRetClass = env->GetObjectClass(jCardRet);
	 		CardRet tempCardRet;
			jboolean isCopy;
	 		JniGetAndSetIntField(flag, "flag", jCardRetClass, jCardRet, tempCardRet);
	 		JniGetAndSetIntField(platform, "platform", jCardRetClass, jCardRet, tempCardRet);
	 		JniGetAndSetStringField(open_id, "open_id", jCardRetClass, jCardRet, tempCardRet);
	 		JniGetAndSetStringField(wx_card_list, "wx_card_list", jCardRetClass, jCardRet, tempCardRet);
	 		JniGetAndSetStringField(desc, "desc", jCardRetClass, jCardRet, tempCardRet);
	 		env->DeleteLocalRef(jCardRetClass);
	}
	
#### 注意事项：

1. **由于平台规则，该接口调用后，并不能直接使用回调OnAddWXCardNotify中的CardRet的flag来判断插卡是否成功，只能通过解析CardRet中wx_card_list的内容，查看is_succ的值来确定回调是否成功。is_succ为0表示失败，1表示成功。**

分享展示效果
---
核心模块中的[`分享模块`](share.md)图文并茂的总结了QQ/微信分享的展示效果和点击效果，在接入分享功能前强烈建议先阅读[`分享模块`](share.md)文档。

结构化消息分享
------

此种消息分享需要唤起微信客户端, 需要用户参与才能完成整个分享过程, 可以分享给游戏内和游戏外好友, 通常用来邀请游戏外好友. 
消息分享出去以后, 消息接收者点击消息可以拉起游戏. 要完成此功能需要用到的接口有: WGSendToWeixin, 接口详细说明如下:

#### 接口声明

	/**
	 * @param title 结构化消息的标题（注意：限制长度不超过512Bytes）
	 * @param desc 结构化消息的概要信息（注意：限制长度不超过1KB）
	 * @param mediaTagName 请根据实际情况填入下列值的一个, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源
		 "MSG_INVITE";                   // 邀请
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //分享本周最高到朋友圈
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //分享历史最高到朋友圈
		 "MSG_SHARE_MOMENT_CROWN";         //分享金冠到朋友圈
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //分享本周最高给好友
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //分享历史最高给好友
		 "MSG_SHARE_FRIEND_CROWN";          //分享金冠给好友
		 "MSG_friend_exceed"         // 超越炫耀
		 "MSG_heart_send"            // 送心
	 * @param thumbImgData 结构化消息的缩略图
	 * @param thumbImgDataLen 结构化消息的缩略图数据长度（注意：限制内容大小不超过32KB）
	 * @param messageExt 游戏分享是传入字符串，通过此消息拉起游戏会通过 OnWakeUpNotify(WakeupRet ret)中ret.messageExt回传给游戏
	 * @return void
	 *   通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *     eFlag_Succ: 分享成功
	 *     eFlag_Error: 分享失败
	 */
	 void WGSendToWeixin(
		unsigned char* title, 
		unsigned char* desc,
		unsigned char* mediaTagName,
		unsigned char* thumbImgData,
		const int& thumbImgDataLen, 
		unsigned char* messageExt
	); 

#### 接口调用

	std::string title = " title ";
	std::string desc = " desc ";
	std::string mediaTagName = " mediaTag_wxAppInvite ";
	unsigned char * thumbImgData = getImageData();
	int thumbImgDataLen = getImageDataLength();
	std::string messageExt = "extend message";
	
	WGPlatform::GetInstance()->WGSendToWeixin(
		(unsigned char *)title.c_str(),
		(unsigned char *)desc.c_str(),
		(unsigned char *)mediaTagName.c_str(),
		thumbImgData,
		thumbImgDataLen,
		(unsigned char *)messageExt.c_str()
	);

#### 回调实现(Demo)代码

	virtual void OnShareNotify(ShareRet& shareRet) {
	// 处理分享回调
	if (shareRet.platform == ePlatform_QQ) {
		…
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 分享成功
			break;
		case eFlag_Error:
			// 分享失败
			break;
		}
		}
	}

#### 注意事项

1. 微信分享需要保证微信版本高于4.0 
2. `缩略图数据大小不能超过32k`, 长宽比无限制，超出大小则不能拉起微信。此下图片大小指的是传入接口的图片数据大小，需要注意如果是 jpg 等格式游戏解压后传入的图片数据会比原文件更大。
3. `2.8.0a`及以上版本微信结构化分享增加了`自动压缩`的功能，如果传入的图片数据大于32KB，msdk会对图片数据压缩到32K以下保证能够成功分享。


大图消息分享
------

此种消息分享需要唤起微信, 需要用户参与才能完成整个分享过程, 可以分享给游戏内和游戏外好友, 通常用来炫耀成绩或者其他需要详图的功能. 此种消息可以分享到会话(好友)或者朋友圈, 微信4.0及以上支持分享到会话, 微信4.2及以上支持分享到朋友圈. 

### 使用图片数据分享

此接口使用图片数据进行分享，名称为 `WGSendToWeixinWithPhoto`。建议使用此接口时传入的图片数据小于1MB，否则在微信6.1及以上易分享失败。接口详细说明如下:

#### 接口声明

	/**
	 * @param scene 指定分享到朋友圈, 或者微信会话, 可能值和作用如下:
	 *   WechatScene_Session: 分享到微信会话
	 *   WechatScene_Timeline: 分享到微信朋友圈
	 * @param mediaTagName 请根据实际情况填入下列值的一个, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源
		 "MSG_INVITE";                   // 邀请
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //分享本周最高到朋友圈
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //分享历史最高到朋友圈
		 "MSG_SHARE_MOMENT_CROWN";         //分享金冠到朋友圈
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //分享本周最高给好友
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //分享历史最高给好友
		 "MSG_SHARE_FRIEND_CROWN";          //分享金冠给好友
		 "MSG_friend_exceed"         // 超越炫耀
		 "MSG_heart_send"            // 送心
	 * @param imgData 原图文件数据
	 * @param imgDataLen 原图文件数据长度(建议图片小于1MB)
	 * @param messageExt 游戏分享是传入字符串，通过此消息拉起游戏会通过 OnWakeUpNotify(WakeupRet ret)中ret.messageExt回传给游戏
	 * @param messageAction scene为1(分享到微信朋友圈)的情况下才起作用
	 *   WECHAT_SNS_JUMP_SHOWRANK       跳排行
	 *   WECHAT_SNS_JUMP_URL            跳链接
	 *   WECHAT_SNS_JUMP_APP           跳APP
	 * @return void
	 *   通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *     eFlag_Succ: 分享成功
	 *     eFlag_Error: 分享失败
	 */
	void WGSendToWeixinWithPhoto(
	const eWechatScene &scene,
	unsigned char *mediaTagName,
	unsigned char *imgData, 
	const int &imgDataLen,
	unsigned char *messageExt,
	unsigned char *messageAction
	);

#### 接口调用

	std::string mediaTagName = " mediaTagName ";
	jbyte * imgDataJb = pEnv->GetByteArrayElements(j_imgData, &isCopy);
	unsigned char * imgData = getImageData();
	int imgDataLen = getImageDataLength();
	std::string messageExt = " messageExt ";
	std::string messageAction = " messageAction ";
	WGPlatform::GetInstance()->WGSendToWeixinWithPhoto(
		1,
		(unsigned char *)mediaTagName.c_str(),
		(unsigned char*) imgData,
		imgDataLen,
		(unsigned char *)messageExt.c_str(),
		(unsigned char *)messageAction.c_str()
	);

#### 回调实现(Demo)代码

	virtual void OnShareNotify(ShareRet& shareRet) {
	LOGD("OnShareNotify: platform:%d flag:%d",
			shareRet.platform, shareRet.flag);
	// 处理分享回调
	if (shareRet.platform == ePlatform_QQ) {
		… // 手Q分享返回的回调处理
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 分享成功
			break;
		case eFlag_Error:
			// 分享失败
			break;
			}
		}
	}

### 使用图片路径分享

此接口使用图片数据进行分享，名称为 `WGSendToWeixinWithPhotoPath`。建议使用此接口分享的图片小于3MB。此接口在 **2.7.2a** 及以上版本增加，如需要使用请先升级 **MSDK**。
接口详细说明如下:

#### 接口声明

	/**
	 * @param scene 指定分享到朋友圈, 或者微信会话, 可能值和作用如下:
	 *   WechatScene_Session: 分享到微信会话
	 *   WechatScene_Timeline: 分享到微信朋友圈
	 * @param mediaTagName (必填)请根据实际情况填入下列值的一个, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源
		 "MSG_INVITE";                   // 邀请
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //分享本周最高到朋友圈
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //分享历史最高到朋友圈
		 "MSG_SHARE_MOMENT_CROWN";         //分享金冠到朋友圈
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //分享本周最高给好友
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //分享历史最高给好友
		 "MSG_SHARE_FRIEND_CROWN";          //分享金冠给好友
		 "MSG_friend_exceed"         // 超越炫耀
		 "MSG_heart_send"            // 送心
	 * @param imgPath 本地图片的路径(建议图片小于3MB)
	 * @param messageExt 游戏分享是传入字符串，通过此消息拉起游戏会通过 OnWakeUpNotify(WakeupRet ret)中ret.messageExt回传给游戏
	 * @param messageAction scene为1(分享到微信朋友圈)的情况下才起作用
	 *   WECHAT_SNS_JUMP_SHOWRANK       跳排行
	 *   WECHAT_SNS_JUMP_URL            跳链接
	 *   WECHAT_SNS_JUMP_APP           跳APP
	 * @return void
	 *   通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *     eFlag_Succ: 分享成功
	 *     eFlag_Error: 分享失败
	 */
	void WGSendToWeixinWithPhotoPath(
		const eWechatScene &scene,
		unsigned char *mediaTagName,
		unsigned char *imgPath,
		unsigned char *messageExt,
		unsigned char *messageAction
	);

#### 接口调用
	std::string mediaTagName = " mediaTagName ";
	std::string imgPath = "/storage/emulated/0/test.png";
	std::string messageExt = " messageExt ";
	std::string messageAction = " messageAction ";
	WGPlatform::GetInstance()->WGSendToWeixinWithPhotoPath(
		1,
		(unsigned char *)mediaTagName.c_str(),
		(unsigned char *)imgPath.c_str(),
		(unsigned char *)messageExt.c_str(),
		(unsigned char *)messageAction.c_str()
	);

#### 回调实现(Demo)代码

	virtual void OnShareNotify(ShareRet& shareRet) {
	LOGD("OnShareNotify: platform:%d flag:%d",
			shareRet.platform, shareRet.flag);
	// 处理分享回调
	if (shareRet.platform == ePlatform_QQ) {
		… // 手Q分享返回的回调处理
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 分享成功
			break;
		case eFlag_Error:
			// 分享失败
			break;
			}
		}
	}

#### 注意事项：
- **朋友圈按钮显示有网络延迟且必须在微信5.1及以上版本**

音乐消息分享
------
此种消息分享需要唤起微信客户端, 需要用户参与才能完成整个分享过程, 可以分享给游戏内和游戏外好友, 通常用来邀请游戏外好友。
消息分享出去以后, 消息接收者点击消息可以拉起游戏. 要完成此功能需要用到的接口有: WGSendToWeixinWithMusic, 接口详细说明如下:
#### 接口声明

	/**
	 * 把音乐消息分享给微信好友
	 * @param scene 指定分享到朋友圈, 或者微信会话, 可能值和作用如下:
	 *   WechatScene_Session: 分享到微信会话
	 *   WechatScene_Timeline: 分享到微信朋友圈 (此种消息已经限制不能分享到朋友圈)
	 * @param title 音乐消息的标题（注意：限制长度不超过512Bytes）
	 * @param desc	音乐消息的概要信息（注意：限制长度不超过1KB）
	 * @param musicUrl	音乐消息的目标URL
	 * @param musicDataUrl	音乐消息的数据URL
	 * @param imgData 原图文件数据
	 * @param imgDataLen 原图文件数据长度(图片大小不z能超过10M)
	 * @param messageExt 游戏分享是传入字符串，通过此分享消息拉起游戏会通过 OnWakeUpNotify(WakeupRet ret)中ret.messageExt回传给游戏
	 * @param messageAction scene为WechatScene_Timeline(分享到微信朋友圈)的情况下才起作用
	 *   WECHAT_SNS_JUMP_SHOWRANK       跳排行,查看排行榜
	 *   WECHAT_SNS_JUMP_URL            跳链接,查看详情
	 *   WECHAT_SNS_JUMP_APP            跳APP,玩一把
	 * @return void
	 *   通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
	 *     eFlag_Succ: 分享成功
	 *     eFlag_Error: 分享失败
	 */
	void WGSendToWeixinWithMusic(
		const eWechatScene& scene,
		unsigned char* title,
		unsigned char* desc,
		unsigned char* musicUrl,
		unsigned char* musicDataUrl,
		unsigned char *mediaTagName,
		unsigned char *imgData,
		const int &imgDataLen,
		unsigned char *messageExt,
		unsigned char *messageAction
	);

后端分享
------
游戏需要分享消息给指定好友(指定好友的openId). 此种分享不需要拉起微信客户端, 分享过程无需用户参与, 调用接口即可完成分享. 但是只能分享给游戏内好友. 消息分享出去以后, 消息接收者点击消息可以唤起游戏. 要完成此功能需要用到的接口有: `WGSendToWXGameFriend`. 此接口因历史原因C++接口与Java接口参数顺序不一样，详细描述分别如下：

#### 接口说明

##### C++接口

	/**
	 * 此接口类似WGSendToQQGameFriend, 此接口用于分享消息到微信好友, 分享必须指定好友openid
	 * @param fOpenId 好友的openid
	 * @param title 分享标题
	 * @param description 分享描述
	 * @param mediaId 图片的id 通过后台接口/share/upload_wx获取（注：Android微信5.4-6.1版本该参数不生效，使用的是默认icon）
	 * @param messageExt 游戏分享是传入字符串，通过此消息拉起游戏会通过 OnWakeUpNotify(WakeupRet ret)中ret.messageExt回传给游戏
	 * @param mediaTagName 请根据实际情况填入下列值的一个, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源
		 "MSG_INVITE";                   // 邀请
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //分享本周最高到朋友圈
		 "MSG_SHARE_MOMENT_BEST_SCORE";    //分享历史最高到朋友圈
		 "MSG_SHARE_MOMENT_CROWN";         //分享金冠到朋友圈
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //分享本周最高给好友
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //分享历史最高给好友
		 "MSG_SHARE_FRIEND_CROWN";          //分享金冠给好友
		 "MSG_friend_exceed"         // 超越炫耀
		 "MSG_heart_send"            // 送心
	 * @param extMsdkInfo 游戏自定义透传字段，通过分享结果shareRet.extInfo返回给游戏，游戏可以用extInfo区分request
	*/
	
	bool WGSendToWXGameFriend(
		unsigned char *fOpenId, 
		unsigned char *title,
		unsigned char *description, 
		unsigned char *mediaId,
		unsigned char* messageExt, 
		unsigned char *mediaTagName，
	    unsigned char * msdkExtInfo
	);

##### Java接口

```
/**
 * 此接口类似WGSendToQQGameFriend, 此接口用于分享消息到微信好友, 分享必须指定好友openid
 * @param friendOpenId 好友的openid
 * @param title 分享标题
 * @param description 分享描述
 * @param messageExt 游戏分享是传入字符串，通过此消息拉起游戏会通过 OnWakeUpNotify(WakeupRet ret)中ret.messageExt回传给游戏
 * @param mediaTagName 请根据实际情况填入下列值的一个, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源
	 "MSG_INVITE";                   // 邀请
	 "MSG_SHARE_MOMENT_HIGH_SCORE";    //分享本周最高到朋友圈
	 "MSG_SHARE_MOMENT_BEST_SCORE";    //分享历史最高到朋友圈
	 "MSG_SHARE_MOMENT_CROWN";         //分享金冠到朋友圈
	 "MSG_SHARE_FRIEND_HIGH_SCORE";     //分享本周最高给好友
	 "MSG_SHARE_FRIEND_BEST_SCORE";     //分享历史最高给好友
	 "MSG_SHARE_FRIEND_CROWN";          //分享金冠给好友
	 "MSG_friend_exceed"         // 超越炫耀
	 "MSG_heart_send"            // 送心
 * @param thumbMediaId 图片的id 通过后台接口/share/upload_wx获取（注：Android微信5.4-6.1版本该参数不生效，使用的是默认icon）
 * @param extMsdkInfo 游戏自定义透传字段，通过分享结果shareRet.extInfo返回给游戏，游戏可以用extInfo区分request
*/
public static boolean WGSendToWXGameFriend(
    String friendOpenId, 
    String title, 
    String description, 
    String messageExt,
    String mediaTagName, 
    String thumbMediaId, 
    String msdkExtInfo);
```

#### 接口调用

	std::string friendOpenId = "oGRTijrV0l67hDGN7dstOl8Cp***";
	std::string title = " title ";
	std::string description = " description ";
	std::string thumbMediaId = " thumbMediaId ";
	std::string extinfo = " extinfo ";
	std::string mediaTagName = " mediaTagName ";
	std::string msdkExtInfo = "msdkExtInfo";
	
	WGPlatform::GetInstance()->WGSendToWXGameFriend(
	(unsigned char *) friendOpenId.c_str(),
	(unsigned char *) title.c_str(),
	(unsigned char *) description.c_str(),
	(unsigned char *) thumbMediaId.c_str(),
	(unsigned char *) extinfo.c_str(),
		(unsigned char *) mediaTagName.c_str()，
	    (unsigned char *) msdkExtInfo.c_str()
	);

#### 回调实现(Demo)代码

	virtual void OnShareNotify(ShareRet& shareRet) {
	// 处理分享回调
	if (shareRet.platform == ePlatform_QQ) {
		…
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// 分享成功
			break;
		case eFlag_Error:
			// 分享失败
			break;
		}
		}
	}

链接分享
------

链接消息其实是结构化消息的一种，由于微信结构化消息不支持点击结构体跳转，因此增加了链接消息。链接同样消息可以发送给任意好友，而且点击结构体可以打开链接。因此链接消息一般多用于邀请、炫耀、活动页面分享等。

#### 接口声明

```
/**
 * @param title 链接消息的标题
 * @param desc 链接消息的概要信息
 * @param url 分享的URL
 * @param mediaTagName 请根据实际情况填入下列值的一个, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源
 "MSG_INVITE";                   // 邀请
 "MSG_SHARE_MOMENT_HIGH_SCORE";    //分享本周最高到朋友圈
 "MSG_SHARE_MOMENT_BEST_SCORE";    //分享历史最高到朋友圈
 "MSG_SHARE_MOMENT_CROWN";         //分享金冠到朋友圈
 "MSG_SHARE_FRIEND_HIGH_SCORE";     //分享本周最高给好友
 "MSG_SHARE_FRIEND_BEST_SCORE";     //分享历史最高给好友
 "MSG_SHARE_FRIEND_CROWN";          //分享金冠给好友
 "MSG_friend_exceed"         // 超越炫耀
 "MSG_heart_send"            // 送心
 * @param thumbImgData 结构化消息的缩略图
 * @param thumbImgDataLen 结构化消息的缩略图数据长度
 * @param messageExt 游戏分享是传入字符串，通过此消息拉起游戏会通过 OnWakeUpNotify(WakeupRet ret)中ret.messageExt回传给游戏
 * @return void
 *   通过游戏设置的全局回调的OnShareNotify(ShareRet& shareRet)回调返回数据给游戏, shareRet.flag值表示返回状态, 可能值及说明如下:
 *     eFlag_Succ: 分享成功
 *     eFlag_Error: 分享失败
 */
void WGSendToWeixinWithUrl(
        const eWechatScene& scene,
        unsigned char* title,
        unsigned char* desc,
        unsigned char* url,
        unsigned char* mediaTagName,
        unsigned char* thumbImgData,
        const int& thumbImgDataLen,
        unsigned char* messageExt
        );
```

#### 调用示例

```
String title = "title";
String desc = "desc";
String mediaTagName = "MSG_INVITE";
String messageExt = "message Ext";
Bitmap thumb = BitmapFactory.decodeResource(mMainActivity.getResources(),
		R.drawable.ic_launcher);
byte[] imgData = CommonUtil.bitmap2Bytes(thumb);
String url = "www.qq.com";
if ("cpp".equals(ModuleManager.LANG)) { // 使用C++调用MSDK, 游戏只需要用一种方式即可
	PlatformTest.WGSendToWeixinWithUrl(scene, title, desc, url,
			mediaTagName, imgData, imgData.length, messageExt);
} else if ("java".equals(ModuleManager.LANG)) { // 使用Java调用MSDK
	WGPlatform.WGSendToWeixinWithUrl(scene, title, desc, url, 
			mediaTagName, imgData, imgData.length, messageExt);
}
```

分享到游戏中心
------
登录后使用此接口可分享消息到微信游戏中心，在游戏中心的我的消息中查看。 这种消息主要包含两部分，消息体和附加按钮，消息体主要包含展示内容附加按钮主要定义了点击以后的跳转动作（拉起APP，拉起页面、拉起排行榜）。

#### 接口声明

```
    /**
     * 此接口会分享消息到微信游戏中心内的消息中心，这种消息主要包含两部分，消息体和附加按钮，消息体主要包含展示内容
     * 附加按钮主要定义了点击以后的跳转动作（拉起APP，拉起页面、拉起排行榜），消息类型和按钮类型可以任意组合
     * @param fopenid 好友的openid
     * @param title 游戏消息中心分享标题
     * @param content 游戏消息中心分享内容
     * @param pInfo 消息体，这里可以传入四种消息类型，均为WXMessageTypeInfo的子类：
     * 		TypeInfoImage: 图片消息（下面的几种属性全都要填值）
     * 			std::string pictureUrl; // 图片缩略图
     * 			int height; // 图片高度
     * 			int width; // 图片宽度
     * 		TypeInfoVideo: 视频消息（下面的几种属性全都要填值）
     * 			std::string pictureUrl; // 视频缩略图
     * 			int height; // 视频高度
     * 			int width; // 视频宽度
     * 			std::string mediaUrl; // 视频链接
     * 		TypeInfoLink: 链接消息（下面的几种属性全都要填值）
     * 			std::string pictureUrl; // 在消息中心的消息图标Url（图片消息中，此链接则为图片URL)
     * 			std::string targetUrl; // 链接消息的目标URL，点击消息拉起此链接
     * 		TypeInfoText: 文本消息
     *
     * @param pButton 按钮效果，这里可以传入三种按钮类型，均为WXMessageButton的子类：
     * 		ButtonApp: 拉起应用（下面的几种属性全都要填值）
     * 			std::string name; // 按钮名称
     * 			std::string messageExt; // 附加自定义信息，通过按钮拉起应用时会带回游戏
     * 		ButtonWebview: 拉起web页面（下面的几种属性全都要填值）
     * 			std::string name; // 按钮名称
     * 			std::string webViewUrl; // 点击按钮后要跳转的页面
     * 		ButtonRankView: 拉起排行榜（下面的几种属性全都要填值）
     * 			std::string name; // 按钮名称
     * 			std::string title; // 排行榜名称
     * 			std::string rankViewButtonName; // 排行榜中按钮的名称
     * 			td::string messageExt; // 附加自定义信息，通过排行榜中按钮拉起应用时会带回游戏
     * @param msdkExtInfo 游戏自定义透传字段，通过分享结果shareRet.extInfo返回给游戏
     *  @return 参数异常或未登陆
     */
     bool WGSendMessageToWechatGameCenter(
        unsigned char* fOpenid,
	    unsigned char* title,
	    unsigned char* content,
	    WXMessageTypeInfo *pInfo,
	    WXMessageButton *pButton,
	    unsigned char* msdkExtInfo
    );
```

#### 调用示例

```
	String title = "分享title";
	String content = "分享content---test";
	String msdkExtInfo = "分享到微信游戏中心的回调";
    MsgLink msgBase = new MsgLink(
        "http://download.wegame.qq.com/wepang/RedGame_Winner_140.png",
        "http://www.qq.com");
    BtnWeb btnBase = new BtnWeb("跳转网页", "http://www.qq.com");

	if ("cpp".equals(ModuleManager.LANG)) {
	    PlatformTest.WGSendMessageToWechatGameCenter();
	} else if ("java".equals(ModuleManager.LANG)) {
	    WGPlatform.WGSendMessageToWechatGameCenter(openid, title, content, msgBase, btnBase, msdkExtInfo);
	}
```

#### 注意事项
1. 点击 跳转排行榜 按钮会先跳转到此游戏详情页，用户可在此游戏详情页查看排行榜。且 ButtonRankView 中的 title, rankViewButtonName 无效，界面不会展示这两个参数。


Deeplink链接跳转
------

Deeplink 可支持分别跳转至微信游戏中心原生页面，和活动页面，具体表现方案和显示入口可以根据游戏的实际情况来定制。游戏中心原生页面包括：微信游戏中心首页、微信游戏中心详情页、微信游戏中心游戏库等；通过游戏后台参数设定来实现。活动页面包括:游戏的H5页面，通过游戏后台配置跳转地址来实现

#### 接口声明

```
    /**
     * 打开微信deeplink（deeplink功能的开通和配置请联系微信游戏中心）
	 * @param link 具体跳转deeplink，可填写为：
	 *             INDEX：跳转微信游戏中心首页
     *             DETAIL：跳转微信游戏中心详情页
     *             LIBRARY：跳转微信游戏中心游戏库
     *             具体跳转的url （需要在微信游戏中心先配置好此url）
     */
    void WGOpenWeiXinDeeplink(unsigned char* link);
```

#### 调用示例

```
		String[] choices = { "游戏中心首页(INDEX)", "游戏中心详情页(DETAIL)", "游戏中心游戏库(LIBRARY)", "跳转url页面" };
		ContextThemeWrapper context = new ContextThemeWrapper (this.mMainActivity, R.style.DialogTheme);
		AlertDialog dialog = new AlertDialog.Builder(context).setItems(choices, new OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						String link = "";
						switch (which) {
						case 0:
							link = "INDEX";
							break;
						case 1:
							link = "DETAIL";
							break;
						case 2:
							link = "LIBRARY";
							break;
						case 3:
							link = "http://www.qq.com/";
							break;
						}
						

						if ("java".equals(ModuleManager.LANG)) {
							WGPlatform.WGOpenWeiXinDeeplink(link);
						} else {
							PlatformTest.WGOpenWeiXinDeeplink(link);
						}
					}

				}).create();
		dialog.show();
```

Android微信登录不了检查步骤
------

### 第一步： 检查Log中是否有

	lauchWXPlatForm wx SendReqRet: true

有这一句表示已经成功发送请求到微信

如果微信客户端被不能被拉起来，请查看 第二步， 
如果微信客户端被拉起了，但是没有回调，请查看 第三步

### 第二步： 检查签名和包名

下载[https://res.wx.qq.com/open/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android2.apk](https://res.wx.qq.com/open/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android2.apk)， 将此apk安装到手机上， 在输入框中输入游戏的签名，点击按钮读取游戏包的签名。

![检查签名](./wechat_GenSig.png "检查签名")

检查上述工具获取到的签名是否和微信后台配置的签名一致（微信后台配置的签名信息查询请RTX联系MSDK）

### 第三步： 检查WXEntryActivity.java放置的位置（此文件在MSDKSample中）

此文件一定要放在 游戏+.wxapi 下面，例如游戏的包名为：com.tencent.msdkgame， 则WXEntryActivity.java 应该放在com.tencent.msdkgame.wxapi下。同时查看WXEntryActivity里面的内容是否和下面的一致

	/**
	 * !!此文件的代码逻辑部分使用者不要修改，MSDK从1.7开始，父类名称由WXEntryActivity改为BaseWXEntryActivity，如果此文件出错请优先检查此项
	 */
	public class WXEntryActivity extends com.tencent.msdk.weixin.BaseWXEntryActivity { }

此步骤没问题请查看 第四步


### 第四步：检查handleCallback

游戏的Launch Activity的onCreate和onNewIntent里面是否调用了WGPlatform.handleCallback。


### 第五步：检查游戏的全局Observer是否设置

检查游戏有没有正确调用WGSetObserver（C++层和Java层）。


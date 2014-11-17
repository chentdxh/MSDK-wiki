
MSDK 微信 相关模块
=======


接入配置
------

#### AndroidMainfest配置

- 游戏按照下面的事例填写配置信息。

		<!-- TODO SDK接入 微信接入配置 START -->
		<activity
   	 		android:name="com.example.wegame.wxapi.WXEntryActivity"
    		android:excludeFromRecents="true"
    		android:exported="true"
    		android:label="WXEntryActivity"
    		android:launchMode="singleTop"
    		android:taskAffinity="com.example.wegame.diff" >
    		<intent-filter>
        		<action android:name="android.intent.action.VIEW" />
        		<category android:name="android.intent.category.DEFAULT" />
        		<data android:scheme="wxcde873f99466f74a" />
    		</intent-filter>
		</activity>
		<!-- TODO SDK接入 微信接入配置 END -->

- **注意事项：**
	
 - 在应用包名+.wxapi下面放置WXEntryActivity.java.
 - 目前微信Webview中调起第三方App可以通过自定义scheme的形式，在AndroidManifest里在需要被微信拉起的Activit(通常是Launch)y定义中加入intent-filter，定义独有的scheme（建议全部用小写，不可以以http或者https开头，如图1）。自定义scheme建议游戏直接使用自己的包名， 例如comtencentpeng://:
	
	![comtencentpeng](/comtencentpeng.png)
 
#### Appid 配置：
 - 这部分内容在Java层初始化部分中已经完成, **不能用MSDKSample的appId和appKey进行联调, 游戏需要使用自己的appId和appKey.**

		// 游戏替换此appId为自己的appId 
		baseInfo.wxAppId = "wxcde873f99466f74a";
		// 游戏替换此appId为自己的appKey
		baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4dea";

	


			


授权登录
------

拉起微信客户端授权, 授权完成返回游戏openId、accessToken、refreshToken, pf, pfKey几种票据. 要完成此功能需要调用WGLogin接口, 接口详细说明如下:

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

	WGPlatform.WGLogin(ePlatform_Weixin);	//调用微信客户端或web授权 
回调接受事例：

	virtual void OnLoginNotify(LoginRet& loginRet) {
	 LOGD("OnLoginNotify: flag:%d platform:%d OpenId:%s, Token Size: %d",
            loginRet.flag, loginRet.platform, loginRet.open_id.c_str(), loginRet.token.size());

    if (loginRet.platform == ePlatform_QQ) {
        ...
    } else if (loginRet.platform == ePlatform_Weixin) {
        // 读取微信的登陆票据
        switch (loginRet.flag) {
        case eFlag_Succ: {
            // 进行正常游戏登陆逻辑
            std::string accessToken = "";
            std::string refreshToken = "";
            for (int i = 0; i < loginRet.token.size(); i++) {
                if (loginRet.token.at(i).type == eToken_WX_Access) {
                    accessToken.assign(loginRet.token.at(i).value);
                } else if (loginRet.token.at(i).type == eToken_WX_Refresh) {
                    refreshToken.assign(loginRet.token.at(i).value);
                }
            }
            LOGD("accessToken : %s", accessToken.c_str());
            LOGD("payToken : %s", refreshToken.c_str());
            break;
        }
        case eFlag_WX_NotSupportApi:
            // 没有安装或者版本太低, 引导用户下载新版微信
            break;

        case eFlag_WX_UserCancel:
        case eFlag_WX_UserDeny:
            // 用户取消, 提示用户重新授权
            break;
        case eFlag_WX_AccessTokenExpired:
            // 调用WGRefreshWxToken, 刷新accessToken
            break;
        case eFlag_WX_RefreshTokenExpired:
            // refreshToken过期, 提示用户重新授权
            break;
        case eFlag_WX_LoginFail:
        case eFlag_Error:
            // 登陆过程中网络失败, 或者其他错误, 引导用户重新授权即可
            break;
        case eFlag_WX_RefreshTokenSucc:
            // WGRefreshWXToken调用成功, 成功用当前的refreshToken换到新的accessToken
            break;
        case eFlag_WX_RefreshTokenFail:
            // WGRefreshWXToken调用失败, 游戏自己决定是否需要重试 WGRefreshWXToken
            break;
        }
    }
	}

#### 注意事项：

1.	微信授权需要保证微信版本高于4.0

- 拉起微信时候, 微信会检查应用程序的签名和微信后台配置的签名是否匹配(此签名在申请微信appId时提交过), 如果不匹配则无法唤起已经授权过的微信客户端.

- 微信授权过程中, 点击左上角的 返回 按钮, 可能会导致没有授权回调, 游戏需要自己倒计时, 超时则算作用户取消授权.
- WXEntryActivity.java 位置不正确（必须在包名/wxapi 目录下）则不能收到回调.
- **在微信未登录的情况下, 游戏拉起微信输入用户名密码以后登录, 可能会没有登录回调, 这是微信客户端已知BUG. 游戏在调用WGLogin登录之前可以开始一个倒计时, 倒计时完毕如果没有收到回调则算作超时, 让用户回到登录界面.**

常见登陆问题
------
####　游戏无法拉起微信授权检查步骤

>第一步： 
>检查Log中是否有

>lauchWXPlatForm wx SendReqRet: true

>有这一句表示已经成功发送请求到微信
		
>如果微信客户端被不能被拉起来，请查看 第二步， 
>如果微信客户端被拉起了，但是没有回调，请查看 第三步

>第二步： 检查签名和包名
	
>下载[https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk](https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk "检查签名apk")， 将此apk安装到手机上， 在输入框中输入游戏的签名，点击按钮读取游戏包的签名。
	
>检查上述工具获取到的签名是否和微信后台配置的签名一致（微信后台配置的签名信息查询请RTX联系MSDK）
	
	
>第三步： 检查WXEntryActivity.java放置的位置（此文件在MSDKSample中）
	
>此文件一定要放在 游戏+.wxapi 下面，例如游戏的包名为：com.tencent.msdkgame， 则WXEntryActivity.java 应该放在com.tencent.msdkgame.wxapi下。
	
>此步骤没问题请查看 第四步
	
	
>第四步：检查handleCallback
	
>游戏的Launch Activity的onCreate和onNewIntent里面是否调用了WGPlatform.handleCallback。
	
	
>第五步：检查游戏的全局Observer是否设置
	
>检查游戏有没有正确调用WGSetObserver（C++层和Java层）。

查询个人信息
------

用户通过手Q授权后只能获取到openId和accessToken, 游戏需要用户昵称, 头像等其他信息用于显示, SDK目前能获取到的信息包括nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city. 要完成此功能需要用到的接口有: WGQueryWXMyInfo, 接口详细说明如下:

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

结构化消息分享
------

此种消息分享需要唤起微信客户端, 需要用户参与才能完成整个分享过程, 可以分享给游戏内和游戏外好友, 通常用来邀请游戏外好友. 
消息分享出去以后, 消息接收者点击消息可以拉起游戏. 要完成此功能需要用到的接口有: WGSendToWeixin, 接口详细说明如下:

#### 接口声明

	/**
	 * @param title 结构化消息的标题
	 * @param desc 结构化消息的概要信息
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
2. 缩略图大小不能超过32k, 长宽比无限制，超出大小则不能拉起微信.
3. 分享需要使用到sd卡, 没有sd卡或者sd卡被占用均会照成分享失败


大图消息分享
------
此种消息分享需要唤起微信, 需要用户参与才能完成整个分享过程, 可以分享给游戏内和游戏外好友, 通常用来炫耀成绩或者其他需要详图的功能. 此种消息可以分享到会话(好友)或者朋友圈, 微信4.0及以上支持分享到会话, 微信4.2及以上支持分享到朋友圈. 图片大小不能大于10M, 分享的图片微信会做相应的压缩处理. 要完成此功能需要用到的接口有: WGSendToWeixinWithPhoto, 接口详细说明如下:
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
	 * @param imgDataLen 原图文件数据长度(图片大小不能超过10M)
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
	 * @param title 音乐消息的标题
	 * @param desc	音乐消息的概要信息
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
游戏需要分享消息给指定好友(指定好友的openId). 此种分享不需要拉起微信客户端, 分享过程无需用户参与, 调用接口即可完成分享. 但是只能分享给游戏内好友. 消息分享出去以后, 消息接收者点击消息可以唤起游戏. 要完成此功能需要用到的接口有: WGSendToWXGameFriend, 接口详细说明如下:

#### 接口说明

	/**
	 * 此接口类似WGSendToQQGameFriend, 此接口用于分享消息到微信好友, 分享必须指定好友openid
	 * @param fOpenId 好友的openid
	 * @param title 分享标题
	 * @param description 分享描述
	 * @param mediaId 图片的id 通过uploadToWX接口获取
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

Android微信登录不了检查步骤
------

### 第一步： 检查Log中是否有

	lauchWXPlatForm wx SendReqRet: true

有这一句表示已经成功发送请求到微信

如果微信客户端被不能被拉起来，请查看 第二步， 
如果微信客户端被拉起了，但是没有回调，请查看 第三步

### 第二步： 检查签名和包名

下载[https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk](https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk)， 将此apk安装到手机上， 在输入框中输入游戏的签名，点击按钮读取游戏包的签名。

检查上述工具获取到的签名是否和微信后台配置的签名一致（微信后台配置的签名信息查询请RTX联系MSDK）


### 第三步： 检查WXEntryActivity.java放置的位置（此文件在MSDKSample中）

此文件一定要放在 游戏+.wxapi 下面，例如游戏的包名为：com.tencent.msdkgame， 则WXEntryActivity.java 应该放在com.tencent.msdkgame.wxapi下。

此步骤没问题请查看 第四步


### 第四步：检查handleCallback

游戏的Launch Activity的onCreate和onNewIntent里面是否调用了WGPlatform.handleCallback。


### 第五步：检查游戏的全局Observer是否设置

检查游戏有没有正确调用WGSetObserver（C++层和Java层）。


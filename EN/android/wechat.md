    
MSDK  WeChat-related Modules
=======


Access configuration
------

#### AndroidMainfest configuration

Developers should fill in configuration information according to the following example.

```
<!-- TODO SDK Access  WeChat access configuration START -->
<activity
	<!-- Note: this place should be changed to  package name.wxapi.WXEntryActivity -->
 	android:name="com.example.wegame.wxapi.WXEntryActivity"
	android:excludeFromRecents="true"
	android:exported="true"
	android:label="WXEntryActivity"
	android:launchMode="singleTop"
	<!-- Note: this place should be changed to  package name.diff -->
	android:taskAffinity="com.example.wegame.diff" >
	<intent-filter>
		<action android:name="android.intent.action.VIEW" />
		<category android:name="android.intent.category.DEFAULT" />
		<!-- Note: this place should be changed to  the game’s WeChat appid -->
		<data android:scheme="wxcde873f99466f74a" />
	</intent-filter>
</activity>
<!-- TODO SDK Access  WeChat access configuration END -->
```

##### Notes:
	
* Place the following `WXEntryActivity.java` below `application package name + .wxapi`
* In Activity accessed by WeChat, there are `three places which need be modified by the game developer himself` (there are marks in the above example). 
* WeChat is also called Weixin, or WX for short

#### Appid configuration:

AppID configuration has been completed when the Java layer was initialized. **It is not allowed to use MSDKSample’s appId and appKey for joint debugging; the game needs to use its own appId and appKey. **

```
public void onCreate(Bundle savedInstanceState) {
	...
	//The game must use its own QQ AppId for joint debugging
    baseInfo.qqAppId = "1007033***";
    baseInfo.qqAppKey = "4578e54fb3a1bd18e0681bc1c7345***";

    //The game must use its own WeChat AppId for joint debugging
    baseInfo.wxAppId = "wxcde873f99466f***"; 
    baseInfo.wxAppKey = "bc0994f30c0a12a9908e353cf05d4***";

    //The game must use its own payment offerId for joint debugging
    baseInfo.offerId = "100703***";
	...
	WGPlatform.Initialized(this, baseInfo);
	WGPlatform.handleCallback(getIntent());
	...
}
```

#### Method which must be called:

The game needs to call `handleCallback` in `onCreat()` and `onNewIntent()` of its own `launchActivity` (the first Activity started by the game); otherwise, this can cause no login callback and other problems.

- **onCreate**:

```	
@Override
protected void onCreate(Bundle savedInstanceState) {
	super.onCreate(savedInstanceState);
	......
    if (WGPlatform.wakeUpFromHall(this.getIntent())) {
    	// The platform starting the game is the Game Hall
    	Logger.d("LoginPlatform is Hall");
    } else {  
    	// The platform starting the game is not the Game Hall
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

Query personal information
------

After the user authorizes the game through WeChat, the user can only get openId and accessToken. The game requires the user’s nickname, head portrait and other information for display. The personal information currently obtained by SDK includes: nickname, openId, gender, pictureSmall, pictureMiddle and pictureLarge, provice and city. Interfaces required to accomplish this function include: WGQueryWXMyInfo. The detailed description of the interface is as follows:

#### Interface declaration:

	/**
	 *   Callback is in OnRelationNotify, in which RelationRet.persons is a Vector. The first item in Vector is the user’s personal info.
	 *   Personal info includes nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city
	 */
	bool WGQueryWXMyInfo();

#### Call demo code:

	WGPlatform::GetInstance()->WGQueryWXMyInfo();

#### Callback demo code is as follows:

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // What is stored in relationRet.persons.at(0) is personal info
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


Query game friends’ info
------

After the user authorizes the game through WeChat, it is needed to launch game friends’ information (for example, friends’ leaderboard). The information which SDK can currently obtain includes: nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice and city. Interfaces required to accomplish this function include: WGQueryWXGameFriendsInfo. The detailed description of the interface is as follows:
####  Interface declaration：

	/**
	 *   Obtain WeChat friends’ info. Callback is in OnRelationNotify,
	 *   Callback is in OnRelationNotify, in which RelationRet.persons is a Vector. The contents in Vector are friends’ info.
    * Friends’ info includes nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city
	 */
	bool WGQueryWXGameFriendsInfo();

The call result of the interface returns data to the game through OnRelationCallBack(RelationRet& relationRet). Persons property of RelationRet object is a Vector <PersonInfo>, in which every PersonInfo object is friends’ info. Friends’ info includes: nickname, openId, gender, pictureSmall, pictureMiddle, pictureLarge, provice, city.

#### Call demo code:

	WGPlatform::GetInstance()->WGQueryWXGameFriendsInfo();

#### Callback demo code is as follows:

	virtual void OnRelationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
	case eFlag_Succ: {
		// What is stored in relationRet.persons.at(0) is personal info
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

Structured message sharing
------

This type of message sharing needs to evoke WeChat client and requires the user’s participation. Only so can the entire sharing process be completed. It can be used to share messages with both game friends and non-game friends. It is usually used to invite non-game friends.
After the message is shared out, as long as the message recipient clicks on the message, the game can be launched. Interfaces required to accomplish this function include: WGSendToWeixin. The detailed description of the interface is as follows:

####  Interface declaration

	/**
	 * @param title: structured message’s title (Note: size should not exceed 512Bytes)
	 * @param desc: structured message’s summary (Note: size should not exceed 1KB)
	 * @param mediaTagName: please fill in one of the following values according to the actual situation. This value will be passed to WeChat for statistical purposes. When the shared message returns, it will also bring back the value, which can be used to distinguish the source of the shared message
		 "MSG_INVITE";                   // invite
		 "MSG_SHARE_MOMENT_HIGH_SCORE";  //share the week’s highest score to the Wechat moment
		 "MSG_SHARE_MOMENT_BEST_SCORE";    // share the history’s highest score to the Wechat moment
		 "MSG_SHARE_MOMENT_CROWN";    // share the gold crown to the Wechat moment
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     // share the week’s highest score to friends
		 "MSG_SHARE_FRIEND_BEST_SCORE";     // share the history’s highest score to friends
		 "MSG_SHARE_FRIEND_CROWN";          // share the gold crown to friends
		 "MSG_friend_exceed"         // show off exceeding
		 "MSG_heart_send"            // send heart
	 * @param thumbImgData: structured message’s thumbnail
	 * @param thumbImgDataLen: structured message’s thumbnail length (Note: size should not exceed 32KB)
	 * @param messageExt: a string passed in by the game in sharing; the player can launch the game through the message, and the message is returned to the game through ret.messageExt of OnWakeUpNotify(WakeupRet ret)
	 * @return void
* Return data to the game through OnShareNotify(ShareRet& shareRet), a global callback set by the game; shareRet.flag value represents the return status, and its possible values and descriptions are as follows:
* EFlag_Succ: share success
* EFlag_Error: share failure
	 */			
	 void WGSendToWeixin(
		unsigned char* title, 
		unsigned char* desc,
		unsigned char* mediaTagName,
		unsigned char* thumbImgData,
		const int& thumbImgDataLen, 
		unsigned char* messageExt
	); 

#### Call the interface

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

#### Callback demo code

	virtual void OnShareNotify(ShareRet& shareRet) {
	// handle share callback
	if (shareRet.platform == ePlatform_QQ) {
		…
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// share success
			break;
		case eFlag_Error:
			// share failure
			break;
		}
		}
	}

#### Notes:

1. The requisite for WeChat sharing is that WeChat version must be higher than 4.0
2. The size of thumbnail can not exceed 32k, and its length/width ratio is unlimited. If its size exceeds 32k, it can’t launch WeChat.
3. Sharing needs to use the SD card. If there is no SD card or SD card is occupied, this can lead to share failure


Big picture message sharing
------

This type of message sharing needs to evoke WeChat and requires the user’s participation, so that to complete the whole sharing process. Big pictures can be shared with game friends and non-game friends. They are usually used to show off scores or used for other functions which need detailed pictures. Such message can be shared to conversation (friends) or the Wechat moment. WeChat 4.0 and higher versions support to share messages to conversation, and WeChat 4.2 and higher versions support to share messages to the Wechat moment. 

### Use image data for sharing

The interface uses image data for sharing. It is called `WGSendToWeixinWithPhoto`. It is recommended that the size of the image passed in should not exceed 1MB in the use of the interface. Otherwise, the image sharing will easily fail in WeChat 6.1 and higher versions. The detailed description of the interface is as follows:

#### Interface declaration

	/**
	 * param scene: share messages to the specified Wechat moment or WeChat conversation, possible values and actions are as follows:
	 *   WechatScene_Session: Share messages to WeChat conversation 
	 *   WechatScene_Timeline: Share messages to Wechat moment 
	 * @param mediaTagName: please fill in one of the following values according to the actual situation. This value will be passed to WeChat for statistical purposes. When the shared message returns, it will also bring back the value, which can be used to distinguish the source
		 "MSG_INVITE";                   //invite
		 "MSG_SHARE_MOMENT_HIGH_SCORE";  //share the week’s highest score to the Wechat moment
		 "MSG_SHARE_MOMENT_BEST_SCORE";    // share the history’s highest score to the Wechat moment
		 "MSG_SHARE_MOMENT_CROWN";    // share the gold crown to the Wechat moment
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     // share the week’s highest score to friends
		 "MSG_SHARE_FRIEND_BEST_SCORE";     // share the history’s highest score to friends
		 "MSG_SHARE_FRIEND_CROWN";          // share the gold crown to friends
		 "MSG_friend_exceed"         // show off exceeding
		 "MSG_heart_send"            // send heart
	 * @param imgData: original image file data
	 * @param imgDataLen: original image file data length (it is recommended that image size should not exceed 1MB)
	 * @param messageExt: a string passed in by the game in sharing; the player can launch the game through the message, and the message is returned to the game through ret.messageExt of OnWakeUpNotify(WakeupRet ret)
	 * @param messageAction: Only when scene is1 (share messages to Wechat moment) can it work
	 *   WECHAT_SNS_JUMP_SHOWRANK //skip to the leaderboard
	 *   WECHAT_SNS_JUMP_URL      //skip URL
	 *   WECHAT_SNS_JUMP_APP          // skip APP
	 * @return void
	 *   Return data to the game through OnShareNotify(ShareRet& shareRet), a global callback set by the game; shareRet.flag value represents the return status, and its possible values and descriptions are as follows: 
	 *     EFlag_Succ: share success
	 *     EFlag_Error: share failure
	 */
	void WGSendToWeixinWithPhoto(
	const eWechatScene &scene,
	unsigned char *mediaTagName,
	unsigned char *imgData, 
	const int &imgDataLen,
	unsigned char *messageExt,
	unsigned char *messageAction
	);

#### Call the interface

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

#### Callback demo code

	virtual void OnShareNotify(ShareRet& shareRet) {
	LOGD("OnShareNotify: platform:%d flag:%d",
			shareRet.platform, shareRet.flag);
	// handle share callback
	if (shareRet.platform == ePlatform_QQ) {
		… // the callback handling of mobile QQ share returns
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// share success
			break;
		case eFlag_Error:
			// share failure
			break;
			}
		}
	}

### Use image path for sharing

The interface uses image data for sharing. It is called `WGSendToWeixinWithPhotoPath`. It is recommended that the size of the image passed in should be less than 3MB in the use of the interface. The interface is added in **MSDK2.7.2a** and higher versions. If you need to use it, please first upgrade **MSDK**.
The detailed description of the interface is as follows:

#### Interface declaration

	/**
	 * @param scene: share messages to the specified Wechat moment or WeChat conversation, possible values and actions are as follows:
	 *   WechatScene_Session: Share messages to WeChat conversation
	 *   WechatScene_Timeline: Share messages to Wechat moment
	 * @param mediaTagName: (required) please fill in one of the following values according to the actual situation. This value will be passed to WeChat for statistical purposes. When the shared message returns, it will also bring back the value, which can be used to distinguish the source
		 "MSG_INVITE";                   //invite
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //share the week’s highest score to the Wechat moment
		 "MSG_SHARE_MOMENT_BEST_SCORE";    // share the history’s highest score to the Wechat moment
		 "MSG_SHARE_MOMENT_CROWN";         //share the gold crown to the Wechat moment
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //share the week’s highest score to friends
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //share the history’s highest score to friends
		 "MSG_SHARE_FRIEND_CROWN";          //share the gold crown to friends
		 "MSG_friend_exceed"         // show off exceeding
		 "MSG_heart_send"            // send heart
	 * @param imgPath: local image path (it is recommended that image size should be less than 3MB)
	 * @param messageExt: a string passed in by the game in sharing; the player can launch the game through the message, and the message is returned to the game through ret.messageExt of OnWakeUpNotify(WakeupRet ret)
	 * @param messageAction: Only when scene is1 (share messages to Wechat moment) can it work
	 *   WECHAT_SNS_JUMP_SHOWRANK       //skip to the leaderboard
	 *   WECHAT_SNS_JUMP_URL            //skip the link
	 *   WECHAT_SNS_JUMP_APP           // skip APP
	 * @return void
	 *  Return data to the game through OnShareNotify(ShareRet& shareRet), a global callback set by the game; shareRet.flag value represents the return status, and its possible values and descriptions are as follows: 
	 *     eFlag_Succ: share success
	 *     eFlag_Error: share failure
	 */
	void WGSendToWeixinWithPhotoPath(
		const eWechatScene &scene,
		unsigned char *mediaTagName,
		unsigned char *imgPath,
		unsigned char *messageExt,
		unsigned char *messageAction
	);

#### Call the interface
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

#### Callback demo code

	virtual void OnShareNotify(ShareRet& shareRet) {
	LOGD("OnShareNotify: platform:%d flag:%d",
			shareRet.platform, shareRet.flag);
	// handle share callback
	if (shareRet.platform == ePlatform_QQ) {
		… //  the callback handling of mobile QQ share returns
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// share success
			break;
		case eFlag_Error:
			// share failure
			break;
			}
		}
	}

#### Notes:
- ** The button display in the Wechat moment has the network delay and requires WeChat 5.1and higher versions **

Music message sharing
------
This type of message sharing needs to evoke WeChat client and requires the user’s participation. Only so can the entire sharing process be completed. It can be used to share messages with both game friends and non-game friends. It is usually used to invite non-game friends.
After the message is shared out, as long as the message recipient clicks on the message, the game can be launched. Interfaces required to accomplish this function include: WGSendToWeixinWithMusic. The detailed description of the interface is as follows:

#### Interface declaration

	/**
	 * Share music messages with WeChat friends
 	 * @param scene: share messages to the specified Wechat moment or WeChat conversation, possible values and actions are as follows:
 	 *   WechatScene_Session: Share messages to WeChat conversation
 	 *   WechatScene_Timeline: Share messages to WeChat moment (such messages are not allowed to be shared to the Wechat moment)
 	 * @param title: music message’s title (Note: size should not exceed 512Bytes)
 	 * @param desc: music message’s summary info (Note: size should not exceed 1KB)
 	 * @param musicUrl: music message’s target URL
 	 * @param musicDataUrl: music message’s data URL
 	 * @param imgData: original image file data
	 * @param imgDataLen: original image file data length (image size can not exceed 10M)
 	 * @param messageExt: a string passed in by the game in sharing; the player can launch the game through the message, and the message is returned to the game through ret.messageExt of OnWakeUpNotify(WakeupRet ret)
 	 * @param messageAction: Only when scene is WechatScene_Timeline (share messages to WeChat moment) can it work
 	 *   WECHAT_SNS_JUMP_SHOWRANK // skip to the leaderboard. View the leaderboard
 	 *   WECHAT_SNS_JUMP_URL  //skip to URL. View details
 	 *   WECHAT_SNS_JUMP_APP  // skip to APP. Play it
	 * @return void
	 *   Return data to the game through OnShareNotify(ShareRet& shareRet), a global callback set by the game; shareRet.flag value represents the return status, and its possible values and descriptions are as follows: 
	 *     eFlag_Succ: share success
	 *     eFlag_Error: share failure
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

Backend sharing
------
The game needs to share the message to a specified friend (the designated friend’s openId). This type of message sharing doesn’t need to evoke WeChat client and doesn’t require the user’s participation. Only calling the interface can complete the sharing. It can only be used to share messages with game friends. After the message is shared out, as long as the message recipient clicks on the message, the game can be launched. Interfaces required to accomplish this function include: `WGSendToWXGameFriend`. Due to historical reasons, the C ++ interface and Java interface of the interface do not have the same parameter order. The detailed description of the interface is as follows:

#### Interface description

##### C++ interface

	/**
	 * This interface is similar to WGSendToQQGameFriend. This interface is used to share messages to WeChat friends and must specify a friend’s opened for sharing messages
	 * @param fOpenId: Friend’s openid
	 * @param title: shared message’s title
	 * @param description: shared message’s description
	 * @param mediaId: Image’s id is obtained through the backend interface /share/upload_wx (Note: in Android WeChat 5.4-6.1 versions, this parameter does not take effect and uses the default icon)
	 * @param messageExt: a string passed in by the game in sharing; the player can launch the game through the message, and the message is returned to the game through ret.messageExt of OnWakeUpNotify(WakeupRet ret)
	 * @param mediaTagName: please fill in one of the following values according to the actual situation. This value will be passed to WeChat for statistical purposes. When the shared message returns, it will also bring back the value, which can be used to distinguish the source
		 "MSG_INVITE";                   //invite
		 "MSG_SHARE_MOMENT_HIGH_SCORE";    //share the week’s highest score to the Wechat moment
		 "MSG_SHARE_MOMENT_BEST_SCORE";    // share the history’s highest score to the Wechat moment
		 "MSG_SHARE_MOMENT_CROWN";         //share the gold crown to the Wechat moment
		 "MSG_SHARE_FRIEND_HIGH_SCORE";     //share the week’s highest score to friends
		 "MSG_SHARE_FRIEND_BEST_SCORE";     //share the history’s highest score to friends
		 "MSG_SHARE_FRIEND_CROWN";          //share the gold crown to friends
		 "MSG_friend_exceed"         // show off exceeding
		 "MSG_heart_send"            // send heart
	 * @param extMsdkInfo: The game’s custom transparent transmission field; the sharing result is returned to the game through shareRet.extInfo. The game can use extInfo to distinguish request
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

##### Java interface

```
/**
 * This interface is similar to WGSendToQQGameFriend. This interface is used to share messages to WeChat friends and must specify a friend’s opened for sharing messages
 * @param friendOpenId: Friend’s openid
 * @param title: sharing message’s title
 * @param description: shared message’s description
 * @param messageExt: a string passed in by the game in sharing; the player can launch the game through the message, and the message is returned to the game through ret.messageExt of OnWakeUpNotify(WakeupRet ret)
 * @param mediaTagName: please fill in one of the following values according to the actual situation. This value will be passed to WeChat for statistical purposes. When the shared message returns, it will also bring back the value, which can be used to distinguish the source
	 "MSG_INVITE";                   //invite
	 "MSG_SHARE_MOMENT_HIGH_SCORE";    //share the week’s highest score to the Wechat moment
	 "MSG_SHARE_MOMENT_BEST_SCORE";    // share the history’s highest score to the Wechat moment
	 "MSG_SHARE_MOMENT_CROWN";         //share the gold crown to the Wechat moment
	 "MSG_SHARE_FRIEND_HIGH_SCORE";     //share the week’s highest score to friends
	 "MSG_SHARE_FRIEND_BEST_SCORE";     //share the history’s highest score to friends
	 "MSG_SHARE_FRIEND_CROWN";          //share the gold crown to friends
	 "MSG_friend_exceed"         // show off exceeding
	 "MSG_heart_send"            // send heart
 * @param thumbMediaId: Image’s id is obtained through the backend interface /share/upload_wx (Note: in Android WeChat 5.4-6.1 versions, this parameter does not take effect and uses the default icon)
 * @param extMsdkInfo: The game’s custom transparent transmission field; the sharing result is returned to the game through shareRet.extInfo. The game can use extInfo to distinguish request
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

#### Call the interface

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

#### Callback demo code

	virtual void OnShareNotify(ShareRet& shareRet) {
	// handle share callback
	if (shareRet.platform == ePlatform_QQ) {
		…
	} else if (shareRet.platform == ePlatform_Weixin) {
		switch (shareRet.flag) {
		case eFlag_Succ:
			// share success
			break;
		case eFlag_Error:
			// share failure
			break;
		}
		}
	}

Link sharing
------

Link message is actually a type of structured message. Because WeChat structured message does not support skipping by clicking the structure, it adds the link message. The link message can be sent to any friends, and clicking the structure can open the link. Therefore, the link message is generally used for invitation, show-off, event page sharing, etc.

#### Interface declaration

```
/**
 * @param title: link message’s title
 * @param desc: link message’s description
 * @param url: sharing URL
 * @param mediaTagName: please fill in one of the following values according to the actual situation. This value will be passed to WeChat for statistical purposes. When the shared message returns, it will also bring back the value, which can be used to distinguish the source
 "MSG_INVITE";                   //invite
 "MSG_SHARE_MOMENT_HIGH_SCORE";    //share the week’s highest score to the Wechat moment
 "MSG_SHARE_MOMENT_BEST_SCORE";    // share the history’s highest score to the Wechat moment
 "MSG_SHARE_MOMENT_CROWN";         //share the gold crown to the Wechat moment
 "MSG_SHARE_FRIEND_HIGH_SCORE";     //share the week’s highest score to friends
 "MSG_SHARE_FRIEND_BEST_SCORE";     //share the history’s highest score to friends
 "MSG_SHARE_FRIEND_CROWN";          //share the gold crown to friends
 "MSG_friend_exceed"         // show off exceeding
 "MSG_heart_send"            // send heart
 * @param thumbImgData: structured message’s thumbnail
 * @param thumbImgDataLen: structured message’s thumbnail length
 * @param messageExt: a string passed in by the game in sharing; the player can launch the game through the message, and the message is returned to the game through ret.messageExt of OnWakeUpNotify(WakeupRet ret)
 * @return void
 *   Return data to the game through OnShareNotify(ShareRet& shareRet), a global callback set by the game; shareRet.flag value represents the return status, and its possible values and descriptions are as follows: 
 *     eFlag_Succ: share success
 *     eFlag_Error: share failure
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

#### Call demo code

```
String title = "title";
String desc = "desc";
String mediaTagName = "MSG_INVITE";
String messageExt = "message Ext";
Bitmap thumb = BitmapFactory.decodeResource(mMainActivity.getResources(),
		R.drawable.ic_launcher);
byte[] imgData = CommonUtil.bitmap2Bytes(thumb);
String url = "www.qq.com";
if ("cpp".equals(ModuleManager.LANG)) { // Use C++ to call MSDK; the game only uses one way
	PlatformTest.WGSendToWeixinWithUrl(scene, title, desc, url,
			mediaTagName, imgData, imgData.length, messageExt);
} else if ("java".equals(ModuleManager.LANG)) { // Use java to call MSDK
	WGPlatform.WGSendToWeixinWithUrl(scene, title, desc, url, 
			mediaTagName, imgData, imgData.length, messageExt);
}
```

Check steps for failure to log in Android WeChat
------

### Step 1: Check if there is the following sentence in Log:

	lauchWXPlatForm wx SendReqRet: true

If there is the sentence in Log, this means that the request has been successfully sent to WeChat

If WeChat client is not launched, please check step 2,
If WeChat client is launched but there is no callback, please check step 3

###: Step2: Check the signature and the package name

Download [https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk](https://open.weixin.qq.com/zh_CN/htmledition/res/dev/download/sdk/Gen_Signature_Android.apk), and install this apk to the phone; enter the game's signature in the input box, and click on the button to read the game package’s signature.

![Check signature] (./ wechat_GenSig.png "Check signature")

Check if the signature gotten by the above tool is consistent with the signature of WeChat backend configuration (as for how to query information about the signature of WeChat backend configuration, please RTX to contact MSDK)

### Step 3: Check the location where WXEntryActivity.java is placed (this file is in MSDKSample)

This file must be placed in the game’s package name +.wxapi. For example, if the game's package name is: com.tencent.msdkgame, then WXEntryActivity.java should be placed under com.tencent.msdkgame.wxapi. Meanwhile, check if the content inside WXEntryActivity is consistent with the below

	/**
	 * !! For the code logic of this file, some users do not modify it. Since MSDK 1.7, the parent class name has been changed from WXEntryActivity into BaseWXEntryActivity. If this file has any error, please check this at first
	 */
	public class WXEntryActivity extends com.tencent.msdk.weixin.BaseWXEntryActivity { }

If this step has no problem, check step 4

### Step 4: Check handleCallback

Check if onCreate and onNewIntent of the game’s Launch Activity call WGPlatform.handleCallback


### Step 5: Check if the game’s global Observer is set

Check if the game call WGSetObserver (C ++ layer and Java layer) correctly.


# MSDK Android 常量

## 平台类型ePlatform

	typedef enum _ePlatform
	{
	ePlatform_None,
	ePlatform_Weixin,		//微信平台
	ePlatform_QQ			//手Q平台
	}ePlatform;

## 回调标识eFlag

### 手Q相关：
	
|返回码|名称|描述|推荐处理|
|: ------- :|: ------- :|: ------- :|: ------- :|
|1000|eFlag_QQ_NoAcessToken|手Q登陆失败，未获取到accesstoken|返回登录界面，引导玩家重新登录授权|
|1001|eFlag_QQ_UserCancel|玩家取消手Q授权登录|返回登录界面，并告知玩家已取消手Q授权登录|
|1002|eFlag_QQ_LoginFail|手Q登陆失败|返回登录界面，引导玩家重新登录授权|
|1003|eFlag_QQ_NetworkErr|网络错误|重试|
|1004|eFlag_QQ_NotInstall|玩家设备未安装手Q客户端|引导玩家安装手Q客户端|
|1005|eFlag_QQ_NotSupportApi|玩家手Q客户端不支持此接口|引导玩家升级手Q客户端|
|1006|eFlag_QQ_AccessTokenExpired|accesstoken过期|返回登录界面，引导玩家重新登录授权|
|1007|eFlag_QQ_PayTokenExpired|paytoken过期|返回登录界面，引导玩家重新登录授权|

### 微信相关：

|返回码|名称|描述|推荐处理|
|: ------- :|: ------- :|: ------- :|: ------- :|
|2000|eFlag_WX_NotInstall|玩家设备未安装微信客户端|引导玩家安装微信客户端
|2001|eFlag_WX_NotSupportApi|玩家微信客户端不支持此接口|引导玩家升级微信客户端|
|2002|eFlag_WX_UserCancel|玩家取消微信授权登录|返回登录界面，并告知玩家已取消微信授权登录|
|2003|eFlag_WX_UserDeny|玩家拒绝微信授权登录|返回登录界面，并告知玩家已拒绝微信授权登录|
|2004|eFlag_WX_LoginFail|微信登录失败|返回登录界面，引导玩家重新登录授权|
|2005|eFlag_WX_RefreshTokenSucc|微信刷新票据成功|获取微信票据，登录进入游戏|
|2006|eFlag_WX_RefreshTokenFail|微信刷新票据失败|返回登录界面，引导玩家重新登录授权|
|2007|eFlag_WX_AccessTokenExpired|微信accessToken过期|尝试用refreshtoken刷新票据|
|2008|eFlag_WX_RefreshTokenExpired|微信refreshtoken过期|返回登录界面，引导玩家重新登录授权|

### 异账号相关：

|返回码|名称|描述|推荐处理|
|: ------- :|: ------- :|: ------- :|: ------- :|
|3001|eFlag_NeedLogin|游戏本地账号和拉起账号均无法登陆|返回登录界面，引导玩家重新登录授权|
|3002|eFlag_UrlLogin|不存在异账号，游戏通过拉起账号快速登陆成功|读取LoginRet结构体中的票据进行游戏授权流程|
|3003|eFlag_NeedSelectAccount|游戏本地账号和拉起账号存在异账号|弹出对话框让用户选择登陆的账号|
|3004|eFlag_AccountRefresh|不存在异账号，MSDK已通过刷新接口将本地账号票据刷新|读取LoginRet结构体中的票据进行游戏授权流程|

### 其他

|返回码|名称|描述|推荐处理|
|: ------- :|: ------- :|: ------- :|: ------- :|
|0|eFlag_Succ|成功|按照接口的成功逻辑处理|
|-1|eFlag_Error|错误|按照接口的默认错误处理方法处理|
|-2|eFlag_Local_Invalid|账号自动登录失败, 包含本地票据过期, 刷新失败等所有错误|返回登录界面，引导玩家重新登录授权|
|-3|eFlag_NotInWhiteList|玩家账号不在白名单中|提示玩家未抢号，引导玩家进入应用宝抢号|
|-4|eFlag_LbsNeedOpenLocationService|游戏所需的定位服务未开启|引导用户开启定位服务|
|-5|eFlag_LbsLocateFail|游戏定位失败|提示玩家定位失败，需重试|
	
## 各种结构体

### eTokenType

	typedef enum _eTokenType
	{
		eToken_QQ_Access = 1,    //手Q accesstoken
		eToken_QQ_Pay,          //手Q paytoken
		eToken_WX_Access,       //微信 accesstoken
		eToken_WX_Code,        //游戏不需要关心
		eToken_WX_Refresh,      //微信refreshtoken
	}eTokenType;



|平台|token类型|token作用|type|有效期|
|: ------- :|: ------- :|: ------- :|: ------- :|: ------- :|: ------- :|
|手Q	|accesstoken|查询手Q个人、好友、关系链、分享等功能|eToken_QQ_Access|	90天|
|手Q	|paytoken	|支付相关|eToken_QQ_Pay|	6天|
|微信|	accesstoken|查询微信个人、好友、关系链、分享、支付等|	eToken_WX_Access|	2小时|
|微信|refreshtoken|	刷新accesstoken|	eToken_WX_Refresh|	30天|

### TokenRet
MSDK server通过票据验证游戏用户身份。TokenRet结构定义说明如下：

		typedef struct {
	 		int type; //票据类型  eTokenType类型
	 		std::string value; //票据value
	 		long long expiration; //票据过期时间（游戏不需要关心）
		}TokenRet;

### LoginRet
用户授权后的帐号信息保存在此结构中，LoginRet定义如下：

		typedef struct loginRet_ {
			int flag;               //返回标记，标识授权或刷新是否成功 eFlag类型
			std::string desc;       //返回描述
			int platform;           //当前授权的平台，ePlatform类型
			std::string open_id;     //用户帐号唯一标识
			std::vector<TokenRet> token;     //存储票据数组
			std::string user_id;    //用户ID，先保留，等待和微信协商
			std::string pf;        //用于支付    调用WGGetPf()获取
			std::string pf_key;    //用于支付     调用WGGetPfKey()获取
			loginRet_ ():flag(-1),platform(0){}; //构造方法
		}LoginRet;
                                    	
### ShareRet
分享结果信息保存在此结构中，ShareRet定义如下：

		typedef struct{
			int platform;           //平台类型   ePlatform类型
			int flag;            //操作结果      eFlag类型
			std::string desc;       //结果描述（保留）
    		std::string extInfo;   //游戏分享是传入的自定义字符串，用来标示分享
		}ShareRet;
	
### WakeupRet
平台拉起游戏的信息会保存在此结构中，WakeupRet 结构定义如下：

		typedef struct{
			int flag;                //错误码   eFlag类型
			int platform;               //被什么平台唤起  ePlatform类型
			std::string media_tag_name; //wx回传得meidaTagName
			std::string open_id;        //平台授权帐号的openid
			std::string desc;           //描述

			std::string lang;          //语言     目前只有微信5.1以上用，手Q不用
			std::string country;       //国家     目前只有微信5.1以上用，手Q不用
			std::string messageExt; //游戏分享传入自定义字符串，平台拉起游戏不做任何处理返回目前只有微信5.1以上用，手Q不用
		}WakeupRet;

### PersonInfo
查询结果单个好友或个人的信息保存在此结构，PersonInfo定义如下：

		typedef struct {
    		std::string nickName;  //昵称
    		std::string openId;    //帐号唯一标示
    		std::string gender;    //性别
    		std::string pictureSmall;     //小头像
    		std::string pictureMiddle;    //中头像
    		std::string pictureLarge;     //datouxiang
    		std::string provice;          //省份
    		std::string city;           //城市
		}PersonInfo;
### RelationRet
查询结果保存在此结构中，RelationRet定义如下：

		typedef struct {
    		int flag;     //查询结果flag，0为成功
    		std::string desc;    // 描述
    		std::vector<PersonInfo> persons;//保存好友或个人信息
		}RelationRet;
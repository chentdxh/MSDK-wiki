##常量查询

### 平台类型ePlatform

	typedef enum _ePlatform
	{
	ePlatform_None,
	ePlatform_Weixin,		//微信平台
	ePlatform_QQ			//手Q平台
	}ePlatform;

### 回调标识eFlag
	
	typedef enum _eFlag
	{
		eFlag_Succ              = 0,        //成功
		eFlag_QQ_NoAcessToken   = 1000, 	//手Q授权失败，获取不到accesstoken
		eFlag_QQ_UserCancel     = 1001, 	//用户取消手Q授权
		eFlag_QQ_LoginFail      = 1002, 	//手授权失败
		eFlag_QQ_NetworkErr     = 1003, 	//网络异常
		eFlag_QQ_NotInstall     = 1004, 	//手Q未安装
		eFlag_QQ_NotSupportApi  = 1005, 	//手Q版本不支持
		eFlag_QQ_AccessTokenExpired = 1006, //手Q accesstoken过期
		eFlag_QQ_PayTokenExpired = 1007,    //手Q paytoken过期
		eFlag_WX_NotInstall     = 2000,     //微信未安装
		eFlag_WX_NotSupportApi  = 2001,     //微信版本不支持
		eFlag_WX_UserCancel     = 2002,     //用户取消微信授权
		eFlag_WX_UserDeny       = 2003,     //用户拒绝微信授权
		eFlag_WX_LoginFail      = 2004,     //微信授权失败
		eFlag_WX_RefreshTokenSucc = 2005,  	//微信刷新accesstoken成功
		eFlag_WX_RefreshTokenFail = 2006,  	//微信刷新accesstoken失败
		eFlag_WX_AccessTokenExpired = 2007, //微信accessToken失效
		eFlag_WX_RefreshTokenExpired = 2008,//微信refreshtoken过期
		eFlag_Error				= -1      	// 网络错误
	}eFlag;


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
|手Q	|paytoken	|支付相关|eToken_QQ_Pay|	2天|
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
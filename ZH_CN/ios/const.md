常量查询
---

1. 平台类型ePlatform

		typedef enum _ePlatform
		{
            ePlatform_None,
            ePlatform_Weixin,		//微信平台
            ePlatform_QQ,			//手Q平台
            ePlatform_Guest = 5     //游客
		}ePlatform;

2. 回调标识eFlag

        typedef enum _eFlag
        {
            eFlag_Succ              = 0,
            eFlag_QQ_NoAcessToken   = 1000,     //QQ&QZone login fail and can't get accesstoken
            eFlag_QQ_UserCancel     = 1001,     //QQ&QZone user has cancelled login process (tencentDidNotLogin)
            eFlag_QQ_LoginFail      = 1002,     //QQ&QZone login fail (tencentDidNotLogin)
            eFlag_QQ_NetworkErr     = 1003,     //QQ&QZone networkErr
            eFlag_QQ_NotInstall     = 1004,     //QQ is not install
            eFlag_QQ_NotSupportApi  = 1005,     //QQ don't support open api
            eFlag_QQ_AccessTokenExpired = 1006, // QQ Actoken失效, 需要重新登陆
            eFlag_QQ_PayTokenExpired = 1007,    // QQ Pay token过期
            eFlag_QQ_UnRegistered = 1008,    // 没有在qq注册
            eFlag_QQ_MessageTypeErr = 1009,    // QQ消息类型错误
            eFlag_QQ_MessageContentEmpty = 1010,    // QQ消息为空
            eFlag_QQ_MessageContentErr = 1011,     // QQ消息不可用（超长或其他）
            eFlag_WX_NotInstall     = 2000,     //Weixin is not installed
            eFlag_WX_NotSupportApi  = 2001,     //Weixin don't support api
            eFlag_WX_UserCancel     = 2002,     //Weixin user has cancelled
            eFlag_WX_UserDeny       = 2003,     //Weixin User has deny
            eFlag_WX_LoginFail      = 2004,     //Weixin login fail
            eFlag_WX_RefreshTokenSucc = 2005, // Weixin 刷新票据成功
            eFlag_WX_RefreshTokenFail = 2006, // Weixin 刷新票据失败
            eFlag_WX_AccessTokenExpired = 2007, // Weixin AccessToken失效, 此时可以尝试用refreshToken去换票据
            eFlag_WX_RefreshTokenExpired = 2008, // Weixin refresh token 过期, 需要重新授权
            eFlag_Error				= -1,
            eFlag_Local_Invalid = -2, // 本地票据无效, 要游戏现实登陆界面重新授权
            eFlag_LbsNeedOpenLocationService = -4, // 需要引导用户开启定位服务
            eFlag_LbsLocateFail = -5, // 定位失败
            eFlag_UrlTooLong = -6,     // for WGOpenUrl
            eFlag_NeedLogin = 3001,     //需要进入登陆页
            eFlag_UrlLogin = 3002,    //使用URL登陆成功
            eFlag_NeedSelectAccount = 3003, //需要弹出异帐号提示
            eFlag_AccountRefresh = 3004, //通过URL将票据刷新
            eFlag_InvalidOnGuest = -7, //该功能在Guest模式下不可使用
            eFlag_Guest_AccessTokenInvalid = 4001, //Guest的票据失效
            eFlag_Guest_LoginFailed = 4002,  //Guest模式登录失败
            eFlag_Guest_RegisterFailed = 4003  //Guest模式注册失败
        }eFlag;


3. 票据类型eTokenType

		typedef enum _eTokenType
		{
			eToken_QQ_Access = 1,    //手Q accesstoken
			eToken_QQ_Pay,          //手Q paytoken
			eToken_WX_Access,       //微信 accesstoken
			eToken_WX_Code,        //微信code, 已弃用
			eToken_WX_Refresh,      //微信refreshtoken
            eToken_Guest_Access     // Guest模式下的票据
		}eTokenType;
||平台	token类型||	token作用||	token ||type	||有效期||
	
		手Q	accesstoken	查询手Q个人、好友、关系链、分享等功能	eToken_QQ_Access	90天
		paytoken	支付相关	eToken_QQ_Pay	2天
		微信	accesstoken	查询微信个人、好友、关系链、分享、支付等	eToken_WX_Access	2小时
		refreshtoken	刷新accesstoken	eToken_WX_Refresh	30天

4. TokenRet 票据structure
MSDK server通过票据验证游戏用户身份。TokenRet结构定义说明如下：

		typedef struct {
	 		int type; //票据类型  eTokenType类型
	 		std::string value; //票据value
	 		long long expiration; //票据过期时间（游戏不需要关心）
		}TokenRet;

5. LoginRet 帐号structure
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
                                    	
6. ShareRet 分享结果structure
分享结果信息保存在此结构中，ShareRet定义如下：

		typedef struct{
			int platform;           //平台类型   ePlatform类型
			int flag;            //操作结果      eFlag类型
			std::string desc;       //结果描述（保留）
    		std::string extInfo;   //游戏分享是传入的自定义字符串，用来标示分享
		}ShareRet;
	
7. WakeupRet 唤起structure
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
            std::vector<KVPair> extInfo;  //游戏－平台携带的自定义参数手Q专用
		}WakeupRet;

8. PersonInfo 个人信息structure
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
            bool        isFriend;         //是否好友
            int         distance;         //离此次定位地点的距离
            std::string lang;             //语言
            std::string country;          //国家
            std::string gpsCity;          //根据GPS信息获取到的城市
		}PersonInfo;

9. RelationRet 查询结果structure
查询结果保存在此结构中，RelationRet定义如下：

		typedef struct {
    		int flag;     //查询结果flag，0为成功
    		std::string desc;    // 描述
    		std::vector<PersonInfo> persons;//保存好友或个人信息
            std::string extInfo; //游戏查询是传入的自定义字段，用来标示一次查询
		}RelationRet;

10. ADRet 广告structure
ADRet定义如下：
        typedef struct
        {
            std::string viewTag;   //Button点击的tag
            _eADType scene;   //暂停位还是退出位
        } ADRet;

11. AddressInfo 地址信息structure
LBS地址信息保存在此结构，AddressInfo定义如下：

        typedef struct
        {
            std::string name;           //地点名称
            std::string addr;           //具体地址
            int distance;               //离此次定位地点的距离
        }AddressInfo;

12. LocationRet 地理位置structure
LBS地理位置信息保存在此结构，LocationRet定义如下：

        typedef struct {
            int flag;
            std::string desc;
            double longitude;           //经度
            double latitude;            //维度
        }LocationRet;

13. PicInfo 图片信息structure
图片信息保存在此结构体，PicInfo定义如下：

        typedef struct
        {
            eMSDK_SCREENDIR screenDir;      //横竖屏   1：横屏 2：竖屏
            std::string picPath;            //图片本地路径
            std::string hashValue;          //图片hash值
        }PicInfo;

14. NoticeInfo 公告信息structure
公告信息保存在此结构体，NoticeInfo定义如下：

        typedef struct
        {
            std::string msg_id;			//公告id
            std::string open_id;		//用户open_id
            std::string msg_url;		//公告跳转链接
            eMSG_NOTICETYPE msg_type;	//公告类型，eMSG_NOTICETYPE
            std::string msg_scene;		//公告展示的场景，管理端后台配置
            std::string start_time;		//公告有效期开始时间
            std::string end_time;		//公告有效期结束时间
            eMSG_CONTENTTYPE content_type;	//公告内容类型，eMSG_CONTENTTYPE
            //网页公告特殊字段
            std::string content_url;     //网页公告URL
            //图片公告特殊字段
            std::vector<PicInfo> picArray;    //图片数组
            //文本公告特殊字段
            std::string msg_title;		//公告标题
            std::string msg_content;	//公告内容
        }NoticeInfo;
Constant query
---

1. Platform type ePlatform

		typedef enum _ePlatform
		{
            ePlatform_None,
            ePlatform_Weixin,		// WeChat platform 
            ePlatform_QQ,			// mobile QQ platform
            ePlatform_Guest = 5     // Vistor
		}ePlatform;

2. Callback flag eFlag

        typedef enum _eFlag
        {
            eFlag_Succ              = 0,
            eFlag_QQ_NoAcessToken   = 1000,     //QQ&QZone login fail and can't get accesstoken
            eFlag_QQ_UserCancel     = 1001,     //QQ&QZone user has cancelled login process (tencentDidNotLogin)
            eFlag_QQ_LoginFail      = 1002,     //QQ&QZone login fail (tencentDidNotLogin)
            eFlag_QQ_NetworkErr     = 1003,     //QQ&QZone networkErr
            eFlag_QQ_NotInstall     = 1004,     //QQ is not install
            eFlag_QQ_NotSupportApi  = 1005,     //QQ don't support open api
            eFlag_QQ_AccessTokenExpired = 1006, // QQ Actoken expires; need re-login
            eFlag_QQ_PayTokenExpired = 1007,    // QQ Pay token expires
            eFlag_QQ_UnRegistered = 1008,    // not registered in QQ
            eFlag_QQ_MessageTypeErr = 1009,    // QQ message type error
            eFlag_QQ_MessageContentEmpty = 1010,    // QQ message is empty
            eFlag_QQ_MessageContentErr = 1011, // QQ message is not available (too long or other reasons)
            eFlag_WX_NotInstall     = 2000,     //Weixin (WeChat) is not installed
            eFlag_WX_NotSupportApi  = 2001,     //Weixin don't support api
            eFlag_WX_UserCancel     = 2002,     //Weixin user has cancelled
            eFlag_WX_UserDeny       = 2003,     //Weixin user has deny
            eFlag_WX_LoginFail      = 2004,     //Weixin login fail
            eFlag_WX_RefreshTokenSucc = 2005, // Weixin refreshes token successfully
            eFlag_WX_RefreshTokenFail = 2006, // Weixin fails to refresh token
            eFlag_WX_AccessTokenExpired = 2007, // Weixin AccessToken expires; at this time, refreshToken can be used to exchange the token
            eFlag_WX_RefreshTokenExpired = 2008, // Weixin refresh token expires; need to re-authorize
            eFlag_Error				= -1,
            eFlag_Local_Invalid = -2, // local token is invalid; the game’s login page needs to be re-authorized
            eFlag_LbsNeedOpenLocationService = -4, //need to guide the user to open LBS
            eFlag_LbsLocateFail = -5, // fail to locate
            eFlag_UrlTooLong = -6,   // for WGOpenUrl
            eFlag_NeedLogin = 3001,     // need to enter the login page
            eFlag_UrlLogin = 3002,    //use URL to log in successfully
            eFlag_NeedSelectAccount = 3003, //need to pop up a prompt about account inconsistency
            eFlag_AccountRefresh = 3004, // refresh token via URL
            eFlag_InvalidOnGuest = -7, // this function can not be used in Guest mode
            eFlag_Guest_AccessTokenInvalid = 4001, // Guest’s token expires
            eFlag_Guest_LoginFailed = 4002,  // logon fails in guest mode’s
            eFlag_Guest_RegisterFailed = 4003  // registration fails in guest mode
        }eFlag;


3. Token type eTokenType

		typedef enum _eTokenType
		{
			eToken_QQ_Access = 1,    // mobile QQ  accesstoken
			eToken_QQ_Pay,          // mobile QQ  paytoken
			eToken_WX_Access,       // WeChat  accesstoken
			eToken_WX_Code,        // WeChat code; unused
			eToken_WX_Refresh,      // WeChat refreshtoken
            eToken_Guest_Access     // Token under Guest mode
		}eTokenType;
||Platform |token type||||	token ||type	||validity||
	
		mobile QQ	accesstoken	Querying mobile QQ personal info, friends and relation chain, sharing and other functions	eToken_QQ_Access	90 days
		paytoken	Related to payment	eToken_QQ_Pay	2 days
		WeChat	accesstoken	Querying WeChat personal info, friends and relation chain, sharing, payment and other functions	eToken_WX_Access	2小时
		refreshtoken	Refreshaccesstoken	eToken_WX_Refresh	30 days|

4. TokenRet  token structure
MSDK Server verifies the game user’s identity through token verification. TokenRet structure definition is described as follows:

		typedef struct {
	 		int type; // token type  eTokenType type
	 		std::string value; //token value
	 		long long expiration; // the expired time of token (game developers do not need to care about this)
		}TokenRet;

5. LoginRet  Account structure
The account information is saved in this structure after the user’s authorization. LoginRet is defined as follows:

		typedef struct loginRet_ {
			int flag;               //return identifier; mark if authorization or refreshing is successful; eFlag type
			std::string desc;       // return description
			int platform;           // the current authorized platform, ePlatform type
			std::string open_id;     // user account’s unique identifier
			std::vector<TokenRet> token;     // array used to store tokens
			std::string user_id;    / user ID; first keep it and wait to negotiate with WeChat
			std::string pf;        // used for payment; call WGGetPf() to access it
			std::string pf_key;    // used for payment; call WGGetPfKey()to access it
			loginRet_ ():flag(-1),platform(0){}; //construction method
		}LoginRet;

6. ShareRet  shared result structure
 The shared results are saved in this structure. ShareRet is defined as follows:

		typedef struct{
			int platform;           //Platform type    ePlatform type
			int flag;            //operation result      eFlag type
			std::string desc;       //result description (reserved)
    		std::string extInfo;   //used for game sharing; it is a custom string passed in, used to label sharing
		}ShareRet;

7. WakeupRet  wakeup structure
The information of the platform evoking or waking up the game is stored in this structure. WakeupRet is defined as follows:

		typedef struct{
			int flag;                //error code    eFlag type
			int platform;               //evoked by what platform?   ePlatform type
			std::string media_tag_name; //meidaTagName returned by wx (WeChat)
			std::string open_id;        //openid of the platform’s authorized account
			std::string desc;           //description
			std::string lang;          // language; currently only used by versions higher than WeChat 5.1 but not used by mobile QQ
			std::string country;       //country; currently only used by versions higher than WeChat 5.1 but not used by mobile QQ
			std::string messageExt; // a custom string passed in by game sharing; when the platform evokes the game, the return is not handled; currently only used by versions higher than WeChat 5.1 but not used by mobile QQ
          std::vector<KVPair> extInfo;  //a custom parameter carried by game – platform; dedicated to QQ mobile
		}WakeupRet;

8. PersonInfo  personal information structure
Query results of a single friend’s or the user’s personal information are saved in this structure, PersonInfo is defined as follows:

		typedef struct {
    		std::string nickName;  //nickname
    		std::string openId;    // account’s unique identifier
    		std::string gender;    //gender
    		std::string pictureSmall;     //small head portrait
    		std::string pictureMiddle;    //mid-sized head portrait
    		std::string pictureLarge;     //big head portrait
    		std::string provice;          //provinces
    		std::string city;           //city
            bool        isFriend;         //Is a friend?
            int         distance;         // distance from the positioned location
            std::string lang;             //language
            std::string country;          //country
            std::string gpsCity;          // city accessed according to the GPS information
		}PersonInfo;


9. RelationRet  query result structure
Query results of the relation chain are saved in this structure. RelationRet is defined as follows:

		typedef struct {
    		int flag;     //query result flag,0 indicates success
    		std::string desc;    // description
    		std::vector<PersonInfo> persons;// save friends’ or the user’s personal information
           std::string extInfo; //game query; it is the incoming custom field, used to label a query
		}RelationRet;


10. ADRet  ad structure
ADRet is defined as follows:
        typedef struct
        {
            std::string viewTag;   //tag of the clicked button
            _eADType scene;   //pause slot or exit slot
        } ADRet;

11. AddressInfo  address info structure
The LBS address information is saved in this structure. AddressInfo is defined as follows:

        typedef struct
        {
            std::string name;           //location name
            std::string addr;           //the specific address
            int distance;               //distance from the located location
        }AddressInfo;

12. LocationRet  location structure
The LBS location information is saved in this structure . LocationRet is defined as follows:

        typedef struct {
            int flag;
            std::string desc;
            double longitude;           //longitude
            double latitude;            //latitude
        }LocationRet;

13. PicInfo  picture information structure
Picture information saved in this structure. PicInfo is defined as follows:

        typedef struct
        {
            eMSDK_SCREENDIR screenDir;      //landscape or portrait mode  1: landscape mode 2: portrait mode
            std::string picPath;            //local path of the image
            std::string hashValue;          //hash value of the image
        }PicInfo;

14. NoticeInfo  notice info structure
Notice or announcement information is saved in this structure.  NoticeInfo is defined as follows:

        typedef struct
        {
            std::string msg_id;			// notice id
            std::string open_id;		//user’s open_id
            std::string msg_url;		//notice’s hoplink
            eMSG_NOTICETYPE msg_type;	//notice type, eMSG_NOTICETYPE
            std::string msg_scene;		//the scene of the notice display; management terminal has the backstage configuration
            std::string start_time;		// start time of the notice validity
            std::string end_time;		//end time of the notice validity
            eMSG_CONTENTTYPE content_type;	 //notice content type, eMSG_CONTENTTYPE
// a special field for the webpage notice
            std::string content_url;     //Webpage notice’s URL
            //a special field for the image notice
            std::vector<PicInfo> picArray;    // image array
            //a special field for the text notice
            std::string msg_title;		//notice title
            std::string msg_content;	//content of the notice
        }NoticeInfo;
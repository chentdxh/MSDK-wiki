# MSDK Android Constants

## Platform type ePlatform

	typedef enum _ePlatform
	{
	ePlatform_None,
	ePlatform_Weixin,		// WeChat platform 
	ePlatform_QQ			// mobile QQ platform 
	}ePlatform;

## Callback flag eFlag

### Mobile QQ-related:
	
|Return code| Name | Description | Recommended handling method|
|: ------- :|: ------- :|: ------- :|: ------- :|
|1000|eFlag_QQ_NoAcessToken|Mobile QQ login fails; fail to get accesstoken |Return to the login page and guide the player to re-login to authorize|
|1001|eFlag_QQ_UserCancel|The player cancels the authorized login for mobile QQ |Return to the login page, and inform that the player has canceled the authorized login for mobile QQ|
|1002|eFlag_QQ_LoginFail| mobile QQ login fails |Return to the login page and guide the player to re-login to authorize|
|1003|eFlag_QQ_NetworkErr|Network error| Retry|
|1004|eFlag_QQ_NotInstall|The player’s device is not installed with mobile QQ client |Guide the player to install the mobile QQ client|
|1005|eFlag_QQ_NotSupportApi|The player’s mobile QQ client does not support this interface | Guide the player to upgrade the Mobile QQ client|
|1006|eFlag_QQ_AccessTokenExpired|accesstoken expires |Return to the login page and guide the player to re-login to authorize|
|1007|eFlag_QQ_PayTokenExpired|paytoken expires |Return to the login page and guide the player to re-login to authorize|

### WeChat-related:

|Return code|Name|Description|Recommended handling method|
|: ------- :|: ------- :|: ------- :|: ------- :|
|2000|eFlag_WX_NotInstall|The player’s device is not installed with WeChat client| Guide the player to install the WeChat client|
|2001|eFlag_WX_NotSupportApi| The player’s WeChat client does not support this interface | Guide the player to upgrade the WeChat client|
|2002|eFlag_WX_UserCancel|The player cancels the authorized login for WeChat |Return to the login page, and inform that the player has canceled the authorized login for WeChat|
|2003|eFlag_WX_UserDeny|The player denies the authorized login for WeChat |Return to the login page, and inform that the player has denied the authorized login for WeChat|
|2004|eFlag_WX_LoginFail| WeChat login fails |Return to the login page and guide the player to re-login to authorize|
|2005|eFlag_WX_RefreshTokenSucc| WeChat refreshes token successfully |Get WeChat token, and log into the game|
|2006|eFlag_WX_RefreshTokenFail| WeChat fails to refresh token |Return to the login page and guide the player to re-login to authorize|
|2007|eFlag_WX_AccessTokenExpired| WeChat accesstoken expires |Try to use refreshtoken to refresh token|
|2008|eFlag_WX_RefreshTokenExpired| WeChat refreshtoken expires |Return to the login page and guide the player to re-login to authorize|

### Account inconsistency-related:

|Return code|Name|Description|Recommended handling method|
|: ------- :|: ------- :|: ------- :|: ------- :|
|3001|eFlag_NeedLogin|The game’s local account and evoked account can not be logged in |Return to the login page and guide the player to re-login to authorize|
|3002|eFlag_UrlLogin|There is no account inconsistency; the game is quickly logged in successfully through the evoked account |Read the token in LoginRet structure to conduct the game authorization process|
|3003|eFlag_NeedSelectAccount |There is account inconsistency between the game’s local account and evoked account |Pop up a dialog to allow the user to select an account for login|
|3004|eFlag_AccountRefresh|There is no account inconsistency; MSDK has refreshed the local account token by refreshing the interface | Read the token in LoginRet structure to conduct the game authorization process|

### Others

|Return code|Name| Description| Recommended handling method|
|: ------- :|: ------- :|: ------- :|: ------- :|
|0|eFlag_Succ|Succeed | Handle the problem according the success logic of the interface|
|-1|eFlag_Error|Error|Handle the error according to the default error handling method of the interface|
|-2|eFlag_Local_Invalid|The account’s automatic login fails; errors include the expiration of the local token and the failure of refreshing the token |Return to the login page and guide the player to re-login to authorize|
|-3|eFlag_NotInWhiteList|The player’s account number is not in the white list |Prompt the player that he or she has not vied for an account number, and guide the player to enter MyApp to vie for an account number|
|-4|eFlag_LbsNeedOpenLocationService|The location-based service (LBS) required by the game is not enabled |Guide the user to open the LBS|
|-5|eFlag_LbsLocateFail|The game’s locating fails |Prompt the player that his or her locating fails and he or she needs to retry locating|

## Various structures

### eTokenType

	typedef enum _eTokenType
	{
		eToken_QQ_Access = 1,    // mobile QQ  accesstoken
		eToken_QQ_Pay,          // mobile QQ  paytoken
		eToken_WX_Access,       // WeChat  accesstoken
		eToken_WX_Code,        //game developers do not need to care about it
		eToken_WX_Refresh,      // WeChat refreshtoken
	}eTokenType;



|Platform|token type|token role|type |validity|
|: ------- :|: ------- :|: ------- :|: ------- :|: ------- :|: ------- :|
| mobile QQ 	|accesstoken| Querying mobile QQ personal info, friends and relation chain, sharing and other functions |eToken_QQ_Access|	90 days|
| mobile QQ 	|paytoken	|Related to payment |eToken_QQ_Pay|	6 days|
| WeChat |	accesstoken| Querying WeChat personal info, friends and relation chain, sharing, payment and other functions |	eToken_WX_Access|	2 hours|
| WeChat |refreshtoken|	Refresh accesstoken|	eToken_WX_Refresh|	30 days|

### TokenRet
MSDK Server verifies the game user’s identity through token verification. TokenRet structure definition is described as follows:

		typedef struct {
	 		int type; // token type  eTokenType type
	 		std::string value; //token value
	 		long long expiration; // the expired time of token (game developers do not need to care about this)
		}TokenRet;

### LoginRet
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
                                    	
### ShareRet
The shared result information is saved in this structure. ShareRet is defined as follows:

		typedef struct{
			int platform;           //Platform type    ePlatform type
			int flag;            //operation result      eFlag type
			std::string desc;       //result description (reserved)
    		std::string extInfo;   //a custom string passed in by game sharing; used to label sharing
		}ShareRet;
	
### WakeupRet
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
		}WakeupRet;


### PersonInfo
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
		}PersonInfo;


### RelationRet
Query results of the relation chain are saved in this structure. RelationRet is defined as follows:

		typedef struct {
    		int flag;     //query result flag,0 indicates success
    		std::string desc;    // description
    		std::vector<PersonInfo> persons;// save friends’ or the user’s personal information
		}RelationRet;
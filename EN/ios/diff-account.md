MSDK Account Inconsistency
=======

What is account inconsistency?
---

Account inconsistency refers to: the login account within the game is inconsistent with the login account in the platform. Account inconsistency has the following two types:

1. The platform is the same, but the accounts are different (for example, the game and QQ mobile are logged in with different QQ numbers)
2. Platforms are different (for example, the game is logged in with WeChat, but the game’s related operations need to use mobile QQ)

Scenarios with account inconsistency
---

 1. When the game launches the platform to share messages, because the accounts are inconsistent, the platform will pop up a box to prompt account inconsistency. The platforms now all support by the feature.


 2. When the user launches the platform to enter the game, because the accounts are inconsistent, the game needs to pop up a box to prompt account inconsistency

`The account inconsistency which the platform requires the game to handle when the game is put online and account inconsistency implemented in MSDK now both belong to the second Type.`

Handling logic of account inconsistency (Game developers should pay attention to this issue)
---
MSDK’s account inconsistency handling logic includes three steps: judge account inconsistency, The user selects an account and log on with the selected account. (For details, please see relevant MSDK access documentation). It is briefly described as follows:

####1. Judge account inconsistency:

When the game is launched by the platform, in handCallback MSDK will judge whether the account in the platform and the game’s local account are inconsistent and return the account inconsistency judgment result to the game through ret.flag of OnWakeupNotify (WakeupRet ret) method. The game can complete the corresponding login processing according to the callback result. Details about ret.flag and the corresponding processing are as follows:

	eFlag_Succ: There is no account inconsistency, and login with the local account is successful. After the game receives this flag, it will directly read the token in LoginRet struct to make the authorization process.

	eFlag_AccountRefresh: There is no account inconsistency, and MSDK has refreshed the local account token through the refresh interface. After the game receives this flag, it will directly read the token in LoginRet struct to make the authorization process.

	eFlag_UrlLogin: There is no account inconsistency, and the game is rapidly logged in successfully with the launched account. After the game receives this flag, it will directly read the token in LoginRet struct to make the authorization process.

	eFlag_NeedLogin: The game is unable to be logged in with either the local account or the launched account. After the game receives this flag, it needs to pop out the login page to allow the user to log on.

	eFlag_NeedSelectAccount: The game’s local account and the launched account are inconsistent. After the game receives this flag, it needs to pop out a dialog box to allow the user to select an account for login.

####2. The user selects an account:
When ret.flag used to judge account inconsistency is eFlag_NeedSelectAccount, the game needs to pop out a box to prompt the user to select the local account or the launched account to log in the game. The game needs to call interface WGSwitchUser to complete the user’s login according to the user’s selection result.
		
		/**
		 *  Log in the game via the launched URL. This interface is used at cases where account inconsistency occurs. At such cases, MSDK will call the interface when the user chooses to use the launched account.
	 	*  After successful login, the result is returned via onLoginNotify
	 	*  
	 	*  @param flag: when flag is YES, it means that the user needs to switch to the launched account. At the time, the interface will log on with the launched account login data saved last time. After successful login, the result will be returned via onLoginNotify method; if there are no tokens or tokens are invalid, the method will return NO and there will no callback from onLoginNotify.
	 	*              When flag is NO, this indicates that the user can continue to use the original account. At the time, delete the stored launched account data to avoid confusion.
	 	*
	 	*  @return If there are tokens or tokens are invalid, NO will be returned; otherwise YES will be returned
		 */
		bool WGSwitchUser(bool flag);

####3. Returns login callback:

When the parameter of WGSwitchUser is true, MSDK will try to log on the game according to the state of the game being launched and it will return the login result to the game through onLoginNotify callback. The game will handle the login result according to the callback result.

Nine cases of account inconsistency from platform to game
----

** Developers do not need to care about this but only care about flag called back by MSDK to the game**:

|           |Launched with an intact token | Launched without an intact token | Launched with no token |
|: ------------- :|: ------------- :|: ------------- :|: ------------- :|
|The local token is valid |Remind the user of account inconsistency |Remind the user of account inconsistency |Log on with the local account|
|The local token is not valid |Remind the user of account inconsistency |Remind the user of account inconsistency |The game returns to the login page|
|There is no local ticket|Log on with the launched account |The game returns to the login page |The game returns to the login page |


Version support of account inconsistency
-----
#### Game-to-platform account inconsistency:
1. In 1.3.0.11 and earlier versions, the game-to-WeChat account inconsistency occurs because the known BUG of MSDK can cause no prompt for automatic login. It is recommended to update the MSDK version to versions higher than 1.3.0.11 to resolve this problem.
2. The game-to-WeChat account inconsistency is only supported in WeChat 5.0 and higher versions

#### Platform-to-game account inconsistency:
1. Starting from 1.8.0, MSDK has begun to support account inconsistency. Currently, only mobile QQ can complete the launch with a token.
2. In mobile QQ 4.6 and lower versions, mobile QQ-to-game account inconsistency disappears in case that the game has started.


## FAQ

1. Messages which are shared via click do not have account inconsistency: Click to view [Click effect of the shared message (share.md#Click effect of the shared message), and confirm if the current operation can trigger account inconsistency.
2. The game launched by mobile QQ cannot be logged in: [click to learn the conditions that mobile QQ supports quick login (qq.md# Quick login). According to the contents, confirm if the current game and mobile QQ support quick login.
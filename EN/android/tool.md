MSDK Basic Tools
======

Check if mobile QQ and WeChat are installed
------
Call WGIsPlatformInstalled interface to check if the detected platform is installed. The interface is described in detail as follows:
#### Interface declaration:

	/**
	 * @param platformType:type of platform passed into by the game; possible values:ePlatform_QQ, ePlatform_Weixin
	 * @return  platform’s support situation; false means the platform is not installed, and true means the platform has been installed
	 */
	bool WGIsPlatformInstalled(ePlatform platformType);

#### Call interface:

Demo code for calling interface:

	WGPlatform::GetInstance()->WGIsPlatformInstalled((ePlatform) platform);


Get the version numbers of mobile QQ and WeChat
------
Call WGGetPlatformAPPVersion interface to return the corresponding number version of the currently installed platform. The interface is described in detail as follows:
#### Interface declaration:

	/**
	 * @return APP version number
	 */
	const std::string WGGetPlatformAPPVersion(ePlatform platform);

#### Call interface:

Demo code for calling interface:

	WGPlatform::GetInstance()->WGGetPlatformAPPVersion((ePlatform) Platform);

Check if the interface is supported by mobile QQ and WeChat installed by the user
------
Call WGCheckApiSupport interface to return a list of a specified type of current valid announcement data. The interface is described in detail as follows:
#### Interface declaration:

	/**
	 * @return  interface’s support situation
	 * @param
	 * eApiName_WGSendToQQWithPhoto = 0,
	 * eApiName_WGJoinQQGroup = 1,
	 * eApiName_WGAddGameFriendToQQ = 2,
	 * eApiName_WGBindQQGroup = 3
	 */
	bool WGCheckApiSupport(eApiName);

#### Call interface:

Demo code for calling interface:

	WGPlatform::GetInstance()->WGCheckApiSupport((eApiName) jApiName);

Get MSDK version number
------
Call WGGetVersion interface to return MSDK’s version number. The interface is described in detail as follows:
#### Interface declaration:

	/**
	 * return MSDK version number
	 * @return MSDK version number
	 */
    const std::string WGGetVersion();

#### Call interface:

Demo code for calling interface:

	WGPlatform::GetInstance()->WGGetVersion();

Get installation channel
----------

Call WGGetChannelId to return the game’s installation channel. The interface is described in detail as follows:
#### Interface declaration:

	/**
	 * @return installation channel
	 */
	const std::string WGGetChannelId();

#### Call interface:

Demo code for calling interface:

	WGPlatform::GetInstance()->WGGetChannelId();

Get registration channel
----------

Call WGGetRegisterChannelId to return the user’s registration channel. The interface is described in detail as follows:
#### Interface declaration:

	/**
	 * @return registration channel
	 */
	const std::string WGGetRegisterChannelId();

####Call interface:

Demo code for calling interface:

	WGPlatform::GetInstance()->WGGetRegisterChannelId();

Local log
------

#### 1. Overview
The module is provided after MSDK 2.0.0 version. Through a switch, the game can control whether or not to print the relevant log of MSDK.
#### 2. Configuration mode
The local log module is off by default. Any game which needs to use the module needs to set the value of localLog in assets/msdkconfig.ini to be the corresponding value in accordance with actual needs.

| Switch value | Log mode |
|:------- :|:------- :|
| 0 | Do not print |
| 1 | Print logcat |
| 2 | Print the local file, and don’t print logcat |
| 3 | Logcat and the local file are printed at the same time |	
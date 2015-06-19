MSDK QQ Game Hall Access Module
====================

# Game Hall

There are now two types of access to the QQ Game Hall (or the Hall for short).

- One is just to launch the game through the Hall, without carrying the access token of the Hall;

- The other is to launch the game from the Hall and also take the user's access token of the Hall to enter the game. At this time, the access token of the Hall can directly replace the player’s access token in the game.

## Launch the game without any access token

If the game is just launched through the Hall but does not need to obtain the access token of the Hall, the launch of the Hall can be shielded by the following methods.

In the game's ‘onCreate’ and ‘onNewIntent’, use the following ways to determine whether the game is launched from the Hall. If yes, do not call ‘handleCallback’. If not, call ‘handleCallback’ to handle the other launches of the platform. The codes are as follows:

```
Intent intent = this.getIntent();
if (intent != null && intent.getExtras() != null) {
	Bundle b = intent.getExtras();
	Set<String> keys = b.keySet();
	if(keys.contains("KEY_START_FROM_HALL")){
    //The launched platform is the Hall
	Logger.d("Wakeup Plantform is Hall");
} else {
	//The launched platform is not the Hall
	Logger.d("Wakeup Plantform is not Hall");
	WGPlatform.handleCallback(this.getIntent()); // receive callbacks from the platform
}
```

## Launch the game with an access token

If the game wants to access the QQ Game Hall, the Game Hall’s entrance should be configured at first (configured by the interface personnel of the corresponding Tencent products [the configuration system’s URL] (http://mqqgameadmin4dev.3gqq.com/web_mqqgame_admin/crud_db_cobra_hall/dbbeans/index.jsp).

Because the Game Hall’s joint debugging process needs to use the test environment, it needs to use a test number (applied by the interface personnel of the corresponding Tencent products; as for the type of the test number, select an ordinary test number; [the URL for test number application] (http://ceshihao.ied.com)). After the game is launched online, it should use the formal environment and does not need to use any test number to log in through the Game Hall.
** Note: ** When you configure the Game Hall for the access to the Game Hall, you need to configure authentication type (auth_type) as ** Open Platform Token (16) **, as shown in the below picture:

![qqgame_1](./qqgame_1.jpg)

When a game wants to access the Game Hall, it first needs to have an entrance to the Game Hall (or the Hall for short). It is needed to configure the game into the Game Hall. As for this part of work, it is needed to find the Hall’s relevant personnel to complete it. After the game has an entrance to the Hall, gamers can launch the game from the Hall. When the game is launched, SDK will store the tokens (openId + accessToken + paytoken) needed by the game to the local site. After the game receives ‘OnWakeupNotify’, according to the received ‘platform’ field of ‘WakeupRet’ it can judge whether the launch comes from the Hall. After it makes sure that the launch comes from the Hall, the game can call ‘WGGetLoginRecord’ interface to read the access token stored at the local site. After these tokens are gotten, the game can complete the access to the Hall.

### Access configuration

Several configuration requirements for access to the Game Hall:

```
<!-- App accessing the Game Hall is not allowed to add the intent-filter  start-->
<intent-filter>
	<action android:name="android.intent.action.MAIN" />
	<category android:name="android.intent.category.LAUNCHER" />
	</intent-filter>
<!-- App accessing the Game Hall is not allowed to add the intent-filter  end -->

```

Add intent-filter in access Activity (MainActivity of corresponding ‘MSDKSample’)

```
<!-- Add the intent-filter in access Activity  start -->
<intent-filter>
	<!-- xxxxx is replaced with the developer’s own application package name. It must be filled in correctly, otherwise the game can not be started. -->
    <action android:name="xxxxx" /> 
    <category android:name="android.intent.category.DEFAULT" />
</intent-filter>
<!-- Add the intent-filter in access Activity  end -->
```

In <application> in AndroidManifest.xml, add the following content

```
<!-- Any game accessing the Game Hall must add meta-data  start -->
<meta-data
    android:name="QQGameHallMark"
    android:value="QQGameHallMark" />
<meta-data
    android:name="QQGameHallAuthorVer"
	android:value="10000" />
<!-- Any game accessing the Game Hall must add meta-data  end -->
```

‘10000’ in ‘QQGameHallAuthorVer’ represents the version number of the access application on the platform of the Game Hall. It is used to update the version. Each time the version is updated in the Hall, the number will be added with 1. Its initial value can be set as 10000. It is used to update the version in the Hall. This value has no conflict with ‘android:versionCode’ but does no need to be consistent with the latter. But the values of `android:versionCode` and ‘QQGameHallAuthorVer’ of the new version submitted each time are simultaneously added with 1

** Notes: ** 

1: Access to the Game Hall must guarantee that a long-time press on the “home” button does not result in the appearing of the Game Hall’s own application icon. In order to ensure this, it must be confirmed that ‘android:launchMode’ of all Activity in androidManifest.xml are set to be the default values (i.e. not set) or singleTop but can not be set to be ‘singleTask’ or ‘singleInstance’.

2: If the situation appears that a press on the “home” button in the game can lead back to the desktop and a long-term press on the “home” button and a click on the Game Hall icon can lead back to the Game Hall page (the normal situation should be that a press on the “home” button in the game could lead back to the game), you should first check whether androidManifest.xml file contains “‘android:excludeFromRecents’ is true”. If yes, it must be deleted. In addition, if the file contains ‘android:allowTaskReparenting’ and ‘android:alwaysRetainTaskState’, they must also be removed.

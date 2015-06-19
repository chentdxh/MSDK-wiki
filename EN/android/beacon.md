MSDK Beacon-related Module
===
Beacon access configuration
---
Since MSDK1.7, the game accessing msdk does not any longer need to apply the beacon’s appkey from the beacon side but uses qqAppId as the beacon key to achieve the access to the beacon. In the user analysis -> real-time statistics, if there are the displayed data, this indicates that the access is successful.

![beacon_1](./beacon_res/beacon_1.png)

Since MSDK 1.7, there has been no need to configure beacon in androidmanifest.xml, as shown in the diagram below. Some games may have data exceptions due to the existence of this section of codes, so it is suggested to delete this section of codes.

![beacon_3](./beacon_3.png)

If you can not see any data, please handle the problem according to the following steps.

1.     First of all, the game may have applied for multiple beacon applications, but beacon can only correlate one of the beacon applications with qqAppId(100703379). For example, for testing, msdk applies for three beacon applications, but MSDK(Android) is the application associated with qqAppId and has no correlation with WeGameSample. Therefore, you can see the latest data in MSDK(Android) here but can’t see the latest data in WeGameSample. The game should first confirm this point.

![beacon_1](./beacon_res/beacon_2.png)

2.     Although the game is access to MSDK1.7 or later versions, beacon does not correlate the previously applied appkey with qqAppid. This can also make you unable to see the data. In this case, please contact beacon staffer @jiaganzheng and tell him qqAppId

3.     If your game accesses MSDK for the first time, you should confirm whether your game have the permission to do so. For this, you can contact beacon staffer @jiaganzheng and tell him qqAppId


Custom event reporting
---
Through the event interface, MSDK records and reports the user’s key events to the beacon and MTA, thus making statistical analysis on the occurrence number of the events. Interfaces required to accomplish this function include: WGReportEvent. The detailed description of the interface is as follows:

     /**Custom data reporting: This interface only supports one key-value reporting. Beginning from MSDK1.3.4, it is recommended to use void WGReportEvent(String name, HashMap<String, String> params, boolean isRealTime)
	 * @param name: event name
	 * @param body: event content
	 * @param isRealTime: whether or not to report in real time
	 * @return void
	 */
     public static void WGReportEvent(String name, String body, boolean isRealTime);

The other interface is:
     
     /**
	 * @param eventName: event name
	 * @param params: custom event in the key-value format
	 * @param isRealTime: whether or not to report in real time
	 * @return void
	 */
    public static void WGReportEvent(String eventName, HashMap<String, String> params, boolean isRealTime);

Wherein, the parameters are restricted as follows: **eventName doesn't start with MSDK_, because this is the naming style of MSDK’s custom events. **

![beacon_3](./beacon_d1.png)

Application scenario
---

You can query the number of calls made to a certain interface. If you query the QQ user’s personal information, the event is named queryQQUserInfo. Its calling method is as follows:

    WGReportEvent("queryQQUserInfo", null, true);

If the event is successfully reported, you can query the event data in the log of the corresponding beacon app in http://beacon.tencent.com/. If an event is reported in real time, after you call the above method, you can generally query the event data within five minutes.

![beacon_3](./beacon_d2.png)

In addition, you can view the statistics of data in the event quality list:


![beacon_4](./beacon_d3.png)

For more details, consult beacon staffer Xiao Mi via RTX.

In addition: the beacon custom event module has the statistics of the success rate and time delay. The module is not yet encapsulated now. When the game needs to use it, it can call UserAction.onUserAction on its own. As for the use method, please see the reference documentation available in the official website of beacon.
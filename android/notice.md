MSDK公告模块
===

概述
---

公告模块会在MSDK初始化和玩家登录以后均会去系统后台拉取该APP的有效公告。此外，公告模块还有定时拉取机制（默认10分钟拉取一次）
	
#### 版本支持

**该功能在MSDK 1.7.0a 版本以后提供，公告分滚动公告、弹出公告两种形式。**从MSDK 2.0.0a 开始，公告内容从文字增加到图片和网页三种形式。
  #### 注意事项调用展示公告的接口和获取公告数据的接口时，均是从本地数据库获取该应用当前有效的公告。
 
接入配置
---
#### 公告初始化：
	
公告模块无需单独的初始化工作，只需要完成MSDK的初始化就好。**如果游戏只接入手Q或者微信平台，请在初始化（onCreate）时只设置对应平台的appid，不要随意填写其余游戏其余平台的appid。否则会导致游戏登录前公告拉取失败。**

#### 公告AndroidMainfest配置：

这部分内容主要是MSDK公告界面相关的权限设置，**如果游戏使用自定义UI，这部分内容可以不用设置。**

- 游戏使用自定义公告界面

	无
- 游戏使用MSDK提供公告界面

		<!-- TODO Notice 公告 配置 START -->
        <!--  MSDK弹出公告相关配置 -->
       	<activity
           	android:name="com.tencent.msdk.notice.AlertMsgActivity"
           	android:configChanges="orientation|screenSize|keyboardHidden"
           	android:screenOrientation="sensor"
           	android:theme="@style/NoticeAlertTheme" >
        </activity>
		<!--  MSDK滚动公告相关配置 -->
        <service android:name="com.tencent.msdk.notice.RollFloatService" >
        </service>
        <!-- TODO Notice 公告 配置  END -->
**备注：游戏可以根据屏幕的方向设置公告activity的屏幕方向（android:screenOrientation的值）。**

开关配置
---
MSDK 提供开关供游戏控制是否开启MSDK公告以及公告定时拉去的时间频率。
#### 是否开启公告
	
公告模块默认打开, 不需要使用公告模块的游戏需要在assets/msdkconfig.ini中将needNotice一项的值设置为false.
#### 设置公告定时拉取时间

公告模块默认自动拉取时间为十分钟, 游戏可以根据需要在assets/msdkconfig.ini中将noticeTime一项的值设置为对应的时间。**（游戏可以设置的最短拉取时间为5分钟）**
	
	
展示公告接口
---

调用WGShowNotice将使用MSDK配置的一套界面显示当前有效的公告。对于弹出公告，还可以设置是否带有跳转链接，对于带有跳转链接的公告，点击详情会拉起MSDK内置浏览器打开对应的详情URL。

#### 接口声明：
		/**	 * 展示对应类型指定场景下的公告	 * @param type   要显示的公告类型	 * 	  eMSG_NOTICETYPE_ALERT: 弹出公告	 * 	  eMSG_NOTICETYPE_SCROLL: 滚动公告	 * 	  eMSG_NOTICETYPE_ALL: 弹出公告&&滚动公告	 * @param scene 公告场景ID，不能为空, 这个参数和公告管理端的“公告栏”设置对应	 */
  	void WGShowNotice(eMSG_NOTICETYPE type, unsigned char *scene);
#### 接口调用：
	eMSG_NOTICETYPE noticeTypeID = eMSG_NOTICETYPE.eMSG_NOTICETYPE_ALERT;
	String sceneString = "1";
	WGPlatform.WGShowNotice(noticeTypeID, sceneString);
	
#### 注意事项：
在调用接口时使用的场景id(scene)公告管理端**设置的“公告栏”ID对应，请不要使用公告ID(msgid)代替公告栏ID**隐藏滚动公告接口
---

调用WGHideScrollNotice会隐藏正在展示的滚动公告。

#### 接口声明：

	/**	 * 隐藏正在展示的滚动公告	 */

	 void WGHideScrollNotice();#### 接口调用：

	WGPlatform.WGHideScrollNotice();
获取公告数据接口
---
调用WGGetNoticeData会返回一个指定类型的当前有效的公告数据的列表。
#### 接口声明：
	/**	 * 从本地数据库读取指定scene下指定type的当前有效公告	 * @param type 需要展示的公告类型。类型为eMSG_NOTICETYPE，具体值如下:	 * 	  eMSG_NOTICETYPE_ALERT: 弹出公告	 * 	  eMSG_NOTICETYPE_SCROLL: 滚动公告	 * @param sence 这个参数和公告管理端的“公告栏”对应	 * @return NoticeInfo结构的数组，NoticeInfo结构如下：		typedef struct		{			std::string msg_id;			//公告id			std::string open_id;		//用户open_id			std::string msg_url;		//公告跳转链接			eMSG_NOTICETYPE msg_type;	//公告类型，eMSG_NOTICETYPE			std::string msg_scene;		//公告展示的场景，管理端后台配置			std::string start_time;		//公告有效期开始时间			std::string end_time;		//公告有效期结束时间			eMSG_CONTENTTYPE content_type;	//公告内容类型，eMSG_CONTENTTYPE
			//网页公告特殊字段
			std::string content_url;     //网页公告URL			//图片公告特殊字段			std::vector<PicInfo> picArray;    //图片数组			//文本公告特殊字段			std::string msg_title;		//公告标题			std::string msg_content;	//公告内容			}NoticeInfo;	 */		 	 std::vector<NoticeInfo> WGGetNoticeData(eMSG_NOTICETYPE type,unsigned char *scene);
#### 接口调用：	
	eMSG_NOTICETYPE noticeTypeID = eMSG_NOTICETYPE.eMSG_NOTICETYPE_ALERT;
	String sceneString = "1";	Vector<NoticeInfo> noticeInfos = new Vector<NoticeInfo>();
    noticeInfos = WGPlatform.WGGetNoticeData(noticeTypeID, sceneString);
    
#### 注意事项：
在调用接口时使用的场景id(scene)公告管理端**设置的“公告栏”ID对应，请不要使用公告ID(msgid)代替公告栏ID**        游戏公告不能正常展示检查步骤
---
1. 公告模块是否开启：
	**检查游戏assets/msdkconfig.ini中needNotice一项的值是否为true。如果不是，改为true再调试；如果是继续往下检查。**检查方法：
	- 查看MSDK日志，如果存在下面一行日志，则说明公告模块处于关闭状态：
	
			WeGame NoticeManager.init	 notice module is closed!		如果存在下面一行日志，则说明公告模块已经打开：			WeGame NoticeManager.init	 notice module init start!	- 反编译游戏包，查找assets目录下的msdkconfig.ini文件，检查是否配置needNotice一项，并确认needNotice的值是否为true.

- 查看调用接口是否有有效内容：

	**查看MSDK的日志，看调用接口的日志里是否有公告。如果不是0，找MSDK相关开发确认；如果是0，则继续往下检查。**检查方法：

	在MSDK日志中看**noticeVector size**的值：

		WeGame NoticeDBModel.getNoticeRecordBySceneAndType	 query result:0
		WeGame NoticeManager.getNoticeFromDBBySceneAndType	 noticeVector size:0

- 查看获取公告的appid是否正确：

	**查看MSDK的日志，看获取公告时的appid是否正确，登陆前公告为手Q和微信appid的组合，登陆后公告为对应平台appid。，如果不正确，请在初始化的地方修改以后再尝试如果正确，请继续往下检查。**检查方法：

	在MSDK日志中看调用**NoticeManager.getNoticeInfo**的时候的appid的值，然后与dev后台、请求公告的时机（是否登陆）对比，看是否正确。**尤其常见只接单一平台的游戏随意填写其余平台的信息，导致公告获取失败**：

		WeGame NoticeManager.getNoticeInfo	 appid：100703379|wxcde873f99466f74a;openid:
		WeGame NoticeManager.getNoticeInfo	 Notice Model:mat_id may be null:860463020910104;mMatId:860463020910104
- 查看公告是否从管理段下发到客户端：

	**清空游戏本地数据，然后重新启动游戏，然后查看MSDK的日志，看后台下发的公告列表是否包含配置的公告。如果没有，找MSDK后台确认；如果有，继续往下看。**检查方法：
	
	在MSDK日志中看请求/notice/gather_data/的返回内容，事例如下：
		
		strResult:{"appid":"100703379|wxcde873f99466f74a","invalidMsgid":[{"invalidMsgid":"499"},{"invalidMsgid":"500"},{"invalidMsgid":"483"},{"invalidMsgid":"509"},{"invalidMsgid":"513"}],"list":[{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403614800","contentType":2,"contentUrl":"http://www.qq.com","endTime":"1412168400","msgContent":"","msgUrl":"http://www.baidu.com","msgid":"528","noticeType":0,"openid":"","picUrlList":[],"scene":"10","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403614800","contentType":1,"contentUrl":"","endTime":"1412168400","msgContent":"","msgUrl":"","msgid":"527","noticeType":0,"openid":"","picUrlList":[{"hashValue":"7a7ac418fb79917875cfd80c81ee4768","picUrl":"http://img.msdk.qq.com/notice/527/20140624211729_610X900.jpg","screenDir":1},{"hashValue":"2243f401734483f09ceeffd86006262d","picUrl":"http://img.msdk.qq.com/notice/527/20140624211739_1080X440.jpg","screenDir":2}],"scene":"10","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403573435","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"& &&兼容测试用例,2& && 关于特殊字符","msgUrl":"","msgid":"490","noticeType":0,"openid":"","picUrlList":[],"scene":"10","title":"& &&兼试2&"},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"滚动公告在配置的时候不能输入换行符。为咩？\r\n\r\n","msgUrl":"","msgid":"491","noticeType":1,"openid":"","picUrlList":[],"scene":"11","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"下面是个换行符\r\n一个换行符，\r\n又一个换行符\r\n哎呀，还有一个\r\n好吧，我想这应该是最后一个了\r\n我去，竟然还有一个\r\n这个真是最后一个了","msgUrl":"","msgid":"492","noticeType":0,"openid":"","picUrlList":[],"scene":"10","title":"换行符测试"},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"下面是个换行符\r\n一个换行符，\r\n又一个换行符\r\n哎呀，还有一个\r\n好吧，我想这应该是最后一个了\r\n我去，竟然还有一个\r\n这个真是最后一个了\r\n下面点击详情我该跳转了，我跳\r\n","msgUrl":"http://im.qq.com","msgid":"493","noticeType":0,"openid":"","picUrlList":[],"scene":"10","title":"换行符+跳转测试"},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"滚动公告在配置的时候不能输入换行符。为咩？\r\n\r\n","msgUrl":"","msgid":"494","noticeType":1,"openid":"","picUrlList":[],"scene":"11","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"& &&兼容测试用例,2& && 关于特殊字符*&……￥%……@#——+（）？》《，我应该出现在滚动公告栏里，我旁边应该还有一个滚动公告，在我前面还是后面呢？","msgUrl":"","msgid":"495","noticeType":1,"openid":"","picUrlList":[],"scene":"11","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403229600","contentType":0,"contentUrl":"","endTime":"1404011100","msgContent":"发送给全部用户有跳转的公告，结束时间距离当前时间非常近","msgUrl":"http://www.qq.com","msgid":"487","noticeType":0,"openid":"","picUrlList":[],"scene":"1","title":"结束时间，有跳转"},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403748000","contentType":0,"contentUrl":"","endTime":"1403834400","msgContent":"微信+手Q+android+滚动","msgUrl":"","msgid":"514","noticeType":1,"openid":"","picUrlList":[],"scene":"4","title":""}],"msg":"success","ret":0,"sendTime":"1403777179"}

	里面会包含所有公告的内容，游戏可以根据后台配置公告的id等缩小搜索范围，查看公告是否下发。
		
- 检查公告是否在本地时间的有效期：

	**检查MSDK的日志，查看调用展示公告的时候的本地时间，如果本地时间不在公告有效期内，请修改本地时间后再调试；如果本地时间在有效期，请继续往下看。**检查方法：

	在上一步中一定找到公告的开始结束时间等相关信息，在MSDK日志中查看调用NoticeDBModel.getNoticeRecordBySceneAndType时currentTimeStamp的值：

		WeGame MsdkThreadManager.showNoticeByScene	 showNotice
		WeGame NoticeManager.setAppinfo	 mAppId：wxcde873f99466f74a;mOpenId:oGRTijsKcz0dOi__dwJTZmINGfx0
		WeGame NoticeDBModel.getNoticeRecordBySceneAndType	 appId:wxcde873f99466f74a,openid:oGRTijsKcz0dOi__dwJTZmINGfx0,scene:10,noticetype:eMSG_NOTICETYPE_ALERT,currentTimeStamp:1403835077
		WeGame NoticeDBModel.getNoticeRecordBySceneAndType	 query result:5
		
	对比获取公告的时候取得本地时间，然后对比产看本地时间是否在公告有效期内（公告的开始与结束时间的区间内）。
	
- 检查调用接口参数是否正确

	**对比MSDK日志和游戏在公告管理端的配置，看公告接口调用的配置与后台是否一致。如果不一致，修改以后再调试；如果一致，继续往下看。**检查方法：

	在MSDK日志中看类似下面的日志：

		WeGame NoticeDBModel.getNoticeRecordBySceneAndType	 appId:100703379|wxcde873f99466f74a,openid:,scene:11,noticetype:eMSG_NOTICETYPE_SCROLL,currentTimeStamp:1409632268

	查看调用公告的时候传递的scene值和noticetype是否和游戏在公告管理段配置的一致，**尤其scene值对应的是管理段配置公告的公告栏ID。**
	
- 检查游戏的appid配置是否正确

	**对比游戏在onCreate里面配置的appid是否和在dev平台注册的一样，如果不一致，修改一致以后再调试，如果一致，找MSDK开发解决。**
	
	

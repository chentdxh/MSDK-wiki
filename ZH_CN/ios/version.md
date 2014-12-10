变更历史
===

## 2.3.2
 - 【代码变更】
1.【修改】更新OpenSDK2.5.1，修正在iOS8.1.1上，没有安装手Q时使用webView无法正常登录的问题。
 - 【编译变更】
1. Tencent_MSDK_IOS_V2.3.2i(支持arm32, iOS SDK7编译)：由于部分游戏使用的游戏引擎对iOS SDK8支持较差，MSDK使用iOS SDK7编译了32位包供这部分游戏使用。
2. Tencent_MSDK_IOS_V2.3.2i(支持arm64, iOS SDK8编译)：使用iOS SDK8编译的支持arm64的包。
---

## 2.3.1
 - 【代码变更】
1.【修改】更新RQD和灯塔，修正Crash上报本身导致的Crash隐患。
---

## 2.3.0

 - 【代码变更】
1.【修改】资源文件打包至WGplatformResources.bundle
2.【删除】米大师解耦，删除如下接口：
```
void WGRegisterPay(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* custom);// since 1.2.6
void WGPay(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGIAPRestoreCompletedTransactions(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGIAPLaunchMpInfo(unsigned char* offerId, unsigned char* openId, unsigned char* openKey, unsigned char* sessionId, unsigned char* sessionType, unsigned char* payItem, unsigned char* productId, bool isDepositGameCoin, uint32_t productType, uint32_t quantity, unsigned char* zoneId, unsigned char* varItem, unsigned char* custom);
void WGDipose();//since 1.2.6
bool WGIsSupprotIapPay();//since 1.2.6
void WGSetOfferId(unsigned char* offerId);//since 1.2.6
void WGSetIapEnvirenment(unsigned char* envirenment);
void WGSetIapEnalbeLog(bool enabled);
```
3、【新增】微信分享URL接口：
        void WGSendToWeixinWithUrl(
                        const eWechatScene& scene,
                        unsigned char* title,
                        unsigned char* desc,
                        unsigned char* url,
                        unsigned char* mediaTagName,
                        unsigned char* thumbImgData,
                        const int& thumbImgDataLen,
                        unsigned char* messageExt
                        );
4、【新增】推送总开关，需在plist配置MSDK_PUSH_SWITCH(string)为ON，若为其他值或不配置，则推送失效
5、【修改】删除滚动公告的配置项中(top,left,width)的配置，公告置顶占满屏幕宽度，若不设置高度则默认30pt
6、【新增】iOS8支持，LBS接口需要增加plist字段requestWhenInUseAuthorization，公告广告等显示的异常修复
7、【修改】优化Guest的存储，每个App存储在不同的key，避免企业证书写入Guest数据，互相覆盖。同时增加了迁移逻辑，避免进度丢失。
8、【修改】增加两个try－catch保护，避免user default读写时导致crash

 - 【修复BUG】
1、【修改】修复手Q游戏内加好友，好友备注和申请信息颠倒的问题
2、【修改】修复广告拉取os=1(安卓)的问题
3、【修改】修复AHAlertView以及子类在横屏展现错误的问题
4、【修改】修复WGRotationView以及子类在横竖屏ios7,8展现错误的问题
5、【修改】修复游客模式同证书不同应用相互覆盖guestid的问题
6、【修改】修复内置浏览器分享页面在iOS7,8的显示问题
7、【修改】修复内置浏览器广告按钮在没有广告时的显示问题
8、【修改】修复游客模式发送注册消息有概率失败的问题
9、【修改】修正RDM Crash上报时，AppID没有上报的问题。

---

## 2.2.0
- 【代码变更】
1、本地关键日志云端控制上报
2、MSDK在http报头的User-agent字段加上终端来源信息的需求			
3、信鸽PUSH发送全量用户	新需求，需plist配置MSDK_XGPUSH_URL			
4、MSDK 封装微信个人信息接口

---

##2.1.0
- 【代码变更】
1、增加广告特性，通过调用WGShowAD(_eADType& scene)接口展示广告，增加WGADObserver，用于广告点击回调；广告的相关配置放在MsdkResources/AdvertisementResources/AdvertisementConfig.plist
2、增加WGGetLocationInfo接口和OnLocationGotNotify回调，获得用户GPS地址并上报到MSDK后台；
3、WGGetNearBy接口增加gpsCity返回；
4、内置浏览器链接附带明文openid；
5、增加LoginInfo类，提供反射形式获取登录票据，减少耦合性。使用代码示例：
```
 Class loginInfoClass = NSClassFromString(@"LoginInfo");
    if (loginInfoClass) {
        id obj = [[[loginInfoClass alloc]init]autorelease];
        if ([obj respondsToSelector:@selector(description)]) {
            NSLog(@"Login info:%@",[obj description]);
        }
    }
```

---

## 2.0.7
 - 【代码变更】
1.【修改】更新OpenSDK2.5.1，修正在iOS8.1.1上，没有安装手Q时使用webView无法正常登录的问题。
---

## 2.0.6
 - 【代码变更】
1.【修改】增加Crash上报时的AppID和OpenId上报。
2.【修改】更新RQD和灯塔，修正Crash上报本身导致的Crash隐患
---

##2.0.5
- 【代码变更】
1.删除了使用苹果私有接口的代码

---

##2.0.4
- 【代码变更】
该版本合并2.0.2i与2.0.3i，无新增功能点。

---

##2.0.3
- 【代码变更】
1. 【新增】WGPlatform.h新增如下接口：
```
   /**
     *  获取游客模式下的id
     * 
     *
     */
    std::string WGGetGuestID();
    
    /**
     *  刷新游客模式下的id
     *
     *
     */
    void WGResetGuestID();
```
2. 【删除】删除如下接口：
```
    void WGRegisterAPNSPushNotification(NSDictionary *dict);
    void WGSuccessedRegisterdAPNSWithToken(NSData *data);
    void WGFailedRegisteredAPNS();
    void WGCleanBadgeNumber();
    void WGReceivedMSGFromAPNSWithDict(NSDictionary* userInfo);
```
3. 【修改】修改WGPublicDefine.h错误的#endif宏位置
4. 【新增】新增公共文件WGApnsInterface，包含如下接口：
```
    + (void)WGRegisterAPNSPushNotification:(NSDictionary*)dict;
    + (void)WGSuccessedRegisterdAPNSWithToken:(NSData *)data;
    + (void)WGFailedRegisteredAPNS;
    + (void)WGCleanBadgeNumber;
    + (void)WGReceivedMSGFromAPNSWithDict:(NSDictionary*) userInfo;
```
5. 【新增】增加内部文件GuestInterface处理游客模式逻辑

【文档调整】
1. 【新增】第13章：游客模式相关说明；
2. 【新增】第1章：增加一次性出C99和C11包的说明；
2. 【新增】第12章：修好APNS相关说明，改为调用WGApnsInterface

---

##2.0.2
- 【代码变更】
1、增加游戏内好友的三个接口，更新OpenSDK2.5，相应的需要使用手Q新版本：
```
    /**
	 * 游戏内加群,公会成功绑定qq群后，公会成员可通过点击“加群”按钮，加入该公会群
	 * @param cQQGroupKey 需要添加的QQ群对应的key，游戏server可通过调用openAPI的接口获取，调用方法可RTX 咨询 OpenAPIHelper
	 */
	void WGJoinQQGroup(unsigned char* cQQGroupKey);
	/**
	 * 游戏群绑定：游戏公会/联盟内，公会会长可通过点击“绑定”按钮，拉取会长自己创建的群，绑定某个群作为该公会的公会群
	 * @param cUnionid 公会ID，opensdk限制只能填数字，字符可能会导致绑定失败
	 * @param cUnion_name 公会名称
	 * @param cZoneid 大区ID，opensdk限制只能填数字，字符可能会导致绑定失败
	 * @param cSignature 游戏盟主身份验证签名，生成算法为openid_appid_appkey_公会id_区id 做md5.
	 * 					   如果按照该方法仍然不能绑定成功，可RTX 咨询 OpenAPIHelper
	 *
	 */
	void WGBindQQGroup(unsigned char* cUnionid, unsigned char* cUnion_name,
                       unsigned char* cZoneid, unsigned char* cSignature);
	/**
	 * 游戏内加好友
	 * @param cFopenid 需要添加好友的openid
	 * @param cDesc 要添加好友的备注
	 * @param cMessage 添加好友时发送的验证信息
	 */
	void WGAddGameFriendToQQ(unsigned char* cFopenid, unsigned char* cDesc,
                             unsigned char* cMessage);
```
---

##2.0.1
- 【代码变更】
1、公告增加图片公告类型，公告结构体增加图片数据，详见MSDK接入文档2.0
2、增加LoginWithLocalInfo接口来校验票据，游戏启动或从后台切到前台调用此方法。

---

##2.0.0
- 【代码变更】
1. 浏览器功能点优化，修正内置浏览器；
2. 增加图片、网页公告类型；定时下载公告数据;
3. 增加自动登陆流程，进行票据校验,定时刷新accessToken等票据；
4. 更新手Q sdk1.1.1版本，修复手Q授权游戏被回收导致的授权失败bug；
5. 本地日志方案，在info.plist配置MSDK_LOG_TO_FILE为YES，将记录MSDK的输出日志到Caches/msdk.log；

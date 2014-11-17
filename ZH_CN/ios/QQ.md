QQ接入
===

## 接入配置

  * 在工程设置的`Target->Info->Custom iOS Target Properties`中，添加配置项，主要配置项如下。

  ![Alt text](./QQ1.png)
  
| Key      |    Type | Value  |备注|相关模块|
| :-------- | --------:| :-- |:--|:---:|
| QQAppId  | String |  各游戏不同 |手Q的Appid|所有|
| QQAppKey  | String |  各游戏不同 |手Q的AppKey|所有|
  
  *	在工程设置的`Target->Info->URL Types`中设置URL Scheme，配置如下：
    ![Alt text](./QQ2.png)
	![Alt text](./QQ3.png)
  
| Identifier|    URL Scheme | 示例  | 备注  |
| :-------- | :--------| :--: | :--: |
| tencentopenapi  | 格式：tencent+游戏的QQAppID |tencent100703379|  接入手Q必填，中间无空格   |
| QQ  | 格式：QQ+游戏的QQAppID的16进制 |QQ06009C93 | 接入手Q必填，中间无空格   |
| QQLaunch  | 格式：tencentlaunch+游戏的QQAppID |tencentlaunch100703379|  接入手Q必填，中间无空格   |

   > **注：各游戏配置存在不一致，具体请咨询各游戏与MSDK接口人或RTX联系“连线MSDK”。**
 
 ---
## 授权登录
 ### 概述
 - 通过唤起手Q客户端或web页面授权，授权成功后返回给游戏openId、accessToken、payToken (附录A票据类型)、pf和pfKey。
完成手Q授权需要调用WGSetPermission和WGLogin接口完成。
```
void WGSetPermission(unsigned int permissions);
```
>描述: 设置QQ登录时候需要用户授权的权限列表
参数:
- permissions　 WGQZonePermissions中有所有权限的定义，选定自己需要的权限，或运算的结果即为此参数．

 - 
```
void WGLogin(ePlatform platform);
```
>描述: 登录统一接口传入_ePlatform. ePlatform_QQ调用手Q授权。
参数: 
  - 传入_ePlatform. ePlatform_QQ调用手Q客户端授权
  - 在已设置全局回调对象的情况下，授权或失败都通过OnLoginNotify（LoginRet ret）回调给游戏。LoginRet.platform为当前授权平台。LoginRet.flag标识授权结果：
eFlag_Succ                     //成功
    eFlag_QQ_NoAcessToken         //手Q授权失败，获取不到accesstoken
    eFlag_QQ_UserCancel            //用户取消手Q授权
    eFlag_QQ_LoginFail             //手授权失败
    eFlag_QQ_NetworkErr           //网络异常



#### 示例代码
- 授权调用代码如下：
```
WGPlatform* plat = WGPlatform::GetInstance();//初始化MSDK
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);//设置回调
plat->WGSetPermission(eOPEN_ALL);//设置授权权限
plat->WGLogin(ePlatform_QQ);//调用手Q客户端或web授权
```
- 授权回调代码如下：
```ruby
void MyObserver::OnLoginNotify(LoginRet& loginRet)
{
if(eFlag_Succ == loginRet.flag)
{
    …//login success
    std::string openId = loginRet.open_id;
    std::string payToken;
    std::string accessToken;
    if(ePlatform_QQ == loginRet.Platform)
    {
        for(int i=0;i< loginRet.token.size();i++)
        {
            TokenRet* pToken = & loginRet.token[i];
            if(eToken_QQ_Pay == pToken->type)
            {
                paytoken = pToken->value;
            }
            else if (eToken_QQ_Access == pToken->type)
{
     accessToken = pToken->value;
}
        }
    }
else if (ePlatform_Weixin == loginRet.platform)
{
        ….
}
} 
else
{
    …//login fail
     NSLog(@"flag=%d,desc=%s",loginRet.flag,loginRet.desc.c_str()); 
}
}
```

####注意事项
- 手Q版本4.0及以上才支持客户端授权
- 手Q未安装或配置错误会进入web授权。web授权应该唤起手Q内置webVeiw授权，如唤起外部浏览器则联系RTX”连线MSDK”。
- URL Types中的scheme tencentopenapi必须配置正确才能唤起手Q客户端授权。
---
##快速登录
###概述
- 可以在手Q游戏列表，或分享链接中直接将手Q已登录的帐号信息传到游戏实现登录，不需要游戏再次授权。

- 环境依赖：
>1. MSDK 1.8.0i以上;
>2. 手Q4.6.2以上;
>3. 游戏配置scheme：
	![Alt text](./QQ4.png)
- 成功则在拉起游戏，携带openId、accessToken、payToken (附录A票据类型)、pf和pfKey。

- 快速登录和异帐号结果在wakeupRet的flag中返回，相关的flag说明如下：
```ruby
eFlag_Succ: 
不存在异账号，成功唤起。这种情况下的拉起App的URL不携带票据，和之前版本的拉起一致。
eFlag_AccountRefresh: 
不存在异账号，MSDK已通过拉起App的URL携带的票据信息将本地账号票据刷新。
eFlag_UrlLogin：
不存在异账号，游戏通过快速登录信息登录成功。游戏接收到此flag以后直接读取LoginRet结构体中的票据进行游戏授权流程。
eFlag_NeedLogin：
游戏本地账号和拉起账号均无法登录。游戏接收到此flag以后需要弹出登录页让用户登录。
eFlag_NeedSelectAccount：
游戏本地账号和拉起账号存在异账号，游戏接收到此flag以后需要弹出对话框让用户选择登录的账号。
当flag为eFlag_NeedSelectAccount时，游戏需要弹出对话框由用户选择使用原账户，还是快速登录携带的账户。这是手Q平台要求必须实现的逻辑，不实现在平台审核时将会被拒绝上线。
```
提示示例（界面由各游戏分别实现）
	![Alt text](./QQ5.png)



- 用户选择后，需要调用WGSwitchUser接口进行异帐号后续逻辑处理。（两个选项都需要调用下面这个接口，详见示例代码）
```ruby
bool WGSwitchUser(bool flag);
```
>描述: 通过外部拉起的URL登录。该接口用于异帐号场景发生时，用户选择使用外部拉起帐号时调用。
参数:
>- flag
>- 为YES时表示用户需要切换到外部帐号，此时该接口会使用上一次保存的异帐号登录数据登录。登录成功后通过onLoginNotify回调；如果没有票据，或票据无效函数将会返回NO，不会发生onLoginNotify回调。
>- 为NO时表示用户继续使用原帐号，此时删除保存的异帐号数据，避免产生混淆。
返回 如果没有票据，或票据无效将会返回NO；其它情况返回YES。

###示例代码

- 在拉起app时增加设置回调的代码
```ruby
-(BOOL)application:(UIApplication*)application openURL:(NSURL *)url sourceApplication:(NSString *)sourceApplication annotation:(id)annotation
{
    NSLog(@"url == %@",url);
    WGPlatform* plat = WGPlatform::GetInstance();
    WGPlatformObserver *ob = plat->GetObserver();
    if (!ob) {
        MyObserver* ob = new MyObserver();
        ob->setViewcontroller(self.viewController);
        plat->WGSetObserver(ob);
    }
    return [WGInterface HandleOpenURL:url];
}
```
- 拉起回调代码示例如下:

        void MyObserver::OnWakeupNotify (WakeupRet& wakeupRet)
            {
        switch (wakeupRet.flag) {
             case eFlag_Succ:
         [viewController setLogInfo:@"唤醒成功"];
        break;
        case eFlag_NeedLogin:
            [viewController setLogInfo:@"异帐号发生，需要进入登录页"];
            break;
        case eFlag_UrlLogin:
            [viewController setLogInfo:@"异帐号发生，通过外部拉起登录成功"];
            
            break;
        case eFlag_NeedSelectAccount:
        {
            [viewController setLogInfo:@"异帐号发生，需要提示用户选择"];
            UIAlertView *alert = [[[UIAlertView alloc]initWithTitle:@"异帐号" message:@"发现异帐号，请选择使用哪个帐号登录" delegate:viewController cancelButtonTitle:@"不切换，使用原帐号" otherButtonTitles:@"切换外部帐号登录", nil] autorelease];
            [alert show];
        }
            break;
        case eFlag_AccountRefresh:
            [viewController setLogInfo:@"外部帐号和已登录帐号相同，使用外部票据更新本地票据"];
            break;
        default:
            break;
         }
            if(eFlag_Succ == wakeupRet.flag ||
       eFlag_NeedLogin == wakeupRet.flag ||
       eFlag_UrlLogin == wakeupRet.flag ||
       eFlag_NeedSelectAccount == wakeupRet.flag ||
       eFlag_AccountRefresh == wakeupRet.flag)
             {
        [viewController setLogInfo:@"唤醒成功"];
             }
             else
          {
        [viewController setLogInfo:@"唤醒失败"];
          }
            } 

        - (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex {
          BOOL switchFlag = NO;
          switch (buttonIndex) {
             case 0:
            NSLog(@"用户选择不切换帐号");
            break;
        case 1:
        {
            NSLog(@"用户选择切换帐号");
            switchFlag = YES;
        }
            break;
        default:
            break;
                   }
             WGPlatform* plat = WGPlatform::GetInstance();
                          plat->WGSwitchUser(switchFlag);
        }


### 注意事项
- 手Q版本4.6以上才支持快速登录。
- URL Types中的scheme 需配置tencentlaunch+appid拉起时才会携带登录信息。
- ---

##手Q关系链查询

- ###查询个人信息
#### 概述
用户通过手Q授权后只能获取到openId和accessToken，此时游戏需要用户昵称，性别，头像等其他信息。手Q授权成功后可调用WGQueryQQMyInfo获取个人信息。
- 
```ruby
bool WGQueryQQMyInfo();
```
>描述: 获取用户QQ帐号基本信息
返回值：
  - false:手Q未授权或appid等配置不对
  -  true:参数无异常
通过OnRelationNotify(RelationRet& relationRet) 回调游戏
RelationRet（附录A）结构体中PersonInfo的province和city字段手Q为空，小、中、大三幅图片尺寸为：40 40 100（像素）

 #### 调用示例代码：
- 
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGQueryQQMyInfo();
```
#### 回调示例代码：
- 
```ruby
OnRelationNotify(RelationRet &relationRet)
{
    NSLog(@"relation callback");
    NSLog(@"count == %d",relationRet.persons.size());
    for (int i = 0; i < relationRet.persons.size(); i++)
    {
        PersonInfo logInfo = relationRet.persons[i];
        NSLog(@"nikename == %s",logInfo.nickName.c_str());
        NSLog(@"openid==%s",logInfo.openId.c_str());
    }
}
```

 ###查询同玩好友信息
####概述
- 游戏授权后需要查询用户同玩好友的昵称，性别，头像、openid等信息，可以调用WGQueryQQGameFriendsInfo获取。
```ruby
bool WGQueryQQGameFriendsInfo();
```
>描述: 获取用户QQ同玩好友基本信息
返回值：
   - false:手Q未授权或appid等配置不对
   - true:参数无异常
通过OnRelationNotify(RelationRet& relationRet) 回调游戏
RelationRet（附录A）结构体中PersonInfo的province和city字段手Q为空，小、中、大三幅图片尺寸为：40、40、100（像素）。

- 调用示例代码：
 ```ruby
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGQueryQQGameFriendsInfo();
回调示例代码：
OnRelationNotify(RelationRet &relationRet)
{
    NSLog(@"relation callback");
    NSLog(@"count == %d",relationRet.persons.size());
    for (int i = 0; i < relationRet.persons.size(); i++)
    {
        PersonInfo logInfo = relationRet.persons[i];
        NSLog(@"nikename == %s",logInfo.nickName.c_str()]);
        NSLog(@"openid==%s",logInfo.openId.c_str();
    }
}
```
####注意事项
- 手Q授权成功
---

##手Q结构化消息分享
  
-   ###概述
- 手Q结构化消息可以通过WGSendToQQ唤起手Q分享，可以在手Q中选择需要分享的对象（群、讨论组、好友）或QZone。可以在游戏内直接WGSendToQQGameFriend接口分享到指定好友（不唤起手Q），需要传入指定好友的openId，所以只能分享到同玩好友。

 ###唤起手Q客户端分享
- 唤起手机QQ(iphone版)或通过网页，在手Q内部选择分享的好友或空间。手Q会话中点击此会话会打开传入的url，通常此url配置成游戏在手Q游戏中心的详情页。Qzone中点击此消息会大图展示图片。网页分享体验较差，不推荐使用，游戏可以弹框提示用户安装手Q。
 ```ruby
void WGSendToQQ(const eQQScene[Int 转为 eQQScene]& scene, unsigned char* title,  unsigned char* desc,   unsigned char* url,  unsigned char* imgData, const int& imgDataLen);
```
>描述: 分享消息到手Q回话或Qzone, url填游戏手Q游戏中心详情页, 点击消息则会在手Q游戏中心详情页唤起游戏。
参数:
    - scene 标识分享到朋友圈还是会话
    - QQScene_Qzone：唤起手Q并默认弹出分享到空间的弹框
    - QQScene_session：唤起手Q没有空间，只能分享到好友
    - title 分享标题
    - desc 分享的具体描述
    - url  内容的跳转url，填游戏对应游戏中心详情页&游戏自定义字段。在手Q中点击此会话MSDK会将游戏自定义参数通过OnWakeupNotify(Wakeu    pRet ret) ret.extInfo透传给游戏。如果游戏不需要透传参数，则直接填游戏中心详情页即可。自定义字段透传需要手Q4.6及以上版本支持。
 例如：游戏中心详情页为“AAAAA”,游戏自定义字段为“bbbbb”，则url为：AAAAA&bbbbb。bbbbb通过wakeupRet.extInfo返回给游戏。
    - imgData 图片文件数据
    - imgDataLen 图片文件数据长度
分享成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。ret.flag表示不同的分享结果，具体见eFlag(附录A)

	调用代码示例：
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);
NSString* gameid=@"微胖";
NSString* question=@"问题时什么，动不动啊";
NSString* 	url=@"XXXXX"
NSString *path = "188.jpg"
NSData* data = [NSData dataWithContentsOfFile:path];
plat->WGSendToQQ(
                     1,
                     (unsigned char*)[gameid UTF8String],
                     (unsigned char*)[question UTF8String],
                     (unsigned char*) [url UTF8String],
                     (unsigned char*)[data bytes],
                     [data length]
                     ); 
	回调代码示例：
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
    NSLog(@"分享成功");
    }
    else if(eFlag_QQ_UserCancel == shareRet.flag)
{
    NSLog(@"用户取消分享");
    }
    else if(eFlag_QQ_NetworkErr == shareRet.flag)
    {
        NSLog(@"网络错误");
    }
}
```
###直接分享到好友（不需要唤起手Q客户端）
####概述
- 不会唤起手Q客户端直接发送的指定的同玩好友，同玩好友的openId可以通过WGQueryQQGameFriendsInfo接口获取。此分享消息在pc QQ上不显示。
```ruby
bool WGSendToQQGameFriend(int act, unsigned char* fopenid, unsigned char *title, unsigned char *summary, unsigned char *targetUrl, unsigned char *imgUrl, unsigned char* previewText, unsigned char* gameTag, unsigned char* extMsdkInfo[1.7.0i])
```
>描述: 点对点定向分享(分享消息给手机QQ好友，在对话框中显示)。分享的内容只有手机QQ上才可以看到，PCQQ上看不到。手Q中点击此会话可以唤起游戏
返回值：
     false:手Q未授权或参数非法
     true:参数无异常
参数: 
 - act 必填参数
0：在手Q点击此分享消息跳转到targetUrl中的地址
1：在手Q点击此分享消息唤起游戏
 - fopenid 必填参数 好友对应游戏中的openid，分享到此好友
 - title必填参数   分享标题
 - summary 必填参数   摘要
 - targetUrl 必填参数 分享url
 - imgUrl 必填参数 
分享图片url (图片尺寸规格为128*128；需要保证网址可访问；且大小不能超过2M)
 - previewText非必填。
 - 分享的文字内容，可为空。如“我在天天连萌”，长度不能超过45字节
 - gameTag 非必填。
    game_tag	用于平台对分享类型的统计，比如送心分享、超越分享，该值由游戏制定并同步给手Q平台，目前的值有：
MSG_INVITE                //邀请
MSG_FRIEND_EXCEED       //超越炫耀
MSG_HEART_SEND          //送心
  MSG_SHARE_FRIEND_PVP    //PVP对战
 - extMsdkInfo 分享时游戏传入，通过ShareRet.extInfo回调给游戏。[1.7.0i]
分享结束会通过OnShareCallBack(ShareRet ret)回调给游戏。Ret.flag表示不同的分享结果，具体见eFlag(附录A)


 - 调用代码示例：
```ruby
unsigned char* openid = (unsigned char*)"86EA9CA0C965B7EE9793E7D0B29161B8";
unsigned char* picUrl = (unsigned char*)"XXXXX";
unsigned char* title = (unsigned char*)"msdk 测试 QQ 分享来了";
unsigned char* target_url = (unsigned char*)"http://www.qq.com";
unsigned char* summary = (unsigned char*)"msdk 摘要也来了";
unsigned char* previewText = (unsigned char*)"我在玩天天爱消除";
unsigned char* game_tag = (unsigned char*)"MSG_INVITE";
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGSendToQQGameFriend(
                               1,
                               openid1,
                               title,
                               summary,
                               target_url,
                               picUrl,
                               previewText,
                               game_tag
                               );
```
回调代码示例：
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
        NSLog(@"分享成功");
    }
    else 
{
   NSLog(@"error message = %s",shareRet.desc.c_str()); 
    }
}
```
####注意事项
 - 需要手Q版本4.0及以上
 - 直接分享必须先手Q授权成功
 - 唤起手Q分享到Qzone的弹框需要手Q4.5及以上版本
 - WGSendToQQ自定义字段透传需要手Q4.6及以上版本支持。
##手Q大图分享
###概述
调用WGSendToQQWithPhoto会唤起手Q，在手Q内部选择分享的好友或空间进行大图分享。手Q中点击此分享消息会全屏预览图片。
```ruby
void WGSendToQQWithPhoto(const eQQScene[Int 转 eQQScene]& scene, unsigned char* imgData, const int& imgDataLen)
```
>描述: 分享消息到手Q回话消息或Qzone
  -  scene 标识分享到朋友圈还是会话
QQScene_Qzone：唤起手Q并默认弹出分享到空间的弹框
QQScene_session：唤起手Q没有空间，只能分享到好友
  - imgData 图片文件数据
  - imgDataLen 图片文件数据长度

 - 分享成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。ret.flag表示不同的分享结果，具体见eFlag(附录A)
###示例代码
调用代码示例：
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver();
ob->setViewcontroller(self);
plat->WGSetObserver(ob);
NSString *path = "422.png";
NSData* data = [NSData dataWithContentsOfFile:path];
plat->WGSendToQQWithPhoto(1,(unsigned char*)[data bytes], [data length]);
```
 - 回调代码示例：
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
        NSLog(@"分享成功");
}
else if(eFlag_QQ_NotInstall == shareRet.flag)
{
        NSLog(@"手Q未安装");
    }
    else if(eFlag_QQ_UserCancel == shareRet.flag)
{
        NSLog(@"用户取消分享");
    }
    else if(eFlag_QQ_NetworkErr == shareRet.flag)
    {
            NSLog(@"网络错误");[代码缩进统一]
    }
}
```
###注意事项
 - 手Q4.2及以上版本
 - 唤起手Q分享到Qzone的弹框需要手Q4.5及以上版本
 - 不能通过web分享。
 ---
##手Q接入注意事项
 - ###手Q功能对应支持版本
通过`WGGetIphoneQQVersion()`方法可以获取手Q版本号。
```ruby
int WGGetIphoneQQVersion();
```
>描述: 获取用户QQ帐号基本信息
    手Q版本号枚举如下：
        typedef enum QQVersion
    	{
        kQQVersion3_0,
        kQQVersion4_0,      //支持sso登录
    	kQQVersion4_2_1,    //ios7兼容
    	kQQVersion4_5,      //4.5版本
    	kQQVersion4_6,      //4.6版本
	    } QQVersion;
返回值：
   手Q版本

- 功能对应手Q版本

|功能|	说明|	手Q支持版本|
|----|----|----|
|授权|		|4.0及以上|
|结构化分享|	|	4.0及以上|
|大图分享	||	4.0及以上|
|QZone分享弹框|	唤起手Q默认有弹框|	4.5及以上|
|快速登录|	手Q唤起游戏带登录态	|4.6及以上|
|结构化消息透传字段|	MSDK将此字段透传回游戏|	|
|异帐号|	平台唤起游戏是否带openid到游戏（异帐号）|	4.2及以上|

##手Q游戏内添加好友和群
 - ###概述
 以下接口2.0.2i以后提供，需要手Q5.1版本以上，且App id已经在手Q后台审核通过并上线：
WGAddGameFriendToQQ:可以在游戏内选择其它玩家，调用该接口添加为好友；
WGBindQQGroup:工会会长可以选择自己创建的群，绑定某个群作为该工会的工会群
```ruby
void WGAddGameFriendToQQ(
unsigned char* cFopenid, unsigned char* cDesc, unsigned char* cMessage)
```
>描述: 游戏内加好友
  - 参数: 
  - cFopenid  必填参数 需要添加好友的openid
  - cDesc  必填参数 要添加好友的备注
  - cMessage    添加好友时发送的验证信息
  添加成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。ret.flag表示不同的分享结果，具体见eFlag(附录A)

 ```ruby
void  WGBindQQGroup (unsigned char* cUnionid, unsigned char* cUnion_name,
                       unsigned char* cZoneid, unsigned char* cSignature)
```
>描述: 游戏群绑定：游戏公会/联盟内，公会会长可通过点击“绑定”按钮，拉取会长自己创建的群，绑定某个群作为该公会的公会群
  - 参数: 
  - cUnionid 公会ID，opensdk限制只能填数字，字符可能会导致绑定失败，一个公会只能绑定一个群。如果需要解绑，请查看QQ API 文档（如下）。如有其它问题可rtx联系OpenAPIHelper(OpenAPI技术支持) http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup
  - cUnion_name 公会名称
  - cZoneid 大区ID，opensdk限制只能填数字，字符可能会导致绑定失败
  - cSignature 游戏盟主身份验证签名，生成算法为openid_appid_appkey_公会id_区id 做md5
  添加成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。ret.flag表示不同的分享结果，具体见eFlag(附录A)
  
 - ###示例代码 
 调用代码示例：
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
//加好友
plat->WGAddGameFriendToQQ((unsigned char*)"D2DEFFFBE310779E88CD067C9D3329E5", (unsigned char*)"测试加好友", (unsigned char*)"你好吗～");
  //绑定群
    LoginRet ret;
    plat->WGGetLoginRecord(ret);    
    NSString *uinionId = @"1";
    NSString *zoneId = @"1";
    NSString *openId = [NSString stringWithCString:ret.open_id.c_str() encoding:NSUTF8StringEncoding];
    NSString *appId = @"100703379";
    NSString *appKey = @"4578e54fb3a1bd18e0681bc1c734514e";
    NSString *orgSigStr = [NSString stringWithFormat:@"%ld",(unsigned long)[[NSString stringWithFormat:@"%@_%@_%@_%@_%@",openId,appId,appKey,uinionId,zoneId]hash]];
    
    plat->WGBindQQGroup((unsigned char*)"1", (unsigned char*)"1", (unsigned char*)"test", (unsigned char*)[orgSigStr UTF8String]);
```
回调代码示例：
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
        NSLog(@"分享成功");
}
else if(eFlag_QQ_NotInstall == shareRet.flag)
{
        NSLog(@"手Q未安装");
    }
    else if(eFlag_QQ_UserCancel == shareRet.flag)
{
        NSLog(@"用户取消分享");
    }
    else if(eFlag_QQ_NetworkErr == shareRet.flag)
    {
            NSLog(@"网络错误");
    }
}
```
###注意事项
 - 手Q5.1及以上版本
 - 一个工会只能绑定一个群，如果需要解绑，请查看QQ API 文档（如下）。如有其它问题可rtx联系OpenAPIHelper(OpenAPI技术支持)。
http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup
 - 使用游戏内绑定好友和群的接口，需要接入的App id已经在手Q后台审核通过并上线
 ---
微信接入
===

##微信接入配置
 
  * 在工程设置的`Target->Info->Custom iOS Target Properties`中，添加配置项，主要配置项如下。
  ![Alt text](./WX1.png)

| Key      |    Type | Value  |备注|相关模块|
| :-------- | --------:| :-- |:--|:---:|
| WXAppID  | String |  各游戏不同 |微信的AppID|所有|
| WXAppKey  | String |  各游戏不同 |微信的AppKey|所有|
  
  *	在工程设置的`Target->Info->URL Types`中设置URL Scheme，配置如下：
  ![Alt text](./WX2.png)
  
| Identifier|    URL Scheme | 示例  | 备注  |
| :-------- | :--------| :--: | :--: |
| weixin  | 游戏的微信AppID |wxcde873f99466f74a | 接入微信必填   |

---

##微信授权
 - ###概述
唤起微信客户端进行授权，获取微信openId、accesstoken和refreshtoken(附录A票据类型)，pf和pfKey。
```ruby
void WGLogin(ePlatform platform);
```
>描述: 登录统一接口传入_ePlatform. ePlatform_Weixin调用微信授权。
参数: 
   -  传入_ePlatform. ePlatform_Weixin调用微信客户端授权
设置observer的情况下，授权或失败都通过OnLoginNotify（LoginRet ret）回调给游戏。回调结果ret.flag说明如下：
```
eFlag_WX_NotInstall     = 2000,     //微信未安装
    eFlag_WX_NotSupportApi  = 2001,     //微信版本不支持
eFlag_WX_UserCancel     = 2002,     //用户取消微信授权
    eFlag_WX_UserDeny       = 2003,     //用户拒绝微信授权
eFlag_WX_LoginFail      = 2004,     //微信授权失败
```

- ###示例代码
调用代码如下:
```ruby
MyObserver* ob = new MyObserver(); 
plat->WGSetObserver(ob);//设置回调对象
plat->WGLogin(ePlatform_Weixin);
```
回调代码如下：
```ruby
void MyObserver::OnLoginNotify(LoginRet& loginRet)
{
if(eFlag_Succ == loginRet.flag)
{
    …//login success
    std::string openId = loginRet.open_id;
    std::string refreshToken;
    std::string accessToken;
    if(ePlatform_Weixin == loginRet.Platform)
    {
        for(int i=0;i< loginRet.token.size();i++)
        {
            TokenRet* pToken = & loginRet.token[i];
            if(eToken_WX_Access == pToken->type)
            {
                accessToken = pToken->value;
            }
            else if (eToken_WX_Refresh == pToken->type)
{
     refreshToken = pToken->value;
}
        }
    }
else if(ePlatform_QQ == loginRet.Platform)
{
}
}
else
{
    …//login fail
     NSLog(@"flag=%d,desc=%s",loginRet.flag,loginRet.desc.c_str()); 
}
}
```
- ### 注意事项
 - 微信版本4.0及以上
 
---

## 微信关系链接口
 - ###查询微信个人信息
 - 调用WGQueryWXMyInfo查询微信个人信息，包括：昵称，性别，头像、城市、省份等信息。
```ruby
bool WGQueryWXMyInfo();
```
>描述: 获取用户微信帐号基本信息
返回值：
   false:微信未授权或AppID等配置不对
   true:参数无异常
通过OnRelationNotify(RelationRet& relationRet) 回调游戏
RelationRet（附录B）结构体中PersonInfo的小、中、大三幅图片尺寸为：46、96、132（像素），个人信息中的国家和语言信息通过country和lang返回给游戏。[1.7.0新增国家语言信息 ]

 - 调用代码事例：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGQueryWXMyInfo();
回调示例代码：
OnRelationNotify(RelationRet &relationRet)
{
    NSLog(@"relation callback");
    NSLog(@"count == %d",relationRet.persons.size());
    for (int i = 0; i < relationRet.persons.size(); i++)
    {
        PersonInfo logInfo = relationRet.persons[i];
        NSLog(@"nikename==%s",logInfo.nickName.c_str()]);
        NSLog(@"openid==%s",logInfo.openId.c_str());
    }
}
```

 - ###查询微信同玩好友信息
通过调用WGQueryWXGameFriendsInfo查询微信同玩信息，包括：昵称，性别，头像、城市、省份等信息。
```ruby
bool WGQueryWXGameFriendsInfo();
```
>描述: 获取用户微信同玩好友基本信息
返回值：
   false:微信未授权或AppID等配置不对
   true:参数无异常
通过OnRelationNotify(RelationRet& relationRet) 回调游戏
RelationRet（附录A）结构体中PersonInfo的小、中、大三幅图片尺寸为：46、96、132（像素），好友信息里面没有国家和语言

 - 调用事例代码：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGQueryWXGameFriendsInfo();
```
回调示例代码：
```ruby
OnRelationNotify(RelationRet &relationRet)
{
    NSLog(@"relation callback");
    NSLog(@"count == %d",relationRet.persons.size());
    for (int i = 0; i < relationRet.persons.size(); i++)
    {
        PersonInfo logInfo = relationRet.persons[i];
        NSLog(@"nikename==%s",logInfo.nickName.c_str());
        NSLog(@"openid==%s",logInfo.openId.c_str());
    }
}
```
###注意事项
 - 微信正确授权

---

##微信结构化分享
 - ###唤起微信客户端分享到好友
游戏通过唤起微信客户端来分享，在微信中选择分享到的好友。图片大小不能大于32k，大于32k微信会默认分享一张图片代替。不能分享到微信朋友圈。
```ruby
void WGSendToWeixin(unsigned char* title, unsigned char* desc, unsigned char* mediaTagName, unsigned char* thumbImgData, const int& thumbImgDataLen, unsigned char* messageExt);
```
>描述: 分享App消息到微信好友, 点击此分享详细能唤起游戏。此类消息不能分享到朋友圈，分享到朋友圈使用WGSendToWeixinWithPhoto接口。
参数: 
- title 分享的标题
  - desc 分享的描述
  - mediaTagName 使用者自己设定一个值, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源.
  - thumbImgData 分享时展示的缩略图数据（不要超过32K）
  - thumbImgDataLen 分享时展示的缩略图的长度, 需要和thumbImgData匹配, 不能为空
  - messageExt 游戏分享传入此字段，微信中点击此分享会话唤起游戏MSDK会将此字段透传给游戏。需要微信5.1及以上版本。
 分享成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。Ret.flag表示不同的分享结果，具体见eFlag(附录A)

 - 
```ruby
void WGSendToWeixin(const eWechatScene& scene, unsigned char* title, unsigned char* desc, unsigned char* url, unsigned char* mediaTagName, unsigned char* thumbImgData, const int& thumbImgDataLen);
```
>描述: 此接口保留只为兼容已经接入的MSDK老版本的游戏，新接入游戏不需要关心此接口

 - 调用代码事例：
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);
NSString* title=@"分享标题";
NSString* desc=@"分享内容";
char*  mediaTag = "MSG_INVITE";
NSString *path = "29.jpg";
NSData* data = [NSData dataWithContentsOfFile:path];
plat->WGSendToWeixin(
                         (unsigned char*)[title UTF8String],
                         (unsigned char*)[desc UTF8String],
                         (unsigned char*)mediaTag,
                         (unsigned char*)[data bytes],
                         [data length],
                         (unsigned char*)ext
                         ); 
```
 - 回调代码事例：
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
    NSLog(@"分享成功");
}
     else if(eFlag_WX_NotInstall == shareRet.flag)
{
    NSLog(@"微信未安装");
    }
 else if(eFlag_WX_UserCancel == shareRet.flag)
{
    NSLog(@"用户取消分享");
    }
    else if(eFlag_WX_UserDeny == shareRet.flag)
{
    NSLog(@"用户拒绝分享");
    }
}
```

 ###直接分享到微信好友
 - 调用WGSendToWXGameFriend分享到指定openid的微信同玩好友。不会唤起微信客户端。
 ```ruby
WGSendToWXGameFriend(unsigned char *fOpenId, unsigned char *title, unsigned char *description, unsigned char *mediaId, unsigned char *extinfo, unsigned char *mediaTagName,  unsigned char *extMsdkInfo)[1.7.0i]
```
>描述: 将分享消息发送给微信好友（只能发送给安装了相同游戏的好友）。在微信中点击此消息会唤起游戏。
返回值：
      false:手Q未授权或参数非法
      true:参数无异常
参数: 
  - fopenid 必填参数 好友对应游戏中的openid，分享到此好友
  - title必填参数   分享标题
  - description必填参数   应用消息描述
  - mediaId必填参数 游戏图标，通过后台接口/share/upload_wx接口获取
  - extinfo非必填。
第三方程序自定义简单数据，微信会回传给第三方程序处理，长度限制2k, 客户端点击的时候可以获取到这个字段。
  - mediaTagName 非必填。
区分游戏消息类型，用于数据统计
  - extMsdkInfo 分享时游戏传入，通过ShareRet.extInfo回调给游戏。[1.7.0i]
分享结束会通过OnShareCallBack(ShareRet ret)回调给游戏。Ret.flag表示不同的分享结果，具体见eFlag(附录A)

- 调用代码事例：
```ruby
unsigned char* title = (unsigned char*)"msdk 测试 QQ 分享来了";
unsigned char* description = (unsigned char*)"我在玩天天爱消除";
unsigned char* media_tag_name = (unsigned char*)"MSG_INVITE";
unsigned char* fopenid = (unsigned char*)"oKdX1juRjuwIwIeSXRrTiq51kjc4";
unsigned char* mediaid = (unsigned char*)XXXXX";
unsigned char* extinfo = (unsigned char*)"balabalabalabala";
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGSendToWXGameFriend(fopenid, title, description, mediaid, extinfo, media_tag_name);
```
- 回调代码示例：
```
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
### 注意事项
-  WGSendToWeixin分享图片必须小于32K
 - 图片大小不能大于10M

 ---
 
##微信大图分享
 - ### 概述
游戏通过唤起微信客户端来分享，在微信中选择分享到的好友。图片大小不能大于10M。
```ruby
void WGSendToWeixinWithPhoto(const eWechatScene[Int 转为 eWechatScene]& scene, unsigned char* mediaTagName, unsigned char* imgData, const int& imgDataLen, unsigned char* messageExt, unsigned char* messageAction);
```
>描述: 分享图片消息到微信, 此类消息只可以分享到会话和到朋友圈.点击分享的图片则大图展示图片
参数: 
  - scene 标识分享到朋友圈还是会话 
WechatScene_Session：会话
WechatScene_Timeline：朋友圈
  - mediaTagName 使用者自己设定一个值, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源.
  - imgData分享的图片数据，png格式图片需要用UIImagePNGRepresentation方法获取图片数据
  - imgDataLen 分享的图片数据长度
  - messageExt 游戏分享是传入字符串，通过此分享消息唤起游戏会通过
OnWakeUpNotify(wakeupRet ret)中ret.messageExt透传给游戏
  - messageAction 第一个参数scene为1的情况下才起作用，会在分享到朋友圈的消息中多一个按钮，点击按钮可以唤起游戏，跳转到排行榜或游戏主页。取值和作用如下：
WECHAT_SNS_JUMP_SHOWRANK       跳排行
WECHAT_SNS_JUMP_URL            跳链接
WECHAT_SNS_JUMP_APP           跳APP[朋友圈按钮显示有网络延迟且必须在微信5.1及以上版本]
void WGSendToWeixinWithPhoto(const int& scene, unsigned char* mediaTagName, unsigned char* imgData, const int& imgDataLen);
描述: 此接口保留只为兼容已经接入的MSDK老版本的游戏，新接入游戏不需要关心此接口
分享成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。Ret.flag表示不同的分享结果，具体见eFlag(附录A)

 ### 代码示例
调用代码示例：
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver();
ob->setViewcontroller(self);
plat->WGSetObserver(ob);
char* mediaTag = "mediaTag";
UIImage *image = [UIImage imageNamed:@"356.png"];
NSData *data = UIImagePNGRepresentation(image);
plat->WGSendToWeixinWithPhoto(
                                  1,
                                  (unsigned char*)mediaTag,
                                  (unsigned char*)[data bytes],
                                  [data length],
                                  (unsigned char*)"msdkwuwuwu",
                                  (unsigned char*)"WECHAT_SNS_JUMP_APP"
                                  ); 
```
回调代码事例：
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
    NSLog(@"分享成功");
}
     else if(eFlag_WX_NotInstall == shareRet.flag)
{
    NSLog(@"微信未安装");
    }
 else if(eFlag_WX_UserCancel == shareRet.flag)
{
    NSLog(@"用户取消分享");
    }
    else if(eFlag_WX_UserDeny == shareRet.flag)
{
    NSLog(@"用户拒绝分享");
    }
}
```
###注意事项
 - 图片大小不能大于10M

---

##分享URL到微信
 - ###概述
与WGSendToWeixin功能相同，添加分享URL的参数，并能分享至朋友圈。
```ruby
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
```
>描述: 分享App消息到微信好友, 点击此分享详细能唤起游戏。此类消息不能分享到朋友圈，分享到朋友圈使用WGSendToWeixinWithPhoto接口。
参数: 
  - scene 分享的场景
  - title 分享的标题
  - desc 分享的描述
  - url 分享的URL
  - mediaTagName 使用者自己设定一个值, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源.
  - thumbImgData 分享时展示的缩略图数据（不要超过32K）
  - thumbImgDataLen 分享时展示的缩略图的长度, 需要和thumbImgData匹配, 不能为空
  - messageExt 游戏分享传入此字段，微信中点击此分享会话唤起游戏MSDK会将此字段透传给游戏。需要微信5.1及以上版本。
  - 分享成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。Ret.flag表示不同的分享结果，具体见eFlag(附录A)

 - ###代码示例
调用代码示例：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
unsigned char* fOpenid = (unsigned char*)"xxx";
unsigned char* title = (unsigned char*)"xxx";
unsigned char* content = (unsigned char*)"xxx";
TypeInfoImage info("xxx.png", 140, 140); 
WXMessageTypeInfo *pInfo = &info;
ButtonApp button("launch", "messageExt");
WXMessageButton *pButton = &button;
plat->WGSendMessageToWechatGameCenter(
		fOpenid, 
		title, 
		content, 
		pInfo, 
		pButton,
		(unsigned char*)"xxx"
);
```
回调代码事例：
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    shareRet.extInfo = “xxx”;//游戏分享是传入的extMsdkInfo字段
    if (eFlag_Succ == shareRet.flag)
{
    NSLog(@"分享成功");
}
     else if(eFlag_WX_NotInstall == shareRet.flag)
{
    NSLog(@"微信未安装");
    }
 else if(eFlag_WX_UserCancel == shareRet.flag)
{
    NSLog(@"用户取消分享");
    }
    else if(eFlag_WX_UserDeny == shareRet.flag)
{
    NSLog(@"用户拒绝分享");
    }
}
```
###注意事项
 - 需要微信5.2版本以上支持

---

## 微信刷新accesstoken
- 概述
微信accessToken只有两个小时的有效期，refreshToken的有效期为30天。只要refreshToken不过期就可以通过refreshToken刷新accessToken。刷新后会得到新的accessToken和refreshToken。每个refreshToken只能用一次。
WGRefreshWXToken()接口对应与MSDK server的/auth/wxexpired_login/ 服务。如果游戏使用WGRefreshWXToken()刷新微信accessToken就不要再调用MSDK server的/auth/wxexpired_login/重复刷新accessToken。建议游戏使用WGRefreshWXToken()接口来进行accessToken续期，游戏不需要保存票据，只需要通过WGGetLoginRecord(loginRet ret)获取票据即可。[1.7.0]
```ruby
void WGRefreshWXToken();
```
>描述:　微信accessToken续期，调用WGGetLoginRecord（LoginRet ret），ret.flag 为eFlag_WX_AccessTokenExpired时调用此接口，刷新微信票据。
刷新结果通过OnLoginNotify(LoginRet ret)回调给游戏。
ret.flag = eFlag_WX_RefreshTokenSucc   刷新token成功
ret.flag = eFlag_WX_RefreshTokenFail    刷新token失败

- 示例代码
调用代码示例：
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
plat->WGRefreshWXToken()
```
回调代码示例：
```ruby
void MyObserver::OnLoginNotify(LoginRet& loginRet)
{
if(eFlag_WX_RefreshTokenSucc == loginRet.flag)
{
    …//refresh success
    std::string openId = loginRet.open_id;
    std::string refreshToken;
    std::string accessToken;
    for(int i=0;i< loginRet.token.size();i++)
    {
        TokenRet* pToken = & loginRet.token[i];
        if(eToken_WX_Access == pToken->type)
        {
            accessToken = pToken->value;
        }
        else if (eToken_WX_Refresh == pToken->type)
{
refreshToken = pToken->value;
}
     }
}
else
{
    …//login fail
     NSLog(@"flag=%d,desc=%s",loginRet.flag,loginRet.desc.c_str()); 
}
}
```
###注意事项
- 刷新回调flag为eFlag_WX_RefreshTokenSucc和eFlag_WX_RefreshTokenFail
- 每个refreshToken只能用与一次刷新即过期

---

##微信各版本支持功能情况如下：
- ###微信功能对应支持版本

|功能	|说明|	微信版本|
|---|---|---|
|授权|	|	4.0以上|
|定向分享|	好友分享到好友|	4.0以上|
|大图分享|	分享图片（WGSendToWeixinWithPhoto接口|	4.0以上|
|朋友圈分享|	分享到朋友圈|	4.2以上|
|异帐号提示|	微信登录帐号通知MSDK|	5.0以上|
|朋友圈跳转|	朋友圈消息多出一个按钮，可以跳转到排行榜，游戏详情页或直接唤起游戏|	5.1以上|
音乐分享
=== 

##概述
 - 该功能在1.7.0版本以后提供，提供了分享到微信和手Q的接口。

---

## 接口说明
 - 调用WGShowNotice将使用MSDK配置的一套界面显示当前有效的公告，调用
```ruby
void WGSendToQQWithMusic(const int& scene,
                             unsigned char* title,
                             unsigned char* desc,
                             unsigned char* musicUrl,
                             unsigned char* musicDataUrl,
                             unsigned char* imgUrl);
```
>描述: 分享消息到手Q回话或Qzone, url填游戏手Q游戏中心详情页, 点击消息则会在手Q中播放音乐。
参数:
  - scene 标识分享到空间还是会话
0：唤起手Q并默认弹出分享到空间的弹框
1：唤起手Q，只能分享到好友
  - title 分享标题
  - desc 分享的具体描述
  - musicUrl 音乐内容的跳转url，可填游戏对应游戏中心详情页&游戏自定义字段。在手Q中点击此会话MSDK会将游戏自定义参数通过OnWakeupNotify(WakeupRet ret) ret.extInfo透传给游戏。如果游戏不需要透传参数，则直接填游戏中心详情页即可。自定义字段透传需要手Q4.6及以上版本支持。
 例如：游戏中心详情页为“AAAAA”,游戏自定义字段为“bbbbb”，则url为：AAAAA&bbbbb。bbbbb通过wakeupRet.extInfo返回给游戏。
  - musicDataUrl 这个参数使音乐分享的消息可以点击播放按钮可以直接播放，如下图的播放按钮。格式一般要求是http://***.mp4
![Alt text](./ShareMusic1.png)
  - imgUrl  iOS下可以是本地路径(格式是[NSData dataWithContentsOfFile:path]要求的)；也可以是预览图URL（http:// ***）。实际测试中发现iOS的手Q组件是先获取到URL图片数据后，再拉起手Q APPAPP。如果网络慢，实际体验可能比较差，此时注意界面作相应的配合.
       Android下只能是预览图URL。
分享成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。ret.flag表示不同的分享结果，具体见eFlag(附录A)

 - 
```ruby
void WGSendToWeixinWithMusic(const int &scene,
                                 unsigned char* title,
                                 unsigned char* desc,
                                 unsigned char* musicUrl,
                                 unsigned char* musicDataUrl,
                                 unsigned char *mediaTagName,
                                 unsigned char *imgData,
                                 const int &imgDataLen,
                                 unsigned char *messageExt,
                                 unsigned char *messageAction);
```
>描述: 分享App音乐消息到微信好友, 点击此分享可以在微信中播放音乐。
参数: 
  - scene 标识分享到朋友圈还是会话
0：唤起微信，只能分享到好友
1：唤起微信并默认弹出分享到朋友圈的弹框
  - title 分享的标题
  - desc 分享的描述
  - musicUrl 音乐内容的跳转url
  - musicDataUrl 这个参数使音乐分享的消息可以点击播放按钮可以直接播放，如下图的播放按钮。格式一般要求是http://***.mp4
  - mediaTagName 使用者自己设定一个值, 此值会传到微信供统计用, 在分享返回时也会带回此值, 可以用于区分分享来源.
  - imgData分享时展示的缩略图数据（不要超过32K）
  - imgDataLen 分享时展示的缩略图的长度, 需要和thumbImgData匹配, 不能为空
  - messageExt 游戏分享传入此字段，微信中点击此分享会话唤起游戏MSDK会将此字段透传给游戏。需要微信5.1及以上版本。
  - messageAction 第一个参数scene为1的情况下才起作用，会在分享到朋友圈的消息中多一个按钮，点击按钮可以唤起游戏，跳转到排行榜或游戏主页。
     messageAction取值如下:
     WECHAT_SNS_JUMP_SHOWRANK       跳排行
     WECHAT_SNS_JUMP_URL            跳链接
     WECHAT_SNS_JUMP_APP           跳APP
分享成功或失败都会通过OnShareNotify(ShareRet ret)回调给游戏。Ret.flag表示不同的分享结果，具体见eFlag(附录A)

---

##示例代码
 - 分享音乐到微信调用代码示例：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
    NSString *path = [[QQViewController testResourcePath] stringByAppendingPathComponent:@"music.jpg"];//news.jpg
    NSData* data = [NSData dataWithContentsOfFile:path];
    plat->WGSendToWeixinWithMusic(1,                 
                                (unsigned char*)"测试音乐",  
                                (unsigned char*)"测试音乐分享",  
                                (unsigned char*)"http://y.qq.com/#type=song&mid=000cz9pr0xlAId",  
                                 (unsigned char*)"http://tsmusic24.tc.qq.com/M500000cz9pr0xlAId.mp3",      
                                NULL, 
                                 (unsigned char*)[data bytes], 
                                [data length], 
                               NULL, 
                               NULL);
```
 - 回调代码示例：
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
 - 分享音乐到手Q调用代码示例：
```ruby
NSString *path = [[QQViewController testResourcePath] stringByAppendingPathComponent:@"music.jpg"];        
    plat->WGSendToQQWithMusic(2,
                          (unsigned char*)"测试音乐",
                              (unsigned char*)"测试音乐分享",
                              (unsigned char*)"http://y.qq.com/#type=song&mid=000cz9pr0xlAId",
                              (unsigned char*)"http://tsmusic24.tc.qq.com/M500000cz9pr0xlAId.mp3",
                              (unsigned char*)[path UTF8String]); 
```
或
```ruby
    WGPlatform *plat = WGPlatform::GetInstance();        
    plat->WGSendToQQWithMusic(1, (unsigned char*)"测试音乐",
                              (unsigned char*)"测试音乐分享",
                              (unsigned char*)"http://y.qq.com/#type=song&mid=000cz9pr0xlAId",
                              (unsigned char*)"http://tsmusic24.tc.qq.com/M500000cz9pr0xlAId.mp3",                              (unsigned char*)"http://www.monsterworking.com/wp-content/uploads/music.jpg");
```
 - 回调代码示例：
```ruby
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
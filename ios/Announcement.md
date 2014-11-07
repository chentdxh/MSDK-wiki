公告
===

##概述
 - 该功能在1.6.1版本以后提供，公告提供了两种形式的接口。1.6.2版本公告处于测试阶段，不建议游戏使用，需要游戏在info中添加配置将公告功能关闭，需要使用公告功能则设置为YES。如下图：
![Alt text](./Announcement1.png)
 - 2.0.1i及以后版本支持公告数据定时拉取功能，需要在info中配置如下项：
![Alt text](./Announcement2.png)
---

##由MSDK展示界面的公告接口
 - 调用WGShowNotice将使用MSDK配置的一套界面显示当前有效的公告，调用WGHideScrollNotice隐藏展示的滚动公告。
```ruby
Void WGShowNotice (eMSG_NOTICETYPE type, unsigned char *scene);
```
>描述: 显示指定scene当前有效的公告。通过参数type的确定展示哪种公告，如下：
```
typedef enum _eMSG_NOTICETYPE
{
	//所有公告类型
eMSG_NOTICETYPE_ALL = 0,
//弹出提示公告
eMSG_NOTICETYPE_ALERT,
//滚动公告
    eMSG_NOTICETYPE_SCROLL,
}eMSG_NOTICETYPE;
```
参数: 
1、Type需要展示的公告类型
2、scene 公告场景ID，不能为空。这个参数和公告管理端的“公告栏”对应，只取制定公告栏有效的公告展示。
 - 
```ruby
void WGHideScrollNotice ();
```
>描述: 隐藏展示的滚动公告
注：公告的展示界面是通过plist定制的。目前有弹出提示公告有“白底、蓝底、黑底、自定义”四种模版，这些模版及对应的资源文件放在WGPlatformResources.bundle/AnnouncementResources下对应的子目录中。模版的元素和定义说明详见附录F。

---

##公告数据列表接口
```ruby
std::vector<NoticeInfo> WGGetNoticeData(eMSG_NOTICETYPE type,unsigned char *scene);
```
>描述: 显示指定scene当前有效的公告数据。通过参数type的确定展示哪种公告，如下：
```ruby
typedef enum _eMSG_NOTICETYPE
{
	//所有公告类型
eMSG_NOTICETYPE_ALL = 0,
//弹出提示公告
eMSG_NOTICETYPE_ALERT,
//滚动公告
    eMSG_NOTICETYPE_SCROLL,
}eMSG_NOTICETYPE;
```
参数: 
2、Type需要展示的公告类型
3、scene 公告场景ID，不能为空。这个参数和公告管理端的“公告栏”对应，只取制定公告栏有效的公告展示。
返回：
1、NoticeInfo的数组，NoticeInfo结构如下：
```ruby
typedef struct
{
    std::string msg_id; //公告id
    std::string open_id; //用户open_id
    std::string msg_content; //公告内容
    std::string msg_title; //公告标题
  std::string msg_url; //公告跳转链接
  eMSG_NOTICETYPE msg_type; //公告类型，eMSG_NOTICETYPE
  std::string msg_scene; //公告展示的场景，管理端后台配置
  std::string start_time; //公告有效期开始时间
  std::string end_time; //公告有效期结束时间
std::string content_url; //网页公告url
std::vector<PicInfo> picArray; //图片公告图片数据
}NoticeInfo; 
typedef struct
{
eMSDK_SCREENDIR screenDir;      //横竖屏   1：横屏 2：竖屏
    std::string picPath;    //图片本地路径
    std::string hashValue;  //图片hash值
}PicInfo; 
```

---

## 示例代码
 - 获取公告数据列表接口调用代码示例：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
std::vector<NoticeInfo> vec = plat->WGGetNoticeData(eMSG_NOTICETYPE_ALERT, (unsigned char *)[scene UTF8String]);
            for (int i = 0; i < vec.size(); i++) {
                NoticeInfo info = vec[i];
                NSLog(@"NoticeInfo msgID: %@\nNoticeInfo msgTitle:%@\nNoticeInfo msgContent:%@",
                [NSString stringWithUTF8String: info.msg_id.c_str()],
                [NSString stringWithUTF8String: info.msg_title.c_str()],
                [NSString stringWithUTF8String: info.msg_content.c_str()]);
            }
```
MSDK 内置浏览器相关模块
======
MSDK提供了内置浏览器的支持, 此内置Webview从安全性, 性能各方面优于系统内置Webview, 此Webview中提供了分享到QQ和微信的功能. 游戏需要在游戏内拉起Web页面时, 例如拉起营销活动页面, 论坛, 攻略等页面时. 接入内置浏览器需要完成两步。


#### MSDK内置浏览器展示效果

![webview](./webview_res/webview_1.png) ![webview](./webview_res/webview_2.png)

接入配置
------
**MSDK2.14.0a更新说明及配置：**
MSDK2.14.0a版本优化了内置浏览器UI，使其更为简洁美观，并增加了上下滑动隐藏上方导航栏、下方工具栏的效果(默认开启，可配置开关)。并在Useragent中增加MSDK标识(格式：MSDK/版本号)。
具体接入配置如下。

    <!-- TODO 浏览器相关 START -->
    <activity
        android:name="com.tencent.msdk.webview.JumpShareActivity"
        android:theme="@android:style/Theme.Translucent.NoTitleBar">
    </activity>

    <activity
        android:name="com.tencent.msdk.webview.WebViewActivity"
        android:process=":msdk_inner_webview"
        android:hardwareAccelerated="true"
        android:configChanges="orientation|screenSize|keyboardHidden|navigation|fontScale|locale"
        android:screenOrientation="unspecified"
        android:theme="@android:style/Theme.NoTitleBar"
        android:windowSoftInputMode="stateHidden|adjustResize" >

        <meta-data android:name="titlebar_hideable" android:value="true"/>
        <meta-data android:name="toolbar_portrait_hideable" android:value="true"/>
        <meta-data android:name="toolbar_landscape_hideable" android:value="true"/>

    </activity>
    <!-- TODO 浏览器相关 END -->

其中滑动隐藏开关为：
1) titlebar_hideable ：上方导航栏是否可滑动隐藏，true为可隐藏，false为不可隐藏。
2) toolbar_portrait_hideable ：竖屏时，下方工具栏是否可滑动隐藏，true为可隐藏，false不可隐藏。
2) toolbar_landscape_hideable ：横屏时，下方工具栏是否可滑动隐藏，true为可隐藏，false不可隐藏。

**MSDK2.7.0a至2.13.0a按如下配置:**

如果手机安装了QQ浏览器则使用的是QQ内置浏览器内核，而未安装的话则使用的是系统默认内置浏览器，存在内存泄露的可能，因此改为独立进程。
**`需要添加android:process=":msdk_inner_webview"，退出内置浏览器时会杀掉该进程，如果未设置该项，会杀掉游戏主进程，游戏会退出。`**

    <!-- TODO 浏览器相关 START -->
    <activity
        android:name="com.tencent.msdk.webview.JumpShareActivity"
        android:theme="@android:style/Theme.Translucent.NoTitleBar">
    </activity>

    <activity
        android:name="com.tencent.msdk.webview.WebViewActivity"
        android:process=":msdk_inner_webview"
        android:hardwareAccelerated="true"
        android:configChanges="orientation|screenSize|keyboardHidden|navigation|fontScale|locale"
        android:screenOrientation="unspecified"
        android:theme="@android:style/Theme.Translucent.NoTitleBar"
        android:windowSoftInputMode="adjustPan" >
    </activity>
    <!-- TODO 浏览器相关 END -->

**MSDK2.0.0a(含)至MSDK2.7.0a（不含）按如下方式配置:**

    <activity
       android:name="com.tencent.msdk.webview.WebViewActivity"
       android:configChanges="orientation|screenSize|keyboardHidden|navigation|fontScale|locale"
       android:theme="@android:style/Theme.NoTitleBar"
       android:screenOrientation="unspecified"
       android:windowSoftInputMode="adjustPan">
    </activity>

**MSDK2.0.0a以前按如下方式配置:**

    <activity
       android:name="com.tencent.mtt.spcialcall.SpecialCallActivity"
       android:configChanges="orientation|keyboardHidden|navigation|fontScale|locale|screenSize"
       android:screenOrientation="unspecified"
       android:theme="@style/ThrdCallActivity"
       android:exported="false"
       android:windowSoftInputMode="adjustPan" >
    <intent-filter>
       <action android:name="com.tencent.QQBrowser.action.VIEWLITE" />
       <category android:name="android.intent.category.DEFAULT" />
       <category android:name="android.intent.category.BROWSABLE" />
       <data android:scheme="http" />
       <data android:scheme="https" />
       <data android:scheme="file" />
    </intent-filter>
    </activity>

如果需要内置浏览器始终保持横屏，则将`android:screenOrientation="unspecified"`改成如下：
`android:screenOrientation="landscape"`

如果需要内置浏览器始终保持竖屏，则将`android:screenOrientation="unspecified"`改成如下：
`android:screenOrientation="portrait"`

**注意：**
WebViewActivity 需要添加 `android:hardwareAccelerated="true"` 配置开启硬件加速，否则部分机器可能在播放视频时有声音无画面。

如果是升级到2.0.0a版本的，可删除2.0.0a以前的配置再添加新的配置。

打开浏览器
------
调用WGOpenUrl接口传入URL即可使用SDK提供的Webview, WGOpenUrl接口说明如下:

    /**
      *打开内置浏览器,此内置Webview从安全性, 性能各方面优于系统内置Webview, 如果手机上安装了QQ浏览器则会使用QQ浏览器的内核, 性能更优. 同时还提供了在内置浏览器中分享到QQ和微信的功能.
      *@param openUrl 要打开的url
      */
    void WGOpenUrl(unsigned char * openUrl);

调用示例代码如下:

    WGPlatform::GetInstance()->WGOpenUrl(cOpenUrl);

指定屏幕方向打开浏览器
------
调用WGOpenUrl接口传入URL即可使用SDK提供的Webview, WGOpenUrl接口说明如下:

	/**
      *打开内置浏览器,此内置Webview从安全性, 性能各方面优于系统内置Webview, 如果手机上安装了QQ浏览器则会使用QQ浏览器的内核, 性能更优. 同时还提供了在内置浏览器中分享到QQ和微信的功能.
      *@param openUrl 要打开的url
      *@param screendir 横屏还是竖屏打开浏览器 eMSDK_SCREENDIR_SENSOR 自动感应 eMSDK_SCREENDIR_PORTRAIT 竖屏 eMSDK_SCREENDIR_LANDSCAPE 横屏
      */
    void WGOpenUrl(unsigned char * openUrl,eMSDK_SCREENDIR &screendir);

调用示例代码如下:

    WGPlatform::GetInstance()->WGOpenUrl(cOpenUrl,eMSDK_SCREENDIR_LANDSCAPE);

透传参数说明
------
###1、加密传输登录态
如果游戏登录，通过内置浏览器访问网页时会携带加密后的登录态参数。具体是这么做的：

1.MSDK加密这些参数，传递到页面；

2.页面获取密文后调MSDK后台解密接口获得明文；

3.通过明文中的Token做登录验证。

![webview](./webview_res/webview_3.png)

###2、被加密的数据
要加密的登录态参数如下表：

| 参数名  | 参数说明  |
| ------------- |:-------------:|
| acctype| 账号类型，取值为qq或wx |
| appid| 游戏ID |  
| openId | 用户授权后平台返回的唯一标识|  
| access_token| 用户授权票据 |
| platid| 终端类型，取值为0表示ios，1表示android |




MSDK会在URL后附加的参数如下，__请勿传入重复的参数，会导致解密失败：

| 参数名  |         参数说明  |  
| ------------- |:-------------:|
| timestamp| 请求的时间戳 |
| appid| 游戏ID |
| algorithm | 加密算法标识，值为v1或者v2 |
| msdkEncodeParam | 密文 |
| version | MSDK版本号，例如：1.6.2a |
| sig | 请求本身签名 |
| encode | 编码参数，如2 |
| openid | 用户授权后平台返回的惟一标识 |

#### **注意**
encode参考在2.8.1a之前为1，建议使用拉起浏览器时带入url的参数，而不是硬编码。

###3、举例说明
假设浏览器拉起URL：http://apps.game.qq.com/ams/gac/index.html， 实际截包会看到访问的URL如下：

`http://apps.game.qq.com/ams/gac/index.html?sig=***&timestamp=**&appid=***&openid=***&algorithm=v1&msdkEncodeParam=***&version=1.6.2i&encode=2`

其中msdkEncodeParam 传输的实际上是下面参数加密得到的密文（url encode）：

`acctype=weixin&appid=100732256&openid=ol7d0jsVhIm3BQwlNG9g2f4puyUg&access_token=OezXcEiiBSKSxW0eoylIeCKi7qrm-
vXrr62qKiSw2otDBgCzzKZZfeBOSv9fplYsIPD844sNIDeZgG3IyarYcGCNe8XuYKHncialLBq0qj9-rVGhoQVkgSYJ8KXr9Rmh8IvdqK3zsXryo37sMJAa9Q&platid=0`



加解密登录态
------
###1、如何解密
业务页面获得上述URL，组装请求调用MSDK解密接口。目前解密接口有两种传参方案，业务后台需根据algorithm参数实现并兼容两种加密参数传输方案：

1、在MSDK1.8.1a及之后，加密传参的方案为：（下面URL访问的是MSDK测试环境）

`http://msdktest.qq.com/comm/decrypv1/?sig=***&timestamp=**&appid=***&openid=***&algorithm=v2&version=1.8.1i&encode=2`

直接将第一步中得到msdkEncodeParam 里的密文值以Post方式，放在body以Post方式传输，注意不需要加key“msdkEncodeParam=”。

2、MSDK1.8.1a之前，加密传参方案如下：（该方案终端已不再使用，但后台需实现以兼容老版本）

`http://msdktest.qq.com/comm/decrypv1/?sig=***&timestamp=**&appid=***&openid=***&algorithm=v1&version=1.6.2i&encode=2`

将msdkEncodeParam 里的密文URL Decode，放在body以Post方式传输，注意不需要加key“msdkEncodeParam=”。截包如下：

3、Fiddler解密示例

3.1 假设浏览器拉起URL：www.qq.com，实际截包会看到访问的URL如下：

    http://www.qq.com?algorithm=v2&version=2.0.6a&timestamp=1423538227203&appid=100703379&sig=427291da31b56b59739be6da61d433ec&encode=2&msdkEncodeParam=BAD8B1625CB04523B06AAF6739ACB3CEA96F54393831AF5C6890E92EE61CF1A29F493710592DD84B47D4217BA9FA9DAFB8025CEB27E45EC958689A794E8BD33CF2544CC5D00FCE03AEF7B23EE2BFCA4332F5D69547477A3E93E44F3270F19664D5499CA2990BE5BA9E232036197B184F1411B76CF95537AC07E3D6A27F054AD3F26648B18554F9C1

3.2 用Fiddler简易测试下，则需要拼装的url为：

    http://msdktest.qq.com/comm/decrypv1/?sig=427291da31b56b59739be6da61d433ec&timestamp=1423538227203&appid=100703379&algorithm=v2&version=2.0.6a&encode=2

   其中Post body为：

    BAD8B1625CB04523B06AAF6739ACB3CEA96F54393831AF5C6890E92EE61CF1A29F493710592DD84B47D4217BA9FA9DAFB8025CEB27E45EC958689A794E8BD33CF2544CC5D00FCE03AEF7B23EE2BFCA4332F5D69547477A3E93E44F3270F19664D5499CA2990BE5BA9E232036197B184F1411B76CF95537AC07E3D6A27F054AD3F26648B18554F9C1

3.3 在Fiddler上调试：

![webview](./webview_extend_3.png)

执行的结果为：

    acctype=qq&appid=100703379&openid=4FC5813635C21D7C0A64729E4E2D3041&access_token=B85D2A1D7DB1B564CADE7116BF70AD0D&platid=1

PS：正式环境请使用http://msdk.qq.com/comm/decrypv1/。

###2、密文解码代码示例（php版本）
![webview](./webview_res/webview_5.png)
![webview](./webview_res/webview_6.png)
###3、密文解码代码示例（C代码）
1、引入下面文件UrlCoding.h：

    #ifndef URL_H
    #define URL_H

    #ifdef __cplusplus
       extern "C" {
          #endif

          int php_url_decode(const char *str, int len, char *out, int *outLen);
          char *php_url_encode(char const *s, int len, int *new_length);
          int php_url_decode_special(const char *str, int len, char *out, int *outLen);

          #ifdef __cplusplus
       }
    #endif

    #endif /* URL_H */

2、引入下面文件UrlCoding.c：

    #include <stdlib.h>
    #include <string.h>
    #include <ctype.h>
    #include <sys/types.h>
    #include <stdio.h>
    #include "UrlCoding.h"

    static unsigned char hexchars[] = "0123456789ABCDEF";

    static int php_htoi(const char *s)
    {
        int value;
        int c;

        c = ((unsigned char *)s)[0];
        if (isupper(c))
            c = tolower(c);
        value = (c >= '0' && c <= '9' ? c - '0' : c - 'a' + 10) * 16;

        c = ((unsigned char *)s)[1];
        if (isupper(c))
            c = tolower(c);
        value += c >= '0' && c <= '9' ? c - '0' : c - 'a' + 10;

        return (value);
    }


    char *php_url_encode(char const *s, int len, int *new_length)
    {
        register unsigned char c;
        unsigned char *to, *start;
        unsigned char const *from, *end;

        from = (unsigned char *)s;
        end  = (unsigned char *)s + len;
        start = to = (unsigned char *) calloc(1, 3*len+1);

        while (from < end)
        {
            c = *from++;

            if (c == ' ')
            {
                *to++ = '+';
            }
            else if ((c < '0' && c != '-' && c != '.') ||
                     (c < 'A' && c > '9') ||
                     (c > 'Z' && c < 'a' && c != '_') ||
                     (c > 'z'))
            {
                to[0] = '%';
                to[1] = hexchars[c >> 4];
                to[2] = hexchars[c & 15];
                to += 3;
            }
            else
            {
                *to++ = c;
            }
        }
        *to = 0;
        if (new_length)
        {
            *new_length = to - start;
        }
        return (char *) start;
    }


    int php_url_decode(const char *str, int len, char *out, int *outLen)
    {
        const char *data = str;
        char *orgOut = out;
        while (len--)
        {
            if (*data == '+')
            {
                *out = ' ';
            }
            else if (*data == '%' && len >= 2 && isxdigit((int) *(data + 1)) && isxdigit((int) *(data + 2)))
            {
                *out = (char) php_htoi(data + 1);
                data += 2;
                len -= 2;
            }
            else
            {
                *out = *data;
            }
            data++;
            out++;
        }
    //  *out = '/0';
        *outLen = out - orgOut;
        return *outLen;
    }

    //专门为WGCommonMethods.h里的encodeForURL实现的解码方法  haywoodfu 2014-04-23
    int php_url_decode_special(const char *str, int len, char *out, int *outLen)
    {
        const char *data = str;
        char *orgOut = out;
        while (len--)
        {
            if (*data == '+')
            {
                *out = ' ';
            }
            else if (*data == '%' && len >= 2 && isxdigit((int) *(data + 1)) && isxdigit((int) *(data + 2)))
            {
                int value = 0;
                sscanf((data+1), "%2x", &value);
                *out = (char) value;
                data += 2;
                len -= 2;
            }
            else
            {
                *out = *data;
            }
            data++;
            out++;
        }
    //  *out = '/0';
        *outLen = out - orgOut;
        return *outLen;
    }

3、将传入的字符串encodeParam先后用php_url_decode和php_url_decode_special解码，得到的就是密文

![webview](./webview_res/webview_7.png)


Javascript接口概述
---

2.10.0a及以后版本的内置浏览器增加了对 Javascript 接口的支持。目前 Android 版 MSDK 提供了 Javascript 分享接口，关闭内置浏览器接口；iOS 版除此外，还可以通过JS在浏览器中打开指定URL，打开iOS图库、相机获取照片（参考[iOS MSDK 内置浏览器](http://wiki.dev.4g.qq.com/v2/ZH_CN/ios/index.html#!InnerBrowser.md)）。

**注意:**
MSDK提供的js接口，`只能在MSDK内置浏览器中调用`，其他浏览调用无效。

Javascript封装层
---

    <script type="text/javascript" src="http://wiki.dev.4g.qq.com/v2/msdkJsAdapter.js"></script>

开发者需要将代码复制到需要调用 MSDK JS接口的网页以加载MSDK的js封装代码，同时此网页需要用 MSDK 内置浏览器打开。Android，iOS平台都可通过调用 `msdkShare(jsonData)` 完成分享，调用`msdkCloseWebview()`关闭浏览器；iOS 版本 MSDK 提供的额外接口可通过 `msdkiOSHandler` 调用，可参考 iOS 部分的文档和 [JSDemo 示例](http://wiki.dev.4g.qq.com/v2/msdkjs.html)。

Javascript分享接口
---

JS层使用统一的分享接口，分享类别和参数通过 json 格式的字符串指定，分享回调统一回调到在初始化MSDK时注册的原生接口 `OnShareNotify(ShareRet ret)`。目前支持手Q/微信平台除后端分享的所有分享接口，具体如下：

| 分享类型 | 分享位置 | 是否支持JS接口 | 调用接口  |
|: ----- :|: ----- :|: ----- :|: ----- :|
| QQ结构化消息分享    | 会话/空间     | 支持 | [WGSendToQQ](qq.md#结构化消息分享)            |
| 微信结构化消息分享  | 会话          | 支持 | [WGSendToWX](wechat.md#结构化消息分享)        |
| QQ音乐消息分享      | 会话/空间     | 支持 | [WGSendToQQWithMusic](qq.md#音乐消息分享)     |
| 微信音乐消息分享    | 会话/朋友圈   | 支持 | [WGSendToWXWithMusic](wechat.md#音乐消息分享) |
| QQ纯图分享          | 会话/空间     | 支持 | [WGSendToQQWithPhoto](qq.md#大图消息分享)     |
| 微信纯图分享        | 会话/朋友圈   | 支持 | [WGSendToWXWithPhoto](wechat.md#大图消息分享) |
| QQ后端分享          | QQ手公共号    | 否   | [WGSendToQQGameFriend](qq.md#后端分享)        |
| 微信后端分享        | 会话          | 否   | [WGSendToWXGameFriend](wechat.md#后端分享)    |
| 微信链接消息分享    | 会话/朋友圈   | 支持 | [WGSendToWeixinWithUrl](wechat.md#链接分享)   |

分享参数 **jsonData** 示例如下：

```javascript
var QQStructuredShare2zone='{"MsdkMethod":"WGSendToQQ","scene":"1","title":"QQ JS 结构化分享","desc":"from js share","url":"http://www.baidu.com"}'
```
参数 `MsdkMethod` 指定分享的类型，对应关系参照上表。后面几个参数的 key 参考对应分享的 C++ 接口声明的参数，json 的 value 统一使用字符串。分享参数的具体意义请点击表中对应的原生接口名查看。
需要`注意`的是，JS接口分享的图片(除音乐分享外)默认为当面网页内容的截图(不可更改)，因此原生接口声明的参数中关于图片的参数(如 imgUrl，imgUrlLen，thumbImageData等)不需要填写在 **jsonData**中。手Q/微信 的音乐分享则必须提供一个网络图片的Url为 key:**imgUrl** 的 value，以用此图片完成分享。

#### 接口声明

    /**
     * @param jsonData json格式的分享参数
     * 分享回调在平台层的 OnShareNotify
     */
    function msdkShare(jsonData)

#### 接口调用

下面是 Javascript 接口参数示例：

```
    // 分享数据, Android iOS 都通过接口 msdkShare 实现分享
    var QQStructuredShare2zone='{"MsdkMethod":"WGSendToQQ","scene":"1","title":"QQ JS 结构化分享","desc":"from js share","url":"http://www.baidu.com"}'
    var QQStructuredShare2friend='{"MsdkMethod":"WGSendToQQ","scene":"2","title":"QQ JS 结构化分享","desc":"from js share","url":"http://www.baidu.com"}'

    var QQMusicShare2zone='{"MsdkMethod":"WGSendToQQWithMusic","scene":"1","title":"QQ JS 音乐分享","desc":"from js share","musicUrl":"http://y.qq.com/i/song.html?songid=1135734&source=qq","musicDataUrl":"http://wekf.qq.com/cry.mp3","imgUrl":"http://imgcache.qq.com/music/photo/mid_album_300/g/l/002ma2S64Gjtgl.jpg"}';
    var QQMusicShare2friend='{"MsdkMethod":"WGSendToQQWithMusic","scene":"2","title":"QQ JS 音乐分享","desc":"from js share","musicUrl":"http://y.qq.com/i/song.html?songid=1135734&source=qq","musicDataUrl":"http://wekf.qq.com/cry.mp3","imgUrl":"http://imgcache.qq.com/music/photo/mid_album_300/g/l/002ma2S64Gjtgl.jpg"}';

    var QQPhotoShare2zone='{"MsdkMethod":"WGSendToQQWithPhoto","scene":"1"}';
    var QQPhotoShare2friend='{"MsdkMethod":"WGSendToQQWithPhoto","scene":"2"}';


    var WXStructuredShare='{"MsdkMethod":"WGSendToWeixin","title":"WX JS 结构化分享","desc":"from js share","mediaTagName":"MSG_INVITE","messageExt":"JS messageExt"}';

    var WXMusicShare2zone='{"MsdkMethod":"WGSendToWeixinWithMusic","scene":"1","title":"WX JS 音乐分享","desc":"from js share","musicUrl":"http://y.qq.com/i/song.html?songid=1135734&source=qq","musicDataUrl":"http://wekf.qq.com/cry.mp3","mediaTagName":"MSG_INVITE","messageExt":"JS messageExt","messageAction":"WECHAT_SNS_JUMP_APP"}';
    var WXMusicShare2friend='{"MsdkMethod":"WGSendToWeixinWithMusic","scene":"0","title":"WX JS 音乐分享","desc":"from js share","musicUrl":"http://y.qq.com/i/song.html?songid=1135734&source=qq","musicDataUrl":"http://wekf.qq.com/cry.mp3","mediaTagName":"MSG_INVITE","messageExt":"JS messageExt","messageAction":"WECHAT_SNS_JUMP_APP"}';

    var WXPhotoShare2zone='{"MsdkMethod":"WGSendToWeixinWithPhoto","scene":"1","mediaTagName":"MSG_INVITE","messageExt":"JS messageExt","messageAction":"WECHAT_SNS_JUMP_APP"}';
    var WXPhotoShare2friend='{"MsdkMethod":"WGSendToWeixinWithPhoto","scene":"0","mediaTagName":"MSG_INVITE","messageExt":"JS messageExt","messageAction":"WECHAT_SNS_JUMP_APP"}';

    var WXUrlShare2zone='{"MsdkMethod":"WGSendToWeiXinWithUrl","scene":"1","title":"WX JS 链接分享","desc":"from js share","url":"http://www.baidu.com","mediaTagName":"MSG_INVITE","messageExt":"js 自定义"}';
    var WXUrlShare2friend='{"MsdkMethod":"WGSendToWeiXinWithUrl","scene":"0","title":"WX JS 链接分享","desc":"from js share","url":"http://www.baidu.com","mediaTagName":"MSG_INVITE","messageExt":"js 自定义"}';
```

接口调用示例：


    <p><input type="button" value="QQ结构化消息分享To空间" onclick="msdkShare(QQStructuredShare2zone)" /></p>
    <p><input type="button" value="QQ结构化消息分享To会话" onclick="msdkShare(QQStructuredShare2friend)" /></p>

    <p><input type="button" value="微信音乐分享To朋友圈" onclick="msdkShare(WXMusicShare2zone)" /></p>
    <p><input type="button" value="微信音乐分享To会话" onclick="msdkShare(WXMusicShare2friend)" /></p>
    ......

Javascript关闭浏览器接口
---

#### 接口声明

    /**
     * 关闭MSDK内置浏览器
     */
    function msdkCloseWebview()

#### 接口调用

    ......
    <p><input type="button" value="关闭MSDK内置浏览器" onclick="msdkCloseWebview()" /></p>
    ......

**注意：**
使用MSDK Js接口前请先加载MSDK Js适配层：http://wiki.dev.4g.qq.com/v2/msdkJsAdapter.js

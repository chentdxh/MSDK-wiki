内置浏览器
===

##打开内置浏览器
 - ###概述
该功能在1.6.1版本以后提供，需要XCode5.0以上版本进行编译。

```
/**
 *  @param openUrl 要打开的url
 */
void WGOpenUrl(unsigned char * openUrl);
```
示例代码：
```
WGPlatform* plat = WGPlatform::GetInstance();
plat->WGOpenUrl((unsigned char*)[url UTF8String]);
```
---

##指定屏幕方向打开浏览器
 - ###概述
该功能在2.9.0版本以后提供，需要在plist中声明App所需的屏幕方向。

```
/**
 *  @param openUrl 要打开的url
 *  @param screenDir 内置浏览器支持的屏幕方向
 */
void WGOpenUrl(unsigned char * openUrl, eMSDK_SCREENDIR screenDir);
```
示例代码：
```
WGPlatform* plat = WGPlatform::GetInstance();
plat->WGOpenUrl((unsigned char*)[url UTF8String], eMSDK_SCREENDIR_LANDSCAPE);
```
---

##使用时的注意事项
 - 浏览器模块是通过xib定制界面的，这个xib放在WGPlatformResources.bundle/目录，xib使用的png等资源文件放在WGPlatformResources.bundle/WebViewResources目录。由于需要兼容iOS7.0，因此需要Xcode5.0及以上版本才能编辑。
 - 手Q分享限制URL长度在512字节之内，因此超长链接需要转成短链。
---

##配置导航栏可隐藏开关
 - ###概述
从MSDK2.14.0版本开始，各游戏可自行配置内置浏览器导航栏的滑动隐藏打开与关闭，横屏和竖屏可分开配置，默认均开启滑动隐藏，可在plist中配置如下Boolean的开关打开与关闭：

```
MSDK_Webview_Portrait_NavBar_Hideable //竖屏状态下可隐藏开关
MSDK_Webview_Landscape_NavBar_Hideable //横屏状态下可隐藏开关
```
竖屏不可隐藏横屏可隐藏示例：
![Alt text](./navBarHideAble.png)
---

##加密传输登录态参数
  - ### 整体方案
如果游戏登录，通过内置浏览器访问网页时会携带加密后的登录态参数。具体是这么做的：
1.MSDK加密这些参数，传递到页面；
2.页面获取密文后调MSDK后台解密接口获得明文；
3.通过明文中的Token做登录验证。

  - ### URL包含的参数
  - MSDK会在URL后附加的参数如下，请勿传入重复的参数，会导致解密失败：

|参数名|	说明	|值|
|--|--|--|
|timestamp|	请求的时间戳||	
|appid |	游戏ID|	　|
|algorithm|	加密算法标识|	v1|
|msdkEncodeParam|	密文|	　|
|version|	MSDK版本号|	例如1.6.2i|
|sig|	请求本身的签名|	|
|encode|	编码参数|	1(2.8.1及以后版本需传2，否则会导致解密失败)|
|openid|	用户授权后平台返回的唯一标识 | | 

 
  - ### 被加密的数据
  - 要加密的登录态参数如下表：

|参数名|	说明|	值|
|--|--|--|
|acctype |	帐号类型|	qq/wx|
|appid 	|游戏ID	　||
|openid |	用户授权后平台返回的唯一标识||
|access_token|	用户授权票据|	　|
|platid 	|终端类型|	0.iOS；1.Android|
 
    
   - 举例说明，假设内置浏览器拉起的URL为http://apps.game.qq.com/ams/gac/index.html，实际截包会看到访问的URL如下：
http://apps.game.qq.com/ams/gac/index.html?sig=***&timestamp=**&appid=***&openid=***&algorithm=v1&msdkEncodeParam=***&version=1.6.2i&encode=1 
   - 其中msdkEncodeParam 传输的实际上是下面参数加密得到的密文（url encode）：
acctype=weixin&appid=100732256&openid=ol7d0jsVhIm3BQwlNG9g2f4puyUg&access_token=OezXcEiiBSKSxW0eoylIeCKi7qrm-
vXrr62qKiSw2otDBgCzzKZZfeBOSv9fplYsIPD844sNIDeZgG3IyarYcGCNe8XuYKHncialLBq0qj9-rVGhoQVkgSYJ8KXr9Rmh8IvdqK3zsXryo37sMJAa9Q&platid=0

- ### 如何解密
- 业务页面获得上述URL，组装请求调用MSDK解密接口。目前解密接口有两种传参方案，业务后台需根据algorithm参数实现并兼容两种加密参数传输 - 方案：
- 在MSDK1.7.1i及之后，加密传参的方案为：（下面URL访问的是MSDK测试环境）
http://msdktest.qq.com/comm/decrypv1/?sig=***&timestamp=**&appid=***&openid=***&algorithm=v2&version=1.7.1i&encode=1
	直接将第一步中得到msdkEncodeParam 里的密文值以Post方式，放在body以Post方式传输，注意不需要加key“msdkEncodeParam=”。
- MSDK1.7.1i之前，加密传参方案如下：（该方案终端已不再使用，但后台需实现以兼容老版本）
http://msdktest.qq.com/comm/decrypv1/?sig=***&timestamp=**&appid=***&openid=***&algorithm=v1&version=1.6.2i&encode=1 
将msdkEncodeParam 里的密文URL Decode，放在body以Post方式传输，注意不需要加key“msdkEncodeParam=”。截包如下：
![Alt text](./InnerBrowser2.png)
- ###密文解码代码示例（php版本）
- 代码示例：
```
php
<?php
//var_dump($argv);
$getparam = urldecode($argv[1]);
$postparam = $argv[2];
$algorithm = $argv[3];
//$sUrl = "http://msdktest.qq.com/comm/decrypv1/?" . $getparam;
$sUrl = "http://msdktest.qq.com/comm/decrypv1/?" . $getparam;
//var_dump($sUrl);
//var_dump($postparam);
$curl  =  curl_init();
curl_setopt( $curl, CURLOPT_URL, $sUrl );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER,1 );
curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "POST" );
$str = $algorithm == "v2" ? $postparam : urldecode(urldecode($postparam));
curl_setopt( $curl, CURLOPT_POSTFIELDS, $str );
try{
	$data = curl_exec($curl);
} catch ( exception $e ){
	print $e->getMessage().$sUrl;
}
curl_close($curl);
print $data;
?>
```
- ###密文解码代码示例（C代码）：
1. 引入下面两个文件：

```
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
```

```
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
//	*out = '/0';
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
//	*out = '/0';
    *outLen = out - orgOut;
	return *outLen;
}
```

2. 将传入的字符串encodeParam先后用php_url_decode和php_url_decode_special解码，得到的就是密文
![Alt text](./InnerBrowser5.png)

---

##游戏自定义传输参数
游戏可以自行在url后加上key-value参数，作为url的补充信息，类似：http://***.com?key1=value1&key2=value2

---

## 判断App是否安装
- 网页中增加如下JS代码，即可在网页中判断是否安装了对应的App：
```
document.addEventListener('WebViewJavascriptBridgeReady', onBridgeReady, false)
function onBridgeReady(event) {
var bridge = event.bridge
bridge.init(function(message, responseCallback) {
var data = { 'Javascript Responds':'Wee!' }
responseCallback(data)
})
bridge.callHandler('getInstallState', {'packageName':'com.tencent.news','packageUrl' :'qqnews://can_open_me_if_install_and_regeister_this_scheme'
}, function(msg) {
if(msg.indexOf("get_install_state:yes") > -1) {
log("install :腾讯新闻");} 
else {
log("not install :腾讯新闻");
}
})
```

---

##应用内打开App Store详情页
（iOS6.0及以上）点击网页中的itunes链接（http://itunes.apple.com/cn/app/id439638720?mt=8），可以在应用内打开该应用的AppStore详情页。如图：

![Alt text](./InnerBrowser6.png)

---

##分享
点击“分享”按钮可将当前页面分享到朋友圈、QZone、微信好友、QQ好友。如下图，请注意手Q分享的URL最大限制在512个字节，如果URL比较长，请使用短链。

![Alt text](./InnerBrowser7.png)

---

##Javascript接口概述
2.7.0i及以后版本的内置浏览器增加了对Javascript接口的支持，目前iOS版MSDK相继提供了JS在Safiri中打开制定URL接口，打开相机、图库获取照片接口，JS分享接口以及关闭内置浏览器接口。

**注意：**
MSDK提供的js接口，只能在MSDK内置浏览器中调用，其他浏览调用无效。

---

##Javascript封装层

```
<script type="text/javascript" src="http://wiki.dev.4g.qq.com/v2/msdkJsAdapter.js"></script>
```

开发者需要将代码复制到需要调用MSDK JS接口的网页以加载MSDK的js封装代码，同时此网页需要用MSDK 内置浏览器打开。Android，iOS平台都可通过调用 `msdkShare(jsonData)` 完成分享，调用`msdkCloseWebview()`关闭浏览器；iOS版本MSDK提供的额外接口可通过 `msdkiOSHandler` 调用，可参考 iOS 部分的文档和 [JSDemo 示例](http://wiki.dev.4g.qq.com/v2/msdkjs.html)。

---

##通过JS在Safiri中打开指定URL
从MSDK2.7.0版本开始，游戏可在内置浏览器中通过JS方式打开Safiri浏览器并打开指定URL，参数需传递固定接口名称`OpenURLInSafiri`和可变参数data（即要打开的url地址），示例代码如下：

```
<p><input type="button" value="Open URL In Safiri" onclick="demoOpenInSafiri()" /></p>
function demoOpenInSafiri() {
	        var data = 'http://v.qq.com/iframe/player.html?vid=y0140id0vna&tiny=0&auto=0'
	        log('JS sending message', data)
	        msdkiOSHandler('OpenURLInSafiri', data, function(response) {
	                log('JS got response', response);
	            });
	    }
```

另：调用方式可参考[该网页](http://wiki.dev.4g.qq.com/v2/msdkjs.html)页面源码，使用时注意引入[封装层](InnerBrowser.md#Javascript封装层)。

---

##通过JS打开iOS图库、相机获取照片
从MSDK2.7.0版本开始，游戏可在内置浏览器中通过JS方式打开打开iOS图库、相机获取照片，参数需传递固定接口名称`OpenImagePickerController`，返回值为'{"message”:”xxx”,”base64String":“xxx”}'json格式串。其中message字段标识获取照片成功与否，值有'success'和'user cancel'。base64String字段为照片的Base64编码串，message为'success'时该字段有值，message为'user cancel'时该字段无值。示例代码如下：

```
<p><input type="button" value="Open ImagePickerController" onclick="demoOpenImagePicker()" /></p>
function demoOpenImagePicker() {
	        var data = 'OpenImagePickerController'
	        log('JS sending message', data)

	        msdkiOSHandler('OpenImagePickerController', data, function(response) {
	            /*
	             response为'{"message”:”xxx”,”base64String":“xxx”}'格式串。
	             其中message字段标识获取照片成功与否，值有'success'和'user cancel'。
	             base64String字段为照片的Base64编码串，message为'success'时该字段有值，message为'user cancel'时该字段无值。
	             */
	            var obj = JSON.parse(response);
	            log('JS got response', obj["message"]);
	        });
	    }
```

另：调用方式可参考[该网页](http://wiki.dev.4g.qq.com/v2/msdkjs.html)页面源码,使用时注意引入[封装层](InnerBrowser.md#Javascript封装层)。

---

##JS分享接口

从MSDK2.10.0i版本开始，游戏可在MSDK内置浏览器中通过JS方式调用 `msdkShare(jsonData)` 接口完成分享，无需指定平台，分享类别和参数通过 json 格式的字符串指定，分享回调统一回调到在初始化MSDK时注册的原生接口 `OnShareNotify(ShareRet ret)`。目前支持手Q/微信平台除后端分享的所有分享接口，具体如下：

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

```
var QQStructuredShare2zone='{"MsdkMethod":"WGSendToQQ","scene":"1","title":"QQ JS 结构化分享","desc":"from js share","url":"http://www.baidu.com"}'
```

参数 `MsdkMethod` 指定分享的类型，对应关系参照上表。后面几个参数的 key 参考对应分享的 C++ 接口声明的参数，json 的 value 统一使用字符串。分享参数的具体意义请点击表中对应的原生接口名查看。
需要`注意`的是，JS接口分享的图片(除音乐分享外)默认为当面网页内容的截图(不可更改)，因此原生接口声明的参数中关于图片的参数(如 imgUrl，imgUrlLen，thumbImageData等)不需要填写在 **jsonData**中。手Q/微信 的音乐分享则必须提供一个网络图片的Url为 key:**imgUrl** 的 value，以用此图片完成分享。

```
	/**
	* @param jsonData json格式的分享参数
	* 分享回调在平台层的 OnShareNotify
	*/
	function msdkShare(jsonData)
```

示例代码：

```
//分享数据, Android iOS 都通过接口 msdkShare 实现分享
var QQStructuredShare2zone='{"MsdkMethod":"WGSendToQQ","scene":"1","title":"QQ JS 结构化分享","desc":"from js share","url":"http://www.baidu.com"}'
<p><input type="button" value="QQ结构化消息分享To空间" onclick="msdkShare(QQStructuredShare2zone)" /></p>
......
```

具体Demo示例可参考[该网页](http://wiki.dev.4g.qq.com/v2/msdkjs.html)源码,使用时注意引入[封装层](InnerBrowser.md#Javascript封装层)。

---

##JS关闭内置浏览器
从MSDK2.14.0版本开始，游戏可在内置浏览器中通过JS方式调用 `msdkCloseWebview()` 接口关闭内置浏览器。

```
/**
 * 关闭MSDK内置浏览器
 */
function msdkCloseWebview()
```

调用示例：

```
<p><input type="button" value="关闭MSDK内置浏览器" onclick="msdkCloseWebview()" /></p>
```

具体Demo示例可参考[该网页](http://wiki.dev.4g.qq.com/v2/msdkjs.html)源码，使用时注意引入[封装层](InnerBrowser.md#Javascript封装层)。

---

##常见问题
部分游戏导入framework后会有找不到framework的情况，例如是无法打开内置浏览器，日志输出“no MSDKWebViewService exist”，此时需要在Other link flags增加“-ObjC “和 “-framework MSDKFoundation -framework MSDK -framework MSDKMarketing -framework MSDKXG”，导入相关framework。

---
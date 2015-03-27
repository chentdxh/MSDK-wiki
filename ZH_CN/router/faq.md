# FAQ #


1.打印结果时，提示” Request overly frequency”或者 “too many times”,表示请求的次数过多，后台服务规定每秒不能超过一次请求。

2.抛出异常 “msdk.qq.com连接失败 (0)”或者 “msdktest.qq.com链接失败(0)”，表示服务器无法解析msdk.qq.com 或者 msdktest.qq.com域名，请联系运维处理。

3.ret=-309或者 ret=-308 或者ret=-306,或者ret=-101表示微信平台返回超时或者断开链接引起的。对于该异常，msdk后台每天都会做统计并跟进处理。

4.“-73，internal error”表示用户修改了密码，导致token失效引起的。<br>

		场景		
		a.用户修改了密码，然后重新授权获得了新的token
		b.再用老的token去验证，就会出现这个错误
5.“-1，system error”表示微信平台处理数据异常引起的，我们会对这类错误做监控，并跟进处理。如果你能够必现，或者出现的次数较多，请与我们联系。

6.“-69,internal error”表示应用不在权限系统里，与我们反馈。

7.“100015，access token is revoked” 表示token已经被用户废弃掉了。

8./share/qq常见错误：
	
	A. {"msg":"100030,is_friend is 0","ret":-10000}  给非好友关系用户推送送心消息 错误。<br>
		　　
    B. {"msg":"30,null ServiceError: :workid=yaaf_mpqq_msgsendsvr cmdid=1 com.tencent.jungle.api.APIException: 	30,response errorCode error 30","ret":-10000}<br>
		表示每个用户的公共帐号的同一个游戏每天接收分享不能超过30条。<br>
		
	C. {"msg":"103,定向分享（手机端）好友 ServiceError: :workid=qconnshare cmdid=11 com.tencent.jungle.api.APIException: 103,response errorCode error 103","ret":-10000}
		　　参数过长，title 不能超过  45字节<br>
		　　
	D. {"msg":"32,null ServiceError: :workid=yaaf_mpqq_msgsendsvr cmdid=1 com.tencent.jungle.api.APIException: 32,response errorCode error 32","ret":-10000}
		取消关注分享公共帐号
		
	

9. 出现“100030,this api without user authorization  ”表示未授权。如<br>
    ![分享图片](./faq1.jpg)

10./auth/check_token微信token验证接口出现“40001,invalid credential”属正常现像，因为2小时过期，如果过期时调用该接口，则出现该错误码。

11./share/wx分享到微信接口不显示？

	　　每个用户在同一个 appid里面，每天最多只能接收5条请求。多了不能保证成功。

12./share/upload_wx接口上传图片模糊？

	　　urlencode 会将"空格"转变成“+”号。用rawurlencode即可。

13.微信和手Q加好友以后，多久可以在游戏中拉取到刚加的好友？

	微信是小时级别的。手Q是立即刷新的。



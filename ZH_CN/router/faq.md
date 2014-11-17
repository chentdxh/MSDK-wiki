# 5.FAQ #


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


# 6.MSDK错误信息注释 #

## 6.1 平台API错误注释 ##

### 6.1.1 手Q平台错误码注释 ###

http://wiki.open.qq.com/wiki/公共返回码说明#OpenAPI_V3.0_.E8.BF.94.E5.9B.9E.E7.A0.81

### 6.1.2 手Q平台错误码补充 ###
	APIGW_RTCODE_APPREQ_INVALID = -1, //client的请求参数无效
	APIGW_RTCODE_APP_NOTEXIST = -2, //请求中的appid不存在
	APIGW_RTCODE_APPAPI_NOPRIVI = -3, //client请求中app到api访问无权限
	APIGW_RTCODE_IP_INVALID = -4, //请求中的app ip不允许
	APIGW_RTCODE_SIG = -5, //签名验证失败
	APIGW_RTCODE_APPAPI_ISLIMITED = -6, //client请求中app到api访问超限
	APIGW_RTCODE_PROTOCAL_INVALID = -7, //请求协议非法 eg https 搞成了http
	APIGW_RTCODE_REQ_BLOCK = -8, //请求受限,通常是安全审计没通过
	APIGW_RTCODE_API_NOTEXIST = -9, //api不存在
	APIGW_RTCODE_SENSI_INNER_IP_INVALID = -10, //请求中的app 内网ip不允许
	APIGW_RTCODE_SENSI_OUTER_IP_INVALID = -11, //请求中的app 外网ip不允许
	APIGW_RTCODE_CHECK_DEV_USER = -12, //测试环境调试号码受限
	APIGW_RTCODE_USERAPI_NOPRIVI = -20, //client请求中api未经用户授权
	APIGW_RTCODE_ACCESS_TOKEN_DISCARD= -21, //access_token已废除
	APIGW_RTCODE_INVALID_OPENID = -22, //openid非法
	APIGW_RTCODE_INVALID_OPENKEY= -23, //openkey非法
	APIGW_RTCODE_INVALID_OPENID_OPENKEY= -24,//openid openkey验证失败
	APIGW_RTCODE_OAUTH_TIMESTAMP= -25,//0x71f 0x5b: timestamp与系统当前时间相差超过10分钟
	APIGW_RTCODE_OAUTH_NONCE= -26,//0x71f 0x5a: 重复的nonce
	APIGW_RTCODE_LOGIN_INVALID_APPID = -70, //登录验证返回，验证openkey时appid非法
	APIGW_RTCODE_OPENID_OPENKEY_NOTMATCH = -71, //openid和openkey不匹配
	APIGW_RTCODE_INVALID_APPKEY = -72, //appkey和权限tmem中的appkey不一致
	APIGW_RTCODE_INVALID_ACCESSTOKEN_MODIFY_SIG = -73, //0x47 access token改密失效

### 6.1.3 微信平台错误码注释 ###

| 宏定义| 错误码|描述|推荐处理|
| ------------- |:-------------:|:-----|:------|
|API_Api_Unauthorized|48001|api unauthorized|重新拉起授权                |
|API_Empty_Post_data|44002|empty post data|-                             |
|API_Error_Format|47001|data format error|-                              |
|API_ERR_SYS|-1|system error|重试一次                                    |
|API_Expired_Access_token|42001|access_token expired|请调用 refresh token|
|API_Expired_Oauth_code|42003|code expired|重新拉起授权                  |
|API_Expired_Refresh_token|42004|refresh_token expired|重新拉起授权      |
|API_Invalid_appid|40013|invalid appid|-                                 |
|API_Invalid_Credential|40001|invalid credential|重新拉起授权            |
|API_Invalid_Grant_type|40002|invalid grant_type|重新拉起授权            |
|API_Invalid_Media_id|40007|invalid media_id|-                           |
|API_Invalid_Msg_type|40008|invalid message type|-                       |
|API_Invalid_Oauth_code|40029|invalid code|重新拉起授权                  |
|API_Invalid_openid|40003|invalid openid|重新拉起授权                    |
|API_Invalid_openid_list|40031|invalid openid list|重新拉起授权          |
|API_Invalid_Refresh_token|40032|invalid refresh_token|重新拉起授权      |
|API_Invalid_Template_id|40037|invalid template_id|-                     |
|API_Invalid_Template_id_size|40036|invalid template_id size|-           |
|API_Limit|45011|api limit|-                                             |
|API_Limit_Freq|45009|api freq out of limit|-                            |
|API_Limit_Template_args_count|45013|too many template args|-            |
|API_Limit_Template_msg_size|45014|template message size out of limit|-  |
|API_Missing_Access_token|41001|access_token missing|重新拉起授权        |
|API_Missing_appid|41002|appid missing|-                                 |
|API_Missing_Appsecret|41004|appsecret missing|-                         |
|API_Missing_Oauth_code|41008|missing code|-                             |
|API_Missing_openid|41009|missing openid|-                               |
|API_Missing_Refresh_token|41003|refresh_token missing|-                 |
|API_OK|0|ok|-                                                           |
|API_Require_Friend|43005|require friend relations|-                     |
|API_Require_Https|43003|require https|-                                 |
|API_Require_Subscribe|43004|require subscribe|-                         |


### 6.1.4 MSDK错误注释 ###

返回值0是成功,<0失败


| 宏定义| 错误码|描述|
| ------------- |:-------------:|:-----|
|#define SDK_SUCCESS                 |0                      | //成功                                                      |
|#define SDK_QUERY_EMPTY             |1                      | //查询结果为空，没数据                                      |
|#define SDK_ERR_SYSTEM              |-100                   | //-100到-999为系统级错误                                    |
|#define SDK_ERR_SYSTEM_INTENAL      |SDK_ERR_SYSTEM - 1     | //spp框架内部异常                                           |
|#define SDK_ERR_SYSTEM_OVERLOAD     |SDK_ERR_SYSTEM - 2     | //系统过载                                                  |
|#define SDK_ERR_SYSTEM_OIDB         |SDK_ERR_SYSTEM - 3     | //oidb异常                                                  |
|#define SDK_ERR_SYSTEM_CMEM         |SDK_ERR_SYSTEM - 4     | //cmem错误                                                  |
|#define SDK_ERR_SYSTEM_JCE_ENCODE   |SDK_ERR_SYSTEM - 5     | //JCE编码异常                                               |
|#define SDK_ERR_SYSTEM_JCE_DECODE   |SDK_ERR_SYSTEM - 6     | //JCE解码异常                                               |
|#define SDK_ERR_API                 |-1000                  | //-1000到-1999为客户端返回的错误                            |
|#define SDK_ERR_RSP_LEN             |SDK_ERR_API - 1        | //未接收到完整消息包                                        |
|#define SDK_ERR_RSP_CMD             |SDK_ERR_API - 2        | //回包包头cmd错误，传入buf的起始位置可能不是消息头的起始位置|
|#define SDK_ERR_RSP_NOBODY          |SDK_ERR_API - 3        | //回包缺少包体                                              |
|#define SDK_ERR_JCE_ENCODE          |SDK_ERR_API - 4        | //JCE编码异常                                               |
|#define SDK_ERR_JCE_DECODE          |SDK_ERR_API - 5        | //JCE解码异常                                               |
|#define SDK_ERR_BUFFER_SIZE         |SDK_ERR_API - 6        | //输入输出Buffer大小不足                                    |
|#define SDK_ERR_ADDRESS             |SDK_ERR_API - 7        | //未配置后台目标IP和端口                                    |
|#define SDK_ERR_SOCKET              |SDK_ERR_API - 8        | //TCP通信错误，查看errno                                    |
|#define SDK_ERR_SEQ                 |SDK_ERR_API - 9        | //seq不匹配                                                 |
|#define SDK_ERR_NULLPT              |SDK_ERR_API - 10       | //空指针错误                                                |
|#define SDK_ERR_SERVER              |-2000                  | //-2000~-9999以下为服务器返回的错误                         |
|#define SDK_ERR_SERVER_UNPACK       |SDK_ERR_SERVER - 1     | //消息解析失败                                              |
|#define SDK_ERR_SERVER_VER          |SDK_ERR_SERVER - 2     | //协议版本不匹配                                            |
|#define SDK_ERR_SERVER_CMD          |SDK_ERR_SERVER - 3     | //命令不存在                                                |
|#define SDK_ERR_SERVER_RSP_PACKAGE  |SDK_ERR_SERVER - 4     | //http 响应包错误                                           |
|#define SDK_ERR_SERVER_EMPTY_BODY   |SDK_ERR_SERVER - 5     | //http empty body                                           |
|#define SDK_ERR_SERVER_JSON         |SDK_ERR_SERVER - 6     | //json响应包解析失败                                        |
|#define SDK_ERR_SERVER_RET          |SDK_ERR_SERVER - 7     | //响应包返回值为空                                          |
|#define SDK_ERR_SERVER_ST_DECRYPT   |SDK_ERR_SERVER - 8     | //ST解码失败                                                |
|#define SDK_ERR_SERVER_A8_DECRYPT   |SDK_ERR_SERVER - 9     | //A8解码失败                                                |
|#define SDK_ERROR_SERVER_CONFIG     |SDK_ERR_SERVER - 10    | //配置文件没有该配置或配置错误                              |
|#define SDK_ERR_BIZ                 |-10000                 | //-10000以上为业务本身的错误                                |
|#define SDK_ERR_BIZ_INVALID_UIN     |SDK_ERR_BIZ - 1        | //非法的qq号                                                |
|#define SDK_ERR_BIZ_INVALID_OPENID  |SDK_ERR_BIZ - 2        | //非法的openid                                              |
|#define SDK_ERR_BIZ_LOGIN_TYPE      |SDK_ERR_BIZ - 3        | //错误的登录方式                                            |
|#define SDK_ERR_BIZ_INTENAL         |SDK_ERR_BIZ - 5        | //内部异常                                                  |

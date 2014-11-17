# 4.游客模式

## 4.1 auth服务

　　实现游客模式下授权登录相关功能

### 4.1.1 /auth/guest_check_token 


#### 4.1.1.1 接口说明 

　　游客模式下面，调用该接口鉴权。

#### 4.1.1.2输入参数说明 

| 参数名称| 类型|描述|
| ------------- |:-------------|:-----|
| guestid|string| 游客的唯一标识.手Q的appid前面加上”G_”(.注意：个别游戏只接入了微信，则使用微信的appid。例如：G_wx***,注册的时候用哪个appid，则后面调用游客模式接口的时候，就用该appid)。|
| accessToken|string|用户的登录凭证 |

#### 4.1.1.3输出参数说明 

| 参数名称| 描述|
| ------------- |:-----|
| ret|返回码  0：正确，其它：失败 |
| msg|ret非0，则表示“错误码，错误提示”，详细注释参见第5节|

#### 4.1.1.4 接口调用说明 
|名称|描述|
| ------------- |:-----|
| URL|http://msdktest.qq.com/ auth/guest_check_token/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 格式|JSON |
| 请求方式|POST  |

#### 4.1.1.5 请求示例 

	POST /auth/guest_check_token/?timestamp=&appid=G_**&sig=***&openid=G_**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJPLafWudG-idTVMbKesBkhBO_ZxFWN4zlXCpCHpYcrXNG6Vs-cocorhdT5Czj_23QF6D1qH8MCldg0BSMdEUnsaWcFH083zgWJcl_goeBUSQ",
	     guestid": "G_oGRTijiaT-XrbyXKozckdNHFgPyc"
	}
	
	//返回结果
	{
	    "ret": 0,
	    "msg": "ok"
	}


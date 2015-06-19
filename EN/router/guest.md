# 4.Guest mode

## 4.1 auth services

　　Realize the authorized login-related functions under the guest mode

### 4.1.1 /auth/guest_check_token 


#### 4.1.1.1 Interface specification

　　Call the interface to authenticate under the guest mode

#### 4.1.1.2 Input parameter description

| Parameter name| Type|Description|
| ------------- |:-------------|:-----|
| guestid|string| The exclusive identifier of a visitor |
| accessToken|string| The user’s login credential |

#### 4.1.1.3 Output parameter description

| Parameter name| Description|
| ------------- |:-----|
| ret| Return code 0: correct  others: failure |
| msg| If ret is not 0, it means “Error code, error prompt”. For details, please refer to Section 5 |

#### 4.1.1.4 Interface call description
|Name|Description|
| ------------- |:-----|
| URL|http://msdktest.qq.com/auth/guest_check_token/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| Format |JSON |
| Request mode |POST  |

#### 4.1.1.5 Request example

	POST /auth/guest_check_token/?timestamp=&appid=G_**&sig=***&openid=G_**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJPLafWudG-idTVMbKesBkhBO_ZxFWN4zlXCpCHpYcrXNG6Vs-cocorhdT5Czj_23QF6D1qH8MCldg0BSMdEUnsaWcFH083zgWJcl_goeBUSQ",
	     guestid": "G_oGRTijiaT-XrbyXKozckdNHFgPyc"
	}
	
	//Returned result
	{
	    "ret": 0,
	    "msg": "ok"
	}


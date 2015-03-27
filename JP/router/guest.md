# 4.ゲストモード

## 4.1 authサービス

　　ゲストモードで授権ログインの関連機能を実現します

### 4.1.1 /auth/guest_check_token 


#### 4.1.1.1 インターフェースの説明 

　　ゲストモードでは、このインターフェースを呼び出して権限を確認します。

#### 4.1.1.2入力パラメータの説明 

| パラメータ名称| 種類|記述|
| ------------- |:-------------|:-----|
| guestid|string| ゲストの唯一標識です。モバイルQQのappidの前に「G_」を付けます(.注意：一部のゲームはウィーチャットだけに接続したため、ウィーチャットのappidを利用します。例えばG_wx***のように、登録の時に1つのappidを利用したら、これからゲストモード・インターフェースを呼び出す時、このappidを利用します)。|
| accessToken|string|ユーザーのログイントークンです|

#### 4.1.1.3出力パラメータの説明 

| パラメータ名称| 記述|
| ------------- |:-----|
| ret|リターンコード  0：正確，その他：失敗 |
| msg|retが0以外の場合、「エラーコード、エラーメッセージ」が表示されます。詳細注釈は第5節を参照してください|

#### 4.1.1.4 インターフェース呼び出し説明 
|名称|記述|
| ------------- |:-----|
| URL|http://msdktest.qq.com/auth/guest_check_token/ |
| URI|?timestamp=**&appid=**&sig=**&openid=**&encode=1|
| 形式|JSON |
| リクエスト方式|POST  |

#### 4.1.1.5 リクエストサンプル 

	POST /auth/guest_check_token/?timestamp=&appid=G_**&sig=***&openid=G_**&encode=1 HTTP/1.0
	Host:$domain
	Content-Type: application/x-www-form-urlencoded
	Content-Length: 198
	
	{
	    "accessToken": "OezXcEiiBSKSxW0eoylIeLl3C6OgXeyrDnhDI73sCBJPLafWudG-idTVMbKesBkhBO_ZxFWN4zlXCpCHpYcrXNG6Vs-cocorhdT5Czj_23QF6D1qH8MCldg0BSMdEUnsaWcFH083zgWJcl_goeBUSQ",
	     guestid": "G_oGRTijiaT-XrbyXKozckdNHFgPyc"
	}
	
	//戻り結果
	{
	    "ret": 0,
	    "msg": "ok"
	}


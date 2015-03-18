1.概説
===
1.1 インターフェースの呼び出し方式
---
　　　httpプロトコルを通じて、インターフェースに必要なパラメータを配列に組み込み、json形式に変換してから、http bodyに入れ、postで指定のurlに送信します。http プロトコルのurl にはappid,sig, timestamp,encode opendidなどのパラメータがなければなりません。インターフェースのパラメータは全てutf8コードです。

インターフェース呼び出しのドメイン：

テスト環境 msdktest.qq.com 

正式環境ではクライアントは msdk.qq.comを利用します

正式環境（内部ネットワークIDC）では、gameSvrはMSDKドメイン msdk.tencent-cloud.net (TGW)にアクセスします。


***ゲームを正式にリリースする前に、正式環境のドメインに切り替えなければなりません***

1.2 インターフェースUrlパラメータの説明
---
appid：ゲームのウィーチャット又はモバイルQQプラットフォームでの唯一ID。

timestamp：現在の標準的なタイムスタンプ（秒）。

sig：暗号化文字列です。Appidに対応するappkeyを用いて、timestampパラメータを付けて、md5暗号化を行い、32ビットの小文字の文字列となります。

sig =  md5 ( appkey + timestamp ) "+"とは2つの文字列の接続文字であり、"+"をmd5暗号化文字列に入れないでください

encode：値は1とし（http+json形式）なければなりません。

conn:常時接続の有無を示します。ご注意： gameSvrのリクエストだけ、conn=1を利用できます。クライアントのリクエストは常時接続をしないでください。

msdkExtInfo:透明伝送のパラメータを示し、戻りのjsonにはこのパラメータを付けて透明伝送します。ご注意： msdkExtInfoは英字・数字・下線から構成されており、特殊文字を利用できません。

openid:ユーザーのアプリでの唯一標識。

1.3 どのように戻り結果を取得しますか。
---
　　　httpプロトコルでデータを送信して、ステータスコードを取得します。200であれば、リクエスト正常を示し、http戻りの内容を取得でき、json文字を配列に解析できます。200以外の場合、リクエスト失敗を示し、直接に結果を印刷して、問題を特定します。

1.4 PHP呼び出しサンプル
---
	<?php
	require_once ‘SnsNetwork.php’;
	$appid = 「100703379」;
	$appKey = 」f92212f75cd8d**」;
	$openid = 「F4382318AFBBD94F856E8%2066043C3472E」;
	$ts = time();
	//md5 32ビットの小文字、例えば」111111」のmd5は「 96e79218965eb72c92a549dd5a330112」となります。
	$sig = md5($appKey.$ts);
	$url= 「http://msdktest.qq.com/relation/qqfriends_detail/?timestamp=$ts&appid=$appid&
	sig=$sig&openid=$openid&encode=1」;
	$param = array(
		‘appid’=> 100703379,
		‘openid’=>’A3284A812ECA15269F85AE1C2D94EB37’,
		‘accessToken’=>’ 933FE8C9AB9C585D7EABD04373B7155F’
	);
	$result = SnsNetwork:: makeRequest($url,json_encode($param));
	print_r($result);


<a href="SnsNetwork.php.txt" target="_blank">SnsNetwork.phpファイルダウンロード</a>

1.5 jsonデータ形式の説明
---
それぞれのインターフェースの入力パラメータの記述では、パラメータの種類を説明しています。int,string,struct等パラメータの違いをご注意ください。例えば：
   
	   appiDの値はintタイプ:{「appid」:369}
	
	　 appiDの値はstringタイプ：{「appid」:」appid」}
	   
       openiDの値はstring配列タイプ：{「openid」:[「openid1」,」openid2」]}

1.6 ゲストモード
---
ゲストモードはurlのappidとopenidで認識されます。即ち従来のモバイルQQのappidの前に「G_」を追加します（ご注意：一部のゲームはウィーチャットだけに接続したため、ウィーチャットのappidを利用します。例えばG_wx***のように、登録の時に1つのappidを利用したら、これからゲストモード・インターフェースを呼び出す時、このappidを利用します)。「G_100703379」はその一例です。ゲストモードでは/auth/guest_check_token権限確認インターフェースにアクセスします。他のインターフェースにアクセスすると、-901のエラーが表示され、ゲストにはこのインターフェースにアクセスする権限がないことを示します。


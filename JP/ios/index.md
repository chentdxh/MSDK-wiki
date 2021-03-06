﻿MSDK iOS 紹介
=======

### [SDKダウンロード](http://mcloud.ied.com/wiki/MSDK%E4%B8%8B%E8%BD%BD) [クイックスタート](iOSPlugin.md)

## 機能紹介
 
#### MSDK はテンセントIEGが自作ゲーム及び第三者モバイルゲームの開発チーム向けに提供される公共コンポーネントとサービスライブラリーです。ゲームが快速にテンセントの各プラットフォームに接続し、運営を展開することを目指しています。

## インストールパッケージの構造
* 2.3.4i及び従来のバージョン:


	圧縮ファイルにはdemoエンジニアリングがあり、WGPlatform.embeddedframework/WGPlatform_C11.embeddedframeworkを含めています。
	前者は「Build Setting->C++ Language Dialect」がGNU++98として配置され、「Build Setting->C++ Standard Library」が「libstdc++(GNU C++ standard library)」のエンジニアリングに適用します。
	後者はこれらの配置が「GNU++11」と「libc++(LLVM C++ standard library with C++11 support)」のエンジニアリングに適用します。


![linkBundle](./ファイル構造1.PNG)


    これらembeddedframeworKのファイル構造は同じです。WGPlatform.embeddedframeworkを例として、フォルダーの用途は[内容]章節を参照してください。更新する時、従来のファイルを削除してから、新しいファイルを導入してください。
![linkBundle](./ファイル構造2.PNG) 


* 2.4.0i以降のバージョン:


    圧縮ファイルにはdemoエンジニアリングがあり、次のような内容を含めています。
    1.MSDKFoundation.framework，基本的なライブラリー。
    2.MSDK.framework，基本的なログイン・共有機能を提供します。
    3.MSDKMarketing.frameworkクロス販売、内蔵ブラウザの機能を提供します。
    4.MSDKXG.frameworkプッシュ機能を提供します。
    その中、MSDKFoundation.frameworkは基本的なライブラリーであり、これを導入しなければなりません。他の3つのライブラリーはオプションライブラリーであり、実際の要求に応じて導入できます。
    MSDK.framework、MSDKFoundation.framework、MSDKMarketing.framework、MSDKXG.frameworkは、「Build Setting->C++ Language Dialect」がGNU++98として配置され、「Build Setting->C++ Standard Library」が「libstdc++(GNU C++ standard library)」のエンジニアリングに適用します。
    対応の_C11のあるframeworkは、これらの配置がそれぞれ「GNU++11」と「libc++(LLVM C++ standard library with C++11 support)」のエンジニアリングに適用します。


![linkBundle](./ファイル構造_2.4.0_1.PNG)


    更新方式は2.3.4iバージョンと同じで、従来のファイルを削除してから、新しいファイルを導入してください。

## 次の内容を含めています

* 2.3.4i以前のバージョン:
####　ヘッダファイル及びスタティック・ライブラリー・ファイルは、`WGPlatform.framework`にあります。リソースファイルは`WGPlatformResources.bundle`にあります（2.3.4i以前のバージョンはフォルダー「MsdkResources」にあります）。
####　主なインターフェースは`WGPlatform.h`ファイルにあり、MSDK関連の構造体は`WGCommon.h`ファイルにあり、枚挙値は`WGPublicDefine.h`で定義され、プッシュ・インターフェースは`WGApnInterface.h`ファイルにあり、メイン・コールバック対象は`WGObserver.h`ファイルにあり、広告コールバック対象は`WGADObserver.h`ファイルにあります。

* 2.4.0i以降のバージョン:
#### ヘッダファイル及びスタティック・ライブラリー・ファイルはそれぞれframeworkにあります。リソースファイルは`/MSDKMarketing/WGPlatformResources.bundle`にあります。
#### 主なインターフェースは`MSDK.framework/WGPlatform.h`ファイルにあり、MSDK関連の構造体は`MSDKFoundation.framework/MSDKStructs.h`ファイルにあり、枚挙値は`MSDKFoundation.framework/MSDKEnums.h`で定義され、プッシュ・インターフェースは`MSDKXG.framework/MSDKXG.h`ファイルにあり、メイン・コールバック対象は`MSDK.framework/WGPlatformObserver.h`ファイルにあり、広告コールバック対象は`MSDK.framework/WGADObserver.h`ファイルにあります。

## モジュール紹介
 
| モジュール名称 | モジュール機能 | 接続条件 |
| ------------- |:-------------:|:----:|
| プラットフォーム| ウィーチャットとモバイルQQをプラットフォームという||
|データ分析モジュール|データ報告、異常報告を提供	||
|モバイルQQ	 |ログインとモバイルQQへの共有能力を提供	|モバイルQQ AppIDとappKeyを必要|
|ウィーチャット |	ウィーチャットのログインと共有能力を提供	|ウィーチャット AppID と appKeyを必要|
|QQゲームホール	|ゲームホールによるゲーム実行能力を提供	||
|内蔵ブラウザ	|アプリの内蔵ブラウザ能力を提供	||
|公告	|ポップアップ公告のスクロール能力	を提供||
|LBS	|地理位置に基づき友達を表示する能力を提供	||
|ゲストモード|ゲストでのログインと支払を提供	|モバイルQQ又はウィーチャットAppIDとappKeyを必要|
|プッシュ|メッセージのプッシュ能力を提供|||


 ## 用語解釈


| 名称 | 用語概説 |
| ------------- |:-------------|
| プラットフォーム| ウィーチャットとモバイルQQをプラットフォームという|
|openId|ユーザーの授権後、プラットフォームから戻る唯一標識|
|accessToken|ユーザー授権のトークンです。このトークンを取得した後、ユーザーが授権したことを認めます。共有/支払などの機能はこのトークンを必要とします。. モバイルQQのaccessTokenの有効期間は90日です。ウィーチャットのaccessTokenの有効期間は2時間です。|
|payToken|支払のトークンであり、このトークンはモバイルQQ支払に利用されます。モバイルQQの授権でこのトークンが戻ります。ウィーチャットの授権ではこのトークンが戻りません。有効期間は6日です。|
|refreshToken|ウィーチャット・プラットフォーム独自のトークンであり、有効期間は30日です。ウィーチャットaccessTokenの期間切れ後に、accessTokenを更新します。|
|別アカウント|ゲームで授権したアカウントとモバイルQQ/ウィーチャットで授権したアカウントは同じではありません。このシーンを別アカウントと言います。|
|構造化メッセージ|共有メッセージの一種です。 このメッセージを共有した後、表示形式としては、左にサムネイル、右上にメッセージタイトル、右下にメッセージ概要です。|
|大画像メッセージ|共有メッセージの一種です。 このメッセージは画像1枚だけで、表示も画像となります。大画像共有、純粋画像共有とも呼ばれています。|
|共遊び友達|モバイルQQ又はウィーチャットの友達で、同じゲームを遊んだ友達を共遊び友達と言います|
|ゲームセンター|モバイルQQクライアント又はウィーチャットクライアントのゲームセンターを統一にゲームセンターと言います。|
|ゲームホール|特にQQゲームホールを言います|
|プラットフォームによる実行|プラットフォーム又はチャンネル（モバイルQQ/ウィーチャット/ゲームホール/応用宝等）を通じてゲームを実行します|
|関係チェーン|ユーザーのプラットフォームでの友達関係|
|会話|モバイルQQ又はウィーチャットのチャット情報|
|インストールチャンネル|info.plistで配置されたCHANNEL_DENGTA値です。デフォルトとしては1001（AppStore）です。|
|登録チャンネル|ユーザーは始めてログインする時、 ゲームのインストールチャンネルがユーザーの登録チャンネルとして、MSDKバックグラウンドで記録されます|
|Pf|支払に必要なフィールドであり、データ分析に使用します。pfの構成としては、実行プラットフォーム_アカウント体系-登録チャンネル-OS-インストールチャンネル-自己定義フィールド.|
|pfKey| 支払に使用します|
|AMS|	インタラクティブ・エンターテインメント高級販売システムであり、ゲームの販売イベントの計画と開発を担当します|
|快速ログイン|	モバイルQQゲームリスト、又は共有リンクから、モバイルQQでログインしたアカウント情報を直接にゲームに伝送し、ログインを実現でき、ゲームの再授権を必要としません。MSDK 1.8.0i以降、モバイルQQ4.6.2以降を必要とします。|
|Guestモード|	Apple社の要求により、iOSモバイルゲームはモバイルQQ/ウィーチャットプラットフォーム以外のログイン方式を提供し、直接にゲームに入り、ゲームの完全な内容を体験し、この方式で支払を完成できなければなりません。|
|GuestID|	機器情報に基づき、MSDKに対して登録し生成したゲストの身分標識です。形式は"G_数字/英字/_/@"で構成される34桁の文字列です。|
|Guest AppID|	ゲストモードを識別するために、GuestモードのAppIDは「G_モバイルQQAppID」の形式を使用します。ゲームはモバイルQQ AppIDがなければ、"G_ウィーチャットAppID"を使用します。|
|Guest AppKey|	Guest AppIDとペアとなり、対応のモバイルQQ/ウィーチャットのAppKeyを使用します。|
|支払id|	OfferIdとも呼ばれ、info.plistのMSDK_OfferId項目に配置されます。<br>自作ゲーム：直接に米大師の公式サイトmidas.qq.comでiosアプリを登録することでofferidを生成します<br>外部代理ゲーム：ゲームのプロダクト担当がRDM公式サイトrdm.oa.comでアップル情報を申請してから、情報を協同計画グループのjiaganzhengに渡し、devバックグラウンドに入力します。それから、開発業者が管理センターでIAPバージョンを追加してから、offeridを生成します|

## 注意事項

支払はMSDKと独立しており、関連のドキュメントは [米大師公式サイト](http://midas.qq.com) を参照してください。
AppID、appKey、offerIdは関連モジュールに接続するための証拠であり、申請方法は「MSDK製品紹介」に記載されています。

## バージョン履歴

* [クリックしてMSDKバージョンの変更履歴を確認します](version.md)




MSDK ユーザーフィードバック 関連モジュール
===

ユーザーフィードバック
---

このイベントインターフェースを通じて、ユーザーフィードバックを行い、フィードバックの内容は[http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce](http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce) で見ることができます。この機能を完成するには、WGFeedbackというインターフェースを利用します。インターフェースの詳細は次の通りです。 
#### インターフェース声明：

    /**
    * ユーザー・フィードバック・インターフェースで、フィードバックの内容はhttp://mcloud.ied.com/queryLogSystem/ceQuery.html?token=07899ab75c30e499d5b33181c2d8ddc7&gameid=0&projectid=ceを見てください。
    * @param game ゲームの名称です。ゲームは自分のapp名を使ってください。
    * @param txt フィードバック内容
    */
    int WGFeedback(unsigned char* game, unsigned char* txt);

	/**
	 * ユーザー・フィードバック・インターフェースで、フィードバックの内容はリンク(Tencent内部ネットワーク)を見てください。
	 * 		http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce
	 * @param body フィードバックの内容であり、ゲームは形式を自己定義し、SDKではこれを制限しません。
	 * @return はOnFeedbackNotifyを通じて、フィードバック・インターフェースの呼び出し結果をコールバックします。
	 */
	void WGFeedback(unsigned char* body);

#### インターフェースの呼び出し：
インターフェース呼び出しのサンプル：

	WGPlatform::GetInstance()->WGFeedback((unsigned char*) cgame.c_str(),
			(unsigned char*) ctxt.c_str());
コールバック受信のサンプル：

	virtual void OnFeedbackNotify(int flag, std::string desc) {
    	LOGD("OnFeedbackNotify %d; %s", flag, desc.c_str());
    }


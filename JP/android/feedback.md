MSDK ユーザーフィードバック 関連モジュール
===

ユーザーフィードバック
---

当該イベントインターフェースを通じて、ユーザーフィードバックを行い、フィードバックの内容は [http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce](http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce)で見ることができます。この機能を完成するには、WGFeedbackというインターフェースを利用し、インターフェースの詳細は次の通りです。 
#### インターフェース声明：
	
	/**
	 * ユーザー・フィードバック・インターフェースで、フィードバックの内容はリンクを見てください (Tencent内部ネットワーク):
	 * 		http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce
	 * @param body フィードバックの内容であり、ゲームは形式を自己定義し、SDKではこれを制限しません。
	 * @return はOnFeedbackNotifyを通じてフィードバックインターフェースの呼び出し結果をコールバックします。
	 */
	void WGFeedback(unsigned char* body);

#### インターフェースの呼び出し：
インターフェース呼び出しのサンプル：

	WGPlatform::GetInstance()->WGFeedback((unsigned char*) cgame.c_str(),
			(unsigned char*) ctxt.c_str());
コールバック受信の事例：

	virtual void OnFeedbackNotify(int flag, std::string desc) {
    	LOGD("OnFeedbackNotify %d; %s", flag, desc.c_str());
    }


MSDK 用户反馈 相关模块
===

用户反馈
---

可以通过该事件接口，进行用户反馈，反馈的内容可通过[http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce](http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce)查看。要完成此功能需要用到的接口有: WGFeedback, 接口详细说明如下: 
#### 接口声明：
	
	/**
	 * 用户反馈接口, 反馈内容查看链接(Tencent内网):
	 * 		http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce
	 * @param body 反馈的内容, 内容由游戏自己定义格式, SDK对此没有限制
	 * @return 通过OnFeedbackNotify回调反馈接口调用结果
	 */
	void WGFeedback(unsigned char* body);

#### 接口调用：
接口调用示例：

	WGPlatform::GetInstance()->WGFeedback((unsigned char*) cgame.c_str(),
			(unsigned char*) ctxt.c_str());
回调接受事例：

	virtual void OnFeedbackNotify(int flag, std::string desc) {
    	LOGD("OnFeedbackNotify %d; %s", flag, desc.c_str());
    }
MSDK 유저 피드백 관련 모듈
===

유저 피드백
---

해당 이벤트 인터페이스를 통하여 유저 피드백을 진행할 수 있습니다. 피드백 내용은 [http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce](http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce)를 통하여 확인 가능합니다. 이 기능 구현에 필요한 인터페이스는 WGFeedback 이며,인터페이스관련 상세한 설명은 아래 내요을 참조 바랍니다. 
#### 인터페이스 설명:
	
	/**
	 * 유저 피드백 인터페이스, 피드백 내용은 링크(Tencent 내부 네트워크) 확인 바랍니다.
	 * 		http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce
	 * @param body 피드백 내용, 내용 포맷은 게임 자체 정의, SDK는 이에 대해 제한이 없음
	 * @return  OnFeedbackNotify 호출을 통하여 인터페이스 호출 결과를 콜백
	 */
	void WGFeedback(unsigned char* body);

#### 인터페이스 호출: 
인터페이스 호출 예시: 

	WGPlatform::GetInstance()->WGFeedback((unsigned char*) cgame.c_str(),
			(unsigned char*) ctxt.c_str());
접수 사례 콜백:

	virtual void OnFeedbackNotify(int flag, std::string desc) {
    	LOGD("OnFeedbackNotify %d; %s", flag, desc.c_str());
    }

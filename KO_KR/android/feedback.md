MSDK 유저 피드백 관련 모듈
===

유저 피드백
---

해당 이벤트를 통해 인터페이스 유저 피드백 진행 가능. 피드백 내용은 [http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce](http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce)를 통해 확인. 이 기능 구현에 필요한 인터페이스: WGFeedback, 인터페이스 구체 설명은 다음 내용 참조: 
#### 인터페이스 선언:
	
	/**
	 * 유저 피드백 인터페이스, 피드백 내용은 링크(Tencent 내부 네트워크) 확인:
	 * 		http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce
	 * @param body 피드백 내용, 내용 형식은 게임 자체 정의, SDK는 이에 대해 제한이 없음
	 * @return OnFeedbackNotify를 통해 피드백 인터페이스 호출 결과 콜백
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

MSDK User Feedback-related Module
===

User feedback
---

Make the user feedback through the event interface, and view the feedback content through [http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce](http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce). The interface required to complete this feature includes: WGFeedback, which is described as follows:

#### Interface declaration:

    /**
    * user feedback interface; as for the feedback content, view the link:  http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=07899ab75c30e499d5b33181c2d8ddc7&gameid=0&projectid=ce
    * @param game: game name; the game can use its own app name
    * @param txt: feedback content
    */
    int WGFeedback(unsigned char* game, unsigned char* txt);

	/**
	 *  user feedback interface; as for the feedback content, view the link (Tencent intranet):
	 * 		http://mcloud.ied.com/queryLogSystem/ceQuery.html?token=545bcbcfada62a4d84d7b0ee8e4b44bf&gameid=0&projectid=ce
	 * @param body: The content of feedback; the format of the content is defined by the game itself, and SDK has no restrictions on this
	 * @return  Call the result through OnFeedbackNotify callback feedback interface
	 */
	void WGFeedback(unsigned char* body);

#### Calling interface:
Interface call example:

	WGPlatform::GetInstance()->WGFeedback((unsigned char*) cgame.c_str(),
			(unsigned char*) ctxt.c_str());
Callback acceptance example:

	virtual void OnFeedbackNotify(int flag, std::string desc) {
    	LOGD("OnFeedbackNotify %d; %s", flag, desc.c_str());
    }

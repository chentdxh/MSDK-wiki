MSDK RQD(RDM) 관련 모듈
===


RQD 스위치 설정
---
    /**
    * @param bRDMEnable RDM의 crash 이상 캡쳐 전송 가동 여부
    * @param bMTAEnable MTA的crash 이상 캡쳐 전송 가동 여부
    */
    void WGEnableCrashReport(bool bRDMEnable, bool bMTAEnable);


Crash 데이터 전송
---
    /**
    * 자체정의 데이터 전송, 이 인터페이스는 1개 key-value의 전송만 지원한다. 버전 1.3.4부터  void WGReportEvent( unsigned char* name, std::vector<KVPair>& eventList, bool isRealTime)를 사용할 것을 제안한다
    * @param name 이벤트 이름
    * @param body 이벤트 내용
    * @param isRealTime 실시간 전송 여부
    * @return void
    */
    void WGReportEvent(
    unsigned char* name, 
    unsigned char * body, 
    bool isRealTime
    ) DEPRECATED(1.3.4);

    /**
    * @param name 이벤트 이름
    * @param eventList 이벤트 내용, key-value 형식의 vector
    * @param isRealTime 실시간 전송 여부
    * @return void
    */
    void WGReportEvent(
    unsigned char* name, 
    std::vector<KVPair>& eventList, 
    bool isRealTime
    );

####전송된 데이터를 확인하는 방법
- 웹주소:[http://rdm.wsd.com/](http://rdm.wsd.com/)

![rdmwsd](/rdmwsd.png)
![rdmdetail](/rdmdetail.png)

####최초 등록 바인딩(자세한 내용은 spiritchen에게 연락):
![rdmregister](/rmdregister.png)

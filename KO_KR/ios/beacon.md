MSDK 비콘 관련 모듈
===
비콘 연동 설정
---
msdk1.7버전부터 msdk를 연동한 게임은 비콘팀에 비콘 appkey를 신청할 필요없고 qqAppId를 비콘key로 하며 연동을 진행합니다. 유저 분석->실시간 통계과정에 데이터 표시가 있으면 연동 성공된 것으로 판단합니다.

![beacon_1](./beacon_res1.png)

만약 데이터가 보이지 않을 경우 아래 스텝대로 처리 바랍니다.

1.     우선,게임에서 여러 비콘 관련앱을 신청하였지만 비콘은 그 중의 한 앱에 qqAppId(100703379)를 연결할 가능성이 있습니다.

2.     게임에서 MSDK1.7 혹은 이후 버전을 연동하였지만 비콘은 전에 신청한 appkey와 qqAppid를 연결하지 않을 경우 데이터를 확인할 수 없습니다.비콘 담당자@jiaganzheng와 연락하여 해당 qqAppId를 공지합니다.

3.     처음으로 연동할 시 우선 권한이 있는지 확인합니다.비콘 담당자@jiaganzheng와 연락하여 qqAppId를 공지합니다.


자체 정의 데이터 전송
---
해당 이벤트 인터페이스를 통하여 유저 관건 이벤트를 기록하여 비콘과 MTA에 전송합니다. 이로 인해 이벤트의 발생 횟수에 대해 통계 및 분석을 진행할 수 있습니다. 해당 기능을 구현할 경우 사용해야 할 인터페이스는 WGReportEvent입니다. 이 인터페이스의 상세 설명은 아래와 같습니다. 


     /**
	 * 자체정의 데이터 전송, 이 인터페이스는 한 key-value의 전송만 지원하며 1.3.4버전부터 void WGReportEvent( unsigned char* name, std::vector<KVPair>& eventList, bool isRealTime)를 사용하는 것을 권장드립니다.
	 * @param name 이벤트 명칭
	 * @param body 이벤트 내용
	 * @param isRealTime 실시간 전송 여부
	 * @return void
	 */
     void WGReportEvent(
		unsigned char* name, 
		unsigned char * body, 
		bool isRealTime
	) DEPRECATED(1.3.4);

기타 사용할 인터페이스는:
     
     /**
	 * @param name 이벤트 명칭
	 * @param eventList 이벤트 내용, 한 key-value형식의 vector
	 * @param isRealTime 실시간 전송 여부
	 * @return void
	 */
	void WGReportEvent(
		unsigned char* name, 
		std::vector<KVPair>& eventList, 
		bool isRealTime
	);

그중 파라미터에 대한 제한은 아래와 같습니다. **eventName는 MSDK_로 시작하는 것은 금지입니다. 이는 msdk자체정의 이벤트의 네이밍 방식이기 때문입니다.**

![beacon_3](./beacon_d1.png)

적용 스테이지
---

어느 인테페이스의 호출 횟수를 조회하려면, 예를 들어 QQ유저 개인 정보를 조회하려면 이벤트의 명칭은 queryQQUserInfo로 설정하고 호출 방법은 아래와 같습니다.

    WGReportEvent("queryQQUserInfo", null, true);

데이터 전송이 성공되면 http://beacon.tencent.com/ 에 해당한 비콘app의 로그에서 조회할 수 있습니다.실시간 전송할 경우 보통 상기 내용에서 언급한 방법으로 호출한 후 5분내에 조회할 수 있습니다.

![beacon_3](./beacon_d2.png)

추가로 이벤트 퀄리티 리스트에서 수량에 대한 통계를 조회할 수 있습니다.


![beacon_4](./beacon_d3.png)

상세 내용은 운영팀을 통하여 비콘 담당자한테 문의 바랍니다.

PS：비콘 자체정의 이벤트에는 성공률 및 시간 딜레이에 관한 통계가 있습니다. 현재는 매핑되어 있지 않아 게임에서 사용할 경우 UserAction.onUserAction를 호출하면 됩니다. 사용 방법은 비콘 홈페이지에서 제공한 참고 파일을 확인 바랍니다.
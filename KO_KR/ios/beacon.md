MSDK 비콘 관련 모듈
===
비콘 연동 설정
---
msdk1.7버전부터 msdk에 연동하는 게임은 비콘팀에게 비콘 appkey를 신청할 필요없고 qqAppId를 비콘key로 하며 연동을 진행한다. 유저 분석->실시간 통계과정에 데이터 표시가 있으면 연동 성공인 것으로 본다.

![beacon_1](./beacon_res1.png)

만약 데이터가 안 보일 경우는 아래 스텝대로 처리.

1.     우선，게임이 여러 비콘 관련앱을 신청했을 가능성이 있어 하지만 비콘은 그 중의 하나 관련앱과 qqAppId(100703379)연결 시킬 것이다.

2.     게임은 MSDK1.7혹 이후 버전에 연동했지만 비콘은 전에 신청한 appkey와 qqAppid를 연결 시키지 않았으면 데이터를 볼 수가 없다.비콘 관련자@jiaganzheng에게 연락하여 해당 qqAppId를 알려주면 된다.

3.     처음으로 연동할 때 우선 권한이 있는지를 확인해야 한다.관련 문의는 비콘 관련자 @jiaganzheng에게 연락하여 qqAppId를 알려줘야 한다.


자체 정의 데이터 보고
---
해당 이벤트 인터페이스를 통해 유저 관건 이벤트를 기록하여 비콘과 MTA에 보고한다. 하여 이벤트의 발생 횟수에 대해 통계 분석을 진행. 해당 기능을 구현하려면 사용해야 할 인터페이스는 WGReportEvent가 있다. 이 인터페이스의 상세 설명은 아래와 같다: 


     /**
	 * 자체정의 데이터 보고, 이 인터페이스는 한 key-value의 보고만 지원하며 1.3.4버전부터 void WGReportEvent( unsigned char* name, std::vector<KVPair>& eventList, bool isRealTime)를 사용하는 것을 제안한다.
	 * @param name 이벤트 명칭
	 * @param body 이벤트 내용
	 * @param isRealTime 실시간 보고 여부
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
	 * @param isRealTime 실시간 보고 여부
	 * @return void
	 */
	void WGReportEvent(
		unsigned char* name, 
		std::vector<KVPair>& eventList, 
		bool isRealTime
	);

그중에 파라미터의 구속은 아래와 같다：**eventName는 MSDK_로 시작하면 안 된다. 외냐하면 이것은 msdk자체정의 이벤트의 네이밍 방식이기 때문이다.**

![beacon_3](./beacon_d1.png)

적용 스테이지
---

모 인테페이스의 호출 횟수를 조회하려면, 예를 들어 QQ유저 개인 정보를 조회하려면 이벤트의 명칭은 queryQQUserInfo로 설정하고 호출 방법은 아래와 같다：

    WGReportEvent("queryQQUserInfo", null, true);

데이터 보고 성공하면 http://beacon.tencent.com/ 에 대응한 비콘app의 로그에서 조회할 수 있다.실시간 보고할 경우는 보통 위에 언급한 방법으로 호출하면 5분내에 조회 가능.

![beacon_3](./beacon_d2.png)

그리고 이벤트 퀄리티 리스트에서 수랭 통계를 조회할 수 있다：


![beacon_4](./beacon_d3.png)

구체적 내용은 RTX로 비콘 비서에 문의 가능.

또한：비콘 자체정의 이벤트에는 성공률 및 시간 지연에 관련 통계가 있는데 현재는 매핑되어 있지 않아 게임이 사용 필요할 때 UserAction.onUserAction를 호출하면 된다. 사용 방법은 비콘 공식 페이지에서 제공한 참고 문서를 확인 바람.
MSDK Beacon 관련 모듈
===
Beacon 연동 설정
---
MSDK1.7부터 MSDK를 연동할 게임은 Beacon에 Beacon appkey를 신청할 필요가 없으며 QQ AppId를 Beacon key로 Beacon을 연동할 수 있습니다. 유저분석->실시간 통계에 데이터가 전시될 경우 연동되었음을 의미합니다.

![beacon_1](./beacon_res/beacon_1.png)

MSDK1.7부터 AndroidManifest.xml에서 Beacon에 대해 설정 할 필요가 없습니다. 일부 게임은 아래 코드로 인하여 데이터 에러가 발생할 수 있으므로 아래 코드를 삭제할 것을 권장드립니다.

![beacon_3](./beacon_3.png)

데이터가 보이지 않을 경우 아래 절차대로 처리합니다.

1.게임이 여러개 Beacon 앱을 신청하였지만 Beacon은 다만 그중 한 Beacon 앱을 QQAppId(100703379)에 연결할 가능성이 있습니다. 예를 들면 MSDK에서 테스트를 위하여 Beacon 앱을 3개 신청하였지만 MSDK(Android)는 QQ AppId와 연결된 앱이여서 WeGameSample과 연결되지 않을 수 있습니다. 하여 MSDK(Android)에서 최신 데이터를 확인할 수 있지만 WeGameSample에서는 최신 데이터를 확인할 수 없습니다. 우선 이 부분에 대해 확인 부탁드립니다.

![beacon_1](./beacon_res/beacon_2.png)

2.게임에서 MSDK1.7 혹은 그 이상 버전을 연동하였지만 Beacon에서 전에 신청한 appkey와 qqAppid를 연결하지 않을 수도 있습니다. 이럴 경우 여전히 데이터를 확인할 수 없으며 Beacon PM님과 연락하여 확인 후 QQAppId를 통보하여야 합니다.

3.최초 연동 시 권한 존재 여부를 확인하여야 하며 이는 Beacon PM님과 연락하여 확인 후 QQAppId를 통보하여야 합니다.


자체 정의 데이터 전송
---
해당 이벤트 인터페이스를 통하여 유저 중요 이벤트를 기록하고 Beacon과 MTA에 전송하여 이벤트 발생 횟수를 통계할 수 있습니다. 이 기능 구현에 필요한 인터페이스는 WGReportEvent이며 상세한 설명은 아래와 같습니다.


     /**자체정의 데이터 전송, 이 인터페이스는 하나의 key-value 전송만 지원합니다. 버전 1.3.4부터 void WGReportEvent(String name,       HashMap<String, String> params, boolean isRealTime)를 사용할 것을 권장드립니다.
	 * @param name 이벤트명
	 * @param body 이벤트 내용
	 * @param isRealTime 실시간 전송 여부
	 * @return void
	 */
     public static void WGReportEvent(String name, String body, boolean isRealTime);

이 외 인터페이스:
     
     /**
	 * @param eventName 이벤트명
	 * @param params key-value 포맷 자체정의 이벤트
	 * @param isRealTime 실시간 전송 여부
	 * @return void
	 */
    public static void WGReportEvent(String eventName, HashMap<String, String> params, boolean isRealTime);

그중 파라미터에 대한 요구는 아래와 같습니다.
**eventName은 MSDK의 자체 설정 이벤트명이므로 MSDK_로 시작하는 것은 권장하지 않습니다.**

![beacon_3](./beacon_d1.png)

시나리오
---

임의 인터페이스의 호출 횟수를 확인할 경우, 예를 들면 QQ유저 개인 정보를 확인할 경우 이벤트명을 queryQQUserInfo로 하며 호출 방법은 아래와 같습니다.

    WGReportEvent("queryQQUserInfo", null, true);

성공적으로 전송될 경우 http://beacon.tencent.com/ Beaconapp에 해당하는 로그에서 조회할 수 있습니다. 실시간으로 전송되면 일반적으로 상기 방법대로 호출한 후 5분 내에 조회할 수 있습니다.

![beacon_3](./beacon_d2.png)

그 외, 이벤트 퀼리티 리스트에서 수량 통계를 확인할 수 있습니다.


![beacon_4](./beacon_d3.png)

자세한 내용은 RTX Beacon 도우미한테 문의할 수 있습니다.

그 외 Beacon 자체정의 이벤트는 성공률과 딜레이 통계가 있으며 아직 패킹되지 않았습니다.게임에서 필요할 경우 자체로 UserAction.onUserAction을 호출할 수 있습니다. 사용 방법은 Beacon 홈페이지의 연동 파일을 참조 바랍니다.
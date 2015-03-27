MSDK 등탑 관련 모듈
===
등탑 액세스 설정
---
msdk1.7부터 msdk를 액세스한 게임은 등탑에 등탑 appkey를 신청하지 않고 qqAppId를 등탑key로 사용하여 등탑 액세스를 실현할 수 있다. 유저분석->실시간 통계에서 데이터가 보여지면 액세스 성공을 표시한다.

![beacon_1](./beacon_res/beacon_1.png)

MSDK1.7부터 AndroidManifest.xml에서 등탑에 대해 아래와 같은 설정 할 필요없다.일부 게임은 해당 코드로 데이터 비정상일 경우가 있기 때문에 해당 코드를 제거하기 제안한다.

![beacon_3](./beacon_3.png)

데이터가 보이지 않으면 다음 절차대로 처리한다.

1.     우선, 게임이 여러개 등탑 앱을 신청했지만 등탑은 그중 하나의 등탑 앱만 qqAppId(100703379)에 연결했을 가능성이 존재한다. 예하면, msdk가 테스트를 위해 등탑 앱을 3개 신청했지만 MSDK(Android)는 qqAppId와 연결된 앱이고 WeGameSample과 연결되지 않아 MSDK(Android)에서 최신 데이터를 볼 수 있지만 WeGameSample에서 최신 데이터를 보지 못하는 경우이다. 게임은 이것을 우선 확인해야 한다.

![beacon_1](./beacon_res/beacon_2.png)

2.     게임이 MSDK1.7 또는 그후의 버전에 액세스했지만 등탑이 이전에 신청한 appkey와 qqAppid를 연결시키지 않은 경우에도 데이터를 볼 수 없게 된다. 등탑 담당자 @jiaganzheng을 통해 확인하고 qqAppId를 통지해야 한다

3.     최초 액세스 시 권한이 있는 지 확인해야 한다. 등탑 담당자 @jiaganzheng을 통해 확인하고 qqAppId를 통지해야 한다.


자체정의 데이터 보고
---
해당 이벤트 인터페이스를 통해 유저 중요 이벤트를 기록하고 등탑과 MTA에 보고하여 이벤트 발생 횟수에 대해 통계 분석을 진행할 수 있다. 이 기능 구현에 필요한 인터페이스: WGReportEvent, 인터페이스의 자세한 설명은 다음과 같다.


     /**자체정의 데이터 보고, 이 인터페이스는 하나의 key-value 보고만 지원한다. 버전 1.3.4부터 void WGReportEvent(String name,       HashMap<String, String> params, boolean isRealTime)를 사용할 것을 권장한다
	 * @param name 이벤트명
	 * @param body 이벤트 내용
	 * @param isRealTime 실시간 보고 여부
	 * @return void
	 */
     public static void WGReportEvent(String name, String body, boolean isRealTime);

이 외 인터페이스는:
     
     /**
	 * @param eventName 이벤트명
	 * @param params key-value 형식의 자체정의 이벤트
	 * @param isRealTime 실시간 보고 여부
	 * @return void
	 */
    public static void WGReportEvent(String eventName, HashMap<String, String> params, boolean isRealTime);

그중 파라미터 제약은 다음과 같다：**eventName은 msdk 자체정의 이벤트의 명명 방식이기에 MSDK_로 시작되지 말아야 한다.**

![beacon_3](./beacon_d1.png)

응용 시나리오
---

어느 하나의 인터페이스의 호출 횟수를 확인하려면, 예하여 QQ유저 개인 정보를 확인하려면 이벤트명을 queryQQUserInfo로 명명하고 호출 방법은 다음과 같다

    WGReportEvent("queryQQUserInfo", null, true);

성공적으로 보고되면 http://beacon.tencent.com/ 등탑app에 대응하는 로그에서 조회할 수 있다. 실시간으로 보고하면 일반적으로 상기 방법을 호출한 후 5분 내에 조회할 수 있다.

![beacon_3](./beacon_d2.png)

이 외에, 이벤트 품질 리스트에서 수량 통계를 확인할 수 있다.


![beacon_4](./beacon_d3.png)

자세한 내용은 RTX 등탑 도우미에게 문의하면 된다.

이외: 등탑 자체정의 이벤트는 성공률과 지연 통계가 있지만 아직 캡슐화되지 않았다. 게임에서 사용하려면 자체적으로 UserAction.onUserAction을 호출할 수 있다. 사용 방법은 등탑 공홈에서 제공하는 참고 문서를 참조할 수 있다.
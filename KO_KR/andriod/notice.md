MSDK 공지 모듈
===

모듈 소개
---

### 개요
공지 시스템은 SDK에서 제공하는 게임내 메세지 통보 시스템입니다. 웹페이지를 통하여 이벤트,월드 데이터 공유 불가능 등 정보를 통보할 수 있으며 정보 도달률을 한층 상승시킵니다. 현재 제공할 수 있는 기능은 아래와 같습니다.

- 상태에 따라 부동한 공지 발송(예: 로그인 전/후 공지);
- 다양한 유저 범위 선택: 전체 공지,구역/운영체제 구분,계정 지정(위챗 계정, QQ 계정);
- 다양한 공지 양식: 팝업 공지,롤링 공지;
- 다양한 공지 콘텐츠: 텍스트,이미지,웹페이지 등;

### 용어 해석

|  용어 | 해석 |
| ------------- |:-------------:|
| 공지 탭 | SDK공지 모듈이 부동한 위치의 공지를 표시하는 필드. 게임에서 공지 설정 시 선택하며, 이는 클라이언트에서 공지 표시 인터페이스를 호출할 시의 scene 파라미터임 |
| 팝업 공지 |팝업창 형식으로 공지 표시. 텍스트, 이미지, 웹페이지 모두 지원. 공지가 여러개 있을 경우 유저가 현재 공지를 닫으면 다음 공지 팝업. <BR>팝업 공지는 이동 링크를 추가할 수 있으며 클릭 시 내장 브라우저로 해당 링크 방문 |
| 롤링 공지 | 게임 화면 최상단에서 롤링 형식으로 공지 표시, 현재 텍스트만 지원하며 공지가 여러개 있을 경우 하나하나 표시 |

## 연동 주의사항(숙지 필요)

- 공지 모듈은 SDK 초기화와 유저 로그인 후 시스템 백그라운드에서 해당 APP의  유효 공지를 실행합니다. 이외, 공지 모듈은 타이밍 실행 메커니즘이 있습니다다. (기본적으로 10분에 1회)
- 공지 표시 인터페이스와 공지 데이터 획득 인터페이스 호출 시 항상 로컬 데이터베이스에서 해당 앱의 현재 유효한 공지를 획득합니다. 게임 연동 비용을 감안하여 SDK에서 제공하는 공지 UI를 사용할 것을 권장드립니다.
- **이 기능은 MSDK 버전 1.7.0a 이후부터 제공하고 공지 형식은 롤링 공지와 팝업 공지로 구분됩니다. **MSDK 2.0.0a 부터 공지 내용은 기존의 텍스트 형식으로부터 이미지와 웹페이지 형식으로 확장되었습니다.
- **`SDK는 부동한 위치에서 출력되는 공지를 공지탭으로로 구분합니다. 예를 들면 흔히 보는 게임 로그인 전 공지와 로그인 후 공지와 해당하는 SDK 공지 모듈은 다른 공지탭에 있습니다`**

권장 사용법
---

### 방안 개요

여기에서 주로 게임에서 SDK 공지 모듈을 연동하는 권장 방안에 대해 설명드립니다. SDK공지 모듈 연동 예시:

- 로그인 전/후 여러 위치의 팝업 공지와 게임내 임의 위치의 롤링 공지 연동.
- SDK 공지 모듈에서 제공하는 UI스타일 사용할 것을 권장. 


### 연동 프로세스

1. SDK 공지 관리자 페이지[http://dev.ied.com/](http://dev.ied.com/)에서 게임에 해당한 공지탭을 추가합니다. 아래 이미지는 SDK Demo에 해당하는 공지탭입니다.

	![notice_solution_1.png](./notice_solution_1.png "공지탭")

- 클라이언트 연동:

	1. `AndroidMainfest`와 `assets/msdkconfig.ini`에 MSDK 공지 관련 설정을 추가하고 본 페이지의 [연동 설정](notice.md#연동 설정)과 [스위치 설정](notice.md#스위치 설정)모듈을 확인 바랍니다.

	- 클라이언트 공지 호출(참고용):
		- 게임 초기화 후 로그인 화면에서 로그인 전 공지를 출력합니다. [공지 인터페이스 전시](notice.md#공지 인터페이스 전시) 인터페이스를 사용하고 파라미터는 해당 공지탭ID일 경우 로그인 전 공지를 출력합니다.
		- 게임에서 loginNotify 성공 콜백을 받고 게임 메인 화면으로 이동 시 로그인 후 공지를 출력합니다. [공지 인터페이스 전시](notice.md#공지 인터페이스 전시) 인터페이스를 사용하고 파라미터는 대응하는 공지탭id를 사용하면 로그인 후 공지를 표시할 수 있다
		- 게임은 롤링 공지를 출력하고 싶은 위치(예하면 로그인 후 게임 메인화면 등)에서 인터페이스를 호출하여 롤링 공지를 표시합니다. [공지 표시 인터페이스](notice.md#공지 표시 인터페이스)를 사용하며 파라미터는 해당한 공지탭ID입니다. 일반적으로 공지를 출력한 후 타이머를 설절하며 시간이 되면 롤링 공지를 감춥니다.

### 연동 테스트
	
1.클라이언트 확인’assets/msdkconfig.ini’ 설정한 도메인은’http://msdktest.qq.com’
2.운영팀에서 공지 관리단[http://dev.ied.com/](http://dev.ied.com/)에서 공지를 선택하여(테스트 환경) 공지를 등록합니다.
3.클라이언트에서는 설정된 공지 유형(로그인 전/후, 롤링/팝업,계정 패키지 여부 등)에 따라 테스트를 진행합니다. 공지가 출력되지 않을 경우 [게임 공지 오류 검증 절차](notice.md#게임 공지 오류 검증 절차)를 클릭하여 절차에 따라 확인합니다.

연동 설정
---
#### 공지 초기화:
	
공지 모듈은 별도로 초기화 작업을 진행하지 않고 MSDK만 초기화하면 됩니다.**만약 게임이 모바일QQ 혹은 위챗 플랫폼에만 연동하면 초기화 진행 시(onCreate) 해당한 플랫폼의 appid만 설정하고 다른 게임과 다른 플랫폼의 appid를 입력하지 않습니다. 아닐 경우 게임 로그인 전 공지를 실행하지 못하게 됩니다. **

#### 공지 AndroidMainfest 설정:

이부분 내용은 주로 MSDK 공지 화면과 관련된 권한 설정입니다.

	<!-- TODO Notice 공지 설정 START -->
    <!--  MSDK팝업 공지 관련 설정 -->
   	<activity
       	android:name="com.tencent.msdk.notice.AlertMsgActivity"
       	android:configChanges="orientation|screenSize|keyboardHidden"
       	android:screenOrientation="sensor"
       	android:theme="@style/NoticeAlertTheme" >
    </activity>
	<!--  MSDK롤링 공지 관련 설정 -->
    <service android:name="com.tencent.msdk.notice.RollFloatService" >
    </service>
    <!-- TODO Notice 공지 설정  END -->
	
**비고: 게임은 스크린 방향에 따라 공지 activity의 스크린 방향을 설정할 수 있습니다.(android:screenOrientation 값)**

스위치 설정
---
게임은 MSDK에서 제공하는 스위치를 이용하여 MSDK 공지 실행 여부 및 공지를 실행하는 시간 빈도를 제어할 수 있습니다.
#### 공지 사용 여부
	
공지 모듈은 기본적으로 Off상태입니다. 공지 모듈을 사용할 게임은 assets/msdkconfig.ini에서 needNotice 값을 true로 설정하여야 합니다.
#### 공지의 특정 실행 시간 설정

공지 모듈의 자동 실행 시간은 기본적으로 10분입니다. 게임에서 수요에 따라 assets/msdkconfig.ini에서 noticeTime 값을 해당한 시간으로 설정할 수 있습니다.**(설정 가능한 최소 실행 시간은 5분)**

##공지 표시 인터페이스

WGShowNotice를 호출하면 MSDK에서 설정한 화면을 사용하여 현재 유효한 공지를 표시합니다. 팝업 공지는 이동 링크 추가 여부도 설정할 수 있습니다. 이동 연결이 있는 공지는 세부 정보를 클릭하면 MSDK 내장 브라우저를 실행하여 해당한 URL을 방문할 수 있습니다.

#### 인터페이스 설명:
	
	/**
	 * 해당한 유형의 지정된 공지탭 공지를 표시합니다.
	 * @param scene 공지탭ID,빈칸 불가. 이 파라미터는 공지 관리단의“공지탭”설정과 대응됩니다.
	 */

  	void WGShowNotice(unsigned char *scene);

#### 인터페이스 호출:

	String sceneString = "1";
	WGPlatform.WGShowNotice(sceneString);
	
#### 주의사항:
1. 인터페이스 호출 시 사용한 공지탭id(scene)는 공지 관리단에서 **설정한 “공지탭” ID와 대응됩니다. 공지ID(msgid)로 공지탭ID를 대체할 수 없습니다**	
2. 2.4.0부터 인터페이스를 튜닝하였으므로 2.4.0 이전 버전을 연동한 게임은 아래 인터페이스 파일을 참조 바랍니다.
	
###기존 공지 표시 인터페이스(이 인터페이스는 2.4.0부터 사용되지 않고 [공지 데이터 표시 인터페이스](notice.md#공지 표시 인터페이스)로 변경하여 사용)

WGShowNotice를 호출하면 MSDK에서 설정한 화면을 사용하여 현재 유효한 공지를 표시합니다. 팝업 공지는 이동 링크 추가 여부도 설정할 수 있습니다. 이동 연결이 있는 공지는 세부 정보를 클릭하면 MSDK 내장 브라우저를 실행하여 해당한 URL을 방문할 수 있습니다.

#### 인터페이스 설명:
	 	/** 	 * 해당한 유형의 지정된 공지탭의 공지를 표시합니다. 	 * @param type   표시할 공지 유형 	 * 	  eMSG_NOTICETYPE_ALERT: 팝업 공지 	 * 	  eMSG_NOTICETYPE_SCROLL: 롤링 공지 	 * 	  eMSG_NOTICETYPE_ALL: 팝업 공지&&롤링 공지 	 * @param scene 공지탭ID,빈칸 불가. 이 파라미터는 공지 관리단의 “공지탭” 설정과 대응됩니다. 	 */
   	void WGShowNotice(eMSG_NOTICETYPE type, unsigned char *scene);
 #### 인터페이스 호출:
 	eMSG_NOTICETYPE noticeTypeID = eMSG_NOTICETYPE.eMSG_NOTICETYPE_ALERT;
	String sceneString = "1";
	WGPlatform.WGShowNotice(noticeTypeID, sceneString);
	
#### 주의사항:
인터페이스 호출 시 사용한 공지탭id(scene)은 공지 관리단에서 **설정한 “공지탭” ID와 대응됩니다. 공지ID(msgid)로 공지탭ID를 대체할 수 없습니다**  롤링 공지 인터페이스 숨기기
---

WGHideScrollNotice를 호출하면 표시 중인 롤링 공지를 감춥니다.

#### 인터페이스 설명:

	/** 	 * 표시 중인 롤링 공지를 감춤 	 */

	 void WGHideScrollNotice();  #### 인터페이스 호출:

	WGPlatform.WGHideScrollNotice(); 
## 공지 데이터 획득 인터페이스

WGGetNoticeData를 호출하면 지정된 유형의 현재 유효한 공지 데이터 리스트를 반환
#### 인터페이스 설명:

	/**
	 * 로컬 데이터베이스에서 지정된 scene과 지정된 type에서의 현재 유효 공지 획득
	 * @param sence 이 파라미터는 공지 관리단 “공지탭”과 대응됩니다.
	 * @return NoticeInfo구조 배열, NoticeInfo 구조는 아래와 같습니다.
		typedef struct
		{
			std::string msg_id;			//공지 id
			std::string open_id;		//유저 open_id
			std::string msg_url;		//공지 이동 링크
			eMSG_NOTICETYPE msg_type;	//공지 유형, eMSG_NOTICETYPE
			std::string msg_scene;		//공지가 표시된 공지탭, 관리자 백그라운드에서 설정
			std::string start_time;		//공지 유효기 시작시간
			std::string end_time;		//공지 유효기 종료시간
			eMSG_CONTENTTYPE content_type;	//공지 내용 유형, eMSG_CONTENTTYPE

			//웹페이지 공지 특수 필드
			std::string content_url;     //웹페이지 공지 URL
			//이미지 공지 특수 필드
			std::vector<PicInfo> picArray;    //이미지 배열
			//텍스트 공지 특수 필드
			std::string msg_title;		//공지 제목
			std::string msg_content;	//공지 내용
			}NoticeInfo;
	 */
		 
	 std::vector<NoticeInfo> WGGetNoticeData(unsigned char *scene);

#### 인터페이스 호출:
	
	String sceneString = "1";
	Vector<NoticeInfo> noticeInfos = new Vector<NoticeInfo>();
    noticeInfos = WGPlatform.WGGetNoticeData(sceneString);

#### 주의사항:
1. 인터페이스 호출 시 사용한 공지탭id(scene)는 공지 관리단에서 **설정한 “공지탭” ID와 대응됩니다. 공지ID(msgid)로 공지탭ID를 대체할 수 없습니다.**   
2. **2.4.0부터 인터페이스를 튜닝하였으므로 2.4.0 이전 버전을 연동한 게임은 아래 인터페이스 파일을 참조 바랍니다.**   

###기존 공지 데이터 획득 인터페이스(이 인터페이스는 2.4.0부터 사용되지 않고 [공지 데이터 획득 인터페이스](notice.md#공지 데이터 획득 인터페이스)로 변경하여 사용)

WGGetNoticeData를 호출하면 지정된 유형의 현재 유효한 공지 데이터 리스트를 반환
#### 인터페이스 설명:
 	/** 	 * 로컬 데이터베이스에서 지정된 scene과 지정된 type에서의 현재 유효 공지 획득 	 * @param type 표시할 공지 유형. 유형은 eMSG_NOTICETYPE, 구체 값: 	 * 	  eMSG_NOTICETYPE_ALERT: 팝업 공지 	 * 	  eMSG_NOTICETYPE_SCROLL: 롤링 공지 	 * @param sence 이 파라미터는 공지 관리단의 “공지탭”에 대응됩니다. 	 * @return NoticeInfo 구조 배열, NoticeInfo 구조는 아래와 같습니다. 		typedef struct 		{ 			std::string msg_id;			//공지 id 			std::string open_id;		//유저 open_id 			std::string msg_url;		//공지 이동 링크 			eMSG_NOTICETYPE msg_type;	//공지 유형, eMSG_NOTICETYPE 			std::string msg_scene;		//공지가 표시하는 공지탭, 관리자 백그라운드에서 설정 			std::string start_time;		//공지 유효기 시작시간 			std::string end_time;		//공지 유효기 종료시간 			eMSG_CONTENTTYPE content_type;	//공지 내용 유형, eMSG_CONTENTTYPE
 			//웹페이지 공지 특수 필드
			std::string content_url;     //웹페이지 공지URL 			//이미지 공지 특수 필드 			std::vector<PicInfo> picArray;    //이미지 배열 			//텍스트 공지 특수 필드 			std::string msg_title;		//공지 제목 			std::string msg_content;	//공지 내용 			}NoticeInfo; 	 */ 		  	 std::vector<NoticeInfo> WGGetNoticeData(eMSG_NOTICETYPE type,unsigned char *scene);
 #### 인터페이스 호출: 	
	eMSG_NOTICETYPE noticeTypeID = eMSG_NOTICETYPE.eMSG_NOTICETYPE_ALERT;
	String sceneString = "1"; 	Vector<NoticeInfo> noticeInfos = new Vector<NoticeInfo>();
    noticeInfos = WGPlatform.WGGetNoticeData(noticeTypeID, sceneString);
    
#### 주의사항:
인터페이스 호출 시 사용한 공지탭id(scene)는 공지 관리단에서 **설정한 “공지탭” ID와 대응됩니다. 공지ID(msgid)로 공지탭id를 대체할 수 없습니다.**          게임 공지 오류 검증 절차
---
 1. 공지 모듈 실행 여부:
 	**게임 assets/msdkconfig.ini 중 needNotice 값이 true인지 확인. 아닐 경우 true로 변경 후 디버깅. 맞을 경우 다음 검증 진행**검증 방법: 
 	- MSDK 로그 확인. 아래 한 줄 로그가 있으면 공지 모듈이 닫김 상태에 있음을 표시
	
			WeGame NoticeManager.init	 notice module is closed!  		아래 로그가 있으면 공지 모듈이 ON상태임을 표시:   			WeGame NoticeManager.init	 notice module init start!  	- 게임 패키지를 디컴파일한 후 assets 디렉토리에서 msdkconfig.ini 파일을 찾아 needNotice 설정 여부를 검증하고 needNotice 값이 true인지 확인

- 인터페이스 호출에 유효 내용이 있는 지 확인:

	**MSDK 로그를 검증하고 인터페이스 호출 로그에 공지가 있는 지 확인. 0이 아니면 MSDK 관련 개발자한테 확인. 0이면 다음 검증 진행.**검증 방법: 

	MSDK 로그에서 **noticeVector size* 값 확인: 

		WeGame NoticeDBModel.getNoticeRecordBySceneAndType	 query result:0
		WeGame NoticeManager.getNoticeFromDBBySceneAndType	 noticeVector size:0

- 공지를 획득한 appid 정확 여부 검증:

	**MSDK 로그를 검증하여 공지 획득시 appid가 정확한 지 확인. 로그인 전 공지는 모바일QQ와 위챗 appid의 조합이고 로그인 후 공지는 대응하는 플랫폼 appid이다. 정확하지 않으면 초기화하는 곳에서 수정한 후 다시 시도. 정확하면 다음 검증 진행.**검증 방법:

	MSDK 로그에서 **NoticeManager.getNoticeInfo** 호출시 appid 값을 확인한 후 dev 백그라운드와 공지 요청 시간(로그인 여부)과 대조 비교하여 정확한 지 확인.**특히 단일 플랫폼에 액세스한 게임이 임의로 다른 플랫폼 정보를 입력하여 공지 획득 실패를 초래하는 경우가 종종 발생한다**: 

		WeGame NoticeManager.getNoticeInfo	 appid: 100703379|wxcde873f99466f74a;openid:
		WeGame NoticeManager.getNoticeInfo	 Notice Model:mat_id may be null:860463020910104;mMatId:860463020910104
- 공지가 관리자에서 클라이언트에 발송되었는지 확인:

	**게임 로컬 데이터를 제거한 후 게임을 다시 실행하고 MSDK 로그를 확인하여 백그라운드에서 보낸 공지 리스트가 설정된 공지를 포함했는 지 확인한다. 없으면 MSDK 백그라운드를 찾아 확인하고, 있으면 다음 절차 진행.**검증 방법:
	
	MSDK 로그에서 /notice/gather_data/ 요청의 리턴 내용 확인. 다음은 사례:
		
		strResult:{"appid":"100703379|wxcde873f99466f74a","invalidMsgid":[{"invalidMsgid":"499"},{"invalidMsgid":"500"},{"invalidMsgid":"483"},{"invalidMsgid":"509"},{"invalidMsgid":"513"}],"list":[{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403614800","contentType":2,"contentUrl":"http://www.qq.com","endTime":"1412168400","msgContent":"","msgUrl":"http://www.baidu.com","msgid":"528","noticeType":0,"openid":"","picUrlList":[],"scene":"10","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403614800","contentType":1,"contentUrl":"","endTime":"1412168400","msgContent":"","msgUrl":"","msgid":"527","noticeType":0,"openid":"","picUrlList":[{"hashValue":"7a7ac418fb79917875cfd80c81ee4768","picUrl":"http://img.msdk.qq.com/notice/527/20140624211729_610X900.jpg","screenDir":1},{"hashValue":"2243f401734483f09ceeffd86006262d","picUrl":"http://img.msdk.qq.com/notice/527/20140624211739_1080X440.jpg","screenDir":2}],"scene":"10","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403573435","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"& &&호환성 테스트 용례,2& && 특수 문자 관련","msgUrl":"","msgid":"490","noticeType":0,"openid":"","picUrlList":[],"scene":"10","title":"& &&호환테스트2&"},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"롤링 공지를 설정할 때 줄바꿈을 입력하지 못한다. 왜일까?\r\n\r\n","msgUrl":"","msgid":"491","noticeType":1,"openid":"","picUrlList":[],"scene":"11","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"아래는 줄바꿈\r\n줄바꿈 하나,\r\n줄바꿈 둘\r\n아이구, 또 하나가 있네\r\n그래, 더는 없을거야\r\n헐, 아직도 있다니\r\n이건 진짜 마지막일거야","msgUrl":"","msgid":"492","noticeType":0,"openid":"","picUrlList":[],"scene":"10","title":"줄바꿈 테스트"},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"아래는 줄바꿈\r\n줄바꿈 하나,\r\n줄바꿈 둘\r\n아이구, 또 하나가 있네\r\n그래, 더는 없을거야\r\n헐, 아직도 있다니\r\n이건 진짜 마지막일거야\r\n세부정보를 클릭하면 이동해야지, 뛰어\r\n","msgUrl":"http://im.qq.com","msgid":"493","noticeType":0,"openid":"","picUrlList":[],"scene":"10","title":"줄바꿈+이동 테스트"},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"롤롤링 공지를 설정할 때 줄바꿈을 입력하지 못한다. 왜일까?\r\n\r\n","msgUrl":"","msgid":"494","noticeType":1,"openid":"","picUrlList":[],"scene":"11","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1396575095","contentType":0,"contentUrl":"","endTime":"1412127095","msgContent":"& &&호환성 테스트 용례,2& && 특수 문자 관련*&……￥%……@#——+()？》《, 나는 롤링 공지 표시줄에 있어야 한다. 내 옆에는 다른 롤링 공지가 있어야 한다. 내 앞에 있을까 뒤에 있을까? ","msgUrl":"","msgid":"495","noticeType":1,"openid":"","picUrlList":[],"scene":"11","title":""},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403229600","contentType":0,"contentUrl":"","endTime":"1404011100","msgContent":"모든 유저에게 이동이 있는 공지 발송, 종료 시간이 현재 시각에 매우 가까움","msgUrl":"http://www.qq.com","msgid":"487","noticeType":0,"openid":"","picUrlList":[],"scene":"1","title":"종료 시간, 이동"},{"appid":"100703379|wxcde873f99466f74a","beginTime":"1403748000","contentType":0,"contentUrl":"","endTime":"1403834400","msgContent":"위챗+모바일QQ+android+롤링","msgUrl":"","msgid":"514","noticeType":1,"openid":"","picUrlList":[],"scene":"4","title":""}],"msg":"success","ret":0,"sendTime":"1403777179"}

	이곳은 모든 공지 내용을 포함한다. 게임은 백그라운드에서 설정한 공지 id 등을 이용하여 검색 범위를 축소하여 공지가 발송되었는 지 확인한다.
		
- 공지가 로컬 시간의 유효기간에 있는 지 검증: 

	**MSDK 로그를 검증하여 공지 표시 시각의 로컬 시간을 확인합니다. 로컬 시간이 공지 유효기간에 없을 경우 로컬 시간을 수정한 후 다시 디버깅합니다. 로컬 시간이 유효기간에 있을 경우 다음 절차를 진행합니다. **검증 방법:

	위 절차에서 공지의 시작 시간과 종료 시간 등 관련 정보를 찾은 후 MSDK 로그에서 NoticeDBModel.getNoticeRecordBySceneAndType 호출 시 currentTimeStamp 값을 확인합니다.

		WeGame MsdkThreadManager.showNoticeByScene	 showNotice
		WeGame NoticeManager.setAppinfo	 mAppId: wxcde873f99466f74a;mOpenId:oGRTijsKcz0dOi__dwJTZmINGfx0
		WeGame NoticeDBModel.getNoticeRecordBySceneAndType	 appId:wxcde873f99466f74a,openid:oGRTijsKcz0dOi__dwJTZmINGfx0,scene:10,noticetype:eMSG_NOTICETYPE_ALERT,currentTimeStamp:1403835077
		WeGame NoticeDBModel.getNoticeRecordBySceneAndType	 query result:5
		
	공지 획득 시간과 로컬 시간을 대조하여 로컬 시간이 공지 유효기간에 있는 지 확인(공지 시작과 종료 시간 구간 내)합니다.
	
- 인터페이스 호출 파라미터가 정확한 지 검증

	**MSDK 로그와 게임이 공지 관리단에서의 설정을 대조하여 공지 인터페이스가 호출한 설정이 백그라운드와 일치한 지 확인합니다. 일치하지 않을 경우 수정 후 디버깅하며 일치할 경우 다음 절차를 진행합니다.**검증 방법:

	MSDK 로그에서 아래와 유사한 로그를 확인합니다.

		WeGame NoticeDBModel.getNoticeRecordBySceneAndType	 appId:100703379|wxcde873f99466f74a,openid:,scene:11,noticetype:eMSG_NOTICETYPE_SCROLL,currentTimeStamp:1409632268

	공지 호출시 전달한 scene 값과 noticetype에서 게임 공지 관리단에 설정한 것과 일치한 지 확인합니다. **특히 scene 값은 관리단에서 설정한 공지탭id와 대응되어야 합니다.**
	
- 게임의 appid 설정 정확 여부 검증

	**게임이 onCreate에서 설정한 appid와 dev 플랫폼에서 등록한 것이 일치한 지 확인합니다. 일치하지 않을 경우 수정한 후 다시 디버깅하고 일치할 경우 MSDK 개발자한테 문의 바랍니다.**

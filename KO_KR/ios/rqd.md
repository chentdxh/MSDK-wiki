MSDK Crash보고 모듈
===
개요
---
Crash보고는 MSDK2.6.1i이전 버전에서 （MSDK2.6.1i포함되지 않음)RQD보고를 사용하고 보고 성공한 후 crash상세 스택 내용은  http://rdm.wsd.com/ 에만 볼 수 있다. 그리고 텐센트 직원이 RTX로 로그인 해야 볼 수 있으며 제체 개발 게임이 아닐 경우 확인하기 여럽다.MSDK2.6.1i버전부터 bugly보고를 사용하며 이때는 관련 정보를  http://bugly.qq.com/ 에서 볼 수 있다. QQ계정을 사용하여 관련 앱과 바인딩을 해서 비 자체 개발 게임여도 편하게 확인할 수 있다.물론  http://rdm.wsd.com/ 에서도 확인 가능하며 게임은 별도의 조작이 필요없다.

보고 스위치 설정
---
데이터 보고 오픈 및 닫기에 관련 설정 함수:

     public static void WGEnableCrashReport(boolean bRdmEnable, boolean bMtaEnable)

WGPlatform에서 해당 함수가 있고 bRdmEnable를 false로 설정하면（bMtaEnable는 false로 설정 가능）rdm crash보고 기능을 닫는다.



RDM플랫폼에서 Crash데이터 보기
---
####가입 및 바인딩

DEV 가입한 게임은 자동으로 RDM에 가입되며 수동으로 가입 불필요; 수동으로 가입해야 할 경우, 직접 RDM에 로그인 하여 비정상 보고 모듈을 클릭해서 게임 BoundID 를 설정하면 된다.

스텝：[http://rdm.wsd.com/](http://rdm.wsd.com/),에 로그인하여 해당 게임으로 이동 -> 비정상 데이터  보고，가입되지 않았을 경우에 아래와 같은 알림 창이 노출：

![rdmregister](./rmdregister.png)

그 중에，boundID 는 AndroidManifest에 있는 packageName이다. 가입되지 않은 게임일 경우, 보고시 관련 데이터 분실.

구체적 내용은 rdm비서에게 문의 가능하며 android문제는 spiritchen에게 문의할 수 있다.

####보고 데이터 획인하는 방법
- 사이트 주소:[http://rdm.wsd.com/](http://rdm.wsd.com/)->비정상 데이터 보고->문제점 리스트

![rdmwsd](./rdmwsd.png)
![rdmdetail](./rdmdetail.png)


bugly플랫폼에서 Crash데이터 보기
---
- 사이트 주소:[http://rdm.wsd.com/](http://rdm.wsd.com/)->QQ계정으로 로그인->해당 App선택

![bugly](./bugly1.png)

Crash보고에 별도 업무 로그 추가
---

프로그램이 Crash발생시 때로는 별도의 업무 로그가 필요한다. 관련 업무 로그가 crash로그와 함계http://rdm.wsd.com/ 플랫폼으로 보고하여 crash발생 원인을 확인하는 데 도움이 된다. 최종으로 rdm플랫폼에서 에러 상세 내역을 확인할 수 있다.

![rqd](./rqd_extramsg.png)

해당 기능을 구현하려면 전반 observer에서 콜뱍함수 OnCrashExtMessageNotify를 추가하면 된다：

    std::string MyObserver::OnCrashExtMessageNotify()
	{
    	return "dsafdasfsafdasdfasdf";
	}


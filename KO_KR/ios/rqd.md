MSDK Crash전송 모듈
===
개요
---
Crash전송은 MSDK2.6.1i이전 버전에서 （MSDK2.6.1i포함되지 않음)RQD전송를 사용하고 전송 완료 후 crash상세한 스택은  http://rdm.wsd.com/ 에서만 확인할 수 있습니다. 또한 텐센트 직원이 RTX로 로그인하여야만 확인할 수 있어 퍼블리싱 게임은 확인하는데 많은 불편함이 있었습니다. MSDK2.5 및 이후 버전에서는 bugly전송을 사용하며  http://bugly.qq.com/ 에서 해당 정보를 확인할 수 있습니다. 또한 QQ계정으로 해당 앱을 바인딩할 수 있어 퍼블리싱 게임도 쉽게 확인할 수 있게 되었습니다. 물론 http://rdm.wsd.com/ 에서도 여전히 확인할 수 있니다다. 게임에서 별도의 조작이 필요 없으며 Crash데이터 전송 스위치를 닫을 뿐입니다. 상세 내용은 **RQD전송 스위치 설정**과**Bugly전송 스위치 설정**을 참조 바랍니다..

전송 스위치 설정
---
데이터 전송 on/off 설정 함수:

     public static void WGEnableCrashReport(boolean bRdmEnable, boolean bMtaEnable)

WGPlatform에서 해당 함수가 있으며 bRdmEnable를 false로 설정하면（bMtaEnable는 false로 설정 가능）rdm crash전송을 off할 수 있습니다.



RDM플랫폼에서 Crash데이터 확인
---
####등록 바인딩

DEV 등록 게임은 자동으로 RDM에 등록되므로 수동으로 등록할 필요가 없습니다. 수동 등록은 직접 RDM에 로그인 하여 에러 전송 모듈을 클릭하고 게임 BoundID 를 설정하면 됩니다.

스텝：[http://rdm.wsd.com/](http://rdm.wsd.com/)에 로그인 후 게임 선택 -> 에러 전송 선택.등록되지 않았으면 아래와 같은 안내 메세지가 출력됩니다.

![rdmregister](./rmdregister.png)

그 중 boundID 는 AndroidManifest에 있는 packageName입니다. 등록하지 않은 게임일 경우 데이터 전송시 데이터가 분실됩니다.

자세한 내용은 운영팀을 통하여 rdm 도우미한테 문의 바랍니다.

####전송 데이터 획인 방법
- 사이트:[http://rdm.wsd.com/](http://rdm.wsd.com/)->에러 전송->문제 리스트

![rdmwsd](./rdmwsd.png)
![rdmdetail](./rdmdetail.png)


bugly플랫폼에서 Crash데이터 확인
---
- 사이트:[http://rdm.wsd.com/](http://rdm.wsd.com/)->QQ계정으로 로그인->해당 App을 선택합니다.

![bugly](./bugly1.png)

Crash전송에 별도 업무 로그 추가
---

프로그램이 Crash 발생 시 별도의 업무 로그를 추가하여 crash로그와 함계http://rdm.wsd.com/ 플랫폼으로 전송하여야 합니다.이럴 경우 보다 쉽게 crash원인을 파악할 수 있고 rdm플랫폼에서 에러 상세 내역을 확인할 수 있습니다.

![rqd](./rqd_extramsg.png)

해당 기능을 구현하려면 전반 observer에서 콜백 함수 OnCrashExtMessageNotify를 추가하면 됩니다.

    std::string MyObserver::OnCrashExtMessageNotify()
	{
    	return "dsafdasfsafdasdfasdf";
	}


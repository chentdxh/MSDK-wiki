MSDK Crash데이터 전송 모듈
===
개요
---
Crash데이터 전송은 MSDK2.5a이전 버전（MSDK2.5a 불포함)에서는 RQD전송을 사용하며 전송 성공 완료 후  crash 상세한 스택은  http://rdm.wsd.com/ 에서만 확인할 수 있습니다. 또한 텐센트 직원이 RTX로 로그인하여야만 확인할 수 있어 퍼블리싱 게임은 확인하는데 많은 불편함이 있었습니다. MSDK2.5 및 이후 버전에서는 bugly전송을 사용하며  http://bugly.qq.com/ 에서 해당 정보를 확인할 수 있습니다. 또한 QQ계정으로 해당 앱을 바인딩할 수 있어 퍼블리싱 게임도 쉽게 확인할 수 있게 되었습니다. 물론 http://rdm.wsd.com/ 에서도 여전히 확인할 수 있니다다. 게임에서 별도의 조작이 필요 없으며 Crash데이터 전송 스위치를 닫을 뿐입니다. 상세 내용은 **RQD전송 스위치 설정**과**Bugly전송 스위치 설정**을 참조 바랍니다.

RQD전송 스위치 설정
---
rdm 데이터 전송 on/off 설정 함수:

     public static void WGEnableCrashReport(boolean bRdmEnable, boolean bMtaEnable)

WGPlatform에 이 함수가 있으며 bRdmEnable을 false(bMtaEnable은 false로 설정 가능）로 설정하면 rdm crash 전송를 off합니다. crash 전송은 디폴트로 오픈되어 있으므로 이 함수를 호출할 필요가 없습니다.

Bugly전송 스위치 설정
---
bugly전송 스위치 on/off는 /assets/msdkconfig.ini에서 설정 필요

      ;bugly전송 스위치 off하면 디폴트로 false로 설정되고，true로 설정하면 Crash데이터 전송 기능 off합니다.
      CLOSE_BUGLY_REPORT=false



RDM플랫폼에서 Crash데이터 확인
---
####등록 바인딩

DEV 등록 게임은 자동으로 RDM을 등록하므로 수동으로 등록할 필요가 없습니다. 수동 등록은 직접 RDM에 로그인하여 에러 전송 모듈을 클릭하고 게임의 BoundID를 설정하면 됩니다.

스텝: [http://rdm.wsd.com/](http://rdm.wsd.com/) 로그인 후 게임 선택 -> 에러 전송 선택. 등록되지 않았으면 아래와 같은 안내 메세지가 출력됩니다.

![rdmregister](./rmdregister.png)

그중 boundID는 게임 자체의 AndroidManifest중 packageName 입니다. 등록하지 않은 게임일 경우 데이터 전송 시 데이터가 분실됩니다.

자세한 내용은 운영팀을 통하여 rdm 도우미한테 문의 바랍니다.

####전송 데이터 확인 방법
- 사이트:[http://rdm.wsd.com/](http://rdm.wsd.com/)->에러 전송->문제 리스트

![rdmwsd](./rdmwsd.png)
![rdmdetail](./rdmdetail.png)


bugly플랫폼에서 Crash데이터 확인
---
- 사이트:[http://rdm.wsd.com/](http://rdm.wsd.com/)->QQ계정으로 로그인->해당 App를 선택합니다.

![bugly](./bugly1.png)

Crash 전송에 별도 업무 로그 추가
---

프로그램이 Crash발생 시 별도의 업무 로그를 추가하여 crash로그와 함께 http://rdm.wsd.com/ 플랫폼으로 전송하여야 합니다.이럴 경우 보다 쉽게 crash원인을 파악할 수 있고 rdm플랫폼에서 에러 상세 내역을 확인할 수 있습니다. 그 중 별도의 업무 로그는 extraMessage.txt파일에 저장됩니다. 현재 bugly는 extraMessage.txt 확인 기능을 오픈하지 않았으며 현재 기능 개발중입니다.

![rqd](./rqd_extramsg.png)

해당 기능을 완료하려면 전반observer(즉WGPlatformObserver)에서 콜백 함수OnCrashExtMessageNotify를 추가하여야 합니다. java는 아래 방식대로 호출합니다.

    @Override
    public String OnCrashExtMessageNotify() {
      // 여기에 crash 시 별도 정보를 추가하여 crash발생 원인을 분석하는 데 사용됩니다.
      // 예를 들어，String str = "test extra crash upload!";
      // 필요 없을 경우 String str = ""를 기입
      String str = "test extra crash upload!";
      return str;
    }

cpp는 아래 방식으로 호출합니다.

    virtual std::string OnCrashExtMessageNotify() {
    	// 여기에 crash 시 별도 정보를 추가하여 crash발생 원인을 분석하는 데 사용됩니다.
    	// 예를 들어，std::string str = "test extra crash upload!";
    	// 필요 없을 경우std::string str = ""를 기입
    	std::string str = "test extra crash upload!";
    	LOGD("OnCrashExtMessageNotify test %s", str.c_str());
    	return str;
    }


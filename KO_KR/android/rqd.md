MSDK Crash보고 모듈
===
개요
---
Crash보고는 MSDK2.5a이전 버전（MSDK2.5a 포함하지 않는다)에서 RQD보고를 사용하며，보고 성공한 후 구체적 crash상세한 스택은  http://rdm.wsd.com/ 에서 볼 수 있다. 텐센트 직원이 RTX로 로그인해서야 볼 수 있다.자체개발 게임 아닐 경우 보기 불편하다.MSDK2.5 및 이후 버전에는 bugly보고를 사용해서  http://bugly.qq.com/ 에서 해당 정보를 볼 수 있다. QQ계정으로 관련 앱을 바인딩을 하여 비자체개발 게임여도 편하게 볼 수 있다.물론, http://rdm.wsd.com/ 에서도 여전히 볼 수 있다.게임은 별도의 조작 필요없고 crash보고 닫는 스위치가 다를 뿐이다. 상세 내역은 **RQD보고의 스위치 설정上**과**Bugly보고의 스의치 설정**을 참고.

RQD보고 스위치 설정
---
rdm 데이터 보고 on/off 설정 함수:

     public static void WGEnableCrashReport(boolean bRdmEnable, boolean bMtaEnable)

WGPlatform에 이 함수가 있다. bRdmEnable을 false(bMtaEnable은 false로 설정 가능）로 설정하면 rdm crash 보고를 종료한다. crash 보고는 기본적으로 열려있기에 이 함수를 호출할 필요가 없다.

Bugly보고 스위치 설정
---
bugly보고 스위치 on/off는 /assets/msdkconfig.ini에서 설정 필요

      ;bugly보고 스의치 off하면 디폴트로 false로 설정되고，true로 설정하면 즉 crash보고 기능 닫는다.
      CLOSE_BUGLY_REPORT=false



RDM플랫폼에서 Crash데이터 보기
---
####등록 바인딩

DEV 등록 게임은 자동으로 RDM을 등록하기에 수동으로 등록할 필요가 없다. 수동 등록은 직접 RDM에 로그인하여 이상보고 모듈을 클릭하고 제품  BoundID를 설정하면 된다.

절차: [http://rdm.wsd.com/](http://rdm.wsd.com/) 로그인, 자신의 제품 -> 이상보고 선택. 등록되지 않았으면 그림처럼 경고를 준다:

![rdmregister](./rmdregister.png)

그중, boundID는 자신의 AndroidManifest 중 packageName이다. 등록되지 않은 제품은 데이터 보고시 바로 버려진다.

자세한 내용은 rdm 도우미에게 문의, android 문제는 spiritchen와 연락하면 된다

####보고 데이터를 보려면
- 웹주소:[http://rdm.wsd.com/](http://rdm.wsd.com/)->이상보고->문제리스트

![rdmwsd](./rdmwsd.png)
![rdmdetail](./rdmdetail.png)


bugly플랫폼에서 Crash데이터 보기
---
- 사이트 주소:[http://rdm.wsd.com/](http://rdm.wsd.com/)->QQ계정으로 로그인->해당 App를 선택한다.

![bugly](./bugly1.png)

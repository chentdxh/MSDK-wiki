MSDK RQD(RDM) 관련 모듈
===


RQD 보고 스위치 설정
---
rdm 데이터 보고 on/off 설정 함수:

     public static void WGEnableCrashReport(boolean bRdmEnable, boolean bMtaEnable)

WGPlatform에 이 함수가 있다. bRdmEnable을 false(bMtaEnable은 false로 설정 가능）로 설정하면 rdm crash 보고를 종료한다. crash 보고는 기본적으로 열려있기에 이 함수를 호출할 필요가 없다.

Crash 데이터 보고 조회
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

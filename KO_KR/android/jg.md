JG 심사
==============

## 개요

MSDK는 버전 출시 전에 JG심사를 진행하여 현재 버전 버그 존재 여부를 확인 후 공식 출시합니다. 하지만 신규  버그가 발견됨에 따라 게임에서 MSDK 오래전 버전을 연동할 경우 여러 버그가 발생합니다. 하여  MSDK개발팀은 JG심사팀과 논의한 결과 공식 출시된 버전에서 발견된 버그는 통일적으로 정리 후 최종 해결안을 제공하도록 하였습니다.

## QMI 네트워크 전송 보안 버그

![jg](./jgp1.png)

####MSDK수정 제안：MSDK버전을 2.3.2a 및 그 이상 버전으로 업데이트

## openSDK 로컬 서비스 제공 거부 버그

![jg](./jgp2.png)

####MSDK수정 제안：MSDK버전을 2.6.0a 및 그 이상 버전으로 업데이트

## MSDK 시스템 모듈 로컬 서비스 제공 거부 버그

![jg](./jgp3.png)

####MSDK수정 제안：MSDK버전을 2.6.1a 및 그 이상 버전으로 업데이트

## Midas 통용 서비스 거부 버그

![jg](./jgp4.png)

####MSDK수정 제안：Midas를 1.3.9b 및 그 이상 버전으로 업데이트（해당 MSDK 2.4.0a 및 그 이상 버전）

## MSDK Web 모듈 원거리 코드 실행 버그

![jg](./jg_msdk_webview.png)

####MSDK수정 제안：MSDK버전을 2.6.0a 및 그 이상 버전으로 업데이트


## Open SDK Web 모듈 원거리 코드 실행 버그

![jg](./jg_opensdk_web.png)

####MSDK수정 제안：MSDK버전을 2.6.0a 및 그 이상 버전으로 업데이트

## Midas 시스템 모듈 로컬 서비스 거부 버그 

![jg](./jg_midas_locaoservice_1.png)

![jg](./jg_midas_locaoservice_2.png)

####MSDK수정 제안：Midas버전을 1.3.9.e 및 그 이상 버전으로 업데이트 

## PUSH 서비스 거부 버그

![jg](./jg_tpush_localservices.png)

####MSDK수정 제안：해당 가입 코드 삭제해 주시기 바랍니다. 게임이 AndroidManifest.xml에서 ForwardActivity 가입할 필요 없습니다.

## XG 푸시 Intent 프로토콜 해석 월권 버그

![jg](./jg_tpush_intent.png)

####MSDK수정 제안：해당 이슈를 JG White List에 추가되었으니 버그 경고가 없을 것입니다.

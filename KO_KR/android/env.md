개발 환경 설정
===

개요
---

이 부분의 내용은 게임을 도와 개발 환경과 관련된 일부 설정을 명확히 할 수 있다.

C++ 컴파일 설정
---
#### 개요:

MSDK의 C++ 인터페이스는 JNI를 통해 구현된다. MSDK의 C++ 인터페이스를 사용하는 게임은 통합 시 NDK를 이용하여 컴파일해야 하며 MSDK은 직접 게임에 소스 코드 컴파일을 제공한다. 게임은 MSDK가 제공하는 NDK 환경 설정과 컴파일 완료 사례를 참조하여 수정할 수 있다.

#### Eclipse 환경 설정:

**window -> preferences -> Android -> NDK** 선택, 아래 그림에 따라 설정

![NDK설정](./ndk.png "ndk 설정")

비고: 최신 adt 버전(adt-bundle-windows-x86-20140702)은 ndk를 통합하지 않아 게임은 Android 옵션에서 상기 설정을 보지 못할 수 있다. 해결방법:

1. eclipse의 ndk 관련 플로그인 다운로드[com.android.ide.eclipse.ndk_23.0.2.1259578.jar](https://github.com/bihe0832/Settings-Tools/tree/master/adt/plugins)
2. 내려받은 `com.android.ide.eclipse.ndk_23.0.2.1259578.jar`를 dt 디렉토리의 `\eclipse\plugins`에 넣은 후 eclipse 재실행.

#### 코드 도입:

게임은 `MSDKLibrary/jni` 디렉토리의 .cpp와 .h 파일을 복사하여 게임 프로젝트에 붙여 넣어야 한다

#### makefile 설정:

게임은 코드를 도입한 후 동시에 관련 코드를 makefile에 추가해야 한다. 게임은 실제 상황에 맞춰 `MSDKLibrary/jni`의 Android.mk 중 설정 정보를 게임의 makefile 파일 또는 Android.mk에 도입할 수 있다.


액세스 설정 자체 테스트
---

#### 개요:

게임 액세스 과정에서 개발자는 종종 MSDK의 demo 코드를 직접 copy/paste하여 일부 MSDK의 demo 관련 설정 내용을 게임 프로젝트에 붙여 넣어 오류를 초래할 수 있다. 때문에 MSDK는 내부 검사 모듈을 추가하여 게임 개발 과정에서 이 부분 기능을 이용하여 액세스 원가를 얼마간 절감할 수 있다.

####사용 방법: 

게임이 연결한 환경이 연동 테스트 또는 테스트 환경일 경우, MSDK는 초기화 시 검사 모듈을 배치하여 흔히 사용되는 일부 설정에 오류가 존재하는 지 검사한다. 게임은 logcat의 내용 확인을 통해 확인 가능: 

- **게임에 설정 오류가 존재하는 log 사례: **

		11-18 17:10:47.373: E/WeGame CheckBase.queryIntentFilter(9855): Msdk: the intent-filter of com.tencent.tauth.AuthActivity has not be configured correctly
		11-18 17:10:47.373: E/WeGame CheckBase.queryIntentFilter(9855): Msdk: the intent-filter of com.tencent.tauth.AuthActivity has not be configured correctly
		11-18 17:10:47.393: W/WeGame WeGame.Initialized(9855): MSDK Config Error!!!!
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): Check Result: 2
		11-18 17:10:47.403: D/WeGame WeGame.Initialized(9855):  ********************check result start********************
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): QQ AppID for Initialiezed must be the same as configed in AndroidMenifest.xml
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): AuthActivity Category Error
		11-18 17:10:47.403: D/WeGame WeGame.Initialized(9855):  ********************check result end**********************

- **게임 기본 설정에 문제가 없을 때 log 사례: **

		11-18 17:15:16.825: W/WeGame WeGame.Initialized(13524): Check Result: 0

#### 비고:

- 이 모듈의 검사 결과**게임 개발 참고용으로만 제공**, 모든 설정 검사는 강제 검사이며, 게임은 검사 결과와 게임 자체 수요에 따라 대응하는 설정 검사 항목의 내용을 수정한다. 게임은 모든 설정 검사 문제를 전부 해결할 필요가 없다.

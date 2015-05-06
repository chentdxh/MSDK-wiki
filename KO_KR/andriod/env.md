개발 환경 설정
===

개요
---

이 부분은 개발사를 도와 개발 환경 해당 설정을 명확히 하도록 준비하였습니다.

C++ 컴파일 설정
---
#### 개요:

MSDK의 C++ 인터페이스는 JNI를 통하여 구현하며 MSDK의 C++ 인터페이스를 사용하는 게임은 통합 시 NDK로 컴파일하여야 합니다. MSDK은 직접 게임에 소스 코드 컴파일을 제공하며 게임은 MSDK가 제공하는 NDK 환경 설정과 컴파일 사례를 참고하여 수정할 수 있습니다.

#### Eclipse 환경 설정:

**window -> preferences -> Android -> NDK** 선택,아래와 같이 설정하면 되겠습니다.

![NDK설정](./ndk.png "ndk 설정")

비고: 최신 adt 버전(adt-bundle-windows-x86-20140702)은 ndk를 통합하지 않아 게임은 Android 옵션에서 상기 설정을 확인할 수 없으므로 해결방안은 아래와 같습니다.

1. eclipse의 ndk 관련 플로그인을 다운 [com.android.ide.eclipse.ndk_23.0.2.1259578.jar](https://github.com/bihe0832/Settings-Tools/tree/master/adt/plugins)
2. 다운 받은 `com.android.ide.eclipse.ndk_23.0.2.1259578.jar`를 dt 디렉토리의 `\eclipse\plugins`에 복사 후 eclipse를 재실행합니다.

#### 코드 복사:

게임은 `MSDKLibrary/jni` 디렉토리의 .cpp와 .h 파일을 게임 프로젝트에 복사해 넣습니다.

#### makefile 설정:

게임에서 코드를 복사 후 동시에 해당 코드를 makefile에 등록하여야 합니다. 게임은 실제 상황에 따라 `MSDKLibrary/jni`아래의 Android.mk 중 설정 정보를 게임의 makefile 파일 혹은 Android.mk에 복사합니다.


연동 설정 자체 검토
---

#### 개요:

게임 연동 과정에 흔히 MSDK의 demo 코드를 직접 Copy/Paste하여 일부 MSDK의 demo 관련 설정을 게임 프로젝트에 복사하는 오류가 발생합니다. 하여 MSDK에서 내부 검토 모듈을 추가하여 연동 비용을 절감할 수 있습니다.

####사용 방법: 

게임에서 연결한 환경이 연동 환경 혹은 테스트 환경일 경우 MSDK를 초기화 시 검증 모듈을 설정하여 흔히 사용하는 설정에 오류가 있는지 검증합니다. 게임은 logcat 내용을 통하여 확인할 수 있습니다. 

- **게임에 설정 오류가 있을 시의 log **

		11-18 17:10:47.373: E/WeGame CheckBase.queryIntentFilter(9855): Msdk: the intent-filter of com.tencent.tauth.AuthActivity has not be configured correctly
		11-18 17:10:47.373: E/WeGame CheckBase.queryIntentFilter(9855): Msdk: the intent-filter of com.tencent.tauth.AuthActivity has not be configured correctly
		11-18 17:10:47.393: W/WeGame WeGame.Initialized(9855): MSDK Config Error!!!!
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): Check Result: 2
		11-18 17:10:47.403: D/WeGame WeGame.Initialized(9855):  ********************check result start********************
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): QQ AppID for Initialiezed must be the same as configed in AndroidMenifest.xml
		11-18 17:10:47.403: W/WeGame WeGame.Initialized(9855): AuthActivity Category Error
		11-18 17:10:47.403: D/WeGame WeGame.Initialized(9855):  ********************check result end**********************

- **게임 기본 설정에 문제가 없을 시의 log **

		11-18 17:15:16.825: W/WeGame WeGame.Initialized(13524): Check Result: 0

#### 비고:

- 이 모듈의 검증결과는 **개발사에서 다만 참고용**으로 하면 됩니다. 하지만 모든 설정을 검증하여야 하며 게임은 검증결과와 자체 수요에 따라 해당하는 설정 검증 항목을 수정할 수 있습니다. 게임에서 모든 설정 검증 문제를 해결할 필요가 없습니다.

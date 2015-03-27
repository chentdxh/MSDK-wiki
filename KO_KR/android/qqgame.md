MSDK 게임로비 액세스 모듈
====================

# 게임로비

현재 게임이 로비에 연결하는 데는 두가지 경우가 있다.

- 첫째: 로비를 통해 게임을 시작하고 이때 로비 로그인 티켓이 달려있지 않는 경우

- 둘째: 로비를 통해 게임을 시작하는 동시에 유저가 로비에서 얻은 로그인 티켓을 가지고 게임에 입장하는 경우. 이때 로비 로그인 티켓은 게임내 유저 로그인 티켓을 직접 교체한다. 

## 비 로그인 상태로 게임 실행

만일 로비를 통해 게임을 실행하지만 로비 로그인 티켓이 필요하지 않으면 아래 방법을 통해 로비의 게임 실행을 차단할 수 있다.
게임의 `onCreate`와 `onNewIntent`에서 아래 방법을 이용하여 로비가 게임을 실행했는 지 판단한다. 로비가 게임을 실행했으면 `handleCallback`를 호출하지 않고 그렇지 않으면 `handleCallback`를 호출하여 다른 플랫폼의 게임 실행을 처리한다. 코드는 다음과 같다:

```
Intent intent = this.getIntent();
if (intent != null && intent.getExtras() != null) {
	Bundle b = intent.getExtras();
	Set<String> keys = b.keySet();
	if(keys.contains("KEY_START_FROM_HALL")){
    //게임 실행 플랫폼은 로비
	Logger.d("Wakeup Plantform is Hall");
} else {
	//게임 실행 플랫폼은 로비가 아님
	Logger.d("Wakeup Plantform is not Hall");
	WGPlatform.handleCallback(this.getIntent()); // 플롯폼 콜백 수신
}
```

## 로그인 상태로 게임 실행

게임이 QQ 게임로비에 액세스하려면 게임로비 입구(대응하는 텐센트 제품 인터페이스 담당자가 설정,[시스템 설정 링크] (http://mqqgameadmin4dev.3gqq.com/web_mqqgame_admin/crud_db_cobra_hall/dbbeans/index.jsp))를 우선 설정해야 한다.
게임로비 연동 테스트는 테스트 환경을 사용하기에 테스트 계정이 필요하다(대응하는 텐센트 제품 담당자가 신청, 테스트 계정 유형은 일반 테스트 계정이면 됨.[테스트 계정 신청 링크](http://ceshihao.ied.com)). 런칭 후 공식 환경을 사용하면 테스트 계정이 없이 게임로비를 통해 직접 로그인할 수 있다.
**주의:** 게임로비 액세스 설정시 인증 유형(auth_type) 을 ** 개방 플랫폼 Token (16)**으로 설정해야 한다. 아래 그림 참조:

![qqgame_1](./qqgame_1.jpg)

게임로비에 액세스하려면 우선 게임로비 입구가 있어 게임을 게임로비에 구성해야 한다. 이 작업은 게임로비 관련 담당자를 찾아 해결해야 한다. 게임이 로비에서 입구를 가진 후에는 로비에서 게임을 실행할 수 있다. 게임 실행 시 SDK는 게임에 필요한 티켓(OpenId+accessToken+paytoken)을 교환하여 로컬에 저장한다. 게임은 `OnWakeupNotify`를 받은 후 수신한 `WakeupRet`의 `platform` 필드에 근거하여 게임이 로비에서 실행되었는 지 판단한다. 로비에서 실행되었으면 `WGGetLoginRecord` 인터페이스를 호출하여 로컬에 저장된 로그인 티켓을 읽고 이런 티켓을 획득한 후 로그인을 완료할 수 있다.

### 액세스 설정

게임로비 액세스 설정 요구

```
<!—게임로비 액세스 앱은 다음의 intent-filter  start—를 추가할 수 없다>
<intent-filter>
	<action android:name="android.intent.action.MAIN" />
	<category android:name="android.intent.category.LAUNCHER" />
	</intent-filter>
<!—게임로비 액세스 앱은 이 intent-filter  end –를 추가할 수 없다>

```

입구 Activity(MSDKSample의 `MainActivity`과 대응)의 intent-filter 설정

```
<!—입구 Activity에서 다음의 intent-filter start – 추가>
<intent-filter>
	<!-- xxxxx 를 개발자 자신의 앱 패키지로 교체, 정확히 기입하지 않으면 실행되지 않는다.-->
    <action android:name="xxxxx" /> 
    <category android:name="android.intent.category.DEFAULT" />
</intent-filter>
<!—입구 Activity에서 이 intent-filter end --입력>
```

AndroidManifest.xml의 <application> 탭에서 아래 내용 추가

```
<!—로비 게임 액세스는 반드시 이 meta-data start –를 설정해야 한다>
<meta-data
    android:name="QQGameHallMark"
    android:value="QQGameHallMark" />
<meta-data
    android:name="QQGameHallAuthorVer"
	android:value="10000" />
<!—로비 게임 액세스는 반드시 이 meta-data end –를 설정해야 한다>
```

`QQGameHallAuthorVer` 중 10000은 액세스한 앱이 로비 플랫폼에서 가지는 버전 번호를 표시하며 버전 업데이트에 사용된다. 로비에서 버전을 업데이트할 때마다 이 값은 1씩 증가된다. 초기값은 10000으로 설정할 수 있으며 로비에서 버전 업데이트용으로 사용된다. 이 값은 `android:versionCode`와 충돌되지 않고 일치할 필요가 업지만 새로운 버전을 제출할 때마다 `android:versionCode`와 `QQGameHallAuthorVer` 값은 동시에 1을 증가해야 한다.

**주의:** 

1. 게임로비 액세스는 반드시 home버튼을 길게 누를 때 자신의 앱 아이콘이 나타나지 말아야 한다. 이 요구를 구현하려면 반드시 androidManifest.xml 파일의 모든 Activity的`android:launchMode`를 기본값(설정하지 않음) 또는 singleTop으로 설정해야 한다. `singleTask` 또는 `singleInstance`로 설정하는 것을 금지한다.

2. 게임에서 home버튼을 누르면 바탕화면에 돌아오고 다시 home버튼을 길게 누르고 게임로비 아이콘을 클릭하면 게임로비 화면에 돌아가는 상황 발생시(정상적인 반응은 게임에서 home 버튼을 누르면 게임에 돌아가야 함) 우선androidManifest.xml 파일에 a`ndroid:excludeFromRecents`가 true로 설정된 것이 있는 지 우선 검사하고 있으면 반드시 삭제해야 한다. 그외, `android:allowTaskReparenting`, `android:alwaysRetainTaskState`를 포함한 것도 전부 제거해야 한다.

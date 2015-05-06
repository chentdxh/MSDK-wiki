MSDK 게임로비 연동 모듈
====================

# 게임로비

현재 텐센트의 게임로비를 연동하는 경로는 두가지 있습니다.

- 첫째: 게임로비를 통하여 게임을 접속하며 이럴 경우 로비 로그인 티켓을 가지고 있지 않습니다.

- 둘째: 게임로비를 통하여 게임을 시작하는 동시에 유저가 로비에서 획득한 로그인 티켓을 가지고 게임을 접속합니다. 이럴 경우 로비의 로그인 티켓은 게임내 유저 로그인 티켓으로 직접 교체합니다. 

## 비 로그인 상태로 게임 실행

게임은 다만 로비를 통하여 실행하며 로비 로그인 티켓이 필요하지 않을 경우 아래 방법을 통하여 로비의 게임 실행을 차단할 수 있습니다.
게임의 `onCreate`와 `onNewIntent`에서 아래 방법으로 게임 실행 경로가 로비인지 판단합니다. 로비를 통하여 게임을 실행했을 경우 `handleCallback`를 호출하지 않고 아닐 경우 `handleCallback`를 호출하여 다른 플랫폼의 게임 실행을 처리합니다. 코드는 아래와 같습니다.

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

게임에서 QQ 게임로비를 연동하려면 우선 게임로비 입구를 설정하여야 합니다.(텐센트 운영팀을 통하여 설정,[시스템 설정 링크] (http://mqqgameadmin4dev.3gqq.com/web_mqqgame_admin/crud_db_cobra_hall/dbbeans/index.jsp))
게임로비 연동 테스트는 테스트 환경을 사용하므로 테스트 계정이 필요합니다.(텐센트 운영팀을 통하여 신청, 테스트 계정 유형은 일반 테스트 계정으로 선택.[테스트 계정 신청 링크](http://ceshihao.ied.com)). 런칭 후 공식 환경을 사용하면 테스트 계정이 필요 없으며 직접 게임로비를 통하여 로그인할 수 있습니다.
**주의:** 게임로비 연동 설정시 인증 유형(auth_type) 은 ** 오픈 플랫폼 Token (16)**으로 설정하여야 합니다. 아래 이미지 참조 바랍니다.

![qqgame_1](./qqgame_1.jpg)

게임로비에 연동하려면 우선 게임로비 입구가 있어야 합니다. 해당 작업은 텐센트 운영팀을 통하여 게임로비 관련 담당자를 찾아 해결할 수 있습니다. 게임로비에 입구가 있으면 게임로비를 통하여 게임을 실행할 수 있습니다. 게임 실행 시 SDK는 게임에 필요한 티켓(OpenId+accessToken+paytoken)을 교환하여 로컬에 저장합니다. 게임은 `OnWakeupNotify`를 받은 후 수신한 `WakeupRet`의 `platform` 필드에 의하여 게임이 로비에서 실행되었는 지 판단합니다. 로비에서 실행되었을 경우 `WGGetLoginRecord` 인터페이스를 호출하여 로컬에 저장된 로그인 티켓을 가져와서 로그인을 완료할 수 있습니다.

### 연동 설정

게임로비 연동 설정 요구

```
<!—게임로비 연동 앱은 다음의 intent-filter  start—를 추가할 수 없습니다.>
<intent-filter>
	<action android:name="android.intent.action.MAIN" />
	<category android:name="android.intent.category.LAUNCHER" />
	</intent-filter>
<!—게임로비 연동 앱은 이 intent-filter  end –를 추가할 수 없습니다.>

```

입구 Activity(MSDKSample의 `MainActivity`과 대응)의 intent-filter 설정

```
<!—입구 Activity에서 다음의 intent-filter start – 추가>
<intent-filter>
	<!-- xxxxx 를 개발자 자신의 앱 패키지로 교체, 정확히 기입하여야 하며 아닐 경우 실행되지 않습니다.-->
    <action android:name="xxxxx" /> 
    <category android:name="android.intent.category.DEFAULT" />
</intent-filter>
<!—입구 Activity에서 이 intent-filter end --입력>
```

AndroidManifest.xml의 <application> 탭에서 아래 내용을 추가합니다.

```
<!—로비 게임 연동는 이 meta-data start –를 설정하여야 합니다.>
<meta-data
    android:name="QQGameHallMark"
    android:value="QQGameHallMark" />
<meta-data
    android:name="QQGameHallAuthorVer"
	android:value="10000" />
<!—게임로비 연동는 이 meta-data end –를 설정하여야 합니다.>
```

`QQGameHallAuthorVer` 중 10000은 로비 플랫폼에서의 버전넘버이며 버전 업데이트시 사용됩니다. 로비에서 버전을 업데이트할 때마다 이 값은 1씩 증가됩니다. 초기값은 10000으로 설정할 수 있으며 로비에서 버전 업데이트용으로 사용됩니다. 이 값은 `android:versionCode`와 충돌되지 않고 일치할 필요가 없지만 신규 버전을 제출할 때마다 `android:versionCode`와 `QQGameHallAuthorVer` 값은 동시에 1을 증가하여야 합니다.

**주의:** 

1. 게임로비 연동는 home버튼을 길게 누를 경우 게임 자체의 아이콘이 나타나지 말아야 합니다. 이 요구에 만족하려면 androidManifest.xml 파일내의 모든 Activity의`android:launchMode`를 기본값(설정하지 않음) 혹은 singleTop으로 설정하여야 합니다. `singleTask` 혹은 `singleInstance`로 설정하는 것은 금지입니다.

2. 게임에서 home버튼을 눌러 바탕화면에 돌아오고 다시 home버튼을 길게 누른 후 게임로비 아이콘을 클릭하여 게임로비 화면으로 돌아오는 상황이 발생할 경우(정확한 프로세스는 게임에서 home 버튼을 누르면 게임으로 돌아가야 함), 우선 androidManifest.xml 파일에 a`ndroid:excludeFromRecents`가 true로 설정되었는지 검토하고 있을 경우 삭제하여야 합니다. 그외 `android:allowTaskReparenting`, `android:alwaysRetainTaskState`를 포함한 것도 모두 삭제하여야 합니다.

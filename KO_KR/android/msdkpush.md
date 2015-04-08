SDK 푸시 기능 액세스
======
MSDK2.2a부터 XG Push 모듈을 액세스했다. 푸시 기능은 게임을 운행하지 않은 상태에서 유저 휴대폰에 게임 관련 정보를 푸시할 수 있도록 한다.
액세스 설정
------
1단계: 환경 설정

assets/msdkconfig.ini에서 메시지 푸시 스위치를 연다:

    PUSH=true //true일 경우, 메시지 푸시 실행

2단계: AndroidManifest.xml 설정

    <!—[필수] XG PushSDK 필요 권한 -->
    <uses-permission android:name="android.permission.INTERNET" />
    <uses-permission android:name="android.permission.READ_PHONE_STATE" />
    <uses-permission android:name="android.permission.ACCESS_WIFI_STATE" />
    <uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
    <uses-permission android:name="android.permission.RECEIVE_BOOT_COMPLETED" />
    <uses-permission android:name="android.permission.RESTART_PACKAGES" />
    <uses-permission android:name="android.permission.BROADCAST_STICKY" />
    <uses-permission android:name="android.permission.WRITE_SETTINGS" />
    <uses-permission android:name="android.permission.RECEIVE_USER_PRESENT" />
    <uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE" />
    <uses-permission android:name="android.permission.WAKE_LOCK" />
    <uses-permission android:name="android.permission.KILL_BACKGROUND_PROCESSES" />
    <uses-permission android:name="android.permission.GET_TASKS" />
    <uses-permission android:name="android.permission.READ_LOGS" />
    <uses-permission android:name="android.permission.VIBRATE" />
    <!—[옵션] XG PushSDK 필요 권한 -->
    <uses-permission android:name="android.permission.BLUETOOTH" />
    <uses-permission android:name="android.permission.BATTERY_STATS" />
    
    <!-- XG Push 환경 설정 START -->
    <!-- [필수] XG Push알림 표시줄 -->
    <activity
        android:name="com.tencent.android.tpush.XGPushActivity"
        android:exported="true" >
        <intent-filter>
            <action android:name="" />
        </intent-filter>
    </activity>
    
    <!-- [필수] XG Pushreceiver 방송 수신 -->
    <receiver
        android:name="com.tencent.android.tpush.XGPushReceiver"
        android:process=":xg_service_v2" >
        <intent-filter android:priority="0x7fffffff" >
            <!-- [필수] XG PushSDK 내부 방송 -->
            <action android:name="com.tencent.android.tpush.action.SDK" />
            <action android:name="com.tencent.android.tpush.action.INTERNAL_PUSH_MESSAGE" />
        </intent-filter>
        <intent-filter android:priority="0x7fffffff" >
            <!-- [필수] 시스템 방송: 스크린 온과 네트워크 전환 -->
            <action android:name="android.intent.action.USER_PRESENT" />
            <action android:name="android.net.conn.CONNECTIVITY_CHANGE" />
        </intent-filter>
    </receiver> 
    
    <!-- [필수] XG Pushservice -->
    <service
     android:name="com.tencent.android.tpush.service.XGPushService"
        android:exported="true"
        android:persistent="true"
        android:process=":xg_service_v2" />
    <!-- XG Push 환경 설정 END -->

MSDK2.7.0a 및 이후 버전에서 아래같은 설정을 추가해야 한다.`패키지명을 수정해야 할 것을 주의해야 한다.`

        <!-- 【필수】 service에 통지, 해당 옵션은 푸시 효율 향상 시키는 데 도움에 된다 -->
        <service
            android:name="com.tencent.android.tpush.rpc.XGRemoteService"
            android:exported="true" >
            <intent-filter>
               <!-- 【필수】 현재APP패키지명으로 수정하기 바란다.PUSH_ACTION-->
               <action android:name="com.example.wegame.PUSH_ACTION" />
           </intent-filter>
        </service>
        <!-- XG Push 환경 설정 END -->

3단계: http://dev.ied.com/에 접속한 후 메시지 관리 모듈에서 푸시 설정을 진행한다. **메시지(공식 환경)을 사용하여 메시지를 발송**해야 한다

**"메시지 관리"메뉴가 안 보이면 marsrabelma(马腾) 연락해서 추가한다.**

![msdkpush_1](./push_1.png)

연동 테스트
------

1. 상기 절차에 따라 설정한 후 게임을 시작하여 log를 필터링한다. 만약 아래 log가 나타나면 설비가 성공적으로 등록되었음을 표시하며 이글 시스템에서 전수 푸시를 진행할 수 있다

![msdkpush_1](./push_ce1.png)

2. 로그인한 후 아래 log가 보이면 유저 바인딩에 성공했음을 표시하며 이글 시스템에서 번호 패키지 푸시를 진행할 수 있다

![msdkpush_1](./push_ce2.png)

XG Push를 이미 액세스한 앱 솔류션
------
XG Push를 이미 액세스한 게임은 이전에 XG Push를 액세스한 로직을 유지할 수 있다. 이때 MSDKLibrary를 도입하면 패키지 충돌이 발생할 수 있다.

i)	MSDK 방식에 따라 XG Push를 액세스할 것을 권장한다. 자신이 이미 액세스한 XG Pushsdk를 삭제하고 MSDK 방식에 따라 푸시 진행

ii)	또는 MSDK가 사용하는 XG Pushsdk를 삭제하고 낡은 XG Push 액세스 방식을 사용할 수도 있다. 그중 XG Pushsdk 저장 위치는:

    MSDKLibrary\libs\armeabi\libtpnsSecurity.so
    MSDKLibrary\libs\armeabi-v7a\libtpnsSecurity.so
    MSDKLibrary\libs\mips\libtpnsSecurity.so
    MSDKLibrary\libs\x86\libtpnsSecurity.so 
    MSDKLibrary\libs\armeabi\Xg_sdk.jar

또한, 이런 libs를 삭제하는 경우 게임은 MSDK의 push 기능을 종료해야 하며 다음과 같이 처리한다. assets/msdkconfig.ini에서 메시지 푸시 스위치 설정:

    PUSH=false 

iii)	자신이 XG Push 공홈에서 내려받은 sdk를 삭제하지만 MSDK가 사용하는 XG Pushsdk(MSDK2.2가 사용한 것은 Xg_sdk_v2.341.jar)를 삭제하지 않고 기존 XG Push 액세스 기능이 정상적으로 운행하는 지 검증하면 된다. 기존 XG Push 액세스 기능을 사용하면 msdk 푸시 스위치를 닫을 것을 권장한다

XG Push 및 MTA 난독화 코드 주의 사항
------
Android APP 개발자는 일반적으로 proguard 툴을 이용하여 코드 난독화를 진행한다. MTA 대외 인터페이스와 NDK 인터페이스는 공개해야 하기에 기능을 사용할 수 없거나 이상이 발생하는 것을 방지하기 위해 난독화 시 아래 코드에 주의해야 한다.

    -keep public class * extends android.app.Service
    -keep public class * extends android.content.BroadcastReceiver
    -keep class com.tencent.android.tpush.**  {* ;}
    -keep class com.tencent.mid.**  {* ;}

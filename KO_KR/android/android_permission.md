Android시스템 관한 설명
===

## 필수적인 기본 권한

아래 권한은 각 기능에 사용할 기본 권한이며 반드시 AndroidManifest에서 성명해야 하며, 아니면 비정상 상황을 일으킬 수 있다.

```
<!-- 필수한 기본 권한-->
<uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
<uses-permission android:name="android.permission.ACCESS_WIFI_STATE" />
<uses-permission android:name="android.permission.CHANGE_WIFI_STATE" />
<uses-permission android:name="android.permission.GET_TASKS" />
<uses-permission android:name="android.permission.INTERNET" />
<uses-permission android:name="android.permission.MOUNT_UNMOUNT_FILESYSTEMS" />
<uses-permission android:name="android.permission.READ_PHONE_STATE" />
<uses-permission android:name="android.permission.RESTART_PACKAGES" />
<uses-permission android:name="android.permission.SYSTEM_ALERT_WINDOW" />
<uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE" />
```

## 일부 선택 가능한 권한

아래는 일부 선택 가능한 권한이며 해당 기능을 사용 불필요할  권한은 AndroidManifest에서 성명하지 않아도 된다.

```
<!-- 위치 정보 획득 권한，LBS기능에 필요 -->
<uses-permission android:name="android.permission.ACCESS_FINE_LOCATION" />

<!-- 블루스 모듈 권한을 통해 장치명을 획득, 로그인 데이터 보고때 필요 -->
<uses-permission android:name="android.permission.BLUETOOTH" />
<uses-permission android:name="android.permission.BLUETOOTH_ADMIN" />

<!-- 시스템 로그 read 권한，비정상 보고 시스템과 XG푸시에 필요 -->
<uses-permission android:name="android.permission.READ_LOGS" />

<!-- Qmi에 연동 시 필요한 권한 -->
<uses-permission android:name="android.permission.CHANGE_CONFIGURATION" />
<uses-permission android:name="android.permission.KILL_BACKGROUND_PROCESSES" />
<uses-permission android:name="android.permission.RECEIVE_BOOT_COMPLETED" />
<uses-permission android:name="android.permission.RECORD_AUDIO" />
<uses-permission android:name="android.permission.VIBRATE" />

<!-- XG 푸시 시스템에 연동시 필요한 권한 -->
<uses-permission android:name="android.permission.BROADCAST_STICKY" />
<uses-permission android:name="android.permission.WRITE_SETTINGS" />
<uses-permission android:name="android.permission.RECEIVE_USER_PRESENT" />
<uses-permission android:name="android.permission.WAKE_LOCK" />
<uses-permission android:name="android.permission.VIBRATE" /> 
```
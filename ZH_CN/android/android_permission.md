Android系统权限说明
===

## 必须的基本权限

以下权限为各功能使用到的基本权限必须在AndroidManifest中声明，否则会导致异常。

```
<!-- 必须的基本权限-->
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

## 部分可选权限

以下为部分可选权限，未用到相应功能的部分权限可以不在AndroidManifest中声明。

```
<!-- 获取位置信息权限，LBS功能需要 -->
<uses-permission android:name="android.permission.ACCESS_FINE_LOCATION" />

<!-- 通过蓝牙模块权限来获取设备名称，登录上报数据时需要 -->
<uses-permission android:name="android.permission.BLUETOOTH" />
<uses-permission android:name="android.permission.BLUETOOTH_ADMIN" />

<!-- 读取系统日志权限，异常上报系统和信鸽需要 -->
<uses-permission android:name="android.permission.READ_LOGS" />

<!-- 接入手游宝需要的权限 -->
<uses-permission android:name="android.permission.CHANGE_CONFIGURATION" />
<uses-permission android:name="android.permission.KILL_BACKGROUND_PROCESSES" />
<uses-permission android:name="android.permission.RECEIVE_BOOT_COMPLETED" />
<uses-permission android:name="android.permission.RECORD_AUDIO" />
<uses-permission android:name="android.permission.VIBRATE" />

<!-- 接入信鸽需要的权限 -->
<uses-permission android:name="android.permission.BROADCAST_STICKY" />
<uses-permission android:name="android.permission.WRITE_SETTINGS" />
<uses-permission android:name="android.permission.RECEIVE_USER_PRESENT" />
<uses-permission android:name="android.permission.WAKE_LOCK" />
<uses-permission android:name="android.permission.VIBRATE" /> 
```
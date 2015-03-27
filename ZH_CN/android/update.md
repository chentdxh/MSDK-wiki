版本更新、发布指南
=======

## Android Library Project类游戏更新

1. 删除原有项目工程下的`MSDKLibrary`，拷贝新的`MSDKLibrary`到项目工程目录下。

	**备注：**：如果是使用C++接口的游戏，复制`MSDKLibrary`下jni目录的 .cpp 和 .h 文件加到游戏工程，并添加到 `Android.mk`。

- 根据版本调整说明中关于Androidmainfest的说明，根据游戏需求，调整对应的权限

- 根据版本调整说明中关于msdkconfig.ini的说明，根据游戏需求，调整对应配置

- OK，更新完成
 
## 非Android Library Project类游戏更新

1. 删除游戏工程下`res`目录中以`com_tencent_msdk_`与`msdk_`开头的资源文件，拷贝复制`MSDKLibrary`下的res目录到游戏工程相应目录。

	**备注：**：资源文件基本不会变化，如果游戏认为删除再添加容易出错，可以直接复制`MSDKLibrary`下的res目录到游戏工程相应目录，覆盖原有文件即可。

- 复制`MSDKLibrary`下的libs到游戏工程相应目录，如果有冲突，对比删除原有版本对应的jar即可。

- **如果是使用C++接口的游戏**，制`MSDKLibrary`下jni目录的 .cpp 和 .h 文件加到游戏工程，并添加到 `Android.mk`。

- 根据版本调整说明中关于Androidmainfest的说明，根据游戏需求，调整对应的权限

- 根据版本调整说明中关于msdkconf.ini的说明，根据游戏需求，调整对应配置

- OK，更新完成

## 代码混淆配置

游戏如果上线前代码混淆，为了放置混淆AGSDK相关代码，需要在混淆配置中增加以下内容：

	-optimizationpasses 5
	-dontusemixedcaseclassnames
	-dontskipnonpubliclibraryclasses
	-dontpreverify
	-dontoptimize
	-ignorewarning
	-verbose
	-optimizations !code/simplification/arithmetic,!field/*,!class/merging/*

	-keep public class * extends android.app.Activity
	-keep public class * extends android.app.Application
	-keep public class * extends android.app.Service
	-keep public class * extends android.content.BroadcastReceiver
	-keep public class * extends android.content.ContentProvider
	-keep public class * extends android.app.backup.BackupAgentHelper
	-keep public class * extends android.preference.Preference
	-keep public class com.android.vending.licensing.ILicensingService

	-keepclasseswithmembernames class * {
		native <methods>;
	}

	-keepclasseswithmembernames class * {
		public <init>(android.content.Context, android.util.AttributeSet);
	}

	-keepclasseswithmembernames class * {
		public <init>(android.content.Context, android.util.AttributeSet, int);
	}


	-keepclassmembers enum * {
		public static **[] values();
		public static ** valueOf(java.lang.String);
	}

	-keep class * implements android.os.Parcelable {
	  public static final android.os.Parcelable$Creator *;
	}

	-keepattributes InnerClasses


	-keep public class com.tencent.msdk.api.**{*;}

	-keep class com.tencent.mid.**{*;}

	-keep class com.tencent.stat.**{*;}

	-keep class com.tencent.smtt.**{*;}

	-keep class com.tencent.beacon.**{*;}

	-keep class com.tencent.mm.**{*;}
	-keep class com.tencent.apkupdate.**{*;}
	-keep class com.tencent.tmassistantsdk.**{*;}
	-keep class org.apache.http.entity.mime.**{*;}

	-keep class com.qq.jce.**{*;}
	-keep class com.qq.taf.**{*;}

	-keep class com.tencent.connect.**{*;}
	-keep class com.tencent.map.**{*;}
	-keep class com.tencent.open.**{*;}
	-keep class com.tencent.qqconnect.**{*;}
	-keep class com.tencent.tauth.**{*;}

	-keep class com.tencent.android.tpush.**{*;}

	-keep class com.tencent.feedback.**{*;}

	-keep class common.**{*;}
	-keep class exceptionupload.**{*;}
	-keep class mqq.**{*;}
	-keep class qimei.**{*;}
	-keep class strategy.**{*;}
	-keep class userinfo.**{*;}
	-keep class com.tencent.mid.**{*;}
















Guide to Version Update and Release
=======

## Update of games using Android Library Project

1. Delete `MSDKLibrary` in the original project directory and copy the new `MSDKLibrary` into the project directory.

	**Note: **: For a game using C++ interfaces, copy .cpp and .h files in jni directory in `MSDKLibrary` into the game project and add them to `Android.mk`.

- Adjust the corresponding permissions according to the instructions on Androidmainfest in the version adjustment instruction and according to the game’s needs

- Adjust the corresponding configuration according to the instructions on msdkconfig.ini in the version adjustment instruction and according to the game’s needs

- Ok. The update is completed.

## Update of games not using Android Library Project

1. Delete resource files whose names begin with `com_tencent_msdk` and `msdk_` in `res` directory in the game project, and copy res directory in `MSDKLibrary` into the corresponding directory of the game project.

	**Note: **: the resource files basically do not change; if game developers think that deleting files and then adding files can easily result in errors, they can directly copy res directory in `MSDKLibrary` into the corresponding directory of the game project to overwrite the existing files.

- copy libs in `MSDKLibrary` into the corresponding directory of the game project; if there are any conflicts, delete the corresponding jar of the original version.

- ** For a game using C++ interfaces, copy .cpp and .h files in jni directory in `MSDKLibrary` into the game project and add them to `Android.mk`.

- Adjust the corresponding permissions according to the instructions on Androidmainfest in the version adjustment instruction and according to the game’s needs

- Adjust the corresponding configuration according to the instructions on msdkconfig.ini in the version adjustment instruction and according to the game’s needs

- Ok. The update is completed.

## Code obfuscation configuration

If the game’s codes are obfuscated before it is put online, it is needed to add the following content in the obfuscation configuration in order to place obfuscation AGSDK-related codes:

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
















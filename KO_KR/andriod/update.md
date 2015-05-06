버전 업데이트，배포 안내
=======

## Android Library Project 게임 업데이트

1. 기존 프로젝트 아래의 `MSDKLibrary`를 삭제하고 새로운 `MSDKLibrary`를 프로젝트 디렉토리에 복사해 넣습니다.

	**비고:**: C++ 인터페이스를 사용하는 게임은 `MSDKLibrary`에서 jni 디렉토리의 .cpp 와 .h 파일을 복사하여 게임 프로젝트에 붙여 넣는 동시에 `Android.mk`에도 추가합니다.

- 버전 튜닝 설명에서의 Androidmainfest 설명은 게임 수요에 따라 해당한 권한을 튜닝합니다.

- 버전 튜닝 설명에서의 msdkconfig.ini 설명은  게임 수요에 따라 해당한 설정을 튜닝합니다.

- OK,업데이트 완료
 
## 비 Android Library Project 게임 업데이트

1. 게임 프로젝트의 `res` 디렉토리에서 `com_tencent_msdk_`와 `msdk_`로 시작되는 리소스 파일을 삭제하고 `MSDKLibrary`에서 res 디렉토리를 복사하여 게임 프로젝트에 해당한 디렉토리에 붙여 넣습니다다.

	**비고:**: 리소스 파일은 일반적으로 변경하지 않습니다. 만약 개발사에서 삭제 후 다시 추가하면 쉽게 문제가 발생할 수 있을 것으로 판단되면  `MSDKLibrary`에서 res 디렉토리를 복사하여 직접 게임 프로젝트에 해당한 디렉토리에 붙여넣거 기존 파일을 커퍼하면 됩니다.

- `MSDKLibrary`의 libs를 복사하에 게임 프로젝트에 해당한 디렉토리에 붙여 넣습니다. 충돌이 발생하면 기존 버전의 jar를 삭제하면 됩니다.

- **C++ 인터페이스를 사용하는 게임은 ** `MSDKLibrary`에서 jni 디렉토리의 .cpp 와 .h 파일을 복사하여 게임 프로젝트에 붙여 넣은 후 `Android.mk`에 추가합니다.

- 버전 튜닝 설명에서의 Androidmainfest 설명은 게임 수요에 따라 해당한 권한을 튜닝합니다.

- 버전 튜닝 설명에서의 msdkconf.ini 설명은 게임 수요에 따라 해당한 설정을 튜닝합니다.

- OK,업데이트 완료

## 코드 난독화 설정

게임 런칭 전에 코드 난독화를 진행하면 난독화 AGSDK 관련 코드를 배치하기 위하여 난독화 설정에 아래 내용을 추가하여야 합니다.

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
















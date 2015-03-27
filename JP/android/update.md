バージョン更新、リリースガイド
=======

## Android Library Project類ゲームの更新

1.従来プロジェクト・エンジニアリングの`MSDKLibrary`を削除し、新しい`MSDKLibrary`をプロジェクト・エンジニアリングのディレクトリーにコピーします。

	**備考：**： C++インターフェースのゲームの場合、`MSDKLibrary`のjniディレクトリー配下の .cpp と .h ファイルをゲームエンジニアリングに複製し、`Android.mk`に追加します。

-バージョン調整説明におけるAndroidmainfestの説明により、ゲームの要求に応じて、対応の権限を調整します

-バージョン調整説明におけるmsdkconfig.iniの説明により、ゲームの要求に応じて、対応の配置を調整します

- OK，更新完成
 
## 非Android Library Project類ゲームの更新

1.ゲームエンジニアリングの`res`ディレクトリーで`com_tencent_msdk_`及び`msdk_`で開始するリソースファイルを削除し、`MSDKLibrary`のresディレクトリーをゲームエンジニアリングの相応ディレクトリーにコピーします。

	**備考：**：リソースファイルは基本的に変化がありません。削除してから追加することは間違いが発生すると考える場合、`MSDKLibrary`のresディレクトリーをゲームエンジニアリングの相応ディレクトリーに複製し、従来のファイルを上書きしても大丈夫です。

- `MSDKLibrary`のlibsをゲームエンジニアリングの相応ディレクトリーに複製します。競合があれば、従来バージョンの対応jarを削除してください。

- ** C++インターフェースのゲームの場合**、`MSDKLibrary`のjniディレクトリー配下の.cpp と .h ファイルをゲームエンジニアリングに複製し、`Android.mk`に追加します。

-バージョン調整説明におけるAndroidmainfestの説明により、ゲームの要求に応じて、対応の権限を調整します

-バージョン調整説明におけるmsdkconfig.iniの説明により、ゲームの要求に応じて、対応の配置を調整します

- OK，更新完成

## コード難読化配置

運営の前にコード難読化をする場合、AGSDK難読化の関連コードを設定するために、難読化配置には次の内容を追加してください。

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














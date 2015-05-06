MSDK 내장 브라우저 관련 모듈
======
MSDK는 내장 브라우저를 제공해 드립니다. 이 내장 Webview는 보안성이나 성능 등 면에서 시스템 내장 Webview보다 훌륭하며 QQ와 위챗에 공유하는 기능도 있습니다. 게임내에서  Web페이지를 실행하여 마케팅 이벤트창,게시판,공략 등 페이지를 방문할 수 있습니다. 내장 브라우저 연동은 크게 두개 절차가 있습니다.
연동 설정
------
**MSDK2.7.0a 및 이후 버전은 아래와 같이 설정합니다.**

핸드폰에 QQ브라우저가 설치되었을 경우 QQ내장 브라우저 커널을 사용하며 설치되어 있지 않았을 경우 시스템에서 디폴트로 내장 브라우저를 사용합니다. 이럴 경우 메모리 노출 가능성이 있어 독립적인 프로세스로 수정하였습니다. 
**`android:process=":msdk_inner_webview"추가 필요，내장 브라우저를 off할 경우 해당 프로세스를 종료합니다. 만약 이 옵션을 설정하지 않았을 경우 게임 메인 프로세스를 종료 후 게임도 종료됩니다.`**

        <!-- TODO 브라우저 관련 START -->
        <activity
            android:name="com.tencent.msdk.webview.JumpShareActivity"
            android:theme="@android:style/Theme.Translucent.NoTitleBar">
        </activity>
        
        <activity
            android:name="com.tencent.msdk.webview.WebViewActivity"
            android:process=":msdk_inner_webview" 
            android:configChanges="orientation|screenSize|keyboardHidden|navigation|fontScale|locale"
            android:screenOrientation="unspecified"
            android:theme="@android:style/Theme.Translucent.NoTitleBar"
            android:windowSoftInputMode="adjustPan" >
        </activity>

**MSDK2.0.0a 이전은 아래 방식으로 설정합니다.**

    <activity
       android:name="com.tencent.mtt.spcialcall.SpecialCallActivity"
       android:configChanges="orientation|keyboardHidden|navigation|fontScale|locale|screenSize"
       android:screenOrientation="unspecified"
       android:theme="@style/ThrdCallActivity"
       android:exported="false"
       android:windowSoftInputMode="adjustPan" >
    <intent-filter>
       <action android:name="com.tencent.QQBrowser.action.VIEWLITE" />
       <category android:name="android.intent.category.DEFAULT" />
       <category android:name="android.intent.category.BROWSABLE" />
       <data android:scheme="http" />
       <data android:scheme="https" />
       <data android:scheme="file" />
    </intent-filter>
    </activity>
**MSDK2.0.0a 및 그 이후부터는 아래 방식으로 설정합니다.**

    <activity
       android:name="com.tencent.msdk.webview.WebViewActivity"
       android:configChanges="orientation|screenSize|keyboardHidden|navigation|fontScale|locale"
       android:theme="@android:style/Theme.NoTitleBar"
       android:screenOrientation="unspecified"
       android:windowSoftInputMode="adjustPan">
    </activity>

내장 브라우저가 줄곧 가로 화면을 유지하려면 `android:screenOrientation="unspecified"`를 아래와 같이 변경합니다.
`android:screenOrientation="landscape"`

내장 브라우저가 줄곧 세로 화면을 유지하려면 `android:screenOrientation="unspecified"`를 아래와 같이 변경한다.
`android:screenOrientation="portrait"`

버전 1.9.0으로 업데이트되었으면 1.9.0 이전의 설정을 삭제하고 새로운 설정을 추가하면 됩니다.

브라우저 실행
------
WGOpenUrl 인터페이스를 호출하여 URL을 전송하면 SDK가 제공한 Webview를 사용할 수 있습니다. WGOpenUrl 인터페이스 설명:

    /**
      *내장 브라우저 실행. 이 내장 Webview는 보안성이나 성능이 시스템 내장 Webview보다 훌륭합니다. 휴대폰에 QQ 브라우저가 설치되어 있으면 QQ브라우저 커널을 사용하여 보다 좋은 성능을 보여주며 내장 브라우저에서 QQ와 위챗에 공유하는 기능도 제공합니다.
      *@param openUrl 방문할 url
      */
    void WGOpenUrl(unsigned char * openUrl);

호출 샘플 코드:

    WGPlatform::GetInstance()->WGOpenUrl(cOpenUrl);

표시 효과:

![webview](./webview_res/webview_1.png) ![webview](./webview_res/webview_2.png)


투과전송 파라미터 설명
------
###1. 로그인 상태의 암호화 전송
게임에 로그인한 후 내장 브라우저를 통하여 웹페이지를 방문하면 암호화된 로그인 상태 파라미터를 전송합니다. 구체 절차는 아래와 같습니다.

1.MSDK가 이런 파라미터를 암호화하여 페이지에 전송합니다.

2.페이지에서 암호화된 스트링을 획득한 후 MSDK 백그라운드 디코딩 인터페이스를 통하여 암호화를 해제한 스트링을 획득합니다.

3.암호화가 해제된 Token으로 로그인 인증을 진행합니다.

![webview](./webview_res/webview_3.png)

###2. 암호화된 데이터
암호화할 로그인 상태 파라미터는 아래 표와 같습니다.

| 파라미터명  | 파라미터 설명  |
| ------------- |:-------------:|
| acctype| 계정 타입，값은qq혹wx로 함|
| appid| 게임ID |  
| openId | 유저 인증 후 플랫폼이 리턴한 유니크ID|  
| access_token| 유저 인증 토큰 | 
| platid| 단말 타입，0은 ios，1은 android |




MSDK는 URL 뒤에 아래와 같은 파라미터를 추가__중복된 파라미터를 전송하면 디코딩 실패를 초래할 수 있습니다.

| 파라미터명  |         파라미터 설명  |  
| ------------- |:-------------:|
| timestamp| 요청하는 타임 스탬프 |
| appid| 게임ID |
| algorithm | 암호화 알고리즘 ID값은 v1혹 v2 | 
| msdkEncodeParam | 함호문 |
| version | MSDK버전번호,예를 들어1.6.2a |
| sig | 요청 자체 사인 |
| encode | 코드 파라미터，예를 들어,1 |
| openid | 유저 인증 후 플랫폼에서 리턴한 유니크 ID |


###3. 예시
브라우저가 URL：http://apps.game.qq.com/ams/gac/index.html을 방문한다고 가정하면 실제 패킷 스니핑시 아래와 같은 URL을 볼 수 있습니다.

`http://apps.game.qq.com/ams/gac/index.html?sig=***&timestamp=**&appid=***&openid=***&algorithm=v1&msdkEncodeParam=***&version=1.6.2i&encode=1`

그중 msdkEncodeParam가 실제로 전송한 것은 아래 파라미터로 암호화 후의 암호문입니다(url encode)

`acctype=weixin&appid=100732256&openid=ol7d0jsVhIm3BQwlNG9g2f4puyUg&access_token=OezXcEiiBSKSxW0eoylIeCKi7qrm-
vXrr62qKiSw2otDBgCzzKZZfeBOSv9fplYsIPD844sNIDeZgG3IyarYcGCNe8XuYKHncialLBq0qj9-rVGhoQVkgSYJ8KXr9Rmh8IvdqK3zsXryo37sMJAa9Q&platid=0`



로그인 상태의 암호화/복호화
------
###1. 디코딩
게임 페이지는 상기 URL을 받은 후 MSDK 디코딩 인터페이스 호출을 요청합니다. 현재 디코딩 인터페이스는 2가지 파라미터 전송 방식이 있습니다. 게임 백그라운드는 algorithm 파라미터에 따라 두가지 파라키터 암호화 전송 방식을 구현 및 지원하여야 합니다.

1. MSDK1.8.1a 및 그후부터 파라미터 암호화 전송 방식: (아래 URL가 방문한 것은 MSDK 테스트 환경)

`http://msdktest.qq.com/comm/decrypv1/?sig=***&timestamp=**&appid=***&openid=***&algorithm=v2&version=1.8.1i&encode=1`

첫 단계에서 얻은 msdkEncodeParam 의 암호문 값을 직접 body에 넣어 직접 Post 방식으로 전송합니다. 주의해야 할 점은 key“msdkEncodeParam=”을 추가하지 말아야 합니다.

2. MSDK1.8.1a 이전의 파라미터 암호화 전송 방식:(이 방식의 단말기는 이미 사용되지 않지만 백그라운드에서는 기존 버전을 지원하여야 합니다.)

`http://msdktest.qq.com/comm/decrypv1/?sig=***&timestamp=**&appid=***&openid=***&algorithm=v1&version=1.6.2i&encode=1`
 
msdkEncodeParam 의 암호문 URL Decode를 body에 넣어 Post 방식으로 전송합니다. 주의해야 할 점은 key“msdkEncodeParam=”를 추가하지 말아야 합니다. 패킷 스니핑은 아래와 같습니다.

3、Fiddler암호 해독 예시

3.1 브라우저에서 URL：www.qq.com를 호출한다고 가정할 경우 실제 패키지 차단 시 방문하는 URL은 아래와 같습니다.

    http://www.qq.com?algorithm=v2&version=2.0.6a&timestamp=1423538227203&appid=100703379&sig=427291da31b56b59739be6da61d433ec&encode=1&msdkEncodeParam=BAD8B1625CB04523B06AAF6739ACB3CEA96F54393831AF5C6890E92EE61CF1A29F493710592DD84B47D4217BA9FA9DAFB8025CEB27E45EC958689A794E8BD33CF2544CC5D00FCE03AEF7B23EE2BFCA4332F5D69547477A3E93E44F3270F19664D5499CA2990BE5BA9E232036197B184F1411B76CF95537AC07E3D6A27F054AD3F26648B18554F9C1

3.2 Fiddler를 사용하여 테스트하며 연결해야 할 url는：

    http://msdktest.qq.com/comm/decrypv1/?sig=427291da31b56b59739be6da61d433ec&timestamp=1423538227203&appid=100703379&algorithm=v2&version=2.0.6a&encode=1

   그 중 Post body는：
          
    BAD8B1625CB04523B06AAF6739ACB3CEA96F54393831AF5C6890E92EE61CF1A29F493710592DD84B47D4217BA9FA9DAFB8025CEB27E45EC958689A794E8BD33CF2544CC5D00FCE03AEF7B23EE2BFCA4332F5D69547477A3E93E44F3270F19664D5499CA2990BE5BA9E232036197B184F1411B76CF95537AC07E3D6A27F054AD3F26648B18554F9C1

3.3 Fiddler에서 디버깅 합니다.

![webview](./webview_extend_3.png)

실행한 결과는：

    acctype=qq&appid=100703379&openid=4FC5813635C21D7C0A64729E4E2D3041&access_token=B85D2A1D7DB1B564CADE7116BF70AD0D&platid=1

PS：정식 환경에서는 http://msdk.qq.com/comm/decrypv1/사용 바랍니다.
###2. 암호문 디코딩 코드 샘플(php버전)
![webview](./webview_res/webview_5.png)
![webview](./webview_res/webview_6.png)
###3. 암호문 디코딩 코드 샘플(C 코드)
1. 아래 파일 UrlCoding.h 도입:

    #ifndef URL_H
    #define URL_H

    #ifdef __cplusplus
       extern "C" {
          #endif
    
          int php_url_decode(const char *str, int len, char *out, int *outLen);
          char *php_url_encode(char const *s, int len, int *new_length);
          int php_url_decode_special(const char *str, int len, char *out, int *outLen);
    
          #ifdef __cplusplus
       }
    #endif

    #endif /* URL_H */

2. 아래 파일 UrlCoding.c 도입:

    #include <stdlib.h>
    #include <string.h>
    #include <ctype.h>
    #include <sys/types.h>
    #include <stdio.h>
    #include "UrlCoding.h"
    
    static unsigned char hexchars[] = "0123456789ABCDEF";
    
    static int php_htoi(const char *s)
    {
        int value;
        int c;
        
        c = ((unsigned char *)s)[0];
        if (isupper(c))
            c = tolower(c);
        value = (c >= '0' && c <= '9' ? c - '0' : c - 'a' + 10) * 16;
        
        c = ((unsigned char *)s)[1];
        if (isupper(c))
            c = tolower(c);
        value += c >= '0' && c <= '9' ? c - '0' : c - 'a' + 10;
        
        return (value);
    }
    
    
    char *php_url_encode(char const *s, int len, int *new_length)
    {
        register unsigned char c;
        unsigned char *to, *start;
        unsigned char const *from, *end;
        
        from = (unsigned char *)s;
        end  = (unsigned char *)s + len;
        start = to = (unsigned char *) calloc(1, 3*len+1);
        
        while (from < end)
        {
            c = *from++;
            
            if (c == ' ')
            {
                *to++ = '+';
            }
            else if ((c < '0' && c != '-' && c != '.') ||
                     (c < 'A' && c > '9') ||
                     (c > 'Z' && c < 'a' && c != '_') ||
                     (c > 'z'))
            {
                to[0] = '%';
                to[1] = hexchars[c >> 4];
                to[2] = hexchars[c & 15];
                to += 3;
            }
            else
            {
                *to++ = c;
            }
        }
        *to = 0;
        if (new_length)
        {
            *new_length = to - start;
        }
        return (char *) start;
    }
    
    
    int php_url_decode(const char *str, int len, char *out, int *outLen)
    {
        const char *data = str;
        char *orgOut = out;
        while (len--)
        {
            if (*data == '+')
            {
                *out = ' ';
            }
            else if (*data == '%' && len >= 2 && isxdigit((int) *(data + 1)) && isxdigit((int) *(data + 2)))
            {
                *out = (char) php_htoi(data + 1);
                data += 2;
                len -= 2;
            }
            else
            {
                *out = *data;
            }
            data++;
            out++;
        }
    //  *out = '/0';
        *outLen = out - orgOut;
        return *outLen;
    }
    
    //WGCommonMethods.h의 encodeForURL을 위해 특별히 구현한 디코딩 방법 haywoodfu 2014-04-23
    int php_url_decode_special(const char *str, int len, char *out, int *outLen)
    {
        const char *data = str;
        char *orgOut = out;
        while (len--)
        {
            if (*data == '+')
            {
                *out = ' ';
            }
            else if (*data == '%' && len >= 2 && isxdigit((int) *(data + 1)) && isxdigit((int) *(data + 2)))
            {
                int value = 0;
                sscanf((data+1), "%2x", &value);
                *out = (char) value;
                data += 2;
                len -= 2;
            }
            else
            {
                *out = *data;
            }
            data++;
            out++;
        }
    //  *out = '/0';
        *outLen = out - orgOut;
        return *outLen;
    }

3. 전송된 문자열 encodeParam을 php_url_decode와 php_url_decode_special을 이용하여 차례로 디코딩하여 얻은 것이 암호문입니다.

![webview](./webview_res/webview_7.png)

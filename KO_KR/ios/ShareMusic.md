음악공유
=== 

##개요
 - 이 기능은 버전 1.7.0 이후부터 제공되며 위챗과 모바일QQ에 공유하는 인터페이스를 제공한다.

---

## 인터페이스 설명
 - WGShowNotice를 호출하면 MSDK에 설정된 화면을 이용하여 현재 유효한 공지를 표시한다
```ruby
void WGSendToQQWithMusic(const int& scene,
                             unsigned char* title,
                             unsigned char* desc,
                             unsigned char* musicUrl,
                             unsigned char* musicDataUrl,
                             unsigned char* imgUrl);
```
>설명: 메시지를 모바일QQ 대화 또는 Qzone에 공유. url은 게임 모바일QQ 게임센터 세부페이지 입력. 메시지를 클릭하면 모바일QQ에서 음악을 재생한다.
파라미터:
  - scene 공간에 공유하는지 대화에 공유하는지 표시
0：모바일QQ 실행, 공간 공유창을 기본적으로 팝업
1：모바일QQ 실행, 친구에게만 공유 가능
  - title 공유 제목
  - desc 공유 구체 설명
  - musicUrl 음악 콘텐츠의 이동 url. 게임의 대응하는 게임센터 세부페이지&게임 자체정의 필드를 입력할 수 있다. 모바일QQ에서 이 대화를 클릭하면 MSDK는 OnWakeupNotify(WakeupRet ret) ret.extInfo를 통해 게임 자체정의 파라미터를 게임에 투과전송한다. 게임에 파라미터를 투과전송할 필요가 없으면 게임센터 세부페이지를 직접 입력하면 된다. 자체정의 필드의 투과전송은 모바일QQ 4.6 및 이상 버전이 지원한다.
예: 게임센터 세부페이지가 “AAAAA”이고 게임 자체정의 필드가 “bbbbb”이면 url은: AAAAA&bbbbb이다. bbbbb는 wakeupRet.extInfo를 통해 게임에 리턴된다.
  - musicDataUrl 이 파라미터는 음악 공유 메시지에서 다음 그림과 같은 재생 버튼을 클릭하여 음악을 직접 재생할 수 있게 한다. 형식은 일반적으로 http://***.mp4
![Alt text](./ShareMusic1.png)
  - imgUrl  iOS에서는 로컬 경로(형식은[NSData dataWithContentsOfFile:path]요구)거나 미리보기URL(http:// ***)일 수 있다. 실제 테스트에서 iOS 모바일QQ 컴포넌트는 URL 이미지 데이터를 먼저 획득한 후 모바일QQ APPAPP를 실행한다는 것이 발견되었다. 네트워크 속도가 늦으면 사용 체험에 영향을 줄 수 있기에 이때는 UI가 배합해줘야 한다.
       Android에서는 미리보기URL만 가능하다.
공유 성공과 실패는 OnShareNotify(ShareRet ret)를 통해 게임에 콜백한다. ret.flag는 부동한 공유 결과를 표시한다. 자세한 내용은 eFlag(부록A) 참조

 - 
```ruby
void WGSendToWeixinWithMusic(const int &scene,
                                 unsigned char* title,
                                 unsigned char* desc,
                                 unsigned char* musicUrl,
                                 unsigned char* musicDataUrl,
                                 unsigned char *mediaTagName,
                                 unsigned char *imgData,
                                 const int &imgDataLen,
                                 unsigned char *messageExt,
                                 unsigned char *messageAction);
```
>설명: App 음악 메시지를 위챗 친구에게 공유. 이 공유를 클릭하면 위챗에서 음악을 재생할 수 있다.
파라미터:
  - scene 모멘트 또는 대화에 공유하는 지 표시
0：위챗 실행, 친구에게만 공유 가능
1：위챗을 실행하고 모멘트 공유창을 기본적으로 팝업
  - title 공유 제목
  - desc 공유 설명
  - musicUrl 음악 콘텐츠의 이동 url
  - musicDataUrl 이 파라미터는 음악 공유 메시지에서 다음 그림과 같은 재생 버튼을 클릭하여 음악을 직접 재생할 수 있게 한다. 형식은 일반적으로 http://***.mp4
  - mediaTagName 사용자가 스스로 설정하는 값. 이 값은 위챗에 전송되어 통계용으로 사용된다. 공유 리턴 시에도 이 값을 반환하며 공유 소스 구분용으로 사용된다
  - imgData공유시 표시하는 썸네일 데이터(32K 이하)
  - imgDataLen 공유시 표시하는 썸네일 길이. thumbImgData와 매칭되어야 하며 비워둘 수 없다
  - messageExt 게임 공유시 이 필드 전송. 위챗에서 이 공유를 클릭하면 게임을 실행하고 MSDK는 이 필드를 게임에 투과전송한다. 위챗5.1 및 이상 버전 필요
  - messageAction 첫번째 파라미터 scene이 1인 경우에만 유효하며 모멘트에 공유하는 메시지에 버튼을 한 개 추가한다. 버튼을 클릭하면 게임 실행, 랭킹 또는 게임페이지로 이동할 수 있다.
     messageAction 값:
     WECHAT_SNS_JUMP_SHOWRANK       랭킹 이동
     WECHAT_SNS_JUMP_URL            링크 이동
     WECHAT_SNS_JUMP_APP           APP 이동
공유 성공과 실패는 OnShareNotify(ShareRet ret)를 통해 게임에 콜백한다. Ret.flag는 부동한 공유 결과를 표시한다. 자세한 내용은 eFlag(부록A) 참조

---

##샘플 코드
 - 음악을 위챗에 공유하는 호출 코드 심플:
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
    NSString *path = [[QQViewController testResourcePath] stringByAppendingPathComponent:@"music.jpg"];//news.jpg
    NSData* data = [NSData dataWithContentsOfFile:path];
    plat->WGSendToWeixinWithMusic(1,                 
                                (unsigned char*)"음악 테스트",  
                                (unsigned char*)"음악 공유 테스트",  
                                (unsigned char*)"http://y.qq.com/#type=song&mid=000cz9pr0xlAId",  
                                 (unsigned char*)"http://tsmusic24.tc.qq.com/M500000cz9pr0xlAId.mp3",      
                                NULL, 
                                 (unsigned char*)[data bytes], 
                                [data length], 
                               NULL, 
                               NULL);
```
 - 콜백 코드 샘플:
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
    NSLog(@"공유 성공");
}
     else if(eFlag_WX_NotInstall == shareRet.flag)
{
    NSLog(@"위챗 미설치");
    }
 else if(eFlag_WX_UserCancel == shareRet.flag)
{
    NSLog(@"유저가 공유 취소");
    }
    else if(eFlag_WX_UserDeny == shareRet.flag)
{
    NSLog(@"유저가 공유 거절");
    }
}
```
 - 음악을 모바일QQ에 공유하는 호출 코드 샘플:
```ruby
NSString *path = [[QQViewController testResourcePath] stringByAppendingPathComponent:@"music.jpg"];        
    plat->WGSendToQQWithMusic(2,
                          (unsigned char*)"음악 테스트",
                              (unsigned char*)"음악 공유 테스트",
                              (unsigned char*)"http://y.qq.com/#type=song&mid=000cz9pr0xlAId",
                              (unsigned char*)"http://tsmusic24.tc.qq.com/M500000cz9pr0xlAId.mp3",
                              (unsigned char*)[path UTF8String]); 
```
또는
```ruby
    WGPlatform *plat = WGPlatform::GetInstance();        
    plat->WGSendToQQWithMusic(1, (unsigned char*)"음악 테스트",
                              (unsigned char*)"음악 공유 테스트",
                              (unsigned char*)"http://y.qq.com/#type=song&mid=000cz9pr0xlAId",
                              (unsigned char*)"http://tsmusic24.tc.qq.com/M500000cz9pr0xlAId.mp3",                              (unsigned char*)"http://www.monsterworking.com/wp-content/uploads/music.jpg");
```
 - 콜백 코드 샘플:
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
        NSLog(@"공유 성공");
    }
    else if(eFlag_QQ_UserCancel == shareRet.flag)
{
        NSLog(@"유저가 공유 취소");
    }
    else if(eFlag_QQ_NetworkErr == shareRet.flag)
    {
        NSLog(@"네트워크 오류");
    }
}
```

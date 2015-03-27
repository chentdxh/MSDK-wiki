QQ 액세스
===

## 액세스 설정

  * 프로젝트 설정의 ‘Target->Info->Custom iOS Target Properties’에서 구성 항목을 추가한다. 주요 구성 항목:

  ![Alt text](./QQ1.png)
  
| Key      |    Type | Value  |비고|관련 모듈|
| :-------- | --------:| :-- |:--|:---:|
| QQAppID  | String |  게임별로 다름 |모바일QQ의 AppID|전부|
| QQAppKey  | String |  게임별로 다름 |모바일QQ의 AppKey|전부|
  
  *	프로젝트 설정의 ‘Target->Info->URL Types’에서 다음과 같이 URL Scheme 설정:
    ![Alt text](./QQ2.png)
	![Alt text](./QQ3.png)
  
| Identifier|    URL Scheme | 예시  | 비고  |
| :-------- | :--------| :--: | :--: |
| tencentopenapi  | 형식: tencent+게임QQAppID |tencent100703379|  모바일QQ 액세스시 필수 입력, 중간에 공백이 없음  |
| QQ  | 형식:QQ+게임QQAppID의 16진수 |QQ06009C93 | 모바일QQ 액세스시 필수 입력, 중간에 공백이 없음  |
| QQLaunch  | 형식: tencentlaunch+게임QQAppID |tencentlaunch100703379|  모바일QQ 액세스시 필수 입력, 중간에 공백이 없음  |

   > **비고：
  1. 게임별로 설정이 다르기에 구체적인 내용은 각 게임과 MSDK 연락 담당자 또는 RTX를 통해 “MSDK연결”에 연락하면 된다. 
  2. Xcode6.0 공정을 만들 때, Bundle Display Name를 설정하지 않았을 가능성이 있어 OpenSDK 해당 이 성정이 있어야 잘 가동할 수 있기 때문에 해당 이 속성이 있는 것을 반드시 확보해야 한다. 없으면 설정하시기 바란다.**
  ![Alt text](./QQ_config.png) 
 ---
## 인증 로그인
 ### 개요
 - 모바일QQ 클라이언트 또는 web페이지를 실행하여 인증을 진행한다. 인증에 성공하면 게임에 openId, accessToken, payToken(부록A 토큰 유형), pf, pfKey를 반환한다.
모바일QQ 인증을 완료하려면 WGSetPermission과 WGLogin 인터페이스를 호출하여 완료해야 한다
```
void WGSetPermission(unsigned int permissions);
```
>설명: QQ 로그인 설정시 유저 인증이 필요한 권한 리스트
파라미터:
- permissions　 WGQZonePermissions 에 모든 권한이 정의되어 있다. 자신에게 필요한 권한을 선택하거나 연산한 결과가 곧 이 파라미터이다.

 - 
```
void WGLogin(ePlatform platform);
```
>설명: 통합 인터페이스에 로그인하고 _ePlatform. ePlatform_QQ을 전송하여 모바일QQ를 호출하여 인증을 진행한다.
파라미터: 
  - ePlatform. ePlatform_QQ를 전송하여 모바일QQ 클라이언트를 호출하여 인증
  - 역 콜백 객체를 설정한 경우, 인증 또는 실패는 OnLoginNotify(LoginRet ret)를 통해 게임에 콜백한다. LoginRet.platform은 목전 인증 플랫폼이다. LoginRet.flag로 인증 결과 식별:
eFlag_Succ                     //성공
    eFlag_QQ_NoAcessToken         //모바일QQ 인증 실패, accesstoken을 획득하지 못함
    eFlag_QQ_UserCancel            //유저가 모바일QQ 인증 취소
    eFlag_QQ_LoginFail             //인증 실패
    eFlag_QQ_NetworkErr           //네트워크 오류


#### 예시 코드
- 인증 호출 코드:
```
WGPlatform* plat = WGPlatform::GetInstance();//MSDK 초기화
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);//콜백 설정
plat->WGSetPermission(eOPEN_ALL);//인증 권한 설정
plat->WGLogin(ePlatform_QQ);//모바일QQ 클라이언트 또는 web를 호출하여 인증
```
- 인증 콜백 코드:
```ruby
void MyObserver::OnLoginNotify(LoginRet& loginRet)
{
if(eFlag_Succ == loginRet.flag)
{
    …//login success
    std::string openId = loginRet.open_id;
    std::string payToken;
    std::string accessToken;
    if(ePlatform_QQ == loginRet.Platform)
    {
        for(int i=0;i< loginRet.token.size();i++)
        {
            TokenRet* pToken = & loginRet.token[i];
            if(eToken_QQ_Pay == pToken->type)
            {
                paytoken = pToken->value;
            }
            else if (eToken_QQ_Access == pToken->type)
{
     accessToken = pToken->value;
}
        }
    }
else if (ePlatform_Weixin == loginRet.platform)
{
        ….
}
} 
else
{
    …//login fail
     NSLog(@"flag=%d,desc=%s",loginRet.flag,loginRet.desc.c_str()); 
}
}
```
- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *authService = [[MSDKAuthService alloc] init];
[authService setPermission:eOPEN_ALL];
[authService login:ePlatform_QQ];
```
- 콜백 코드는 아래와 같다：
```
-(void)OnLoginWithLoginRet:(MSDKLoginRet *)ret
{
    //내부 실현 로직은 void MyObserver::OnLoginNotify(LoginRet& loginRet)와 일치
}
```


####주의사항
- 모바일QQ 버전4.0 및 이상만 클라이언트 인증을 지원한다
- 모바일QQ가 설치되지 않거나 잘못 설정하면 web 인증을 시작한다. Web 인증은 모바일QQ 내장 webVeiw를 불러와 인증을 진행해야 한다. 외부 브라우저를 사용할 경우 RTX를 통해 “MSDK연결”과 연락할 수 있다.
- URL Types 중 scheme tencentopenapi를 정확히 설정해야 모바일QQ 클라이언트를 불러와 인증을 진행할 수 있다.
---
##빠른로그인
###개요
- 모바일QQ 게임 리스트 또는 공유 링크에서 모바일QQ에 로그인된 계정 정보를 게임에 직접 보내어 로그인을 실현할 수 있으며 게임은 다시 인증하지 않아도 된다.

- 환경 의존:
>1. MSDK 1.8.0i 이상;
>2. 모바일QQ 4.6.2 이상;
>3. 게임 구성 scheme:
	![Alt text](./QQ4.png)
- 성공하면 게임을 실행하고 openId, accessToken, payToken(부록A 토큰 유형), pf, pfKey를 전송한다.

- 빠른로그인과 다른계정 결과는 wakeupRet의 flag에서 반환된다. 관련 flag 설명:
```ruby
eFlag_Succ: 
다른계정이 존재하지 않고 성공적으로 실행. 이런 경우는 App를 실행시킨 URL에 토큰이 포함되지 않고 이전 버전의 실행 방식과 일치하다.
eFlag_AccountRefresh: 
다른계정이 존재하지 않고 MSDK가 이미 App를 실행시킨 URL에 포함된 토큰 정보를 통해 로컬 계정 토큰을 새로 고침
eFlag_UrlLogin：
다른계정이 존재하지 않고 게임이 빠른로그인 계정을 이용하여 로그인 성공. 게임이 이 flag를 수신하면 직접 LoginRet 구조체 중 토큰을 획득하여 게임 인증 절차 진행
eFlag_NeedLogin：
게임 로컬 계정과 외부 계정이 모두 로그인 실패. 게임이 이 flag를 수신하면 로그인창을 팝업하여 유저를 로그인하게 해야 한다
eFlag_NeedSelectAccount：
게임 로컬 계정과 외부 계정에 다른계정이 존재. 게임이 이 flag를 수신하면 대화창을 팝업하여 유저에게 로그인할 계정을 선택하게 해야 한다.
flag가 eFlag_NeedSelectAccount일 경우, 게임은 대화창을 팝업하여 유저에게 원래 계정 또는 빠른로그인에 포함된 계정으로 게임에 로그인할 지 문의해야 한다. 이것은 모바일QQ 플랫폼이 반드시 구현해야 하는 로직이며, 구현되지 않으면 플랫폼 심사 시 게임 출시가 거절당한다.
```
제시 예시(화면은 각 게임 별로 구현)
	![Alt text](./QQ5.png)



- 유저가 선택한 후, WGSwitchUser 인터페이스를 호출하여 다른계정 후속 로직을 처리해야 한다.(두개 옵션은 모두 다음의 인터페이스를 호출해야 함. 자세한 내용은 예시 코드 참조)
```ruby
bool WGSwitchUser(bool flag);
```
>설명: 외부에서 실행한 URL을 통해 로그인. 이 인터페이스는 다른계정 발생시 유저가 외부에서 계정 실행시 호출한다.
파라미터:
>- flag
>- YES이면, 유저가 외부 계정으로 바꾸려 한다는 것을 표시한다. 이럴 경우, 이 인터페이스는 지난번에 저장한 다른계정 로그인 데이터를 이용해 게임에 로그인하고 로그인에 성공한 후 onLoginNotify를 통해 콜백한다. 토큰이 없거나 토큰이 무효 함수이면 NO를 리턴하고 onLoginNotify 콜백이 발생하지 않는다.
>- NO이면, 유저가 원래 계정을 계속 사용한다는 것을 표시한다. 이때 저장된 다른계정 데이터를 삭제하여 혼동을 방지한다.
토큰이 없거나 무효하면 NO 리턴; 다른 경우는 YES 리턴

###예시 코드

- app 실행시 콜백 코드 추가
```ruby
-(BOOL)application:(UIApplication*)application openURL:(NSURL *)url sourceApplication:(NSString *)sourceApplication annotation:(id)annotation
{
    NSLog(@"url == %@",url);
    WGPlatform* plat = WGPlatform::GetInstance();
    WGPlatformObserver *ob = plat->GetObserver();
    if (!ob) {
        MyObserver* ob = new MyObserver();
        ob->setViewcontroller(self.viewController);
        plat->WGSetObserver(ob);
    }
    return [WGInterface HandleOpenURL:url];
}
```
- 실행 콜백 코드 예시:

        void MyObserver::OnWakeupNotify (WakeupRet& wakeupRet)
            {
        switch (wakeupRet.flag) {
             case eFlag_Succ:
         [viewController setLogInfo:@"실행 성공"];
        break;
        case eFlag_NeedLogin:
            [viewController setLogInfo:@"다른계정 발생, 로그인 페이지에 들어가야 함"];
            break;
        case eFlag_UrlLogin:
            [viewController setLogInfo:@"다른계정 발생, 외부에서 실행하여 로그인 성공"];
            
            break;
        case eFlag_NeedSelectAccount:
        {
            [viewController setLogInfo:@"다른계정 발생, 유저에게 선택할 것을 제시"];
            UIAlertView *alert = [[[UIAlertView alloc]initWithTitle:@"다른계정" message:@"다른계정이 발견되었습니다. 로그인할 계정을 선택하십시오" delegate:viewController cancelButtonTitle:@"바꾸지 않고 기존 계정 사용" otherButtonTitles:@"외부 계정으로 로그인", nil] autorelease];
            [alert show];
        }
            break;
        case eFlag_AccountRefresh:
            [viewController setLogInfo:@"외부 계정과 로그인된 계정 일치. 외부 토큰을 사용하여 로컬 토큰 갱신"];
            break;
        default:
            break;
         }
            if(eFlag_Succ == wakeupRet.flag ||
       eFlag_NeedLogin == wakeupRet.flag ||
       eFlag_UrlLogin == wakeupRet.flag ||
       eFlag_NeedSelectAccount == wakeupRet.flag ||
       eFlag_AccountRefresh == wakeupRet.flag)
             {
        [viewController setLogInfo:@"실행 성공"];
             }
             else
          {
        [viewController setLogInfo:@"실행 실패"];
          }
            } 

        - (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex {
          BOOL switchFlag = NO;
          switch (buttonIndex) {
             case 0:
            NSLog(@"유저가 계정전환 거절");
            break;
        case 1:
        {
            NSLog(@"유저가 계정전환 선택");
            switchFlag = YES;
        }
            break;
        default:
            break;
                   }
             WGPlatform* plat = WGPlatform::GetInstance();
                          plat->WGSwitchUser(switchFlag);
        }


### 주의사항
- 모바일QQ 버전 4.6 이상만 빠른로그인을 지원한다.
- URL Types 중 scheme 은 tencentlaunch+AppID를 설정해야 실행시 로그인 정보를 운반한다.
- ---

##모바일QQ 관계사슬 조회

- ###개인정보 조회
#### 개요
유저가 모바일QQ 인증을 통과하면 openId와 accessToken만 획득한다. 이때 게임은 유저 닉네임, 성별, 아바타 등 기타 정보를 필요로 한다. 모바일QQ 인증에 성공하면 WGQueryQQMyInfo를 호출하여 개인정보를 획득할 수 있다.
- 
```ruby
bool WGQueryQQMyInfo();
```
>설명: 유저 QQ 계정 기본정보 획득
리턴 값:
  - false:모바일QQ 미인증 또는 AppID 등 설정 오류
  -  true:파라미터 정상
OnRelationNotify(RelationRet& relationRet)를 통해 게임에 콜백
RelationRet(부록A) 구조체 중 PersonInfo의 province와 city 필드 모바일QQ는 비어 있음. 스몰, 일반, 빅이미지 사이즈: 40 40 100(픽셀)

 #### 호출 예시 코드:
- 
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGQueryQQMyInfo();
```
#### 콜백 예시 코드:
- 
```ruby
OnRelationNotify(RelationRet &relationRet)
{
    NSLog(@"relation callback");
    NSLog(@"count == %d",relationRet.persons.size());
    for (int i = 0; i < relationRet.persons.size(); i++)
    {
        PersonInfo logInfo = relationRet.persons[i];
        NSLog(@"nikename == %s",logInfo.nickName.c_str());
        NSLog(@"openid==%s",logInfo.openId.c_str());
    }
}
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용 가능하며 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKRelationService *service = [[MSDKRelationService alloc] init];
[service queryMyInfo];
```
- 콜백 코드 예시：
```
-(void)OnRelationWithRelationRet:(MSDKRelationRet *)ret
{
    //내부 살현 로직은 OnRelationNotify(RelationRet &relationRet)와 일치한다
}
```

 ###게임친구 정보 조회
####개요
- 게임은 인증 후 WGQueryQQGameFriendsInfo를 호출하여 게임에 필요한 유저 게임친구의 닉네임, 성별, 아바타, openid 등 정보를 획득할 수 있다.
```ruby
bool WGQueryQQGameFriendsInfo();
```
>설명: 유저 QQ 게임친구 기본정보 획득
리턴 값:
   - false:모바일QQ 미인증 또는 AppID 등 설정 오류
   - true:파라미터 정상
OnRelationNotify(RelationRet& relationRet)를 통해 게임에 콜백
RelationRet(부록A) 구조체 중 PersonInfo의 province와 city 필드 모바일QQ는 비어 있음. 스몰, 일반, 빅이미지 사이즈: 40, 40, 100(픽셀)

- 호출 예시 코드:
 ```ruby
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGQueryQQGameFriendsInfo();
호출 예시 코드:
OnRelationNotify(RelationRet &relationRet)
{
    NSLog(@"relation callback");
    NSLog(@"count == %d",relationRet.persons.size());
    for (int i = 0; i < relationRet.persons.size(); i++)
    {
        PersonInfo logInfo = relationRet.persons[i];
        NSLog(@"nikename == %s",logInfo.nickName.c_str()]);
        NSLog(@"openid==%s",logInfo.openId.c_str();
    }
}
```
- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKRelationService *service = [[MSDKRelationService alloc] init];
[service queryMyGameFriendsInfo];
```
- 콜백 코드 예시：
```
-(void)OnRelationWithRelationRet:(MSDKRelationRet *)ret
{
    //내부 실현 로직은 OnRelationNotify(RelationRet &relationRet)와 일치한다
}
```

####주의사항
- 모바일QQ 인증 성공
---

##모바일QQ 구조화 메시지 공유
  
-   ###개요
- 모바일QQ 구조화 메시지는 WGSendToQQ를 통해 모바일QQ 공유를 진행할 수 있으며 모바일QQ에서 공유할 대상(그룹, 토론그룹, 친구) 또는 QZone을 선택할 수 있다. 게임 내에서 직접 WGSendToQQGameFriend 인터페이스를 통해 지정된 친구에게 공유할 수 있지만(모바일QQ를 실행하지 않음) 지정된 친구의 openId가 필요하기에 게임친구에게만 공유가 가능하다.

 ###모바일QQ 클라이언트를 불러와서 공유 진행
- 모바일QQ(iphone버전) 또는 웹페이지를 통해 모바일QQ 내부에서 공유할 친구 또는 Qzone을 선택한다. 모바일QQ대화에서 이 대화를 클릭하면 전송된 url을 방문한다. 보통 이 url은 게임의 모바일QQ 게임센터 세부페이지로 설정된다. Qzone에서 이 메시지를 클릭하면 큰 사이즈로 이미지를 표시한다. 웹페이지 공유는 사용 체험이 뒤떨어지기에 사용을 권장하지 않는다. 게임은 팝업창으로 유저에게 모바일QQ를 설치하라고 제시할 수 있다.
 ```ruby
void WGSendToQQ(const eQQScene[Int는 eQQScene로 전환]& scene, unsigned char* title,  unsigned char* desc,   unsigned char* url,  unsigned char* imgData, const int& imgDataLen);
```
>설명: 메시지를 모바일QQ 대화 또는 Qzone에 공유. url은 게임 모바일QQ 게임센터 세부페이지 입력. 메시지를 클릭하면 모바일QQ 게임센터에서 게임을 실행한다.
파라미터:
    - scene 모멘트 또는 대화에 공유할 지 표시
    - QQScene_Qzone: 모바일QQ를 깨우고 ‘공간에 공유’ 팝업창을 기본적으로 출력
    - QQScene_session：모바일QQ를 깨우고 Qzone이 없이 친구에게만 공유 가능
    - title 공유 제목
    - desc 공유 구체적 설명
- url 내용의 이동 url. 게임의 대응하는 게임센터 세부페이지&게임 자체정의 필드 입력. 모바일QQ에서 이 대화를 클릭하면 MSDK는 OnWakeupNotify(Wakeu    pRet ret) ret.extInfo를 통해 게임 자체정의 파라미터를 게임에 투과전송한다. 게임에 파라미터를 투과전송할 필요가 없으면 게임센터 세부페이지를 직접 입력하면 된다. 자체정의 필드의 투과전송은 모바일QQ 4.6 및 이상 버전이 지원한다.
예: 게임센터 세부페이지가 “AAAAA”이고 게임 자체정의 필드가 “bbbbb”이면 url은: AAAAA&bbbbb이다. bbbbb는 wakeupRet.extInfo를 통해 게임에 리턴된다
    - imgData 이미지 파일 데이터
    - imgDataLen 이미지 파일 데이터 길이
공유 성공과 실패시 OnShareNotify(ShareRet ret)를 통해 게임에 콜백한다. ret.flag는 부동한 공유 결과를 표시한다.자세한 내용은 eFlag(부록A) 참조

	호출 코드 예시:
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver();
plat->WGSetObserver(ob);
NSString* gameid=@"통통이";
NSString* question=@"왜 움직이지 않는거지";
NSString* 	url=@"XXXXX"
NSString *path = "188.jpg"
NSData* data = [NSData dataWithContentsOfFile:path];
plat->WGSendToQQ(
                     1,
                     (unsigned char*)[gameid UTF8String],
                     (unsigned char*)[question UTF8String],
                     (unsigned char*) [url UTF8String],
                     (unsigned char*)[data bytes],
                     [data length]
                     ); 
	콜백 코드 예시:
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

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKShareService *service = [[MSDKShareService alloc] init];
[service WGSendToQQ:QQScene_QZone
title:(unsigned char*)[gameid UTF8String]
desc:(unsigned char*)[revStr UTF8String]
url:(unsigned char*)"XXXX"
imgData:NULL
imgDataLen:0];
```
- 콜백 코드 예시：
```
-(void)OnShareWithShareRet:(MSDKShareRet *)ret
{
    //내부 실현 로직은 void MyObserver::OnShareNotify(ShareRet& shareRet)와 일치한다
}
```

###직접 친구에게 공유(모바일QQ 클라이언트를 불러올 필요가 없음)
####개요
- 모바일QQ 클라이언트를 불러오지 않고 지정된 게임친구에게 직접 발송. 게임친구의 openId는 WGQueryQQGameFriendsInfo 인터페이스를 통해 획득할 수 있다. 이 공유 메시지는 pc QQ에서 출력되지 않는다.
```ruby
bool WGSendToQQGameFriend(int act, unsigned char* fopenid, unsigned char *title, unsigned char *summary, unsigned char *targetUrl, unsigned char *imgUrl, unsigned char* previewText, unsigned char* gameTag, unsigned char* extMsdkInfo[1.7.0i])
```
>설명: 일대일 지향적 공유(메시지를 모바일QQ 친구에게 공유, 대화창에서 표시). 공유한 내용은 모바일QQ에서만 볼 수 있고 PCQQ에서는 보이지 않는다. 모바일QQ에서 이 대화를 클릭하면 게임을 실행할 수 있다
리턴 값:
     false:모바일QQ 미인증 또는 잘못된 파라미터
     true:파라미터 정상
파라미터: 
 - act 필수 파라미터
0：모바일QQ에서 이 공유 메시지를 클릭하면 targetUrl 주소로 이동
1：모바일QQ에서 이 공유 메시지를 클릭하면 게임 실행
 - fopenid 필수 파라미터  친구의 대응하는 게임의 openid, 이 친구에게 공유
 - title필수 파라미터   공유 제목
 - summary 필수 파라미터   개요
 - targetUrl 필수 파라미터 공유url
 - imgUrl 필수 파라미터 
공유 이미지 url(이미지 사이즈는 128*128; 웹주소는 방문할 수 있어야 한다; 크기는 2M를 초과하지 못한다)
 - previewText비필수
 - 공유한 문자 내용, 비워둘 수 있다. 예를 들면, “2Day’s Match를 놀고 있어요”, 길이는 45바이트를 초과하지 못한다
 - gameTag 비필수
    game_tag	플랫폼이 공유 유형에 대한 통계용, 예하면 하트 보내기 공유, 초월 공유, 이 값은 게임이 책정하고 동기적으로 모바일QQ 플랫폼에 전송한다. 현재 값:
MSG_INVITE                //초대
MSG_FRIEND_EXCEED       //초월 자랑하기
MSG_HEART_SEND          //하트 보내기
  MSG_SHARE_FRIEND_PVP    //PVP 대전
 - extMsdkInfo 공유시 게임이 전송하며 ShareRet.extInfo를 통해 게임에 콜백한다. [1.7.0i]
공유가 끝나면 OnShareCallBack(ShareRet ret)를 통해 게임에 콜백한다. Ret.flag로 부동한 공유 결과를 표시한다. 자세한 내용은 eFlag(부록A) 참조


 - 호출 코드 예시:
```ruby
unsigned char* openid = (unsigned char*)"86EA9CA0C965B7EE9793E7D0B29161B8";
unsigned char* picUrl = (unsigned char*)"XXXXX";
unsigned char* title = (unsigned char*)" msdk가 QQ 공유를 테스트하러 왔어요";
unsigned char* target_url = (unsigned char*)"http://www.qq.com";
unsigned char* summary = (unsigned char*)"msdk 개요도 왔어요";
unsigned char* previewText = (unsigned char*)" Craz3 Match을 놀고 있어요";
unsigned char* game_tag = (unsigned char*)"MSG_INVITE";
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGSendToQQGameFriend(
                               1,
                               openid1,
                               title,
                               summary,
                               target_url,
                               picUrl,
                               previewText,
                               game_tag
                               );
```
콜백 코드 예시:
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
        NSLog(@"공유 성공");
    }
    else 
{
   NSLog(@"error message = %s",shareRet.desc.c_str()); 
    }
}
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같다：
```
[MSDKService setMSDKDelegate:self];
MSDKShareService *service = [[MSDKShareService alloc] init];
[service WGSendToQQGameFriend:0
fopenid:(unsigned char *)"E7B0E64C39A09127A698326F4941A9B6"
title:(unsigned char *)"WGShare_WGSendToQQGameFriend_LONG_URL"
summary:(unsigned char *)"WGShare_WGSendToQQGameFriend_LONG_URL_Summary"
targetUrl:(unsigned char *)"http://bbs.oa.com"
imgUrl:(unsigned char *)"http://bbs.oa.com"
previewText:(unsigned char *)"WGShare_WGSendToQQGameFriend_LONG_URL_PreviewText"
gameTag:(unsigned char *)"MSG_INVITE"];
```
- 콜백 코드 예시：
```
-(void)OnShareWithShareRet:(MSDKShareRet *)ret
{
    //내부 실현 로직은 void MyObserver::OnShareNotify(ShareRet& shareRet)와 일치한다
}
```

####주의사항
 - 모바일QQ 버전 4.0 및 이상 필요
 - 직접 공유는 우선 모바일QQ 인증에 성공해야 한다
 - 모바일QQ를 깨워 Qzone에 공유하는 팝업창은 모바일QQ 4.5 및 이상 버전 필요
 - WGSendToQQ 자체정의 필드 투과전송은 모바일QQ 4.6 및 이상 버전 필요
##모바일QQ 빅이미지 공유
###개요
WGSendToQQWithPhoto를 호출하면 모바일QQ를 깨워 모바일QQ 내부에서 공유할 친구 또는 공간을 선택하여 빅이미지 공유를 진행한다. 모바일QQ에서 이 공지 메시지를 클릭하면 전체 화면으로 그림을 미리보기할 수 있다.
```ruby
void WGSendToQQWithPhoto(const eQQScene[Int에서 eQQScene 전환]& scene, unsigned char* imgData, const int& imgDataLen)
```
>설명: 메시지를 모바일QQ 대화 또는 Qzone에 공유
  -  scene 모멘트 또는 대화에 공유할 지 표시
QQScene_Qzone: 모바일QQ를 깨우고 ‘공간에 공유’ 팝업창을 기본적으로 출력
QQScene_session：모바일QQ를 깨우고 Qzone이 없이 친구에게만 공유 가능
  - imgData 이미지 파일 데이터
  - imgDataLen 이미지 파일 데이터 길이

 - 공유 성공과 실패시 OnShareNotify(ShareRet ret)를 통해 게임에 콜백한다. ret.flag는 부동한 공유 결과를 표시한다.자세한 내용은 eFlag(부록A) 참조
###예시 코드
호출 코드 예시:
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
MyObserver* ob = new MyObserver();
ob->setViewcontroller(self);
plat->WGSetObserver(ob);
NSString *path = "422.png";
NSData* data = [NSData dataWithContentsOfFile:path];
plat->WGSendToQQWithPhoto(1,(unsigned char*)[data bytes], [data length]);
```
 - 콜백 코드 예시:
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
        NSLog(@"공유 성공");
}
else if(eFlag_QQ_NotInstall == shareRet.flag)
{
        NSLog(@"모바일QQ가 설치되지 않음");
    }
    else if(eFlag_QQ_UserCancel == shareRet.flag)
{
        NSLog(@"유저가 공유 취소");
    }
    else if(eFlag_QQ_NetworkErr == shareRet.flag)
    {
            NSLog(@"네트워크 오류");[코드 들여쓰기 통일화]
    }
}
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같다：
```
UIImage *image = [UIImage imageNamed:@"422.png"];
NSData *data = UIImageJPEGRepresentation(image, 1.0);
[MSDKService setMSDKDelegate:self];
MSDKShareService *service = [[MSDKShareService alloc] init];
[shareService WGSendToQQWithPhoto:QQScene_QZone
imgData:(unsigned char*)[data bytes]
imgDataLen:(int)[data length]];
```
- 콜백 코드 예시：
```
-(void)OnShareWithShareRet:(MSDKShareRet *)ret
{
    //내부 실현 로직은 void MyObserver::OnShareNotify(ShareRet& shareRet)와 일치한다
}
```

###주의사항
 - 모바일QQ 4.2 및 이상 버전
 - 모바일QQ를 깨워 Qzone에 공유하는 팝업창은 모바일QQ 4.5 및 이상 버전 필요
 - web를 통해 공유 불가능
 ---
##모바일QQ 액세스 주의사항
 - ###모바일QQ 기능과 지원하는 버전
‘WGGetIphoneQQVersion()’ 방법을 통해 모바일QQ 버전 번호를 획득할 수 있다.
```ruby
int WGGetIphoneQQVersion();
```
[MSDKInfoService getIphoneQQVersion];//2.4.0i및 이후 버전
>설명: 유저 QQ 계정 기본정보 획득
    모바일QQ 버전 열거:
        typedef enum QQVersion
    	{
        kQQVersion3_0,
        kQQVersion4_0,      //sso로그인 지원
    	kQQVersion4_2_1,    //ios7 호환
    	kQQVersion4_5,      //버전 4.5
    	kQQVersion4_6,      //버전 4.6
	    } QQVersion;
리턴 값:
   모바일QQ 버전

- 기능 및 상응한 모바일QQ 버전

|기능|	설명|	모바일QQ 지원 버전|
|----|----|----|
|인증|		|4.0 및 이상|
|구조화 공유|	|	4.0 및 이상|
|빅이미지 공유	||	4.0 및 이상|
|QZone 공유 팝업창|	모바일QQ를 깨울 때 기본적으로 대화창 팝업|	4.5 및 이상|
|빠른로그인|	모바일QQ가 불러온 게임이 로그인 상태에 있음|4.6 및 이상|
|구조화 메시지 투과전송 필드|	MSDK는 이 필드를 게임에 투과전송한다|	|
|다른계정|	플랫폼이 불러온 게임이 openid를 게임에 운반 여부(다른계정)|	4.2 및 이상|

##모바일QQ 게임내에서 친구와 그룹 추가
 - ###개요
다음 인터페이스는 2.0.2i 이후에 제공되고 모바일QQ 5.1 이상 버전이 필요하며 App id가 모바일QQ 백그라운드에서 심사를 통과하고 출시되어야 한다.
WGAddGameFriendToQQ: 게임내에서 다른 유저를 선택하고 이 인터페이스를 호출하여 친구 추가 가능;
WGBindQQGroup:길드장은 자신이 만든 그룹을 선택하여 해당 길드의 길드 그룹으로 바인딩할 수 있다.
```ruby
void WGAddGameFriendToQQ(
unsigned char* cFopenid, unsigned char* cDesc, unsigned char* cMessage)
```
>설명: 인게임 친구추가
  - 파라미터:
  - cFopenid  필수 파라미터  친구의 openid를 추가해야 함
  - cDesc  필수 파라미터  친구의 비고를 추가해야 함
  - cMessage    친구 추가시 발송한 인증 정보
  추가 성공 또는 실패는 OnShareNotify(ShareRet ret)를 통해 게임에 콜백. ret.flag는 부동한 공유 결과 표시. 자세한 내용은 eFlag(부록A) 참조

 ```ruby
void  WGBindQQGroup (unsigned char* cUnionid, unsigned char* cUnion_name,
                       unsigned char* cZoneid, unsigned char* cSignature)
```
>설명: 게임 그룹 바인딩: 게임 길드/연맹 내에서 길드장은 “바인딩” 버튼을 클릭하여 길드장이 만든 그룹을 불러와 해당 길드의 길드 그룹으로 바인딩시킬 수 있다
  - 파라미터:
  - cUnionid 길드ID, opensdk는 숫자만 입력 가능, 문자를 입력하면 바인딩 실패를 초래할 수 있음. 하나의 길드는 1개 그룹만 바인딩 가능. 바인딩을 해제하려면 QQ API 문서(다음)를 참조. 다른 질문이 있으면 rtx를 통해 OpenAPIHelper(OpenAPI 기술지원) 연락. http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup
  - cUnion_name 길드명
  - cZoneid 큰구역 ID, opensdk는 숫자만 입력 가능, 문자를 입력하면 바인딩 실패를 초래할 수 있음
  - cSignature 게임 맹주 신분 인증 서명, 생성 알고리즘은 openid_AppID_appkey_길드id_구역id md5 생성
  추가 성공 또는 실패는 OnShareNotify(ShareRet ret)를 통해 게임에 콜백. ret.flag는 부동한 공유 결과 표시. 자세한 내용은 eFlag(부록A) 참조
  
 - ###예시 코드 
 호출 코드 예시:
```ruby
WGPlatform* plat = WGPlatform::GetInstance();
//친구추가
plat->WGAddGameFriendToQQ((unsigned char*)"D2DEFFFBE310779E88CD067C9D3329E5", (unsigned char*)"친구추가 테스트", (unsigned char*)"안녕~");
  //그룹 바인딩
    LoginRet ret;
    plat->WGGetLoginRecord(ret);    
    NSString *uinionId = @"1";
    NSString *zoneId = @"1";
    NSString *openId = [NSString stringWithCString:ret.open_id.c_str() encoding:NSUTF8StringEncoding];
    NSString *AppID = @"100703379";
    NSString *appKey = @"4578e54fb3a1bd18e0681bc1c734514e";
    NSString *orgSigStr = [NSString stringWithFormat:@"%ld",(unsigned long)[[NSString stringWithFormat:@"%@_%@_%@_%@_%@",openId,AppID,appKey,uinionId,zoneId]hash]];
    
    plat->WGBindQQGroup((unsigned char*)"1", (unsigned char*)"1", (unsigned char*)"test", (unsigned char*)[orgSigStr UTF8String]);
```
콜백 코드 예시:
```ruby
void MyObserver::OnShareNotify(ShareRet& shareRet)
{
    if (eFlag_Succ == shareRet.flag)
{
        NSLog(@"공유 성공");
}
else if(eFlag_QQ_NotInstall == shareRet.flag)
{
        NSLog(@"모바일QQ가 설치되지 않음");
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

- 2.4.0i 및 이후버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같다：
```
//친구 추가
MSDKRelationService *service = [[MSDKRelationService alloc] init];
[service addFriend:@"C1BF66286792F24E166C9A5D27CFB519"
remark:@"친구 추가 테스트"
description:@"안녕하세요～"
subId:nil];
//그룹 바인딩
NSString *uinionId = @"33";
NSString *zoneId = @"1";
NSString *openId = [NSString stringWithCString:ret.open_id.c_str() encoding:NSUTF8StringEncoding];
NSString *appId = @"100703379";
NSString *appKey = @"4578e54fb3a1bd18e0681bc1c734514e";
NSString *orgSigStr = [NSString stringWithFormat:@"%@_%@_%@_%@_%@",openId,appId,appKey,uinionId,zoneId];
NSString *md5Str = [self md5HexDigest:orgSigStr];
MSDKRelationService *service = [[MSDKRelationService alloc] init];
[service bindGroup:md5Str
unionId:uinionId
zoneId:zoneId
appDisplayName:@"MSDKSampleTest"];
```
- 콜백 코드 예시：
```
-(void)OnShareWithShareRet:(MSDKShareRet *)ret
{
    //내부 실현 로직은 void MyObserver::OnShareNotify(ShareRet& shareRet)와 일치한다
}
```

###주의사항
 - 모바일QQ 5.1 및 이상 버전
 - 하나의 길드는 1개 그룹만 바인딩 가능. 바인딩을 해제하려면 QQ API 문서(다음)를 참조. 다른 질문이 있으면 rtx를 통해 OpenAPIHelper(OpenAPI 기술지원) 연락.
http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup
 - 인게임 친구/그룹 바인딩 인터페이스를 사용하려면 액세스한 App id가 모바일QQ 백그라운드에서 심사를 통과하고 출시되어야 한다
 ---

 ## FAQ
 ###주의 사항
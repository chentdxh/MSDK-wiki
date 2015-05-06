QQ 연동
===

## 연동 설정

  * 프로젝트 설정 ‘Target->Info->Custom iOS Target Properties’에서 설정 항목을 추가합니다. 주요 설정 항목은 아래와 같습니다.

  ![Alt text](./QQ1.png)
  
| Key      |    Type | Value  |비고|관련 모듈|
| :-------- | --------:| :-- |:--|:---:|
| QQAppID  | String |  게임별로 다름 |모바일QQ의 AppID|모두|
| QQAppKey  | String |  게임별로 다름 |모바일QQ의 AppKey|모두|
  
  *	프로젝트 설정 ‘Target->Info->URL Types’에서 다음과 같이 URL Scheme 설정합니다.
    ![Alt text](./QQ2.png)
	![Alt text](./QQ3.png)
  
| Identifier|    URL Scheme | 예시  | 비고  |
| :-------- | :--------| :--: | :--: |
| tencentopenapi  | 포맷: tencent+게임QQAppID |tencent100703379|  모바일QQ 연동시 필수 입력, 중간 빈칸 불가  |
| QQ  | 형식:QQ+게임QQAppID의 16진수 |QQ06009C93 | 모바일QQ 연동시 필수 입력, 중간에 공백이 없음  |
| QQLaunch  | 형식: tencentlaunch+게임QQAppID |tencentlaunch100703379|  모바일QQ 연동시 필수 입력, 중간 빈칸 불가 |

   > **비고：
  1. 게임별로 설정이 다르므로 자세한 내용은 운영팀을 통하여 MSDK 담당자한테 문의 바랍니다. 
  2. Xcode6.0 프로젝트 생성 시 Bundle Display Name를 설정하지 않을 가능성이 있습니다.OpenSDK 해당 설정이 있어야 정확히 실행할 수 있으므로 해당 속성을 확보하여야 합니다.아닐 경우 설정 바랍니다.**
  ![Alt text](./QQ_config.png) 
 ---
## 인증 로그인
 ### 개요
 - 모바일QQ 클라이언트 혹은 web페이지를 실행하여 인증을 진행합니다. 인증에 성공하면 게임에 openId, accessToken, payToken(부록A 토큰 유형), pf, pfKey를 리턴합니다.
모바일QQ 인증을 완료하려면 WGSetPermission과 WGLogin 인터페이스를 호출하여야 합니다.
```
void WGSetPermission(unsigned int permissions);
```
>설명: QQ 로그인 설정시 유저 인증이 필요한 권한 리스트
파라미터:
- permissions　 WGQZonePermissions 에 모든 권한이 정의되어 있습니다. 게임에서 필요한 권한을 선택하거나 연산한 결과는 곧 이 파라미터입니다.

 - 
```
void WGLogin(ePlatform platform);
```
>설명: 통합 인터페이스에 로그인하고 _ePlatform. ePlatform_QQ을 전송하여 모바일QQ를 호출하여 인증을 진행합니다.
파라미터: 
  - ePlatform. ePlatform_QQ를 전송하여 모바일QQ 클라이언트를 호출하여 인증합니다.
  - 전역 콜백 객체를 설정한 경우, 인증 혹은 실패는 OnLoginNotify(LoginRet ret)를 통하여 게임에 콜백합니다. LoginRet.platform은 현재 인증 플랫폼이며 LoginRet.flag로 인증 결과를 식별합니다.
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
plat->WGLogin(ePlatform_QQ);//모바일QQ 클라이언트 혹은 web를 호출하여 인증
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
- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같습니다.
```
[MSDKService setMSDKDelegate:self];
MSDKAuthService *authService = [[MSDKAuthService alloc] init];
[authService setPermission:eOPEN_ALL];
[authService login:ePlatform_QQ];
```
- 콜백 코드는 아래와 같습니다.
```
-(void)OnLoginWithLoginRet:(MSDKLoginRet *)ret
{
    //내부 구현 로직은 void MyObserver::OnLoginNotify(LoginRet& loginRet)와 일치합니다.
}
```


####주의사항
- 모바일QQ 버전4.0 및 그 이상 버전만 클라이언트 인증을 지원합니다.
- 모바일QQ가 설치되지 않거나 잘못 설정하면 web 인증을 시작합니다. Web 인증은 모바일QQ 내장 webVeiw를 불러와 인증을 진행하여야 합니다. 외부 브라우저를 사용할 경우 운영팀을 통하여 MSDK 담당자한테 문의 바랍니다.
- URL Types 중 scheme tencentopenapi를 정확히 설정해야 모바일QQ 클라이언트를 불러와 인증을 진행할 수 있습니다.
---
##퀵로그인
###개요
- 모바일QQ 게임 리스트 혹은 공유 링크에서 모바일QQ에 로그인된 계정 정보를 게임에 직접 보내어 로그인을 구현할 수 있으며 게임은 다시 인증하지 않아도 됩니다.

- 환경 의존:
>1. MSDK 1.8.0i 이상;
>2. 모바일QQ 4.6.2 이상;
>3. 게임 구성 scheme:
	![Alt text](./QQ4.png)
- 성공하면 게임을 실행하고 openId, accessToken, payToken(부록A 토큰 유형), pf, pfKey를 전송합니다.

- 퀵로그인과 Diff계정 결과는 wakeupRet의 flag에서 리턴합니다. 관련 flag 설명은 아래와 같습니다.
```ruby
eFlag_Succ: 
Diff계정이 존재하지 않고 성공적으로 실행. 이런 경우는 App를 실행시킨 URL에 토큰이 포함되지 않고 이전 버전의 실행 방식과 일치합니다.
eFlag_AccountRefresh: 
Diff계정이 존재하지 않고 MSDK에서 이미 App를 실행시킨 URL에 포함된 토큰 정보를 통하여 로컬 계정 토큰을 리셋하였습니다.
eFlag_UrlLogin：
Diff계정이 존재하지 않고 게임이 퀵로그인 계정을 이용하여 로그인 성공. 게임에서 이 flag를 받으면 직접 LoginRet 구조체 중 토큰을 획득하여 게임 인증 절차를 진행합니다.
eFlag_NeedLogin：
게임 로컬 계정과 외부 계정이 모두 로그인 실패. 게임에서 이 flag를 받으면 로그인창을 팝업하여 유저들이 로그인하도록 안내합니다.
eFlag_NeedSelectAccount：
게임 로컬 계정과 외부 계정에 Diff계정이 존재. 게임에서 이 flag를 받으면 대화창을 팝업하여 유저에게 로그인할 계정을 선택하도록 안내합니다.
flag가 eFlag_NeedSelectAccount일 경우, 게임은 대화창을 팝업하여 유저에게 기존 계정 혹은 퀵로그인에 포함된 계정으로 게임에 로그인하도록 안내합니다. 이것은 모바일QQ 플랫폼의 필수항목이므로 구현되지 않았을 경우 플랫폼 심사 시 게임 출시 불가능합니다.
```
제시 예시(화면은 각 게임 별로 구현)
	![Alt text](./QQ5.png)



- 유저가 선택한 후, WGSwitchUser 인터페이스를 호출하여 Diff계정 향후 로직을 처리하여야 합니다.(두개 옵션은 모두 다음의 인터페이스를 호출해야 하며 자세한 내용은 예시 코드 참조 바랍니다.)
```ruby
bool WGSwitchUser(bool flag);
```
>설명: 외부에서 실행한 URL을 통하여 로그인. 이 인터페이스는 Diff계정 발생시 유저가 외부에서 계정 실행시 호출합니다.
파라미터:
>- flag
>- YES이면, 유저가 외부 계정으로 바꾸려 한다는 것을 표시합니다. 이럴 경우 이 인터페이스는 전에 저장한 Diff계정 로그인 데이터를 이용해 게임에 로그인하고 로그인에 성공한 후 onLoginNotify를 통하여 콜백합니다. 토큰이 없거나 토큰이 무효 함수이면 NO를 리턴하고 onLoginNotify 콜백이 발생하지 않습니다.
>- NO이면, 유저가 기존 계정을 계속 사용한다는 것을 표시합니다. 이럴 경우 저장된 Diff계정 데이터를 삭제합니다.
토큰이 없거나 무효하면 NO 리턴하며 다른 경우는 YES 리턴합니다.

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
            [viewController setLogInfo:@"Diff계정 발생, 로그인 페이지에 들어가야 함"];
            break;
        case eFlag_UrlLogin:
            [viewController setLogInfo:@"Diff계정 발생, 외부에서 실행하여 로그인 성공"];
            
            break;
        case eFlag_NeedSelectAccount:
        {
            [viewController setLogInfo:@"Diff계정 발생, 유저에게 선택할 것을 안내"];
            UIAlertView *alert = [[[UIAlertView alloc]initWithTitle:@"Diff계정" message:@"Diff계정이 발견되었습니다. 로그인할 계정을 선택하세요." delegate:viewController cancelButtonTitle:@"바꾸지 않고 기존 계정 사용" otherButtonTitles:@"외부 계정으로 로그인", nil] autorelease];
            [alert show];
        }
            break;
        case eFlag_AccountRefresh:
            [viewController setLogInfo:@"외부 계정과 로그인된 계정 일치. 외부 토큰을 사용하여 로컬 토큰 업데이트"];
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
- 모바일QQ 버전 4.6 이상만 퀵로그인을 지원합니다.
- URL Types 중 scheme 은 tencentlaunch+AppID를 설정해야 실행시 로그인 정보를 전송합니다.
- ---

##모바일QQ SNS친구정보 조회

- ###개인정보 조회
#### 개요
유저가 모바일QQ 인증을 통과하면 openId와 accessToken만 획득합니다. 이럴 경우 게임은 유저 닉네임, 성별, 아바타 등 기타 정보를 필요로 합니다. 모바일QQ 인증에 성공하면 WGQueryQQMyInfo를 호출하여 개인정보를 획득할 수 있습니다.
- 
```ruby
bool WGQueryQQMyInfo();
```
>설명: 유저 QQ 계정 기본정보 획득
리턴 값:
  - false:모바일QQ 미인증 혹은 AppID 등 설정 오류
  -  true:파라미터 정상
OnRelationNotify(RelationRet& relationRet)를 통하여 게임에 콜백
RelationRet(부록A) 구조체 중 PersonInfo의 province와 city 필드 모바일QQ는 비어 있습니다. 소,중,대이미지 사이즈: 40 40 100(픽셀)

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

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같습니다.
```
[MSDKService setMSDKDelegate:self];
MSDKRelationService *service = [[MSDKRelationService alloc] init];
[service queryMyInfo];
```
- 콜백 코드 예시：
```
-(void)OnRelationWithRelationRet:(MSDKRelationRet *)ret
{
    //내부 구현 로직은 OnRelationNotify(RelationRet &relationRet)와 일치합니다.
}
```

 ###게임친구 정보 조회
####개요
- 게임은 인증 후 WGQueryQQGameFriendsInfo를 호출하여 게임에 필요한 유저 게임친구의 닉네임, 성별, 아바타, openid 등 정보를 획득할 수 있습니다.
```ruby
bool WGQueryQQGameFriendsInfo();
```
>설명: 유저 QQ 게임친구 기본정보 획득
리턴 값:
   - false:모바일QQ 미인증 혹은 AppID 등 설정 오류
   - true:파라미터 정상
OnRelationNotify(RelationRet& relationRet)를 통하여 게임에 콜백
RelationRet(부록A) 구조체 중 PersonInfo의 province와 city 필드 모바일QQ는 비어 있습니다. 소,중,대이미지 사이즈: 40, 40, 100(픽셀)

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
- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같습니다.
```
[MSDKService setMSDKDelegate:self];
MSDKRelationService *service = [[MSDKRelationService alloc] init];
[service queryMyGameFriendsInfo];
```
- 콜백 코드 예시：
```
-(void)OnRelationWithRelationRet:(MSDKRelationRet *)ret
{
    //내부 구현 로직은 OnRelationNotify(RelationRet &relationRet)와 일치합니다.
}
```

####주의사항
- 모바일QQ 인증 성공
---

##모바일QQ 구조화 메시지 공유
  
-   ###개요
- 모바일QQ 구조화 메시지는 WGSendToQQ를 통하여 모바일QQ 공유를 진행할 수 있으며 모바일QQ에서 공유할 대상(그룹, 토론그룹, 친구) 혹은 QZone을 선택할 수 있습니다. 게임 내에서 직접 WGSendToQQGameFriend 인터페이스를 통하여 지정된 친구에게 공유할 수 있지만(모바일QQ를 실행하지 않음) 지정된 친구의 openId가 필요하므로 게임친구에게만 공유 가능합니다.

 ###모바일QQ 클라이언트를 불러와서 공유 진행
- 모바일QQ(iphone버전) 혹은 웹페이지를 통하여 모바일QQ 내부에서 공유할 친구 혹은 Qzone을 선택합니다. 모바일QQ대화에서 이 대화를 클릭하면 전송된 url을 방문합니다. 일반적으로 이 url은 게임의 모바일QQ 게임센터 세부페이지로 설정됩니다. Qzone에서 이 메시지를 클릭하면 큰 사이즈로 이미지를 표시합니다. 웹페이지 공유는 유저 체험이 좋지 않으므로 권장하지 않습니다. 게임에서 팝업창으로 유저한테 모바일QQ를 설치할 것을 안내합니다.
 ```ruby
void WGSendToQQ(const eQQScene[Int는 eQQScene로 전환]& scene, unsigned char* title,  unsigned char* desc,   unsigned char* url,  unsigned char* imgData, const int& imgDataLen);
```
>설명: 메시지를 모바일QQ 대화 혹은 Qzone에 공유. url은 게임 모바일QQ 게임센터 세부페이지 입력. 메시지를 클릭하면 모바일QQ 게임센터에서 게임을 실행합니다.
파라미터:
    - scene 모멘트 혹은 대화에 공유할 지 표시
    - QQScene_Qzone: 모바일QQ 호출 후 ‘Qzone 공유’ 팝업창을 디폴트로 출력
    - QQScene_session：모바일QQ 호출 후 Qzone이 없으면 친구에게만 공유
    - title 공유 제목
    - desc 공유 구체적 설명
- url 내용의 이동 url. 게임에 해당한 게임센터 세부페이지&게임 자체정의 필드 입력. 모바일QQ에서 이 대화를 클릭하면 MSDK는 OnWakeupNotify(Wakeu    pRet ret) ret.extInfo를 통하여 게임 자체정의 파라미터를 게임에 투과전송합니다. 게임에 파라미터를 투과전송할 필요가 없으면 게임센터 세부페이지를 직접 입력하면 됩니다. 자체정의 필드의 투과전송은 모바일QQ 4.6 및 이상 버전에서만 지원 가능합니다.
예: 게임센터 세부페이지가 “AAAAA”이고 게임 자체정의 필드가 “bbbbb”이면 url은: AAAAA&bbbbb이다. bbbbb는 wakeupRet.extInfo를 통하여 게임에 리턴된다
    - imgData 이미지 파일 데이터
    - imgDataLen 이미지 파일 데이터 길이
공유 성공과 실패시 OnShareNotify(ShareRet ret)를 통하여 게임에 콜백합니다. ret.flag는 부동한 공유 결과를 표시하며 자세한 내용은 eFlag(부록A) 참조 바랍니다.

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
    NSLog(@"유저 공유 취소");
    }
    else if(eFlag_QQ_NetworkErr == shareRet.flag)
    {
        NSLog(@"네트워크 오류");
    }
}
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같습니다.
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
    //내부 구현 로직은 void MyObserver::OnShareNotify(ShareRet& shareRet)와 일치합니다.
}
```

###직접 친구에게 공유(모바일QQ 클라이언트를 불러올 필요가 없습니다.)
####개요
- 모바일QQ 클라이언트를 불러오지 않고 지정된 게임친구에게 직접 발송할 수 있습니다. 게임친구의 openId는 WGQueryQQGameFriendsInfo 인터페이스를 통하여 획득할 수 있으며 이 공유 메시지는 pc QQ에서 출력되지 않습니다.
```ruby
bool WGSendToQQGameFriend(int act, unsigned char* fopenid, unsigned char *title, unsigned char *summary, unsigned char *targetUrl, unsigned char *imgUrl, unsigned char* previewText, unsigned char* gameTag, unsigned char* extMsdkInfo[1.7.0i])
```
>설명: 1:1 공유(메시지를 모바일QQ 친구에게 공유, 대화창에서 표시), 공유한 내용은 모바일QQ에서만 볼 수 있고 PC QQ에서는 보이지 않습니다. 모바일QQ에서 이 대화를 클릭하면 게임을 실행할 수 있습니다.
리턴 값:
     false:모바일QQ 미인증 혹은 잘못된 파라미터
     true:정확한 파라미터
파라미터: 
 - act 필수 파라미터
0：모바일QQ에서 이 공유 메시지를 클릭하면 targetUrl 주소로 이동
1：모바일QQ에서 이 공유 메시지를 클릭하면 게임 실행
 - fopenid 필수 파라미터  친구가 게임에 해당하는 openid, 이 친구에게 공유
 - title필수 파라미터   공유 제목
 - summary 필수 파라미터   개요
 - targetUrl 필수 파라미터 공유url
 - imgUrl 필수 파라미터 
공유 이미지 url(이미지 사이즈는 128*128; 웹주소는 방문할 수 있어야 하며 크기는 2M이하여야 합니다.)
 - previewText비필수
 - 공유한 문자 내용, 빈칸 불가. 예를 들면 “2Day’s Match를 놀고 있어요”, 길이는 45바이트를 초과하지 않습니다.
 - gameTag 비필수
    game_tag	플랫폼이 공유 유형에 대한 통계용, 예하면 하트 보내기 공유, 초월 공유, 이 값은 게임에서 책정하고 동시에 모바일QQ 플랫폼에 전송합니다. 현재 값:
MSG_INVITE                //초대
MSG_FRIEND_EXCEED       //초월 자랑하기
MSG_HEART_SEND          //하트 보내기
  MSG_SHARE_FRIEND_PVP    //PVP 대전
 - extMsdkInfo 공유시 게임이 전송하며 ShareRet.extInfo를 통하여 게임에 콜백합니다. [1.7.0i]
공유가 끝나면 OnShareCallBack(ShareRet ret)를 통하여 게임에 콜백합니다. Ret.flag로 부동한 공유 결과를 표시하며 자세한 내용은 eFlag(부록A) 참조 바랍니다.


 - 호출 코드 예시:
```ruby
unsigned char* openid = (unsigned char*)"86EA9CA0C965B7EE9793E7D0B29161B8";
unsigned char* picUrl = (unsigned char*)"XXXXX";
unsigned char* title = (unsigned char*)" msdk에서 QQ 공유를 테스트합니다.";
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

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같습니다.
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
    //내부 구현 로직은 void MyObserver::OnShareNotify(ShareRet& shareRet)와 일치합니다.
}
```

####주의사항
 - 모바일QQ 버전 4.0 및 이상 필요.
 - 직접 공유는 우선 모바일QQ 인증에 성공하여야 합니다.
 - 모바일QQ 호출 후 Qzone에 공유하는 팝업창은 모바일QQ 4.5 및 이상 버전이여야 합니다.
 - WGSendToQQ 자체정의 필드 투과전송은 모바일QQ 4.6 및 이상 버전이여야 합니다.
##모바일QQ 빅이미지 공유
###개요
WGSendToQQWithPhoto를 호출하면 모바일QQ 호출 후 모바일QQ 내부에서 공유할 친구 혹은 Qzone을 선택하여 빅이미지 공유를 진행합니다. 모바일QQ에서 이 공지 메시지를 클릭하면 전체 화면으로 미리 확인할 수 있습니다.
```ruby
void WGSendToQQWithPhoto(const eQQScene[Int에서 eQQScene 전환]& scene, unsigned char* imgData, const int& imgDataLen)
```
>설명: 메시지를 모바일QQ 대화 혹은 Qzone에 공유
  -  scene 모멘트 혹은 대화에 공유할 지 표시
QQScene_Qzone: 모바일QQ 호출 후 ‘Qzone 공유’ 팝업창을 디폴트로 출력
QQScene_session：모바일QQ 호출 후 Qzone이 없어 친구에게만 공유
  - imgData 이미지 파일 데이터
  - imgDataLen 이미지 파일 데이터 길이

 - 공유 성공과 실패시 OnShareNotify(ShareRet ret)를 통하여 게임에 콜백합니다. ret.flag는 부동한 공유 결과를 표시하며자세한 내용은 eFlag(부록A) 참조 바랍니다.
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
            NSLog(@"네트워크 오류");[코드 축소 통일화]
    }
}
```

- 2.4.0i 및 이후 버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같습니다.
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
    //내부 구현 로직은 void MyObserver::OnShareNotify(ShareRet& shareRet)와 일치합니다.
}
```

###주의사항
 - 모바일QQ 4.2 및 이상 버전이여야 합니다.
 - 모바일QQ를 깨워 Qzone에 공유하는 팝업창은 모바일QQ 4.5 및 이상 버전여야 합니다.
 - web를 통하여 공유 불가능합니다.
 ---
##모바일QQ 연동 주의사항
 - ###모바일QQ 기능과 지원하는 버전
‘WGGetIphoneQQVersion()’ 방법을 통하여 모바일QQ 버전 번호를 획득할 수 있다.
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
    	kQQVersion4_5,      //4.5버전
    	kQQVersion4_6,      //4.6버전
	    } QQVersion;
리턴 값:
   모바일QQ 버전

- 기능 및 해당한 모바일QQ 버전

|기능|	설명|	모바일QQ 지원 버전|
|----|----|----|
|인증|		|4.0 및 이상|
|구조화 공유|	|	4.0 및 이상|
|빅이미지 공유	||	4.0 및 이상|
|QZone 공유 팝업창|	모바일QQ를 호출 후 디폴트로 대화창 팝업|	4.5 및 이상|
|퀵로그인|	모바일QQ가 불러온 게임이 로그인 상태에 있음|4.6 및 이상|
|구조화 메시지 투과전송 필드|	MSDK는 이 필드를 게임에 투과전송합니다.|	|
|Diff계정|	플랫폼이 불러온 게임이 openid를 게임에 전송 여부(Diff계정)|	4.2 및 이상|

##모바일QQ 게임내에서 친구 및 그룹 추가
 - ###개요
다음 인터페이스는 2.0.2i 이후에 제공되며 모바일QQ 5.1 이상 버전여야 합니다.또한 App id는 모바일QQ 백그라운드에서 심사 통과 후 출시되어야 합니다.
WGAddGameFriendToQQ: 게임내에서 다른 유저를 선택하고 이 인터페이스를 호출하여 친구 추가할 수 있습니다.
WGBindQQGroup:길드장은 자신이 만든 그룹을 선택하여 해당 길드의 길드 그룹으로 바인딩할 수 있습니다.
```ruby
void WGAddGameFriendToQQ(
unsigned char* cFopenid, unsigned char* cDesc, unsigned char* cMessage)
```
>설명: 인게임 친구 추가
  - 파라미터:
  - cFopenid  필수 파라미터  친구의 openid를 추가하여야 합니다.
  - cDesc  필수 파라미터  친구의 비고를 추가하여야 합니다.
  - cMessage    친구 추가시 발송한 인증 정보
  추가 성공 혹은 실패는 OnShareNotify(ShareRet ret)를 통하여 게임에 콜백합니다. ret.flag는 부동한 공유 결과를 표시하며 자세한 내용은 eFlag(부록A) 참조 바랍니다.

 ```ruby
void  WGBindQQGroup (unsigned char* cUnionid, unsigned char* cUnion_name,
                       unsigned char* cZoneid, unsigned char* cSignature)
```
>설명: 게임 그룹 바인딩: 게임 길드/연맹 내에서 길드장은 “바인딩” 버튼을 클릭하여 길드장이 만든 그룹을 불러와 해당 길드의 길드 그룹으로 바인딩시킬 수 있습니다.
  - 파라미터:
  - cUnionid 길드ID, opensdk는 숫자만 입력 가능, 문자를 입력하면 바인딩 실패를 초래할 수 있습니다. 하나의 길드는 1개 그룹만 바인딩할 수 있으며 바인딩을 해제하려면 QQ API 문서(다음)를 참조 바랍니다. 문의사항이 있을 경우 운영팀을 통하여 OpenAPIHelper(OpenAPI 기술지원)에 문의 바랍니다. http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup
  - cUnion_name 길드명
  - cZoneid 월드 ID, opensdk는 숫자만 입력 가능, 문자를 입력하면 바인딩 실패를 초래할 수 있습니다.
  - cSignature 게임 맹주 신분 인증 시그네쳐, 생성 알고리즘은 openid_AppID_appkey_길드id_월드id md5 생성
  추가 성공 혹은 실패는 OnShareNotify(ShareRet ret)를 통하여 게임에 콜백합니다. ret.flag는 부동한 공유 결과 표시하며 자세한 내용은 eFlag(부록A) 참조 바랍니다.
  
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

- 2.4.0i 및 이후버전에는 delegate방식을 사용할 수 있으며 코드는 아래와 같습니다.
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
    //내부 구현 로직은 void MyObserver::OnShareNotify(ShareRet& shareRet)와 일치합니다.
}
```

###주의사항
 - 모바일QQ 5.1 및 이상 버전여야 합니다.
 - 하나의 길드는 1개 그룹만 바인딩할 수 있으며 바인딩을 해제하려면 QQ API 문서(다음)를 참조 바랍니다. 문의사항이 있을 경우 운영팀을 통하여 OpenAPIHelper(OpenAPI 기술지원)에 문의 바랍니다.
http://wiki.open.qq.com/wiki/v3/qqgroup/unbind_qqgroup
 - 인게임 친구/그룹 바인딩 인터페이스를 사용하려면 연동한 App id가 모바일QQ 백그라운드에서 심사 통과 후 출시되어야 합니다.
 ---

 ## FAQ
 ###주의 사항
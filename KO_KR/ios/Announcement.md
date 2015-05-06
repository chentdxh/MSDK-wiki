공지
===

##개요
 - 이 기능은 버전 1.6.1 이후부터 제공되며 두가지 형식의 공지 인터페이스를 제공합니다. 1.6.2버전의 공지는 테스트 단계이므로 게임에서 사용하는 것은 권장하지 않으며 게임은 info에서 공지 기능을 off하여야 합니다. 공지 기능을 사용하려면 YES로 설정하면 됩니다.
![Alt text](./Announcement1.png)
 - 2.0.1i 및 이후 버전은 공지 데이터 타이밍 실행 기능을 제공하며 info에서 아래와 같이 설정하여야 합니다.
![Alt text](./Announcement2.png)
---

##MSDK가 제공하는 공지 표시 인터페이스
 - WGShowNotice를 호출하면 MSDK에 설정된 화면을 이용하여 현재 유효한 공지를 표시합니다. WGHideScrollNotice를 호출하면 표시된 롤링 공지를 숨김니다.
```ruby
Void WGShowNotice (eMSG_NOTICETYPE type, unsigned char *scene);
```
>설명: 지정된 scene에서 현재 유효한 공지 표시하며 아래와 같이 파라미터 type를 통하여 어떤 공지를 표시할 지 확정합니다.
```
typedef enum _eMSG_NOTICETYPE
{
	//모든 공지 유형
eMSG_NOTICETYPE_ALL = 0,
//팝업 공지
eMSG_NOTICETYPE_ALERT,
//롤링 공지
    eMSG_NOTICETYPE_SCROLL,
}eMSG_NOTICETYPE;
```
파라미터: 
1. Type 표시할 공지 유형
2. scene 공지 씬ID, 빈칸 불가. 이 파라미터는 공지 관리단의 “공지탭”에 해당되며 공지탭의 유효한 공지만 표시합니다.
 - 
```ruby
void WGHideScrollNotice ();
```
>설명: 표시된 롤링 공지 숨기기
주: 공지 표시 화면은 plist를 통하여 커스터마이징합니다. 현재 팝업 공지는 “흰색 바탕, 푸른색 바탕, 검은색 바탕, 사용자정의” 등 4개 양식이 있습니다. 이런 템플릿 및 해당한 리소스 파일은 WGPlatformResources.bundle/AnnouncementResources의 하위 디렉토리에 위치합니다. 해당 양식 요소와 설명은 부록을 참조 바랍니다.
---

##공지 데이터 리스트 인터페이스
```ruby
std::vector<NoticeInfo> WGGetNoticeData(eMSG_NOTICETYPE type,unsigned char *scene);
```
>설명: 지정된 scene에서 현재 유효한 공지 데이터를 표시하며 아래와 같이 파라미터 type를 통하여 어떤 공지를 표시할 지 확정합니다.
```ruby
typedef enum _eMSG_NOTICETYPE
{
	//모든 공지 유형
eMSG_NOTICETYPE_ALL = 0,
//팝업 공지
eMSG_NOTICETYPE_ALERT,
//롤링 공지
    eMSG_NOTICETYPE_SCROLL,
}eMSG_NOTICETYPE;
```
파라미터:
2. Type 표시할 공지 유형
3. scene 공지 씬ID, 빈칸 불가. 이 파라미터는 공지 관리단의 “공지탭”에 해당되며 공지탭의 유효한 공지만 표시합니다.
리턴:
1. NoticeInfo 배열. NoticeInfo 구조는 아래와 같습니다.
```ruby
typedef struct
{
    std::string msg_id; //공지id
    std::string open_id; //유저open_id
    std::string msg_content; //공지 내용
    std::string msg_title; //공지 제목
  std::string msg_url; //공지 이동 링크
  eMSG_NOTICETYPE msg_type; //공지 유형, eMSG_NOTICETYPE
  std::string msg_scene; //공지 표시 scene, 관리자 백그라운드 설정
  std::string start_time; //공지 유효기간 시작 시간
  std::string end_time; //공지 유효기간 종료 시간
std::string content_url; //웹페이지 공지 url
std::vector<PicInfo> picArray; //이미지 공지 이미지 데이터
}NoticeInfo; 
typedef struct
{
eMSDK_SCREENDIR screenDir;      //가로세로 화면   1: 가로 2: 세로
    std::string picPath;    //이미지 로컬 경로
    std::string hashValue;  //이미지 hash 값
}PicInfo; 
```


---

## 샘플 코드
 - 공지 데이터 리스트 획득 인터페이스 호출 코드 예시:
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
std::vector<NoticeInfo> vec = plat->WGGetNoticeData(eMSG_NOTICETYPE_ALERT, (unsigned char *)[scene UTF8String]);
            for (int i = 0; i < vec.size(); i++) {
                NoticeInfo info = vec[i];
                NSLog(@"NoticeInfo msgID: %@\nNoticeInfo msgTitle:%@\nNoticeInfo msgContent:%@",
                [NSString stringWithUTF8String: info.msg_id.c_str()],
                [NSString stringWithUTF8String: info.msg_title.c_str()],
                [NSString stringWithUTF8String: info.msg_content.c_str()]);
            }
```
## FAQ
 - 리소스 파일 도입 이슈로 인하여 Crash 초래：
	MsdkReources.bundle를 프로젝트의 ”Copy Bundle Resources“로 정확히 도입하지 못할 경우 공지 표시할 시 crash가 발생할 가능성이 있습니다.
![linkBundle](./Crash_Annoucement.PNG)
 - AppDelegate(AppController)에서 window 속성을 구현하지 않으면 공지 호출할 시 crash가 발생할 가능성이 있습니다.	
	[AppController window]: unrecognized selector sent to instance 0x17fa7130
	해결 방법：AppDelegate(AppController)에서 한 window의 property를 추가하여 생성한 keywindow를 지향합니다.
## 부록
  - 공지plist설정 설명
    공지 표시 화면은 plist를 통하여 커스터마이징합니다. 현재 팝업 공지는 “흰색 바탕,파란 바탕, 검은 바탕,자체정의 바탕 ”4가지 양식이 있습니다다. 해당 양식에 해당된 리소스 파일은 framework/Resources/AnnouncementResources의 하위 디렉터리에 있습니다. 양식의 요소와 설명은 아래와 같습니다.
    ![Alt text](./Announcement_config.png)
    그 중에 AlertView 노드는 팝업 공지 화면을 구축하며 BannerView노드는 롤링 공지 화면을 구축합니다.
    팝업 공지와 AlertView노드의 대응 관계는 아래와 같습니다. 현재는 한가지 block만 설정하므로 “종료”버튼만 있습니다.
    ![Alt text](./Announcement_config2.png)
    롤링 공지와 BannerView노드의 대응 관계는 아래와 같습니다.Icon는 선택할 수 있습니다.
    ![Alt text](./Announcement_config3.png)
    각 노드는 Font,view,icon 요소로 구성되었으며 해당 설명은 아래와 같습니다.
Font노드 커스터마이징 투시도 텍스트의 속성:

| 항목	| 타입	| 설명	| 예시| 
| ------------- |:-------------:|:----:|
| font	| Number	| Font 크기	| 20| 
| fontColor	| string	| Font 색깔	| #ffffff| 
| fontShadow	| number	| Font 그림자	| 0| 
| fontShadowColor	| string	| 그림자 색깔	| #ffffff| 
| labelWidth	| Number	| 텍스트 너비	| 280| 
| labelLeft	| Number	| 텍스트의 X좌표	| 10| 
| labelTop	| Number	| 텍스트의 y좌표	| 10| 
| labelHeight	| Number	| 텍스트 높이	| 30| 
| textAlign	Number	| 텍스트 정열방식	| 0-왼쪽으로 정열 1-가운데로 정열 2-오른쪽으로 정열| |

View 노드 커스터마이징 투시도 배경 등의 속성:

| 항목	| 타입	| 설명	| 예시| 
| ------------- |:-------------:|:----:|
| backgroudColor	| string	| 배경 색상	| #ffffff| 
| backgroudColorAlpha	| number	| 배경색 투명도	| 0.5(0.0-1.0)| 
| backgroundLeftImage	| string	| 배경도 좌측	| 비워둘 수 있음| 
| backgroundMidImage	| string	| 배경도 스트레칭 파트 | 파일은 plist와 같은 디렉터리에서 저장| 
| backgroundRightImage	| string	| 배경도 우측	| 비워둘 수 있음| 
| viewHeight	| number	| 투시도 높이	| 40| 
| viewWidth	| number	| 투시도 너비	| 200| 
| viewTop	| number	| 투시도의 y좌표（bottom투시도에서 설정하지 않으면 content투시도로 적용）	| 10| 
| viewLeft	| number	| 투시도의 x좌표	| 10| 



Icon노드 커스터마이징 투시도 icon의 속성：
	
| 항목	| 타입	| 설명	| 예시| 
| ------------- |:-------------:|:----:|
| iconPath	| string	| 이미지 파일명，plist와 같은 디렉터리	| icon.png| 
| backgroudColor	| string	| 배경 색상	| #ffffff
| backgroudColorAlpha	| number	| 배경색 투명도	| 0.5(0.0-1.0)| 
| viewHeight	| number	| 투시도 높이	| 30| 
| viewWidth	| number	| 투시도 너비	| 30| 
| viewTop	| number	| 투시도의 y좌표	| 10| 
| viewLeft	| number	| 투시도의 x좌표 | 10| 


cancelButton노드 커스터마이징 투시도에 버튼의 속성：
	
| 항목	| 타입	| 설명	| 예시| 
| ------------- |:-------------:|:----:|
| titleColor	| string	| 버튼 타이틀 색상	| #ffffff| 
| backgroudColor	| string	| 버튼 배경 색상	| #ffffff| 
| backgroudColorAlpha	| number	| 버튼 배경 색상 투명도	| 1| 
| btnImage	| string	| 버튼 배경도	| icon.png| 
| selectedBtnImage	| string	| 버튼 선정 이미지	| selIcon.png| 
| buttonLeft	| number	| 버튼의 x좌표	| 10| 
| buttonWidth	| number	| 버튼 투시도 높이	| 80| 
| buttonHeight	| number	| 버튼 투시도 너비	| 30| 
| buttonTop	| number	| 버튼의 y좌표（설정하지 않거나 0일 경우, 바탕으로 적용）	| 10| 
| buttonTitle	| string	| 버튼 타이틀 색상	| #ffffff| 
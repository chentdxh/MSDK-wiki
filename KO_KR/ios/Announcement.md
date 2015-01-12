공지
===

##개요
 - 이 기능은 버전 1.6.1 이후부터 제공되며 두가지 형식의 공지 인터페이스를 제공한다. 버전 1.6.2 공지는 테스트 단계이기에 게임에 사용하지 않는 게 좋으며 게임은 info에서 공지 기능을 닫아야 한다. 공지 기능을 사용하려면 YES로 설정하면 된다.
![Alt text](./Announcement1.png)
 - 2.0.1i 및 이후 버전은 공지 데이터 타이밍 실행 기능을 제공하며 info에서 아래와 같이 설정해야 한다
![Alt text](./Announcement2.png)
---

##MSDK가 제공하는 공지 표시 인터페이스
 - WGShowNotice를 호출하면 MSDK에 설정된 화면을 이용하여 현재 유효한 공지를 표시한다. WGHideScrollNotice를 호출하면 표시된 롤링 공지를 숨긴다.
```ruby
Void WGShowNotice (eMSG_NOTICETYPE type, unsigned char *scene);
```
>설명: 지정된 scene에서 현재 유효한 공지 표시. 다음과 같이 파라미터 type를 통해 어떤 공지를 표시할 지 확정한다
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
2. scene 공지 씬ID, 비워둘 수 없다. 이 파라미터는 공지 관리자의 “공지 표시줄”과 대응하며 공지 표시줄의 유효한 공지만 표시한다.
 - 
```ruby
void WGHideScrollNotice ();
```
>설명: 표시된 롤링 공지 숨기기
주: 공지 표시 화면은 plist를 통해 맞춤 제작된다. 현재 팝업 공지는 “흰색 바탕, 푸른색 바탕, 검은색 바탕, 사용자정의” 등 4개 템플릿이 있다. 이런 템플릿 및 상응한 리소스 파일은WGPlatformResources.bundle/AnnouncementResources 상응한 하위 디렉토리에 위치한다. 템플릿 요소와 정의는 부록 F 참조..
---

##공지 데이터 리스트 인터페이스
```ruby
std::vector<NoticeInfo> WGGetNoticeData(eMSG_NOTICETYPE type,unsigned char *scene);
```
>설명: 지정된 scene에서 현재 유효한 공지 데이터를 표시한다. 다음과 같이 파라미터 type를 통해 어떤 공지를 표시할 지 확정한다.
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
3. scene 공지 씬ID, 비워둘 수 없다. 이 파라미터는 공지 관리자의 “공지 표시줄”과 대응하며 공지 표시줄의 유효한 공지만 표시한다.
리턴:
1. NoticeInfo 배열. NoticeInfo 구조는 다음과 같다
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

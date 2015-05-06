MSDK 광고 관련 모듈
===
1. 개요
---
게임설정내에 정지 버튼이 있으며 해당 버튼을 누르면 정지 대화창이 팝업되고 돌아가기 버튼을 누르면 종료 대화창이 팝업됩니다. MSDK2.1부터 MSDK에 정지와 종료를 표시하는 사용자정의 대화창이 추가되었습니다. 아래 이미지 참조 바랍니다.

![msdkad](./ad_res/ad_1.png) ![msdkad](./ad_res/ad_2.png)

게임에 광고가 투입될 경우 아래와 같은 화면이 표시됩니다. 여러 광고가 있을 경우 일정한 시간 간격으로 다음 광고를 자동으로 출력하며 터치하여도 다음 광고를 출력할 수 있습니다.

![msdkad](./ad_res/ad_3.png) ![msdkad](./ad_res/ad_4.png)

버튼 수량은 __adconfig.ini__에서 설정할 수 있으며 __2__ 혹은 __3__개만 설정 가능합니다. 이미지3의 정지 대화창에는 "계속 플레이","다시 시작","도전 종료" 3개 버튼이 있습니다. 버튼 문자는 변경할 수 있으며 버튼을 클릭할 경우 대화창이 사라집니다. MSDK 콜백 인터페이스 OnADNotify는 게임에 통보하며 게임에서 이 함수의 구체적인 로직을 구현합니다. 모든 View에는 __android:tag__ 속성이 있습니다. 게임은 부동한 tag명을 통하여 어느 버튼에 응답할 것인지 구분합니다. 기본 레이아웃을 사용할 경우, 이미지3과 같이 “계속 플레이”의 viewTag는 `FIRST_BTN_POSITION`,“다시 시작”의 viewTag는 `SECOND_BTN_POSITION`, “도전 종료”의 viewTag는 `THIRD_BTN_POSITION`입니다. 게임에서 돌아가기 버튼을 누를 경우 MSDK 콜백 인터페이스 `OnADBackPressedNotify`는 게임에 통보합니다.

더불어 내장 브라우저를 사용하여 네비게이션바 광고를 표시하며 네비게이션바 광고가 있을 경우 내장 브라우저 하단의 네비게이션바에 이미지5와 같은 추천 버튼이 표시됩니다. 클릭할 경우 네비게이션바 광고 페이지가 출력됩니다.
![msdkad](./ad_res/ad_5.png) 


2. 게임 연동
---
###Step 1: 연동 설정
__MSDKSample/assets/adconfig.ini를 게임에 해당하는 프로젝트 assets 디렉토리에 복사 후 설정합니다.__

assets/adconfig.ini에서 광고 실행 스위치 설정: 

    MSDK_AD=true //일 경우 광고 실행

assets/adconfig.ini에서 광고 버튼 수량 설정:

    ;MSDK 정지 위치 광고 버튼 수량은 2, 3만 입력 가능하며 기본값은 2.
    ;AD_PAUSE=2
    AD_PAUSE=3
    
    ;MSDK 종료위치 광고 버튼 수량은 2, 3만 입력 가능하며 기본값은 2.
    ;AD_STOP=3
    AD_STOP=2

###Step 2: 게임 Activity 라이프사이클 데이터 모니터링
게임 메인 Acitivity의 onResume과 onPause에서 각각 MSDK 대응 방법을 호출합니다.(필수 호출)

    @Override
    protected void onResume() {
        super.onResume();
        WGPlatform.onResume();
    }
    @Override
    protected void onPause() {
        super.onPause();
        WGPlatform.onPause();
    }
    @Override
    protected void onDestroy() {
        super.onDestroy();
        WGPlatform.onDestory(this);
    }

###Step 3: 콜백 함수 설정

3.1 버튼을 클릭하거나 돌아가기 버튼을 누른 후 MSDK는 게임으로 콜백하여 게임에서 처리 로직을 추가합니다. Java 호출 방법은 다음 방식으로 처리하며 onCreate에서 호출 로직을 추가합니다. 예를 들면 MSDKSample에서의 com.example.wegame.MainActivity.

    public class ADRet {
        // 기본 레이아웃의 viewTag
        // FIRST_BTN_POSITION 
        // SECOND_BTN_POSITION 
        // THIRD_BTN_POSITION 
        // 게임이 버튼 View의 android:tag를 변경하면 viewTag는 해당하는 값
        public String viewTag = "";
        public eADType scene;
    }

    // 광고 버튼 클릭시 콜백
    class MsdkADCallback implements WGADObserver {

        @Override
        public void OnADNotify(ADRet ret) {
            Logger.d("Java MsdkADCallback OnADNotify:" + ret.toString());
            // TODO: GAME 여기에 광고 콜백에 대한 처리 추가
        }

        @Override
        public void OnADBackPressedNotify(ADRet ret) {
            Logger.d("Java MsdkADCallback OnADBackPressedNotify:" + ret.toString());
            // TODO GAME 돌아가기 버튼을 눌러 광고를 종료할 경우 close 방법을 호출
            WGPlatform.WGCloseAD(ret.scene);
        }
    }

    if (LANG.equals("java")) {
        WGPlatform.WGSetObserver(new MsdkCallback());
        // 광고의 콜백 설정
        WGPlatform.WGSetADObserver(new MsdkADCallback());
    }

3.2 CPP 방식 콜백 설정

MSDKSample의 com_example_wegame_PlatformTest.cpp에서 제시한 바와 같이 전역 콜백 객체를 추가합니다.

    // 광고 콜백
    class ADCAllback: public WGADObserver {

        virtual void OnADNotify(ADRet& adRet) {
            // 게임은 여기에 광고를 표시하고 버튼을 클릭하는 처리 로직 추가
            LOGD("ADCAllback OnADNotify Tag:%s ", adRet.viewTag.c_str());
            if(adRet.scene == Type_Pause) {
                LOGD("ADCAllback OnADNotify scene:Type_Pause%s", "");
            } else if(adRet.scene == Type_Stop) {
                LOGD("ADCAllback OnADNotify scene:Type_Stop%s", "");
            }
        }

        virtual void OnADBackPressedNotify(ADRet& adRet) {
             // 게임은 여기에 광고 표시 후 돌아가기 버튼을 누르는 처리 로직 추가
            LOGD("ADCAllback OnADBackPressedNotify Tag:%s ", adRet.viewTag.c_str());
            if(adRet.scene == Type_Pause) {
                LOGD("ADCAllback OnADBackPressedNotify scene:Type_Pause%s", "");
                // 광고 대화창 종료에 주의
                WGPlatform::GetInstance()->WGCloseAD(adRet.scene);
            } else if(adRet.scene == Type_Stop) {
                LOGD("ADCAllback OnADBackPressedNotify scene:Type_Stop%s", "");
                // 광고 대화창 종료에 주의
                WGPlatform::GetInstance()->WGCloseAD(adRet.scene);
            }
        }
    };

    // 광고 전역 콜백 객체
    ADCAllback ad_callback;

    // 초기화
    JNIEXPORT jint JNICALL JNI_OnLoad(JavaVM* vm, void* reserved) {
        //TODO GAME C++ 층 초기화,게임 메인 Activity의 onCreate전에 호출
        WGPlatform::GetInstance()->init(vm);
        WGPlatform::GetInstance()->WGSetObserver(&g_Test);
        // 광고 콜백 설정
    WGPlatform::GetInstance()->WGSetADObserver(&ad_callback);
        
        WGPlatform::GetInstance()->WGSetSaveUpdateObserver(&callback);
        return JNI_VERSION_1_4;
    }

###Step 4: 호출 방법 설명
JAVA에서 정지와 종료 위치 광고 대화창을 ON하거나 OFF하는 데 사용하는 함수를 호출합니다.

    /**
     * @param scene 광고 씬 ID, 공백 불가
     * Type_Pause(1) 정지 위치 광고 표시
     * Type_Stop(2) 종료 위치 광고 표시
    */
    WGPlatform.WGShowAD(eADType scene); 
    WGPlatform.WGCloseAD (eADType scene);

CPP에서 정지 위치와 종료 위치 광고 대화창을 ON하거나 OFF하는데 사용하는 함수를 호출합니다.
전역 열거형 정의는 WGPublicDefine.h에서 확인

    typedef enum _eADType
    {
        Type_Pause  = 1, // 정지 위치 광고
        Type_Stop = 2, // 종료 위치 광고
    }eADType;

정지 위치와 종료 위치 광고를 표시하거나 종료하는 방법

    WGPlatform::GetInstance()->WGCloseAD(Type_Pause);
    WGPlatform::GetInstance()->WGCloseAD(Type_Stop);

###Step 5: 리소스 파일 설명

5.1 파일 경로:

【1】MSDKLibrary\res\layout\msdk_ad_pause_three_default.xml

【2】MSDKLibrary\res\layout\msdk_ad_pause_three_show.xml

【3】MSDKLibrary\res\layout\msdk_ad_pause_two_default.xml

【4】MSDKLibrary\res\layout\msdk_ad_pause_two_show.xml

【5】MSDKLibrary\res\layout\msdk_ad_stop_three_default.xml

【6】MSDKLibrary\res\layout\msdk_ad_stop_three_show.xml

【7】MSDKLibrary\res\layout\msdk_ad_stop_two_default.xml

【8】MSDKLibrary\res\layout\msdk_ad_stop_two_show.xml

그중:

【1】msdk_ad_pause_three_default.xml 이미지1 효과에 해당

【2】msdk_ad_stop_three_default.xml효과는 같지만 문자가 다르며 문자는 MSDKLibrary\res\values\msdk_ad_strings.xml에서 변경할 수 있습니다.

![msdkad](./ad_res/ad_6.png) 

【3】msdk_ad_stop_two_default.xml和msdk_ad_pause_two_default.xml 이미지2 해당

【4】msdk_ad_pause_three_show.xml和msdk_ad_stop_three_show.xml 이미지3 해당

【5】msdk_ad_stop_two_show.xml和msdk_ad_pause_two_show.xml 이미지4 해당

**설명: 게임은 MSDKLibrary\res에서 직접 변경할 수 있으며 광고 관련 리소스는 모두 msdk_ad로 시작됩니다. 대화창의 버튼 숫자가 확정되어 있으므로 실제로 모든 게임은 레이아웃 파일 4개만 필요하며 다른 내용은 Step 7을 참조 바랍니다. **

###Step 6: 게임의 레이아웃 파일 설정 설명

6.1 MSDKLibrary는 변경될 수 있고 향후 업데이트는 대조 및 복사하는데 불편함이 있으므로 MSDK는 일부 설정항목을 처리하였습니다. 게임은 자신의 프로젝트 디렉토리에서 레이아웃 파일을 정의한 후 XML파일명을 assets/adconfig.ini에 기입하면 됩니다. 물론 레이아웃 파일에 대해 일정한 제한조건이 있습니다.

6.2 설정 절차

우선, 레이아웃을 설정할 수 있는 스위치 실행

    ;MSDK 광고 레이아웃 파일 설정 스위치, 기본값은 false
    AD_NEED_CONFIG_LAYOUT=false

그 후, 프로젝트에서 대화창 레이아웃 파일 정의

마지막으로, 구성 파일에서 설정 진행

    ;MSDK정지 위치 광고 대화창은 게임 자체  설정,AD_NEED_CONFIG_LAYOUT=true여야만 유효
    ;레이아웃 파일의 버튼 수량은 AD_PAUSE와 일치
    ;광고가 없을 경우 대화창의 레이아웃 파일
    AD_LAYOUT_PAUSE_DEFAULT=myad_pause_default
    ;광고가 있을 경우 대화창의 레이아웃 파일
    AD_LAYOUT_PAUSE_SHOW=myad_pause_show

    ;MSDK종료 위치 광고 대화창은 게임 자체 설정
    ;레이아웃 파일의 버튼 수량은 AD_STOP과 일치
    ; 광고가 없을 경우 대화창의 레이아웃 파일
    AD_LAYOUT_STOP_DEFAULT=myad_stop_default
    ; 광고가 있을 경우 대화창의 레이아웃 파일
    AD_LAYOUT_STOP_SHOW=myad_stop_show

예를 들면 MSDKSample/res/layout에서 4개 레이아웃 파일을 설정.

![msdkad](./ad_res/ad_7.png) 

###Step 7: 리소스와 레이아웃 파일 수정 주의사항

**1.버튼 ID는 msdk_ad_btn_1, msdk_ad_btn_2, msdk_ad_btn_3으로 해야 하며 아닐 경우 대화창 호출시 버튼 ID는 조회할 수 없습니다.**

**2.광고가 있을 경우 이미지 롤링 효과의 레이아웃을 유지 바랍니다. 즉 아래 붉은선으로 표시된 부분의 ID명 ad_view_pager은 변경하지 않으며 사이즈는 300dp*200dp로 설정합니다.**

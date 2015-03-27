MSDK LBS 관련 모듈
=======
현재 MSDK의 LBS 기능은 프런트 엔드에서 위치를 추적하고 백그라운드에서 인근 유저를 요청하는 기능을 구현하였다. 유저가 해당 기능을 원하지 않는 경우에 대비하여 SDK는 유저 지리적 위치를 삭제하는 인터페이스도 제공한다. 관련 인터페이스 설명은 아래와 같다:

인근 유저 획득
---
#### 인터페이스 선언:

    /**
    *  인근 유저 정보 획득
    *  @return OnLocationNotify에 콜백
    *  @return void
    *   게임에서 설정한 전역 콜백 OnLocationNofity(RelationRet& rr) 방법을 통해 데이터를 게임에 반환
    *     rr.platform 현재 인증 플랫폼 표시. 값 유형은 ePlatform, 가능한 값은 ePlatform_QQ, ePlatform_Weixin
    *     rr.flag 값은 반환 상태 표시. 가능한 값(eFlag열거)은 다음과 같다:
    * 			eFlag_LbsNeedOpenLocationService: 유저가 위치 추적 서비스를 실행하도록 안내해야 한다
    *  		eFlag_LbsLocateFail: 위치 추적 실패, 재시도 가능
    *  		eFlag_Succ: 인근 유저 획득 성공
    *  		eFlag_Error:  위치 추적에 성공했지만 인근 유저 요청에 실패한 경우. 재시도 가능
    *     rr.persons는 하나의 Vector로, 인근 유저 정보가 저장된다
    */*/
    void WGGetNearbyPersonInfo ();
   
#### 샘플 코드 호출:

	WGPlatform::GetInstance()->WGGetNearbyPersonInfo();

#### 콜백 구현(Demo)코드:

    void OnLocationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // relationRet.persons.at(0) 에 저장된 것은 첫번째 인근 유저의 정보이다
		std::string gender = relationRet.persons.at(0).gender;
		std::string nickName = relationRet.persons.at(0).nickName;
		std::string openId = relationRet.persons.at(0).openId;
		std::string pictureLarge = relationRet.persons.at(0).pictureLarge;
		std::string pictureMiddle = relationRet.persons.at(0).pictureMiddle;
		std::string pictureSmall = relationRet.persons.at(0).pictureSmall;
        break;
    default:
        break;
    	}
	
	
위치 정보 삭제
---

#### 인터페이스 선언:

       /**
     *  개인 위치 정보 삭제
     *  @return OnLocationNotify에 콜백
     *  @return void
     *   게임에서 설정한 전역 콜백 OnLocationNofity(RelationRet& rr) 방법을 통해 데이터를 게임에 반환
     *     rr.platform 현재 인증 플랫폼 표시. 값 유형은 ePlatform, 가능한 값은 ePlatform_QQ, ePlatform_Weixin
     *     rr.flag 값은 반환 상태 표시. 가능한 값은 (eFlag열거)다음과 같다:

     * 			eFlag_LbsNeedOpenLocationService: 유저가 위치 추적 서비스를 실행하도록 안내해야 한다
     *  		eFlag_LbsLocateFail: 위치 추적 실패, 재시도 가능
     *  		eFlag_Succ: 삭제 성공
     *  		eFlag_Error:  삭제 실패, 재시도 가능
     */*/
     bool WGCleanLocation ();
     
#### 샘플 코드 호출:

	WGPlatform::GetInstance()->WGCleanLocation();
	
	
유저 위치 정보 획득
---

#### 인터페이스 선언:

    /**
     *  유저의 현재 위치 정보를 획득하여 게임에 반환하는 동시에 MSDK 백그라운드에 전송
     *  @return OnLocationGotNotify에 콜백
     *  @return boolean, true는 클라이언트에 오류가 없음을 표시, false는 클라이언트에 오류가 발생했음을 표시
	 *   게임에서 설정한 전역 콜백 OnLocationGotNotify(LocationRet& rr) 방법을 통해 데이터를 게임에 반환
	 *     rr.platform 현재 인증 플랫폼 표시. 값 유형은 ePlatform, 가능한 값은 ePlatform_QQ, ePlatform_Weixin
	 *     rr.flag값은 반환 상태 표시. 가능한 값은 (eFlag열거) 다음과 같다:
	 *  		eFlag_Succ: 획득 성공
	 *  		eFlag_Error: 획득 실패
	 *     rr.longitude 유저 위치 경도, double 유형
	 *     rr.latitude 유저 위치 위도, double 유형
	 *     /
	 *     
     bool WGGetLocationInfo ();
     
#### 샘플 코드 호출:

	WGPlatform::GetInstance()->WGGetLocationInfo();

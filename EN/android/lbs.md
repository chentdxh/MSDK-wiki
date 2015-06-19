MSDK LBS-related Module
=======
Currently, MSDK LBS has realized the function of locating in the frontend and acquiring nearby friends’ location info in the backend. Meanwhile, if the user is not willing to use the function, SDK also provides an interface to clear the user’s location info. Related interfaces are described as follows:

Acquire nearby persons’ location info
---
#### Interface declaration:

    /**
    *  Acquire nearby persons’ location info
    *  @return  callback via OnLocationNotify
    *  @return void
    *   Return data to the game through the global callback, OnLocationNofity (RelationRet &rr) method, configured by the game
    *     rr.platform represents the current authorization platform, the value type is ePlatform, and possible values are ePlatform_QQ, ePlatform_Weixin
    *     rr.flag value indicates the return status, possible values (eFlag enumeration) are listed as follows:
    * 			eFlag_LbsNeedOpenLocationService: need to guide the user to open LBS
    *  		eFlag_LbsLocateFail: locating fails, and retry again
    *  		eFlag_Succ: get nearby people’s location info successfully
    *  		eFlag_Error: locating is successful, but it fails to get nearby people’s location info; retry
    *     rr.persons is a Vector, which stores the information about the nearby players
    */*/
    void WGGetNearbyPersonInfo ();
   
#### Call code example:

	WGPlatform::GetInstance()->WGGetNearbyPersonInfo();

#### The callback code is as follows:

    void OnLocationNotify(RelationRet& relationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // What stored in relationRet.persons.at(0) is the first nearby player’s information
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
	
	
Clear location information
---

#### Interface declaration:

       /**
     *  Clear location information
     *  @return callback via OnLocationNotify
     *  @return void
     *  Return data to the game via OnLocationNotify(LocationRet &rr) method, a global callback configured by the game
     *     rr.platform represents the current authorization platform, the value type is ePlatform, and possible values are ePlatform_QQ, ePlatform_Weixin
     *     rr.flag indicates the return status, possible values (eFlag enumeration) are listed as follows:
     * 			eFlag_LbsNeedOpenLocationService: need to guide the user to open LBS
     *  		eFlag_LbsLocateFail: locating fails, and retry again
     *  		eFlag_Succ: clear location info successfully
     *  		eFlag_Error: fail to clear location info, and retry
     */*/
     bool WGCleanLocation ();
     
#### Call code example:

	WGPlatform::GetInstance()->WGCleanLocation();
	
	
Get the player’s location information
---

#### Interface declaration:

    /**
     *  Get the current player’s location information; return the data to the game and also report them to the MSDK backend at the same time.
     *  @return allback via OnLocationGotNotify
     *  @return Boolean, true indicates that the client side has no errors, false indicates that the client side has errors
	 *   Return data to the game via OnLocationNotify(LocationRet &rr) method, a global callback configured by the game
	 *     rr.platform represents the current authorization platform, the value type is ePlatform, and possible values are ePlatform_QQ, ePlatform_Weixin
	 *     rr.flag indicates the return status, possible values (eFlag enumeration) are listed as follows:
	 *  		eFlag_Succ: Get the player’s location information successfully
	 *  		eFlag_Error: Fail to get the player’s location information
	 *     rr.longitude: the player’s location longitude, double type
	 *     rr.latitude: the player’s location latitude, double type
	 *     /
	 *     
     bool WGGetLocationInfo ();
     
#### Call code example:

	WGPlatform::GetInstance()->WGGetLocationInfo();
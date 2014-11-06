MSDK LBS 相关模块
=======
目前MSDK的LBS功能已经实现了前端定位并到后台请求附近好友的功能, 同时如果用户不愿意使用此功能, SDK也提供了清除用户地理位置的接口. 相关接口描述如下:

获取附近的人
---
#### 接口声明：

    /**
    *  获取附近人的信息
    *  @return 回调到OnLocationNotify
    *  @return void
    *   通过游戏设置的全局回调的OnLocationNofity(RelationRet& rr)方法返回数据给游戏
    *     rr.platform表示当前的授权平台, 值类型为ePlatform, 可能值为ePlatform_QQ, ePlatform_Weixin
    *     rr.flag值表示返回状态, 可能值(eFlag枚举)如下：
    * 			eFlag_LbsNeedOpenLocationService: 需要引导用户开启定位服务
    *  		eFlag_LbsLocateFail: 定位失败, 可以重试
    *  		eFlag_Succ: 获取附近的人成功
    *  		eFlag_Error:  定位成功, 但是请求附近的人失败, 可重试
    *     rr.persons是一个Vector, 其中保存了附近玩家的信息
    */*/
    void WGGetNearbyPersonInfo ();
   
#### 调用示例代码：

	WGPlatform::GetInstance()->WGGetNearbyPersonInfo();

#### 回调实现(Demo)代码如下:

    void OnRelationNotify(RelationRet& relationRet) {lationRet) {
    switch (relationRet.flag) {
    case eFlag_Succ:
        // relationRet.persons.at(0) 中保存的即是第一个附近玩家的信息
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
	
	
清空位置信息
---

#### 接口声明：

       /**
     *  清除个人位置信息
     *  @return 回调到OnLocationNotify
     *  @return void
     *   通过游戏设置的全局回调的OnLocationNofity(RelationRet& rr)方法返回数据给游戏
     *     rr.platform表示当前的授权平台, 值类型为ePlatform, 可能值为ePlatform_QQ, ePlatform_Weixin
     *     rr.flag值表示返回状态, 可能值(eFlag枚举)如下：
     * 			eFlag_LbsNeedOpenLocationService: 需要引导用户开启定位服务
     *  		eFlag_LbsLocateFail: 定位失败, 可以重试
     *  		eFlag_Succ: 清除成功
     *  		eFlag_Error:  清除失败, 可重试
     */*/
     bool WGCleanLocation ();
     
#### 调用示例代码：

	WGPlatform::GetInstance()->WGCleanLocation();
	
	
获取玩家位置信息
---

#### 接口声明：

    /**
     *  获取当前玩家位置信息,返回给游戏的同时上报到MSDK后台。
     *  @return 回调到OnLocationGotNotify
     *  @return boolean，true则说明客户端侧未发生错误，false则说明客户端侧发生错误
	 *   通过游戏设置的全局回调的OnLocationGotNotify(LocationRet& rr)方法返回数据给游戏
	 *     rr.platform表示当前的授权平台, 值类型为ePlatform, 可能值为ePlatform_QQ, ePlatform_Weixin
	 *     rr.flag值表示返回状态, 可能值(eFlag枚举)如下：
	 *  		eFlag_Succ: 获取成功
	 *  		eFlag_Error: 获取失败
	 *     rr.longitude 玩家位置经度，double类型
	 *     rr.latitude 玩家位置纬度，double类型
	 *     /
	 *     
     bool WGGetLocation ();
     
#### 调用示例代码：

	WGPlatform::GetInstance()->WGGetLocation();
# FAQ #


1. When you print the results, the screen prompts "Request too frequently" or "too many times", which indicate the excessive number of requests; the back-end server stipulates that the number of requests can not be more than once per second.

2. An exception is thrown, such as "Connection to msdk.qq.com failed (0)" or " Connection to msdktest.qq.com failed (0)", which indicates that the server can not parse domain names like msdk.qq.com or msdktest.qq.com. Please contact the operation & maintenance personnel to handle the exception.

3. ret = -309 or ret = -308 or ret = -306, or ret = -101 is an exception caused by the return timeout or unlink of WeChat platform. For the exception, the back-end server of MSDK makes statistics on it every day and makes follow-up handling of it.

4. "-73, internal error" indicates an exception caused by the token failure due to the move that the user changes the password.<br>

		Scenes:
		a. The user modifies the password and then re-authorizes to get a new token.
		b. Then use the old token to verify. In this case, this error occurs
5. "-1, system error" is an error caused by WeChat platform’s data processing exceptions. We will monitor this type of errors and make follow-up handling of them. If such errors appear or occur frequently, please contact us.

6. "-69, internal error" indicates the application is not within the permissions system. Feed it back to us.

7. "100015, access token is revoked" indicates that the token has been discarded by the user.

8. Common errors of /share/qq:
	
	A. {"msg": "100030, is_friend is 0", "ret": -10000} indicates an error to push the heart-sending message to non-friend users. <br>
		　　
    B. {"msg":"30,null ServiceError: :workid=yaaf_mpqq_msgsendsvr cmdid=1 com.tencent.jungle.api.APIException: 	30,response errorCode error 30","ret":-10000}<br> indicates that the same game of each user’s public account can not receive more than 30 pieces of shared messages a day. <br>
		
	C. {"msg": "103, directed share (mobile terminal) friends ServiceError:: workid = qconnshare cmdid = 11 com.tencent.jungle.api.APIException: 103, response errorCode error 103", "ret": -10000 } indicates that the parameter is too long; title can not exceed 45 bytes <br>
		
	D. {"msg": "32, null ServiceError:: workid = yaaf_mpqq_msgsendsvr cmdid = 1 com.tencent.jungle.api.APIException: 32, response errorCode error 32", "ret": -10000} indicates that the Share Public Account is cancelled



9. When "100030, this api without user authorization" occurs, this means no authorization, as shown in the following picture <br>
     ! [Shared picture] (./ faq1.jpg)

10. That /auth/check_token WeChat token verification interface appears "40001, invalid credential" is a normal phenomenon, because the token expires after two hours; If you call this interface after the token expires, the error code will appear

11. Why does the message shared by /share/wx to WeChat interface not display?

	　　In the same appid, every user can receive at most 5 requests a day. If the user receives more than 5 requests a day, the user can not guarantee to receive the additional ones successfully.

12. Why do the images uploaded by /share/upload_wx interface look blurred?


	　　urlencode can turn "space" into a "+" sign. This problem can be solved with rawurlencode.

13. How long can I draw the just added friends in the game after I add friends in WeChat and mobile QQ?

	About an hour in WeChat, and immediately in mobile QQ


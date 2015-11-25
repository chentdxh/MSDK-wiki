<?php
$endTime = 1441814400;
$noticeType = 1;
$data= Array();
$data["cookie"]="msdkkey";

if($noticeType == 1){
	$data["title"]="<span class='f_red f_bold'>关于msdkkey相关问题的公告</span>";
	$data["desc"]=
		"<dd class='f_16' >近期联调过程中收到了比较多关于<span class='f_red'> msdkkey </span>相关的咨询，MSDK团队特意整理答疑。</dd>".
		"<dd class='f_16 f_red f_bold' >名词解释：</dd>".
		"<dd class='f_14' >msdkkey是MSDK前后台交互的凭证，该key从MSDK 2.8.1版本开始使用。<a href='http://wiki.dev.4g.qq.com/v2/ZH_CN/android/index.html#!version.md#Android_2.8.1变更内容' target='_blank'>点击查看</a></dd>".
		"<dd class='f_16 f_red f_bold' >如何获取：</dd>".
		"<dd class='f_14' >游戏开发可以联系运营同学在游戏注册平台查看手Q、微信APPID的地方找到游戏对应的msdkkey。<span class='f_red'>切记游戏不要直接将微信AppKey赋值给msdkkey</span></dd>".
		"<dd class='f_16 f_red f_bold' >如何配置：</dd>".
		"<dd class='f_14' >对于<span class='f_red'>游戏后台</span>：无需关注，继续使用原有调用MSDK后台接口方式调用即可。</dd>".
		"<dd class='f_14' >对于<span class='f_red'>游戏客户端</span>：在初始化MSDK或者配置MSDK相关参数时，将游戏的msdkkey的值加入对应配置即可，其余无需关注。该调整不影响其余功能</dd>".
		"<dd class='f_14' >对于<span class='f_red'>基于MSDK内置浏览器做二次开发的同学</span>：在解密MSDK加密内容时需要根据请求类型选择不同的解密方式。详情<a href='http://wiki.dev.4g.qq.com/v2/ZH_CN/android/index.html#!version.md#Android_2.8.1变更内容' target='_blank'>点击查看</a></dd>";

	//强制更新 强烈推荐更新 推荐更新 建议更新

}else{
	$version = "MSDK 1.3.3a";
	$data["title"]="<span class='f_red f_bold'>".$version." 发布公告</span>";
	$data["desc"]=
		"<dd class='f_16' >在开发团队的努力下，".$version." 正式发布了！</dd>".
		"<dd class='f_16' >版本介绍：<a href='http://wiki.dev.4g.qq.com/v2/agsdk/index.html#!VERSION.md' target='_blank'>点击查看版本历史</a></dd>".
		"<ul>".
			"<li>升级信鸽SDK至2.38版本，提高触达率。</li>".
		"</ul>".
		"<dd class='f_16' >下载地址：<a href='http://wiki.dev.4g.qq.com/v2/agsdk/index.html#!index.md#包下载地址' target='_blank'>前往下载</a></dd>".
		"<dd class='f_16' >升级方法：<a href='http://wiki.dev.4g.qq.com/v2/agsdk/index.html#update.md' target='_blank'>点击查看</a></dd>".
		"<dd class='f_16 f_red' >推荐级别：建议更新</dd>";

	//强制更新 强烈推荐更新 推荐更新 建议更新

}


if(time() > $endTime){
	$data["show"]=false;
}else{
	$data["show"]=true;
}
echo json_encode($data);  //返回格式，必需
?>

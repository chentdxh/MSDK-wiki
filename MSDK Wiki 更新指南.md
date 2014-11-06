# 目录结构

- **MSDK Wiki 更新指南.md：MSDK wiki更新的说明**
- **android：Android Wiki相关文档**

	- navigation.md：Android Wiki 菜单配置文件
	- config.json：Android Wiki 风格配置
	- *.md：Android 各模块文档
	- *.jpg：Android 文档中用到的图片

- **ios：IOS Wiki相关文档**

	- navigation.md：IOS Wiki 菜单配置文件
	- config.json：IOS Wiki 风格配置
	- *.md：IOS 各模块文档
	- *.jpg：IOS 文档中用到的图片	

- **router：Router Wiki相关文档**

	- navigation.md：Router Wiki 菜单配置文件
	- config.json：Router Wiki 风格配置
	- *.md：Router 各模块文档
	- *.jpg：Router 文档中用到的图片
		
# 更新步骤

1. **开发完善文档：**

	开发同学修改自己负责模块的markdown文件，同时如果整个wiki的菜单有调整的话，到navigation.md里面修改对应模块的内容。

- **提交更新后的文档到SVN：**

	文档修改完成以后确认无误，提交内容到SVN

- **上传文档**
	
	利用上传工具提交更新的内容到测试环境（包括图片和markdown文件）。各模块上传工具地址如下：
	
	- Android :**[http://wekefu.ied.com/msdk/upload/android.php](http://wekefu.ied.com/msdk/upload/android.php)**
	
	- IOS :**[http://wekefu.ied.com/msdk/upload/ios.php](http://wekefu.ied.com/msdk/upload/ios.php)**
	
	- Router :**[http://wekefu.ied.com/msdk/upload/router.php](http://wekefu.ied.com/msdk/upload/router.php)**
	
	**备注：请使用模块对应的链接来上传文件，使用错误链接会覆盖对应平台文档，请上传前确认，切记！**

- **确认效果**

	在测试环境查看效果，如果有问题，回滚，没有问题在5分钟后前往正式环境查看

#环境说明：

## SVN 地址：[http://tc-svn.tencent.com/ied/ied_ieod03_rep/MSDK_proj/document/Wiki](http://tc-svn.tencent.com/ied/ied_ieod03_rep/MSDK_proj/document/Wiki)

##测试环境：[http://wekefu.ied.com/](http://wekefu.ied.com/)

- **Aondroid：[http://wekefu.ied.com/msdk/wiki/android/index.html](http://wekefu.ied.com/msdk/wiki/android/index.html)**

- **IOS：[http://wekefu.ied.com/msdk/wiki/ios/index.html](http://wekefu.ied.com/msdk/wiki/ios/index.html)**

- **Router：[http://wekefu.ied.com/msdk/wiki/router/index.html](http://wekefu.ied.com/msdk/wiki/router/index.html)**

##正式环境：[http://wiki.dev.4g.qq.com](http://wiki.dev.4g.qq.com)

- **Aondroid：[http://wiki.dev.4g.qq.com/v2/android/index.html](http://wiki.dev.4g.qq.com/v2/android/index.html)**

- **IOS：[http://wiki.dev.4g.qq.com/v2/ios/index.html](http://wiki.dev.4g.qq.com/v2/ios/index.html)**

- **Router：[http://wiki.dev.4g.qq.com/v2/router/index.html](http://wiki.dev.4g.qq.com/v2/router/index.html)**

##注意事项：

- 正式环境的wiki与测试环境有5分钟的时间间隔，后台会自动每隔5分钟将测试环境文档自动同步到正式环境。
- 使用过程中如果有任何疑问，请联系hardyshi。


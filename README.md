## 目录结构

- **CSS：wiki页面相关的css**

- **font：wiki页面使用到的特殊字体**

- **js：wiki页面相关的js**

- **upload：wiki文档上传工具**

- **ZH_CN：MSDK中文文档**

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
	- **README.html：MSDK Wiki相关链接**

- **KO_KR：MSDK한국어 설명 문서**	

	- 디렉터리 구조는 위와 같습니다	- **한국어 문서는 번역 등 원인으로 업데이트 시 중국어 문서에 비해 2주정도 늦을 겁니다 **

- **JP：MSDK日文文档**	

	- ディレクトリ構造は以上となる。
	**日本語ドキュメントは翻訳に時間がかかるため、更新スピードは中国版より約2週間が遅れる。	
- **EN：MSDK English Documentation** 	- Catalogue Structure is the same as described above	- **Due to translation reason update of English documentation is about two weeks delay than Chinese documentation**
	
## WIKI链接

- **Github Site**

	- [http://coolbee-studio.github.io/](http://coolbee-studio.github.io/)

- **中文 Wiki 地址：**

	- Android Wiki：[http://wiki.dev.4g.qq.com/v2/ZH_CN/android/index.html](http://wiki.dev.4g.qq.com/v2/ZH_CN/android/index.html)
	- IOS Wiki：[http://wiki.dev.4g.qq.com/v2/ZH_CN/ios/index.html](http://wiki.dev.4g.qq.com/v2/ZH_CN/ios/index.html)
	- 后台 Wiki：[http://wiki.dev.4g.qq.com/v2/ZH_CN/router/index.html](http://wiki.dev.4g.qq.com/v2/ZH_CN/router/index.html)

- **한국어:**

	- Android Wiki：[http://wiki.dev.4g.qq.com/v2/KO_KR/android/index.html](http://wiki.dev.4g.qq.com/v2/KO_KR/android/index.html)
	- IOS Wiki：[http://wiki.dev.4g.qq.com/v2/KO_KR/ios/index.html](http://wiki.dev.4g.qq.com/v2/KO_KR/ios/index.html)
	- Router Wiki：[http://wiki.dev.4g.qq.com/v2/KO_KR/router/index.html](http://wiki.dev.4g.qq.com/v2/KO_KR/router/index.html)

- **日本語:**

	- Android Wiki：[http://wiki.dev.4g.qq.com/v2/JP/android/index.html](http://wiki.dev.4g.qq.com/v2/JP/android/index.html)
	- IOS Wiki：[http://wiki.dev.4g.qq.com/v2/JP/ios/index.html](http://wiki.dev.4g.qq.com/v2/JP/ios/index.html)
	- Router Wiki：[http://wiki.dev.4g.qq.com/v2/JP/router/index.html](http://wiki.dev.4g.qq.com/v2/JP/router/index.html)

- **English:**

	- Android Wiki：[http://wiki.dev.4g.qq.com/v2/EN/android/index.html](http://wiki.dev.4g.qq.com/v2/EN/android/index.html)
	- IOS Wiki：[http://wiki.dev.4g.qq.com/v2/EN/ios/index.html](http://wiki.dev.4g.qq.com/v2/EN/ios/index.html)
	- Router Wiki：[http://wiki.dev.4g.qq.com/v2/EN/router/index.html](http://wiki.dev.4g.qq.com/v2/EN/router/index.html)
	
## 站点地图（SiteMap）

- 中文：[http://wiki.dev.4g.qq.com/v2/site.html](http://wiki.dev.4g.qq.com/v2/site.html)
- 한국어：[http://wiki.dev.4g.qq.com/v2/KO_KR/site.html](http://wiki.dev.4g.qq.com/v2/KO_KR/site.html)
- 日本語：[http://wiki.dev.4g.qq.com/v2/JP/site.html](http://wiki.dev.4g.qq.com/v2/JP/site.html)
- English：[http://wiki.dev.4g.qq.com/v2/EN/site.html](http://wiki.dev.4g.qq.com/v2/EN/site.html)
	
## MDWiki相关介绍：

####github地址：[https://github.com/Dynalon/mdwiki](https://github.com/Dynalon/mdwiki)

#####官网：[http://www.mdwiki.info](http://www.mdwiki.info)

####使用指引：参见github地址

## 写在最后

MSDK做了这么久，被开发商嗤之以鼻最多的问题之一就是文档。问题的原因比较多，主要是三个方面：

1. MSDK没有完整的线上文档，所有的文档都是跟随版本包。
2. MSDK同时外发版本太多
3. MSDK的版本文档使用word编写，不同版本文档不易比对。

由于以上的问题，经常出现游戏更新版本以后没有同步使用新版本的文档，无法同步更新我们已经修正的文档错误，或者由于文档比对太过麻烦和版本太多，开发修改文档错误以后比较难同步修改到其余版本。

为了解决这个问题，MSDK团队早期尝试过使用wiki，然而由于wiki的语法太过复杂，编辑的时间成本很高，所以最终还是没能坚持。但是文档online化总要解决，不然上面的问题会一直存在。为了让伟大的开发哥哥们不受困于wiki，最后在github终于找到了神器。mdwiki一个基于bootstrap的，使用markdown编辑内容的js wiki框架。

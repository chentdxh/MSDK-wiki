MSDK RQD(RDM) 相关模块
===


RQD接入配置
---
1. 接入时需要loadlibrary:![loadlibrary](/rdmloadlibrary.png)
这个主要是native crash的上报
2. 打开和关闭rdm数据上报的设置函数:![enable](/rdmenable.png)

在WGPlatform里面有这个函数，如果将bRdmEnable设为false则关闭rdm crash上报。

Crash数据上报
---
####如何查看上报数据
- 网址:[http://rdm.wsd.com/](http://rdm.wsd.com/)

![rdmwsd](/rdmwsd.png)
![rdmdetail](/rdmdetail.png)

####首次注册绑定(具体情况可联系spiritchen):
![rdmregister](/rmdregister.png)
MSDKDns介绍
=======

## 功能介绍
####MSDKDns的主要功能是为了提升手游用户接入体验，有效的避免由于运营商传统LocalDns解析导致的无法访问最佳接入点的方案。原理为使用Http加密协议替代传统的DNS协议，整个过程不使用域名，大大减少劫持的可能性。


##安装包结构
压缩文件中包含demo工程，其中包含：

	MSDKDns.framework：适用“Build Setting->C++ Language Dialect”配置为GNU++98，“Build Setting->C++ Standard Library”为“libstdc++(GNU C++ standard library)”的工程。
	MSDKDns_C11.framework：适用于该两项配置分别为“GNU++11”和“libc++(LLVM C++ standard library with C++11 support)”的工程。


##依赖库
MSDKDns依赖MSDK2.4.0i及其以上版本，接入MSDKDns之前必须接入MSDKFoundation.framework、MSDK.framework。


##获取IP
- ###概述
引入头文件，调用WGGetHostByName接口会返回IP数组。

```
    /**
     *
     *  @param domain 域名
     *  @return 查询到的IP数组，超时（3s）或者未未查询到返回空数组
     */
    std::vector<unsigned char*> WGGetHostByName(unsigned char* domain);
```
- ###示例代码
接口调用示例：

```
	std::vector<unsigned char*> ipsVector = MSDKDns::GetInstance()->WGGetHostByName((unsigned char *)"www.qq.com");
    if (ipsVector.size() > 0){
        unsigned char* ip = ipsVector[0];
        //Use ip to do something.
    }
```


##控制台日志
- ###概述
游戏可以通过开关控制是否打印MSDKDns相关的Log，注意和MSDKLog区分。

```
	/**
     *
     *  @param enabled true:打开 false:关闭
     */
    void WGOpenMSDKDnsLog(bool enabled);
```

- ###示例代码
接口调用示例：

```
 	MSDKDns::GetInstance()->WGOpenMSDKDnsLog(true);
```


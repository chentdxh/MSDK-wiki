MSDK RQD(RDM) 相关模块
===


RQD开关配置
---
    /**
    * @param bRDMEnable 是否开启RDM的crash异常捕获上报
    * @param bMTAEnable 是否开启MTA的crash异常捕获上报
    */
    void WGEnableCrashReport(bool bRDMEnable, bool bMTAEnable);


Crash数据上报
---
    /**
    * 自定义数据上报, 此接口仅支持一个key-value的上报, 从1.3.4版本开始, 建议使用void WGReportEvent( unsigned char* name, std::vector<KVPair>& eventList, bool isRealTime)
    * @param name 事件名称
    * @param body 事件内容
    * @param isRealTime 是否实时上报
    * @return void
    */
    void WGReportEvent(
    unsigned char* name, 
    unsigned char * body, 
    bool isRealTime
    ) DEPRECATED(1.3.4);

    /**
    * @param name 事件名称
    * @param eventList 事件内容, 一个key-value形式的vector
    * @param isRealTime 是否实时上报
    * @return void
    */
    void WGReportEvent(
    unsigned char* name, 
    std::vector<KVPair>& eventList, 
    bool isRealTime
    );

####如何查看上报数据
- 网址:[http://rdm.wsd.com/](http://rdm.wsd.com/)

![rdmwsd](/rdmwsd.png)
![rdmdetail](/rdmdetail.png)

####首次注册绑定(具体情况可联系spiritchen):
![rdmregister](/rmdregister.png)
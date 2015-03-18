MSDK RQD(RDM) 関連モジュール
===


RQDのスイッチ配置
---
    /**
    * @param bRDMEnable RDMのcrash異常報告をオンにしますか
    * @param bMTAEnable MTAのcrash異常報告をオンにしますか
    */
    void WGEnableCrashReport(bool bRDMEnable, bool bMTAEnable);


Crashデータ報告
---
    /**
    * データ報告を自己定義し、このインターフェースは1つのkey-valueの報告だけに対応します。1.3.4バージョンから、void WGReportEvent( unsigned char* name, std::vector<KVPair>& eventList, bool isRealTime)を利用するよう提案します。
    * @param name イベント名称
    * @param body イベント内容
    * @param isRealTime　リアルタイムに報告しますか
    * @return void
    */
    void WGReportEvent(
    unsigned char* name, 
    unsigned char * body, 
    bool isRealTime
    ) DEPRECATED(1.3.4);

    /**
    * @param name イベント名称
    * @param eventList イベント内容で、key-value形式のvectorです
    * @param isRealTime　リアルタイムに報告しますか
    * @return void
    */
    void WGReportEvent(
    unsigned char* name, 
    std::vector<KVPair>& eventList, 
    bool isRealTime
    );

####どのように報告データを見ますか
- サイト:[http://rdm.wsd.com/](http://rdm.wsd.com/)

![rdmwsd](/rdmwsd.png)
![rdmdetail](/rdmdetail.png)

####初めて登録・バンディング(詳細はspiritchenにお問合せください):
![rdmregister](/rmdregister.png)


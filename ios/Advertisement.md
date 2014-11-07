广告
===

##概述
 - 该功能在2.1.0版本以后提供，需要游戏在info中添加如下配置进行广告数据定时拉取：
![Alt text](./Advertisement1.png)

---

##广告接口
 - 调用WGShowAD将使用MSDK配置的一套界面显示当前有效的公告，调用WGHideScrollNotice隐藏展示的滚动公告。
```ruby
 void WGPlatform::WGShowAD(const _eADType& scene) const;
```
>描述: 显示指定scene当前有效的公告。通过参数type的确定展示哪种公告，如下：
```ruby
typedef enum _eADType
{
   Type_Pause  = 1, // 暂停位广告
Type_Stop = 2, // 退出位广告
}eADType;
```
iOS目前只使用Type_Pause（暂停位广告）。
参数: 
  - Type需要展示的广告类型

 - 
```ruby
void WGCloseAD (const _eADType& scene);
```
>描述: 隐藏已展示的广告
注：广告展示界面的按钮是通过AdvertisementConfig.plist定制的。可通过plist配置按钮数量、图片和tag，该tag在用户点击后会通过回调返回游戏，该plist文件放在framework/Resources/ AdvertisementResources下对应的子目录中。模版的元素和定义说明详见附录G。

---
##示例代码
 - 获取公告数据列表接口调用代码示例：
```ruby
WGPlatform *plat = WGPlatform::GetInstance();
plat->WGShowAD(Type_Pause);
```

 - 根据“Get Started-Step5”设置WGAdObserver后，用户点击按钮的事件会回调在observer的OnADNotify函数，示例代码：
```ruby
void MyAdObserver::OnADNotify(ADRet& adRet) 
{
NSString *string = [NSString stringWithCString:(const char*)adRet.viewTag.c_str() encoding:NSUTF8StringEncoding];
    NSLog(@"btn tag == %@",string);
    
    WGPlatform *plat = WGPlatform::GetInstance();
    plat->WGCloseAD(Type_Pause);
}
```
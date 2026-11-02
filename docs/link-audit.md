# 主题链接审查（2026-11-02）

扫描主题PHP、JS、CSS及对应min产物，区分运行时链接、后台元信息、代码注释与许可文档。

已修正：

- index.php主题头：后台作者显示半隐，链接指向MoluRead仓库；介绍中的作者网站指向陌路之引，文档和反馈指向xgchip/MoluRead。
- screenshot.png：替换上游站点截图，使用当前MoluRead首页预览。
- 首页Hello组件的关于主题按钮：删除旧harmonyhues.html地址，指向MoluRead仓库。
- Atheme.php：确认仓库、更新记录指向MoluRead，展示作者为半隐。
- 轮播示例、默认图标与Logo：确认使用当前主题动态资源地址，没有请求上游站点图片。
- 默认收款设置为空，不启用上游收款地址。已配置的正式站图片与收款信息不被覆盖。
- 页面页脚和控制台：确认展示MoluRead。

保留：

- ATTRIBUTION.md、上游README副本、Git历史与原文件注释中的上游署名和链接，用于来源、许可与第三方归属。
- Typecho官网、CC许可、工信部备案、第三方库文档、字体工具、分享服务和浏览器升级说明：属于各自功能或资料，不冒充主题作者站点。
- assets/js/harmonyhues.js及min文件名与内部hh前缀：为内部实现命名，不会把用户导向上游网站。
- 站内about.html、links.html、privacy.html等由站长提供的独立页面入口，未改写为作者的个人页面。

没有批量替换文章正文或用户保存的外链。仓库的安装默认设置与正式站已有设置分开维护。

补充：新安装默认Logo与favicon改为MoluRead自有SVG标识，轮播示例使用当前screenshot.png，不再默认展示上游品牌图片；不覆盖既有站点保存的图片设置。

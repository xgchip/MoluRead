# HarmonyHues二次开发入口

这是供独立开发和后续分发的Typecho主题仓库。保留作者原README、署名、版本头和Git历史；显示名称已改为陌阅 MoluRead，未改变上游授权，项目仓库为 https://github.com/xgchip/MoluRead。

## Git与来源

- 上游：https://github.com/wugeng20/HarmonyHuesTheme.git
- 本次基线：`42c684b1d09f5a2ae4334ab4651ff96cfbbbf630`，主题2.0.0。
- `upstream`指向作者仓库；`develop`为本地开发分支，`main`保留上游状态。origin指向xgchip/MoluRead。
- SQLite、首图封面等适配已经放入工作区，已整理至MoluRead发布提交，使用 `git diff` 审阅。

```bash
git status
git diff
git fetch upstream
# 在单独分支评估上游改动，不直接覆盖自己的修改。
```

将来创建自己的远程仓库后，再用 `git remote add origin <自己的仓库地址>` 连接。不要向作者仓库直接推送。

## 文件地图

| 文件/目录 | 作用 |
| --- | --- |
| index.php、archive.php | 首页与归档入口 |
| post.php、page.php | 文章和页面布局 |
| components/ | 导航、页脚、文章列表、正文和侧栏组件 |
| core/theme-config.php | 原生后台主题设置 |
| core/editor-config.php | 编辑器扩展和文章自定义字段 |
| core/function.php | 查询、封面、资源路径与主题初始化 |
| core/content-parse.php | 正文短代码、图片、标题锚点解析 |
| assets/css/*.scss | 样式源文件 |
| assets/css/*.css、*.min.css | 已生成的样式，模板通常加载min文件 |
| assets/js/*.js、*.min.js | 脚本源码及压缩产物 |
| assets/typecho/ | 后台主题设置和编辑器资源 |
| assets/lib/、core/PHPMailer/ | 第三方依赖，保留各自声明 |

仓库没有现成package.json或统一构建命令。本次未额外引入框架。修改SCSS/JS时须检查模板实际加载的文件，并同步生成CSS/min产物；不能只改源文件就声称页面已经生效。资源URL带filemtime缓存标记。

## 已带入的通用适配

1. 列表SQL使用AND和CASE，兼容SQLite；MySQL支持需在独立测试站回归验证。
2. 文章封面依次读取thumb、cover、正文首图，不要求其他站点具备WordPress迁移字段；没有图片时沿用无封面展示。
3. 已有标题id不重复添加，保留历史锚点。
4. 上一篇/下一篇同时接受NULL和空字符串密码。
5. 自定义页脚时正常闭合容器。
6. 默认署名文字不自动断言所有历史文章均为原创。

这些修改不包含正式站的页脚、侧栏配置、文章内容、WordPressHtml插件、数据库或阅读数导入脚本。线上通过主题设置保存的图片比例和头像尺寸修正没有混入上游默认配置，若要向其他用户提供同样效果，应在通用样式中实现并验证。

## 网站预览与安装

这是主题，不是完整Typecho程序。用户明确选择：本地只修改源码，不搭建或运行本地预览；二次开发后，备份线上主题，再上传到用户授权的Typecho网站检查实际效果。保持目录名HarmonyHues，因为上游部分资源路径使用该名字。向其他用户交付时，整个主题目录放入其Typecho的 `usr/themes/HarmonyHues/`，后台“控制台 → 外观”启用，再配置“设置外观”。

网站预览使用网站已有配置，本地源码和可分发主题不携带正式数据库、凭证或本站图片。更新前保留线上回退点，更新后重新核验页面；旧版本已验证的结果不能代替新改动的测试。

## 发布前检查

- 用原生Typecho后台验证启用、设置保存、普通Markdown和历史HTML文章。
- 覆盖SQLite/MySQL、首页/分类/标签/分页/搜索/文章/评论，检查手机、深浅色、目录和图片比例。
- 阅读数会写库；SQLite测试使用WAL可改善并发，运行中的备份使用SQLite在线backup，不能只复制.db。
- 审核原主题示例链接、作者个人图片/收款码、默认页脚的站点声明，保留合理示例与原作者署名，不携带本人的私有数据。
- 打包时外层目录为HarmonyHues，排除.git、开发环境、数据库、凭证、日志和缓存；保留署名、来源、改动说明和第三方声明。
- 发布前更新版本号与更新说明；确认压缩包能在干净Typecho中独立安装。

## 上游授权状态

本次获取的上游README通过徽章标注 **CC BY-NC-SA 4.0**，但仓库根目录未见独立LICENSE文件。保留该标注和作者信息，不擅自替换为MIT/GPL或宣称可商用。分发前按作者实际授权核对署名、非商业与相同方式共享等要求；计划收费或商业分发时，先明确取得适用授权。第三方库按各自声明处理。

## 与线上站点的关系

本地编辑不会自动更新正式站，仓库没有部署钩子。后续部署应明确目标和版本，先备份再切换；不能把服务器配置、数据库、文章或密钥加入此仓库。

## 阅读页二次开发（2026-11-01）

第一步阅读页与动态标签云已实现并上传网站预览，设计规范、文件入口与验证边界见 [docs/reading-layout.md](docs/reading-layout.md)。新增reading.css和tag-cloud.js由模板直接加载，修改这些源文件即可更新；其他上游min资源仍按原流程维护。

## 首页每页文章数（2026-11-02）

主题设置“外观与布局”新增homePageSize（1–48，默认12，留空沿用原生阅读设置）。themeInit在首页查询执行前应用数量，手机不再自动加一。后台管理员全站统计及迁移评论归属修复属于站点运维插件AdminOverview，不混入可分发主题。

## 可视化导航菜单（2026-11-02）

导航与分类分区新增navigationMode，支持自动分类或完全自定义。navbarInfo仍是原生保存字段，通过navigation.js可视化编辑，也接受旧JSON对象/对象序列和标准JSON数组。core/navigation.php统一校验与转义渲染，两级菜单，拒绝危险链接协议。新资源navigation.js/navigation.css直接加载，保留JS源码，无第三方依赖。

## 陌阅 MoluRead（2026-11-02）

显示名称：陌阅 MoluRead；版本2.1.0；二次开发署名半隐。保留 HarmonyHues 原作者星语社长与上游许可，目录仍为HarmonyHues以兼容资源路径及现有设置。页脚区分站点版权与主题来源；一言刷新按钮改为3秒透明度呼吸，悬停、聚焦暂停，减少动态效果时禁用。

网站署名按用户要求仅显示陌阅 MoluRead / 半隐；上游来源集中记录于 ATTRIBUTION.md，保留原 README、源码署名与 Git 历史。

## 一言模块（2026-11-02）

日期、问候、配图、引文及出处重新排版。widget-yiyan.php直接加载assets/js/yiyan.js，首次点击读取同源句库yiyan.txt，后续使用内存缓存并排除当前句子；仅更新文本和出处，不重载页面。包含8秒超时、重复点击保护、失败保留原句、aria-live提示。正式站浏览器点击已验证换句成功且页面未导航。样式位于reading.css。

## 目录统一（2.1.1）

当前安装与本地仓库目录统一为 MoluRead。默认图标、Logo与轮播使用动态主题路径；func.php从__DIR__加载。历史段落中的HarmonyHues目录仅说明旧版状态。正式站已迁移49项设置，旧主题和旧设置保留回退；首页、文章资源及一言局部刷新已回归。

# MoluRead

面向中文博客阅读的 Typecho 主题，基于 [HarmonyHues](https://github.com/wugeng20/HarmonyHuesTheme) 二次开发。

[在线演示](https://www.ee-nav.com/) · [反馈问题](https://github.com/xgchip/MoluRead/issues) · [更新记录](CHANGELOG.md) · [上游署名](ATTRIBUTION.md)

## 功能

- 居中文章标题、紧凑的文章信息与侧栏，默认关闭文章顶部封面。
- 列表封面支持 `thumb` → `cover` → 正文第一张 HTML 图片。
- 可视化两级导航菜单，支持排序、站内路径与新窗口打开。
- 首页每页文章数设置（1–48），手机与桌面分页保持一致。
- 动态或静态标签云，支持暂停、键盘访问及减少动态效果。
- 一言日期卡片和呼吸按钮，点击只更新句子与出处，不刷新页面。
- 浅色、深色和跟随系统模式；保留上游代码高亮、目录、灯箱等功能。
- SQLite 查询适配及历史文章锚点兼容。

## 环境与验证范围

建议 Typecho 1.2+、PHP 7.4–8.x。当前版本已在 PHP 8.2 + SQLite 的现有站点验证主要流程；MySQL、全新安装和所有 PHP 版本尚未完成完整回归。正式使用前请备份并在自己的环境检查。

## 安装

这是主题，不是完整的 Typecho 程序。

```bash
cd /你的站点/usr/themes
git clone https://github.com/xgchip/MoluRead.git MoluRead
```

也可下载仓库 ZIP，解压后将文件夹改名为 **MoluRead**，放入 `usr/themes/`。主题目录名与后台显示名称统一为 MoluRead，资源路径按当前主题动态生成。

进入 Typecho「控制台 → 外观」，启用主题后打开「设置外观」。首次安装请配置自己的 Logo、头像、站点信息和图片；收款码默认留空，请填写自己的图片地址。

## 配置

- **首页数量**：在外观与布局中设置每页文章数；留空沿用 Typecho 阅读设置。
- **导航**：选择自动分类或自定义菜单，使用编辑器添加、排序菜单及二级菜单。
- **文章封面**：在文章自定义字段填写 `thumb`；未填写时尝试 `cover` 和正文第一张 HTML 图片。文章顶部大封面可单独开关。
- **标签云**：选择动态或静态；系统减少动态效果时使用静态展示。
- **一言**：在侧栏勾选一言，句库位于 `assets/yiyan/yiyan.txt`，每行格式为 `句子——出处`。浏览器通过静态请求读取句库，使用外部资源域名时需允许跨域读取。
- **备案**：在“备案HTML内容”中填写链接，独立显示于页脚下方，自定义页脚也同样生效；不要在自定义页脚重复填写。

升级时先备份主题和数据库，再更新文件。Git 安装可使用 `git pull --ff-only`；存在本地改动时先审阅并合并，不要直接覆盖。版本更新后如仍看到旧样式，请刷新浏览器缓存。

## 开发与贡献

参见 [CONTRIBUTING.md](CONTRIBUTING.md) 与 [DEVELOPMENT.md](DEVELOPMENT.md)。修改源码后需同步实际加载的 CSS/JS 产物。仓库不包含完整站点、数据库、账号凭证及迁移插件。

欢迎通过 Issue 提交复现步骤，通过 Pull Request 提交改进。安全问题请按 [SECURITY.md](SECURITY.md) 私下报告。

## 许可与来源

本项目遵循上游标注的 **CC BY-NC-SA 4.0（署名—非商业性使用—相同方式共享）**，不以 MIT 重新许可，也不授予商业使用权。完整条款见 [LICENSE](LICENSE)；第三方组件仍适用各自许可。

原作者：星语社长；二次开发：半隐。来源、基线提交与第三方说明见 [ATTRIBUTION.md](ATTRIBUTION.md)。原始介绍保留于 [上游 README](docs/upstream/HarmonyHues-README.md)。本项目公开源码，但其非商业限制不符合通常允许商用的开源定义。

### 从旧目录升级

旧版安装在 HarmonyHues 时，先备份站点及主题设置；直接改文件夹名会改变 Typecho 的设置键。需将原主题设置迁移至 theme:MoluRead，并将其中 /usr/themes/HarmonyHues/ 资源地址更新为 /usr/themes/MoluRead/，再切换活动主题。不要在后台直接启用新目录后覆盖已有配置。

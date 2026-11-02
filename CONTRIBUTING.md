# 贡献指南

先搜索现有 Issue。反馈时提供 Typecho、PHP、数据库和浏览器版本、复现步骤及脱敏截图；不要上传数据库、后台 Cookie、密码或私钥。

请从 main 创建分支，每个 PR 解决一个明确问题，说明行为变化与验证方式。保持原生 Typecho 结构，不修改 Typecho 核心，不引入站点专用配置。保留上游与第三方署名和许可。

修改 PHP 后运行 `php -l 文件.php`，修改 JS 后运行 `node --check 文件.js`，提交前运行 `git diff --check`。SCSS 或 JS 修改需同步模板实际引用的 CSS/min 产物；reading.css、tag-cloud.js、yiyan.js 直接加载源码。

请在自己的测试站检查首页、文章、分页、导航、评论、手机布局及深浅模式，说明未验证的部分。此仓库不附带 Typecho 测试站或数据库。

提交贡献须有相应权利，并同意按本项目现有适用许可分发；第三方依赖保留原许可。

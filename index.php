<?php

/**
 * <ul><li>php 支持：  7.2 ~ 8.x （说明：php 8.x 需要使用 typecho 1.2+ 版本）</li><li>作者博客：<a href="https://www.biibii.cn/" target="_blank">BIIBII.CN</a></li><li>关于主题：<a href="https://www.biibii.cn/harmonyhues.html" target="_blank">HarmonyHues主题</a></li><li>Github：<a href="https://github.com/wugeng20/HarmonyHuesTheme" target="_blank">https://github.com/wugeng20/HarmonyHuesTheme</a></li></ul>
 * @package MoluRead — 专注阅读的 Typecho 主题
 * @author 半隐（二次开发）；星语社长（HarmonyHues 原作者）
 * @version 2.1.1
 * @link https://github.com/xgchip/MoluRead
 */

if (! defined('__TYPECHO_ROOT_DIR__')) {
  exit;
}

$this->need('components/header.php');

?>
<main>
  <div class="container py-2 px-0">
    <div class="row no-gutters">
      <?php $this->need('components/layout.php'); ?>
    </div>
    <div class="index-footer-widget mt-3 px-1">
      <?php $this->need('components/widgets/widget-hello.php'); ?>
      <?php $this->need('components/widgets/widget-timejourney.php'); ?>
      <?php $this->need('components/widgets/widget-links.php'); ?>
    </div>
  </div>
</main>
<?php $this->need('components/footer.php'); ?>
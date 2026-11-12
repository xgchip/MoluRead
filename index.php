<?php

/**
 * <ul><li>环境：Typecho 1.2+ / PHP 7.4–8.x</li><li>作者网站：<a href="https://www.ee-nav.com/" target="_blank" rel="noopener">陌路之引</a></li><li>主题文档：<a href="https://github.com/xgchip/MoluRead#readme" target="_blank" rel="noopener">MoluRead</a></li><li>GitHub：<a href="https://github.com/xgchip/MoluRead" target="_blank" rel="noopener">xgchip/MoluRead</a></li><li>问题反馈：<a href="https://github.com/xgchip/MoluRead/issues" target="_blank" rel="noopener">Issues</a></li></ul>
 * @package MoluRead — 专注阅读的 Typecho 主题
 * @author 半隐
 * @version 2.1.7
 * @link https://github.com/xgchip/MoluRead
 */

// Based on HarmonyHues by 星语社长. Source, license and modifications: ATTRIBUTION.md.
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

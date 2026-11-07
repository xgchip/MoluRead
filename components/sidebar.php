<?php
/**
 * Sidebar composition; original theme by 星语社长 (https://biibii.cn).
 * MoluRead: shared, configurable order for enabled modules.
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$widgets = array(
  'ShowAboutMe'=>'widget-blogger.php',
  'ShowSidebarYiyan'=>'widget-yiyan.php',
  'ShowHotPosts'=>'widget-hotposts.php',
  'ShowSidebarComments'=>'widget-newreply.php',
  'ShowBlogSignage'=>'widget-blogsignage.php',
  'ShowDevilEyes'=>'widget-devileyes.php',
  'ShowTags'=>'widget-tags.php',
);
$order = array_unique(array_merge(array_filter(array_map('trim', explode(',', (string) $this->options->sidebarOrder))), array_keys($widgets)));
$enabled = (array) $this->options->sidebarBlock;
$article = $this->is('post') || $this->is('page');
echo '<div class="main-sidebar col-lg-3 pt-2 pl-lg-3 pl-xl-3 pr-lg-2 pr-xl-2 d-none d-lg-block">';
foreach ($order as $key) {
  if (!isset($widgets[$key]) || !in_array($key, $enabled, true)) continue;
  // Reading pages keep the original compact module selection and TOC.
  if ($article && !in_array($key, array('ShowAboutMe','ShowHotPosts','ShowTags'), true)) continue;
  ob_start();
  require __DIR__ . '/widgets/' . $widgets[$key];
  $html = trim(ob_get_clean());
  if ($html !== '') echo '<div class="mlr-sidebar-item" data-sidebar-widget="' . $key . '">' . $html . '</div>';
}
if ($article) {
  echo '<div class="sidebar-list sticky-top sidebar-sticky mt-3">';
  require __DIR__ . '/widgets/widget-articletoc.php';
  echo '</div>';
}
echo '</div>';

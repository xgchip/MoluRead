<?php
/**
 * Tag cloud: real links, usage weights and optional motion.
 * @author 星语社长; local theme contributors
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (empty($this->options->sidebarBlock) || !in_array('ShowTags', $this->options->sidebarBlock)) return;
$this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($hhTagCloud);
$tags=[]; $max=1;
while($hhTagCloud->next()) {
    ob_start(); $hhTagCloud->permalink(); $url=ob_get_clean();
    ob_start(); $hhTagCloud->name(); $name=html_entity_decode(ob_get_clean(), ENT_QUOTES, 'UTF-8');
    $count=(int)$hhTagCloud->count; $max=max($max,$count);
    $tags[]=['name'=>$name,'url'=>$url,'count'=>$count];
}
$dynamic=(string)$this->options->tagCloudStyle!=='static';
?>
<section class="hh-widget mt-3" aria-label="文章标签">
  <div class="widget-title p-2 w-100"><div class="widget-title-top-bg" style="background:var(--tags-h-bg);"></div><i class="iconfont icon-biaoqian" aria-hidden="true"></i>标签云</div>
  <div class="widget-content tags-widget p-2">
    <?php if($tags): ?>
    <nav class="hh-tag-cloud" aria-label="按标签浏览"<?php echo $dynamic?' data-hh-tag-cloud':''; ?>>
      <?php foreach($tags as $tag): $size=12+4*log(1+$tag['count'])/log(1+$max); ?>
      <a href="<?php echo htmlspecialchars($tag['url'],ENT_QUOTES,'UTF-8'); ?>" style="--tag-size:<?php echo round($size,1); ?>px" title="<?php echo htmlspecialchars($tag['name'].' · '.$tag['count'].' 篇文章',ENT_QUOTES,'UTF-8'); ?>"><span><?php echo htmlspecialchars($tag['name'],ENT_QUOTES,'UTF-8'); ?></span><small aria-hidden="true"><?php echo $tag['count']; ?></small></a>
      <?php endforeach; ?>
    </nav>
    <?php if($dynamic): ?><button class="hh-tag-toggle" type="button" aria-pressed="false" hidden>暂停动态</button><?php endif; ?>
    <?php else: ?><p class="text-center">暂无标签</p><?php endif; ?>
  </div>
</section>

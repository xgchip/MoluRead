<?php

/**
 * 文章内容
 *
 * @author  星语社长
 * @link  https://biibii.cn
 * @update  2025-1-20 12:58:35
 */
if (! defined('__TYPECHO_ROOT_DIR__')) {
  exit;
}
?>
<?php $usePostCover = usePostCover($this); ?>
<?php if ($usePostCover): ?>
<?php $this->need('components/post-cover.php'); ?>
<?php endif; ?>
<!-- 文章st -->
<div id="post" class="post card">
  <div class="card-body">
    <?php if (! $usePostCover): ?>
    <!-- 文章信息 -->
    <header class="post-header hh-reading-header">
      <h1 class="post-title"><?php $this->title(); ?></h1>
      <?php if (! $this->is('page')): ?>
      <div class="hh-post-meta" aria-label="文章信息">
        <a href="<?php $this->author->permalink(); ?>" rel="author"><i class="iconfont icon-zuozhe" aria-hidden="true"></i><?php $this->author(); ?></a>
        <time datetime="<?php $this->date('c'); ?>"><i class="iconfont icon-shijian" aria-hidden="true"></i><?php $this->date('Y-m-d'); ?></time>
        <span><i class="iconfont icon-liulanjilu" aria-hidden="true"></i><?php PostViewCount($this); ?> 阅读</span>
        <a href="<?php $this->permalink(); ?>#comments"><i class="iconfont icon-pinglun1" aria-hidden="true"></i><?php $this->commentsNum('0', '1', '%d'); ?> 评论</a>
      </div>
      <?php endif; ?>
    </header>
    <?php endif; ?>
    <!-- 文章内容 -->
    <div class="post-content markdown-body" itemprop="articleBody" view-image>
      <?php $this->content(); ?>
    </div>
    <?php if (! $this->is('page')): ?>
    <div class="post-end d-flex align-items-center justify-content-center my-4">THE END</div>
    <!-- 文章标签+分类 -->
    <div class="category-and-tags d-flex flex-wrap align-items-center">
      <div class="post-category d-flex flex-wrap align-items-center mt-2">
        <span class="ct-title">分类：</span><?php $this->category('', true, ''); ?>
      </div>
      <div class="post-tags d-flex flex-wrap align-items-center mt-2">
        <?php if (count($this->tags) != 0): ?>
        <span class="ct-title">标签：</span><?php $this->tags('', true, ''); ?>
        <?php endif; ?>
      </div>
    </div>
    <!-- 分享+赞助 -->
    <div class="post-tools d-flex justify-content-center mt-4">
      <div class="post-tools-item d-flex flex-column align-items-center">
        <button class="btn d-flex flex-column align-items-center justify-content-center" id="poster-btn" title="文章海报"><i
            class="iconfont icon-haibao"></i></button>
        <span class="post-tools-title">海报</span>
      </div>
      <div class="post-tools-item d-flex flex-column align-items-center">
        <button class="btn d-flex flex-column align-items-center justify-content-center" id="reward-btn" title="赞赏作者"><i
            class="iconfont icon-zanshangma"></i></button>
        <span class="post-tools-title">赞赏</span>
      </div>
      <div class="post-tools-item d-flex flex-column align-items-center">
        <button class="btn d-flex flex-column align-items-center justify-content-center" id="share-btn" title="分享文章"><i
            class="iconfont icon-fenxiang1"></i></button>
        <span class="post-tools-title">分享</span>
      </div>
    </div>
    <!-- 版权声明 -->
    <div class="post-copyright mt-4 p-3">
      <div class="copyright-content">
        <div class="copyright-title">&#169版权申明</div>
        <p class="copyright-desc"><span class="ml-3"></span>- 本文由作者 <a href="<?php $this->author->permalink(); ?>"
            title="<?php $this->author(); ?>">@<?php $this->author(); ?></a>
          发布于<?php $this->options->title(); ?>站点。未经许可，禁止转载。</p>
      </div>
      <div class="copyright-svgname animated-signature svg-name">
        <?php $this->options->svgName(); ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>
<!-- 文章en -->
<!-- 上一篇、下一篇 -->
<?php if (! $this->is('page')): ?>
<nav class="mlr-post-navigation my-4" aria-label="文章导航">
  <?php foreach (array('prev' => '上一篇', 'next' => '下一篇') as $direction => $label): ?>
    <?php
    $adjacent = getAdjacentPost($this, $direction, $this->fields->articleType == 'image');
    $navTitle = $adjacent ? (string) $adjacent['title'] : ($direction === 'prev' ? '已是第一篇' : '已是最后一篇');
    $navClass = 'mlr-post-nav-item mlr-post-nav-' . $direction . ($adjacent ? '' : ' is-empty');
    ?>
    <?php if ($adjacent): $adjacentPost = Helper::widgetById('Contents', $adjacent['cid']); ?>
    <a class="<?php echo $navClass; ?>" href="<?php echo htmlspecialchars($adjacentPost->permalink, ENT_QUOTES, 'UTF-8'); ?>" rel="<?php echo $direction; ?>">
    <?php else: ?>
    <div class="<?php echo $navClass; ?>">
    <?php endif; ?>
      <span class="mlr-post-nav-label"><span class="mlr-post-nav-arrow" aria-hidden="true"><?php echo $direction === 'prev' ? '←' : '→'; ?></span><?php echo $label; ?></span>
      <span class="mlr-post-nav-title"><?php echo htmlspecialchars($navTitle, ENT_QUOTES, 'UTF-8'); ?></span>
    <?php if ($adjacent): ?></a><?php else: ?></div><?php endif; ?>
  <?php endforeach; ?>
</nav>

<?php endif; ?>
<!--文章评论-->
<?php $this->need('components/comments.php'); ?>
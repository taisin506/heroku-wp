<?php
/*
* -------------------------------------------------------------------------------------
* @author: EasTheme Team
* @author URI: https://eastheme.com
* @copyright: (c) 2020 EasTheme. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 1.0.1
*
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$class = 'items';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
  <div class="item"><a href="<?php the_permalink(); ?>" class="thumb">
    <?php echo the_thumbnail(get_the_ID(), '74','104'); ?>
  </a>
  <div class="info"><a class="name" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><h2 class="entry-title" itemprop="headline"><?php the_title(); ?></h2></a>
    <p> <?php echo excerpt(40); ?></p>
  </div>
</div>
</article>

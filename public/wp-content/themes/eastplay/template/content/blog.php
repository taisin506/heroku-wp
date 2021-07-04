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

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
   <div class="box-blog">
      <div class="img">
         <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
         <?php echo the_thumbnail(get_the_ID(),'270','166'); ?>
         </a>
      </div>
      <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
      <div class="exp">
         <p>
            <?php echo excerpt(10); ?>
         </p>
      </div>
        <span class="auth"> <i><?php echo get_the_date(); ?></i></span>
   </div>
</article>

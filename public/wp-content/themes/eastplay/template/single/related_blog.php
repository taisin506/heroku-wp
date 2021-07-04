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

$showpost = get_option('cnrelatedblog');

if ($showpost == '') {
	$showpost = '6';
}

?>
<div class="whites recanim widget_senction">
   <div class="widget-title">
      <h3><?php _d('Related Blog'); ?></h3>
   </div>
   <div class="blog-post">
      <div class="pad-blog">
         <?php
            $myposts = array(
              'showposts' => $showpost,
              'post_type' => 'blog',
              'orderby' => 'rand',
            );
            $wp_query = new WP_Query($myposts);
            while ($wp_query->have_posts()) : $wp_query->the_post();
            ?>
         <div class="box-blog">
            <div class="img">
               <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
               <?php echo the_thumbnail(get_the_ID(),'270','166'); ?>
               <div class="background_hover_image"></div>
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
         <?php endwhile; wp_reset_query(); ?>
      </div>
   </div>
</div>

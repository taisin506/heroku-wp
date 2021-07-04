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

$series_id = meta(get_the_ID(),'east_series');

$metasbdb = meta(get_the_ID(),'east_typesbdb');

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
   <div class="animepost">
      <div class="animposx">
         <a href="<?php the_permalink(); ?>"  alt="<?php the_title();?>" itemprop="url" rel="bookmark">
            <div class="content-thumb">
               <div class="ply">
                  <i class="fa fa-play"></i>
               </div>
               <?php echo the_thumbnail($series_id, '200','160' ); ?>
               <div class="type <?php echo meta($series_id, 'east_type'); ?>"><?php echo meta($series_id, 'east_type'); ?></div>
               <div class="score"><i class="fa fa-star"></i> <?php echo meta($series_id, 'east_score'); ?></div>
            </div>
            <div class="data">
               <div class="title"> <?php echo get_the_title($series_id); ?></div>
               <h2 class="entry-title screen-reader-text" itemprop="headline"><?php echo the_title();?></h2>
               <div class="plyepisode"><i class="fa fa-play-circle"></i> Episode <?php echo meta(get_the_ID(), 'east_episode');?></div>
               <div class="chdt"><?php echo human_time_diff( get_the_time('U', get_the_ID()), current_time('timestamp') ); ?></div>
               <span class="screen-reader-text"><time itemprop="dateCreated" datetime="<?php the_time('c'); ?>"></time></span>
            </div>
            <div class="data_tw">
         <a href="<?php echo get_the_permalink($series_id); ?>" class="ltseps"><?php _d('Latest Episode'); ?></a>
         </div>
         </a>
      </div>
   </div>
</article>


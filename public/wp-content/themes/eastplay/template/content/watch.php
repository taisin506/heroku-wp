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

$series = get_post_meta(get_the_ID(), 'east_series', true);
$episode = meta(get_the_ID(),'east_episode');
?>
<div class="animepost" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
   <div class="animposx" id="watch<?php the_id(); ?>">
      <div class="content-thumb">
         <div class="ply">
            <div class="data">
               <div class="profile_control"> <span><a href="<?php the_permalink(); ?>"><?php _d('View'); ?></a></span> <span><a class="user_views_control buttom-control-v-<?php the_id(); ?>" data-nonce="<?php echo wp_create_nonce('east_views_nonce'); ?>" data-postid="<?php the_id(); ?>"><?php _d('Remove'); ?></a></span></div>
            </div>
         </div>
        <?php echo the_thumbnail($series, '150','210' ); ?>
      </div>
      <div class="data">
         <div class="title"> <?php echo get_the_title($series);?></div>
         <div class="plyepisode"><i class="fas fa-play"></i> Episode <?php echo $episode; ?></div>
      </div>
   </div>
</div>

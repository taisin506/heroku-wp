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

$status = get_post_meta( get_the_ID(), 'east_status', true );
$type = get_post_meta( get_the_ID(), 'east_type', true );
$rating = get_post_meta( get_the_ID(), 'east_score', true );
?>
<div class="animepost" id="post<?php the_id(); ?>">
    <div class="animposx">
        <div class="content-thumb">
            <div class="ply">
                <div class="data">
                    <div class="profile_control animation-1">
                        <span><a href="<?php the_permalink(); ?>"><?php _d('View'); ?></a></span>
                        <span><a class="remove_favorites buttom-control-<?php the_id(); ?>" data-nonce="<?php echo wp_create_nonce('east_favorites_nonce'); ?>" data-postid="<?php the_id(); ?>"><?php _d('Remove'); ?></a></span>
                    </div>
                </div>
            </div>
          <?php echo the_thumbnail(get_the_ID(), '150','210' ); ?>
          <div class="type <?php echo meta(get_the_ID(), 'east_type'); ?>"><?php echo meta(get_the_ID(), 'east_type'); ?></div>
          <div class="score"><i class="fa fa-star"></i> <?php echo meta(get_the_ID(), 'east_score'); ?></div>
        </div>
        <div class="data">
            <div class="title">
                <?php the_title();?>
            </div>
         <div class="type"><?php echo status_anime(get_the_ID()); ?></div>
        </div>
    </div>
</div>

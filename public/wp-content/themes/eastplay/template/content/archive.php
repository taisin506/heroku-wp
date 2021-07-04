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
<article id="post-<?php the_ID(); ?>" <?php post_class('animpost'); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
<div class="animepost">
   <div class="animposx">
      <a rel="<?php the_ID();?>" href="<?php the_permalink();?>" title="<?php the_title();?>" alt="<?php the_title();?>">
         <div class="content-thumb">
            <div class="ply">
               <i class="fa fa-play"></i>
            </div>
            <?php echo the_thumbnail(get_the_ID(), '150','210' ); ?>
            <div class="type <?php echo meta(get_the_ID(), 'east_type'); ?>"><?php echo meta(get_the_ID(), 'east_type'); ?></div>
            <div class="score"><i class="fa fa-star"></i> <?php echo meta(get_the_ID(), 'east_score'); ?></div>
         </div>
         <div class="data">
            <div class="title"><h2><?php the_title();?></h2></div>
            <div class="type"><?php echo status_anime(get_the_ID()); ?></div>
         </div>
      </a>
   </div>
   <?php echo east_tooltip(get_the_ID()); ?>
</div>
</article>

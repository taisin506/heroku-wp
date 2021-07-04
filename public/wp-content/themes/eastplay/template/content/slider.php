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
<div class="animepost">
   <div class="animposx">
      <a rel="<?php the_ID();?>" href="<?php the_permalink();?>" title="<?php the_title();?>" alt="<?php the_title();?>">
         <div class="content-thumb">
            <?php echo the_thumbnail(get_the_ID(), '150','210', false ); ?>
         </div>
      </a>
   </div>
</div>

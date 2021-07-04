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
$post = get_post($series);
setup_postdata($post);
$trailer = meta(get_the_ID(), 'east_trailer');
$season = term(get_the_ID(),'season');
?>
<div class="episodeinf widget_senction">
<div class="infoanime nocover">
  <div class="areainfo">
   <div class="thumb" itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
      <?php echo the_thumbnail(get_the_ID(), '155','213' ); ?>
      <div class="rt">
        <div class="rating-area">
           <?php echo star_archive(get_the_ID(),1); ?>
        </div>
         <?php east_favorites_button($post->ID); ?>
      </div>
   </div>
   <div class="infox">
     <div class="areatitle">
        <div class="title">
       <h2 class="entry-title" itemprop="partOfSeries"><?php the_title(); ?></h2><span class="trailer"><a href="https://www.youtube.com/watch?v=<?php echo $trailer; ?>" class="east-trailer-popup"><i class="fab fa-youtube"></i> Trailer</a></span>
     </div>
       <div class="alternati">
         <span class="type"><?php echo meta(get_the_ID(),'east_type'); ?></span>
         <span><?php echo status_anime(get_the_ID()); ?></span>
         <span><?php echo meta(get_the_ID(),'east_duration'); ?></span>
         <?php if($season) { ?><span><?php echo $season; ?></span><?php } ?>
       </div>
     </div>
      <div class="desc">
        <h3><?php _d('Synopsis'); ?></h3>
         <div class="entry-content entry-content-single" itemprop="description">
            <?php echo get_the_content($series); ?>
         </div>
      </div>
      <div class="genre-info">
         <?php tax_genres(get_the_ID()); ?>
      </div>
   </div>
 </div>
</div>
</div>

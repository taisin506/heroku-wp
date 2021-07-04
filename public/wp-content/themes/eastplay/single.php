<?php
/*
* -------------------------------------------------------------------------------------
* @author: EasTheme
* @author URI: https://eastheme.com
* @copyright: (c) 2019 EasTheme. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 1.0.1
*
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$related = get_option('relatedanime');

$seri = get_post_meta(get_the_ID(), 'east_series', true);
$embd = get_post_meta(get_the_ID(), 'east_player', true);
$sub = get_post_meta(get_the_ID(), 'east_typesbdb', true);

get_ads('sadsheader');

?>
<div id="infoarea">
   <div id="shadow"></div>
   <div class="plyexpand"></div>
   <div id="primary" class="content-area post-body">
      <main id="main" class="site-main" role="main">
         <article id="post-<?php the_ID();?>" <?php post_class();?> itemscope="itemscope" itemtype="http://schema.org/Episode">
            <?php get_template_part('template/single/player'); ?>
            <?php EastPlay::episode_navigation(get_the_ID()); ?>
						<div id="mobileepisode"></div>
            <?php get_ads('adsbottomplayer','ads_info'); ?>
            <?php EastPlay::download_links(get_the_ID()); ?>
            <?php get_template_part('template/single/info'); ?>
         </article>
         <?php
            east_breadcrumbs_episode(get_the_ID());
            if($related == 1) { get_template_part('template/single/related'); }
            get_template_part('template/single/comments'); ?>
      </main>
   </div>
   <?php get_template_part('sidebar','episode'); ?>
</div>
<script>
var $selected = $('.selected_eps');
var $parent = $selected.parent();
$selected.remove();
$selected.prependTo($parent);
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
jQuery("#singlepisode").appendTo("#mobileepisode");
}
jQuery(function($){$('.east-trailer-popup').magnificPopup({type:'iframe',mainClass:'mfp-img-mobile mfp-no-margins mfp-with-zoom',removalDelay:160,preloader:false,zoom:{enabled:true,duration:300}});});
</script>
<?php get_footer(); ?>

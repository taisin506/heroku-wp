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

$showpost = get_option('countpost');

if ($showpost == '') {
	$showpost = '8';
}

echo '<div class="post-show">';

$myposts = array(
	'post_type' => 'anime',
	'orderby' => 'modified',
	'posts_per_page' => $showpost,
	'update_post_term_cache' => false,
	'update_post_meta_cache' => false,
	'cache_results' => false
);
$wp_query = new WP_Query($myposts);

while ($wp_query->have_posts()): $wp_query->the_post();

$lastid = EastPlay::latestepisode(get_the_ID());

if($lastid){
	$timeid = $lastid;
}else{
	$timeid = get_the_ID();
}

$metasbdb = meta($lastid,'east_typesbdb');

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
	<div class="animepost animver2">
	   <div class="animposx">
	      <a href="<?php echo get_the_permalink($lastid); ?>"  alt="<?php the_title();?>" itemprop="url" rel="bookmark">
	         <div class="content-thumb">
	            <div class="ply">
	               <i class="fa fa-play"></i>
	            </div>
							<div class="overlay"></div>
	             <?php echo the_thumbnail(get_the_ID(), '141','198' ); ?>
					  <div class="type <?php echo meta(get_the_ID(), 'east_type'); ?>"><?php echo meta(get_the_ID(), 'east_type'); ?></div>
					<div class="dataver2">
			 			<div class="title"><?php the_title();?></div>
			 			<span class="screen-reader-text"><time itemprop="dateCreated" datetime="<?php the_time('c'); ?>"></time></span>
			 	 </div>
	         </div>
					 <div class="data">
						 <div class="mark"><i class="fas fa-play-circle"></i></div>
							<div class="title"><h2>Episode <?php echo meta($lastid, 'east_episode');?></h2></div>
							<div class="type"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) .  __d(' ago'); ?></div>
					 </div>
	      </a>
	   </div>
	</div>
</article>
<?php endwhile;
wp_reset_query();
echo '</div>';

?>

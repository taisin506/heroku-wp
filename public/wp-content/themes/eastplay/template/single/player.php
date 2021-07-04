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

$series = meta(get_the_ID(), 'east_series');
$embd = get_post_meta(get_the_ID(), 'east_player', true);
$sub = get_post_meta(get_the_ID(), 'east_typesbdb', true);
$episode_id = get_the_ID();
?>
<div class="player-area widget_senction">
   <header class="entry-header info_episode widget_senction">
      <div class="lm">
         <?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
         <div class="sbdbti">
            <span class="epx">Episode <span itemprop="episodeNumber"><?php echo get_post_meta(get_the_ID(),'east_episode',true); ?></span>
            <?php if($sub) { ?><span class="lg"><?php echo $sub; ?></span></span><?php } ?>
         </div>
         <span class="year"><div class="animeprofile"><?php echo the_thumbnail($series); ?></div>
          <div class="authorbox"><a href="<?php echo get_the_permalink($series); ?>"><?php echo get_the_title($series); ?></a> / <?php _d('Posted by'); ?> <?php $author_id = get_post_field( 'post_author', get_the_ID() ); echo get_the_author_meta('user_nicename', $author_id); ?> / <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . __d(' ago'); ?></div></span>
      </div>
   </header>
   <?php get_ads('adsbottomtitle','ads_info'); ?>
   <?php if($embd) { ?>
   <div class="plarea">
      <div class="server_option">
         <div id="server">
            <?php EastPlay::server_player(get_the_ID()); ?>
         </div>
      </div>
      <div class="video-content">
         <div id="embed_holder">
            <div class="player-embed" id="pembed">
               <div class="playerload"></div>
               <div id="player_embed"></div>
            </div>
         </div>
      </div>
      <div class="video-nav">
         <div class="itemleft">
            <div class="icon expand"><i class="fa fa-expand-arrows-alt"></i> <span><?php _d('Expand');?></span></div>
            <div class="icon light"><i class="fa fa-lightbulb"></i> <span><?php _d('Turn on Light');?></span></div>
            <div class="icon shares"><i class="fa fa-share-alt"></i> <span><?php _d('Share');?></span></div>
            <div class="icon comment"><i class="fa fa-comment"></i> <a href="#comments"><span><?php _d('Comments');?></span></a></div>
            <?php east_watch_button(get_the_ID()); ?>
         </div>
         <div class="itemright">
            <div class="views"><?php echo wpb_get_post_views(get_the_ID()); ?></div>
         </div>
      </div>
   </div>
   <?php } else { echo '<div class="content-post">'; if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content(); endwhile; endif; wp_reset_query(); echo '</div>';} ?>
</div>
<div class="whites sds displaynone widget_senction">
   <div class="sharesection">
      <center>
         <b><?php _d('Share to your friends!');?></b>
         <?php east_social_share(get_the_ID()); ?>
      </center>
   </div>
</div>
<div class="whites <?php if($embd) { echo 'displaynone'; } else { echo 'displayblock'; } ?> widget_senction">
   <div class="sharesection">
      <center>
         <b><?php _d('Share to your friends!');?></b>
         <?php east_social_share(get_the_ID()); ?>
      </center>
   </div>
</div>

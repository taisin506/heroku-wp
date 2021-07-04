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

$member = get_option('membersystem');
$recom = get_option('recommendedanime');

$japanese = meta( get_the_ID(), 'east_japanese' );
$synonyms = meta( get_the_ID(), 'east_synonyms' );
$english = meta( get_the_ID(), 'east_english' );
$status = meta( get_the_ID(), 'east_status' );
$duration = meta( get_the_ID(), 'east_duration' );
$totaleps = meta( get_the_ID(), 'east_totalepisode' );
$source = meta( get_the_ID(), 'east_source' );
$trailer = meta(get_the_ID(), 'east_trailer');
$season = term(get_the_ID(),'season');
$producers = term_producers(get_the_ID());

?>
<article id="post-<?php the_ID();?>" <?php post_class();?> itemscope="itemscope" itemtype="http://schema.org/CreativeWorkSeries">
   <div id="container">
      <?php get_ads('adsbottomcover'); ?>
      <div id="infoarea">
         <div class="post-body">
            <div class="infoanime widget_senction">
               <div class="thumb" itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
                  <?php echo the_thumbnail(get_the_ID(), '205','282' ); ?>
                  <div class="rt">
                     <div class="rating-area">
                        <?php echo star_archive(get_the_ID(),1); ?>
                     </div>
                     <?php east_favorites_button(get_the_ID()); ?>
                  </div>
               </div>
               <div class="infox">
                  <div class="areatitle">
                     <div class="title">
                        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
                        <span class="trailer"><a href="https://www.youtube.com/watch?v=<?php echo $trailer; ?>" class="east-trailer-popup"><i class="fab fa-youtube"></i> Trailer</a></span>
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
                        <?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); the_content(); ?>
                     </div>
                  </div>
                  <div class="genre-info">
                     <?php tax_genres(get_the_ID()); ?>
                  </div>
               </div>
            </div>
            <div class="sds">
               <div class="sharesection">
                  <center>
                     <b><?php _d('Share to your friends!');?></b>
                     <?php east_social_share(get_the_ID());?>
                  </center>
               </div>
            </div>
            <div class="anim-senct">
               <?php get_ads('adstopinfo','ads_info'); ?>
               <div class="right-senc widget_senction">
                  <div class="anime infoanime">
                     <div class="infox">
                        <h3 class="anim-detail">Anime Detail</h3>
                        <div class="spe">
                           <?php if($japanese){ ?><span><b><?php _d('Japanese'); ?></b> <?php echo $japanese; ?></span><?php } ?>
                           <?php if($synonyms){ ?><span><b><?php _d('Synonyms'); ?></b> <?php echo $synonyms; ?></span><?php } ?>
                           <?php if($english){ ?><span><b><?php _d('English'); ?></b> <?php echo $english; ?></span><?php } ?>
                           <span><b><?php echo __('Source'); ?></b> <?php echo meta(get_the_ID(),'east_source'); ?></span>
                           <span><b>Total Episode</b> <?php echo meta(get_the_ID(),'east_totalepisode'); ?></span>
                           <span><b><?php _d('Released'); ?>:</b>  <?php echo meta(get_the_ID(),'east_date'); ?></span>
                           <span><b>Studio</b> <?php echo term(get_the_ID(),'studio'); ?></span>
                           <?php if($producers) { ?><span><b>Producers</b> <?php echo $producers; ?></span>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
               <span itemprop="author" itemscope itemtype="https://schema.org/Person" class="author vcard"><i itemprop="name" content="<?php the_author(); ?>"></i></span>
               <time itemprop="datePublished" class="entry-date published" datetime="<?php the_time('c'); ?>"></time>
            </div>
            <?php east_alert_genre(get_the_ID()); ?>
            <div class="whites widget_senction">
               <div class="widget-title">
                  <h3><?php _d('List Episode');?> Anime <?php the_title(); ?></h3>
               </div>
               <div class="lsteps">
                  <?php get_ads('adstoplsepisode','ads_lstepisode'); ?>
                  <?php EastPlay::list_episode(get_the_ID(), 1000);?>
                  <?php get_ads('adsbottomlsepisode','ads_blstepisode'); ?>
               </div>
            </div>
            <?php east_breadcrumbs_anime(get_the_ID()); endwhile; endif;
               if($recom == 1) { get_template_part('template/single/recom_anime'); }
               get_template_part('template/single/comments'); ?>
         </div>
         <?php get_template_part('sidebar','anime'); ?>
      </div>
   </div>
   </div>
</article>
<script>
	 jQuery(function($){$('.east-trailer-popup').magnificPopup({type:'iframe',mainClass:'mfp-img-mobile mfp-no-margins mfp-with-zoom',removalDelay:160,preloader:false,zoom:{enabled:true,duration:300}});});
</script>
<?php get_footer(); ?>

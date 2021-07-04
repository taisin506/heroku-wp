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

if(!function_exists('opengraph')){
  function opengraph() {
    $name = get_bloginfo('name');
   $opengraph = get_option('opengraph'); if($opengraph == '1') {
    if ( is_single() ) {
      $fbappid = get_option('fbappid');
      $twitterusername = get_option('twitterusername');
      $seri = get_post_meta( get_the_ID(), 'east_series', true );
      $description = wp_trim_words( get_post_field('post_content', $seri), 25 );
      ?>
      <meta property="og:title" content="<?php echo get_the_title(get_the_ID()); ?>" />
      <meta property="og:type" content="article" />
      <meta property="og:url" content="<?php echo get_the_permalink(get_the_ID()); ?>" />
      <meta property="og:description" content="<?php echo $description; ?>" />
      <meta property="og:locale" content="en_US" />
      <?php if($fbappid) { ?>
        <meta property="fb:app_id" content="<?php echo $fbappid; ?>" />
     <?php } ?>
     <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
     <meta property="og:image" content="<?php echo get_the_post_thumbnail_url($seri); ?>" />
     <meta property="og:image:width" content="300" />
     <meta property="og:image:height" content="450" />
     <meta name="twitter:title" content="<?php echo get_the_title(get_the_ID()); ?>" />
     <meta name="twitter:card" content="summary" />
     <meta name="twitter:url" content="<?php echo get_the_permalink(get_the_ID()); ?>" />
     <meta name="twitter:description" content="<?php echo $description; ?>" />

     <?php if($twitterusername) { ?>
      <meta name="twitter:site" content="<?php echo $twitterusername; ?>" />
      <meta name="twitter:creator" content="<?php echo $twitterusername; ?>" />
    <?php } else { ?>
      <meta name="twitter:site" content="@<?php echo $name; ?>" />
      <meta name="twitter:creator" content="@<?php echo $name; ?>" />
    <?php } ?>
  <?php } } } }
  ?>

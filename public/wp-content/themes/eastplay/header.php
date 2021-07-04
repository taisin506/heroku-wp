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

$customads = get_option('cadsheader');
$customcss = get_option('customcss');
$cover =  get_cover(get_the_ID(),'1263','303');
if( !is_singular('anime') ) { $class = 'bodyclass'; } else { $class = 'bodyclass-anime'; }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
   <head itemscope="itemscope" itemtype="http://schema.org/WebSite">
      <meta http-equiv="Content-Type" content="<?php bloginfo('html_type');?>; charset=<?php bloginfo('charset');?>" />
      <title><?php wp_title('–', true, 'right');?></title>
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="pingback" href="<?php bloginfo ('pingback_url');?>" />
      <?php wp_head();?>
   </head>
   <?php if ($customcss) {?>
   <style type="text/css">
      <?php echo $customcss; ?>
   </style>
   <?php }
      echo $customads;
      east_form_login();
      ?>
   <body <?php body_class( $class ); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
     <script>
        if (localStorage.getItem("theme-mode") == null){
           if (defaultTheme == "darkmode"){
             jQuery("body").addClass("darkmode");
           }else{
             jQuery("body").removeClass("darkmode");
           }
         }else if (localStorage.getItem("theme-mode") == "darkmode"){
           jQuery("body").addClass("darkmode");
         }else{
           jQuery("body").removeClass("darkmode");
         }
     </script>
     <header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
        <div class="header-area mobile-area">
           <div class="container">
              <div class="btnmenu"><span class="fa fa-bars"></span></div>
              <?php get_template_part('template/header/header'); ?>
              <div class="theme switchmode"> <label class="switch"><input type="checkbox"> <span class="slider round"></span></label> <span class="text"><i class="fas fa-sun"></i> / <i class="fas fa-moon"></i></span></div>
              <?php east_account_bar(); ?>
              <div class="btnsearch"><a class="aresp search-resp"><i class="fa fa-search"></i></a></div>
           </div>
        </div>
        <div id="primary-menu" class="mm">
           <div class="mobileswl">
              <?php east_account_bar(); ?>
              <div class="switch"> <span class="inner-switch"><i class="fas fa-moon"></i></span></div>
           </div>
           <div class="container">
              <div class="header-area desktop-area">
                 <div class="btnmenu"><span class="fa fa-bars"></span></div>
                 <?php get_template_part('template/header/header'); ?>
                 <div class="theme switchmode"> <label class="switch"><input type="checkbox"> <span class="slider round"></span></label> <span class="text"><i class="fas fa-sun"></i> / <i class="fas fa-moon"></i></span></div>
                 <?php east_account_bar(); ?>
                 <div class="search_desktop">
                    <form action="<?php bloginfo('url'); ?>/" id="form" method="get">
                       <input id="s" type="text" placeholder="<?php _d('Search'); ?>..." name="s" autocomplete="off"  />
                       <button type="submit" id="submit" class="search-button"><span class="fa fa-search"></span></button>
                    </form>
                    <div class="live-search ltr"></div>
                 </div>
                 <div class="btnsearch"><a class="aresp search-resp"><i class="fa fa-search"></i></a></div>
              </div>
              <nav id="site-navigation" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                 <?php
                    $nav_menu = wp_nav_menu(array('theme_location'=>'main', 'container'=>'', 'link_before'=>'<span itemprop="name">','link_after'=>'</span>','fallback_cb' => '', 'echo' => 0));
                    if(empty($nav_menu))
                     $nav_menu = '<ul>'.wp_list_categories(array('show_option_all'=>__('Home', 'dp'), 'title_li'=>'', 'echo'=>0)).'</ul>';
                    echo $nav_menu;
                    ?>
              </nav>
           </div>
        </div>
        <div class="search_responsive">
           <form method="get" id="form-search-resp" class="form-resp-ab" action="<?php bloginfo('url'); ?>/"> <input type="text" placeholder="Search..." name="s" id="ms" value="" autocomplete="off"> <button type="submit" class="search-button"><span class="fa fa-search"></span></button></form>
        </div>
     </header>
     <script>
        if (localStorage.getItem("theme-mode") == null){
           if (defaultTheme == "darkmode"){
             jQuery(".logo img").attr('src', '<?php echo get_option('logodark'); ?>');
             jQuery('.switch input').prop('checked', true);
             jQuery( ".inner-switch" ).html( '<i class="fas fa-sun" aria-hidden="true"></i>' );
           }else{
             jQuery(".logo img").attr('src', '<?php echo get_option('logo'); ?>');
             jQuery( ".inner-switch" ).html( '<i class="fas fa-moon" aria-hidden="true"></i>' );
           }
         }else if (localStorage.getItem("theme-mode") == "darkmode"){
           jQuery(".logo img").attr('src', '<?php echo get_option('logodark'); ?>');
           jQuery('.switch input').prop('checked', true);
           jQuery( ".inner-switch" ).html( '<i class="fas fa-sun" aria-hidden="true"></i>' );
         }else{
           jQuery(".logo img").attr('src', '<?php echo get_option('logo'); ?>');
           jQuery( ".inner-switch" ).html( '<i class="fas fa-moon" aria-hidden="true"></i>' );
         }
     </script>
      <?php if( is_singular('anime') ) { if($cover) { echo '<div class="coveri">';
        ?>
        <div class="coveranime">
           <div class="ime"> <?php
           echo $cover;
         echo '</div></div></div>';
       } } ?>
      <div class="site-content">
      <div id="<?php if( !is_singular('anime') ) { echo 'container'; } elseif($cover) { echo 'container-anime'; } else { echo 'container-manga'; } ?>">

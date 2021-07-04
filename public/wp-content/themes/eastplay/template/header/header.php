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

$logomobile = get_option('logomobile');
$logodesktop = get_option('logo');
$bnme = get_option('blogname');
if ( wp_is_mobile() ) {
	$logo = ($logomobile) ? "<img src='{$logomobile}' alt='{$bnme}'/>" : "<h1 class='text'>{$bnme}</h1>";
} else {
$logo = ($logodesktop) ? "<img src='{$logodesktop}' alt='{$bnme}'/>" : "<h1 class='text'>{$bnme}</h1>";
}
?>
<div class="logo-area">
   <div itemscope="itemscope" itemtype="http://schema.org/Brand" class="site-branding logox">
      <?php  if($logo) { if(is_home()){ ?>
      <h1 class="logo">
         <a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo $logo; ?><span class="hdl"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?></span></a>
      </h1>
      <?php } else { ?>
      <span class="logo">
      <a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo $logo; ?><span class="hdl"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?></span></a>
      </span>
      <?php } } ?>
      <meta itemprop="name" content="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" />
   </div>
</div>

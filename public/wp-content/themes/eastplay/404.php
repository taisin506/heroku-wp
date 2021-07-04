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

get_header(); ?>
<div id="content" class="content-separate">
   <div id="primary" class="content-area">
      <main id="main" class="site-main post-body widget_senction" role="main">
         <div class="widget-title">
            <h1><?php _d('Page not found'); ?></h1>
         </div>
         <h3 class="notfound"><?php _d('404 Not Found'); ?></h3>
      </main>
   </div>
   <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

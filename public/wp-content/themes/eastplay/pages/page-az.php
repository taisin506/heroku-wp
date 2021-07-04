<?php
/*
   Template Name: EasTheme - A-Z
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
            <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
         </div>
         <?php EastPlay::page_az(); ?>
       </main>
      </div>
      <?php sidebar_page(); ?>
   </div>
<?php get_footer(); ?>

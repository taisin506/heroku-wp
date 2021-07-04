<?php
/*
   Template Name: EasTheme - Shortcode
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
            <?php
               while ( have_posts() ) : the_post();
               the_content();
               endwhile;
               ?>
         </main>
      </div>
      <?php sidebar_page(); ?>
</div>
<?php get_footer(); ?>

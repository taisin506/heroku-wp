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
         <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="https://schema.org/CreativeWork">
            <header class="entry-header widget-title">
               <?php the_title( '<h1 class="entry-title page-title" itemprop="headline">', '</h1>' ); ?>
            </header>
            <div class="entry-content content-post" itemprop="text">
               <?php if (have_posts()) : while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
            </div>
         </article>
      </main>
   </div>
   <?php sidebar_page(); ?>
</div>
<?php get_footer(); ?>

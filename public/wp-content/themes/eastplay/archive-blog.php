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
            <h1 class="page-title" itemprop="headline">Blog</h1>
         </div>
         <div class="blog-post">
            <div class="pad-blog">
               <?php  if ( have_posts() ) : while ( have_posts() ) : the_post();
                  get_template_part('template/content/blog');
                  endwhile; ?>
               <?php else : ?>
               <?php endif; ?>
            </div>
             <?php echo east_pagination(); ?>
         </div>
      </main>
   </div>
   <?php sidebar_page(); ?>
</div>
<?php get_footer(); ?>

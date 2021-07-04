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

get_header(); ?>
<div id="content" class="content-separate">
   <div id="primary" class="content-area post-body widget_senction">
      <div class="widget-title">
         <h1 class="page-title" itemprop="headline"><?php _d('Results found:'); ?> <?php echo get_search_query(); ?></h1>
      </div>
      <main id="main" class="site-main relat" role="main">
         <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            get_template_part('template/content/archive');
            endwhile;
            else : ?>
         <h3 class="notfound"><?php _d('No results to show with'); ?> <b><?php echo get_search_query(); ?></b></h3>
         <?php endif; ?>
      </main>
      <?php echo east_pagination(); ?>
   </div>
   <?php sidebar_page(); ?>
</div>
<?php get_footer(); ?>

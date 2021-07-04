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

get_header();

echo '<div id="content" class="content-separate">';
echo '<div id="primary" class="content-area">';
echo '<main id="main" class="site-main post-body widget_senction" role="main">';
echo '<div class="widget-title">';
the_archive_title( '<h1 class="page-title" itemprop="headline">', '</h1>' );
echo '</div>';
echo '<div class="post-show">';
if ( have_posts() ) : while ( have_posts() ) : the_post();
get_template_part('template/content/category');
endwhile;
echo '</div>';
echo east_pagination();
else :
endif;
echo '</main>';
echo '</div>';
sidebar_page();
echo '</div>';
get_footer();

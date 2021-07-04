<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2021 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.4.2
*
*/
get_header();
$sidebar = dooplay_get_option('sidebar_position_archives','right');
echo '<div class="module"><div class="content '.$sidebar.'">';
echo '<header><h1>'. __d('Seasons'). '</h1><span>'.doo_total_count('seasons'). '</span></header>';
echo '<div id="archive-content" class="animation-2 items">';
if (have_posts()) {
    while (have_posts()) {
        the_post();
		get_template_part('inc/parts/item_se');
	}
}
echo '</div>';
doo_pagination();
echo '</div>';
echo '<div class="sidebar '.$sidebar.' scrolling"><div class="fixed-sidebar-blank">';
dynamic_sidebar('sidebar-home');
echo '</div></div>';
echo '</div>';
get_footer();

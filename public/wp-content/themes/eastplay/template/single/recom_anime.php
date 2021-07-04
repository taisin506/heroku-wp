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

$showpost = get_option('cnrecomanime');

if ($showpost == '') {
	$showpost = '8';
}

echo '<div class="whites recanim widget_senction">';
echo '<div class="widget-title">';
echo '<h3>'.__d('Recommend Anime').'</h3>';
echo '</div>';
echo '<div class="relat widget-post slidfer2">';

$myposts = array(
   'showposts' => $showpost,
   'post_type' => 'anime',
   'orderby' => 'rand',
);
$wp_query = new WP_Query($myposts);
while ($wp_query->have_posts()) : $wp_query->the_post();
 get_template_part('template/content/slider');
endwhile;
wp_reset_query();

echo '</div>';
echo '</div>';

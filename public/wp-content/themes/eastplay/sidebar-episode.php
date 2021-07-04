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

echo '<aside id="sidebar" role="complementary">';

EastPlay::series_episode_list(get_the_ID());

if(is_active_sidebar('sidebar-episode')){
dynamic_sidebar('sidebar-episode');
}
echo '</div>';

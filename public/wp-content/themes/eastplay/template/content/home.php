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

if(is_active_sidebar('main-top')){
	dynamic_sidebar('main-top');
}

if(is_active_sidebar('main-center')){
	dynamic_sidebar('main-center');
}

if(is_active_sidebar('main-bottom')){
	dynamic_sidebar('main-bottom');
}

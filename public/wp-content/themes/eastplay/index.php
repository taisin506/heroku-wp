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
if (!defined('ABSPATH'))
{
    exit;
}

get_header();

get_ads('hadsheader');

echo '<div id="content">';
echo '<div id="primary" class="content-area">';
echo '<main id="main" class="site-main post-body" role="main">';

get_template_part('template/content/home');

echo '</main>';
echo '</div>';

get_sidebar();

echo '</div>';

get_footer(); ?>

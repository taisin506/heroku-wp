<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2021 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.4.3
*/

# Theme options
define('DOO_THEME_DOWNLOAD_MOD', true);
define('DOO_THEME_PLAYER_MOD',   true);
define('DOO_THEME_DBMOVIES',     true);
define('DOO_THEME_USER_MOD',     true);
define('DOO_THEME_VIEWS_COUNT',  true);
define('DOO_THEME_RELATED',      true);
define('DOO_THEME_SOCIAL_SHARE', true);
define('DOO_THEME_CACHE',        true);
define('DOO_THEME_PLAYERSERNAM', true);
define('DOO_THEME_JSCOMPRESS',   true);
# Repository data
define('DOO_COM','Doothemes');
define('DOO_VERSION','2.4.3');
define('DOO_VERSION_DB','2.8');
define('DOO_ITEM_ID','154');
define('DOO_PHP_REQUIRE','7.1');
define('DOO_THEME','Dooplay');
define('DOO_THEME_SLUG','dooplay');
define('DOO_SERVER','https://doothemes.com');
define('DOO_GICO','https://s2.googleusercontent.com/s2/favicons?domain=');
# Define Logic data
define('DOO_TIME','M. d, Y');
define('DOO_MAIN_RATING','_starstruck_avg');
define('DOO_MAIN_VOTOS','_starstruck_total');
# Define Options key
define('DOO_OPTIONS','_dooplay_options');
define('DOO_CUSTOMIZE', '_dooplay_customize');
# Authorize copy
define('DOO_SGH1','_?g-c2H:<5wo5=S33fK8*A*IaO~ne+?iYi}6gF|i&qyNWw(bB-z+H)opii5aK*4n');
define('DOO_TRM2','u,<E>h6$e3K]cs~,9U>h|s}Ie$C-C[6C<;Yl_pEHy4)`f5)J?4uYrvy5)Zu*:,/O');
define('DOO_RPQ3','viVAPx?P<W)|L8@720*1ul4*d&|Cr_.ZftZKB!zSXuDrqn(QSjK?dC)Gp7p95uJs');
define('DOO_KGX4','h!XJ}--_){fSjhOOd#f5gQJ1M*j-W1Qm1sR0?y!/ 5]d.7}:]4Ya7I)qY{@7%mjz');
define('DOO_MJP5','V1-4J&}X0Nh^Q-NXJ:^.1#mW%<oF%djlz{<s$j?4_zHhg248[n1B14J-$[Cm7u4f');
define('DOO_LMK6','s`lp_9p*~tGWP;.!is[2k:~x|D6H_$;$Hw!8Ci/il-Ic2.?]+s02$frpo*o}V&5A');
define('DOO_CMU7','^UkG#q#M!z|:7Ji%%SDUIaxmNn]+q>:C4;9*O`pJv+&|;I8tf:[`D:9sH(?T<8Iy');
define('DOO_QDY8','Jx.p&GWiYQy+Ecck!q&c#H<46V;+rvk^xJ=beVk|%aO?ooLpWKIl]w9zaor0|:}?');
# Define template directory
define('DOO_URI',get_template_directory_uri());
define('DOO_DIR',get_template_directory());

# Translations
load_theme_textdomain('dooplay', DOO_DIR.'/lang/');

# Load Application
require get_parent_theme_file_path('/inc/doo_init.php');

/* Custom functions
========================================================
*/

	// Here your code

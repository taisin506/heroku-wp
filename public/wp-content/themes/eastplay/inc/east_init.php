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

add_filter( 'manage_post_posts_columns', 'set_custom_edit_anime_columns' );
function set_custom_edit_anime_columns($columns) {
    unset( $columns['anime_series'] );
    $columns['anime_series'] = __( 'Anime Series', 'esthm' );
    return $columns;
}

add_action( 'manage_post_posts_custom_column' , 'custom_anime_column', 10, 2 );
function custom_anime_column( $column, $post_id ) {
    switch ( $column ) {
        case 'anime_series' :
          $series =   get_post_meta( $post_id , 'east_series' , true );
            if ( $series )
                echo '<a href="post.php?post='.$series.'&action=edit">'.get_the_title($series).'</a>';
            else
                _e( '—', 'esthm' );
            break;
    }
}

function scheduleformat($d, $h, $m){
	$day = get_option('schday');
	$hour = get_option('schhour');
	$minute = get_option('schminute');
  // d = day, h = hour, m = minute
	return "$d$day $h$hour $m$minute";

}

if(!function_exists('east_user_wpadmin')){
    function east_user_wpadmin(){
				$accountpage = get_option('accountpage');
        if(is_user_logged_in() && !is_multisite()){
            if(!defined('DOING_AJAX') && current_user_can('subscriber')){
                wp_redirect(get_bloginfo('url').'/'.$accountpage);  exit;
            }
        }
    }
    add_action('admin_init', 'east_user_wpadmin');
}

if (!function_exists('get_relative_permalink')) {
	function get_relative_permalink($url) {
		return str_replace(home_url(), "", $url);
	}
}

remove_filter('the_excerpt', 'wpautop');

if (!function_exists('get_post_title')) {
	function get_post_title() {
		return get_the_title();
	}
}
add_shortcode('post_title', 'get_post_title');

if (!function_exists('get_post_link')) {
	function get_post_link() {
		return get_the_permalink();
	}
}
add_shortcode('post_link', 'get_post_link');

function status_anime($post_id) {
	$get_status = get_post_meta($post_id, 'east_status', true);
	if ($get_status == 'Finished Airing') {
		$status = __d('Completed');
	} else {
		$status = __d('Ongoing');
	}
	return $status;
}

function sidebar_page(){
 get_template_part('sidebar','page');
}

function wpse45700_get_menu_by_location( $location ) {
	if( empty($location) ) return false;

	$locations = get_nav_menu_locations();
	if( ! isset( $locations[$location] ) ) return false;

	$menu_obj = get_term( $locations[$location], 'nav_menu' );

	return $menu_obj;
}


	function east_social_share($post_id) {
		?>
		<div class="sosmed">
			<a href="#" onclick="popUp=window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink($post_id);?>', 'popupwindow', 'scrollbars=yes,height=300,width=550');popUp.focus();return false" rel="nofollow" title="Share this" class="btn facebook"><i class="fab fa-facebook-f"></i> <span>Facebook</span></a>
			<a href="#" onclick="popUp=window.open('http://twitter.com/share?url=<?php echo get_the_permalink($post_id);?>', 'popupwindow', 'scrollbars=yes,height=300,width=550');popUp.focus();return false" rel="nofollow" title="Share this" class="btn twitter"><i class="fab fa-twitter"></i> <span>Twitter</span></a>
			<a href="#" onclick="popUp=window.open('https://api.whatsapp.com/send?text=<?php echo get_the_title($post_id).' '.get_the_permalink($post_id); ?>', 'popupwindow', 'scrollbars=yes,height=300,width=550');popUp.focus();return false" rel="nofollow" title="Share this" class="btn whatsapp"><i class="fab fa-whatsapp"></i> <span>Whatsapp</span></a>
		</div>
		<?php
	}

	function east_az(){
	$azslug = get_option('azpage'); if($azslug){
	echo '<div class="letter_home">';
	echo '<span class="ftaz">'.__d('A-Z LIST').'</span>';
	echo '<span class="size-s">'.__d('Searching anime order by alphabet name A to Z.').'</span>';
	    echo '<ul class="lttr_azhome">';
	      echo '<li><a href="'.esc_url( home_url() ).''.$azslug.'?letter=0-9">0-9</a></li>';
	      foreach(range('a', 'z') as $letter) {
	      echo '<li><a href="'.esc_url( home_url() ).''.$azslug.'?letter='.strtoupper($letter).'">'.strtoupper($letter).'</a></li>';
	    }
	  echo '</ul>';
	echo '</div>'; }
	}

function east_trailer($post_id){
		 $trailer = get_post_meta($post_id,'east_trailer', true);
		 if($trailer) {
			$out = '<div class="trailer-anime">';
		 $out .= '<div id="embed_holder">';
		 $out .= '<div class="player-embed" id="pembed">';
		 $out .= '<iframe src="https://www.youtube.com/embed/'.$trailer.'">" frameborder="0" marginwidth="0" marginheight="0" scrolling="NO" width="100%" height="100%" allowfullscreen="true"></iframe>';
		 $out .= '</div>';
		 $out .= '</div>';
		 $out .= '</div>';
echo $out;
	 }
}

function east_account_bar(){
	$member = get_option('membersystem');
	$accountpage = get_option('accountpage');
	if($member == 1) { if (is_user_logged_in()) {
	$current_user = wp_get_current_user();
					?>
					<div class="accont">
					   <div class="image"><a href="<?php echo get_bloginfo('url').$accountpage; ?>"><?php echo get_avatar( $current_user->ID, 80 ); ?></a></div>
					   <a href="javascript:void(0)" class="logout" id="east_logout"><span class="fas fa-sign-out-alt"></span></a>
					</div>
					<?php } else { ?>
					<div class="accont">
					   <a href="<?php bloginfo('url'); ?>/login" class="showlogin" id="east_logout"><span class="fa fa-user"></span></a>
					</div>
 <?php } }
}

function east_social_account(){
	$fb = get_option('fburl');
	$tw = get_option('twiturl');
	$ig = get_option('igurl');
	$yt = get_option('yturl');

	echo "<div class='footer-social'>";
	if($fb){
		echo "<div class='socaccount'><a href='{$fb}'><i class='fab fa-facebook-f'></i></a></div>";
	}
	if($tw){
		echo "<div class='socaccount'><a href='{$tw}'><i class='fab fa-twitter'></i></a></div>";
	}
	if($ig){
		echo "<div class='socaccount'><a href='{$ig}'><i class='fab fa-instagram'></i></a></div>";
	}
	if($yt){
		echo "<div class='socaccount'><a href='{$yt}'><i class='fab fa-youtube'></i></a></div>";
	}
	echo "</div>";

}

function east_alert_genre($post_id){
	if( has_term( 'Ecchi', 'genre', $post_id ) ) {
		$title =  get_the_title($post_id);
		echo '<div class="alr">'.sprintf(__d('Warning, the series is titled "%s" there may be violent, bloody or sexual content that is not appropriate for underage audiences.'), $title).'</div>';
		 }
}

function east_core_posts() {
	?>
	<style>
		.dashicons-admin-post:before,
		.dashicons-format-standard:before{content: "\f522";}
	</style>
	<?php
}

function east_breadcrumbs_episode($post_id) {

	$seri = get_post_meta($post_id, 'east_series', true);

	$out = '<div id="breadcrumbs" class="widget_senction">';
	$out .= '<ol itemscope itemtype="http://schema.org/BreadcrumbList">';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_bloginfo('url') . '">';
	$out .= '<span itemprop="name">Home</span></a>';
	$out .= '<meta itemprop="position" content="1" />';
	$out .= '</li>';
	$out .= '<i class="fa fa-chevron-right"></i>';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_bloginfo('url') . '/anime">';
	$out .= '<span itemprop="name">Anime</span></a>';
	$out .= '<meta itemprop="position" content="2" />';
	$out .= '</li>';
	$out .= '<i class="fa fa-chevron-right"></i>';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_the_permalink($seri) . '">';
	$out .= '<span itemprop="name">' . get_the_title($seri) . '</span></a>';
	$out .= '<meta itemprop="position" content="3" />';
	$out .= '</li>';
	$out .= '<i class="fa fa-chevron-right"></i>';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_the_permalink() . '">';
	$out .= '<span itemprop="name">' . get_the_title() . '</span></a>';
	$out .= '<meta itemprop="position" content="4" />';
	$out .= '</li>';
	$out .= '</ol>';
	$out .= '</div>';

	echo $out;

}

function east_breadcrumbs_blog($post_id) {
		$bread = get_option('breadcrumbs');if ($bread) {
	$out = '<div id="breadcrumbs" class="widget_senction">';
	$out .= '<ol itemscope itemtype="http://schema.org/BreadcrumbList">';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_bloginfo('url') . '">';
	$out .= '<span itemprop="name">Home</span></a>';
	$out .= '<meta itemprop="position" content="1" />';
	$out .= '</li>';
	$out .= '<i class="fa fa-chevron-right"></i>';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_bloginfo('url') . '/blog">';
	$out .= '<span itemprop="name">Blog</span></a>';
	$out .= '<meta itemprop="position" content="2" />';
	$out .= '</li>';
	$out .= '<i class="fa fa-chevron-right"></i>';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_the_permalink() . '">';
	$out .= '<span itemprop="name">' . get_the_title() . '</span></a>';
	$out .= '<meta itemprop="position" content="3" />';
	$out .= '</li>';
	$out .= '</ol>';
	$out .= '</div>';

	echo $out;
}
}

function east_breadcrumbs_anime($post_id) {
	$bread = get_option('breadcrumbs');if ($bread) {
	$out = '<div id="breadcrumbs" class="widget_senction">';
	$out .= '<ol itemscope itemtype="http://schema.org/BreadcrumbList">';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_bloginfo('url') . '">';
	$out .= '<span itemprop="name">Home</span></a>';
	$out .= '<meta itemprop="position" content="1" />';
	$out .= '</li>';
	$out .= '<i class="fa fa-chevron-right"></i>';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_bloginfo('url') . '/anime">';
	$out .= '<span itemprop="name">Anime</span></a>';
	$out .= '<meta itemprop="position" content="2" />';
	$out .= '</li>';
	$out .= '<i class="fa fa-chevron-right"></i>';
	$out .= '<li itemprop="itemListElement" itemscope ';
	$out .= 'itemtype="https://schema.org/ListItem">';
	$out .= '<a itemtype="https://schema.org/Thing" ';
	$out .= 'itemprop="item" href="' . get_the_permalink() . '">';
	$out .= '<span itemprop="name">' . get_the_title() . '</span></a>';
	$out .= '<meta itemprop="position" content="3" />';
	$out .= '</li>';
	$out .= '</ol>';
	$out .= '</div>';
	echo $out;
}
}

function get_ads($ads, $class = ''){
	$ads = get_option($ads);
	if($ads){
		echo '<div class="ads_area '.$class.'">';
		echo $ads;
		echo '</div>';
	}
}

function ads_float(){
$floatleft = get_option('adsfloatleft');
$floatright = get_option('adsfloatright');
$floatcenter = get_option('adsfloatcenter');
if($floatleft) {
	?>
	<div id="floatleft" class="adsfloat left">
	   <div align="center"><a href="javascript:void()" id="close-ads" onclick="document.getElementById('floatleft').style.display = 'none';" style="cursor:pointer;">Close</a></div>
	   <?php echo $floatleft; ?>
	</div>
	<?php
}if($floatright){
	?>
	<div id="floatright" class="adsfloat right">
		 <div align="center"><a href="javascript:void()" id="close-ads" onclick="document.getElementById('floatright').style.display = 'none';" style="cursor:pointer;">Close</a></div>
		 <?php echo $floatright; ?>
	</div>
	<?php
}
if($floatcenter){
	?>
	<div id="floatcenter">
	<div class="ads" align="center"><a href="javascript:void()" id="close-adscenter" onclick="document.getElementById('floatcenter').style.display = 'none';" style="cursor:pointer;"><i class="fa fa-times"></i></a>
	<?php echo $floatcenter; ?>
	</div>
	</div>
	<?php
}
}

function east_tooltip($post_id){

$tooltip = get_option('easttooltip');

if($tooltip == 1) {

$view = wpb_get_post_views(get_the_ID());
$title = get_the_title($post_id);
$status = get_post_meta( get_the_ID(), 'east_status', true );
$type = get_post_meta( get_the_ID(), 'east_type', true );
$rating = get_post_meta( get_the_ID(), 'east_score', true );
$genre = term_sep(get_the_ID(),'genre');
$excerpt = excerpt(20);

$out =	"<div class='stooltip'>";
$out .=	"<div class='title'>";
$out .=	"<h4>{$title}</h4>";
$out .=	"</div>";
$out .=	"<div class='metadata'><span class='skor'><i class='fa fa-star'></i> {$rating}</span> <span>{$type}</span><span>{$view}</span></div>";
$out .=	"<div class='ttls'>{$excerpt}</div>";
$out .=  "<div class='genres'>";
$out .=	"<div class='mta'>{$genre}</div>";
$out .=	"</div>";
$out .=	"</div>";

return $out;

}

}

function east_form_login(){

	$member = get_option('membersystem');
	$accountpage = get_option('accountpage');

	  if($member == 1) { ?>
	 <form id="east_login_user" class="ajax-auth lgsg_form" action="login" method="post">
	      <h1><?php _d('Login'); ?></h1>
					        <div id="lgsgrespon"></div>
	      <fieldset>
	    		<input type="text" name="username" placeholder="Username" id="user_login" value="<?php echo isset($_POST['username']) ? $_POST['username'] : false; ?>" required/>
	    	</fieldset>
	    	<fieldset>
	    		<input type="password" name="password" placeholder="Password" id="user_pass" value="<?php echo isset($_POST['password']) ? $_POST['password'] : false; ?>" required/>
	    	</fieldset>
	    	<fieldset class="remembr">
	    		<label for="rememberme"><input name="rmb" type="checkbox" id="rememberme" value="forever" checked="checked" /> <?php _d('Remember Me'); ?></label>
	    	</fieldset>
	    	<fieldset class="last">
	    		<input type="submit" id="east_login_btn" data-btntext="<?php _d('Log in'); ?>" class="submit button" value="<?php _d('Log in'); ?>" />
	    		<span><?php _d("Don't you have an account yet?"); ?> <a href="<?php echo get_bloginfo('url').$accountpage; ?>?action=sign-up"><?php _d("Sign up here"); ?> </a></span>
	    		<span><a href="<?php echo get_bloginfo('url').$accountpage; ?>?action=lostpassword" target="_blank"><?php _d("I forgot my password"); ?></a></span>
	    	</fieldset>
	      <input type="hidden" name="action" value="east_login">
	      <a class="close" href=""><i class="fa fa-times" aria-hidden="true"></i></a>
	    </form>
	<?php }
}

function _d($text) {
	echo translate($text, 'esthm');
}

function __d($text) {
	return translate($text, 'esthm');
}

function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

function content($limit) {
	$content = explode(' ', get_the_content(), $limit);
	if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
	} else {
		$content = implode(" ",$content);
	}
	$content = preg_replace('/\[.+\]/','', $content);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}

add_filter('wp_title', 'filter_wp_title');

function filter_wp_title($title) {
	global $page, $paged;

	if (is_feed()) {
		return $title;
	}

	$site_description = get_bloginfo('description');

	$filtered_title = $title . get_bloginfo('name');
	$filtered_title .= (!empty($site_description) && (is_home() || is_front_page())) ? ' – ' . $site_description : '';
	$filtered_title .= (2 <= $paged || 2 <= $page) ? ' – ' . sprintf(__('Page %s'), max($paged, $page)) : '';

	return $filtered_title;
}

if (!function_exists('meks_disable_srcset')) {
	function meks_disable_srcset($sources) {
		return false;
	}
}

add_filter('wp_calculate_image_srcset', 'meks_disable_srcset');

function sidebar_eastplay() {
    register_sidebar(array(
        'name' => 'Sidebar Home',
        'id' => 'sidebar-home',
        'before_widget' => '<div class="widgets">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => 'Sidebar Episode',
        'id' => 'sidebar-episode',
        'before_widget' => '<div class="widgets">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => 'Sidebar Anime',
        'id' => 'sidebar-anime',
        'before_widget' => '<div class="widgets">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => 'Sidebar Archive',
        'id' => 'sidebar-archive',
        'before_widget' => '<div class="widgets">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => 'Sidebar Blog',
        'id' => 'sidebar-blog',
        'before_widget' => '<div class="widgets">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
     'name' => 'Main Top',
     'id' => 'main-top',
     'before_widget' => '<div class="widget_senction">',
     'after_widget' => '</div>',
     'before_title' => '<div class="widget-title widgtl"><h3>',
     'after_title' => '</h3></div>'
     ));
		 register_sidebar(array(
				 'name' => 'Main Center',
				 'id' => 'main-center',
				 'before_widget' => '<div class="widget_senction">',
		     'after_widget' => '</div>',
				 'before_title' => '<div class="widget-title"><h3>',
				 'after_title' => '</h3></div>'     ));
     register_sidebar(array(
         'name' => 'Main Bottom',
         'id' => 'main-bottom',
				 'before_widget' => '<div class="widget_senction">',
		     'after_widget' => '</div>',
         'before_title' => '<div class="widget-title"><h3>',
         'after_title' => '</h3></div>'     ));
}
add_action('widgets_init', 'sidebar_eastplay');

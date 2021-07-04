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

$themecolor = get_option('themecolor');
$logo = get_option('logoaccount');
$home = esc_url(home_url());
$bnme = get_option('blogname');

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php wp_title('-', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() .'/assets/css/style.css'; ?>">
			<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() .'/assets/css/dark.css'; ?>">
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js?ver=2.2.0'></script>
	<?php if(get_option('sitekey') && get_option('secretkey')){ echo "<script src='https://www.google.com/recaptcha/api.js'></script>"; } ?>
<style>
    a{color: <?php echo $themecolor; ?>}
    .lgsg_form fieldset input[type="submit"]{background:<?php echo $themecolor; ?>}
		.lgsg_form fieldset input[type="text"]:focus, .lgsg_form fieldset input[type="password"]:focus{border-color: <?php echo $themecolor; ?>}
		.lgsg_form fieldset input[type="submit"]:hover{background: <?php echo $hovercolor; ?>}
		a:hover{color: <?php echo $hovercolor; ?>}
</style>
</head>
	<script>
	var defaultTheme = '<?php echo get_option('colorscheme'); ?>';
	$(document).ready(function() {
	if (localStorage.getItem("theme-mode") == null){
		 if (defaultTheme == "darkmode"){
							jQuery(".logo_sign img").attr('src', '<?php echo get_option('logodark'); ?>');
			 $('.switchmode input').prop('checked', true);
			 jQuery("body").addClass("darkmode");
		 }else{
				jQuery(".logo_sign img").attr('src', '<?php echo get_option('logoaccount'); ?>');
			 jQuery("body").removeClass("darkmode");
		 }
	 }else if (localStorage.getItem("theme-mode") == "darkmode"){
			jQuery(".logo_sign img").attr('src', '<?php echo get_option('logodark'); ?>');
		 jQuery("body").addClass("darkmode");
		 $('.switchmode input').prop('checked', true);
	 }else{
					jQuery(".logo_sign img").attr('src', '<?php echo get_option('logoaccount'); ?>');
		 jQuery("body").removeClass("darkmode");
	 }
 });
	 </script>
<div class="container-sign">
	<div class="east_box <?php if( isset($_GET['action']) && $_GET['action'] == 'log-in') echo "login"; ?>">
	<div class="logo_sign">
		<?php echo ($logo) ? "<a href='{$home}'><img src='{$logo}'></a>" : "<h1>{$bnme}</h1>"; ?>
	</div>

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

get_template_part('template/page/page_header'); ?>
<div class="lgsg_form">
	<header>
		<h1><?php _d('Lost your password?'); ?></h1>
	</header>
  <form id="east_lost_password" method="post">
		<div id="lgsgrespon"></div>
  	<fieldset>
  		<input type="text" name="useremail" placeholder="Username or Email Address" id="user_login" value="<?php echo isset($_POST['useremail']) ? $_POST['useremail'] : false; ?>" required/>
  	</fieldset>
  	<fieldset>
  		<input type="submit" id="east_lostpassword_btn" data-btntext="<?php _d('Log in'); ?>" class="submit button" value="<?php _d('Get new password'); ?>" />
		<span><?php _d('Do you already have an account?'); ?> <a href="<?php the_permalink(); ?>?action=log-in"><?php _d('Login here'); ?></a></span>
  	</fieldset>
      <input type="hidden" name="action" value="east_lostpassword">
  </form>
</div>
<?php
get_template_part('template/page/page_footer'); ?>

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
		<h1><?php _d('Login'); ?></h1>
	</header>
  <form id="east_login_user" method="post">
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
  	<fieldset>
  		<input type="submit" id="east_login_btn" data-btntext="<?php _d('Log in'); ?>" class="submit button" value="<?php _d('Log in'); ?>" />
  		<span><?php _d("Don't you have an account yet?"); ?> <a href="<?php the_permalink(); ?>?action=sign-up"><?php _d("Sign up here"); ?> </a></span>
  		<span><a href="<?php the_permalink(); ?>?action=lostpassword" target="_blank"><?php _d("I forgot my password"); ?></a></span>
  	</fieldset>
      <input type="hidden" name="action" value="east_login">
  	<input type="hidden" name="red" value="<?php the_permalink(); ?>">
  </form>
</div>
<?php
get_template_part('template/page/page_footer'); ?>

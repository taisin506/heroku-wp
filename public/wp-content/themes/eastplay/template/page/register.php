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
    <h1><?php  _d("Sign up"); ?></h1>
  </header>
  <?php do_action ('east_register_form'); ?>
  <?php if( isset($_GET['form']) && $_GET['form'] == 'send') {  } else {
?>
<form method="POST" id="east_sign_up" class="register_form">
	  <div id="lgsgrespon"></div>
	<fieldset class="min fix">
		<input type="text" id="firstname" placeholder="First name" name="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : false; ?>" required />
	</fieldset>
	<fieldset class="min">
		<input type="text" id="lastname" placeholder="Last name" name="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : false; ?>" required />
	</fieldset>
	<fieldset>
		<input type="text" id="username" placeholder="Username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : false; ?>" required />
	</fieldset>
	<fieldset>
		<input type="text" id="email" placeholder="E-mail address" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : false; ?>" required />
	</fieldset>
	<fieldset>
		<input type="password" id="spassword" placeholder="Password" name="spassword" required />
	</fieldset>
	<?php if(get_option('sitekey') && get_option('secretkey')){ ?>
	<fieldset>
		<div class="g-recaptcha" data-sitekey="<?php echo get_option('sitekey'); ?>"></div>
	</fieldset>
	<?php } ?>
	<fieldset>
		<input name="adduser" type="submit" id="east_signup_btn" class="submit button" data-btntext="<?php _d('Sign up'); ?>" value="<?php _d('Sign up'); ?>" />
		<span><?php _d('Do you already have an account?'); ?> <a href="<?php the_permalink(); ?>?action=log-in"><?php _d('Login here'); ?></a></span>
	</fieldset>
	<input name="action" type="hidden" id="action" value="east_register"/>
</form>
<?php
  } ?>
</div>
<?php  get_template_part('template/page/page_footer'); ?>

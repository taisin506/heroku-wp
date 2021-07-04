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

get_header();
global $current_user, $wp_roles, $wpdb;
wp_get_current_user();
$user_id	= get_current_user_id();
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name	= get_user_meta($user_id, 'last_name', true);
$list		= get_user_meta($user_id, $wpdb->prefix .'favorites_count', true);
$view		= get_user_meta($user_id, $wpdb->prefix .'user_watchl_count', true);
$display_name = $current_user->display_name;
$tab = '';
if (isset($_GET['tab'])) { $tab = $_GET['tab']; }
?>

<div id="content" class="content-separate">
   <div id="primary" class="content-area">
      <main id="main" class="site-main post-body widget_senction" role="main">
         <div class="relat">
					 <div id="favorites">
		 <?php    echo '<h3 class="txacc">'.__d('Favorites').'</h3>';
                  EastPlay::east_favorites_content($user_id, array('anime'), '18', '_east_favorites', 'favorites'); ?>
					</div>
					<div id="watch" class="tab_box">
		<?php    echo '<h3 class="txacc">'.__d('Watch Later').'</h3>';
							EastPlay::east_favorites_content($user_id, array('post'), '18', '_east_watchl', 'views');  ?>
				 </div>
				 <div id="account" class="tab_box">
					 <div id="update_notice"></div>
			<?php echo '<h3 class="txacc">'.__d('Account Settings').'</h3>'; ?>
						<form id="update_user_page" class="update_profile">
							 <div id="general">
									<fieldset class="form-email">
										 <label for="email"><?php _d('E-mail'); ?></label>
										 <input type="text" id="email" name="email" value="<?php the_author_meta('user_email', $current_user->ID ); ?>" disabled />
									</fieldset>
									<fieldset class="from-first-name min fix">
										 <label for="first-name"><?php _d('First name'); ?></label>
										 <input type="text" id="first-name" name="first-name" value="<?php the_author_meta('first_name', $current_user->ID ); ?>" />
									</fieldset>
									<fieldset class="form-last-name min">
										 <label for="last-name"><?php _d('Last name'); ?></label>
										 <input type="text" id="last-name" name="last-name" value="<?php the_author_meta('last_name', $current_user->ID ); ?>" />
									</fieldset>
			</div>
							 <div id="password">
									<fieldset class="form-pass1 min fix">
										 <label for="pass1"><?php _d('New password *'); ?></label>
										 <input type="password" id="pass1" name="pass1" />
									</fieldset>
									<fieldset class="form-pass2 min">
										 <label for="pass2"><?php _d('Repeat password *'); ?></label>
										 <input type="password" id="pass2" name="pass2" />
									</fieldset>
							 </div>
							 <fieldset class="form-submit">
									<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _d('Update account'); ?>" />
									<?php wp_nonce_field('update-user','update-user-nonce')?>
							 </fieldset>
						</form>
					</div>
         </div>
      </main>
   </div>
	 <div id="sidebar">
			<div class="senc">
				 <div class="side-account">
					 <ul class="idTabs amenu">
					 <li class=""><a href="#favorites">Favorites</a></li>
					 <li><a href="#watch">Watch Later</a></li>
					 <li><a href="#account">Account Settings</a></li>
					 </ul>
				 </div>
			</div>
	 </div>
</div>

<script type='text/javascript'>
	 jQuery(document).ready(function($) {
		 $('#update_user_page').submit(function(){
			 $('#message').html('<div class="sms"><div class="updating"><i class="icons-spinner9 loading"></i> '+ easthemeajax.updating + '</div></div>');
			 $.ajax({
				 type:'POST',
				 url:easthemeajax.url + '?action=east_update_user',
				 data:$(this).serialize()
			 })
			 .done(function(data){
				 $('#update_notice').html('<div class="txes">' + data + '</div>');
			 });
			 return false;
		 });
		 $('#description').bind('change', function(){
			 $('#puser').text($(this).val());
		 });
		 $('#display_name').bind('change', function(){
			 $('#h2user').text($(this).val());
		 });
	 });
</script>

<?php get_footer(); ?>

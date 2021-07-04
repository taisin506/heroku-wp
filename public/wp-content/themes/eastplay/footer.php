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

$customads = get_option('cadsfooter');
$logo = get_option('logofooter');
if($logo){
	$logofooter = "<div class='logofooter'><img src='{$logo}'/></div>";
}else{
	$logofooter = '';
}

?>
</div>
</div>
<div id="footer">
	<div id="foot_nav">
		 <div class="footer-widget">
				<?php $location = 'footer';
					 if ( has_nav_menu( $location ) ) {
						$menu_obj = wpse45700_get_menu_by_location($location );
						wp_nav_menu( array('theme_location' => $location, 'items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>') ); } ?>
		 </div>
	</div>
   <div class="container footer">
		 <div class="footer-top">
		 <div class="footer-one">
      <?php echo east_az(); ?>
      <div class="footer-last">
				<?php echo $logofooter; ?>
         <div class="footer-desc">
            <p><?php echo get_option('textfooter'); ?></p>
         </div>
      </div>
      <?php east_social_account(); ?>
   </div>
</div>
<a href="#" class="scrollToTop"><span class="fa fa-caret-up"></span></a>
<?php
if($customads){echo $customads;}
ads_float();
wp_footer(); ?>
</body>
</html>

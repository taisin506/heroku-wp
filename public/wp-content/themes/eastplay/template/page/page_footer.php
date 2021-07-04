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

$json = array(
    'url'     => admin_url('admin-ajax.php', 'relative'),
    'wait'    => __d('please wait...'),
	'getpassword' => __d('Get new password'),
	'succes' => __d('Succes'),
    'error'   => __d('Unknown error'),
    'loading' => __d('Loading...')
);

$json = json_encode( $json );

?>

<div class="text_ft"><?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?></div>
	</div>
</div>
<script type='text/javascript'>
    var Auth = <?php echo $json; ?>;
</script>
<script type='text/javascript' src='<?php echo EAST_URI; ?>/assets/js/ajax.auth.js'></script>
</body>
</html>

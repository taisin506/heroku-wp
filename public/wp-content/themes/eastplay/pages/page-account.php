<?php
/*
   Template Name: EasTheme - Account
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
 exit;
}

if(is_user_logged_in()){
   get_template_part('template/page/account');
} else {
if(isset($_GET['action']) and $_GET['action'] =='sign-up') {
   get_template_part('template/page/register');
}elseif(isset($_GET['action']) and $_GET['action'] =='lostpassword'){
   get_template_part('template/page/lostpassword');
}else{
   get_template_part('template/page/login');
}

}

?>

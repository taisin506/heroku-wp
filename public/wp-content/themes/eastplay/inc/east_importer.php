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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'east_ocdi_import_files' ) ) :
	/**
	 * Set one click import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.1
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 *
	 * @return array
	 */
	function east_ocdi_import_files() {
		return array(
			array(
				'import_file_name'             	=> 'EastPlay Demo Import',
				'local_import_file'            	=> trailingslashit( get_template_directory() ) . 'inc/demo-data/demo-content.xml',
				'local_import_widget_file'     	=> trailingslashit( get_template_directory() ) . 'inc/demo-data/widget_data.json',
				'local_import_customizer_file' 	=> trailingslashit( get_template_directory() ) . 'inc/demo-data/customizer.dat',
				'import_notice'              => __( 'Import demo from http://demo.eastheme.com/eastplay .', 'eastheme' ),
			)
		);
	}
endif;
add_filter( 'pt-ocdi/import_files', 'east_ocdi_import_files' );

if ( ! function_exists( 'east_ocdi_after_import' ) ) :
	/**
	 * Set action after import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.1
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 *
	 * @return void
	 */
	function east_ocdi_after_import( $selected_import ) {

		// Menus to Import and assign - you can remove or add as many as you want
		$top_menu = get_term_by('name', 'Top menus', 'nav_menu');
		$second_menu = get_term_by('name', 'Second menus', 'nav_menu');

		set_theme_mod ( 'nav_menu_locations', array(
			'primary' => $top_menu->term_id,
			'secondary' => $second_menu->term_id,
		)
	);

		// update option post per page
		update_option( 'posts_per_page', 15 );

	}
endif;
add_action( 'pt-ocdi/after_import', 'east_ocdi_after_import' );

// disable generation of smaller images (thumbnails) during the content import
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

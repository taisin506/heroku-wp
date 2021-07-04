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

function anime() {

  $labels = array(
    'name'                => _x( 'Anime', 'Post Type General Name', 'text_domain' ),
    'singular_name'       => _x( 'Anime', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'           => __( 'Anime Series', 'text_domain' ),
    'name_admin_bar'      => __( 'Anime', 'text_domain' ),
    'parent_item_colon'   => __( 'Parent Anime :', 'text_domain' ),
    'all_items'           => __( 'All Anime', 'text_domain' ),
    'add_new_item'        => __( 'Add New Anime', 'text_domain' ),
    'add_new'             => __( 'Add New', 'text_domain' ),
    'new_item'            => __( 'New Anime', 'text_domain' ),
    'edit_item'           => __( 'Edit Anime', 'text_domain' ),
    'update_item'         => __( 'Update Anime', 'text_domain' ),
    'view_item'           => __( 'View Anime', 'text_domain' ),
    'search_items'        => __( 'Search Anime', 'text_domain' ),
    'not_found'           => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
    'label'               => __( 'Anime', 'text_domain' ),
    'description'         => __( 'Anime', 'text_domain' ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', ),
    'taxonomies'          => array( 'category' , 'post_tag'),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 6,
    'menu_icon'           => 'dashicons-list-view',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
  );
  register_post_type( 'anime', $args );

}

add_action( 'init', 'anime', 0 );

function blog() {

  $labels = array(
    'name'                => _x( 'Blog', 'Post Type General Name', 'text_domain' ),
    'singular_name'       => _x( 'Blog', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'           => __( 'Blog', 'text_domain' ),
    'name_admin_bar'      => __( 'Blog', 'text_domain' ),
    'parent_item_colon'   => __( 'Parent Blog :', 'text_domain' ),
    'all_items'           => __( 'All Blog', 'text_domain' ),
    'add_new_item'        => __( 'Add New Blog', 'text_domain' ),
    'add_new'             => __( 'Add New', 'text_domain' ),
    'new_item'            => __( 'New Blog', 'text_domain' ),
    'edit_item'           => __( 'Edit Blog', 'text_domain' ),
    'update_item'         => __( 'Update Blog', 'text_domain' ),
    'view_item'           => __( 'View Blog', 'text_domain' ),
    'search_items'        => __( 'Search Blog', 'text_domain' ),
    'not_found'           => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
    'label'               => __( 'Blog', 'text_domain' ),
    'description'         => __( 'Blog', 'text_domain' ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', ),
    'taxonomies'          => array(  'post_tag'),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 6,
    'menu_icon'           => 'dashicons-welcome-write-blog',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
  );
  register_post_type( 'blog', $args );

}

add_action( 'init', 'blog', 0 );

function blog_category() {
	$labels = array(
		'name'              => _x( 'Blog Category', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Blog Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Blog Category', 'textdomain' ),
		'all_items'         => __( 'All Blog Category', 'textdomain' ),
		'parent_item'       => __( 'Parent Blog Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Blog Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit Blog Category', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate Blog Category with commas', 'textdomain' ),
		'update_item'       => __( 'Update Blog Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New Blog Category', 'textdomain' ),
		'new_item_name'     => __( 'New Blog Category Name', 'textdomain' ),
		'menu_name'         => __( 'Blog Category', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'blog-category' ),
	);

	register_taxonomy( 'blog-category', array( 'blog' ), $args );
}

add_action('init', 'blog_category', 0 );

function eastgenres() {
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Genres', 'textdomain' ),
		'all_items'         => __( 'All Genres', 'textdomain' ),
		'parent_item'       => __( 'Parent Genre', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
		'edit_item'         => __( 'Edit Genre', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate Genre with commas', 'textdomain' ),
		'update_item'       => __( 'Update Genre', 'textdomain' ),
		'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
		'new_item_name'     => __( 'New Genre Name', 'textdomain' ),
		'menu_name'         => __( 'Genre', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);

	register_taxonomy( 'genre', array( 'anime' ), $args );
}

add_action('init', 'eastgenres', 0 );

function eastseason() {
	$labels = array(
		'name'                       => _x( 'Season', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Season', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Search Season', 'textdomain' ),
		'popular_items'              => __( 'Popular Season', 'textdomain' ),
		'all_items'                  => __( 'All Season', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Season', 'textdomain' ),
		'update_item'                => __( 'Update Season', 'textdomain' ),
		'add_new_item'               => __( 'Add New Season', 'textdomain' ),
		'new_item_name'              => __( 'New Season Name', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate Season with commas', 'textdomain' ),
		'add_or_remove_items'        => __( 'Add or remove Season', 'textdomain' ),
		'choose_from_most_used'      => __( 'Choose from the most used Season', 'textdomain' ),
		'not_found'                  => __( 'No Season found.', 'textdomain' ),
		'menu_name'                  => __( 'Season', 'textdomain' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'season' ),
	);

	register_taxonomy( 'season', 'anime', $args );
}
add_action( 'init', 'eastseason', 0 );

function eaststudio() {


	$labels = array(
		'name'                       => _x( 'Studio', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Studio', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Studio', 'text_domain' ),
		'all_items'                  => __( 'All Studio', 'text_domain' ),
		'parent_item'                => __( 'Parent Studio', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Studio:', 'text_domain' ),
		'new_item_name'              => __( 'New Studio Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Studio', 'text_domain' ),
		'edit_item'                  => __( 'Edit Studio', 'text_domain' ),
		'update_item'                => __( 'Update Studio', 'text_domain' ),
		'view_item'                  => __( 'View Studio', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate studio with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove studio', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Studio', 'text_domain' ),
		'search_items'               => __( 'Search Studio', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'studio', array( 'anime' ), $args );

}
add_action( 'init', 'eaststudio', 0 );

function eastproducers() {

	$labels = array(
		'name'                       => _x( 'Producers', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Producers', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Producers', 'text_domain' ),
		'all_items'                  => __( 'All Producers', 'text_domain' ),
		'parent_item'                => __( 'Parent Producers', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Producers:', 'text_domain' ),
		'new_item_name'              => __( 'New Producers Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Producers', 'text_domain' ),
		'edit_item'                  => __( 'Edit Producers', 'text_domain' ),
		'update_item'                => __( 'Update Producers', 'text_domain' ),
		'view_item'                  => __( 'View Producers', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate studio with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove studio', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Producers', 'text_domain' ),
		'search_items'               => __( 'Search Producers', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'producers', array( 'anime' ), $args );

}
add_action( 'init', 'eastproducers', 0 );

if (!function_exists('post_type_post')) {
	function post_type_post() {
		global $wp_post_types;
		$labels = &$wp_post_types['post']->labels;
		$labels->name = 'Episode';
		$labels->singular_name = 'Episode';
		$labels->add_new = 'Add Episode';
		$labels->add_new_item = 'Add Episode';
		$labels->edit_item = 'Edit Episode';
		$labels->new_item = 'Episode';
		$labels->view_item = 'View Episode';
		$labels->search_items = 'Search Episode';
		$labels->not_found = 'No Episode found';
		$labels->menu_icon = 'dashicons-controls-play';
		$labels->not_found_in_trash = 'No Episode found in Trash';
		$labels->all_items = 'All Episode';
		$labels->menu_name = 'Episode';
		$labels->name_admin_bar = 'Episode';
	}
}

function category_to_anime_category() {
		global $wp_taxonomies;

		$cat                            = $wp_taxonomies['category'];
		$cat->label                     = __( 'Anime Category', 'eastheme-core' );
		$cat->labels->singular_name     = __( 'Anime Category', 'eastheme-core' );
		$cat->labels->name              = $cat->label;
		$cat->labels->menu_name         = $cat->label;
		$cat->labels->search_items      = __( 'Search', 'eastheme-core' ) . ' ' . $cat->label;
		$cat->labels->popular_items     = __( 'Popular', 'eastheme-core' ) . ' ' . $cat->label;
		$cat->labels->all_items         = __( 'All', 'eastheme-core' ) . ' ' . $cat->label;
		$cat->labels->parent_item       = __( 'Parent', 'eastheme-core' ) . ' ' . $cat->labels->singular_name;
		$cat->labels->parent_item_colon = __( 'Parent', 'eastheme-core' ) . ' ' . $cat->labels->singular_name . ':';
		$cat->labels->edit_item         = __( 'Edit', 'eastheme-core' ) . ' ' . $cat->labels->singular_name;
		$cat->labels->update_item       = __( 'Update', 'eastheme-core' ) . ' ' . $cat->labels->singular_name;
		$cat->labels->add_new_item      = __( 'Add new', 'eastheme-core' ) . ' ' . $cat->labels->singular_name;
		$cat->labels->new_item_name     = __( 'New', 'eastheme-core' ) . ' ' . $cat->labels->singular_name;

	}

add_action( 'init', 'category_to_anime_category' );


?>

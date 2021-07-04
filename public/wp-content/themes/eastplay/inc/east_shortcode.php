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

function tax_list($atts){
	extract(shortcode_atts(array(
    'tax' => 'season',
  ) , $atts));

	$taxonomy = $tax;
	$tax_terms = get_terms(array('taxonomy' =>$taxonomy));

	$out  = "<div class='relat'>";

	$out .= "<ul class='taxlists'>";
	foreach ($tax_terms as $tax_term) {

		if ( in_array( $tax_term->slug, array('none-found') ) ) {
				 continue;
		 }

  $alt = sprintf( __d( "View all series in %s %s" ), $tax, $tax_term->name );
	$termname = $tax_term->name;
	$permalink = esc_attr(get_term_link($tax_term, $taxonomy));
	$taxcount = $tax_term->count;

  $out .= "<li>";
	$out .= "<a href='{$permalink}' title='{$alt}'><span class='taxtil'>{$termname}</span><span class='count'>{$taxcount}</span></a></li>";
	$out .= "</li>";
	}

	$out .= "</ul>";

	$out .= "</div>";

	return $out;

}
add_shortcode('tax_list', 'tax_list');

function anime_status($atts)
{
  extract(shortcode_atts(array(
    'count' => '10',
    'status' => 'Currently Airing',
  ) , $atts));

  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $wp_query = new WP_Query( array(
    'posts_per_page' => $count,
    'post_type' => 'anime',
    'orderby' => 'date',
    'ignore_sticky_posts' => 1,
    'meta_key' => 'east_status',
    'meta_value' => $status,
    'paged' => $paged,
  ));

	$out  = "<div class='relat'>";

	while ($wp_query->have_posts()) : $wp_query->the_post();

	$post_id = get_the_ID();
	$post_class = join( '  ', get_post_class('animpost') );
	$type = meta($post_id, 'east_type');
	$status = status_anime($post_id);
	$score = meta($post_id, 'east_score');
	$thumbnail = the_thumbnail($post_id, '150','210' );
	$permalink = get_the_permalink($post_id);
	$title = get_the_title($post_id);

  $out   .= "<article id='post-{$post_id}' class='{$post_class}' itemscope='itemscope' itemtype='http://schema.org/CreativeWork'>";
	$out .= "<div class='animepost'>";
	$out .= "<div class='animposx'>";
	$out .= "<a rel='{$post_id}' href='{$permalink}' title='$title' alt='$title'>";
	$out .= "<div class='content-thumb'>";
	$out .= "<div class='ply'>";
	$out .= "<i class='fa fa-play'></i>";
	$out .= "</div>";
	$out .= $thumbnail;
	$out .= "<div class='type {$type}'>{$type}</div>";
	$out .= "<div class='score'><i class='fa fa-star'></i> {$score}</div>";
	$out .= "</div>";
	$out .= "<div class='data'>";
	$out .= "<div class='title'><h2 class='entry-title' itemprop='headline'>{$title}</h2></div>";
	$out .= "<div class='type'>{$status}</div>";
	$out .= "</div>";
	$out .= "</a>";
	$out .= "</div>";
	$out .= east_tooltip($post_id);
	$out .= "</div>";
	$out .= "</article>";

endwhile;

$big = 999999999;

$out .= "</div>";

$out .= east_pagination($wp_query->max_num_pages);

	return $out;

}
add_shortcode('anime_status', 'anime_status');

function anime_type($atts)
{
  extract(shortcode_atts(array(
    'count' => '10',
    'type' => 'TV',
  ) , $atts));

  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $wp_query = new WP_Query( array(
    'posts_per_page' => $count,
    'post_type' => 'anime',
    'orderby' => 'date',
    'ignore_sticky_posts' => 1,
    'meta_key' => 'east_type',
    'meta_value' => $type,
    'paged' => $paged,
  ));

	$out  = "<div class='relat'>";

	while ($wp_query->have_posts()) : $wp_query->the_post();

	$post_id = get_the_ID();
	$post_class = join( '  ', get_post_class('animpost') );
	$type = meta($post_id, 'east_type');
	$status = status_anime($post_id);
	$score = meta($post_id, 'east_score');
	$thumbnail = the_thumbnail($post_id, '150','210' );
	$permalink = get_the_permalink($post_id);
	$title = get_the_title($post_id);

  $out   .= "<article id='post-{$post_id}' class='{$post_class}' itemscope='itemscope' itemtype='http://schema.org/CreativeWork'>";
	$out .= "<div class='animepost'>";
	$out .= "<div class='animposx'>";
	$out .= "<a rel='{$post_id}' href='{$permalink}' title='$title' alt='$title'>";
	$out .= "<div class='content-thumb'>";
	$out .= "<div class='ply'>";
	$out .= "<i class='fa fa-play'></i>";
	$out .= "</div>";
	$out .= $thumbnail;
	$out .= "<div class='type {$type}'>{$type}</div>";
	$out .= "<div class='score'><i class='fa fa-star'></i> {$score}</div>";
	$out .= "</div>";
	$out .= "<div class='data'>";
	$out .= "<div class='title'><h2 class='entry-title' itemprop='headline'>{$title}</h2></div>";
	$out .= "<div class='type'>{$status}</div>";
	$out .= "</div>";
	$out .= "</a>";
	$out .= "</div>";
	$out .= east_tooltip($post_id);
	$out .= "</div>";
	$out .= "</article>";

endwhile;

$big = 999999999;

$out .= "</div>";

$out .= east_pagination($wp_query->max_num_pages);

	return $out;

}
add_shortcode('anime_type', 'anime_type');

function anime_popular($atts)
{
  extract(shortcode_atts(array(
    'count' => '10',
  ) , $atts));

	global $paged;

  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $wp_query = new WP_Query( array(
    'posts_per_page' => $count,
    'post_type' => 'anime',
    'ignore_sticky_posts' => 1,
		'meta_key' => 'wpb_post_views_count',
		'orderby' => 'meta_value_num',
    'paged' => $paged,
  ));

	$out  = "<div class='relat'>";

	while ($wp_query->have_posts()) : $wp_query->the_post();

	$post_id = get_the_ID();
	$post_class = join( '  ', get_post_class('animpost') );
	$type = meta($post_id, 'east_type');
	$status = status_anime($post_id);
	$score = meta($post_id, 'east_score');
	$thumbnail = the_thumbnail($post_id, '150','210' );
	$permalink = get_the_permalink($post_id);
	$title = get_the_title($post_id);

  $out   .= "<article id='post-{$post_id}' class='{$post_class}' itemscope='itemscope' itemtype='http://schema.org/CreativeWork'>";
	$out .= "<div class='animepost'>";
	$out .= "<div class='animposx'>";
	$out .= "<a rel='{$post_id}' href='{$permalink}' title='$title' alt='$title'>";
	$out .= "<div class='content-thumb'>";
	$out .= "<div class='ply'>";
	$out .= "<i class='fa fa-play'></i>";
	$out .= "</div>";
	$out .= $thumbnail;
	$out .= "<div class='type {$type}'>{$type}</div>";
	$out .= "<div class='score'><i class='fa fa-star'></i> {$score}</div>";
	$out .= "</div>";
	$out .= "<div class='data'>";
	$out .= "<div class='title'><h2 class='entry-title' itemprop='headline'>{$title}</h2></div>";
	$out .= "<div class='type'>{$status}</div>";
	$out .= "</div>";
	$out .= "</a>";
	$out .= "</div>";
	$out .= east_tooltip($post_id);
	$out .= "</div>";
	$out .= "</article>";

endwhile;

$big = 999999999;

$out .= "</div>";
$out .= east_pagination($wp_query->max_num_pages);

	return $out;

}
add_shortcode('anime_popular', 'anime_popular');

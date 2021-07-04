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
if (!defined('ABSPATH')) {
	exit;
}

# Define template directory
define('EAST_URI', get_template_directory_uri());
define('EAST_DIR', get_template_directory());

/*** include section ***/
include 'inc/east_init.php';
include 'inc/east_core.php';

load_theme_textdomain('esthm', EAST_DIR . '/lang/');

if (!is_admin()) {
	add_filter('pre_get_posts', 'search_query');
}

if (current_user_can('subscriber')) {
	add_filter('show_admin_bar', '__return_false');
}

if (!function_exists('wpa_cpt_tags')) {
	function wpa_cpt_tags($query)
	{
		if ($query->is_tag() && $query->is_main_query()) {
			$query->set('post_type', array(
				'anime', 'post', 'blog'
			));
		}
	}
	if (!is_admin()) {
		add_action('pre_get_posts', 'wpa_cpt_tags');
	}
}

function search_query($query)
{
	if ($query->is_search) {
		$query->set('post_type', array(
			'anime',
		));
	}
	return $query;
}

function east_theme_setup()
{

	add_theme_support('automatic-feed-links');

	add_theme_support('post-thumbnails');

	add_theme_support('title-tag');

	register_nav_menus(array(
		'main' => __('Header Menu'),
		'footer' => __('Footer Menu'),
	));
}

add_action('after_setup_theme', 'east_theme_setup');

if (!function_exists('wpb_set_post_views')) {
	function wpb_set_post_views($postID)
	{
		$count_key = 'wpb_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if ($count == '') {
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		} else {
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
}

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

if (!function_exists('wpb_track_post_views')) {
	function wpb_track_post_views($post_id)
	{
		if (!is_single()) {
			return;
		}

		if (empty($post_id)) {
			global $post;
			$post_id = $post->ID;
		}
		wpb_set_post_views($post_id);
	}
}
add_action('wp_head', 'wpb_track_post_views');

if (!function_exists('wpb_get_post_views')) {
	function wpb_get_post_views($postID)
	{
		$count_key = 'wpb_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if ($count == '') {
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return __d('0 View');
		}
		return $count . __d(' Views');
	}
}

update_option('eastplay_license_key_status', 'valid');

function easthemeadmin_assets()
{
	if (isset($_GET['page']) and $_GET['page'] == EAST_THEME_SLUG . '-settings') {
		wp_enqueue_style('eastheme-panel-styles', EAST_URI . '/assets/css/admin/admin.settings.css', '', EAST_VERSION, 'all');
		wp_enqueue_script('eastheme-panel-scripts', EAST_URI . '/assets/js/admin/admin.settings.js', array(
			'jquery',
		), EAST_VERSION);
	}
	wp_enqueue_script('jquery-ui-timepicker', EAST_URI . '/assets/js/admin/jquery-ui-timepicker-addon.js',  array('jquery-ui-datepicker', 'jquery-ui-slider'), EAST_VERSION, true);
	if (isset($_GET['page']) and $_GET['page'] == EAST_THEME_SLUG . '-license') {
		wp_enqueue_style('eastheme-license', EAST_URI . '/assets/css/admin/admin.license.css', '', EAST_VERSION, 'all');
		wp_enqueue_script('eastheme-panel-scripts', EAST_URI . '/assets/js/admin/admin.license.js', array(
			'jquery',
		), EAST_VERSION);
	}
	wp_enqueue_style('fontsawesome', EAST_URI . '/assets/css/font-awesome.min.css', array(), null);
	wp_enqueue_style('eastheme-panel-styles', EAST_URI . '/assets/css/admin/admin.post.css', '', EAST_VERSION, 'all');
	wp_enqueue_style('eastheme-jqueryui-styles', EAST_URI . '/assets/css/admin/jquery-ui.css', '', EAST_VERSION, 'all');
	wp_enqueue_style('eastheme-select2-styles', EAST_URI . '/assets/css/admin/select2.css', '', EAST_VERSION, 'all');
	wp_enqueue_script('eastheme-select2', EAST_URI . '/assets/js/admin/select2.min.js', array('jquery'), EAST_VERSION);
	wp_enqueue_script('eastheme-wp-scripts', EAST_URI . '/assets/js/admin/admin.post.js', array('jquery'), EAST_VERSION);
}
add_action('admin_enqueue_scripts', 'easthemeadmin_assets');


function east_style()
{
	wp_enqueue_style('theme-light', EAST_URI . '/assets/css/style.css', array(), EAST_VERSION);
	wp_enqueue_style('theme-dark', EAST_URI . '/assets/css/dark.css', array(), EAST_VERSION);
	wp_enqueue_style('owl-carousel', EAST_URI . '/assets/css/owl.carousel.css', array(), EAST_VERSION);
	wp_enqueue_style('magnific-popup', EAST_URI . '/assets/css/magnific-popup.css', array(), null);
	wp_enqueue_style('fonts-roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700', array(), null);
	wp_enqueue_style('fontsawesome', 'https://use.fontawesome.com/releases/v5.9.0/css/all.css', array(), null);
}

function jquery_theme()
{
	wp_deregister_script('jquery');
	wp_register_script('jquery', EAST_URI . '/assets/js/jquery.min.js', array(), EAST_VERSION, false);
	wp_enqueue_script('jquery');
}
if (!is_admin()) {
	add_action('wp_enqueue_scripts', 'jquery_theme', 99);
}

if (!function_exists('east_scripts')) {
	function east_scripts()
	{
		wp_enqueue_script('scrollbar', EAST_URI . '/assets/js/mcsbscrollbar.js', array('jquery'), EAST_VERSION, false);
		wp_enqueue_script('idtabs', EAST_URI . '/assets/js/jquery.idTabs.min.js', array('jquery'), EAST_VERSION, false);
		wp_enqueue_script('magnific-popup', EAST_URI . '/assets/js/jquery.magnific-popup.min.js', '', EAST_VERSION, true);
		wp_enqueue_script('owl', EAST_URI . '/assets/js/owl.carousel.js', array('jquery'), EAST_VERSION, false);
		wp_enqueue_script('front-script', EAST_URI . '/assets/js/front.script.js', array('jquery'), EAST_VERSION, true);
	}
}


function east_scripts_footer()
{

	$google_analytics = get_option('ganalytics');
	$disqus = get_option('commentssystem');
	$tooltip = get_option('easttooltip');
?>
	<script type="text/javascript">
		<?php
		if ($google_analytics) { ?>
				(function(b, c, d, e, f, h, j) {
					b.GoogleAnalyticsObject = f, b[f] = b[f] || function() {
						(b[f].q = b[f].q || []).push(arguments)
					}, b[f].l = 1 * new Date, h = c.createElement(d), j = c.getElementsByTagName(d)[0], h.async = 1, h.src = e, j.parentNode.insertBefore(h, j)
				})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga'), ga('create', '<?php echo $google_analytics; ?>', 'auto'), ga('send', 'pageview');
			<?php
		}
		if ($disqus == 'dq') {
			if (is_single()) { ?>
				var disqus_shortname = '<?php echo get_option('dqsrt'); ?>';
				(function() {
					var a = document.createElement("script");
					a.type = "text/javascript";
					a.async = true;
					a.src = "//" + disqus_shortname + ".disqus.com/embed.js";
					(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(a)
				})();
		<?php }
		} ?>
			! function(a) {
				a(window).load(function() {
					a(".scrolling").mCustomScrollbar({
						theme: "minimal-dark",
						scrollButtons: {
							enable: !0
						},
						callbacks: {
							onTotalScroll: function() {
								addContent(this)
							},
							onTotalScrollOffset: 100,
							alwaysTriggerOffsets: !1
						}
					})
				})
			}(jQuery);
		<?php if ($tooltip == 1) { ?>
			$(function() {
				for (var b = 0, a = $(".relat .animpost"), c = 0; c <= a.length; c++) {
					b > 3 ? ($(".relat .animpost:nth-child(" + c + ") .stooltip").addClass("right"), 5 > b ? b++ : (b--, b--, b--, b--)) : ($(".relat .animpost:nth-child(" + c + ") .stooltip").addClass("left"), b++)
				}
			});
			$(".animpost").on({
				mouseover: function() {
					$(this).addClass("active")
				},
				mouseleave: function() {
					$(this).removeClass("active")
				}
			});
		<?php } ?>
		$(document).ready(function() {
			jQuery(function($) {
				$('.switch input').on('click', function(e) {
					if ($(this).is(':checked')) {
						$('body').addClass('darkmode');
						jQuery(".logo img").attr('src', '<?php echo get_option('logodark'); ?>');
						$('.switch input').each(function(item, key) {
							$(this).prop('checked', true);
						});
						localStorage.setItem('theme-mode', 'darkmode');
					} else {
						$('body').removeClass('darkmode');
						jQuery(".logo img").attr('src', '<?php echo get_option('logo'); ?>');
						$('.switch input').each(function(item, key) {
							$(this).prop('checked', false);
						});
						localStorage.setItem('theme-mode', 'lightmode');
					}
				});
			});
			<?php if (is_singular(array('anime', 'post'))) { ?>
				$(".slidfer").owlCarousel({
					loop: true,
					dots: false,
					autoplay: false,
					pagination: false,
					responsive: {
						0: {
							items: 2,
							nav: false,
						},
						600: {
							items: 4,
							nav: false,
						},
						800: {
							items: 4,
							nav: false,
						},
						1000: {
							items: 5,
							nav: false,
						}
					}
				});
				$(".slidfer2").owlCarousel({
					loop: true,
					dots: false,
					autoplay: false,
					pagination: false,
					responsive: {
						0: {
							items: 2,
							nav: false,
						},
						600: {
							items: 4,
							nav: false,
						},
						800: {
							items: 4,
							nav: false,
						},
						1000: {
							items: 5,
							nav: false,
						}
					}
				});
			<?php } ?>
		});
	</script>

<?php

}
add_action('wp_footer', 'east_scripts_footer');


function east_scripts_head()
{
?>
	<script type='text/javascript'>
		var defaultTheme = '<?php echo get_option('colorscheme'); ?>';
		<?php if (is_singular('post')) { ?>
			$(document).ready(function() {
				$("#shadow").css("height", $(document).height()).hide();
				$(".light").click(function() {
					$("#shadow").toggle();
					if ($("#shadow").is(":hidden")) {
						$(this).html("<i class='fa fa-lightbulb'></i> <span><?php _d('Turn on Light'); ?></span>").removeClass("turnedOff")
					} else {
						$(this).html("<i class='fa fa-lightbulb'></i> <span><?php _d('Turn off Light'); ?></span>").addClass("turnedOff")
					}
				});
				$("#shadow").click(function() {
					$("#shadow").toggle(), $(".light").html("<i class='fa fa-lightbulb'></i> <span>Turn on Light</span>").removeClass("turnedOff")
				});
				$(".expand").click(function() {
					$(".player-area ").toggleClass("expnd");
					$(".plyexpand").toggleClass("acxpan");
					if ($(".plyexpand").hasClass("acxpan")) {
						$(".expand").html("<i class='fa fa-expand-arrows-alt'></i> <span><?php _d('Shrink'); ?></span>")
					} else {
						$(".expand").html("<i class='fa fa-expand-arrows-alt'></i> <span><?php _d('Expand'); ?></span>")
					}
				});
				$(".shares").click(function() {
					$(".sds").toggleClass("displayblock")
				})
			});
		<?php } ?>
	</script>
	<?php
}
add_action('wp_head', 'east_scripts_head');


function east_custom_color()
{

	$themecolor = get_option('themecolor');
	if ($themecolor) { ?>
		<style type="text/css">
			.filtersearch button.filterbtn,
			.mode_post a,
			.hpage a,
			#footer .footermenu,
			.letter_az .active,
			.letter_home ul.lttr_azhome li a,
			.boxurl strong,
			.letterlist a:hover,
			.alert-warning,
			.pagination span.page-numbers.current,
			#footer-menu,
			.boxdl .boxtitle,
			#footer-widget .boxbar .genre li a:hover,
			#slider .slide-caption .btn,
			.seriestitle,
			.owl-dot.active span,
			.post_taxs a,
			.owl-dot.active:hover span,
			.bookmark,
			#sidebar .widgets h3 .linkwidget,
			.filter.submit .btn,
			.switchmode .slider.round:before,
			.scrollToTop,
			.ctss,
			.post-body p.index,
			.ajax-auth input.submit_button,
			.favbut,
			.widgetseries.poplr ul li.topanm .ctr,
			.page_inf .infs .inf_gen a:hover,
			.naveps .nvsc a,
			a.selected .item.swiper-slide,
			.widget.schedule .widget-body .slider .items .item:hover,
			#epl::-webkit-scrollbar,
			span.e,
			.epl .mirrorifram.active,
			.epl ul li a.active,
			.epl ul li:hover a,
			.autocomplete-suggestion:nth-child(odd):hover,
			.autocomplete-suggestion:hover,
			.taxlist li a:hover,
			ul.taxlists li .taxtil,
			#sidebar .widgets .ongoingwgt li .r,
			.footerwgt .widfoot .sct .ongoingwgt li .r,
			#sidebar .widgets ul.season li:before,
			.login,
			.recommended h2,
			.widget-title .reset,
			.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar,
			.live-search ul li a.more,
			#respond #submit,
			.glimit a:hover,
			.commentlist li .reply a,
			a.linkwidget,
			.icon.in-views,
			.letter_az a:hover,
			#primary-menu,
			.filter-sort li input:checked+label,
			.tab-account.active,
			.lgsg_form fieldset input[type="submit"],
			form.update_profile fieldset input[type="submit"],
			.mobileswl .accont,
			.ctra,
			.profile_control a,
			ul.amenu li a.selected,
			.filterss.active {
				background: <?php echo $themecolor; ?>
			}

			.radiox input:checked~.checkfilx,
			.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
			.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
			.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar,
			.tooltip .towatch a,
			.listeps span.eps,
			.filtersearch .radio input:checked~.checkfilx,
			.widgetseries ul li .ctr,
			.widgetfilter .filters .filter.submit button {
				background-color: <?php echo $themecolor; ?>
			}

			.widget-title span,
			.listttl ul li,
			.post-body .dev ul li .dtl h2 a:hover,
			.post-body .boxed .right .lts ul li .dtl span a:hover,
			.letter-cell a,
			.white .bottom a:hover,
			a,
			.search_desktop #form #s:focus+button,
			.search_desktop2 #form2 #s2:focus+button,
			a#pop_signup,
			a#pop_login,
			.headpost h1,
			#sidebar .side a:hover,
			.filters .filter li label:hover,
			.filters .filter li:hover,
			.filters .filter li input:checked+label:before,
			.widget.az-list .items .item .info .name:hover,
			.page_inf .infs .inf_gen a,
			ul.smenu li a.selected,
			h1.titless,
			a:hover,
			.widget.info .info .head .title a,
			.widget.info .info dl.info_episode dd a,
			.widget.schedule .widget-body .timeline .item .info .name:hover,
			.widget.schedule .widget-body .timeline .item .watch:hover,
			.listabj a,
			.listttl a:hover,
			.tooltip .totitle h4,
			.bs .bsx .content-thumb .ply .dashicons,
			.itemleft .icon .fa,
			.slide-content .title a:hover,
			#respond #submit:hover,
			.lstepsiode ul li span.dt a,
			.listeps a:visited,
			.widget_senction .widget-title h3,
			.widget-title h3,
			.widget-title h1,
			#sidebar .widgets h3,
			a.btn.nextf:hover,
			a.btn.prevf:hover,
			.animetitle-episode,
			.widgetongoing li .eps,
			.animepost .animposx .data .mark i,
			.entry-header h1,
			.sttle h1,
			#primary-menu ul li ul li a:hover,
			#server .east_player_option.on:before {
				color: <?php echo $themecolor; ?>
			}

			.epl ul li:hover a,
			.page_inf .infs .inf_gen a,
			.letter_az a.active,
			.letter_az a:hover,
			.widgetseries ul li .ctr,
			.filter.submit .btn,
			.search_desktop2 #form2 #s2:focus,
			.pagination span.page-numbers.current,
			.ajax-auth input.submit_button,
			a#pop_signup,
			a#pop_login,
			.epl .mirrorifram.active,
			.taxlist li a:hover,
			.filtersearch button.filterbtn,
			.widget.schedule .widget-body .timeline .item .watch:hover,
			.tooltip .towatch a,
			.form-control:focus,
			blockquote,
			q,
			#respond #submit,
			.letterlist a:hover,
			#server .east_player_option.on,
			.lgsg_form fieldset input[type="text"]:focus,
			.lgsg_form fieldset input[type="password"]:focus,
			.filter-sort li input:checked+label {
				border-color: <?php echo $themecolor; ?>
			}

			.tax_fil .checkfil:after {
				border: solid <?php echo $themecolor; ?>;
				border-width: 0 3px 4px 0;
			}

			a.more.live_search_click:hover,
			.TV,
			.tab-account.active {
				background: <?php echo $themecolor; ?> !important
			}


			@media only screen and (max-width: 769px) {
				.header-area {

					background: <?php echo $themecolor; ?>
				}
			}

			@media only screen and (max-width: 769px) {
				.darkmode .header-area {

					background: <?php echo $themecolor; ?>
				}

				.darkmode .search_desktop #form #s {
					background: transparent
				}

				.darkmode .search_desktop #form #s {
					border: 1px solid #fff;
				}

				.darkmode .search_desktop #form #s::placeholder {
					color: #fff
				}

				.darkmode .search_desktop #form #s:focus {
					border-color: #fff;
				}

				.darkmode .search_desktop #form #s:focus+button {
					color: #fff;
				}

				.darkmode .search_desktop #form #submit {
					color: #fff
				}
			}
		</style><?php }
				}
				add_action('wp_head', 'east_custom_color');

				function east_hover_color()
				{

					$hovercolor = get_option('hovercolor');
					if ($hovercolor) { ?>
		<style type="text/css">
			.widgetfilter .filters .filter.submit button:hover,
			.filtersearch button.filterbtn:hover,
			.favbut:hover,
			.letter_home ul.lttr_azhome li a:hover,
			.live-search ul li a.more:hover,
			a.linkwidget:hover,
			.lgsg_form fieldset input[type="submit"]:hover,
			.profile_control a:hover,
			form.update_profile fieldset input[type="submit"]:hover,
			ul.taxlists li .count {
				background: <?php echo $hovercolor; ?> !important
			}

			.widgetfilter .filters .filter.submit button:hover,
			.filtersearch button.filterbtn:hover {
				border-color: <?php echo $hovercolor; ?>
			}
		</style><?php }
				}
				add_action('wp_head', 'east_hover_color');


						?>
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

class EastPlay_Settings {

private $settings_api;

public function __construct() {
	$this->settings_api = new EasThemeSettings;

	add_action( 'admin_init', array( $this, 'admin_init' ) );
	add_action( 'admin_menu', array( $this, 'admin_menu' ) );

}

public function admin_init() {
$this->settings_api->set_navigation( $this->navigation() );
$this->settings_api->set_fields( $this->field_settings() );
$this->settings_api->register_field_setting();
}

public function admin_menu() {
 add_theme_page( 'EastPlay Settings', 'EastPlay Settings', 'edit_theme_options', 'eastplay-settings', array( $this, 'east_configuration' ) );
}

public function navigation(){
	$navigation = array(
		array(
			'id' => 'headersettings',
			'name' => 'General',
			'icon' => 'fa fa-cog',
		),
		array(
			'id' => 'mainsettings',
			'name' => 'Main',
			'icon' => 'fa fa-home',
		),
		array(
			'id' => 'socialsettings',
			'name' => 'Social',
			'icon' => 'fa fa-facebook',
		),
		array(
			'id' => 'MalApisettings',
			'name' => 'MyAnimeList API',
			'icon' => 'fa fa-tasks',
		),
		array(
			'id' => 'commentssettings',
			'name' => 'Comments',
			'icon' => 'fa fa-comments',
		),
		array(
			'id' => 'ads',
			'name' => 'Advertising',
			'icon' => 'fa fa-usd',
		),
		array(
			'id' => 'singlesettings',
			'name' => 'Single Post',
			'icon' => 'fa fa-file-text',
		),
	);
	return $navigation;
}

function field_settings() {
$register = array(
    'headersettings' => array(
        array(
            'id' => 'logo',
						'name' => 'Logo',
						'desc' => 'Upload your image logo for default theme.',
						'type'  => 'upload',
        ),
				array(
            'id' => 'logodark',
						'name' => 'Dark Logo',
						'desc' => 'Upload your image logo for dark theme.',
						'type'  => 'upload',
        ),
				array(
						'id' => 'logoaccount',
						'name' => 'Account Logo',
						'desc' => 'Upload your image logo for account.',
						'type'  => 'upload',
				),
    ),
    'mainsettings' => array(
			array(
					'id' => 'themecolor',
					'name' => 'Theme Color',
					'desc' => 'Choose a color',
					'type'  => 'color',
			),
			array(
					'id' => 'hovercolor',
					'name' => 'Hover Color',
					'desc' => 'Choose a hover color',
					'type'  => 'color',
			),
			array(
					'id' => 'colorscheme',
					'name' => 'Color Scheme',
					'desc' => 'Select the default color scheme',
					'type'  => 'select',
					'options'         => array(
	'lightmode'       => 'Light Mode',
	'darkmode' => 'Dark Mode',
	),
			),
        array(
            'id' => 'ganalytics',
						'name' => 'Google Analytics',
						'desc' => 'Insert tracking code to use this function',
						'type'  => 'text',
						'placeholder' => 'UA-68543687-58',
        ),
				array(
						'id' => 'countpost',
						'name' => 'Latest update',
						'desc' => 'Number of items to show',
						'type'  => 'number',
								'placeholder' => '10',
				),
        array(
            'id' => 'customcss',
						'name' => 'Custom CSS',
						'desc' => 'Add only CSS code',
						'type'  => 'textarea',
						'placeholder' => '.YourClas{}',
        ),
        array(
            'id' => 'membersystem',
						'name' => 'Member system',
						'desc' => 'Member for favorites and watch later',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
        ),
				array(
						'id' => 'livesearch',
						'name' => 'Live search',
						'desc' => 'Ajax live search',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
				),
				array(
						'id' => 'easttooltip',
						'name' => 'Tooltip',
						'desc' => 'Show Tooltip',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
				),
				array(
						'id' => '',
						'name' => 'Photon CDN settings',
						'desc' => '',
						'type'  => 'header',
				),
				array(
						'id' => 'photonx',
						'name' => 'Photon CDN',
						'desc' => 'Accelerate you images from Photon CDN.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
				),
				array(
					'id' => 'autoresize',
					'name' => 'Auto resize',
					'desc' => 'Auto resizing image with photon',
					'type'  => 'select',
					'options'         => array(
						'0'       => 'Disable',
						'1' => 'Enable',
					),
				),
				array(
						'id' => 'imagequality',
						'name' => 'Image quality',
						'desc' => 'Adjust image quality (min 10 / max 100)',
						'type'  => 'number',
						'placeholder' => '10'
				),
				array(
						'id' => '',
						'name' => 'Page settings',
						'desc' => '',
						'type'  => 'header',
				),
				array(
						'id' => 'countaz',
						'name' => 'Anime per page in A-Z',
						'desc' => 'The number of items displayed in A-Z',
						'type'  => 'number',
						'placeholder' => '10'
				),
					array(
							'id' => 'advancedsearch',
							'name' => 'Anime per page in filter search',
							'desc' => 'The number of items displayed in filter',
							'type'  => 'number',
							'placeholder' => '10',
					),
					array(
							'id' => 'updateanime',
							'name' => 'Anime per page in latest',
							'desc' => 'The number of items displayed latest',
							'type'  => 'number',
							'placeholder' => '10',
					),
					array(
							'id' => 'updateblog',
							'name' => 'Latest blog number',
							'desc' => 'The number of items displayed blog',
							'type'  => 'number',
							'placeholder' => '10',
					),
					array(
							'id' => 'azpage',
							'name' => 'Page A-Z',
							'desc' => '',
							'type'  => 'select_query',
							'post_type' => 'page'
					),
					array(
							'id1' => 'schday',
							'placeholder1' => 'day',
							'id2' => 'schhour',
							'placeholder2' => 'hour',
							'id3' => 'schminute',
							'placeholder3' => 'minute',
							'name' => 'Format Schedule',
							'desc' => '',
							'class' => 'triple_text',
							'type'  => 'multi_text',
					),
					array(
							'id' => 'accountpage',
							'name' => 'Page account',
							'desc' => '',
							'type'  => 'select_query',
							'post_type' => 'page'
					),
					array(
							'id' => '',
							'name' => 'Google reCAPTCHA v2',
							'desc' => '',
							'type'  => 'header',
					),
				array(
            'id' => 'sitekey',
						'name' => 'Site Key',
						'desc' => '',
						'type'  => 'text',
						'placeholder' => '',
        ),
        array(
            'id' => 'secretkey',
						'name' => 'Secret Key',
						'desc' => '',
						'type'  => 'text',
						'placeholder' => '',
        ),
				array(
						'id' => '',
						'name' => 'Footer Settings',
						'desc' => '',
						'type'  => 'header',
				),
				array(
						'id' => 'logofooter',
						'name' => 'Footer Logo',
						'desc' => 'Upload your image logo for footer.',
						'type'  => 'upload',
				),
				array(
            'id' => 'textfooter',
						'name' => 'Footer text',
						'desc' => 'Set footer description',
						'type'  => 'textarea',
						'placeholder' => '',
        ),
    ),
		'MalApisettings' => array(
        array(
            'id' => 'catmal',
						'name' => 'Add categories',
						'desc' => 'Automatically create categories based on anime titles.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
        ),
				array(
						'id' => 'autouploadcover',
						'name' => 'Upload cover images to server',
						'desc' => 'Automatically saves images to the local server.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
				),
				array(
            'id' => 'autoupload',
						'name' => 'Upload poster images to server',
						'desc' => 'Automatically saves images to the local server.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
        ),
        array(
            'id' => 'titlemal',
						'name' => 'Title type',
						'desc' => 'Select the default post title that you want to use based on Myanimelist.',
						'type'  => 'select',
						'options'         => array(
		'title'       => 'Default',
		'english' => 'English',
				'title' => 'Kanji',
		),
        ),
    ),
		'commentssettings' => array(
				array(
						'id' => 'commentssystem',
						'name' => 'Comments system',
						'desc' => '',
						'type'  => 'select_js',
						'options'         => array(
		'wp'       => 'Wordpress',
		'dq' => 'Disqus',
		),
				),
				array(
						'id' => 'dqsrt',
						'name' => 'Shortname',
						'class' => 'cms dq',
						'desc' => '',
						'hidden' => 1,
						'type'  => 'text',
						'placeholder' => '',
				),

		),
		'socialsettings' => array(
			array(
					'id' => 'opengraph',
					'name' => 'Open Graph',
					'desc' => 'If you are using a third-party plugin for Open Graph, please turn this off',
					'type'  => 'select_js',
					'options'         => array(
	'0'       => 'Disable',
	'1' => 'Enable',
	),
			),

        array(
            'id' => 'twitterusername',
						'name' => 'Twitter Username',
						'desc' => 'Enter Twitter username, this is useful when you share your posts on Twitter',
						'hidden' => 1,
						'type' => 'text',
        ),
        array(
            'id' => 'fbappid',
						'name' => 'Facebook App ID',
						'desc' => 'Insert your Facebook Application ID, this is useful when you share your posts on Facebook',
						'hidden' => 1,
						'type' => 'text',
        ),
        array(
            'id' => 'fburl',
						'name' => 'Facebook',
						'desc' => 'The custom URL to your Facebook profile page (Please include http://)',
						'type' => 'text'
        ),
				array(
            'id' => 'twiturl',
						'name' => 'Twitter',
						'desc' => 'The custom URL to your Facebook profile page (Please include http://)',
						'type' => 'text'
        ),
        array(
            'id' => 'igurl',
						'name' => 'Instagram',
						'desc' => 'The custom URL to your Facebook profile page (Please include http://)',
						'type' => 'text',
        ),
				array(
						'id' => 'yturl',
						'name' => 'Youtube',
						'desc' => 'The custom URL to your Facebook profile page (Please include http://)',
						'type' => 'text',
				),
    ),
		'ads' => array(
			array(
					'id' => 'cadsheader',
					'name' => 'Header code integration',
					'desc' => 'Enter the code that you must place before the closing tag',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'cadsfooter',
					'name' => 'Footer code integration',
					'desc' => 'Enter the code you need to place in the footer.',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adsfloatcenter',
					'name' => 'Floating center',
					'desc' => 'Display floating banner in center.',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adsfloatleft',
					'name' => 'Floating left',
					'desc' => 'Display floating banner in left side.',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adsfloatright',
					'name' => 'Floating right',
					'desc' => 'Display floating banner in right side.',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => '',
					'name' => 'Homepage',
					'desc' => '',
					'type'  => 'header',
			),
			array(
					'id' => 'hadsheader',
					'name' => 'Header ads',
					'desc' => 'Display ads after menu',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => '',
					'name' => 'Single Episode',
					'desc' => '',
					'type'  => 'header',
			),
			array(
					'id' => 'sadsheader',
					'name' => 'Header ads',
					'desc' => 'Display ads after menu',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adsbottomtitle',
					'name' => 'After title',
					'desc' => 'Display ads after title',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adsbottomplayer',
					'name' => 'After player',
					'desc' => 'Display ads after player',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adstoplisteps',
					'name' => 'Before list episode',
					'desc' => 'Display ads before list episode',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => '',
					'name' => 'Single Anime',
					'desc' => '',
					'type'  => 'header',
			),
			array(
					'id' => 'adsbottomcover',
					'name' => 'After big info',
					'desc' => 'Display ads after big info',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adstopinfo',
					'name' => 'Before info',
					'desc' => 'Display ads before info',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adstoplsepisode',
					'name' => 'Before list episode',
					'desc' => 'Display ads before list episode',
					'type'  => 'textarea',
					'placeholder' => '',
			),
			array(
					'id' => 'adsbottomlsepisode',
					'name' => 'After list episode',
					'desc' => 'Display ads after list episode',
					'type'  => 'textarea',
					'placeholder' => '',
			),
		),
		'singlesettings' => array(
				array(
            'id' => 'breadcrumbs',
						'name' => 'Breadcrumbs',
						'desc' => 'Enable to display Breadcrumbs.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
        ),
				array(
						'id' => '',
						'name' => 'Episode',
						'desc' => '',
						'type'  => 'header',
				),
				array(
						'id' => 'relatedanime',
						'name' => 'Related Anime',
						'desc' => 'Enable to display Related Anime.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
				),
				array(
						'id' => 'playlistepisode',
						'name' => 'Play List',
						'desc' => 'Enable to display Play List.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
				),
				array(
						'id' => 'cnrelatedanime',
						'name' => 'Count Related Anime',
						'desc' => 'The number of items displayed Related Anime.',
						'type'  => 'number',
						'placeholder' => '10'
				),
				array(
						'id' => '',
						'name' => 'Anime',
						'desc' => '',
						'type'  => 'header',
				),
				array(
						'id' => 'recommendedanime',
						'name' => 'Recommended Anime',
						'desc' => 'Enable to display Recommended Anime.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
				),
				array(
						'id' => 'cnrecomanime',
						'name' => 'Count Recommended Anime',
						'desc' => 'The number of items displayed Recommended Anime.',
						'type'  => 'number',
						'placeholder' => '10'
				),
				array(
						'id' => '',
						'name' => 'Blog',
						'desc' => '',
						'type'  => 'header',
				),
				array(
						'id' => 'relatedblog',
						'name' => 'Related Blog',
						'desc' => 'Enable to display Related Blog.',
						'type'  => 'select',
						'options'         => array(
		'0'       => 'Disable',
		'1' => 'Enable',
		),
				),
				array(
						'id' => 'cnrelatedblog',
						'name' => 'Count Related Blog',
						'desc' => 'The number of items displayed Related Blog',
						'type'  => 'number',
						'placeholder' => '10'
				),
    ),
);
return $register;
}


public function east_configuration() {

	echo '<div class="dashboard-panel">';
	echo '<div class="headpanel">';

	echo '<div class="headpanelleft"><h1>EastPlay</h1></div>';
	echo '</div>';

	echo '<div class="eastheme-setting">';

	echo '<div class="content-separate">';
	echo '<div class="tab-setting-left">';
	echo '<h2 class="nav-tab-wrapper">';

$this->settings_api->show_navigation();


	echo '</h2>';
	echo '</div>';
	echo '<div class="tab-setting-right">';

	$this->settings_api->show_forms();

	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';

}

}

new EastPlay_Settings();

?>

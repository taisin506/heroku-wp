<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Plugin Name: NeverBlock
 * Plugin URI: https://www.neverblock.com
 * Description: Display alternative content to site visitors who block your ads.
 * Version: 1.7
 * Author: Exads
 * Author URI: https://www.exads.com
*/

class NeverBlock_Manager
{
    private static $_instance = null;


    private $adjectives = [
        "aged", "ancient", "autumn", "billowing", "bitter", "black", "blue", "bold",
        "broad", "broken", "calm", "cold", "cool", "crimson", "curly", "damp",
        "dark", "dawn", "delicate", "divine", "dry", "empty", "falling", "fancy",
        "flat", "floral", "fragrant", "frosty", "gentle", "green", "hidden", "holy",
        "icy", "jolly", "late", "lingering", "little", "lively", "long", "lucky",
        "misty", "morning", "muddy", "mute", "nameless", "noisy", "odd", "old",
        "orange", "patient", "plain", "polished", "proud", "purple", "quiet", "rapid",
        "raspy", "red", "restless", "rough", "round", "royal", "shiny", "shrill",
        "shy", "silent", "small", "snowy", "soft", "solitary", "sparkling", "spring",
        "square", "steep", "still", "summer", "super", "sweet", "throbbing", "tight",
        "tiny", "twilight", "wandering", "weathered", "white", "wild", "winter", "wispy",
        "withered", "yellow", "young",
    ];

    private $nouns = [
        "art", "band", "bar", "base", "bird", "block", "boat", "bonus",
        "bread", "breeze", "brook", "bush", "butterfly", "cake", "cell", "cherry",
        "cloud", "credit", "darkness", "dawn", "dew", "disk", "dream", "dust",
        "feather", "field", "fire", "firefly", "flower", "fog", "forest", "frog",
        "frost", "glade", "glitter", "grass", "hall", "hat", "haze", "heart",
        "hill", "king", "lab", "lake", "leaf", "limit", "math", "meadow",
        "mode", "moon", "morning", "mountain", "mouse", "mud", "night", "paper",
        "pine", "poetry", "pond", "queen", "rain", "recipe", "resonance", "rice",
        "river", "salad", "scene", "sea", "shadow", "shape", "silence", "sky",
        "smoke", "snow", "snowflake", "sound", "star", "sun", "sun", "sunset",
        "surf", "term", "thunder", "tooth", "tree", "truth", "union", "unit",
        "violet", "voice", "water", "water", "waterfall", "wave", "wildflower", "wind",
        "wood",
    ];

    public static function instance()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        // Define constants
        define( 'NEVERBLOCK_VERSION', '1.7' );
        define( 'NEVERBLOCK_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'NEVERBLOCK_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
        define( 'NEVERBLOCK_OPTION_PREFIX', 'neverblock_');
        define( 'NEVERBLOCK_DOC_URL', 'https://docs.exads.com/testing/');
        define( 'NEVERBLOCK_ADMIN_PAGE_NAME', 'neverblock');


        if ( is_admin() ) {

            global $wp_version;

            if ( version_compare( $wp_version, '4.9.0', '<' ) ) {
                wp_die( __( 'Sorry, this plugin has only been tested with Wordpress versions >= 4.9.' ) );
            }

            if (!is_multisite()) {
                add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
            } else if (is_multisite() && is_network_admin()) {
                add_action( 'network_admin_menu', array( $this, 'admin_menu' ), 12 );
            }

            add_action( 'admin_head', array( $this, 'admin_head' ) );

            add_action( 'admin_init', array( $this, 'redirect' ) );
            add_action( 'admin_init', array( $this, 'admin_output_buffer' ) );

            if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == NEVERBLOCK_ADMIN_PAGE_NAME . '-setup') {
                add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 12 );
            }
        }

        add_action('generate_rewrite_rules', array($this,'create_rewrite_rules'));
        add_action('wp_head', array($this, 'plugin_header'));
        add_action('wp_footer', array($this, 'plugin_footer'));
        add_filter('query_vars', array($this,'plugin_query_vars'));
        add_filter('template_redirect', array($this,'plugin_display'));
        add_shortcode('neverblock', array($this, 'neverblock_addzone'));
        add_action('init', array($this, 'strip_cookie_slashes'));
        add_action('init', array($this, 'define_plugin_constants'));

        register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), array( $this, 'activate' ) );
        register_deactivation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), array( $this, 'deactivate' ) );
    }

    public function define_plugin_constants() {

        define('CONNECT_TIMEOUT_MS', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'connect_timeout_ms', 300));
        define('REQUEST_TIMEOUT_MS', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'request_timeout_ms', 600));
        define('LOGFILE', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'logfile', null));
        define('WRITABLE_PATH', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'writable_path', null));
        define('CACHE_INTERVAL_BANNERS', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'cache_interval_banners', 3600)); // id set to 0, banners won't be cached
        define('CACHE_KEYS_LIMIT_BANNERS', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'cache_keys_limit_banners', 500));  //if set to 0, there will be no limit for the amount of keys this script can set
        define('CACHE_INTERVAL_SCRIPTS', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'cache_interval_scripts', 3600));
        define('POPUNDER_RESOURCE_URL', "http://ads." . get_site_option(NEVERBLOCK_OPTION_PREFIX . "domain_base", "exoclick.com") . "/popunder2000.js");
        define('MULTI_ADS_RESOURCE_URL', "http://syndication." . get_site_option(NEVERBLOCK_OPTION_PREFIX . "domain_base", "exoclick.com") . "/ads-multi.php?v=1");
        define('MULTI_BANNER_RESOURCE_URL', "http://syndication." . get_site_option(NEVERBLOCK_OPTION_PREFIX . "domain_base", "exoclick.com") . "/ads-multi.php?block=1");
        define('BANNER_BASE_URL', "http://static." . get_site_option(NEVERBLOCK_OPTION_PREFIX . "domain_base", "exoclick.com") . "/library/");
        define('ALLOW_MULTI_CURL', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'allow_multi_curl', 'off') == 'on');
        define('LINK_URL_PREFIX', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'link_url_prefix', ''));
        define('BANNER_URL_PREFIX', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'banner_url_prefix', ''));
        define('KEY_1', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'key_1', 't8Sn7cvBv2n8duxU28eUxqd6i+gJywzoNo72ItPEtdU='));
        define('KEY_2', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'key_2', "zCeopESQfMDIVekZTQjm52lbdnQ7iC2RgLuh3RAhexU="));

    }

    public function strip_cookie_slashes() {
        $_COOKIE = stripslashes_deep( $_COOKIE );
    }


    public function neverblock_addzone($atts)
    {
        $zone_config = new stdClass();
        $zone_config->idzone = $atts['idzone'];

        $script  = '<script type="text/javascript">' . PHP_EOL;
        $script .= '    (function () {' . PHP_EOL;
        $script .= '        function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;' . PHP_EOL;
        $script .= '        var zoneConfig_' . $atts['idzone'] . ' = ' . json_encode($zone_config) . ';' . PHP_EOL;

        foreach ($atts as $att_name => $att_value) {

            if ($att_name == 'idzone') {
                continue;
            }

            if ($att_name == 'container_id') {
                $script .= '        zoneConfig_' . $atts['idzone'] . '["container"] = document.getElementById(\'' . $att_value . '\');' . PHP_EOL;
                continue;
            }

            if (in_array($att_value, ['true', 'false'], true)) {
                $escaped_val = $att_value;
            } else {
                $escaped_val = "'" . $att_value . "'";
            }
            $script .= '        zoneConfig_' . $atts['idzone'] . '["' . $att_name . '"] = ' . $escaped_val . ';' . PHP_EOL;
        }

        $script .= '        ExoLoader.addZone(zoneConfig_' . $atts['idzone'] . ');' . PHP_EOL;
        $script .= '    })();' . PHP_EOL;
        $script .= '</script>' . PHP_EOL;

        return $script;
    }

    public function plugin_header()
    {
        $output = '<script type="text/javascript" src="/' . get_site_option(NEVERBLOCK_OPTION_PREFIX . 'random_frontend_name') . '/"></script>' . PHP_EOL;

        if (get_site_option(NEVERBLOCK_OPTION_PREFIX . 'domain_base', false)) {
            $output .= '<script type="text/javascript">' . PHP_EOL;
            $output .= '    (function () {' . PHP_EOL;
            $output .= '        function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;' . PHP_EOL;
            $output .= '        ExoLoader.getDetector().domain_base = "' . get_site_option(NEVERBLOCK_OPTION_PREFIX . 'domain_base') . '";' . PHP_EOL;
            $output .= '    })();' . PHP_EOL;
            $output .= '</script>' . PHP_EOL;
        }

        echo $output;
    }

    public function plugin_footer()
    {
        $output = '<script type="text/javascript">' . PHP_EOL;
        $output .= '    (function () {' . PHP_EOL;
        $output .= '        function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;' . PHP_EOL;
        $output .= '        var serveParams = {"script_url":"/' . get_site_option(NEVERBLOCK_OPTION_PREFIX . 'random_backend_name') . '/"};'  . PHP_EOL;
        if (get_site_option(NEVERBLOCK_OPTION_PREFIX . 'force_no_cache', 'off') == 'on') {
            $output .= '        serveParams.no_cache = true;' . PHP_EOL;
        }
        $output .= '        ExoLoader.serve(serveParams);' . PHP_EOL;
        $output .= '    })();' . PHP_EOL;
        $output .= '</script>' . PHP_EOL;

        echo $output;
    }

    public function admin_output_buffer()
    {
        // added to allow redirect when step 3 validates. if not present we would see a 'headers already sent'
        ob_start();
    }

    public function plugin_query_vars($vars)
    {
        $vars[] = 'plugin_action';
        $vars[] = 'mg';
        $vars[] = 'rl';

        return $vars;
    }

    public function plugin_display()
    {
        global $wp_query;

        $plugin_action = get_query_var('plugin_action');

        switch($plugin_action) {
            case 'backend':
                $_REQUEST = array_merge($_REQUEST, $wp_query->query_vars);

                // when we use banner_url_prefix or link_url_prefix we have to manually urldecode because query string missing
                if (isset($_REQUEST['mg'])) {
                    $_REQUEST['mg'] = rawurldecode($_REQUEST['mg']);
                }

                if (isset($_REQUEST['rl'])) {
                    $_REQUEST['rl'] = rawurldecode($_REQUEST['rl']);
                }

                include_once untrailingslashit(NEVERBLOCK_PLUGIN_DIR) . '/backend_loader.php';
                exit;
            case 'frontend':
                header('Content-Type: application/javascript');
                echo file_get_contents(untrailingslashit(NEVERBLOCK_PLUGIN_DIR) . '/frontend_loader.js');
                exit;
            default:
                break;
        }
    }

    public function admin_head()
    {
        remove_submenu_page( 'index.php', NEVERBLOCK_ADMIN_PAGE_NAME . '-setup' );
    }

    public function admin_menu() {

        add_dashboard_page( __( 'Setup', 'neverblock' ), __( 'Setup', 'neverblock' ), 'manage_options', 'neverblock-setup', array( $this, 'output' ) );

        add_menu_page(
            __( 'NeverBlock', 'neverblock' ),
            __( 'NeverBlock', 'neverblock' ),
            'manage_options',
            NEVERBLOCK_ADMIN_PAGE_NAME,
            array( $this, 'intro' ),
            'dashicons-shield-alt'	//	Menu Icon (https://developer.wordpress.org/resource/dashicons/#shield-alt)
        );

        add_submenu_page(
            NEVERBLOCK_ADMIN_PAGE_NAME,
                'NeverBlock Settings',
                'Settings',
                'manage_options',
            NEVERBLOCK_ADMIN_PAGE_NAME . '-settings',
                array($this, 'settings')
        );

        add_submenu_page(
            NEVERBLOCK_ADMIN_PAGE_NAME,
                'NeverBlock System Check',
                'System Check',
                'manage_options',
                NEVERBLOCK_ADMIN_PAGE_NAME . '-diagnose',
                array($this, 'diagnose')
        );
    }

    public function intro()
    {
        ?>
        <h3><?php _e( 'NeverBlock', 'neverblock' ); ?></h3>
        <p><?php _e( 'Thanks for installing <em>NeverBlock</em>! Let\'s get your site ready to ignore ad blockers.', 'neverblock' ); ?></p>
        <p>NeverBlock is a proven ad block circumventing solution that maximizes your revenues instantly. Our unique technology ensures that your advertisements still get shown even if a user has ad blocking software installed and switched on. NeverBlock’s advanced technology bypasses ad blockers to recapture all your ad revenue and works on all browsers (including Safari, Chrome, Internet Explorer, Mozilla, etc.) and on all platforms and devices (desktop, smartphone, tablet). The solution is free to all ExoClick clients and is a simple process of placing a line of code on your website.</p>

        <?php
        if (get_site_option(NEVERBLOCK_OPTION_PREFIX . 'random_backend_name', false)) {
            $backendLoaderUrl = untrailingslashit(get_site_url())  . '/' . get_site_option(NEVERBLOCK_OPTION_PREFIX . 'random_backend_name') . '/?exoDebug=exoDebug';
            ?>
            <p>To access the backend loader script directly for debugging please click <a href="<?php echo $backendLoaderUrl; ?>" target="_blank">here</a> or use the following url in your browser address bar: <strong><?php echo $backendLoaderUrl ?></strong> after opening a page with the ExoLoader codes</p>
            <?php
        }
    }

    function diagnose()
    {
        ?>
        <h3><?php _e( 'System Requirements', 'neverblock' ); ?></h3>
        <?php
        include_once NEVERBLOCK_PLUGIN_DIR . '/diag.php';
    }

    function settings($wizard=false)
    {
        $messages = [];

        if ( ! empty( $_POST ) ) {
            if ( false == wp_verify_nonce( $_REQUEST[ 'setup_wizard' ], 'step_3' ) )
                wp_die( 'Error in nonce. Try again.', 'neverblock' );

            $neverblock_options     = $_POST['neverblock-option'];

            foreach ( $neverblock_options as $name => $value ) {
                $isUpdate = $this->add_or_update_neverblock_option($name, $value);
                if ($isUpdate !== true) {
                    $messages[] = $isUpdate;
                }
            }

            if ($wizard && count($messages) == 0) {
                wp_redirect( add_query_arg( 'step', 4 ));
                exit;
            } elseif (count($messages) == 0) {
                ?>
                <div class="notice notice-success"><p>Plugin Settings Updated</p></div>
                <?php
            }
        }

        ?>

        <h3><?php _e( 'Plugin Settings', 'neverblock' ); ?></h3>

        <p><?php _e( 'We recommended to keep the default settings when they are already set but in some cases it can be useful to change some of the configurations..', 'neverblock' ); ?></p>

        <?php foreach ($messages as $message): ?>
        <div class="notice notice-error"><p><?= $message; ?></p></div>
        <?php endforeach; ?>

        <form action="<?php echo esc_url( add_query_arg( 'step', 3 ) ); ?>" method="post">
            <?php wp_nonce_field( 'step_3', 'setup_wizard' ); ?>
            <table class="neverblock-shortcodes widefat">
                <tbody>
                <tr>
                    <td colspan="4" style="background-color: #dedede">General</td>
                </tr>
                <tr>
                    <td>CONNECT_TIMEOUT_MS</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'connect_timeout_ms', '')?>" placeholder="<?php echo esc_attr( _x( 'Connection Timeout ms', 'Connection timeout in milliseconds', 'neverblock' ) ); ?>" name="neverblock-option[connect_timeout_ms]" /></td>
                    <td><?php _e('Connection timeout in milliseconds used for curl/fsock requests.', 'neverblock') ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>REQUEST_TIMEOUT_MS</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'request_timeout_ms', '')?>" placeholder="<?php echo esc_attr( _x( 'Request Timeout ms', 'Request timeout in milliseconds', 'neverblock' ) ); ?>" name="neverblock-option[request_timeout_ms]" /></td>
                    <td><?php _e('Whole request timeout in milliseconds (also includes time from CONNECT_TIMEOUT_MS) used for curl/fsock requests.', 'neverblock' ); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>LOGFILE</td>
                    <td><input type="text" value="<?php echo str_replace(trailingslashit(NEVERBLOCK_PLUGIN_DIR), '', get_site_option(NEVERBLOCK_OPTION_PREFIX . 'logfile', ''))?>" placeholder="<?php echo esc_attr( _x( 'Logfile', 'Log file for errors, etc.', 'neverblock' ) ); ?>" name="neverblock-option[logfile]" /></td>
                    <td><?php _e('Path to a writable file to log the messages, like some errors and cases when requests time out. Will be created in ' . NEVERBLOCK_PLUGIN_DIR . ' when name does not start with slash, eg neverblock.log will be created as ' . untrailingslashit(NEVERBLOCK_PLUGIN_DIR) . '/neverblock.log' , 'neverblock' ) ?></td>
                    <td><a href="https://docs.exads.com/testing/configuration/#logfile" target="_blank">More</a></td>
                </tr>
                <tr>
                    <td>DOMAIN_BASE</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'domain_base', '')?>" placeholder="<?php echo esc_attr( _x( 'Domain base', 'Domain base', 'neverblock' ) ); ?>" name="neverblock-option[domain_base]" /></td>
                    <td><?php _e('If you are using a domain other *.exoclick.com (e.g ads.yourdomain.com) then you should set this value to “yourdomain.com”', 'neverblock' )?></td>
                    <td><a href="https://docs.exads.com/testing/displaying-ads/#domain-base" target="_blank">More</a></td>
                </tr>
                <tr>
                    <td>ALLOW_MULTI_CURL</td>
                    <?php
                    $checked = get_site_option(NEVERBLOCK_OPTION_PREFIX . 'allow_multi_curl', 'off') == 'on' ? 'checked="checked"' : '';
                    ?>
                    <td><input type="hidden" name="neverblock-option[allow_multi_curl]" value="off"><input type="checkbox" name="neverblock-option[allow_multi_curl]" <?php echo $checked; ?>/></td>
                    <td><?php _e('When possible, script tries to use curl_multi_exec. If this is a burden on cpu - this can be turned off.', 'neverblock' )?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" style="background-color: #dedede">XCache, APC, File cache settings</td>
                </tr>
                <tr>
                    <td>WRITABLE_PATH</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'writable_path', '')?>" placeholder="<?php echo esc_attr( _x( 'File cache directory', 'File cache directory', 'neverblock' ) ); ?>" name="neverblock-option[writable_path]" /></td>
                    <td><?php _e('Path to writable directory, that will contain cache files. (if this is set - file cache will become default cache to use)', 'neverblock' ) ?></td>
                    <td><a href="https://docs.exads.com/testing/configuration/#caching" target="_blank">More</a></td>
                </tr>
                <tr>
                    <td>CACHE_INTERVAL_BANNERS</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'cache_interval_banners', '')?>" placeholder="<?php echo esc_attr( _x( 'Banner Cache Lifetime', 'Banner Cache Lifetime', 'neverblock' ) ); ?>" name="neverblock-option[cache_interval_banners]" /></td>
                    <td><?php _e('Cache lifetime for banner images (in seconds), if set to 0 images will NOT be cached.', 'neverblock' ) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>CACHE_INTERVAL_SCRIPTS</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'cache_interval_scripts', '')?>" placeholder="<?php echo esc_attr( _x( 'Script Cache Lifetime', 'Script Cache Lifetime', 'neverblock' ) ); ?>" name="neverblock-option[cache_interval_scripts]" /></td>
                    <td><?php _e('Cache lifetime for for javascripts like popunder (in seconds), if set to 0 they will NOT be cached.', 'neverblock' ) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>CACHE_KEYS_LIMIT_BANNERS</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'cache_keys_limit_banners', '')?>" placeholder="<?php echo esc_attr( _x( 'Max Number Banners Cached', 'Max Number Banners Cached', 'neverblock' ) ); ?>" name="neverblock-option[cache_keys_limit_banners]" /></td>
                    <td><?php _e('The limit for number of allowed banner images to store in cache (to not overuse publisher resources), if set to 0 there will be no limit, so all the images will be cached.', 'neverblock' ) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" style="background-color: #dedede">Apache/Nginx rewrite rules</td>
                </tr>
                <tr>
                    <td>LINK_URL_PREFIX</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'link_url_prefix', '')?>" placeholder="<?php echo esc_attr( _x( 'Link Url Prefix', 'Link Url Prefix', 'neverblock' ) ); ?>" name="neverblock-option[link_url_prefix]" /></td>
                    <td><?php _e('If is set, this will become the new URI for click links on frontend (the hash of url for redirection appended to it).', 'neverblock' ) ?>)</td>
                    <td></td>
                </tr>
                <tr>
                    <td>BANNER_URL_PREFIX</td>
                    <td><input type="text" value="<?php echo get_site_option(NEVERBLOCK_OPTION_PREFIX . 'banner_url_prefix', '')?>" placeholder="<?php echo esc_attr( _x( 'Banner Url Prefix', 'Banner Url Prefix', 'neverblock' ) ); ?>" name="neverblock-option[banner_url_prefix]" /></td>
                    <td><?php _e('If is set, this will become the new URI for banner images on frontend (the hash for specific banner appended to it)', 'neverblock' ) ?>)</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" style="background-color: #dedede">Ad Serving Js Params</td>
                </tr>
                <tr>
                    <td>FORCE_NO_CACHE</td>
                    <?php
                    $checked = get_site_option(NEVERBLOCK_OPTION_PREFIX . 'force_no_cache', 'off') == 'on' ? 'checked="checked"' : '';
                    ?>
                    <td><input type="hidden" name="neverblock-option[force_no_cache]" value="off"><input type="checkbox" name="neverblock-option[force_no_cache]" <?php echo $checked; ?>/></td>
                    <td><?php _e('An option for js ad serving frontend to append extra get parameters to server backend requests to prevent aggressive caching', 'neverblock' ) ?></td>
                    <td></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="4">
                        <input type="submit" class="button button-primary" value="Save" />
                    </th>
                </tr>
                </tfoot>
            </table>
        </form>
        <?php
    }

    /**
     * Sends user to the setup page on first activation.
     */
    public function redirect() {
        // Bail if no activation redirect transient is set
        if ( ! get_site_transient( '_neverblock_activation_redirect' ) ) {
            return;
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Delete the redirect transient
        delete_site_transient( '_neverblock_activation_redirect' );

        // Bail if activating from network, or bulk, or within an iFrame
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) || defined( 'IFRAME_REQUEST' ) ) {
            return;
        }

        if ( ( isset( $_GET['action'] ) && 'upgrade-plugin' == $_GET['action'] ) && ( isset( $_GET['plugin'] ) && strstr( $_GET['plugin'], 'nvrblck.php' ) ) ) {
            return;
        }

        wp_redirect( admin_url( 'index.php?page=' . NEVERBLOCK_ADMIN_PAGE_NAME . '-setup' ) );
        exit;
    }

    public function activate()
    {
        if ( ! get_site_option( 'neverblock_version' ) ) {
            set_site_transient( '_neverblock_activation_redirect', 1, HOUR_IN_SECONDS );
        }

        $default_options = [
            'connect_timeout_ms' => 300,
            'request_timeout_ms' => 600,
            'cache_interval_banners' => 3600,
            'cache_keys_limit_banners' => 500,
            'cache_interval_scripts' => 3600,
            'allow_multi_curl' => true,
            'key_1' => wp_generate_password(40, true, true),
            'key_2' => wp_generate_password(40, true, true),
            'random_backend_name' => $this->random_rewrite(),
            'random_frontend_name' => $this->random_rewrite(),
            'force_no_cache' => false,
        ];

        foreach ($default_options as $name => $value) {
            add_site_option(NEVERBLOCK_OPTION_PREFIX . $name, $value);
        }

        flush_rewrite_rules();
    }

    public function deactivate()
    {
        global $wp_rewrite, $wpdb;

        $options = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE '". NEVERBLOCK_OPTION_PREFIX . "%'");

        foreach ($options as $option) {
            delete_site_option($option->option_name);
        }

        $wp_rewrite->flush_rules();
    }

    public function create_rewrite_rules($wp_rewrite)
    {
        $plugin_rules = array(
            '^' . get_site_option(NEVERBLOCK_OPTION_PREFIX . 'random_backend_name', 'randombackendname') . '.*' =>
                'index.php?plugin_action=backend',
            '^' . get_site_option(NEVERBLOCK_OPTION_PREFIX . 'random_frontend_name', 'randomfrontendname') . '.*' =>
                'index.php?plugin_action=frontend'
        );

        $banner_url_prefix = get_site_option(NEVERBLOCK_OPTION_PREFIX . 'banner_url_prefix', '');

        if (!empty($banner_url_prefix)) {
            $plugin_rules['^' . ltrim($banner_url_prefix, '/') . '(.+)'] = 'index.php?plugin_action=backend&mg=$matches[1]';
        }

        $link_url_prefix = get_site_option(NEVERBLOCK_OPTION_PREFIX . 'link_url_prefix', '');

        if (!empty($link_url_prefix)) {
            $plugin_rules['^' . ltrim($link_url_prefix, '/') . '(.+)'] = 'index.php?plugin_action=backend&rl=$matches[1]';
        }

        $wp_rewrite->rules = $plugin_rules + $wp_rewrite->rules;

        return $wp_rewrite->rules;
    }

    public function admin_enqueue_scripts() {
        wp_enqueue_style( 'neverblock_setup_css', NEVERBLOCK_PLUGIN_URL . '/assets/css/setup.css', array( 'dashicons' ), NEVERBLOCK_VERSION );
    }

    private function add_or_update_neverblock_option($name, $value) {

        WP_Filesystem();

        $full_option_name = NEVERBLOCK_OPTION_PREFIX . $name;

        if(get_site_option($full_option_name) === false && empty(trim($value))) {
            return true;
        }

        $integer_options = [
            NEVERBLOCK_OPTION_PREFIX . 'cache_interval_scripts',
            NEVERBLOCK_OPTION_PREFIX . 'cache_keys_limit_banners',
            NEVERBLOCK_OPTION_PREFIX . 'cache_interval_banners',
            NEVERBLOCK_OPTION_PREFIX . 'request_timeout_ms',
            NEVERBLOCK_OPTION_PREFIX . 'connect_timeout_ms'
        ];

        $validators = [
            NEVERBLOCK_OPTION_PREFIX . 'writable_path' => function($name, &$item) {
                if (empty($item) || is_dir($item) && is_writable($item)) {
                    return true;
                }

                if (!is_dir($item)) {
                    return 'ERROR validating ' . $name . ': ' . $item . ' is not a directory';
                }

                if (!is_writable($item)) {
                    return 'ERROR validating ' . $name . ': ' . $item . ' is a not a writable directory';
                }

                return true;
            },
            NEVERBLOCK_OPTION_PREFIX . 'logfile' => function($name, &$item) {

                global $wp_filesystem;

                if (empty($item) || is_file($item) && is_writable($item)) {
                    return true;
                }

                $pathToLog = strpos($item, '/') === 0 ? $item : untrailingslashit(NEVERBLOCK_PLUGIN_DIR) . '/' . $item;

                if (!$wp_filesystem->is_file($pathToLog)) {

                    $needed_dirs = array();

                    $to = trailingslashit(dirname($pathToLog));

                    // Determine any parent dir's needed (of the upgrade directory)
                    if ( ! $wp_filesystem->is_dir($to) ) { //Only do parents if no children exist
                        $path = preg_split('![/\\\]!', untrailingslashit($to));
                        for ( $i = count($path); $i >= 0; $i-- ) {
                            if ( empty($path[$i]) )
                                continue;

                            $dir = implode('/', array_slice($path, 0, $i+1) );
                            if ( preg_match('!^[a-z]:$!i', $dir) ) // Skip it if it looks like a Windows Drive letter.
                                continue;

                            if ( ! $wp_filesystem->is_dir($dir) )
                                $needed_dirs[] = $dir;
                            else
                                break; // A folder exists, therefor, we dont need the check the levels below this
                        }
                    }

                    $needed_dirs = array_unique($needed_dirs);

                    foreach ( $needed_dirs as $dir ) {
                        // Check the parent folders of the folders all exist within the creation array.
                        if ( untrailingslashit($to) == $dir ) // Skip over the working directory, We know this exists (or will exist)
                            continue;
                        if ( strpos($dir, $to) === false ) // If the directory is not within the working directory, Skip it
                            continue;

                        $parent_folder = dirname($dir);
                        while ( !empty($parent_folder) && untrailingslashit($to) != $parent_folder && !in_array($parent_folder, $needed_dirs) ) {
                            $needed_dirs[] = $parent_folder;
                            $parent_folder = dirname($parent_folder);
                        }
                    }

                    asort($needed_dirs);

                    // Create those directories if need be:
                    foreach ( $needed_dirs as $_dir ) {
                        // Only check to see if the dir exists upon creation failure. Less I/O this way.
                        if ( ! $wp_filesystem->mkdir( $_dir, FS_CHMOD_DIR ) && ! $wp_filesystem->is_dir( $_dir ) )
                            return 'ERROR while setting up ' . $name . ': ' . $_dir . ' is a not a writable directory';
                    }

                    unset($needed_dirs);

                    if (!$wp_filesystem->put_contents($pathToLog, '')) {
                        return 'ERROR while setting up ' . $name . ': Unable to create ' . $pathToLog . '. Please check directory exists and is writeable';
                    }
                }

                $item = $pathToLog;

                return true;
            },
            NEVERBLOCK_OPTION_PREFIX . 'banner_url_prefix' => function($name, &$item) {

                $current_prefix = get_site_option(NEVERBLOCK_OPTION_PREFIX . 'banner_url_prefix');

                if ($item == $current_prefix) {
                    return true;
                }

                if (empty(trim($item))) {
                    // need to flush rewrites but can't do it here because option has to be set first
                    add_action('delete_site_option_' . NEVERBLOCK_OPTION_PREFIX . 'banner_url_prefix', 'flush_rewrite_rules');
                    return true;
                }

                $item = '/' . ltrim($item, '/');

                if (empty($current_prefix)) {
                    add_action('add_site_option_' . NEVERBLOCK_OPTION_PREFIX . 'banner_url_prefix', 'flush_rewrite_rules');
                } else {
                    add_action('update_site_option_' . NEVERBLOCK_OPTION_PREFIX . 'banner_url_prefix', 'flush_rewrite_rules');
                }

                return true;
            },
            NEVERBLOCK_OPTION_PREFIX . 'link_url_prefix' => function($name, &$item) {

                $current_prefix = get_site_option(NEVERBLOCK_OPTION_PREFIX . 'link_url_prefix');

                if ($item == $current_prefix) {
                    return true;
                }

                if (empty(trim($item))) {
                    // need to flush rewrites but can't do it here because option has to be set first
                    add_action('delete_site_option_' . NEVERBLOCK_OPTION_PREFIX . 'link_url_prefix', 'flush_rewrite_rules');
                    return true;
                }

                $item = '/' . ltrim($item, '/');

                if (empty($current_prefix)) {
                    add_action('add_site_option_' . NEVERBLOCK_OPTION_PREFIX . 'link_url_prefix', 'flush_rewrite_rules');
                } else {
                    add_action('update_site_option_' . NEVERBLOCK_OPTION_PREFIX . 'link_url_prefix', 'flush_rewrite_rules');
                }

                return true;
            }
        ];

        if (array_key_exists($full_option_name, $validators) && is_callable($validators[$full_option_name])) {
            $validation = $validators[$full_option_name](strtoupper($name), $value);
            if ($validation !== true) {
                return $validation;
            }
        }

        if (in_array($full_option_name, $integer_options)) {
            $value = absint($value);
        } else {
            $value = sanitize_text_field( $value );
        }

        if (get_site_option($full_option_name) === false) {
            add_site_option($full_option_name, $value);
        } elseif (trim($value) === '') {
            delete_site_option($full_option_name);
        } else {
            update_site_option($full_option_name, $value);
        }

        return true;
    }

    public function output() {

        $step = ! empty( $_GET['step'] ) ? absint( $_GET['step'] ) : 1;

        ?>

        <div class="wrap neverblock neverblock_addons_wrap">

            <h2><?php _e( 'NeverBlock Setup', 'neverblock' ); ?></h2>

            <ul class="neverblock-setup-steps">
                <li class="<?php if ( $step === 1 ) echo 'neverblock-setup-active-step'; ?>"><?php _e( '1. Introduction', 'neverblock' ); ?></li>
                <li class="<?php if ( $step === 2 ) echo 'neverblock-setup-active-step'; ?>"><?php _e( '2. System Requirements', 'neverblock' ); ?></li>
                <li class="<?php if ( $step === 3 ) echo 'neverblock-setup-active-step'; ?>"><?php _e( '3. Plugin Settings', 'neverblock' ); ?></li>
                <li class="<?php if ( $step === 4 ) echo 'neverblock-setup-active-step'; ?>"><?php _e( '4. Done', 'neverblock' ); ?></li>
            </ul>

            <?php if ( 1 === $step ) : ?>

                <?php
                $this->intro();
                ?>

                <p><?php _e( 'This setup wizard will walk you through the process of setting up NeverBlock for your site.', 'neverblock' ); ?></p>

                <p class="submit">
                    <a href="<?php echo esc_url( add_query_arg( 'step', 2 ) ); ?>" class="button button-primary"><?php _e( 'Start setup', 'neverblock' ); ?></a>
                </p>

            <?php endif; ?>
            <?php if ( 2 === $step ) : ?>
                <h3><?php _e( 'System Requirements', 'neverblock' ); ?></h3>

                <?php
                include_once NEVERBLOCK_PLUGIN_DIR . '/diag.php';
                ?>

                <p class="submit">
                    <a href="<?php echo esc_url( add_query_arg( 'step', 3 ) ); ?>" class="button button-primary"><?php _e( 'Next', 'neverblock' ); ?></a>
                </p>

            <?php endif; ?>
            <?php if ( 3 === $step ) : ?>
                <?php
                $this->settings(true);
                ?>
            <?php endif; ?>
            <?php if ( 4 === $step ) : ?>
                <h3><?php _e( 'You\'re ready to start using NeverBlock!', 'neverblock' ); ?></h3>
                <p><?php printf( __( 'Please refer to the %1$sdocumentation%2$s how to add NeverBlock zones to your themes', 'neverblock' ), '<a href="'. NEVERBLOCK_DOC_URL . '">', '</a>' ); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    public function random_rewrite()
    {
        $token_chars = "0123456789abcdef";
        $token_length = 4;
        $delimiter = '-';

        $adjective = $this->adjectives[mt_rand(0, count($this->adjectives) - 1)];
        $noun = $this->nouns[mt_rand(0, count($this->nouns) - 1)];
        $token = "";

        for ($i = 0; $i < $token_length; $i++) {
            $token .= $token_chars[mt_rand(0, strlen($token_chars) - 1)];
        }

        $sections = [$adjective, $noun, $token];
        return implode($delimiter, array_filter($sections));
    }
}

function NVRBLCK() {
    return NeverBlock_Manager::instance();
}

$GLOBALS['neverblock'] = NVRBLCK();

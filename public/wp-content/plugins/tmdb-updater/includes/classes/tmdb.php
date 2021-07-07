<?php if(!defined('ABSPATH')) die;
/**
 * @package TMDB Updater > Classes > TMDbAPI
 * @author Erick Meza
 * @copyright 2020 Doothemes and Dbmvs.com
 * @link https://doothemes.com/
 * @version 1.0.0
 */

class TMDbAPI{

    /**
     * @version 1.0
     * @since 1.0
     */
    protected static $api_key;
    protected static $api_lng;
    protected static $api_tim;
    protected static $api_img;

    /**
     * @version 1.0
     * @since 1.0
     */
    public static function get_content($post_id, $post_type){
        // Get Options
        $options = get_option('_dbmovies_settings');
        // Compose options
        self::$api_tim = microtime(TRUE);
        self::$api_key = self::c_isset($options,' themoviedb', TMDB_API_KEY);
        self::$api_lng = self::c_isset($options, 'language', TMDB_API_LNG);
        self::$api_img = self::c_isset($options, 'upload');
        // Set Response
        $response = array();
        // Verifications
        if(!empty($post_id) && !empty($post_type)){
            switch ($post_type) {
                case 'movies':
                    $response = self::movies($post_id);
                break;

                case 'tvshows':
                    $response = self::tvshows($post_id);
                break;

                case 'seasons':
                    $response = self::seasons($post_id);
                break;

                case 'episodes':
                    $response = self::episodes($post_id);
                break;

                default:
                    $response = array(
                        'success' => false,
                        'message' => __('Unknown error','tmdb')
                    );
                    break;
            }
        } else {
            $response = array(
                'success' => false,
                'message' => __('Incomplete data','tmdb')
            );
        }
        // The Response
        return $response;
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function upload_image($url = '', $post = '', $thumbnail = false, $showurl = false){
        if(self::$api_img == true && !empty($url)){
            // WordPress Lib
            require_once(ABSPATH.'wp-admin/includes/file.php');
			require_once(ABSPATH.'wp-admin/includes/image.php');
            // File System
            global $wp_filesystem;
            WP_Filesystem();
			// Get Image
			$upload_dir	  = wp_upload_dir();
			$image_remote = wp_remote_get($url);
			$image_data	  = wp_remote_retrieve_body($image_remote);
			$filename	  = wp_basename($url);
            if(!is_wp_error($image_data)){
                // Path folder
    			if(wp_mkdir_p($upload_dir['path'])) {
    				$file = $upload_dir['path'] . '/' . $filename;
    			} else {
    				$file = $upload_dir['basedir'] . '/' . $filename;
    			}
    			$wp_filesystem->put_contents($file, $image_data);
    			$wp_filetype = wp_check_filetype($filename, null);
    			// Compose attachment Post
    			$attachment = array(
    				'post_mime_type' => $wp_filetype['type'],
    				'post_title' => sanitize_file_name($filename),
    				'post_content' => false,
    				'post_status' => 'inherit'
    			);
    			// Insert Attachment
    			$attach_id	 = wp_insert_attachment($attachment, $file, $post);
    			$attach_data = wp_generate_attachment_metadata($attach_id, $file);
    			wp_update_attachment_metadata($attach_id, $attach_data );
    			// Featured Image
    			if($thumbnail == true) set_post_thumbnail($post, $attach_id);
    			if($showurl == true) return wp_get_attachment_url($attach_id);
            }
        }
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function c_isset($data = array(), $key = '', $default = null){
        return isset($data[$key]) ? $data[$key] : $default;
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function images($tmdb_images = array()){
        $images = '';
        if($tmdb_images){
            $image_count = 0;
            foreach($tmdb_images as $image) if($image_count < 10){
                if($image_count == 9){
                    $images.= self::c_isset($image,'file_path');
                }else{
                    $images.= self::c_isset($image,'file_path')."\n";
                }
                $image_count++;
            }
        }
        return $images;
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function arguments(){
        return array(
            'append_to_response'     => 'images,trailers',
            'include_image_language' => self::$api_lng.',null',
            'language'               => self::$api_lng,
            'api_key'                => self::$api_key
        );
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function remote($api = '', $args = array()){
        $sapi = esc_url_raw(add_query_arg($args, $api));
        $json = wp_remote_retrieve_body(wp_remote_get($sapi));
        return json_decode($json, true);
    }

    /**
     * @since 1.0
     * @version 1.0
     */
    private static function timexe($time = ''){
        $micro	= microtime(TRUE);
		return number_format($micro - $time, 2);
    }


    private static function successfully($post_id = '', $post_type = ''){
        return array(
            'success'   => true,
            'post_id'   => $post_id,
            'permalink' => get_permalink($post_id),
            'post_tile' => get_the_title($post_id),
            'post_type' => $post_type,
            'exetime'   => self::timexe(self::$api_tim)
        );
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function movies($post_id = ''){
        // Set Response
        $response = array();
        // Post Meta data
        $finder = get_post_meta($post_id, 'ids', true);
        // Verify ID finder
        if(!$finder){
            $finder = get_post_meta($post_id, 'idtmdb', true);
        }
        // Verify the Finder ID
        if(!empty($finder)){
            // TMDb Json data
            $json_tmdb   = self::remote(TMDB_API_URL.'/3/movie/'.$finder, self::arguments());
            // verificate
            if(!self::c_isset($json_tmdb,'status_code')){
                // Set TMDb Metada
                $release   = self::c_isset($json_tmdb,'release_date');
                $ortitle   = self::c_isset($json_tmdb,'original_title');
                $poster    = self::c_isset($json_tmdb,'poster_path');
                $backdrop  = self::c_isset($json_tmdb,'backdrop_path');
                $average   = self::c_isset($json_tmdb,'vote_average');
                $votecount = self::c_isset($json_tmdb,'vote_count');
                $tagline   = self::c_isset($json_tmdb,'tagline');
                $runtime   = self::c_isset($json_tmdb,'runtime');
                $backdrops = isset($json_tmdb['images']['backdrops']) ? $json_tmdb['images']['backdrops'] : false;
                $trailers  = isset($json_tmdb['trailers']['youtube']) ? $json_tmdb['trailers']['youtube'] : false;
                // Set Images
                $images = self::images($backdrops);
                // Set Video Traiter
                $youtube = '';
                if($trailers){
                    foreach($trailers as $trailer){
                        $youtube .= '['.self::c_isset($trailer,'source').']';
                        break;
                    }
                }
                // TMDb Api Credits
                $json_credits = self::remote(TMDB_API_URL.'/3/movie/'.$finder.'/credits', self::arguments());
                // Cast data
                $tmdb_cast = self::c_isset($json_credits,'cast');
                $tmdb_crew = self::c_isset($json_credits,'crew');
                // Compose Shortcode Cast
                $meta_cast = '';
                if($tmdb_cast){
                    $cast_count = 0;
                    foreach($tmdb_cast as $cast) if($cast_count < 10){
                        // Pre Data
                        $name = self::c_isset($cast,'name');
                        $chrt = self::c_isset($cast,'character');
                        $ppat = self::c_isset($cast,'profile_path');
                        $path = ($ppat == NULL) ? 'null' : $ppat;
                        // Set Data
                        $meta_cast .= '['.$path.';'.$name.','.$chrt.']';
                        // Counter
                        $cast_count++;
                    }
                }
                // Compose Shortcode Director
                $meta_director = '';
                if($tmdb_crew){
                    foreach ($tmdb_crew as $crew){
                        // Pre data
                        $name = self::c_isset($crew,'name');
                        $detp = self::c_isset($crew,'department');
                        $ppth = self::c_isset($crew,'profile_path');
                        $path = ($ppth == NULL) ? 'null' : $ppth;
                        if($detp == 'Directing'){
                            $meta_director .= '['.$path.';'.$name.']';
                        }
                    }
                }
                ################################ UPDATE POST META ##################################
                if(!empty($poster))
                    update_post_meta($post_id,'dt_poster',sanitize_text_field($poster));
                if(!empty($backdrop))
                    update_post_meta($post_id,'dt_backdrop',sanitize_text_field($backdrop));
                if(!empty($images))
                    update_post_meta($post_id,'imagenes',esc_attr($images));
                if(!empty($youtube))
                    update_post_meta($post_id,'youtube_id',sanitize_text_field($youtube));
                if(!empty($ortitle))
                    update_post_meta($post_id,'original_title',sanitize_text_field($ortitle));
                if(!empty($release))
                    update_post_meta($post_id,'release_date',sanitize_text_field($release));
                if(!empty($average))
                    update_post_meta($post_id,'vote_average',sanitize_text_field($average));
                if(!empty($votecount))
                    update_post_meta($post_id,'vote_count',sanitize_text_field($votecount));
                if(!empty($tagline))
                    update_post_meta($post_id,'tagline',sanitize_text_field($tagline));
                if(!empty($runtime))
                    update_post_meta($post_id,'runtime',sanitize_text_field($runtime));
                if(!empty($meta_cast))
                    update_post_meta($post_id,'dt_cast',sanitize_text_field($meta_cast));
                if(!empty($meta_director))
                    update_post_meta($post_id,'dt_dir',sanitize_text_field($meta_director));
                #####################################################################################

                // Upload Image
                if(!empty($poster) && !has_post_thumbnail($post_id)){
                    self::upload_image('https://image.tmdb.org/t/p/w500'.$poster, $post_id, true, false);
                }

                // The response
                $response = self::successfully( $post_id, __('movie','tmdb'));
            } else {
                $response = array(
                    'success' => false,
                    'message' => self::c_isset($json_tmdb,'status_message')
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => __('Undefined TMDb ID','tmdb')
            );
        }
        // The response
        return $response;
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function tvshows($post_id = ''){
        // Set Response
        $response = array();
        // Post Meta data
        $finder = get_post_meta($post_id, 'ids', true);
        // Verify the Finder ID
        if(!empty($finder)){
            // TMDb Json data
            $json_tmdb = self::remote(TMDB_API_URL.'/3/tv/'.$finder, self::arguments());
            // verificate
            if(!self::c_isset($json_tmdb,'status_code')){
                // Get videos
                $json_tmdb_videos = self::remote(TMDB_API_URL.'/3/tv/'.$finder.'/videos', self::arguments());
                // Set TMDb Metada
                $orname     = self::c_isset($json_tmdb,'original_name');
                $firstdate  = self::c_isset($json_tmdb,'first_air_date');
                $lastdate   = self::c_isset($json_tmdb,'last_air_date');
                $epiruntime = self::c_isset($json_tmdb,'episode_run_time');
                $poster     = self::c_isset($json_tmdb,'poster_path');
                $backdrop   = self::c_isset($json_tmdb,'backdrop_path');
                $average    = self::c_isset($json_tmdb,'vote_average');
                $votecount  = self::c_isset($json_tmdb,'vote_count');
                $seasons    = self::c_isset($json_tmdb,'number_of_seasons');
                $episodes   = self::c_isset($json_tmdb,'number_of_episodes');
                $creators   = self::c_isset($json_tmdb,'created_by');
                $trailers   = self::c_isset($json_tmdb_videos,'results');
                $backdrops  = isset($json_tmdb['images']['backdrops']) ? $json_tmdb['images']['backdrops'] : false;
                // Set Images
                $images = self::images($backdrops);
                // Set Video Traiter
                $youtube = '';
                if($trailers){
                    foreach($trailers as $trailer){
                        $youtube .= '['.self::c_isset($trailer,'key').']';
                        break;
                    }
                }
                // Set Runtime
                $runtime = '';
                if($epiruntime){
                    foreach($epiruntime as $time){
                        $runtime .= $time;
                        break;
                    }
                }
                // Compose Shortcode creators
                $meta_creator = '';
                if($creators){
                    foreach($creators as $creator){
                        // Pre Data
                        $name = self::c_isset($creator,'name');
                        $ppat = self::c_isset($creator,'profile_path');
                        $path = ($ppat == NULL) ? 'null' : $ppat;
                        // Set Data
                        $meta_creator .= '['.$path.';'.$name.']';
                    }
                }
                // TMDb Api Credits
                $json_credits = self::remote(TMDB_API_URL.'/3/tv/'.$finder.'/credits', self::arguments());
                // Set Cast
                $tmdb_cast = self::c_isset($json_credits,'cast');
                // Shortcode composer cast
                $meta_cast = '';
                if($tmdb_cast){
                    $cast_count = 0;
                    foreach($tmdb_cast as $cast) if($cast_count < 10){
                        // Pre Data
                        $name = self::c_isset($cast,'name');
                        $chrt = self::c_isset($cast,'character');
                        $ppat = self::c_isset($cast,'profile_path');
                        $path = ($ppat == NULL) ? 'null' : $ppat;
                        // Set Data
                        $meta_cast .= '['.$path.';'.$name.','.$chrt.']';
                        // Counter
                        $cast_count++;
                    }
                }

                ################################ UPDATE POST META ##################################
                if(!empty($images))
                    update_post_meta($post_id,'imagenes',esc_attr($images));
                if(!empty($youtube))
                    update_post_meta($post_id,'youtube_id',sanitize_text_field($youtube));
                if(!empty($runtime))
                    update_post_meta($post_id,'episode_run_time',sanitize_text_field($runtime));
                if(!empty($poster))
                    update_post_meta($post_id,'dt_poster',sanitize_text_field($poster));
                if(!empty($backdrop))
                    update_post_meta($post_id,'dt_backdrop',sanitize_text_field($backdrop));
                if(!empty($firstdate))
                    update_post_meta($post_id,'first_air_date',sanitize_text_field($firstdate));
                if(!empty($lastdate))
                    update_post_meta($post_id,'last_air_date',sanitize_text_field($lastdate));
                if(!empty($episodes))
                    update_post_meta($post_id,'number_of_episodes',sanitize_text_field($episodes));
                if(!empty($seasons))
                    update_post_meta($post_id,'number_of_seasons',sanitize_text_field($seasons));
                if(!empty($orname))
                    update_post_meta($post_id,'original_name',sanitize_text_field($orname));
                if(!empty($average))
                    update_post_meta($post_id,'imdbRating',sanitize_text_field($average));
                if(!empty($votecount))
                    update_post_meta($post_id,'imdbVotes',sanitize_text_field($votecount));
                if(!empty($meta_cast))
                    update_post_meta($post_id,'dt_cast',sanitize_text_field($meta_cast));
                if(!empty($meta_creator))
                    update_post_meta($post_id,'dt_creator',sanitize_text_field($meta_creator));
                #####################################################################################

                // Upload Image
                if(!empty($poster) && !has_post_thumbnail($post_id)){
                    self::upload_image('https://image.tmdb.org/t/p/w500'.$poster, $post_id, true, false);
                }

                // The response
                $response = self::successfully( $post_id, __('show','tmdb') );
            } else {
                $response = array(
                    'success' => false,
                    'message' => self::c_isset($json_tmdb,'status_message')
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => __('Undefined TMDb ID','tmdb')
            );
        }
        // The response
        return $response;
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function seasons($post_id = ''){
        // Set Response
        $response = array();
        // Post Meta data
        $finder = get_post_meta($post_id,'ids',true);
        $season = get_post_meta($post_id,'temporada',true);
        // Verifications
        if(!empty($finder) && !empty($season)){
            // TMDb Json data
            $json_tmdb = self::remote(TMDB_API_URL.'/3/tv/'.$finder.'/season/'.$season, self::arguments());
            // verificate
            if(!self::c_isset($json_tmdb,'status_code')){
                // get Data
                $poster  = self::c_isset($json_tmdb,'poster_path');
                $airdate = self::c_isset($json_tmdb,'air_date');

                ################################ UPDATE POST META ##################################
                if(!empty($poster))
                    update_post_meta($post_id, 'dt_poster',sanitize_text_field($poster));
                if(!empty($airdate))
                    update_post_meta($post_id, 'air_date',sanitize_text_field($airdate));
                #####################################################################################

                // Upload Image
                if(!empty($poster) && !has_post_thumbnail($post_id)){
                    self::upload_image('https://image.tmdb.org/t/p/w500'.$poster, $post_id, true, false);
                }

                // The response
                $response = self::successfully( $post_id, __('season','tmdb') );
            }else{
                $response = array(
                    'success' => false,
                    'message' => self::c_isset($json_tmdb,'status_message')
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => __('Undefined data','tmdb')
            );
        }
        // The response
        return $response;
    }

    /**
     * @version 1.0
     * @since 1.0
     */
    private static function episodes($post_id = ''){
        // Set Response
        $response = array();
        // Post Meta data
        $finder  = get_post_meta($post_id,'ids',true);
        $season  = get_post_meta($post_id,'temporada',true);
        $episode = get_post_meta($post_id,'episodio',true);
        // Verifications
        if(!empty($finder) && !empty($season) && !empty($episode)){
            // TMDb Json data
            $json_tmdb = self::remote(TMDB_API_URL.'/3/tv/'.$finder.'/season/'.$season.'/episode/'.$episode, self::arguments());
            // verificate
            if(!self::c_isset($json_tmdb,'status_code')){
                $airdate   = self::c_isset($json_tmdb,'air_date');
                $backdrop  = self::c_isset($json_tmdb,'still_path');
                $backdrops = isset($json_tmdb['images']['stills']) ? $json_tmdb['images']['stills'] : false;
                // Compose Images
                $images = '';
                if($backdrops){
                    $image_count = 0;
                    foreach($backdrops as $image) if($image_count < 10){
                        if($image_count == 9){
                            $images.= self::c_isset($image,'file_path');
                        }else{
                            $images.= self::c_isset($image,'file_path')."\n";
                        }
                        $image_count++;
                    }
                }

                ################################ UPDATE POST META ##################################
                if(!empty($backdrop))
                    update_post_meta($post_id,'dt_backdrop',sanitize_text_field($backdrop));
                if(!empty($airdate))
                    update_post_meta($post_id,'air_date',sanitize_text_field($airdate));
                if(!empty($images))
                    update_post_meta($post_id,'imagenes',esc_attr($images));
                #####################################################################################

                // Upload Image
                if(!empty($backdrop) && !has_post_thumbnail($post_id)){
                    self::upload_image('https://image.tmdb.org/t/p/w500'.$backdrop, $post_id, true, false);
                }

                // The response
                $response = self::successfully( $post_id, __('episode','tmdb') );
            }else{
                $response = array(
                    'success' => false,
                    'message' => self::c_isset($json_tmdb,'status_message')
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => __('Undefined data','tmdb')
            );
        }
        // The response
        return $response;
    }
}

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

class East_Widget_FeaturedAnime extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'featuredanime_widget', 'description' => __d('Display Featured Anime') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'tpw_featuredanime');
		parent::__construct('tpw_featuredanime', __d('EasTheme - Featured Anime'), $widget_ops, $control_ops );

	}


	public function widget($args, $instance) {
		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . '<div class="nav_items_module"><a class="btn prevf"><i class="fa fa-caret-left"></i></a><a class="btn nextf"><i class="fa fa-caret-right"></i></a></div>'. $args['after_title'];
		}
		$stripped = str_replace(' ', '', $instance['title']);
		$slider = strtolower($stripped);
		?>
		<div id="<?php echo $slider; ?>" class="load_slider flashit" style="display: block;">Loading..</div>

		<div class="relat widget-post slidfer <?php echo $slider; ?>">

			<?php
			$status = '';
			$genre = '';
			$season = '';
			$orderby = 'rand';
			$type = '';

			if ($instance['type'] != 'all') {
				$type = array('key' => 'east_type', 'value' => $instance['type'], 'compare' => '=');
			} else {
				$type = '';
			}

			if ($instance['status'] == 'ongoing') {
				$status = array('key' => 'east_status', 'value' => 'Currently Airing', 'compare' => '=');
			} elseif ($instance['status'] == 'completed') {
				$status = array('key' => 'east_status', 'value' => 'Finished Airing', 'compare' => '=');
			} elseif ($instance['status'] == 'all') {
				$status = '';
			}

			if ($instance['genre'] != 'all') {
				$genre = array('taxonomy' => 'genre', 'field' => 'slug', 'terms' => $instance['genre'], 'operator' => 'AND');
			}

			if ($instance['season'] != 'all') {
				$season = array('taxonomy' => 'season', 'field' => 'slug', 'terms' => $instance['season'], 'operator' => 'AND');
			}

			$myposts = array(
				'showposts' => $instance['count'],
				'post_type' => 'anime',
				'orderby' => $instance['orderby'],
				'meta_query' => array('relation' => 'AND', 0 => $status, 1 => $type),
				'tax_query' => array('relation' => 'AND', 0 => $genre, 1 => $season),
			);
			$wp_query = new WP_Query($myposts);
			while ($wp_query->have_posts()):
				$wp_query->the_post();?>
				<div class="animepost">
					<div class="animposx">
						<a rel="<?php the_ID();?>" href="<?php the_permalink();?>" title="<?php the_title();?>" alt="<?php the_title();?>">
							<div class="content-thumb">
								<div class="ply">
						<i class="fa fa-play"></i>
									</div>
								   <?php echo the_thumbnail(get_the_ID(), '150','210' ); ?>
									 <div class="type <?php echo meta(get_the_ID(), 'east_type'); ?>"><?php echo meta(get_the_ID(), 'east_type'); ?></div>
							 		 <div class="score"><i class="fa fa-star"></i> <?php echo meta(get_the_ID(), 'east_score'); ?></div>
								</div>
									<div class="data">
								<div class="title"> <?php the_title();?></div>
								<div class="type"><?php echo status_anime(get_the_ID()); ?></div>
									</div>
							</a>
						</div>
					</div>
					<?php endwhile; ?>
				</div>

				<script type="text/javascript">
				$(document).ready(function()
				{

				$('.<?php echo $slider; ?>').owlCarousel({
				    loop:true,
				    dots: false,
				    autoplay:false,
				    pagination: false,
				    responsive:{
				      0:{
				        items:2,
				        nav:false,
				      },
				      600:{
				        items:4,
				        nav:false,
				      },
				      800:{
				        items:4,
				        nav:false,
				      },
				      1000:{
				        items:5,
				        nav:false,
				      }
				    }

				});
				var owl = $('.<?php echo $slider; ?>');
				owl.owlCarousel();
				// Go to the next item
				$('.nextf').click(function() {
				    owl.trigger('next.owl.carousel');
				})
				// Go to the previous item
				$('.prevf').click(function() {
				    // With optional speed parameter
				    // Parameters has to be in square bracket '[]'
				    owl.trigger('prev.owl.carousel', [300]);
				});
				});

				$.each(["#<?php echo $slider; ?>"], function(e, s) {
		        1 <= $(s).length && ($("#content").ready(function() {
		            $(s).css("display", "none")
		        }), $(".content").load(function() {
		            $(s).css("display", "none")
		        }))
		    });

				</script>

				<?php
				echo $args['after_widget'];
			}


				public function update($new_instance, $old_instance) {
					$instance = array();
					$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
					$instance['count'] = (!empty($new_instance['count'])) ? sanitize_text_field($new_instance['count']) : '';
					$instance['orderby'] = (!empty($new_instance['orderby'])) ? sanitize_text_field($new_instance['orderby']) : '';
					$instance['status'] = (!empty($new_instance['status'])) ? sanitize_text_field($new_instance['status']) : '';
					$instance['genre'] = (!empty($new_instance['genre'])) ? sanitize_text_field($new_instance['genre']) : '';
					$instance['season'] = (!empty($new_instance['season'])) ? sanitize_text_field($new_instance['season']) : '';
					$instance['type'] = (!empty($new_instance['type'])) ? sanitize_text_field($new_instance['type']) : '';

					return $instance;
				}

	public function form($instance) {
		$defaults = array('title' => 'Featured Anime', 'count' => '10',  'orderby' => 'rand', 'status' => 'all', 'type' => 'all' , 'genre' => 'all', 'season' => 'all');
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
	   <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'text_domain');?></label>
	   <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo $instance['title']; ?>">
		 	</p>
			<p>
	   <label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_attr_e('Count:', 'text_domain');?></label>
	   <input class="widefat" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number" value="<?php echo $instance['count']; ?>">
		 	</p>
			<p>
	   <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby:');?></label>
	   <select name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>" class="widefat">
	      <option value="date"<?php selected($instance['orderby'], 'date');?>><?php _e('Date');?></option>
	      <option value="rand"<?php selected($instance['orderby'], 'rand');?>><?php _e('Rand');?></option>
	   </select>
		 	</p>
			<p>
	   <label for="<?php echo $this->get_field_id('Status'); ?>"><?php _e('Status:');?></label>
	   <select name="<?php echo $this->get_field_name('status'); ?>" id="<?php echo $this->get_field_id('status'); ?>" class="widefat">
	      <option value="all"<?php selected($instance['status'], 'all');?>><?php _e('All');?></option>
	      <option value="ongoing"<?php selected($instance['status'], 'ongoing');?>><?php _e('Currently Airing');?></option>
	      <option value="completed"<?php selected($instance['status'], 'completed');?>><?php _e('Finished Airing');?></option>
	   </select>
		 	</p>
			<p>
	   <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type:');?></label>
	   <select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" class="widefat">
	      <option value="all"<?php selected($instance['type'], 'all');?>><?php _e('All');?></option>
	      <option value="tv"<?php selected($instance['type'], 'tv');?>><?php _e('TV');?></option>
	      <option value="special"<?php selected($instance['type'], 'ova');?>><?php _e('Special');?></option>
	      <option value="movie"<?php selected($instance['type'], 'movie');?>><?php _e('Movie');?></option>
	      <option value="ona"<?php selected($instance['type'], 'ona');?>><?php _e('ONA');?></option>
	      <option value="la"<?php selected($instance['type'], 'LA');?>><?php _e('LA');?></option>
	   </select>
		 	</p>
			<p>
	   <label for="<?php echo $this->get_field_id('genre'); ?>"><?php _e('Genre:');?></label>
	   <select name="<?php echo $this->get_field_name('genre'); ?>" id="<?php echo $this->get_field_id('genre'); ?>" class="widefat">
	      <option value="all"<?php selected($instance['genre'], '');?>><?php _e('All');?></option>
	      <?php
	         $taxonomy = 'genre';
	         $tax_terms = get_terms($taxonomy);
	         foreach ($tax_terms as $tax_term) {
	         	echo '<option value="' . $tax_term->name . '"' . selected($instance['genre'], $tax_term->name) . '>' . $tax_term->name . '</option>';
	         }?>
	   </select>
		 	</p>
			<p>
	   <label for="<?php echo $this->get_field_id('season'); ?>"><?php _e('Season:');?></label>
	   <select name="<?php echo $this->get_field_name('season'); ?>" id="<?php echo $this->get_field_id('season'); ?>" class="widefat">
	      <option value="all"<?php selected($instance['season'], '');?>><?php _e('All');?></option>
	      <?php
	         $taxonomy = 'season';
	         $tax_terms = get_terms($taxonomy);
	         foreach ($tax_terms as $tax_term) {
	         	echo '<option value="' . $tax_term->name . '"' . selected($instance['season'], $tax_term->name) . '>' . $tax_term->name . '</option>';
	         }?>
	   </select>
		 	</p>
		<?php
	}


}

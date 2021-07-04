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

class East_Widget_Filter extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'filter_widget', 'description' => __d('Display Filter') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'sdw_filter');
		parent::__construct('sdw_filter', __d('EasTheme - Filter Search'), $widget_ops, $control_ops );

	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		?>
    <div class="widgetfilter">
       <form action="<?php echo get_bloginfo('url').'/'.$instance['link']; ?>" class="filters" method="GET">
          <div class="filter dropdown">
             <button type="button" class="dropdown-toggle" data-toggle="dropdown"> Genre <span id="filtercount">All</span> <i class="dashicons dashicons-arrow-down-alt2"></i> </button>
             <ul class="dropdown-menu c4">
               <?php EastPlay::filter_form_tax('genre','genre'); ?>
             </ul>
          </div>
          <div class="filter dropdown">
             <button type="button" class="dropdown-toggle" data-toggle="dropdown"> Season <span id="filtercount">All</span> <i class="dashicons dashicons-arrow-down-alt2"></i> </button>
             <ul class="dropdown-menu c4">
              <?php EastPlay::filter_form_tax('season','season'); ?>
             </ul>
          </div>
					<div class="filter dropdown">
						 <button type="button" class="dropdown-toggle" data-toggle="dropdown"> Studio <span id="filtercount">All</span> <i class="dashicons dashicons-arrow-down-alt2"></i> </button>
						 <ul class="dropdown-menu c4">
							<?php EastPlay::filter_form_tax('studio','studio'); ?>
						 </ul>
					</div>
          <div class="filter dropdown">
             <button type="button" class="dropdown-toggle" data-toggle="dropdown"> Status <span id="filtercount">All</span> <i class="dashicons dashicons-arrow-down-alt2"></i> </button>
             <ul class="dropdown-menu c1">
							 <?php
									$array_status = array(
										'Currently Airing' => 'Currently Airing',
										'Finished Airing' => 'Finished Airing'
									);
									EastPlay::filter_form_radio($array_status,'status',0); ?>
             </ul>
          </div>
          <div class="filter dropdown">
             <button type="button" class="dropdown-toggle" data-toggle="dropdown"> Type <span id="filtercount">All</span> <i class="dashicons dashicons-arrow-down-alt2"></i> </button>
             <ul class="dropdown-menu c1">
							 <?php
									$array_type = array(
										'TV' => 'TV',
     								'OVA' => 'OVA',
     								'ONA' => 'ONA',
     								'Special' => 'Special',
     								'Movie' => 'Movie'
									);
									EastPlay::filter_form_radio($array_type,'type',0); ?>
             </ul>
          </div>
          <div class="filter dropdown">
             <button type="button" class="dropdown-toggle" data-toggle="dropdown"> Order by <span id="filtercount">Default</span> <i class="dashicons dashicons-arrow-down-alt2"></i> </button>
             <ul class="dropdown-menu c1">
							 <?php
									$array_order = array(
										'favorite' => 'Most Favorite',
										'update' => 'Latest Update',
										'latest' => 'Latest Added',
										'popular' => 'Popular',
										'rating' => 'Rating'
									);
									EastPlay::filter_form_radio($array_order,'order',1); ?>
             </ul>
          </div>
					<div class="filter searchfilter">
          <input type="text" class="inputx" name="title" placeholder="<?php _d('Search...'); ?>"autocomplete="off">
          </div>
          <div class="filter submit"> <button type="submit" class="btn btn-custom-search"><i class="dashicons dashicons-filter"></i> Search</button></div>
       </form>
    </div>
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? sanitize_text_field( $new_instance['link'] ) : '';

		return $instance;
	}

		public function form( $instance ) {
			$defaults = array('title' => 'Filter Search', 'link' => '');
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>
			   <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
			   <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
				 	</p>
				 <p>
			   <label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_attr_e( 'Filter Action:', 'text_domain' ); ?></label>
			   <select name="<?php echo $this->get_field_name( 'link' ); ?>" id="<?php echo $this->get_field_id( 'link' ); ?>" class="widefat">
			      <option value=""<?php selected( $instance['link'], '' ); ?>><?php _e( 'Disable' ); ?></option>
			      <?php
			         $lastposts = get_posts( array(
			              'post_type' => 'page',
			                    'posts_per_page' => '100',
			         ) );

			         if ( $lastposts ) {
			            foreach ( $lastposts as $post ) :
			                setup_postdata( $post );
			                $id = $post->ID;
			                ?>
			      <option value="<?php echo get_relative_permalink(get_the_permalink($id)); ?>" <?php selected( $instance['link'], get_relative_permalink(get_the_permalink($id))) ?>><?php echo get_the_title($id); ?></option>
			      <?php
			         endforeach;
			         wp_reset_postdata();
			         } ?>
			   </select>
				 	</p>

			<?php
		}

}

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

class East_Widget_LatestEpisode extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'latestepisode_widget', 'description' => __d('Display Latest Episode') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'tpw_latestepisode');
		parent::__construct('tpw_latestepisode', __d('EasTheme - Latest Episode'), $widget_ops, $control_ops );

	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		$viewall = '';
		if ( ! empty( $instance['link'] ) ) { $viewall = '<a class="linkwidget" href="'.get_bloginfo('url').'/'.$instance['link'].'">'.__d('View All').'</a>'; }
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $viewall . $args['after_title'];
		}

	  get_template_part('template/content/latest');

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? sanitize_text_field( $new_instance['link'] ) : '';

		return $instance;
	}

		public function form( $instance ) {
			$defaults = array('title' => 'Latest Episode', 'link' => '', 'orderby'=>'date');
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>
			   <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
			   <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
				 	</p>

				 <p>
			   <label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_attr_e( 'View All:', 'text_domain' ); ?></label>
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

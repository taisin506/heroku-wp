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

class East_Widget_RecentBlog extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'recentblog_widget', 'description' => __d('Display Recent Blog') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'sdw_recentblog');
		parent::__construct('sdw_recentblog', __d('EasTheme - Recent Blog'), $widget_ops, $control_ops );

	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) .  $args['after_title'];
		}
		?>
		<div class='widget-post'>
		<div class="widgetseries recntblog">
		   <ul>
		      <?php
		         $myposts = array(
		         	'showposts' => $instance['count'],
		         	'post_type' => 'blog',
		         );
		         $wp_query = new WP_Query($myposts);

		      while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
		      <li>
		         <div class="imgseries"><a class="series" href="<?php the_permalink(); ?>" rel="<?php the_ID(); ?>"><?php echo the_thumbnail(get_the_ID(), '120','88' ); ?><div class="background_hover_image"></div></a></div>
		         <div class="lftinfo">
		            <h2><a class="series" href="<?php the_permalink(); ?>" rel="<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
		            <span><i><?php echo get_the_date('F j, Y'); ?></i></span>
		      </li>
		      <?php endwhile;
		       wp_reset_query(); ?>
		      <div class='clear'>
		      </div>
		   </ul>
		   </div>
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? sanitize_text_field( $new_instance['count'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? sanitize_text_field( $new_instance['orderby'] ) : '';

		return $instance;
	}

		public function form( $instance ) {
			$defaults = array('title' => 'Recent Blog', 'count' => '5',  'orderby' => 'rand');
			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
			   <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
			   <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
			 </p>
				 		<p>
			   <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_attr_e( 'Count:', 'text_domain' ); ?></label>
			   <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo $instance['count']; ?>">
			 </p>
			 		<p>
			   <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Orderby:' ); ?></label>
			   <select name="<?php echo $this->get_field_name( 'orderby' ); ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat">
			      <option value="date"<?php if ( $instance['orderby'] == 'date' ) echo 'selected="selected"'; ?>>Date</option>
			      <option value="rand"<?php if ( $instance['orderby'] == 'rand' ) echo 'selected="selected"'; ?>>Rand</option>
			   </select>
			</p>
			<?php
		}


}

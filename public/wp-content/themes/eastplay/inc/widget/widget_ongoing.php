<?php
/*
* -------------------------------------------------------------------------------------
* @author: EasTheme Team
* @author URI: https://eastheme.com
* @copyright: (c) 2020 EasTheme. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 1.0.0
*
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class East_Widget_Ongoing extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'ongoinganime_widget', 'description' => __d('Display Ongoing Anime') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'sdw_ongoinganime');
		parent::__construct('sdw_ongoinganime', __d('EasTheme - Ongoing Anime'), $widget_ops, $control_ops );

	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		$viewall = '';
		if ( ! empty( $instance['link'] ) ) { $viewall = '<a class="linkwidget" href="'.get_bloginfo('url').'/'.$instance['link'].'">'.__d('View All').'</a>'; }
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $viewall . $args['after_title'];
		}
		$scroll = $instance[ 'scroll' ] ? 'scrolling' : 'noscroll';
		?>
<div class="widget-post">
   <ul class="widgetongoing <?php echo $scroll; ?>">
      <?php
         $orderby = $instance['orderby'];

         $myposts = array(
         	'showposts' => $instance['count'],
         	'post_type' => 'anime',
         	'meta_key' => 'east_status',
         	'meta_value' => 'Currently Airing',
         	'orderby' => $orderby,
         );
         $wp_query = new WP_Query($myposts);
         while ($wp_query->have_posts()) : $wp_query->the_post();
         $lastid = EastPlay::latestepisode(get_the_ID());
				 ?>
      <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><div class="animeprofile"><?php echo the_thumbnail(get_the_ID()); ?></div><span class="titleseries"><?php the_title(); ?></span> <span class="eps">Ep. <?php echo meta($lastid,'east_episode'); ?></span> </a></li>
      <?php endwhile;
         wp_reset_query(); ?>
   </ul>
</div>
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? sanitize_text_field( $new_instance['count'] ) : '';

		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? sanitize_text_field( $new_instance['orderby'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? sanitize_text_field( $new_instance['link'] ) : '';
		$instance['scroll'] = strip_tags( $new_instance['scroll'] );

		return $instance;
	}

		public function form( $instance ) {
			$defaults = array('title' => '', 'count' => '10',  'link' => '','orderby'=>'date','scroll' => 'scrolling');
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

				 <p>
				 		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance[ 'scroll' ], 'on'); ?> id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>" />
			<label for="<?php echo $this->get_field_id('scroll'); ?>"> <?php _d('Enable scrolling'); ?></label>
			</p>
			   <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Orderby:' ); ?></label>
			   <select name="<?php echo $this->get_field_name( 'orderby' ); ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat">
			      <option value="date"<?php if (  'date' == $instance['orderby']) echo 'selected="selected"'; ?>>Date</option>
			      <option value="rand"<?php if (  'rand' == $instance['orderby']) echo 'selected="selected"'; ?>>Rand</option>
			   </select>
			</p>
			<?php
		}

}

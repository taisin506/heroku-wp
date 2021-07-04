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

class East_Widget_GetPostAnime extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'getpostanime_widget', 'description' => __d('Display Anime With Slider') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'sdw_getpostanime');
		parent::__construct('sdw_getpostanime', __d('EasTheme - Get Post Anime'), $widget_ops, $control_ops );

	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		$viewall = '';
		if ( ! empty( $instance['link'] ) ) { $viewall = '<a class="linkwidget" href="'.get_bloginfo('url').'/'.$instance['link'].'">'.__d('View All').'</a>'; }
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $viewall . $args['after_title'];
		}
		?>
		<div class="widget-post">
		   <div class="widgetseries">
		      <ul>
		         <?php

		            $types = $instance['type'];

		            if ($types != 'all'){
		            	$type = array('key' => 'east_type', 'value' => $types, 'compare' => '=');
		            }else{
									$type = '';
								}
		            $orderby = $instance['orderby'];

		            $myposts = array(
		            	'showposts' => $instance['count'],
		            	'post_type' => 'anime',
		            	'meta_query'          => array('relation' => 'AND', 0 => $type),
		            	'orderby' => $orderby,
		            );
		            $wp_query = new WP_Query($myposts);
		         while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
		         <li>
		            <div class="imgseries"><a class="series" href="<?php the_permalink(); ?>" rel="<?php the_ID(); ?>"><?php echo the_thumbnail(get_the_ID(), '61','85' ); ?><div class="background_hover_image"></div></a></div>
		            <div class="lftinfo">
		               <h2><a class="series" href="<?php the_permalink(); ?>" rel="<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
		               <span><b>Genres</b>: <?php echo get_the_term_list(get_the_ID(), 'genre', '', ', ', ''); ?></span>
		               <span><?php echo meta(get_the_ID(),'east_date'); ?></span>
		            </div>
		         </li>
		         <?php endwhile;
		        wp_reset_query(); ?>
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
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? sanitize_text_field( $new_instance['type'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? sanitize_text_field( $new_instance['orderby'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? sanitize_text_field( $new_instance['link'] ) : '';

		return $instance;
	}

		public function form( $instance ) {
			$defaults = array('title' => '', 'count' => '10',  'link' => '', 'type' => 'all','orderby'=>'date');
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
			   <label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type:' ); ?></label>
			   <select name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>" class="widefat">
			      <option value="all"<?php if ( $instance['type'] == 'all' ) echo 'selected="selected"'; ?>><?php _e( 'All' ); ?></option>
			      <option value="TV"<?php if ( $instance['type'] == 'TV' ) echo 'selected="selected"'; ?>><?php _e( 'TV' ); ?></option>
			      <option value="OVA"<?php if ( $instance['type'] == 'OVA' ) echo 'selected="selected"'; ?>><?php _e( 'OVA' ); ?></option>
			      <option value="Special"<?php if ( $instance['type'] == 'Special' ) echo 'selected="selected"'; ?>><?php _e( 'Special' ); ?></option>
			      <option value="LA"<?php if ( $instance['type'] == 'LA' ) echo 'selected="selected"'; ?>><?php _e( 'LA' ); ?></option>
			      <option value="Movie"<?php if ( $instance['type'] == 'Movie' ) echo 'selected="selected"'; ?>><?php _e( 'Movie' ); ?></option>
			      <option value="ONA"<?php if ( $instance['type'] == 'OVA' ) echo 'selected="selected"'; ?>><?php _e( 'ONA' ); ?></option>
			   </select>
				 	</p>
				 <p>
			   <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Orderby:' ); ?></label>
			   <select name="<?php echo $this->get_field_name( 'orderby' ); ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat">
			      <option value="date"<?php if (  'date' == $instance['orderby']) echo 'selected="selected"'; ?>>Date</option>
			      <option value="rand"<?php if (  'rand' == $instance['orderby']) echo 'selected="selected"'; ?>>Rand</option>
			   </select>
			</p>
			<?php
		}

}

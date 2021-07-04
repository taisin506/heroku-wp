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

class East_Widget_GetBlog extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'getpostblog_widget', 'description' => __d('Display Post Blog') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'tpw_getpostblog');
		parent::__construct('tpw_getpostblog', __d('EasTheme - Get Post Blog'), $widget_ops, $control_ops );

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
      <div class="blog-post">
         <div class="pad-blog">
         <?php
            $myposts = array(
              'showposts' => $instance['count'],
              'post_type' => 'blog',
              'orderby' => $instance['orderby'],
            );
            $wp_query = new WP_Query($myposts);
            while ($wp_query->have_posts()) : $wp_query->the_post();
            ?>
         <div class="box-blog">
            <div class="img">
              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
               <?php echo the_thumbnail(get_the_ID(),'270','166'); ?>
							 <div class="background_hover_image"></div>
             </a>
            </div>
							<div class="data">
            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <div class="exp">
               <p>
                  <?php echo excerpt(10); ?>
               </p>
            </div>
                <span class="auth"> <i><?php echo get_the_date(); ?></i></span>
							</div>
         </div>
         <?php endwhile; ?>
       </div>
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
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? sanitize_text_field( $new_instance['link'] ) : '';

		return $instance;
	}

		public function form( $instance ) {
			$defaults = array('title' => 'Blog', 'count' => '10',  'link' => '', 'orderby'=>'date');
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
			   <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Orderby:' ); ?></label>
			   <select name="<?php echo $this->get_field_name( 'orderby' ); ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat">
			      <option value="date"<?php if (  'date' == $instance['orderby']) echo 'selected="selected"'; ?>>Date</option>
			      <option value="rand"<?php if (  'rand' == $instance['orderby']) echo 'selected="selected"'; ?>>Rand</option>
			   </select>
			</p>
			<?php
		}

}

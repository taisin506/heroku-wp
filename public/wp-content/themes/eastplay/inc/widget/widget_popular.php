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

class East_Widget_Popular extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'popular_widget', 'description' => __d('Display Popular Anime') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'sdw_popular');
		parent::__construct('sdw_popular', __d('EasTheme - Popular Anime'), $widget_ops, $control_ops );

	}

	public function widget($args, $instance) {
		$before_wd = $args['before_widget'];
		echo str_replace('widgets','widgets populerps', $before_wd);
		$viewall = '';
		if ( ! empty( $instance['link'] ) ) { $viewall = '<a class="linkwidget" href="'.get_bloginfo('url').'/'.$instance['link'].'">'.__d('View All').'</a>'; }
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $viewall  . $args['after_title'];
		}?>
		<div class="widget-post">
			<div class="widgetseries poplr">
				<ul>
				<?php
 $myposts = array(
		 'showposts' => $instance['count'],
		 'post_type' => 'anime',
		 'meta_key' => 'wpb_post_views_count',
		 'orderby' => 'meta_value_num'
 );
 $wp_query = new WP_Query($myposts);
$count = 1;
 while ($wp_query->have_posts()) : $wp_query->the_post(); if($count == 1) { ?>
	 <li class="onepiece">
	    <div class="limit">
	       <div class="shadow"></div>
	       <div class="bxsh">
	          <div class="ctr"><?php echo $count; ?></div>
						<div class="lftinfo">
							 <h2><a class="series" href="<?php the_permalink(); ?>" rel="<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
							 <span><b>Genres</b>: <?php echo get_the_term_list(get_the_ID(), 'genre', '', ', ', ''); ?></span>
							 <span><?php echo meta(get_the_ID(),'east_date'); ?></span>
						</div>
	       </div>
	      <?php echo get_the_cover(get_the_ID(),'304','170'); ?>
	    </div>
	 </li>
 <?php } else {
	 $status = get_post_meta( get_the_ID(), 'east_status', true );
	 $type = get_post_meta( get_the_ID(), 'east_type', true );
	 $rating = get_post_meta( get_the_ID(), 'east_score', true );
	 ?>
	 <div class="animepost">
	    <div class="animposx">
	       <a rel="<?php the_ID();?>" href="<?php the_permalink();?>" title="<?php the_title();?>" alt="<?php the_title();?>">
	          <div class="content-thumb">
	             <div class="ply">
	                <i class="fa fa-play"></i>
	             </div>
	             <?php echo the_thumbnail(get_the_ID(), '150','210' ); ?>
							   <div class="ctra"><?php echo $count; ?></div>
	          </div>

	       </a>
	    </div>
	 </div>
<?php } $count++; endwhile; ?>
</ul>
</div>
</div>
<?php
echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
		$instance['count'] = (!empty($new_instance['count'])) ? sanitize_text_field($new_instance['count']) : '';
		$instance['link'] = (!empty($new_instance['link'])) ? sanitize_text_field($new_instance['link']) : '';

		return $instance;
	}

	public function form($instance) {
		$defaults = array('title' => 'Popular Anime', 'count' => '10',  'link' => '');
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
		   <label for="<?php echo esc_attr($this->get_field_id('link')); ?>"><?php esc_attr_e('Page:', 'text_domain');?></label>
		   <select name="<?php echo $this->get_field_name('link'); ?>" id="<?php echo $this->get_field_id('link'); ?>" class="widefat">
		      <option value=""<?php selected($instance['link'], '');?>><?php _e('Disable');?></option>
		      <?php
		         $lastposts = get_posts(array(
		         			'post_type' => 'page',
		         			'posts_per_page' => '100',
		         		));

		         		if ($lastposts) {
		         			foreach ($lastposts as $post):
		         				setup_postdata($post);
		         				$id = $post->ID;
		         				?>
		      <option value="<?php echo get_relative_permalink(get_the_permalink($id)); ?>" <?php selected($instance['link'], get_relative_permalink(get_the_permalink($id)))?>><?php echo get_the_title($id); ?></option>
		      <?php
		         endforeach;
		         			wp_reset_postdata();
		         		}?>
		   </select>
		</p>
			<?php
}


}

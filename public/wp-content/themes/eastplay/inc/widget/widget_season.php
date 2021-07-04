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

class East_Widget_Season extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'season_widget', 'description' => __d('Display Season') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'sdw_season');
		parent::__construct('sdw_season', __d('EasTheme - Season'), $widget_ops, $control_ops );

	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$scroll = $instance[ 'scroll' ] ? 'scrolling' : 'noscroll';

		$taxonomy = 'season';
		$tax_terms = get_terms($taxonomy,'number=$total');

		echo '<ul class="season '.$scroll.'">';

		foreach ($tax_terms as $tax_term) {
			echo '<li>' . '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __d( "View all series in season %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name.'<span> ('.$tax_term->count.')</span></a></li>';
		}

		echo  '</ul>';

		echo $args['after_widget'];

	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['scroll'] = strip_tags( $new_instance['scroll'] );

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array('title' => 'Season', 'scroll' => 'scrolling');
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance[ 'scroll' ], 'on'); ?> id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>" />
			<label for="<?php echo $this->get_field_id('scroll'); ?>"> <?php _d('Enable scrolling'); ?></label>
			</p>
		<?php
	}

}

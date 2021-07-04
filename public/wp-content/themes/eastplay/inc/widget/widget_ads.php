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

class East_Widget_Ads extends WP_Widget {

	function __construct() {

			$widget_ops = array('classname' => 'ads_widget', 'description' => __d('Display Ads') );
			$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'tpw_ads');
			parent::__construct('tpw_ads', __d('EasTheme - Ads'), $widget_ops, $control_ops );

	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

	  echo '<div class="ads_area">';
		echo $instance['ads'];
		echo '</div>';

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['ads'] = wp_kses_post( $new_instance['ads'] );

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array('title' => 'Ads 1', 'ads' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
    </p>
				<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ads' ) ); ?>"><?php esc_attr_e( 'Ads:', 'text_domain' ); ?></label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('ads'); ?>" name="<?php echo $this->get_field_name('ads'); ?>"><?php echo $instance['ads']; ?></textarea>
		</p>
		<?php
	}

}

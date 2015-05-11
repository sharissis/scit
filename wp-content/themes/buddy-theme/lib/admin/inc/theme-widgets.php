<?php

/*************************** Custom Content Widget ***************************/

add_action( 'widgets_init', 'custom_content_widgets' );

function custom_content_widgets() {
	register_widget( 'Custom_Content' );
}

class Custom_Content extends WP_Widget {
	function Custom_Content() {
		$widget_ops = array( 'classname' => 'custom-content', 'description' => __('Display custom content such as Google ads, flash and javascript.', 'gp_lang'));
		$control_ops = array('width' => 300);
		$this->WP_Widget( 'custom_content-widget', 'GP Custom Content', $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$content = $instance['content']; ?>
		
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<div class="textwidget">
			<?php echo do_shortcode($content); ?>
		</div>
		
	<?php echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['content'] = ( $new_instance['content'] );
		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 'title' => '');
		$defaults = array( 'content' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'gp_lang'); ?></label>
			<br/><input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Content:', 'gp_lang'); ?></label>
			<textarea style="width: 300px; height: 250px;" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php echo $instance['content']; ?></textarea>
		</p>

		<?php
	}

}

?>
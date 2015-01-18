<?php

/**
 * Icon widgets
 */
class parelevel_widget_icons extends WP_Widget {

	// constructor
	function __construct() {
		$widget_ops = array('description' => __('Icon with title and content.', 'parelevel_widget_icons'));
		$control_ops = array('width' => 400, 'height' => 300);
		parent::WP_Widget(false, $name = __('Icon Widgets', 'parelevel_widget_icons'), $widget_ops, $control_ops );
	}

	// widget form creation
	function form($instance) {

	// Check values
	if( $instance) {
		$icon = esc_attr($instance['icon']);
		$title = esc_attr($instance['title']);
		$textarea = esc_textarea($instance['textarea']);
		} else {
			$icon = '';
			$title = '';
			$textarea = '';
		}
	?>

	<p>
		<label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon:', 'parelevel_widget_icons'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" type="text" value="<?php echo $icon; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'parelevel_widget_icons'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
		<textarea class="widefat" rows="16" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
	</p>
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['icon'] = strip_tags($new_instance['icon']);
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['textarea'] =  $new_instance['textarea'];
		else
			$instance['textarea'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['textarea']) ) );
		return $instance;
	}

	// display widget
	function widget($args, $instance) {
		 extract( $args );
		 // these are the widget options
		 $title = apply_filters('widget_title', $instance['title']);
		 $textarea = apply_filters( 'widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
		 echo $before_widget;

		 if( $icon ) {
		 	echo '<p>'.$icon.'</p>'."\n";
		 }

		 // Check if title is set
		 if ( $title ) {
			echo $before_title . $title . $after_title;
		 }

		 // Check if content
		 if( $textarea ) {
			echo '<div class="textwidget">'."\n";
				echo wpautop($textarea)."\n";
			echo '</div>'."\n";
		 }

		 echo $after_widget;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("parelevel_widget_icons");'));

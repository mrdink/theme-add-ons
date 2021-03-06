<?php

/**
 * Content with link widget
 */
class changethis_widget_link extends WP_Widget {

	// constructor
	function __construct() {
		$widget_ops = array('description' => __('Arbitrary text or HTML with a link', 'changethis_widget_link'));
		$control_ops = array('width' => 400, 'height' => 300);
		parent::WP_Widget(false, $name = __('Content With Link', 'changethis_widget_link'), $widget_ops, $control_ops );
	}

	// widget form creation
	function form($instance) {

	// Check values
	if( $instance) {
		$title = esc_attr($instance['title']);
		$textarea = esc_textarea($instance['textarea']);
		$link = esc_attr($instance['link']);
		$link_text = esc_attr($instance['link_text']);
		} else {
			$title = '';
			$textarea = '';
			$link = '';
			$link_text = '';
		}
	?>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'changethis_widget_link'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
		<textarea class="widefat" rows="16" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', 'changethis_widget_link'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link Text:', 'changethis_widget_link'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo $link_text; ?>" />
	</p>
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['textarea'] =  $new_instance['textarea'];
		else
			$instance['textarea'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['textarea']) ) );
			$instance['link'] = strip_tags($new_instance['link']);
			$instance['link_text'] = strip_tags($new_instance['link_text']);
		return $instance;
	}

	// display widget
	function widget($args, $instance) {
		 extract( $args );
		 // these are the widget options
		 $title = apply_filters('widget_title', $instance['title']);
		 $textarea = apply_filters( 'widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
		 $link = $instance['link'];
		 $link_text = $instance['link_text'];
		 echo $before_widget;

		 // Check if title is set
		 if ( $title ) {
			echo $before_title . $title . $after_title;
		 }

		 // Check if content
		 if( $textarea ) {
			echo '<div class="textwidget">'."\n";
				echo wpautop($textarea)."\n";

				// Check if link is set
				if( $link && $link_text ) {
					echo '<p><a href="'.$link.'" class="widget-link">'.$link_text.'</a></p>'."\n";
				}
			echo '</div>'."\n";
		 }

		 echo $after_widget;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("changethis_widget_link");'));

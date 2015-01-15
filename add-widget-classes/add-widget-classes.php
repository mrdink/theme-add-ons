<?php

/**
 * Add field for custom classes
 */
function changethis_widget_form_extend($widget, $return, $instance){
	if (!isset($instance['classes']))
		$instance['classes'] = null;

		$row = "<p>\n";
			$row .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-classes'>CSS Class <small>(separate with spaces)</small></label>\n";
			$row .= "\t<input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' class='widefat' value='{$instance['classes']}'/>\n";
		$row .= "</p>\n";
	echo $row;
	return array($widget, null, $instance);
}
add_filter('in_widget_form', 'changethis_widget_form_extend', 99, 3);

/**
 * Add new options for classes to widgets
 */
function changethis_widget_update($instance, $new_instance) {
	$instance['classes'] = $new_instance['classes'];
	return $instance;
}
add_filter('widget_update_callback', 'changethis_widget_update', 99, 2);

/**
 * Add classes to output
 */
function changethis_dynamic_sidebar_params($params) {
	global $wp_registered_widgets;
	$widget_id = $params[0]['widget_id'];
	$widget_obj = $wp_registered_widgets[$widget_id];
	$widget_opt = get_option($widget_obj['callback'][0]->option_name);
	$widget_num = $widget_obj['params'][0]['number'];

	if (isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']))
		$params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1);

	return $params;
}
add_filter('dynamic_sidebar_params', 'changethis_dynamic_sidebar_params');

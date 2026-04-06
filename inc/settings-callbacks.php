<?php // Pirumatic - Settings Callbacks

if (!defined('ABSPATH')) exit;

function pirumatic_section_general() {
	
	echo '<p>'. esc_html__('Thank you for using the free version of', 'pirumatic') .' <a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/plugins/pirumatic/">'. esc_html__('Pirumatic', 'pirumatic') .'</a>.</p>';
	
}

function pirumatic_section_prism() {
	
	echo '<p>'. esc_html__('Settings for syntax highlighting via', 'pirumatic') .' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/">'. esc_html__('Prism.js', 'pirumatic') .'</a>.</p>';
	
}

function pirumatic_section_prism_code() {
	
	echo '<p>'. esc_html__('Settings for code escaping when Prism.js is enabled. By default all code contained in code tags is escaped on the frontend. Here you may choose also to enable escaping in the Admin Area. If unsure, use the default settings.', 'pirumatic') .'</p>';
	
}

function pirumatic_section_highlight() {
	
	echo '<p>'. esc_html__('Settings for syntax highlighting via', 'pirumatic') .' <a target="_blank" rel="noopener noreferrer" href="https://highlightjs.org/">'. esc_html__('Highlight.js', 'pirumatic') .'</a>.</p>';
	
}

function pirumatic_section_highlight_code() {
	
	echo '<p>'. esc_html__('Settings for code escaping when Highlight.js is enabled. By default all code contained in code tags is escaped on the frontend. Here you may choose also to enable escaping in the Admin Area. If unsure, use the default settings.', 'pirumatic') .'</p>';
	
}

function pirumatic_section_plain() {
	
	echo '<p>'. esc_html__('Settings for code escaping when syntax highlighting is disabled. By default all code contained in code tags is escaped on the frontend. Here you may choose also to enable escaping in the Admin Area. If unsure, use the default settings.', 'pirumatic') .'</p>';
	
}

function pirumatic_section_advanced() {
	
	echo '<p>'. esc_html__('Advanced settings. These settings apply regardless of which library is active (Prism.js, Highlight.js, Plain Flavor, or None).', 'pirumatic') .'</p>';
	
}

function pirumatic_library() {
	
	$library = array(
		
		'prism' => array(
			'value' => 'prism',
			'label' => esc_html__('Prism.js', 'pirumatic'),
		),
		'highlight' => array(
			'value' => 'highlight',
			'label' => esc_html__('Highlight.js', 'pirumatic'),
		),
		'plain' => array(
			'value' => 'plain',
			'label' => esc_html__('Plain Flavor', 'pirumatic'),
		),
		'none' => array(
			'value' => 'none',
			'label' => esc_html__('None (Disable)', 'pirumatic'),
		),
	);
	
	return $library;
	
}

function pirumatic_location() {
	
	$array = array(
		
		'none' => array(
			'value' => 'none',
			'label' => esc_html__('Disable (default)', 'pirumatic'),
		),
		'admin' => array(
			'value' => 'admin',
			'label' => esc_html__('Enable', 'pirumatic'),
		),
	);
	
	return $array;
	
}

function pirumatic_prism_theme() {
	
	$theme = array(
		
		'pirulug' => array(
			'value' => 'pirulug',
			'label' => esc_html__('Pirulug', 'pirulug'),
		),
		'coy' => array(
			'value' => 'coy',
			'label' => esc_html__('Coy', 'pirumatic'),
		),
		'dark' => array(
			'value' => 'dark',
			'label' => esc_html__('Dark', 'pirumatic'),
		),
		'default' => array(
			'value' => 'default',
			'label' => esc_html__('Default', 'pirumatic'),
		),
		'funky' => array(
			'value' => 'funky',
			'label' => esc_html__('Funky', 'pirumatic'),
		),
		'okaidia' => array(
			'value' => 'okaidia',
			'label' => esc_html__('Okaidia', 'pirumatic'),
		),
		'solarized' => array(
			'value' => 'solarized',
			'label' => esc_html__('Solarized', 'pirumatic'),
		),
		'tomorrow-night' => array(
			'value' => 'tomorrow-night',
			'label' => esc_html__('Tomorrow Night', 'pirumatic'),
		),
		'twilight' => array(
			'value' => 'twilight',
			'label' => esc_html__('Twilight', 'pirumatic'),
		),
	);
	
	return $theme;
	
}

function pirumatic_highlight_theme() {
	
	$theme = array();
	
	require_once PIRUMATIC_DIR .'lib/highlight/themes.php';
	
	return $theme;
	
}

function pirumatic_callback_select($args) {
	
	$id      = isset($args['id'])      ? $args['id']      : '';
	$label   = isset($args['label'])   ? $args['label']   : '';
	$section = isset($args['section']) ? $args['section'] : '';
	
	$setting = 'pirumatic_options_'. $section;
	
	$options = pirumatic_get_default_options($section);
	
	$value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
	
	$options_array = array();
	
	if ($id === 'library') {
		
		$options_array = pirumatic_library();
		
	} elseif ($id === 'filter_content' || $id === 'filter_excerpts' || $id === 'filter_comments') {
		
		$options_array = pirumatic_location();
		
	} elseif ($id === 'prism_theme') {
		
		$options_array = pirumatic_prism_theme();
		
	} elseif ($id === 'highlight_theme') {
		
		$options_array = pirumatic_highlight_theme();
		
	}
	
	echo '<select name="'. $setting .'['. $id .']">';
	
	foreach ($options_array as $option) {
		echo '<option '. selected($option['value'], $value, false) .' value="'. $option['value'] .'">'. $option['label'] .'</option>';
	}
	echo '</select> <label class="pirumatic-label inline-block" for="'. $setting .'['. $id .']">'. $label .'</label>';
	
}

function pirumatic_callback_text($args) {
	
	$id      = isset($args['id'])      ? $args['id']      : '';
	$label   = isset($args['label'])   ? $args['label']   : '';
	$section = isset($args['section']) ? $args['section'] : '';
	
	$setting = 'pirumatic_options_'. $section;
	
	$options = pirumatic_get_default_options($section);
	
	$value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
	
	echo '<input name="'. $setting .'['. $id .']" type="text" size="40" value="'. $value .'"> ';
	echo '<label for="'. $setting .'['. $id .']" class="pirumatic-label">'. $label .'</label>';
	
}

function pirumatic_callback_textarea($args) {
	
	$id      = isset($args['id'])      ? $args['id']      : '';
	$label   = isset($args['label'])   ? $args['label']   : '';
	$section = isset($args['section']) ? $args['section'] : '';
	
	$setting = 'pirumatic_options_'. $section;
	
	$options = pirumatic_get_default_options($section);
	
	$allowed_tags = wp_kses_allowed_html('post');
	
	$value = isset($options[$id]) ? wp_kses(stripslashes_deep($options[$id]), $allowed_tags) : '';
	
	echo '<textarea name="'. $setting .'['. $id .']" rows="3" cols="50">'. $value .'</textarea> ';
	echo '<label for="'. $setting .'['. $id .']" class="pirumatic-label" >'. $label .'</label>';
	
}

function pirumatic_callback_checkbox($args) {
	
	$id      = isset($args['id'])      ? $args['id']      : '';
	$label   = isset($args['label'])   ? $args['label']   : '';
	$section = isset($args['section']) ? $args['section'] : '';
	
	$setting = 'pirumatic_options_'. $section;
	
	$options = pirumatic_get_default_options($section);
	
	$checked = isset($options[$id]) ? checked($options[$id], 1, false) : '';
	
	echo '<input name="'. $setting .'['. $id .']" value="1" type="checkbox" '. $checked .'> ';
	echo '<label for="'. $setting .'['. $id .']" class="pirumatic-label inline">'. $label .'</label>';
	
}

function pirumatic_callback_number($args) {
	
	$id      = isset($args['id'])      ? $args['id']      : '';
	$label   = isset($args['label'])   ? $args['label']   : '';
	$section = isset($args['section']) ? $args['section'] : '';
	
	$setting = 'pirumatic_options_'. $section;
	
	$options = pirumatic_get_default_options($section);
	
	$value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
	
	$min = 0;
	$max = 999;
	
	echo '<input name="'. $setting .'['. $id .']" type="number" min="'. $min .'" max="'. $max .'" value="'. $value .'"> ';
	echo '<label for="'. $setting .'['. $id .']" class="pirumatic-label inline-block">'. $label .'</label>';
	
}

function pirumatic_callback_reset($args) {
	
	$nonce = wp_create_nonce('pirumatic_reset_options');
	$url   = admin_url('options-general.php?page=pirumatic');
	$href  = esc_url(add_query_arg(array('reset-options-verify' => $nonce), $url));
	
	echo '<a class="pirumatic-reset-options" href="'. $href .'">'. esc_html__('Restore default plugin options', 'pirumatic') .'</a>';
	
}

function pirumatic_callback_rate($args) {
	
	$href  = 'https://wordpress.org/support/plugin/'. PIRUMATIC_SLUG .'/reviews/?rate=5#new-post';
	$title = esc_attr__('Help keep Pirumatic going strong! A huge THANK YOU for your support!', 'pirumatic');
	$text  = isset($args['label']) ? $args['label'] : esc_html__('Show support with a 5-star rating &raquo;', 'pirumatic');
	
	echo '<a target="_blank" rel="noopener noreferrer" class="pirumatic-rate-plugin" href="'. $href .'" title="'. $title .'">'. $text .'</a>';
	
}

function pirumatic_callback_support($args) {
	
	$href  = 'https://monzillamedia.com/donate.html';
	$title = esc_attr__('Donate via PayPal, credit card, or cryptocurrency', 'pirumatic');
	$text  = isset($args['label']) ? $args['label'] : esc_html__('Show support with a small donation&nbsp;&raquo;', 'pirumatic');
	
	echo '<a target="_blank" rel="noopener noreferrer" class="pirumatic-show-support" href="'. $href .'" title="'. $title .'">'. $text .'</a>';
	
}

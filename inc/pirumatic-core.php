<?php // Pirumatic - Core Functions

if (!defined('ABSPATH')) exit;

function pirumatic_load_library() {
	
	global $pirumatic_options_general;
	
	if (isset($pirumatic_options_general['library']) && $pirumatic_options_general['library'] === 'prism') {
		
		require_once PIRUMATIC_DIR .'lib/prism/prism.php';
		
	} elseif (isset($pirumatic_options_general['library']) && $pirumatic_options_general['library'] === 'highlight') {
		
		require_once PIRUMATIC_DIR .'lib/highlight/highlight.php';
		
	} elseif (isset($pirumatic_options_general['library']) && $pirumatic_options_general['library'] === 'plain') {
		
		require_once PIRUMATIC_DIR .'lib/plain/plain.php';
		
	}
	
}

function pirumatic_get_default_options($section) {
	
	$options = '';
	
	if ($section === 'general') {
		
		global $pirumatic_options_general;
		
		$options = $pirumatic_options_general;
		
	} elseif ($section === 'prism') {
		
		global $pirumatic_options_prism;
		
		$options = $pirumatic_options_prism;
		
	} elseif ($section === 'highlight') {
		
		global $pirumatic_options_highlight;
		
		$options = $pirumatic_options_highlight;
		
	} elseif ($section === 'plain') {
		
		global $pirumatic_options_plain;
		
		$options = $pirumatic_options_plain;
		
	} elseif ($section === 'advanced') {
		
		global $pirumatic_options_advanced;
		
		$options = $pirumatic_options_advanced;
		
	}
	
	return $options;
	
}

function pirumatic_encode($text) {
	
	if (!is_string($text)) return $text;
	
	$output = '';
	$split  = preg_split("/(<code[^>]*>.*<\/code>)/Us", $text, -1, PREG_SPLIT_DELIM_CAPTURE);
	$count  = count($split);
	
	for ($i = 0; $i < $count; $i++) {
		
		$content = $split[$i];
		
		if (preg_match("/^<code([^>]*)>(.*)<\/code>/Us", $content, $code)) {
			
			$atts = str_replace(array("'", "\""), "%%", $code[1]);
			
			$content = '[pirumatic_encoded'. $atts .']'. base64_encode($code[2]) .'[/pirumatic_encoded]';
			
		}
		
		$output .= $content;
		
	}
	
	return $output;
	
}

function pirumatic_decode($text) {
	
	if (!is_string($text)) return $text;
	
	$output = '';
	$split  = preg_split("/(\[pirumatic_encoded.*\].*\[\/pirumatic_encoded\])/Us", $text, -1, PREG_SPLIT_DELIM_CAPTURE);
	$count  = count($split);
	
	for ($i = 0; $i < $count; $i++) {
		
		$content = $split[$i];
		
		if (preg_match("/^\[pirumatic_encoded(.*)\](.*)\[\/pirumatic_encoded\]/Us", $content, $code)) {
			
			$atts = str_replace("%%", "\"", $code[1]);
			
			$content = base64_decode($code[2]);
			
			$content = preg_replace("/\r/", "", $content);
			
			$content = preg_replace("/^\s*?\n/", "\n", $content);
			
			$content = '<code'. $atts .'>'. esc_html($content) .'</code>';
			
		}
		
		$output .= $content;
		
	}
	
	return $output;
	
}

function pirumatic_check_admin($library, $filter) {
	
	$settings = 'pirumatic_options_'. $library;
	
	$setting = 'filter_'. $filter;
	
	$options = pirumatic_get_default_options($library);
	
	$option = isset($options[$setting]) ? $options[$setting] : false;
	
	if ($option === 'admin' || $option === 'both') return true;
	
	return false;
	
}

function pirumatic_add_filters() {
	
	global $pirumatic_options_general;
	
	$library = (isset($pirumatic_options_general['library'])) ? $pirumatic_options_general['library'] : 'none';
	
	// POST CONTENT
	
	add_filter('the_content', 'pirumatic_encode', 1);
	add_filter('the_content', 'pirumatic_decode', 3);
	
	if (function_exists('get_fields')) { // ACF
		
		add_filter('acf/load_value', 'pirumatic_encode', 1);
		add_filter('acf/load_value', 'pirumatic_decode', 3);
		
	}
	
	if (pirumatic_check_admin($library, 'content')) {
		
		add_filter('content_save_pre', 'pirumatic_encode', 33);
		add_filter('content_save_pre', 'pirumatic_decode', 77);
		
	}
	
	// POST EXCERPTS
	
	add_filter('the_excerpt', 'pirumatic_encode', 1);
	add_filter('the_excerpt', 'pirumatic_decode', 99);
	
	if (pirumatic_check_admin($library, 'excerpts')) {
		
		add_filter('excerpt_save_pre', 'pirumatic_encode', 33);
		add_filter('excerpt_save_pre', 'pirumatic_decode', 77);
		
	}
	
	// POST COMMENTS
	
	add_filter('comment_text', 'pirumatic_encode', 1);
	add_filter('comment_text', 'pirumatic_decode', 99);
	
	if (pirumatic_check_admin($library, 'comments')) {
		
		add_filter('comment_save_pre', 'pirumatic_encode', 33);
		add_filter('comment_save_pre', 'pirumatic_decode', 77);
		
	}
	
}

function pirumatic_block_styles() {
	
	global $pirumatic_options_general;
	
	$disable = isset($pirumatic_options_general['disable_block_styles']) ? $pirumatic_options_general['disable_block_styles'] : false;
	
	if ($disable) {
		
		wp_deregister_style('pirumatic-blocks');
		
		wp_register_style('pirumatic-blocks', false);
		
	}
	
}

function pirumatic_code_shortcode($attr, $content = null) {
	
	extract(shortcode_atts(array('class' => '',
		
	), $attr));
	
	$class = $class ? ' class="'. sanitize_html_class($class) .'"' : '';
	
	$encode = pirumatic_encode($content);
	$decode = pirumatic_decode($encode);
	
	return '<code'. $class .'>'. wp_kses_post($decode) .'</code>';
	
}
